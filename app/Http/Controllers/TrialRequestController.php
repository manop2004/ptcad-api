<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\TbSettingProvince;

class TrialRequestController extends Controller
{
    public function index(Request $request)
{
    $setting = \App\Models\TbSetting::first();
 
    $provinces = TbSettingProvince::select('id', 'prov_name_th')->orderBy('prov_name_th')->get();
 
    $trialProducts = \App\Models\TbProduct::whereIn('pro_permalink', ['ptcad-lite', 'ptcad-standard', 'ptcad-plus'])
        ->select('id', 'pro_name', 'pro_permalink', 'pro_release_notes')
        ->get()
        ->keyBy('pro_permalink');
 
    foreach ($trialProducts as $p) {
        $picture = \App\Models\TbProductPicture::select('picture_name')
            ->where('proId', $p->id)
            ->where('picture_status', 1)
            ->first();
        $p->cover_image = !empty($picture) ? asset('storage/product/' . $picture->picture_name) : null;
    }
 
    // ===== อ่านค่า ?ref=xxx จาก URL (ของเดิม ไม่เปลี่ยน) =====
$ref = $request->query('ref');

// ===== [เพิ่มใหม่] อ่านค่า ?utm_source= จาก URL =====
$utmSource = $request->query('utm_source');

// ===== เลือก Layout: มี ref (แบบเดิม) หรือ มี utm_source (แบบใหม่) -> ใช้ Layout เปล่า =====
if (!empty($ref) || !empty($utmSource)) {
    $layout = 'layouts.embed_bare';
    $breadcrumb = [];
} else {
    $layout = 'layouts.temp_user';
    $breadcrumb = [
        ['route' => route('fronend.home'), 'name' => 'หน้าหลัก'],
        ['route' => '', 'name' => 'ทดลองใช้ฟรี'],
    ];
}
 
    return view('fontend.trial.index', compact('setting', 'provinces', 'trialProducts', 'breadcrumb', 'ref', 'layout'));
}

    private function getDownloadLink(string $productSlug): ?string
    {
        $links = [
            'ptcad-lite'     => 'https://download.pt-cad.com/DownloadManage/DirectLatestLite',
            'ptcad-standard' => 'https://download.pt-cad.com/DownloadManage/DirectLatest',
            'ptcad-plus'     => 'https://download.pt-cad.com/DownloadManage/DirectLatestPlus',
        ];

        return $links[$productSlug] ?? null;
    }

    private function getEditionLabel(string $productSlug): string
    {
        $labels = [
            'ptcad-lite'     => 'PTCAD LITE',
            'ptcad-standard' => 'PTCAD Standard',
            'ptcad-plus'     => 'PTCAD Plus',
        ];

        return $labels[$productSlug] ?? strtoupper(str_replace('ptcad-', '', $productSlug));
    }

    public function store(Request $request)
    {
        $request->validate([
            'firstname'    => 'required|max:255',
            'lastname'     => 'required|max:255',
            'company'      => 'required|max:255',
            'email'        => 'required|email|max:255',
            'phone'        => 'required|max:255',
            'province'     => 'required',
            'product_slug' => 'required|in:ptcad-lite,ptcad-standard,ptcad-plus',
        ], [
            'firstname.required'    => 'กรุณากรอกชื่อ',
            'lastname.required'     => 'กรุณากรอกนามสกุล',
            'company.required'      => 'กรุณากรอกชื่อบริษัท',
            'email.required'        => 'กรุณากรอกอีเมล',
            'email.email'           => 'รูปแบบอีเมลไม่ถูกต้อง',
            'phone.required'        => 'กรุณากรอกเบอร์โทรศัพท์',
            'province.required'     => 'กรุณาเลือกจังหวัด',
            'product_slug.required' => 'กรุณาเลือกเวอร์ชันที่ต้องการทดลองใช้',
            'product_slug.in'       => 'เวอร์ชันที่เลือกไม่ถูกต้อง',
        ]);

        $province = TbSettingProvince::find($request->province);

        $downloadLink = $this->getDownloadLink($request->product_slug);
        $editionLabel = $this->getEditionLabel($request->product_slug);

        if (empty($downloadLink)) {
            \Log::error('[TrialRequest] Unknown product_slug, no download link mapped', [
                'product_slug' => $request->product_slug,
            ]);
            return redirect()->back()
                ->withInput()
                ->with('trial_error', 'ไม่พบลิงก์ดาวน์โหลดสำหรับเวอร์ชันที่เลือก กรุณาติดต่อเจ้าหน้าที่');
        }

        // ===== อ่านค่า ref ที่แอบส่งมากับฟอร์ม (ของเดิม ไม่เปลี่ยน) =====
$ref = $request->input('ref');

// ===== [เพิ่มใหม่] ถ้าไม่มี ref ให้ลองดู cf_utm_source แทน (รองรับ Campaign แบบ UTM ด้วย) =====
$utmSource = $request->input('cf_utm_source');
$resellerKey = !empty($ref) ? $ref : $utmSource;

$reseller = $resellerKey ? (config('resellers', [])[$resellerKey] ?? null) : null;

        $trialExpireAt = now()->addDays(30)->toDateString();

        $id = DB::table('tb_trial_request')->insertGetId([
            'firstname'       => $request->firstname,
            'lastname'        => $request->lastname,
            'company'         => $request->company,
            'email'           => $request->email,
            'phone'           => $request->phone,
            'line_id'         => $request->line_id,
            'province_id'     => $request->province,
            'product_slug'    => $request->product_slug,
            'trial_expire_at' => $trialExpireAt,
            'created_at'      => now(),
        ]);

        // -----------------------------
        // ส่งอีเมลลิงก์ดาวน์โหลดให้ผู้ใช้ (เหมือนเดิมทุกอย่าง ไม่เปลี่ยน)
        // -----------------------------
        try {
    $setting = \App\Models\TbSetting::first();
 
    $mailData = new \stdClass();
    $mailData->setting_logoWeb = $setting->setting_logoWeb ?? null;
    $mailData->setting_nameWeb = $setting->setting_nameWeb ?? 'PTCAD Thailand';
    $mailData->firstname       = $request->firstname;
    $mailData->lastname        = $request->lastname;
    $mailData->editionLabel    = $editionLabel;
    $mailData->downloadLink    = $downloadLink;
    $mailData->trialExpireAt   = $trialExpireAt;
 
    Mail::send('emails.trial_download', ['data' => $mailData], function ($message) use ($request, $editionLabel) {
        $message->to($request->email)
            ->subject("ลิงก์ดาวน์โหลด {$editionLabel} - ทดลองใช้ฟรี 30 วัน");
    });
 
    DB::table('tb_trial_request')->where('id', $id)->update([
        'mail_status' => 'sent',
    ]);
} catch (\Exception $e) {
    \Log::error('[TrialRequest] Mail send exception: ' . $e->getMessage());
    DB::table('tb_trial_request')->where('id', $id)->update([
        'mail_status' => 'failed',
    ]);
}

        // =====================================================================
        // ใหม่: ถ้ามี ref และตรงกับ reseller ที่รู้จัก -> ส่งอีเมลแจ้งทีม reseller เพิ่ม
        // =====================================================================
        if ($reseller) {
            try {
                Mail::raw(
                    "แจ้งเตือนลูกค้าใหม่จากฟอร์มทดลองใช้ PTCAD (Reseller: {$reseller['name']})\n\n" .
                    "ชื่อ - สกุล: {$request->firstname} {$request->lastname}\n" .
                    "บริษัท: {$request->company}\n" .
                    "อีเมล: {$request->email}\n" .
                    "โทรศัพท์: {$request->phone}\n" .
                    "จังหวัด: " . ($province->prov_name_th ?? '-') . "\n" .
                    "เวอร์ชันที่เลือก: {$editionLabel}\n" .
                    "วันที่: " . now()->format('d-m-Y H:i'),
                    function ($message) use ($reseller, $request) {
                        $message->to($reseller['notify_emails'])
                            ->subject("[PTCAD] ลูกค้าใหม่จาก {$reseller['name']} - {$request->company}");
                    }
                );
            } catch (\Exception $e) {
                \Log::error('[TrialRequest] Reseller notify mail exception: ' . $e->getMessage());
            }
        }

        // -----------------------------
        // ยิงไป Lead API (ไม่กระทบ flow เดิมถ้ายิงพลาด)
        // =====================================================================
        // ใหม่: ถ้ามี ref ที่ตรงกับ reseller ซึ่งตั้งค่า use_crm = false -> ข้ามขั้นตอนนี้ไปเลย
        //        ถ้าไม่มี ref เลย (หน้าเว็บหลักปกติ) -> ทำงานเหมือนเดิมทุกอย่าง ไม่เปลี่ยน
        // =====================================================================
        $skipCrm = $reseller && array_key_exists('use_crm', $reseller) && $reseller['use_crm'] === false;

        if (!$skipCrm) {
            try {
                $leadApiUrl    = env('LEAD_API_URL');
                $leadApiKey    = env('LEAD_API_KEY');
                $backendSecret = env('LEAD_API_BACKEND_SECRET');

                $payload = [
                    'lastname'        => $request->lastname,
                    'firstname'       => $request->firstname,
                    'email'           => $request->email,
                    'phone'           => $request->phone,
                    'mobile'          => $request->phone,
                    'company'         => $request->company,
                    'state'           => $province->prov_name_en ?? '',
                    'country'         => 'Thailand',
                    'description'     => 'ขอทดลองใช้ ' . $editionLabel . ' ฟรี 30 วัน (หมดอายุ ' . $trialExpireAt . ')' . (!empty($request->line_id) ? ' / Line ID: ' . $request->line_id : ''),
                    'leadsource'      => $reseller ? ('Reseller - ' . $reseller['name']) : 'Web Site',
                    'recaptcha_token' => 'backend-trusted',
                ];

                // ใหม่: ถ้ามี reseller และเขามี campaign_id ของตัวเอง ใช้ตัวนั้นแทนแคมเปญหลัก
                $payload['campaign_id'] = ($reseller && !empty($reseller['campaign_id']))
                    ? $reseller['campaign_id']
                    : 33; // Campaign "ดาวน์โหลด_ทดลองใช้_PTCAD" (ค่าเดิม ใช้ตอนไม่มี ref)
                    // ส่งค่า UTM เข้า CRM โดยใช้ชื่อ custom field ที่ lead-api/Vtiger ต้องการโดยตรง
                    // รองรับทั้งฟอร์มใหม่ (cf_utm_*) และฟอร์ม/ลิงก์เดิม (utm_*) เพื่อ backward compatibility
                    $utmFields = [
                        'cf_utm_source'   => 'utm_source',
                        'cf_utm_medium'   => 'utm_medium',
                        'cf_utm_campaign' => 'utm_campaign',
                        'cf_utm_term'     => 'utm_term',
                        'cf_utm_content'  => 'utm_content',
                    ];

                    foreach ($utmFields as $crmField => $legacyField) {
                        $utmValue = trim((string) $request->input($crmField, ''));

                        // fallback สำหรับหน้า/ฟอร์มเก่าที่ยังส่งชื่อ utm_* อยู่
                        if ($utmValue === '') {
                            $utmValue = trim((string) $request->input($legacyField, ''));
                        }

                        if ($utmValue !== '') {
                            $payload[$crmField] = $utmValue;
                        }
                    }

                $response = \Illuminate\Support\Facades\Http::timeout(10)
                    ->retry(2, 500)
                    ->withHeaders([
                        'Content-Type'     => 'application/json',
                        'X-API-Key'        => $leadApiKey,
                        'X-Backend-Secret' => $backendSecret,
                    ])
                    ->post($leadApiUrl, $payload);

                DB::table('tb_trial_request')->where('id', $id)->update([
                    'lead_api_status' => $response->successful() ? 'sent' : 'failed',
                ]);

            } catch (\Exception $e) {
                \Log::error('[TrialRequest] Lead API exception: ' . $e->getMessage());
            }
        } else {
            DB::table('tb_trial_request')->where('id', $id)->update([
                'lead_api_status' => 'skipped_no_crm',
            ]);
        }

        session()->flash('trial_success', true);
        return redirect()->route('fronend.trial.index');
    }
}