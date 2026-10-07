<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\TbOrder;
use App\Models\TbSetting;
use App\Models\TbPagesMap;
use App\Models\User;
use App\Models\HistorySendMail;
use App\Models\HistoryOrderStatus;

use OmiseCharge;
use OmiseAccount;
use OmiseEvent;

use App\Mail\orderNotify;
use App\Mail\orderToStaff;

use App\Models\TbSettingPayment;

class OmiseController extends Controller
{

    private function omisePublicKey(){

        //1 ปิดใช้งาน
        //2 เปิดใช้งาน
        //3 ทดสอบการใช้งาน

        $omise = TbSettingPayment::first();
        if($omise->omise_status == 3){
            $public_key_omise = $omise->omise_public_key_for_test;
        }else{
            $public_key_omise = $omise->omise_public_key_for_live;
        }

        return define('OMISE_PUBLIC_KEY', $public_key_omise);
    }

    private function omiseSecretKey(){

        //1 ปิดใช้งาน
        //2 เปิดใช้งาน
        //3 ทดสอบการใช้งาน

        $omise = TbSettingPayment::first();
        if($omise->omise_status == 3){
            $secret_key_omise = $omise->omise_secret_key_for_test;
        }else{
            $secret_key_omise = $omise->omise_secret_key_for_live;
        }

        return define('OMISE_SECRET_KEY', $secret_key_omise);
    }

    public function omise_webhook(Request $request){

        $this->omisePublicKey();
        $this->omiseSecretKey();

        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        //check
        if($data['data']['object'] == 'charge'){
            //สร้างรายการ
            $chargeId =  $data['data']['id'];
            //check order
            $order =  TbOrder::select('id','chargeId','orderNumber')->where('chargeId',$chargeId)->first();

            if(!empty($order)){

                if($data['key'] == 'charge.create'){
                    $resust                     = TbOrder::select('id','payment_status','payment_massage')->findOrFail($order->id);
                    $resust->payment_status     = 9;
                    if(!empty($data['data']['message'])){
                        $resust->payment_massage    = $data['data']['message'].' (WH OMISE)';
                    }else{
                        $resust->payment_massage    = 'รอตรวจสอบยอดชำระ (WH OMISE)';
                    }
                    $resust->save();

                    $history = new HistoryOrderStatus();
                    $history->orderNumber           = $order->orderNumber;
                    $history->order_status          = 'WEBHOOK OMISE';
                    if(!empty($data['data']['message'])){
                        $history->order_message    = $data['data']['message'].' (WH OMISE)';
                    }else{
                        $history->order_message    = 'รอตรวจสอบยอดชำระ (WH OMISE)';
                    }
                    $history->updated_by            = 'SYSTEM';
                    $history->updated_at            = date('Y-m-d H:i:s');
                    $history->created_by            = 'SYSTEM';
                    $history->created_at            = date('Y-m-d H:i:s');
                    $history->save();

                }else if($data['key'] == 'charge.complete'){
										
					if($data['data']['status'] == 'expired'){
						
						$pm_status     = 4;
						$pm_massage    = 'รายการรอตัดวงเงิน ได้หมดอายุลงเนื่องจากไม่มีการดำเนินการในระยะเวลาที่กำหนด (WH OMISE)';
						
					}else if($data['data']['status'] == 'failed'){
						
						$pm_status     = 4;
						if(!empty($data['data']['failure_message'])){
							$pm_massage = $data['data']['failure_message'].' (WH OMISE)';
						}else{
							$pm_massage    = 'รายการไม่สำเร็จ (WH OMISE)';
						}
						
					}else if($data['data']['status'] == 'successful'){
						
						$pm_status     = 7;
						if(!empty($data['data']['failure_message'])){
							$pm_massage = $data['data']['failure_message'].' (WH OMISE)';
						}else{
							$pm_massage    = 'ชำระเงินสำเร็จ (WH OMISE)';
						}
						
					}else{
						
						// [PTCAD FIX] เดิม default เป็น pm_status = 7 (ชำระเงินสำเร็จ) แม้ไม่รู้จักสถานะที่ Omise ส่งมา
						// อันตรายมาก เพราะแปลว่าสถานะแปลกๆที่ไม่ตรงเงื่อนไขไหนเลย จะถูกมองว่า "จ่ายเงินสำเร็จ" ทันที
						// เปลี่ยนเป็น "รอตรวจสอบ" (9) แทน ให้คนเข้ามาเช็คเอง ไม่ปล่อยผ่านว่าสำเร็จอัตโนมัติ
						$pm_status     = 9;
						if(!empty($data['data']['status'])){
							$pm_massage = 'สถานะที่ไม่รู้จักจาก Omise: '.$data['data']['status'].' กรุณาตรวจสอบยอดชำระด้วยตนเอง (WH OMISE)';
						}else{
							$pm_massage    = 'รอตรวจสอบยอดชำระ (WH OMISE)';
						}
						
					}
                    $resust                     = TbOrder::select('id','payment_status','payment_massage')->findOrFail($order->id);
                    $resust->payment_status     = $pm_status;
					$resust->payment_massage    = $pm_massage;
                    
                    $resust->save();

                    $history = new HistoryOrderStatus();
                    $history->orderNumber           = $order->orderNumber;
                    $history->order_status          = 'WEBHOOK OMISE';
					$history->order_message    		= $pm_massage;
                    $history->updated_by            = 'SYSTEM';
                    $history->updated_at            = date('Y-m-d H:i:s');
                    $history->created_by            = 'SYSTEM';
                    $history->created_at            = date('Y-m-d H:i:s');
                    $history->save();

                    // [PTCAD] สร้าง License อัตโนมัติผ่าน License API เมื่อจ่ายเงินสำเร็จจริง (pm_status = 7 เท่านั้น)
                    if ($pm_status == 7) {
                        $orderForLicense = TbOrder::with('tb_order_details')->find($order->id);
                        if (!empty($orderForLicense)) {
                            app(\App\Services\PtcadLicenseService::class)->createLicenseForOrder($orderForLicense);
                        }
                    }

                    //send mail
                    $this->send_mail_order_Touser($order->id);
                    $this->send_mail_order_Tostaff($order->id);

                }else if($data['key'] == 'charge.expire'){
                    $resust                     = TbOrder::select('id','payment_status','payment_massage')->findOrFail($order->id);
                    $resust->payment_status     = 4;
                    if(!empty($data['data']['message'])){
                        $resust->payment_massage    = $data['data']['message'].' (WH OMISE)';
                    }else{
                        $resust->payment_massage    = 'รายการรอตัดวงเงิน ได้หมดอายุลงเนื่องจากไม่มีการดำเนินการในระยะเวลาที่กำหนด (WH OMISE)';
                    }
                    $resust->save();

                    $history = new HistoryOrderStatus();
                    $history->orderNumber           = $order->orderNumber;
                    $history->order_status          = 'WEBHOOK OMISE';
                    if(!empty($data['data']['message'])){
                        $history->order_message    = $data['data']['message'].' (WH OMISE)';
                    }else{
                        $history->order_message    = 'รายการรอตัดวงเงิน ได้หมดอายุลงเนื่องจากไม่มีการดำเนินการในระยะเวลาที่กำหนด (WH OMISE)';
                    }
                    $history->updated_by            = 'SYSTEM';
                    $history->updated_at            = date('Y-m-d H:i:s');
                    $history->created_by            = 'SYSTEM';
                    $history->created_at            = date('Y-m-d H:i:s');
                    $history->save();

                    //send mail
                    $this->send_mail_order_Touser($order->id);
                    $this->send_mail_order_Tostaff($order->id);

                }else if($data['key'] == 'charge.reverse'){
                    $resust                     = TbOrder::select('id','payment_status','payment_massage')->findOrFail($order->id);
                    $resust->payment_status     = 4;
                    if(!empty($data['data']['message'])){
                        $resust->payment_massage    = $data['data']['message'].' (WH OMISE)';
                    }else{
                        $resust->payment_massage    = 'รายการอนุมัติวงเงินสำเร็จและได้มีการยกเลิกการกันวงเงินในภายหลัง (WH OMISE)';
                    }
                    $resust->save();

                    $history = new HistoryOrderStatus();
                    $history->orderNumber           = $order->orderNumber;
                    $history->order_status          = 'WEBHOOK OMISE';
                    if(!empty($data['data']['message'])){
                        $history->order_message    = $data['data']['message'].' (WH OMISE)';
                    }else{
                        $history->order_message    = 'รายการอนุมัติวงเงินสำเร็จและได้มีการยกเลิกการกันวงเงินในภายหลัง (WH OMISE)';
                    }
                    $history->updated_by            = 'SYSTEM';
                    $history->updated_at            = date('Y-m-d H:i:s');
                    $history->created_by            = 'SYSTEM';
                    $history->created_at            = date('Y-m-d H:i:s');
                    $history->save();

                    //send mail
                    $this->send_mail_order_Touser($order->id);
                    $this->send_mail_order_Tostaff($order->id);

                }else if($data['key'] == 'charge.update'){

                    $resust                     = TbOrder::select('id','payment_status','payment_massage')->findOrFail($order->id);
                    $resust->payment_status     = 9;
                    if(!empty($data['data']['message'])){
                        $resust->payment_massage    = $data['data']['message'].' (WH OMISE)';
                    }else{
                        $resust->payment_massage    = 'รอตรวจสอบยอดชำระ (WH OMISE)';
                    }
                    $resust->save();

                    $history = new HistoryOrderStatus();
                    $history->orderNumber           = $order->orderNumber;
                    $history->order_status          = 'WEBHOOK OMISE';
                    if(!empty($data['data']['message'])){
                        $history->order_message    = $data['data']['message'].' (WH OMISE)';
                    }else{
                        $history->order_message    = 'รอตรวจสอบยอดชำระ (WH OMISE)';
                    }
                    $history->updated_by            = 'SYSTEM';
                    $history->updated_at            = date('Y-m-d H:i:s');
                    $history->created_by            = 'SYSTEM';
                    $history->created_at            = date('Y-m-d H:i:s');
                    $history->save();

                }else if($data['key'] == 'charge.capture'){
                    $resust                     = TbOrder::select('id','payment_status','payment_massage')->findOrFail($order->id);
                    $resust->payment_status     = 9;
                    if(!empty($data['data']['message'])){
                        $resust->payment_massage    = $data['data']['message'].' (WH OMISE)';
                    }else{
                        $resust->payment_massage    = 'รอตรวจสอบยอดชำระ (WH OMISE)';
                    }
                    $resust->save();

                    $history = new HistoryOrderStatus();
                    $history->orderNumber           = $order->orderNumber;
                    $history->order_status          = 'WEBHOOK OMISE';
                    if(!empty($data['data']['message'])){
                        $history->order_message    = $data['data']['message'].' (WH OMISE)';
                    }else{
                        $history->order_message    = 'รอตรวจสอบยอดชำระ (WH OMISE)';
                    }
                    $history->updated_by            = 'SYSTEM';
                    $history->updated_at            = date('Y-m-d H:i:s');
                    $history->created_by            = 'SYSTEM';
                    $history->created_at            = date('Y-m-d H:i:s');
                    $history->save();
                }

            }

        }else if($data['data']['object']== 'refund'){
            //คืนเงิน
            $chargeId =  $data['data']['charge'];

            //check order
            $order =  TbOrder::select('id','chargeId','orderNumber')->where('chargeId',$chargeId)->first();

            if(!empty($order)){

                if($data['key'] == "refund.create"){
                    $refund                     = TbOrder::select('id','payment_status','payment_massage')->findOrFail($order->id);
                    $refund->payment_status     = 8;
                    if(!empty($data['data']['message'])){ 
                        $refund->payment_massage    = $data['data']['message'].' (WH OMISE)';
                    }else{
                        $refund->payment_massage    = 'รายการอนุมัติวงเงินสำเร็จ และได้มีการขอคืนเงินในภายหลัง';
                    }
                    $refund->save();

                    $history = new HistoryOrderStatus();
                    $history->orderNumber           = $order->orderNumber;
                    $history->order_status          = 'WEBHOOK OMISE';
                    if(!empty($data['data']['message'])){
                        $history->order_message    = $data['data']['message'].' (WH OMISE)';
                    }else{
                        $history->order_message    = 'รายการอนุมัติวงเงินสำเร็จ และได้มีการขอคืนเงินในภายหลัง';
                    }
                    $history->updated_by            = 'SYSTEM';
                    $history->updated_at            = date('Y-m-d H:i:s');
                    $history->created_by            = 'SYSTEM';
                    $history->created_at            = date('Y-m-d H:i:s');
                    $history->save();

                    //send mail
                    $this->send_mail_order_Touser($order->id);
                    $this->send_mail_order_Tostaff($order->id);

                }
            }

        }else if($data['data']['object'] == 'dispute'){
            //ปฏิเสธ
            $chargeId =  $data['data']['charge'];

            $order = TbOrder::select('id','chargeId','orderNumber')->where('chargeId',$chargeId)->first();
            if(!empty($order)){

                if(!empty($data['data']['message'])){ 
                    $message = $data['data']['message'].' (WH OMISE)';
                }else{
                    $message = '';
                }

                if($data['key'] == 'dispute.create'){

                    $resust                     = TbOrder::select('id','payment_status','payment_massage')->findOrFail($order->id);
                    $resust->payment_status     = 10;
                    $resust->payment_massage    = $message;
                    $resust->save();

                    $history = new HistoryOrderStatus();
                    $history->orderNumber           = $order->orderNumber;
                    $history->order_status          = 'WEBHOOK OMISE';
                    $history->order_message         = $message;
                    $history->updated_by            = 'SYSTEM';
                    $history->updated_at            = date('Y-m-d H:i:s');
                    $history->created_by            = 'SYSTEM';
                    $history->created_at            = date('Y-m-d H:i:s');
                    $history->save();

                }else if($data['key'] == 'dispute.update'){

                    $resust                     = TbOrder::select('id','payment_status','payment_massage')->findOrFail($order->id);
                    $resust->payment_status     = 10;
                    $resust->payment_massage    = $message;
                    $resust->save();

                    $history = new HistoryOrderStatus();
                    $history->orderNumber           = $order->orderNumber;
                    $history->order_status          = 'WEBHOOK OMISE';
                    $history->order_message         = $message;
                    $history->updated_by            = 'SYSTEM';
                    $history->updated_at            = date('Y-m-d H:i:s');
                    $history->created_by            = 'SYSTEM';
                    $history->created_at            = date('Y-m-d H:i:s');
                    $history->save();

                    //send mail
                    $this->send_mail_order_Touser($order->id);
                    $this->send_mail_order_Tostaff($order->id);

                }else if($data['key'] == 'dispute.close'){

                    $resust                     = TbOrder::select('id','payment_status','payment_massage')->findOrFail($order->id);
                    $resust->payment_status     = 11;
                    $resust->payment_massage    = $message;
                    $resust->save();

                    $history = new HistoryOrderStatus();
                    $history->orderNumber           = $order->orderNumber;
                    $history->order_status          = 'WEBHOOK OMISE';
                    $history->order_message         = $message;
                    $history->updated_by            = 'SYSTEM';
                    $history->updated_at            = date('Y-m-d H:i:s');
                    $history->created_by            = 'SYSTEM';
                    $history->created_at            = date('Y-m-d H:i:s');
                    $history->save();

                    //send mail
                    $this->send_mail_order_Touser($order->id);
                    $this->send_mail_order_Tostaff($order->id);

                }else if($data['key'] == 'dispute.accept'){

                    $resust                     = TbOrder::select('id','payment_status','payment_massage')->findOrFail($order->id);
                    $resust->payment_status     = 11;
                    $resust->payment_massage    = $message;
                    $resust->save();

                    $history = new HistoryOrderStatus();
                    $history->orderNumber           = $order->orderNumber;
                    $history->order_status          = 'WEBHOOK OMISE';
                    $history->order_message         = $message;
                    $history->updated_by            = 'SYSTEM';
                    $history->updated_at            = date('Y-m-d H:i:s');
                    $history->created_by            = 'SYSTEM';
                    $history->created_at            = date('Y-m-d H:i:s');
                    $history->save();

                    //send mail
                    $this->send_mail_order_Touser($order->id);
                    $this->send_mail_order_Tostaff($order->id);


                }

            }

        }

    }

    private function send_mail_order_Touser($orderId){

        $setting = TbSetting::first();
        $page = TbPagesMap::first();
        $order = TbOrder::with(
            'tb_setting_payment_status',
            'tb_order_payments',
            'tb_order_details',
            'tb_setting_province',
            'tb_setting_amphure',
            'tb_setting_district',
            'tb_receipt_province',
            'tb_receipt_amphures',
            'tb_receipt_district',
            'tb_setting_transport'
        )
        ->findOrFail($orderId);
        $user = User::where('user_code',$order->userCode)->first();

        $data = new \stdClass();
        $data->setting_nameWeb = $setting->setting_nameWeb;
        $data->setting_logoWeb = $setting->setting_logoWeb;
        $data->order = $order;
        $data->page = $page;

		try{
			Mail::to($user->email)->later(now()->addMinutes(5), new orderNotify($data));
			
			if(Mail::failures()) { $mailStatus = 'ล้มเหลว'; }else{ $mailStatus = 'สำเร็จ'; }
		}catch(\Exception $e){
			// Never reached
			$mailStatus = 'ล้มเหลว';
		}

        $history                            = new HistorySendMail();
        $history->userId                    = $user->id;
        $history->remark                    = "อัพเดตสถานะ ".$order->orderNumber;
        $history->status                    = $mailStatus;
        $history->created_by                = 'SYSTEM';
        $history->created_at                = date('Y-m-d H:i:s');
        $history->updated_at                = date('Y-m-d H:i:s');
        $history->save();

    }

    private function send_mail_order_Tostaff($orderId){

        $setting = TbSetting::first();
        $page = TbPagesMap::first();
        $order = TbOrder::with(
            'tb_setting_payment_status',
            'tb_order_payments',
            'tb_order_details',
            'tb_setting_province',
            'tb_setting_amphure',
            'tb_setting_district',
            'tb_receipt_province',
            'tb_receipt_amphures',
            'tb_receipt_district',
            'tb_setting_transport'
        )
        ->findOrFail($orderId);
        //ค้นหาข้อมูลผู้สั่งซื้อสินค้า
        $user = User::where('user_code',$order->userCode)->first();
        //ค้นหาข้อมูลผู้แนะนำ
        $ref = User::select('id','user_code','staffId')->where('user_code',$user->user_code_friend)->first();
        if(!empty($ref)){
            //ค้นหาข้อมูลพนักงานที่ดูแล ข้อมูลของผู้แนะนำ
            $staff = User::select('id','name','lastname')->where('id',$ref->staffId)->first();
        }else{
            //ค้นหาข้อมูลพนักงานที่ดูแล ข้อมูลของผู้แนะนำ
            $staff = '';
        }

        $data = new \stdClass();
        $data->setting_nameWeb = $setting->setting_nameWeb;
        $data->setting_logoWeb = $setting->setting_logoWeb;
        $data->order = $order;
        $data->page = $page;
        $data->user = $user;
        $data->staff = $staff;

        if(!empty($setting->setting_email_bcc)){
            $mail_bcc = explode(",",$setting->setting_email_bcc);
            
			try{
				Mail::to($mail_bcc)->later(now()->addMinutes(5), new orderToStaff($data));

				if(Mail::failures()) { $mailStatus = 'ล้มเหลว'; }else{ $mailStatus = 'สำเร็จ'; }
			}catch(\Exception $e){
				// Never reached
				$mailStatus = 'ล้มเหลว';
			}

            $history                            = new HistorySendMail();
            $history->userId                    = $user->id;
            $history->remark                    = "อัพเดตสถานะ ".$order->orderNumber;
            $history->status                    = $mailStatus;
            $history->created_by                = 'SYSTEM';
            $history->created_at                = date('Y-m-d H:i:s');
            $history->updated_at                = date('Y-m-d H:i:s');
            $history->save();
        }

    }

}
