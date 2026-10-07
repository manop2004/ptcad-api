<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

use App\Models\TbOrder;
use App\Models\TbSetting;
use App\Models\TbPagesMap;
use App\Models\User;
use App\Models\HistorySendMail;
use App\Models\HistoryOrderStatus;

use App\Mail\orderNotify;
use App\Mail\orderToStaff;

class StripeController extends Controller
{
    public function webhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $webhookSecret = env('STRIPE_WEBHOOK_SECRET');

        if (empty($sigHeader) || empty($webhookSecret)) {
            \Log::warning('Stripe webhook: missing signature header or secret');
            return response('Missing signature', 400);
        }

        // แยก header รูปแบบ "t=169...,v1=abcd...,v1=efgh..." ออกเป็นชิ้นๆ
        $parts = [];
        foreach (explode(',', $sigHeader) as $item) {
            $pair = array_pad(explode('=', $item, 2), 2, null);
            $parts[$pair[0]][] = $pair[1];
        }

        $timestamp = $parts['t'][0] ?? null;
        $signatures = $parts['v1'] ?? [];

        if (empty($timestamp) || empty($signatures)) {
            \Log::warning('Stripe webhook: malformed signature header', ['header' => $sigHeader]);
            return response('Malformed signature', 400);
        }

        // คำนวณลายเซ็นตามสูตรของ Stripe: HMAC-SHA256("{timestamp}.{payload}", webhook_secret)
        $signedPayload = $timestamp . '.' . $payload;
        $expectedSignature = hash_hmac('sha256', $signedPayload, $webhookSecret);

        $verified = false;
        foreach ($signatures as $sig) {
            if (hash_equals($expectedSignature, (string) $sig)) {
                $verified = true;
                break;
            }
        }

        if (!$verified) {
            \Log::warning('Stripe webhook: signature verification failed');
            return response('Invalid signature', 400);
        }

        // กันเหตุการณ์เก่าเกินไปถูกยิงซ้ำ (Stripe แนะนำไม่เกิน 5 นาที)
        if (abs(time() - (int) $timestamp) > 300) {
            \Log::warning('Stripe webhook: timestamp too old');
            return response('Timestamp too old', 400);
        }

        $event = json_decode($payload, true);

        if (($event['type'] ?? null) == 'checkout.session.completed') {

            $session = $event['data']['object'] ?? [];

            // [เพิ่มใหม่] เช็คก่อนว่าเป็น "ต่ออายุ License" หรือไม่ ถ้าใช่ แยกไปอีกเส้นทางทันที
            // ไม่ปนกับ Logic ออเดอร์ปกติด้านล่างเลย กันความเสี่ยงกระทบระบบเดิม
            if (($session['metadata']['type'] ?? null) === 'renew_license') {
                $this->handleRenewLicensePayment($session);
                return response('Webhook handled', 200);
            }

            $orderId = $session['metadata']['orderId'] ?? null;

            if (!empty($orderId)) {

                $order = TbOrder::select('id', 'orderNumber', 'chargeId', 'payment_status')->find($orderId);

                if (!empty($order)) {

                    if ($order->payment_status != 7) {

                        $updateOrder = TbOrder::findOrFail($order->id);
                        $updateOrder->chargeId = $session['payment_intent'] ?? $session['id'] ?? null;
                        $updateOrder->payment_status = 7;
                        $updateOrder->payment_massage = 'ชำระเงินสำเร็จผ่านบัตรเครดิต (WH STRIPE)';
                        $updateOrder->save();

                        $history = new HistoryOrderStatus();
                        $history->orderNumber = $order->orderNumber;
                        $history->order_status = 'WEBHOOK STRIPE';
                        $history->order_message = 'ชำระเงินสำเร็จผ่านบัตรเครดิต (WH STRIPE)';
                        $history->updated_by = 'SYSTEM';
                        $history->updated_at = date('Y-m-d H:i:s');
                        $history->created_by = 'SYSTEM';
                        $history->created_at = date('Y-m-d H:i:s');
                        $history->save();

                        $orderForLicense = TbOrder::with('tb_order_details')->find($order->id);
                        if (!empty($orderForLicense)) {
                            app(\App\Services\PtcadLicenseService::class)->createLicenseForOrder($orderForLicense);
                            app(\App\Services\CivilProMaxLicenseService::class)->createLicenseForOrder($orderForLicense); // [เพิ่มใหม่]
                        }

                        $this->send_mail_order_Touser($order->id);
                        $this->send_mail_order_Tostaff($order->id);
                    }

                } else {
                    \Log::warning('Stripe webhook: order not found', ['orderId' => $orderId]);
                }

            } else {
                \Log::warning('Stripe webhook: metadata orderId missing', ['session_id' => $session['id'] ?? null]);
            }
        }

        return response('Webhook handled', 200);
    }

    /**
     * [เพิ่มใหม่] จัดการ Event "ต่ออายุ License" — แยกจาก order ปกติทั้งหมด
     * ไม่แตะ/ไม่เกี่ยวกับตาราง tb_order เลย
     */
    private function handleRenewLicensePayment(array $session)
    {
        $notifyId = $session['metadata']['renewSoftwareNotifyId'] ?? null;
        $sessionId = $session['id'] ?? null;

        if (empty($notifyId)) {
            \Log::warning('Stripe webhook (renew): metadata renewSoftwareNotifyId missing', ['session_id' => $sessionId]);
            return;
        }

        $notify = \App\Models\TbSoftwareNotify::find($notifyId);
        if (empty($notify)) {
            \Log::warning('Stripe webhook (renew): software_notify not found', ['id' => $notifyId]);
            return;
        }

        // กันยิงซ้ำ (Stripe อาจส่ง Webhook ซ้ำได้) — เช็คว่าเคยประมวลผล session นี้ไปแล้วหรือยัง
        if (!empty($sessionId) && str_contains((string) $notify->note, $sessionId)) {
            \Log::info('Stripe webhook (renew): already processed this session, skip', ['session_id' => $sessionId]);
            return;
        }

        $result = app(\App\Services\PtcadLicenseService::class)
            ->extendLicense($notify->serial_number, (string) $notify->userId);

        if (!empty($result['success'])) {
            $updated = $result['data']['updated'] ?? [];
            $newExpire = !empty($updated['timeexpire'])
                ? date('Y-m-d', strtotime($updated['timeexpire']))
                : $notify->date_exp;

            $notify->date_exp   = $newExpire;
            $notify->note       = trim(($notify->note ?? '') . ' / ต่ออายุสำเร็จผ่าน Stripe (session: ' . $sessionId . ')');
            $notify->updated_by = 'SYSTEM (Stripe Renew Webhook)';
            $notify->updated_at = date('Y-m-d H:i:s');
            $notify->save();

            if (!empty($notify->softwareId)) {
                $software = \App\Models\TbSoftware::find($notify->softwareId);
                if (!empty($software)) {
                    $software->date_exp   = $newExpire;
                    $software->updated_by = 'SYSTEM (Stripe Renew Webhook)';
                    $software->updated_at = date('Y-m-d H:i:s');
                    $software->save();
                }
            }

            \Log::info('Stripe webhook (renew): license extended successfully', [
                'notifyId' => $notify->id, 'serial' => $notify->serial_number, 'newExpire' => $newExpire,
            ]);
        } else {
            \Log::error('Stripe webhook (renew): extend API failed', [
                'notifyId' => $notify->id, 'serial' => $notify->serial_number, 'error' => $result['error'] ?? 'unknown',
            ]);
        }
    }

    private function send_mail_order_Touser($orderId)
    {
        $setting = TbSetting::first();
        $page = TbPagesMap::first();
        $order = TbOrder::with(
            'tb_setting_payment_status', 'tb_order_payments', 'tb_order_details',
            'tb_setting_province', 'tb_setting_amphure', 'tb_setting_district',
            'tb_receipt_province', 'tb_receipt_amphures', 'tb_receipt_district', 'tb_setting_transport'
        )->findOrFail($orderId);
        $user = User::where('user_code', $order->userCode)->first();

        $data = new \stdClass();
        $data->setting_nameWeb = $setting->setting_nameWeb;
        $data->setting_logoWeb = $setting->setting_logoWeb;
        $data->order = $order;
        $data->page = $page;

        try {
            Mail::to($user->email)->later(now()->addMinutes(5), new orderNotify($data));
            $mailStatus = Mail::failures() ? 'ล้มเหลว' : 'สำเร็จ';
        } catch (\Exception $e) {
            $mailStatus = 'ล้มเหลว';
        }

        $history = new HistorySendMail();
        $history->userId = $user->id;
        $history->remark = "อัพเดตสถานะ " . $order->orderNumber;
        $history->status = $mailStatus;
        $history->created_by = 'SYSTEM';
        $history->created_at = date('Y-m-d H:i:s');
        $history->updated_at = date('Y-m-d H:i:s');
        $history->save();
    }

    private function send_mail_order_Tostaff($orderId)
    {
        $setting = TbSetting::first();
        $page = TbPagesMap::first();
        $order = TbOrder::with(
            'tb_setting_payment_status', 'tb_order_payments', 'tb_order_details',
            'tb_setting_province', 'tb_setting_amphure', 'tb_setting_district',
            'tb_receipt_province', 'tb_receipt_amphures', 'tb_receipt_district', 'tb_setting_transport'
        )->findOrFail($orderId);

        $user = User::where('user_code', $order->userCode)->first();
        $ref = User::select('id', 'user_code', 'staffId')->where('user_code', $user->user_code_friend)->first();
        $staff = !empty($ref) ? User::select('id', 'name', 'lastname')->where('id', $ref->staffId)->first() : '';

        $data = new \stdClass();
        $data->setting_nameWeb = $setting->setting_nameWeb;
        $data->setting_logoWeb = $setting->setting_logoWeb;
        $data->order = $order;
        $data->page = $page;
        $data->user = $user;
        $data->staff = $staff;

        if (!empty($setting->setting_email_bcc)) {
            $mail_bcc = explode(",", $setting->setting_email_bcc);

            try {
                Mail::to($mail_bcc)->later(now()->addMinutes(5), new orderToStaff($data));
                $mailStatus = Mail::failures() ? 'ล้มเหลว' : 'สำเร็จ';
            } catch (\Exception $e) {
                $mailStatus = 'ล้มเหลว';
            }

            $history = new HistorySendMail();
            $history->userId = $user->id;
            $history->remark = "อัพเดตสถานะ " . $order->orderNumber;
            $history->status = $mailStatus;
            $history->created_by = 'SYSTEM';
            $history->created_at = date('Y-m-d H:i:s');
            $history->updated_at = date('Y-m-d H:i:s');
            $history->save();
        }
    }
}