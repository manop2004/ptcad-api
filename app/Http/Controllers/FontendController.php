<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\RateLimiter;

use App\Models\TbArticle;
use App\Models\TbSetting;
use App\Models\TbTutorial;
use App\Models\TbTutorialProgress;
use App\Models\TbPage;
use App\Models\TbBrand;
use App\Models\TbPromotionEmailtemplate;
use App\Models\TbProduct;
use App\Models\TbProductPicture;
use App\Models\TbCategory;
use App\Models\TbCategorySub;
use App\Models\TbRecommendPromotion;
use App\Models\TbRecommendProduct;
use App\Models\TbRecommendProductCategory;
use App\Models\User;
use App\Models\TbSettingUser;
use App\Models\TbSettingPayment;
use App\Models\TbSettingInstallment;
use App\Models\TbProductCondition;
use App\Models\TbProductSpecification;
use App\Models\TbProductDetail;
use App\Models\TbExtension;
use App\Models\TbSettingProvince;
use App\Models\TbQuotation;
use App\Models\UsersAddressReceipt;
use App\Models\TbQuotationSetting;
use App\Models\TbPagesMap;
use App\Models\HistorySendMail;
use App\Models\TbSettingAmphure;
use App\Models\TbSettingDistrict;
use App\Models\HistoryQuotation;
use App\Models\TbPromotionCalendar;
use App\Models\TbPagesRedirect;
use App\Models\TbPromotionOnepage;
use App\Models\TbCustomcode;
use App\Models\TbPromotionOnepagesMenu;
use App\Models\TbPromotionOnepagesForm;
use App\Models\TbPromotionOnepagesSetting;
use App\Models\TbPromotionOnepagesSection;
use App\Models\TbPromotionOnepagesSort;
use App\Models\Ticket;
use App\Models\TicketFile;
use App\Models\TicketProgram;
use App\Models\HistoryTicket;
use App\Models\TbProductType;
use App\Models\TbProductStatus;
use App\Models\Review;

use App\Rules\userCheckMail;
use App\Mail\forgotMail;
use PDF;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class FontendController extends Controller
{

    public function index()
    {

        $brands                      = TbBrand::where('brand_recommend', 1)->where('brand_show', 1)->orderBy('brand_sort', 'asc')->get();
        $articles                    = TbArticle::select('art_name', 'art_thumb', 'art_parmalink', 'art_show', 'art_seo_detail', 'created_at')->where('art_show', 1)->orderBy('created_at', 'desc')->limit(4)->get();
        $recommendPromotion          = TbRecommendPromotion::where('show', 1)->orderBy('recommend_sort', 'desc')->get();
        $recommendProduct            = $this->recommendProduct();
        $recommendProductAndCategory = $this->recommendProductAndCategory();

        return view('fontend.main', [
            'og_site_name' => 'phpstack-1646968-6541058.cloudwaysapps.com',
            'og_keywords' => 'PTCAD, PTCAD, โปรแกรมออกแบบ, ซอฟต์แวร์เขียนแบบ, โปรแกรมเขียนแบบ, AutoCAD, GstarCAD, SketchUp, ArchiCAD, BIM, Adobe, โปรแกรมถูกลิขสิทธิ์, ซอฟต์แวร์ลิขสิทธิ์',
            'og_title' => 'จำหน่ายซอฟต์แวร์ออกแบบ สถาปัตกรรม วิศวกรรม และงานด้านกราฟิก&แอนิเมชั่น',
            'og_description' => 'ศูนย์รวมเครื่องมือ Software 2D/3D Hardware จำหน่าย ขาย โปรแกรมสำหรับนักออกแบบ โปรแกรมก่อสร้าง โปรแกรมสถาปนิก โปรแกรมสถาปัตยกรรม โปรแกรมวิศวกร เครื่องพิมพ์สามมิติ 3D Printer คุณภาพสูง ราคาถูก รวมถึง คอมพิวเตอร์ และการ์จอ เพื่องานออกแบบ',
            'og_url' => '/',
            'og_image' => asset('storage/setting/PTCAD_software_and_hardware_shop.webp'),
            'brands' => $brands,
            'articles' => $articles,
            'recommendPromotion' => $recommendPromotion,
            'recommendProduct' => $recommendProduct,
            'recommendProductAndCategory' => $recommendProductAndCategory,
        ]);
    }

    public function confirmation()
    {
        $setting = TbSetting::first();
        $settingUser = TbSettingUser::first();

        if (!empty($_GET['status'])) {
            $page_name = 'สมัครสมาชิกสำเร็จ';
        } else {
            $page_name = 'สมัครสมาชิกไม่สำเร็จ';
        }

        //title share
        if (!empty($page_name)) {
            $og_site_name = $page_name;
        } else {
            $og_site_name = $page_name;
        }
        if (!empty($page_name)) {
            $og_title = $page_name;
        } else {
            $og_title = $og_site_name = $page_name;
        }
        if (!empty($setting->setting_keyword)) {
            $og_keywords = $setting->setting_keyword;
        } else {
            $og_keywords = "";
        }
        if (!empty($setting->setting_detail)) {
            $og_description = $setting->setting_detail;
        } else {
            $og_description = "";
        }
        if (!empty($setting->setting_coverShare)) {
            $og_image = asset('storage/setting/' . $setting->setting_coverShare);
        } else {
            $og_image = "";
        }
        if (!empty($page)) {
            $og_url = route('login');
        } else {
            $og_url = route('fronend.home');
        }

        return view('auth.confirmation', [
            'og_site_name' => $og_site_name,
            'og_keywords' => $og_keywords,
            'og_title' => $og_title,
            'og_description' => $og_description,
            'og_url' => $og_url,
            'og_image' => $og_image,
            'page_name' => $page_name,
            'settingUser' => $settingUser,
        ]);
    }

    public function promotionEvent()
    {

        $promotions = TbPromotionCalendar::where('line_notify_group1', 1)->where('promo_show', 1)->orderBy('created_at', 'desc')->paginate(8);
        return view('fontend.promotion.main', [
            'promotions' => $promotions,
        ]);
    }

    public function brand(Request $request, $permalink)
    {

        $brand = TbBrand::where('brand_permalink', $permalink)->where('brand_show', 1)->first();

        if (!empty($brand)) {

            $breadcrumb = [
                ['route' => route('fronend.home'), 'name' => 'หน้าหลัก'],
                ['route' => '', 'name' => $brand->brand_name],
            ];


            $setting        = TbSetting::first();
            $page_name      = $brand->brand_name;
            $page_detail    = '';
            $items          = $this->getBrandProduct($brand->id);
            $data           = $this->paginate($items, 40);
            $data->withPath(route('fronend.category', $permalink));

            $breadcrumb = [
                ['route' => route('fronend.home'), 'name' => 'หน้าหลัก'],
                ['route' => '', 'name' => $permalink],
            ];
        } else {

            $breadcrumb = [
                ['route' => route('fronend.home'), 'name' => 'หน้าหลัก']
            ];

            $page_name = 'ไม่พบข้อมูล';

            $setting        = TbSetting::first();
            $page_name      = '';
            $page_detail    = '';
            $items          = '';
            $data           = '';

            $breadcrumb = [
                ['route' => route('fronend.home'), 'name' => 'หน้าหลัก'],
                ['route' => '', 'name' => $permalink],
            ];
        }

        //title share
        if (!empty($page_name)) {
            $og_site_name = $page_name;
        } else {
            $og_site_name = "";
        }
        if (!empty($page_name)) {
            $og_title = $page_name;
        } else {
            $og_title = $og_site_name = "";
        }
        if (!empty($setting->setting_keyword)) {
            $og_keywords = $setting->setting_keyword;
        } else {
            $og_keywords = "";
        }
        if (!empty($setting->setting_detail)) {
            $og_description = $setting->setting_detail;
        } else {
            $og_description = "";
        }
        if (!empty($setting->setting_coverShare)) {
            $og_image = asset('storage/setting/' . $setting->setting_coverShare);
        } else {
            $og_image = asset('storage/setting/' . $setting->setting_coverShare);
        }
        if (!empty($page)) {
            $og_url = route('fronend.category', $permalink);
        } else {
            $og_url = route('fronend.home');
        }

        return view('fontend.product.category', [
            'breadcrumb' => $breadcrumb,
            'og_site_name' => $og_site_name,
            'og_keywords' => $og_keywords,
            'og_title' => $og_title,
            'og_description' => $og_description,
            'og_url' => $og_url,
            'og_image' => $og_image,
            'page_name' => $page_name,
            'page_detail' => $page_detail,
            'data' => $data,
        ]);
    }

    /* ================================================ support ticket */

	public function indexHelp(Request $request)
    {

        $breadcrumb = [
            ['route' => route('fronend.home'), 'name' => 'หน้าหลัก'],
            ['route' => '', 'name' => 'บริการช่วยเหลือ'],
        ];
        $setting = TbSetting::first();
        $programs = TicketProgram::where('show', 1)->orderBy('name', 'asc')->get();

        //title share
        if (!empty($setting->setting_keyword)) {
            $og_keywords = $setting->setting_keyword;
        } else {
            $og_keywords = "";
        }
        if (!empty($setting->setting_detail)) {
            $og_description = $setting->setting_detail;
        } else {
            $og_description = "";
        }
        if (!empty($setting->setting_coverShare)) {
            $og_image = asset('storage/setting/' . $setting->setting_coverShare);
        } else {
            $og_image = asset('storage/setting/' . $setting->setting_coverShare);
        }
		
		$userdata = array();
		$userdata = $this->getUserAddress();
		$userdata['id'] = $this->checkAuth();
		$userdata['is_customer'] = 'no';
		
		$userdata['userStaffId'] = '';
		$userdata['userStaffName'] = '';
		$userdata['userStaffEmail'] = '';
		
		if(!empty($userdata['userLevel'])){
			
			if($userdata['userLevel'] == 6){
				$userdata['is_customer'] = 'yes';
				
				$staff = User::select('name', 'lastname', 'email')->where('id', $userdata['userStaffId'])->first();
				
				if(!empty($staff)){
					$userdata['userStaffId'] = $staff->userStaffId ? $staff->userStaffId : '';
					$userdata['userStaffName'] = $staff->name ? $staff->name : '';
					$userdata['userStaffEmail'] = $staff->email ? $staff->email : '';
				}
				
			}else{
				
				$userdata['userStaffId'] = $userdata['id'] ? $userdata['id'] : '';
				$userdata['userStaffName'] = $userdata['userName'] ? $userdata['userName'] : '';
				$userdata['userStaffEmail'] = $userdata['userEmail'] ? $userdata['userEmail'] : '';
				
				$userdata['userName'] = '';
				$userdata['userLastname'] = '';
				$userdata['userTelMain'] = '';
				$userdata['userEmail'] = '';
				$userdata['userCompanyMain'] = '';
				
			}
			
		}else{
			$userdata['userLevel'] = '';
		}
		
		$request_channel = trim((string) $request->query('ref', ''));
		$request_channel = strip_tags($request_channel);
		$request_channel = mb_substr($request_channel, 0, 255);

        return view('fontend.help.main', [
            'og_site_name' => 'บริการช่วยเหลือ',
            'og_keywords' => $og_keywords,
            'og_title' => 'บริการช่วยเหลือ',
            'og_description' => $og_description,
            'og_url' => route('fronend.help.index'),
            'og_image' => $og_image,
            'breadcrumb' => $breadcrumb,
            'programs' => $programs,
            'userdata' => $userdata,
            'request_channel' => $request_channel,
        ]);
    }
	
	public function indexHelp2()
    {

        $breadcrumb = [
            ['route' => route('fronend.home'), 'name' => 'หน้าหลัก'],
            ['route' => '', 'name' => 'บริการช่วยเหลือ'],
        ];
        $setting = TbSetting::first();
        $programs = TicketProgram::where('show', 1)->orderBy('name', 'asc')->get();

        //title share
        if (!empty($setting->setting_keyword)) {
            $og_keywords = $setting->setting_keyword;
        } else {
            $og_keywords = "";
        }
        if (!empty($setting->setting_detail)) {
            $og_description = $setting->setting_detail;
        } else {
            $og_description = "";
        }
        if (!empty($setting->setting_coverShare)) {
            $og_image = asset('storage/setting/' . $setting->setting_coverShare);
        } else {
            $og_image = asset('storage/setting/' . $setting->setting_coverShare);
        }
		
		$userdata = array();
		$userdata = $this->getUserAddress();
		$userdata['id'] = $this->checkAuth();
		$userdata['is_customer'] = 'no';
		
		$userdata['userStaffId'] = '';
		$userdata['userStaffName'] = '';
		$userdata['userStaffEmail'] = '';
		
		if(!empty($userdata['userLevel'])){
			
			if($userdata['userLevel'] == 6){
				$userdata['is_customer'] = 'yes';
				
				$staff = User::select('name', 'lastname', 'email')->where('id', $userdata['userStaffId'])->first();
				
				if(!empty($staff)){
					$userdata['userStaffId'] = $staff->userStaffId ? $staff->userStaffId : '';
					$userdata['userStaffName'] = $staff->name ? $staff->name : '';
					$userdata['userStaffEmail'] = $staff->email ? $staff->email : '';
				}
				
			}else{
				
				$userdata['userStaffId'] = $userdata['id'] ? $userdata['id'] : '';
				$userdata['userStaffName'] = $userdata['userName'] ? $userdata['userName'] : '';
				$userdata['userStaffEmail'] = $userdata['userEmail'] ? $userdata['userEmail'] : '';
				
				$userdata['userName'] = '';
				$userdata['userLastname'] = '';
				$userdata['userTelMain'] = '';
				$userdata['userEmail'] = '';
				$userdata['userCompanyMain'] = '';
				
			}
			
		}else{
			$userdata['userLevel'] = '';
		}
		
		$request_channel = isset($_GET['ref']) && !empty($_GET['ref']) ? $_GET['ref'] : '';

        return view('fontend.help.main2', [
            'og_site_name' => 'บริการช่วยเหลือ',
            'og_keywords' => $og_keywords,
            'og_title' => 'บริการช่วยเหลือ',
            'og_description' => $og_description,
            'og_url' => route('fronend.help.index'),
            'og_image' => $og_image,
            'breadcrumb' => $breadcrumb,
            'programs' => $programs,
            'userdata' => $userdata,
            'request_channel' => $request_channel,
        ]);
    }

	public function crateHelp(Request $request)
    {

        $request->validate(
            [
                'name' => 'required|max:255',
                'company' => 'required|max:255',
                'tel' => 'required|max:255',
                'email' => 'required|email:rfc,dns',
                'program' => 'required|max:255',
                'message' => 'required|max:1000',
				'idempotency_key' => 'required|uuid',
            ],
            [
                'name.required' => 'กรุณากรอกข้อมูล',
                'name.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
				'company.required' => 'กรุณากรอกข้อมูล',
                'company.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
				'tel.required' => 'กรุณากรอกข้อมูล',
                'tel.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'email.required' => 'กรุณากรอกข้อมูล',
                'email.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
				'program.required' => 'กรุณากรอกข้อมูล',
                'program.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
				'message.required' => 'กรุณากรอกข้อมูล',
                'message.max' => 'กรุณากรอกข้อมูลไม่เกิน 1000 ตัวอักษร',
            ]
        );
		
		// --- Rate limit ---
		$key = 'open-ticket:' . (Auth::id() ?: $request->ip());
		if (RateLimiter::tooManyAttempts($key, 5)) {
			return back()->withErrors(['too_many' => 'ส่งคำขอถี่เกินไป กรุณาลองใหม่ภายหลัง'])->withInput();
		}
		RateLimiter::hit($key, 60); // อนุญาต 5 ครั้ง/นาที ต่อผู้ใช้หรือ IP
		
		# Block Bot
		if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($request['g-recaptcha-response'])) {
			
			// Build POST request:
			$recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
			$recaptcha_secret = env('RECAPTCHA_SECRET_KEY');
			$recaptcha_response = $request['g-recaptcha-response'];

			// Make and decode POST request:
			$recaptcha = file_get_contents($recaptcha_url.'?secret='.$recaptcha_secret.'&response='.$recaptcha_response);
			$recaptcha = json_decode($recaptcha);

			// Take action based on the score returned:
			if (!empty($recaptcha->success)) {
    // Verified
} else {
    \Log::info('reCAPTCHA failed in crateHelp', ['recaptcha_response' => $recaptcha]);
    return back()->withErrors(['recaptcha' => 'ยืนยันตัวตนไม่สำเร็จ กรุณาลองใหม่อีกครั้ง'])->withInput();
}
		}else{
    \Log::info('reCAPTCHA missing g-recaptcha-response field entirely');
    return back()->withErrors(['recaptcha' => 'กรุณายืนยันตัวตน (ติ๊กช่อง reCAPTCHA) ก่อนส่งข้อมูล'])->withInput();
}
		
		// --- กันซ้ำด้วย idempotency key ---
		if ($exists = Ticket::where('idempotency_key', $request->idempotency_key)->first()) {
			return redirect()->route('fronend.help.status', ['code' => $exists->code]);
		}
		
		$userid = $this->checkAuth();
		$request_by = 'Unknow';
		if(!empty($userid)){
			$user_level = Auth::user()->level;
			
			$sales_role = Array(2);
			$support_role = Array(5);
			$customer_role = Array(6);
			
			if(in_array($user_level, $sales_role)){
				$request_by = 'Sale';
			}else if(in_array($user_level, $support_role)){
				$request_by = 'Support';
			}else if(in_array($user_level, $customer_role)){
				$request_by = 'Customer';
			}
		}
		
		$program_ticket = '';
		if(!empty($request->program)){
			if(is_array($request->program)){
				$program_ticket = implode(',', $request->program);
			}else{
				$program_ticket = $request->program;
			}
		}
		
		$request_channel = trim((string) $request->input('request_channel', ''));

		if ($request_channel === '') {
			$request_channel = '';
		} else {
			$request_channel = strip_tags($request_channel);
			$request_channel = mb_substr($request_channel, 0, 255);
		}

        //สถานะการช่วยเหลือ
        //1 == เปิด ticket
        //2 == กำลังดำเนินการ
        //3 == แก้ไขสำเร็จ
        $data = new Ticket;
        $data->code                     = $this->generateTicketCode();
		$data->idempotency_key          = $request->idempotency_key;
        $data->userid                   = $userid;
        $data->name                     = $request->name;
        //$data->lastname                 = $request->lastname;
        $data->company                  = $request->company;
        $data->email                    = $request->email;
        $data->tel                      = $request->tel;
        //$data->available_time           = $request->available_time;
        //$data->subject                  = $request->subject;
        $data->program                  = $program_ticket;
        $data->message                  = $request->message;
        $data->sales_id                 = $request->sales_id;
        $data->sales_name               = $request->sales_name;
        $data->email_cc                 = $request->email_cc;
        $data->status                   = 1;
        $data->created_by               = $request->name;
        $data->updated_by               = $request->name;
        $data->created_at               = date('Y-m-d H:i:s');
        $data->updated_at               = date('Y-m-d H:i:s');
		$data->secret_code              = $this->generateRandomString(16);
        $data->request_channel          = $request_channel;
        $data->request_by          		= $request_by;
        $data->save();
		
        if (!empty($request->file)) {
            if ($request->hasFile('file')) {

                for ($i = 0; $i < count($request->file); $i++) {

					if(isset($request->file[$i])){
						
						$attachment = $request->file[$i];

						if ($attachment != null) {

							$dataFile = new TicketFile;
							$dataFile->ticketId                = $data->id;
							$dataFile->name                    = $attachment;
							$dataFile->created_at              = date('Y-m-d H:i:s');
							$dataFile->updated_at              = date('Y-m-d H:i:s');

							$newFilename    = uniqid() . '.' . $attachment->extension();
							$dataFile->name     = $newFilename;
							$file = $attachment;
							$file->move(public_path('storage/ticket/'), $newFilename);
							$dataFile->save();
						}
						
					}
                    
                }
            }
        }

        $history = new HistoryTicket();
        $history->ticketId                	= $data->id;
        $history->ticketcode                = $data->code;
        $history->status                	= $data->status;
        $history->remark                    = "Open Ticket ID : " . $data->code;
        $history->mailStatus                = 2;
        $history->mailRemark                = 'ล้มเหลว';
        $history->updated_by                = $data->created_by;
        $history->created_at                = date('Y-m-d H:i:s');
        $history->updated_at                = date('Y-m-d H:i:s');
        $history->save();

        $this->TicketForUser($data->id);

        // [PTCAD] ส่งข้อมูลเข้า CRM (Vtiger) เป็น Lead — เพื่อให้พนักงานเห็น
        // คำขอความช่วยเหลือใน CRM ด้วย (ไม่กระทบ flow เดิมถ้า Lead API ล่ม)
        $nameParts = explode(' ', trim($request->name), 2);
        $firstname = $nameParts[0] ?? '';
        $lastname  = $nameParts[1] ?? '';

        $ticketMessage = 'โปรแกรมที่ขอใช้บริการ: ' . $program_ticket . "\n\n" . 'รายละเอียด: ' . $request->message;

        $this->sendToLeadApi(
            null,
            $firstname,
            $lastname,
            $request->email,
            $request->company,
            $request->tel,
            '',
            '',
            '',
            $ticketMessage,
            ''
        );

        $breadcrumb = [
            ['route' => route('fronend.home'), 'name' => 'หน้าหลัก'],
            ['route' => '', 'name' => 'บริการช่วยเหลือ'],
        ];

        return redirect()->route('fronend.help.status', ['code' => $data->code]);
    }
	
	public function status($code) {
		$breadcrumb = [
			['route' => route('fronend.home'), 'name' => 'หน้าหลัก'],
			['route' => '', 'name' => 'บริการช่วยเหลือ'],
		];

		return view('fontend.help.status', [
			'og_site_name'   => '',
			'og_keywords'    => '',
			'og_title'       => 'บริการช่วยเหลือ',
			'og_description' => '',
			'og_url'         => '',
			'og_image'       => '',
			'breadcrumb'     => $breadcrumb,
			'code'           => $code,
		]);
	}


	
	public function reviewHelp($code,$score)
    {
		if(!empty($code)){
			
			$ticket = Ticket::where('secret_code', $code)->first();
			
			if(!empty($ticket)){
				
				if(empty($ticket->score)){
					
					$data = Ticket::findOrfail($ticket->id);
					$data->score                    = $score;
					$data->score_at                 = date('Y-m-d H:i:s');
					$data->save();
					
					$history = new HistoryTicket();
					$history->ticketId                	= $ticket->id;
					$history->ticketcode                = $ticket->code;
					$history->status                	= $ticket->status;
					$history->score                    	= $score;
					$history->remark                    = 'Reviewed';
					
					$history->mailStatus                = 0;
					$history->mailRemark                = null;
					
					$history->updated_by                = $ticket->created_by;
					$history->created_at                = date('Y-m-d H:i:s');
					$history->updated_at                = date('Y-m-d H:i:s');
					$history->save();
					
					$save_status = 1;
				
				}else{
					
					$save_status = 2;
					
				}
				
			}else{
				$save_status = 2;
			}
			
		}else{
			$save_status = 2;
		}
		
		$breadcrumb = [
            ['route' => route('fronend.home'), 'name' => 'หน้าหลัก'],
            ['route' => '', 'name' => 'บริการช่วยเหลือ'],
        ];

        return view('fontend.help.review', [
            'og_site_name' => '',
            'og_keywords' => '',
            'og_title' => 'บริการช่วยเหลือ',
            'og_description' => '',
            'og_url' => '',
            'og_image' => '',
            'breadcrumb' => $breadcrumb,
			'save_status' => $save_status,
        ]);
    }

    /* ================================================ end support ticket */

    /* ================================================ product */
    public function search(Request $request)
    {

        $search = $request->search;

        $setting = TbSetting::first();
        $items          = $this->getProductSearch($search);
        $data           = $this->paginate($items, 40);
        $data->withPath(route('fronend.category.all'));

        $breadcrumb = [
            ['route' => route('fronend.home'), 'name' => 'หน้าหลัก'],
            ['route' => '', 'name' => $search],
        ];

        $page_name = $search;

        //title share
        if (!empty($page_name)) {
            $og_site_name = $page_name;
        } else {
            $og_site_name = "";
        }
        if (!empty($page_name)) {
            $og_title = $page_name;
        } else {
            $og_title = $og_site_name = "";
        }
        if (!empty($setting->setting_keyword)) {
            $og_keywords = $setting->setting_keyword;
        } else {
            $og_keywords = "";
        }
        if (!empty($setting->setting_detail)) {
            $og_description = $setting->setting_detail;
        } else {
            $og_description = "";
        }
        if (!empty($setting->setting_coverShare)) {
            $og_image = asset('storage/setting/' . $setting->setting_coverShare);
        } else {
            $og_image = asset('storage/setting/' . $setting->setting_coverShare);
        }
        if (!empty($page)) {
            $og_url = route('fronend.category.main');
        } else {
            $og_url = route('fronend.home');
        }

        return view('fontend.product.category', [
            'breadcrumb' => $breadcrumb,
            'og_site_name' => $og_site_name,
            'og_keywords' => $og_keywords,
            'og_title' => $og_title,
            'og_description' => $og_description,
            'og_url' => $og_url,
            'og_image' => $og_image,
            'page_name' => $page_name,
            'data' => $data,
        ]);
    }

    public function pageContent($permalink)
    {

        $setting = TbSetting::first();
        $page = TbPage::where('page_parmalink', $permalink)->where('page_show', 1)->first();
        $page_recommend = TbPage::select('page_parmalink', 'pages_type', 'pages_name', 'page_recommend', 'page_show')->where('page_recommend', 1)->where('page_show', 1)->get();

        if (!empty($page->pages_name)) {
            $breadcrumb = [
                ['route' => route('fronend.home'), 'name' => 'หน้าหลัก'],
                ['route' => '', 'name' => $page->pages_name],
            ];
        } else {
            $breadcrumb = "";
        }

        if (!empty($page)) {
            $permalink = $permalink;
        } else {
            $permalink = '';
        }
        //title share
        if (!empty($page->pages_name)) {
            $og_site_name = $page->pages_name;
        } else {
            $og_site_name = $setting->setting_nameWeb;
        }
        if (!empty($page->pages_name)) {
            $og_title = $page->pages_name;
        } else {
            $og_title = $og_site_name = $setting->setting_nameWeb;
        }
        if (!empty($page->pages_keyword)) {
            $og_keywords = $page->pages_keyword;
        } else {
            $og_keywords = "";
        }
        if (!empty($page->page_seo_detail)) {
            $og_description = $page->page_seo_detail;
        } else {
            $og_description = "";
        }
        if (!empty($setting->setting_coverShare)) {
            $og_image = asset('storage/setting/' . $setting->setting_coverShare);
        } else {
            $og_image = asset('storage/setting/' . $setting->setting_coverShare);
        }
        if (!empty($page)) {
            $og_url = route('fronend.page.content', $permalink);
        } else {
            $og_url = route('fronend.home');
        }

        if (!empty($page)) {

            if ($page->page_recommend == 1) {
                $return_page = 'fontend.pages.recommend';
            } else {
                $return_page = 'fontend.pages.form';
            }
        } else {
            $return_page = 'fontend.pages.form';
        }


        return view($return_page, [
            'breadcrumb' => $breadcrumb,
            'og_site_name' => $og_site_name,
            'og_keywords' => $og_keywords,
            'og_title' => $og_title,
            'og_description' => $og_description,
            'og_url' => $og_url,
            'og_image' => $og_image,
            'page' => $page,
            'page_recommend' => $page_recommend,
            'permalink' => $permalink,
        ]);
    }

    public function categoryAll()
    {

        $setting = TbSetting::first();
        $items          = $this->getCategoryProductAll();
        $data           = $this->paginate($items, 200);
        $data->withPath(route('fronend.category.all'));

        $breadcrumb = [
            ['route' => route('fronend.home'), 'name' => 'หน้าหลัก'],
            ['route' => '', 'name' => 'สินค้าทั้งหมด'],
        ];

        $page_name = "สินค้าทั้งหมด";

        //title share
        if (!empty($page_name)) {
            $og_site_name = $page_name;
        } else {
            $og_site_name = "";
        }
        if (!empty($page_name)) {
            $og_title = $page_name;
        } else {
            $og_title = $og_site_name = "";
        }
        if (!empty($setting->setting_keyword)) {
            $og_keywords = $setting->setting_keyword;
        } else {
            $og_keywords = "";
        }
        if (!empty($setting->setting_detail)) {
            $og_description = $setting->setting_detail;
        } else {
            $og_description = "";
        }
        if (!empty($setting->setting_coverShare)) {
            $og_image = asset('storage/setting/' . $setting->setting_coverShare);
        } else {
            $og_image = asset('storage/setting/' . $setting->setting_coverShare);
        }
        if (!empty($page)) {
            $og_url = route('fronend.category.main');
        } else {
            $og_url = route('fronend.home');
        }

        return view('fontend.product.category', [
            'breadcrumb' => $breadcrumb,
            'og_site_name' => $og_site_name,
            'og_keywords' => $og_keywords,
            'og_title' => $og_title,
            'og_description' => $og_description,
            'og_url' => $og_url,
            'og_image' => $og_image,
            'page_name' => $page_name,
            'data' => $data,
        ]);
    }
	
	public function materialAll()
    {

        $data = $this->getMaterialProductAll();
		/*
		$machine = TbProduct::select(DB::raw("REPLACE(REPLACE(SUBSTRING_INDEX((SUBSTRING_INDEX(pro_content, '______', 1)), '</strong>', -1), '<br />' ,''), '&nbsp;', '') AS machine"))
				->where('tb_product.pro_show', 1)
				->where('pro_catsubId', 61)
				->get();
		*/
		
        return view('fontend.product.material', [
            'data' => $data,
        ]);
    }
	
	public function malist(request $request)
    {

        $data = $this->getMaList($request->arr_spec, $request->arr_machine);
		
        return view('fontend.product.malist', [
            'data' => $data,
        ]);
    }
	
	public function maproduct(request $request)
    {

        $data = $this->getMaProduct($request->permalink);
		
        return view('fontend.product.maproduct', [
            'data' => $data,
        ]);
    }
	
	public function sale()
    {

        $setting = TbSetting::first();
        $items          = $this->getSaleProductAll();
        $data           = $this->paginate($items, 40);
        $data->withPath(route('fronend.sale.all'));

        $breadcrumb = [
            ['route' => route('fronend.home'), 'name' => 'หน้าหลัก'],
            ['route' => '', 'name' => 'สินค้าลดราคา'],
        ];

        $page_name = "สินค้าลดราคา";

        //title share
        if (!empty($page_name)) {
            $og_site_name = $page_name;
        } else {
            $og_site_name = "";
        }
        if (!empty($page_name)) {
            $og_title = $page_name;
        } else {
            $og_title = $og_site_name = "";
        }
        if (!empty($setting->setting_keyword)) {
            $og_keywords = $setting->setting_keyword;
        } else {
            $og_keywords = "";
        }
        if (!empty($setting->setting_detail)) {
            $og_description = $setting->setting_detail;
        } else {
            $og_description = "";
        }
		/*
        if (!empty($setting->setting_coverShare)) {
            $og_image = asset('storage/setting/' . $setting->setting_coverShare);
        } else {
            $og_image = asset('storage/setting/' . $setting->setting_coverShare);
        }
		*/
		$og_image = asset('storage/banner/651bbb93eb947.webp');
        if (!empty($page)) {
            $og_url = route('fronend.sale.all');
        } else {
            $og_url = route('fronend.home');
        }

        return view('fontend.product.category', [
            'breadcrumb' => $breadcrumb,
            'og_site_name' => $og_site_name,
            'og_keywords' => $og_keywords,
            'og_title' => $og_title,
            'og_description' => $og_description,
            'og_url' => $og_url,
            'og_image' => $og_image,
            'page_name' => $page_name,
            'data' => $data,
        ]);
    }
	
	public function sale_promotion($start_date)
    {
		
        $setting = TbSetting::first();
		
        $items          = $this->getSaleProductSearch($start_date);
        $data           = $this->paginate($items, 40);
        $data->withPath(route('fronend.sale', $start_date));

        $breadcrumb = [
            ['route' => route('fronend.home'), 'name' => 'หน้าหลัก'],
            ['route' => '', 'name' => 'สินค้าลดราคา'],
        ];

        $page_name = "สินค้าลดราคา";

        //title share
        if (!empty($page_name)) {
            $og_site_name = $page_name;
        } else {
            $og_site_name = "";
        }
        if (!empty($page_name)) {
            $og_title = $page_name;
        } else {
            $og_title = $og_site_name = "";
        }
        if (!empty($setting->setting_keyword)) {
            $og_keywords = $setting->setting_keyword;
        } else {
            $og_keywords = "";
        }
        if (!empty($setting->setting_detail)) {
            $og_description = $setting->setting_detail;
        } else {
            $og_description = "";
        }
		/*
        if (!empty($setting->setting_coverShare)) {
            $og_image = asset('storage/setting/' . $setting->setting_coverShare);
        } else {
            $og_image = asset('storage/setting/' . $setting->setting_coverShare);
        }
		*/
		$og_image = asset('storage/banner/651bbb93eb947.webp');
        if (!empty($page)) {
            $og_url = route('fronend.sale.all');
        } else {
            $og_url = route('fronend.home');
        }
		
        return view('fontend.product.category', [
            'breadcrumb' => $breadcrumb,
            'og_site_name' => $og_site_name,
            'og_keywords' => $og_keywords,
            'og_title' => $og_title,
            'og_description' => $og_description,
            'og_url' => $og_url,
            'og_image' => $og_image,
            'page_name' => $page_name,
            'data' => $data,
        ]);
		
    }

    public function category($permalink)
    {

        $setting        = TbSetting::first();
        $page_name      = $this->getCategory($permalink);
        $page_detail    = $this->getCategoryDetail($permalink);
		
		$breadcrumb = [
            ['route' => route('fronend.home'), 'name' => 'หน้าหลัก'],
            ['route' => '', 'name' => $page_name],
        ];

        //title share
        if (!empty($page_name)) {
            $og_site_name = $page_name;
        } else {
            $og_site_name = "";
        }
        if (!empty($page_name)) {
            $og_title = $page_name;
        } else {
            $og_title = $og_site_name = "";
        }
        if (!empty($setting->setting_keyword)) {
            $og_keywords = $setting->setting_keyword;
        } else {
            $og_keywords = "";
        }
        if (!empty($setting->setting_detail)) {
            $og_description = $setting->setting_detail;
        } else {
            $og_description = "";
        }
        if (!empty($setting->setting_coverShare)) {
            $og_image = asset('storage/setting/' . $setting->setting_coverShare);
        } else {
            $og_image = asset('storage/setting/' . $setting->setting_coverShare);
        }
        if (!empty($page)) {
            $og_url = route('fronend.category', $permalink);
        } else {
            $og_url = route('fronend.home');
        }
		
		$subcategory	= $this->getSubCategory($permalink);
		
		$arr_product = array();
		if(count($subcategory)){
			# หากมี Sub Category ย่อย
			foreach($subcategory as $subcat){
				$arr_product[$subcat['categorysub_permalink']]['categorysub_name'] = $subcat['categorysub_name'];
				$arr_product[$subcat['categorysub_permalink']]['categorysub_permalink'] = $subcat['categorysub_permalink'];
				$arr_product[$subcat['categorysub_permalink']]['item'] = $this->getCategoryProduct($subcat['categorysub_permalink']);
			}
			
			$items          = $this->getCategoryProduct($permalink);
			$data           = $this->paginate($items, 40);
			$data->withPath(route('fronend.category', $permalink));

			return view('fontend.product.categoryMain', [
				'breadcrumb' => $breadcrumb,
				'og_site_name' => $og_site_name,
				'og_keywords' => $og_keywords,
				'og_title' => $og_title,
				'og_description' => $og_description,
				'og_url' => $og_url,
				'og_image' => $og_image,
				'page_name' => $page_name,
				'page_detail' => $page_detail,
				'data' => $data,
				'arr_product' => $arr_product,
			]);
			
		}else{
			$items          = $this->getCategoryProduct($permalink);
			$data           = $this->paginate($items, 40);
			$data->withPath(route('fronend.category', $permalink));

			return view('fontend.product.category', [
				'breadcrumb' => $breadcrumb,
				'og_site_name' => $og_site_name,
				'og_keywords' => $og_keywords,
				'og_title' => $og_title,
				'og_description' => $og_description,
				'og_url' => $og_url,
				'og_image' => $og_image,
				'page_name' => $page_name,
				'page_detail' => $page_detail,
				'data' => $data,
			]);
		}
		
        
    }
	
    public function product($permalink)
    {

        $setting                    = TbSetting::first();
        $settingInstallment         = TbSettingInstallment::where('installment_show', 1)->get();
        $settingPayment             = TbSettingPayment::with('tb_product_condition')->select('installment_status', 'conditionId')->first();
        $settingCondition           = $this->getCondition($settingPayment);
        $quotationSetting           = TbQuotationSetting::value('show');

        $breadcrumb                 = $this->checkProductBreadcrumb($permalink);
        $products                   = TbProduct::select('id', 'pro_name', 'pro_keyword', 'pro_seo_detail', 'pro_permalink', 'pro_option', 'pro_related')
            ->where('pro_show', 1)
            ->where('pro_permalink', $permalink)
            ->first();
        // title share
        if (!empty($products->pro_name)) {
            $og_site_name = $products->pro_name;
        } else {
            $og_site_name = "ไม่พบข้อมูล";
        }
        if (!empty($products->pro_name)) {
            $og_title = $products->pro_name;
        } else {
            $og_title = $og_site_name = "ไม่พบข้อมูล";
        }
        if (!empty($products->pro_keyword)) {
            $og_keywords = $products->pro_keyword;
        } else {
            $og_keywords = "ไม่พบข้อมูล";
        }
        if (!empty($products->pro_seo_detail)) {
            $og_description = $products->pro_seo_detail;
        } else {
            $og_description = "ไม่พบข้อมูล";
        }
        if (!empty($products)) {
            $og_image = $this->getproductCover($products->id);
        } else {
            $og_image = "";
        }
        if (!empty($permalink)) {
            $og_url = route('fronend.product.content', $permalink);
        } else {
            $og_url = route('fronend.home');
        }


        $data = $this->getProduct($permalink);

        if (!empty($data)) {
			
			// ล้าง Font Family
			$data['pro_highlight'] = $data['pro_highlight'] ? $this->removeFontFamilyStyles($data['pro_highlight']) : null;
			$data['pro_content'] = $data['pro_content'] ? $this->removeFontFamilyStyles($data['pro_content']) : null;
			//$data['pro_specification'] = $data['pro_specification'] ? $this->removeFontFamilyStyles($data['pro_specification']) : null;
			$data['pro_feature'] = $data['pro_feature'] ? $this->removeFontFamilyStyles($data['pro_feature']) : null;
			$data['pro_gift'] = $data['pro_feature'] ? $this->removeFontFamilyStyles($data['pro_gift']) : null;

			$rating = Review::selectRaw('COUNT(id) as count_review,
										SUM(rating) as sum_rating,
										AVG(rating) as avg_rating,
										SUM(CASE WHEN rating = 5 THEN 1 ELSE 0 END) as count_5,
										SUM(CASE WHEN rating = 4 THEN 1 ELSE 0 END) as count_4,
										SUM(CASE WHEN rating = 3 THEN 1 ELSE 0 END) as count_3,
										SUM(CASE WHEN rating = 2 THEN 1 ELSE 0 END) as count_2,
										SUM(CASE WHEN rating = 1 THEN 1 ELSE 0 END) as count_1')
						->where('review_approved', 'approved')
						->where('product_id', $products->id)
						->first();
						
			$reviews = Review::select('reviews.*','users.name','users.lastname')
						->join('users', 'reviews.user_id', '=', 'users.id')
						->where('review_approved', 'approved')
						->where('product_id', $products->id)
						->orderBy('created_at', 'desc')
						->paginate(5);
						
			if (request()->ajax()) {
				return response()->json([
					'html' => view('fontend.product.partials.reviews', compact('reviews'))->render()
				]);
			}

            if ($products->pro_option == 1) {

                return view('fontend.product.mainOne', [
                    'breadcrumb' => $breadcrumb,
                    'og_site_name' => $og_site_name,
                    'og_keywords' => $og_keywords,
                    'og_title' => $og_title,
                    'og_description' => $og_description,
                    'og_url' => $og_url,
                    'og_image' => $og_image,
                    'page_name' => $og_site_name,
                    'data' => $data,
                    'settingPayment' => $settingPayment,
                    'settingInstallment' => $settingInstallment,
                    'settingCondition' => $settingCondition,
                    'quotationSetting' => $quotationSetting,
                    'rating' => $rating,
					'reviews' => $reviews
                ]);
            } else {
				
				$arr_sku_stock = array();
				if(!empty($data['proDetail'])){
					$line = 0;
					foreach($data['proDetail'] as $prodetial){
						$arr_sku_stock[$line]['sku'] = $prodetial['sku'];
						$arr_sku_stock[$line]['detail_check_stock_status'] = $prodetial['detail_check_stock_status'];
						$arr_sku_stock[$line]['detail_stock'] = $prodetial['detail_stock'];
						
						$arr_sku_stock[$line]['min_order'] = !empty($prodetial['min_order']) ? (int)$prodetial['min_order'] : null;
						$arr_sku_stock[$line]['max_order'] = !empty($prodetial['max_order']) ? (int)$prodetial['max_order'] : null;

						$line++;
					}
				}

                return view('fontend.product.mainTwo', [
                    'breadcrumb' => $breadcrumb,
                    'og_site_name' => $og_site_name,
                    'og_keywords' => $og_keywords,
                    'og_title' => $og_title,
                    'og_description' => $og_description,
                    'og_url' => $og_url,
                    'og_image' => $og_image,
                    'page_name' => $og_site_name,
                    'data' => $data,
                    'settingPayment' => $settingPayment,
                    'settingInstallment' => $settingInstallment,
                    'settingCondition' => $settingCondition,
                    'quotationSetting' => $quotationSetting,
                    'arr_sku_stock' => $arr_sku_stock,
                    'rating' => $rating,
					'reviews' => $reviews
                ]);
            }
        } else {
			
			return Redirect::to('/');
			/*
            return view('fontend.product.mainOne', [
                'breadcrumb' => $breadcrumb,
                'og_site_name' => $og_site_name,
                'og_keywords' => $og_keywords,
                'og_title' => $og_title,
                'og_description' => $og_description,
                'og_url' => $og_url,
                'og_image' => $og_image,
                'page_name' => $og_site_name,
                'data' => $data,
                'settingPayment' => $settingPayment,
                'settingInstallment' => $settingInstallment,
                'settingCondition' => $settingCondition,
                'optionSelect' => '',
                'quotationSetting' => $quotationSetting,
            ]);
			*/
        }
    }
    public function productJson($permalink)
{
    $products = TbProduct::select('id', 'pro_name', 'pro_option')
        ->where('pro_show', 1)
        ->where('pro_permalink', $permalink)
        ->first();

    if (empty($products)) {
        return response()->json(['message' => 'ไม่พบสินค้า'], 404);
    }

    $data = $this->getProduct($permalink);

    if (empty($data)) {
        return response()->json(['message' => 'ไม่พบสินค้า'], 404);
    }

    $data['pro_highlight'] = $data['pro_highlight'] ? $this->removeFontFamilyStyles($data['pro_highlight']) : null;
    $data['pro_content']   = $data['pro_content'] ? $this->removeFontFamilyStyles($data['pro_content']) : null;
    $data['pro_feature']   = $data['pro_feature'] ? $this->removeFontFamilyStyles($data['pro_feature']) : null;

    $rating = Review::selectRaw('COUNT(id) as count_review, AVG(rating) as avg_rating')
        ->where('review_approved', 'approved')
        ->where('product_id', $products->id)
        ->first();

    return response()->json([
        'product' => $data,
        'rating'  => $rating,
    ]);
}

    /* ================================================ product */

    /* ================================================ article */
    
    private function getArticleCategories()
    {
        $keywords = TbArticle::where('art_show', 1)
            ->whereNotNull('art_keyword')
            ->where('art_keyword', '!=', '')
            ->pluck('art_keyword');

        $all = [];
        foreach ($keywords as $k) {
            foreach (explode(',', $k) as $tag) {
                $tag = trim($tag);
                if ($tag !== '') {
                    $all[$tag] = true;
                }
            }
        }

        $tags = array_keys($all);
        sort($tags);

        return array_slice($tags, 0, 10); // เอาแค่ 10 tag แรก กันปุ่มเยอะเกินไป
    }

     public function articleIndex()
    {
 
        $setting = TbSetting::first();
        $articles = TbArticle::select('art_name', 'art_parmalink', 'art_seo_detail', 'art_thumb', 'art_show', 'created_at')->where('art_show', 1)->orderBy('created_at', 'desc')->paginate(8);
        $article_randoms = TbArticle::select('art_name', 'art_parmalink', 'art_thumb', 'art_show')->where('art_show', 1)->inRandomOrder()->limit(5)->get();
        $categories = $this->getArticleCategories();
 
        // [ใหม่] หมวดหมู่คงที่ (art_cat) แยกต่างหากจาก keyword tag ด้านบน
        $artCats = ['ข่าวสาร', 'Tips & Tricks'];
        $activeCat = null;
 
        $breadcrumb = [
            ['route' => route('fronend.home'), 'name' => 'หน้าหลัก'],
            ['route' => '', 'name' => 'ข่าวสารด้านซอฟต์แวร์และรีวิว']
        ];
 
        //title share
        if (!empty($setting->setting_nameWeb)) {
            $og_site_name = $setting->setting_nameWeb;
        } else {
            $og_site_name = "";
        }
        if (!empty($setting->setting_keyword)) {
            $og_keywords = $setting->setting_keyword;
        } else {
            $og_keywords = "";
        }
        if (!empty($setting->setting_detail)) {
            $og_description = $setting->setting_detail;
        } else {
            $og_description = "";
        }
        if (!empty($setting->setting_coverShare)) {
            $og_image = asset('storage/setting/' . $setting->setting_coverShare);
        } else {
            $og_image = "";
        }
 
        return view('fontend.article.main', [
            'breadcrumb' => $breadcrumb,
            'og_site_name' => 'ข่าวสารด้านซอฟต์แวร์และรีวิว',
            'og_keywords' => $og_keywords,
            'og_title' => 'ข่าวสารด้านซอฟต์แวร์และรีวิว',
            'og_description' => $og_description,
            'og_url' => route('fronend.article.main'),
            'og_image' => $og_image,
            'articles' => $articles,
            'article_randoms' => $article_randoms,
            'categories' => $categories,
            'activeTag' => null,
            'artCats' => $artCats,
            'activeCat' => $activeCat,
        ]);
    }

     public function articleSearch(Request $request)
    {
 
        $setting = TbSetting::first();
        $articles = TbArticle::select('art_name', 'art_keyword', 'art_parmalink', 'art_seo_detail', 'art_thumb', 'art_show', 'created_at')
            ->where('art_name', 'LIKE', '%' . $request->search_artlicle . '%')
            ->where('art_keyword', 'LIKE', '%' . $request->search_artlicle . '%')
            ->where('art_show', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(8);
        $article_randoms = TbArticle::select('art_name', 'art_parmalink', 'art_thumb', 'art_show')->where('art_show', 1)->inRandomOrder()->limit(5)->get();
        $categories = $this->getArticleCategories();
 
        // [ใหม่] หมวดหมู่คงที่ (art_cat) แยกต่างหากจาก keyword tag ด้านบน
        $artCats = ['ข่าวสาร', 'Tips & Tricks'];
        $activeCat = null;
 
        $breadcrumb = [
            ['route' => route('fronend.home'), 'name' => 'หน้าหลัก'],
            ['route' => '', 'name' => 'ข่าวสารด้านซอฟต์แวร์และรีวิว']
        ];
 
        //title share
        if (!empty($setting->setting_nameWeb)) {
            $og_site_name = $setting->setting_nameWeb;
        } else {
            $og_site_name = "";
        }
        if (!empty($setting->setting_keyword)) {
            $og_keywords = $setting->setting_keyword;
        } else {
            $og_keywords = "";
        }
        if (!empty($setting->setting_detail)) {
            $og_description = $setting->setting_detail;
        } else {
            $og_description = "";
        }
        if (!empty($setting->setting_coverShare)) {
            $og_image = asset('storage/setting/' . $setting->setting_coverShare);
        } else {
            $og_image = "";
        }
 
        return view('fontend.article.main', [
            'breadcrumb' => $breadcrumb,
            'og_site_name' => 'ข่าวสารด้านซอฟต์แวร์และรีวิว',
            'og_keywords' => $og_keywords,
            'og_title' => 'ข่าวสารด้านซอฟต์แวร์และรีวิว',
            'og_description' => $og_description,
            'og_url' => route('fronend.article.main'),
            'og_image' => $og_image,
            'articles' => $articles,
            'article_randoms' => $article_randoms,
            'categories' => $categories,
            'activeTag' => null,
            'artCats' => $artCats,
            'activeCat' => $activeCat,
        ]);
    }

    public function articleSearchtag(Request $request, $search)
    {
 
        $setting = TbSetting::first();
        $articles = TbArticle::select('art_name', 'art_keyword', 'art_parmalink', 'art_seo_detail', 'art_thumb', 'art_show', 'created_at')
            ->where('art_name', 'LIKE', '%' . $search . '%')
            ->where('art_keyword', 'LIKE', '%' . $search . '%')
            ->where('art_show', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(8);
        $article_randoms = TbArticle::select('art_name', 'art_parmalink', 'art_thumb', 'art_show')->where('art_show', 1)->inRandomOrder()->limit(5)->get();
        $categories = $this->getArticleCategories();
 
        // [ใหม่] หมวดหมู่คงที่ (art_cat) แยกต่างหากจาก keyword tag ด้านบน
        // route นี้เป็นตัวกรอง Keyword (activeTag) ไม่ใช่ตัวกรอง category ดังนั้น activeCat = null เสมอ
        $artCats = ['ข่าวสาร', 'Tips & Tricks'];
        $activeCat = null;
 
        $breadcrumb = [
            ['route' => route('fronend.home'), 'name' => 'หน้าหลัก'],
            ['route' => '', 'name' => 'ข่าวสารด้านซอฟต์แวร์และรีวิว']
        ];
 
        //title share
        if (!empty($setting->setting_nameWeb)) {
            $og_site_name = $setting->setting_nameWeb;
        } else {
            $og_site_name = "";
        }
        if (!empty($setting->setting_keyword)) {
            $og_keywords = $setting->setting_keyword;
        } else {
            $og_keywords = "";
        }
        if (!empty($setting->setting_detail)) {
            $og_description = $setting->setting_detail;
        } else {
            $og_description = "";
        }
        if (!empty($setting->setting_coverShare)) {
            $og_image = asset('storage/setting/' . $setting->setting_coverShare);
        } else {
            $og_image = "";
        }
 
        return view('fontend.article.main', [
            'breadcrumb' => $breadcrumb,
            'og_site_name' => 'ข่าวสารด้านซอฟต์แวร์และรีวิว',
            'og_keywords' => $og_keywords,
            'og_title' => 'ข่าวสารด้านซอฟต์แวร์และรีวิว',
            'og_description' => $og_description,
            'og_url' => route('fronend.article.main'),
            'og_image' => $og_image,
            'articles' => $articles,
            'article_randoms' => $article_randoms,
            'categories' => $categories,
            'activeTag' => $search,
            'artCats' => $artCats,
            'activeCat' => $activeCat,
        ]);
    }
    public function articleCategory(Request $request, $cat)
    {
 
        $setting = TbSetting::first();
        $articles = TbArticle::select('art_name', 'art_cat', 'art_parmalink', 'art_seo_detail', 'art_thumb', 'art_show', 'created_at')
            ->where('art_cat', $cat)
            ->where('art_show', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(8);
        $article_randoms = TbArticle::select('art_name', 'art_parmalink', 'art_thumb', 'art_show')->where('art_show', 1)->inRandomOrder()->limit(5)->get();
        $categories = $this->getArticleCategories();
 
        $artCats = ['ข่าวสาร', 'Tips & Tricks'];
        $activeCat = $cat;
 
        $breadcrumb = [
            ['route' => route('fronend.home'), 'name' => 'หน้าหลัก'],
            ['route' => '', 'name' => 'ข่าวสารด้านซอฟต์แวร์และรีวิว']
        ];
 
        //title share
        if (!empty($setting->setting_nameWeb)) {
            $og_site_name = $setting->setting_nameWeb;
        } else {
            $og_site_name = "";
        }
        if (!empty($setting->setting_keyword)) {
            $og_keywords = $setting->setting_keyword;
        } else {
            $og_keywords = "";
        }
        if (!empty($setting->setting_detail)) {
            $og_description = $setting->setting_detail;
        } else {
            $og_description = "";
        }
        if (!empty($setting->setting_coverShare)) {
            $og_image = asset('storage/setting/' . $setting->setting_coverShare);
        } else {
            $og_image = "";
        }
 
        return view('fontend.article.main', [
            'breadcrumb' => $breadcrumb,
            'og_site_name' => 'ข่าวสารด้านซอฟต์แวร์และรีวิว',
            'og_keywords' => $og_keywords,
            'og_title' => 'ข่าวสารด้านซอฟต์แวร์และรีวิว',
            'og_description' => $og_description,
            'og_url' => route('fronend.article.main'),
            'og_image' => $og_image,
            'articles' => $articles,
            'article_randoms' => $article_randoms,
            'categories' => $categories,
            'activeTag' => null,
            'artCats' => $artCats,
            'activeCat' => $activeCat,
        ]);
    }

    public function articleContent($permalink)
    {

        $setting = TbSetting::first();
        $articles = TbArticle::select('tb_article.*', 'users.displayname')->leftJoin('users', 'users.id', '=', 'tb_article.user_id')->where('tb_article.art_parmalink', $permalink)->where('tb_article.art_show', 1)->orderBy('tb_article.created_at', 'desc')->first();
        $article_randoms = TbArticle::select('art_name', 'art_parmalink', 'art_thumb', 'art_show')->where('art_show', 1)->inRandomOrder()->limit(5)->get();

        if (!empty($articles)) {
            $this->update_view($permalink);
        }

        $breadcrumb = [
            ['route' => route('fronend.home'), 'name' => 'หน้าหลัก'],
            ['route' => route('fronend.article.main'), 'name' => 'ข่าวสารด้านซอฟต์แวร์และรีวิว'],
        ];

        //title share
        if (!empty($articles->art_name)) {
            $og_site_name = $articles->art_name;
        } else {
            $og_site_name = "ข่าวสารด้านซอฟต์แวร์และรีวิว";
        }
        if (!empty($articles->art_name)) {
            $og_title = $articles->art_name;
        } else {
            $og_title = "ข่าวสารด้านซอฟต์แวร์และรีวิว";
        }
        if (!empty($articles->art_keyword)) {
            $og_keywords = $articles->art_keyword;
        } else {
            $og_keywords = "";
        }
        if (!empty($articles->art_seo_detail)) {
            $og_description = $articles->art_seo_detail;
        } else {
            $og_description = "";
        }
        if (!empty($articles->art_thumb)) {
            $og_image = asset('storage/article/' . $articles->art_thumb);
        } else {
            $og_image = asset('storage/setting/' . $setting->setting_coverShare);
        }
        if (!empty($articles)) {
            $og_url = route('fronend.article.content', $permalink);
        } else {
            $og_url = route('fronend.article.main');
        }
		
		$articles->art_detail = $this->removeFontFamilyStyles($articles->art_detail);

        return view('fontend.article.form', [
            'breadcrumb' => $breadcrumb,
            'og_site_name' => $og_site_name,
            'og_keywords' => $og_keywords,
            'og_title' => $og_title,
            'og_description' => $og_description,
            'og_url' => $og_url,
            'og_image' => $og_image,
            'articles' => $articles,
            'article_randoms' => $article_randoms,
        ]);
    }

    private function update_view($parmalink)
    {

        $item                   = TbArticle::select('id', 'art_view', 'art_parmalink', 'art_show')->where('art_parmalink', $parmalink)->where('art_show', 1)->first();

        $data                   = TbArticle::findOrfail($item->id);
        $data->art_view         = $item->art_view + 1;
        $data->save();
    }
    /* ================================================ end article */

    private function getTutorialCategories()
{
    $keywords = TbTutorial::where('tut_show', 1)
        ->whereNotNull('tut_keyword')
        ->where('tut_keyword', '!=', '')
        ->pluck('tut_keyword');
 
    $all = [];
    foreach ($keywords as $k) {
        foreach (explode(',', $k) as $tag) {
            $tag = trim($tag);
            if ($tag !== '') {
                $all[$tag] = true;
            }
        }
    }
 
    $tags = array_keys($all);
    sort($tags);
 
    return array_slice($tags, 0, 10);
}
 
private function getTutorialProgressMap($tutorialIds)
{
    if (empty($tutorialIds)) {
        return [];
    }
 
    $rows = TbTutorialProgress::where('user_id', Auth::user()->id)
        ->whereIn('tutorialId', $tutorialIds)
        ->get();
 
    $map = [];
    foreach ($rows as $row) {
        $map[$row->tutorialId] = [
            'percent' => $row->percent,
            'completed' => $row->completed,
        ];
    }
    return $map;
}
 
public function tutorialIndex()
{
    $setting = TbSetting::first();
    $tutorials = TbTutorial::select('id', 'tut_name', 'tut_parmalink', 'tut_seo_detail', 'tut_thumb', 'tut_duration', 'tut_show', 'tut_group', 'tut_sort_order', 'created_at')
        ->where('tut_show', 1)
        ->when(request('group'), function($query) {
            $query->where('tut_group', request('group'));
        })
        ->orderBy('tut_group')
        ->orderBy('tut_sort_order')
        ->paginate(9);
    $categories = $this->getTutorialCategories();
 
    $tutorialIds = collect($tutorials->items())->pluck('id')->toArray();
    $progressMap = $this->getTutorialProgressMap($tutorialIds);
 
    // วิดีโอ "ดูต่อจากเดิม" — เอาอันที่ดูล่าสุดและยังไม่จบ
    $continueRow = TbTutorialProgress::where('user_id', Auth::user()->id)
        ->where('completed', 0)
        ->where('percent', '>', 0)
        ->orderBy('last_watched_at', 'desc')
        ->first();
 
    $continueTutorial = null;
    if (!empty($continueRow)) {
        $continueTutorial = TbTutorial::where('id', $continueRow->tutorialId)->where('tut_show', 1)->first();
    }
 
    $breadcrumb = [
        ['route' => route('fronend.home'), 'name' => 'หน้าหลัก'],
        ['route' => '', 'name' => 'Tutorial']
    ];
 
    if (!empty($setting->setting_nameWeb)) { $og_site_name = $setting->setting_nameWeb; } else { $og_site_name = ""; }
    if (!empty($setting->setting_keyword)) { $og_keywords = $setting->setting_keyword; } else { $og_keywords = ""; }
    if (!empty($setting->setting_detail)) { $og_description = $setting->setting_detail; } else { $og_description = ""; }
    if (!empty($setting->setting_coverShare)) { $og_image = asset('storage/setting/' . $setting->setting_coverShare); } else { $og_image = ""; }
 
    return view('fontend.tutorial.main', [
        'breadcrumb' => $breadcrumb,
        'og_site_name' => 'Tutorial',
        'og_keywords' => $og_keywords,
        'og_title' => 'วิดีโอ Tutorial',
        'og_description' => $og_description,
        'og_url' => route('fronend.tutorial.main'),
        'og_image' => $og_image,
        'tutorials' => $tutorials,
        'categories' => $categories,
        'activeTag' => null,
        'progressMap' => $progressMap,
        'continueTutorial' => $continueTutorial,
        'continueRow' => $continueRow,
    ]);
}
 
public function tutorialSearchtag(Request $request, $search)
{
    $setting = TbSetting::first();
    $tutorials = TbTutorial::select('id', 'tut_name', 'tut_keyword', 'tut_parmalink', 'tut_seo_detail', 'tut_thumb', 'tut_duration', 'tut_show', 'created_at')
        ->where('tut_name', 'LIKE', '%' . $search . '%')
        ->orWhere('tut_keyword', 'LIKE', '%' . $search . '%')
        ->where('tut_show', 1)
        ->orderBy('created_at', 'desc')
        ->paginate(9);
    $categories = $this->getTutorialCategories();
 
    $tutorialIds = collect($tutorials->items())->pluck('id')->toArray();
    $progressMap = $this->getTutorialProgressMap($tutorialIds);
 
    $breadcrumb = [
        ['route' => route('fronend.home'), 'name' => 'หน้าหลัก'],
        ['route' => '', 'name' => 'Tutorial']
    ];
 
    if (!empty($setting->setting_nameWeb)) { $og_site_name = $setting->setting_nameWeb; } else { $og_site_name = ""; }
    if (!empty($setting->setting_keyword)) { $og_keywords = $setting->setting_keyword; } else { $og_keywords = ""; }
    if (!empty($setting->setting_detail)) { $og_description = $setting->setting_detail; } else { $og_description = ""; }
    if (!empty($setting->setting_coverShare)) { $og_image = asset('storage/setting/' . $setting->setting_coverShare); } else { $og_image = ""; }
 
    return view('fontend.tutorial.main', [
        'breadcrumb' => $breadcrumb,
        'og_site_name' => 'Tutorial',
        'og_keywords' => $og_keywords,
        'og_title' => 'วิดีโอ Tutorial',
        'og_description' => $og_description,
        'og_url' => route('fronend.tutorial.main'),
        'og_image' => $og_image,
        'tutorials' => $tutorials,
        'categories' => $categories,
        'activeTag' => $search,
        'progressMap' => $progressMap,
        'continueTutorial' => null,
        'continueRow' => null,
    ]);
}
 
public function tutorialContent($permalink)
{
    $setting = TbSetting::first();
    $tutorial = TbTutorial::where('tut_parmalink', $permalink)->where('tut_show', 1)->first();
 
    if (!empty($tutorial)) {
        $tutorial->tut_view = $tutorial->tut_view + 1;
        $tutorial->save();
    }
 
    $progress = null;
    if (!empty($tutorial)) {
        $progress = TbTutorialProgress::where('user_id', Auth::user()->id)
            ->where('tutorialId', $tutorial->id)
            ->first();
    }
 
    $breadcrumb = [
        ['route' => route('fronend.home'), 'name' => 'หน้าหลัก'],
        ['route' => route('fronend.tutorial.main'), 'name' => 'Tutorial'],
    ];
 
    if (!empty($tutorial->tut_name)) { $og_title = $tutorial->tut_name; } else { $og_title = "Tutorial"; }
    if (!empty($tutorial->tut_keyword)) { $og_keywords = $tutorial->tut_keyword; } else { $og_keywords = ""; }
    if (!empty($tutorial->tut_seo_detail)) { $og_description = $tutorial->tut_seo_detail; } else { $og_description = ""; }
    if (!empty($tutorial->tut_thumb)) {
        $og_image = asset('storage/tutorial/' . $tutorial->tut_thumb);
    } else {
        $og_image = asset('storage/setting/' . $setting->setting_coverShare);
    }
    if (!empty($tutorial)) {
        $og_url = route('fronend.tutorial.content', $permalink);
    } else {
        $og_url = route('fronend.tutorial.main');
    }
 
    return view('fontend.tutorial.form', [
        'breadcrumb' => $breadcrumb,
        'og_site_name' => $og_title,
        'og_keywords' => $og_keywords,
        'og_title' => $og_title,
        'og_description' => $og_description,
        'og_url' => $og_url,
        'og_image' => $og_image,
        'tutorial' => $tutorial,
        'progress' => $progress,
    ]);
}
 
public function tutorialProgressSave(Request $request)
{
    $tutorial = TbTutorial::findOrFail($request->tutorialId);
 
    $progress = TbTutorialProgress::where('user_id', Auth::user()->id)
        ->where('tutorialId', $tutorial->id)
        ->first();
 
    if (empty($progress)) {
        $progress = new TbTutorialProgress;
        $progress->user_id = Auth::user()->id;
        $progress->tutorialId = $tutorial->id;
        $progress->created_at = date('Y-m-d H:i:s');
    }
 
    $progress->watched_seconds = $request->watched_seconds;
    $progress->duration_seconds = $request->duration_seconds;
    $percent = $request->duration_seconds > 0 ? intval(($request->watched_seconds / $request->duration_seconds) * 100) : 0;
    $progress->percent = min($percent, 100);
    $progress->completed = $progress->percent >= 90 ? 1 : 0;
    $progress->last_watched_at = date('Y-m-d H:i:s');
    $progress->updated_at = date('Y-m-d H:i:s');
    $progress->save();
 
    return response()->json(['status' => 'ok', 'percent' => $progress->percent]);
}
 
/* ================================================ end tutorial */

    public function jsonDetail(Request $request)
    {

        $detailId = $request->detailId;

        if (!empty($categoryId)) {
            $response = TbProduct::select(
                'tb_product.id',
                'tb_product.pro_codition',
                'tb_product.pro_permalink',
                'tb_product.pro_highlight',
                'tb_product.pro_download',
                'tb_product.pro_content',
                'tb_product.pro_feature',
                'tb_product.pro_gift',
                'tb_product_detail.id',
                'tb_product_detail.proId',
                'tb_product_detail.detail_sku',
                'tb_product_detail.detail_name',
                'tb_product_detail.detail_other',
                'tb_product_detail.detail_status',
                'tb_product_detail.detail_preorder_day',
                'tb_product_detail.detail_product_weight',
                'tb_product_detail.detail_product_wide',
                'tb_product_detail.detail_product_long',
                'tb_product_detail.detail_product_high',
                'tb_product_detail.detail_product_contact_sale_status',
                'tb_product_detail.detail_price',
                'tb_product_detail.detail_price_sale_status',
                'tb_product_detail.detail_price_sale',
                'tb_product_detail.detail_price_sale_status_date',
                'tb_product_detail.detail_sale_date_start',
                'tb_product_detail.detail_sale_date_end',
                'tb_product_detail.detail_show',
                'tb_product_detail.min_order',
                'tb_product_detail.max_order',
                'tb_product_status.id',
                'tb_product_status.stu_name',
                'tb_product_status.stu_preorder',
                'tb_product_status.stu_color',
                'tb_brand.id',
                'tb_brand.brand_name',
                'tb_product_picture.proId',
                'tb_product_picture.picture_status',
                'tb_product_picture.picture_name',
            )
                ->leftjoin('tb_product_detail', 'tb_product_detail.proId', 'tb_product.id')
                ->leftjoin('tb_brand', 'tb_brand.id', 'tb_product.pro_brand')
                ->leftjoin('tb_product_status', 'tb_product_status.id', 'tb_product_detail.detail_status')
                ->leftjoin('tb_product_picture', 'tb_product_picture.proId', 'tb_product.id')
                ->where('tb_product_picture.picture_status', 1)
                ->where('tb_product.pro_show', 1)
                ->where('tb_product_detail.id', $detailId)
                ->first();
            if (!empty($response)) {
                return response()->json($response);
            } else {
                return 'false';
            }
        } else {
            return 'false';
        }
    }

    public function emailtemplate($link)
    {

        $data = TbPromotionEmailtemplate::where('email_link', $link)->where('show', 1)->first();

        if (!empty($data)) {
            return view('fontend.emailtemplate', [
                'data' => $data,
            ]);
        } else {
            return redirect('/');
        }
    }

    /* ================================================ quotation */

    private function checkAuth()
    {

        if (!empty(Auth::user()->id)) {
            return Auth::user()->id;
        } else {
            return null;
        }
    }

    private function getUserAddress()
    {

        if (!empty(Auth::user()->id)) {

            $user = User::select('user_type', 'id', 'email', 'name', 'lastname', 'level', 'staffId', 'tel', 'company_name')->findOrFail(Auth::user()->id);
            $address = UsersAddressReceipt::where('userId', Auth::user()->id)->first();

            if (!empty($address)) {

                $response = array(
                    'userType' => $user->user_type,
                    'userName' => $user->name,
                    'userLastname' => $user->lastname,
                    'userCompany' => $address->company,
                    'userTax' => $address->taxid,
                    'userAddress' => $address->address,
                    'userDistrict' => $address->district,
                    'userAmphures' => $address->amphures,
                    'userProvince' => $address->province,
                    'userZipcode' => $address->zipcode,
                    'userEmail' => $user->email,
                    'userTel' => $address->tel,
                    'userLevel' => $user->level,
                    'userStaffId' => $user->staffId,
                    'userTelMain' => $user->tel,
                    'userCompanyMain' => $user->company_name,
                );
            } else {

                $response = array(
                    'userType' => $user->user_type,
                    'userName' => $user->name,
                    'userLastname' => $user->lastname,
                    'userCompany' => $user->company_name,
                    'userTax' => $user->taxid,
                    'userAddress' => null,
                    'userDistrict' => null,
                    'userAmphures' => null,
                    'userProvince' => null,
                    'userZipcode' => null,
                    'userEmail' => $user->email,
                    'userTel' => $user->tel,
                    'userLevel' => $user->level,
                    'userStaffId' => $user->staffId,
                    'userTelMain' => $user->tel,
                    'userCompanyMain' => $user->company_name,
                );
            }
        } else {

            $response = null;
        }

        return $response;
    }

    private function getProductQuotation($proId, $sku, $unit)
	{
		if (!empty($proId) && !empty($sku)) {

			$product = TbProduct::where('pro_show', 1)->findOrFail($proId);
			if (!empty($product)) {

				$detail = TbProductDetail::where('proId', $proId)
					->where('detail_sku', $sku)
					->where('detail_show', 1)
					->first();

				if (!empty($detail)) {
					$response = array(
						'id' => $product->id,
						'name' => $product->pro_name,
						'sku' => $detail->detail_sku,
						'vendor_sku' => $detail->vendor_sku, // ✅ เพิ่ม
						'unit' => $unit,
						'image' => $this->getproductCover($product->id),
						'detail_name' => $detail->detail_name,
						'detail_other' => $detail->detail_other,
						'detailPrice' => $detail->detail_price,
						'detailPriceSale' => check_price_product_sale_on_quotation_page($detail->id),
						'brand' => $this->getBrand($product->pro_brand),
					);
				} else {
					$response = null;
				}
			} else {
				$response = null;
			}

		} else if (!empty($proId)) {

			$product = TbProduct::where('pro_show', 1)->findOrFail($proId);
			if (!empty($product)) {

				$detail = TbProductDetail::where('proId', $proId)
					->where('detail_show', 1)
					->first();

				if (!empty($detail)) {
					$response = array(
						'id' => $product->id,
						'name' => $product->pro_name,
						'sku' => $detail->detail_sku,
						'vendor_sku' => $detail->vendor_sku, // ✅ เพิ่ม
						'unit' => 1,
						'image' => $this->getproductCover($product->id),
						'detail_name' => $detail->detail_name,
						'detail_other' => $detail->detail_other,
						'detailPrice' => $detail->detail_price,
						'detailPriceSale' => check_price_product_sale_on_quotation_page($detail->id),
						'brand' => $this->getBrand($product->pro_brand),
					);
				} else {
					$response = null;
				}
			} else {
				$response = null;
			}

		} else {
			$response = null;
		}

		return $response;
	}

    private function getQuotation($proId, $sku, $unit)
    {

        $response = array(
            'userId' => $this->checkAuth(),
            'userAddress' => $this->getUserAddress(),
            'productDetail' => $this->getProductQuotation($proId, $sku, $unit),
        );

        return $response;
    }
	
	public function quotation(Request $request)
    {

        $proId          = $request->productId;
        $sku            = $request->productSku;
        $unit           = $request->productUnit;

        $setting        = TbSetting::first();
        $settingUser    = TbSettingUser::first();
        $extension      = TbExtension::first();
        $provinces      = TbSettingProvince::get();
        $data           = $this->getQuotation($proId, $sku, $unit);

        $breadcrumb = [
            ['route' => route('fronend.home'), 'name' => 'หน้าหลัก'],
            ['route' => '', 'name' => 'ขอใบเสนอราคา'],
        ];

        //title share
        if (!empty($page_name)) {
            $og_site_name = 'ขอใบเสนอราคา';
        } else {
            $og_site_name = 'ขอใบเสนอราคา';
        }
        if (!empty($page_name)) {
            $og_title = 'ขอใบเสนอราคา';
        } else {
            $og_title = $og_site_name = 'ขอใบเสนอราคา';
        }
        if (!empty($setting->setting_keyword)) {
            $og_keywords = $setting->setting_keyword;
        } else {
            $og_keywords = "";
        }
        if (!empty($setting->setting_detail)) {
            $og_description = $setting->setting_detail;
        } else {
            $og_description = "";
        }
        if (!empty($setting->setting_coverShare)) {
            $og_image = asset('storage/setting/' . $setting->setting_coverShare);
        } else {
            $og_image = asset('storage/setting/' . $setting->setting_coverShare);
        }
        if (!empty($page)) {
            $og_url = route('fronend.quotation');
        } else {
            $og_url = route('fronend.home');
        }

        return view('fontend.quotation.main', [
            'breadcrumb' => $breadcrumb,
            'og_site_name' => $og_site_name,
            'og_keywords' => $og_keywords,
            'og_title' => $og_title,
            'og_description' => $og_description,
            'og_url' => $og_url,
            'og_image' => $og_image,
            'settingUser' => $settingUser,
            'extension' => $extension,
            'provinces' => $provinces,
            'data' => $data,
        ]);
    }
	
    public function quotationCrmPreview($id, $crm)
    {

        $setting            = TbSetting::select('setting_iconWeb', 'setting_nameWeb', 'setting_logoWeb')->first();
        $extension          = TbExtension::first();
        $quotation_notify   = TbQuotation::findOrFail($id);
        $provinces          = TbSettingProvince::where('id', $quotation_notify->province)->value('prov_name_th');
        $amphoes            = TbSettingAmphure::where('id', $quotation_notify->amphures)->value('amp_name_th');
        $district           = TbSettingDistrict::where('id', $quotation_notify->district)->value('dis_name_th');
        $historyquotation   = Historyquotation::where('quotationId', $quotation_notify->id)->value('name_file');
        return view('fontend.quotationCrmPreview', [
            'setting'           => $setting,
            'extension'         => $extension,
            'quotation_notify'  => $quotation_notify,
            'crm'               => $crm,
            'provinces'         => $provinces,
            'amphoes'           => $amphoes,
            'district'          => $district,
            'historyquotation'  => $historyquotation,
        ]);
    }

	public function quotationCrate(Request $request)
    {
 
        $request->validate(
            [
                'fullname' => 'required|max:255',
                'company' => 'max:255',
				'tax' => 'nullable|max:255|required_if:type,2',
				'email' => 'required|email|max:255',
                'tel' => 'required|max:255',
                'address' => 'required|max:255',
                'province' => 'required',
                'amphures' => 'required',
                'district' => 'required',
                'zipcode' => 'required|max:255',
            ],
            [
                'fullname.required' => 'กรุณากรอกข้อมูล',
                'company.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
				'tax.required_if' => 'กรุณากรอกเลขประจำตัวผู้เสียภาษี (บังคับสำหรับนิติบุคคล)',
				'tax.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
				'email.required' => 'กรุณากรอกข้อมูล',
                'email.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'email.email' => 'รูปแบบอีเมลไม่ถูกต้องกรุณาตรวจสอบข้อมูล',
                'tel.required' => 'กรุณากรอกข้อมูล',
                'tel.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'address.required' => 'กรุณากรอกข้อมูล',
                'address.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'province.required' => 'กรุณาเลือกข้อมูล',
                'amphures.required' => 'กรุณาเลือกข้อมูล',
                'district.required' => 'กรุณาเลือกข้อมูล',
                'zipcode.required' => 'กรุณากรอกข้อมูล',
                'zipcode.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
            ]
        );
		
		# Block Bot
		if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($request['g-recaptcha-response'])) {
			
			// Build POST request:
			$recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
			$recaptcha_secret = env('RECAPTCHA_SECRET_KEY');
			$recaptcha_response = $request['g-recaptcha-response'];
 
			// Make and decode POST request:
			$recaptcha = file_get_contents($recaptcha_url.'?secret='.$recaptcha_secret.'&response='.$recaptcha_response);
			$recaptcha = json_decode($recaptcha);
 
			// Take action based on the score returned:
			if (!empty($recaptcha->success)) {
    // Verified
} else {
    \Log::info('reCAPTCHA failed in quotationCrate', ['recaptcha_response' => $recaptcha]);
    return back()->withErrors(['recaptcha' => 'ยืนยันตัวตนไม่สำเร็จ กรุณาลองใหม่อีกครั้ง'])->withInput();
}
		}else{
    \Log::info('reCAPTCHA missing g-recaptcha-response field entirely in quotationCrate');
    return back()->withErrors(['recaptcha' => 'กรุณายืนยันตัวตน (ติ๊กช่อง reCAPTCHA) ก่อนส่งข้อมูล'])->withInput();
}
 
        if (!empty($data['pdpa_wording']) == 1) {
            $pdpa_news = '1';
            $pdpa_article = '1';
            $pdpa_product = '1';
        } else {
            $pdpa_news = '2';
            $pdpa_article = '2';
            $pdpa_product = '2';
        }
 
        $date = date('Y-m-d');
        $setting_Q = TbQuotationSetting::select('company_vat', 'company_withheld')->first();
 
        $data = new TbQuotation;
        $data->quotationNumber              = 'WEB'.$this->generateQuotationCode();
        if (!empty(Auth::user()->id)) {
            $data->user_code                = Auth::user()->user_code;
            $data->userId                   = Auth::user()->id;
        } else {
            $data->user_code                = $this->generateRandomString(10);
        }
        $data->staffId                      = $this->check_staff_IN_user();
        $data->quotationDate                = $date;
        $data->quotationDateExp             = null;
        $data->type                         = $request->type;
        if (!empty($setting_Q)) {
            if ($request->type == 1) {
                $data->productTax               = 0;
                $data->productVat               = $setting_Q->company_vat;
            } else {
                $data->productTax               = $setting_Q->company_withheld;
                $data->productVat               = $setting_Q->company_vat;
            }
        }
        if($request->ref != ''){
			$data->ref           			= $request->ref;
		}else{
			$data->ref           			= null;
		}
		
		$fullname = trim(preg_replace('/\s+/', ' ', $request->fullname));
		$parts = explode(' ', $fullname);
 
		if (count($parts) > 1) {
			$lastname = array_pop($parts);
			$firstname = implode(' ', $parts);
		} else {
			$firstname = $fullname;
			$lastname = '';
		}
		
        $data->name                         = $firstname;
        $data->lastname                     = $lastname;
        $data->company                      = $request->company;
		$data->tax                          = $request->tax;
		$data->email                        = $request->email;
        $data->tel                          = $request->tel;
        $data->address                      = $request->address;
        $data->province                     = $request->province;
        $data->amphures                     = $request->amphures;
        $data->district                     = $request->district;
        $data->zipcode                      = $request->zipcode;
        
 
		$count_digital_product = 0;
        if (!empty($request->productPrice)) {
 
            $data->message                  = $request->message;
            if (!empty($request->productImg)) {
                $data->productImg           = $request->productImg;
            }
            if (!empty($request->productSku)) {
                $data->productSku           = $request->productSku;
				
				# เช็คว่ามาจาก แบรนด์สินค้าที่ขายโดย ทีม ดิจิตอล MI มั้ย
				$brand_digital = '50,1,24';	// 3DConnexions , BASF
				$brand_digital = explode(',',$brand_digital);
				
				$count_digital_product = TbProduct::leftjoin('tb_product_detail','tb_product.id','tb_product_detail.proId')
													->leftjoin('tb_brand','tb_brand.id','tb_product.pro_brand')
													->where('tb_product_detail.detail_sku',$data->productSku)
													->where('tb_brand.for_digital_team',1)
													->groupBy('tb_product.id')
													->count();
				$count_3dx_product = TbProduct::leftjoin('tb_product_detail','tb_product.id','tb_product_detail.proId')
													->leftjoin('tb_brand','tb_brand.id','tb_product.pro_brand')
													->where('tb_product_detail.detail_sku',$data->productSku)
													->where('tb_brand.for_3dx_team',1)
													->groupBy('tb_product.id')
													->count();
				
            }
 
            // ✅ เพิ่มแค่ตรงนี้
            if (!empty($request->productVendorSku)) {
                $data->productVendorSku     = $request->productVendorSku;
            }
 
            if (!empty($request->productName)) {
                $data->productName          = $request->productName;
            }
            if (!empty($request->productDetail)) {
                $data->productDetail        = $request->productDetail;
            }
            if (!empty($request->productPrice)) {
                $data->productPrice         = $request->productPrice;
            }
            if (!empty($request->productPricesale)) {
                $data->productPricesale     = $request->productPricesale;
            }
            if (!empty($request->productUnit)) {
                $data->productUnit          = $request->productUnit;
            }
            if (!empty($request->productPrice)) {
                if (!empty($request->productPricesale)) {
                    $data->productTotal     = $request->productPricesale * $request->productUnit;
                } else {
                    $data->productTotal     = $request->productPrice * $request->productUnit;
                }
            }
        } else {
            if (!empty($request->productName)) {
                $data->message              = 'สนใจสินค้า SKU: ' . $request->productSku . ' ชื่อสินค้า: ' . $request->productName . ' จำนวน ' . $request->productUnit;
            } else {
                $data->message              = $request->message;
            }
        }
 
        $data->pdpa_news                    = $pdpa_news;
        $data->pdpa_article                 = $pdpa_article;
        $data->pdpa_product                 = $pdpa_product;
        $data->created_by                   = $request->fullname;
        $data->created_at                   = date('Y-m-d H:i:s');
        $data->save();
 
        //add to crm
        $provinces      = TbSettingProvince::select('prov_name_th','prov_name_en')->where('id', $request->province)->first();
        $amphoes        = TbSettingAmphure::select('amp_name_th','amp_name_en')->where('id', $request->amphures)->first();
        $district       = TbSettingDistrict::select('dis_name_th','dis_name_en')->where('id', $request->district)->first();
		
		$campaignid = '32';	// Campaigns : Request_Quotation_PTCAD (ยืนยันแล้ว 17 ส.ค. 2026)
        
        $firstname      = $firstname;
        $lastname       = $lastname;
        $email          = $request->email;
        $company        = $request->company;
        $mobile         = $request->tel;
        $lane           = $request->address . ',' . $district->dis_name_en;
        $city         	= $amphoes->amp_name_en;
        $cf_650         = $provinces->prov_name_en;
        $code           = $request->zipcode;
        $designation    = '-';
        $department     = '-';
        $industry       = '-';
 
        if (!empty($request->tax)) {
            $tax_id     = 'เลขประจำตัวผู้เสียภาษี : ' . $request->tax . ' / ';
        } else {
            $tax_id     = 'เลขประจำตัวผู้เสียภาษี : - / ';
        }
 
        if ($request->message != "") {
            $messengerQuo   = $request->message;
        } else {
            $messengerQuo   = '';
        }
 
        $checkStaff_Noty = $this->check_staff_IN_user_CrateTo_Quotatioon();
        if (!empty($checkStaff_Noty)) {
            $staffNoti = 'ผู้รับผิดชอบ : ' . $checkStaff_Noty;
        } else {
            $staffNoti = 'ยังไม่มีผู้รับผิดชอบ';
        }
 
        if (!empty($request->productPrice)) {
            $messenger2     = '';
            //gen pdf
            $pdfId = $this->generatePDF($data->id);
 
            //ตัวแปร CRM
            if ($request->message != "") {
				$messengerQuo	= 'สนใจสินค้า SKU: ' . $request->productSku . ' ชื่อสินค้า: ' . $request->productName . ' จำนวน ' . $request->productUnit . ' / '.$request->message;
            } else {
				$messengerQuo	= 'สนใจสินค้า SKU: ' . $request->productSku . ' ชื่อสินค้า: ' . $request->productName . ' จำนวน ' . $request->productUnit;
            }
            //$dowload            = ' * หมายเหตุ : ให้ติดต่อกลับ';
            $description        = $tax_id.$messengerQuo.', 
			- https://phpstack-1646968-6541058.cloudwaysapps.com/setting/quotation/preview/'.$data->id;
 
            // [ปิดใช้งาน — เปลี่ยนไปใช้ Lead API ตัวใหม่แทน 2026-08-11]
            // $idcrm           = $this->crateCRM($campaignid, $firstname, $lastname, $email, $company, $mobile, $lane, $code, $cf_650, $designation, $department, $industry, $description, $city);
            $idcrm              = $this->sendToLeadApi($campaignid, $firstname, $lastname, $email, $company, $mobile, $lane, $code, $cf_650, $description, $city);
 
            // line notify
            $extension = TbExtension::first();
            $quotation_notify = TbQuotation::findOrFail($data->id);
 
            // link เอกสาร pdf
            $quotation          = Historyquotation::where('quotationId', $quotation_notify->id)->first();
            $linkpdf            = asset('storage/pdfQuotation/' . $quotation->name_file);
 
            if ($quotation_notify->quotation_type == 2) {
                $type = 'บริษัท/สำนักงาน/องค์กร';
            } else {
                $type = 'บุคคลธรรมดา';
            }
			
			$this->sendQuotationForUser($data->id);
			
            session()->flash('quotation_confirm_id', $data->id);
			return redirect()->route('fronend.quotation.status'); // URL สะอาด ไม่มีพารามิเตอร์
			
        } else {
			
			//gen pdf
            $pdfId = $this->generatePDF($data->id);
			
            $messenger2     = ' สนใจสินค้า SKU: ' . $request->productSku . ' ชื่อสินค้า: ' . $request->productName . ' จำนวน ' . $request->productUnit . ' / ';
            $description    = $tax_id.$messengerQuo . $messenger2.', 
			- https://phpstack-1646968-6541058.cloudwaysapps.com/setting/quotation/preview/'.$data->id;
 
            // [ปิดใช้งาน — เปลี่ยนไปใช้ Lead API ตัวใหม่แทน 2026-08-11]
            // $idcrm      = $this->crateCRM($campaignid, $firstname, $lastname, $email, $company, $mobile, $lane, $code, $cf_650, $designation, $department, $industry, $description, $city);
            $idcrm          = $this->sendToLeadApi($campaignid, $firstname, $lastname, $email, $company, $mobile, $lane, $code, $cf_650, $description, $city);
			
			$quotation_notify = TbQuotation::findOrFail($data->id);
			
			$this->sendQuotationForUser($data->id);
			
            session()->flash('quotation_confirm_id', $data->id);
			return redirect()->route('fronend.quotation.status'); // URL สะอาด ไม่มีพารามิเตอร์
        }
		
    }

    public function quotationStatus()
	{
		$setting     = TbSetting::first();
		$quotationId = session()->pull('quotation_confirm_id');
		$quotation   = $quotationId ? TbQuotation::find($quotationId) : null;

		$fileUrl = null;
		$hasFile = false;

		if ($quotation) {
			$fileHistory = HistoryQuotation::where('quotationId', $quotationId)->first();

			if ($fileHistory && !empty($fileHistory->name_file)) {
				$filename   = basename($fileHistory->name_file);
				$publicPath = public_path("storage/pdfQuotation/{$filename}");

				if (is_file($publicPath) && is_readable($publicPath) && filesize($publicPath) > 0) {
					$fileUrl = asset("storage/pdfQuotation/{$filename}");
					$hasFile = true;
				}
			}
		}

		$breadcrumb     = [
			['route' => route('fronend.home'), 'name' => 'หน้าหลัก'],
			['route' => '', 'name' => 'ขอใบเสนอราคา'],
		];
		$og_site_name   = 'ขอใบเสนอราคา';
		$og_title       = 'ขอใบเสนอราคา';
		$og_keywords    = $setting->setting_keyword ?? '';
		$og_description = $setting->setting_detail ?? '';
		$og_image       = asset('storage/setting/' . ($setting->setting_coverShare ?? ''));
		$og_url         = $quotation ? route('fronend.quotation') : route('fronend.home');

		return view('fontend.quotation.status', compact(
			'breadcrumb','og_site_name','og_keywords','og_title','og_description','og_url','og_image',
			'quotation','fileUrl','hasFile'
		));
	}

    private function generatePDF($id)
    {
        //ตั้งค่าใบเสนอราคา
        $quotationsetting = TbQuotationSetting::first();
        $dateToday        = date('d-m-Y');

        //ข้อมูลใบเสนอราคา
        $data           = TbQuotation::findOrFail($id);
        $provinces      = TbSettingProvince::where('id', $data->province)->value('prov_name_th');
        $amphoes        = TbSettingAmphure::where('id', $data->amphures)->value('amp_name_th');
        $district       = TbSettingDistrict::where('id', $data->district)->value('dis_name_th');

        $dateExp                    = TbQuotation::findOrfail($id);
        $dateExp->quotationDateExp  = date("Y-m-d", strtotime("+7 day", strtotime($dateToday)));
        $dateExp->save();

        //อัพเดตชื่อไฟล์ PDF
        $nampPdf                    = new HistoryQuotation;
        $nampPdf->name_file         = $data->quotationNumber . '.pdf';
        $nampPdf->year              = date('Y');
        if (!empty(Auth::user()->id)) {
            $nampPdf->userId        = Auth::user()->id;
        }
        $nampPdf->quotationId       = $id;
        $nampPdf->save();

        PDF::loadView('fontend.quotation.pdfview', [
            'items' => $data,
            'quotationsetting' => $quotationsetting,
            'provinces' => $provinces,
            'amphoes' => $amphoes,
            'district' => $district
        ])->save('storage/pdfQuotation/' . $data->quotationNumber . '.pdf');

        return $nampPdf->id;
    }

    private function check_staff_IN_user()
    {
        if (!empty(Auth::user()->id)) {
            $user = User::select('id', 'staffId')->findOrFail(Auth::user()->id);

            if (!empty($user->staffId)) {

                $response = $user->staffId;
            } else {
                $response = NULL;
            }
        } else {
            $response = NULL;
        }

        return $response;
    }

    private function check_staff_IN_user_CrateTo_Quotatioon()
    {

        if (!empty(Auth::user()->id)) {
            $user = User::select('id', 'staffId', 'name', 'lastname')->findOrFail(Auth::user()->id);

            if (!empty($user->staffId)) {
                $staff = User::select('id', 'staffId', 'name', 'lastname')->where('id', $user->staffId)->first();
                $response = $staff->name . ' ' . $staff->lastname;
            } else {
                $response = NULL;
            }
        } else {
            $response = NULL;
        }

        return $response;
    }
    /**
     * ยิง Lead ไปที่ Lead API ตัวใหม่ (แทนที่ crateCRM() เดิม)
     * ใช้ Backend Secret แทน reCAPTCHA เพราะ Laravel เช็ค reCAPTCHA ไปแล้วก่อนหน้านี้
     * คืนค่า Lead ID (ตัวเลขล้วน ไม่มี tabid นำหน้า) เพื่อให้ใช้แทน $idcrm เดิมได้
     */
    private function sendToLeadApi($campaignid, $firstname, $lastname, $email, $company, $mobile, $lane, $zipcode, $province, $description, $city)
    {
        try {
            $leadApiUrl    = env('LEAD_API_URL');
            $leadApiKey    = env('LEAD_API_KEY');
            $backendSecret = env('LEAD_API_BACKEND_SECRET');

            if (empty($leadApiUrl) || empty($leadApiKey)) {
                \Log::info('[quotationCrate] Lead API skipped — LEAD_API_URL/LEAD_API_KEY not set in .env');
                return null;
            }

            $payload = [
    'lastname'        => $lastname !== '' ? $lastname : $firstname,
    'firstname'       => $firstname,
    'email'           => $email,
    'phone'           => $mobile,
    'mobile'          => $mobile,
    'company'         => $company,
    'lane'            => $lane,
    'city'            => $city,
    'zip'             => $zipcode,
    'country'         => 'Thailand',
    'description'     => $description,
    'leadsource'      => 'Web Site',
    'recaptcha_token' => 'backend-trusted',
];

// ใส่ campaign_id เฉพาะตอนที่ผู้เรียกส่งค่ามาจริง (ไม่ใช่ null)
// เช่น quotationCrate() ส่ง 32 มา, crateHelp() (Help Ticket) ส่ง null มา = ไม่ผูก Campaign ใดๆ
if (!empty($campaignid)) {
    $payload['campaign_id'] = $campaignid;
}

            $response = Http::timeout(10)
                ->retry(2, 500)
                ->withHeaders([
                    'Content-Type'     => 'application/json',
                    'X-API-Key'        => $leadApiKey,
                    'X-Backend-Secret' => $backendSecret,
                ])
                ->post($leadApiUrl, $payload);

            if ($response->successful()) {
                $body   = $response->json();
                $leadId = $body['lead']['id'] ?? null;
                if ($leadId && str_contains($leadId, 'x')) {
                    return explode('x', $leadId)[1];
                }
                return $leadId;
            }

            \Log::error('[quotationCrate] Lead API failed: ' . $response->body());
            return null;

        } catch (\Exception $e) {
            \Log::error('[quotationCrate] Lead API exception: ' . $e->getMessage());
            return null;
        }
    }


    /* ================================================ end quotation */

    public function forgotPassword($id, $code)
    {

        $user = User::where('user_code', $code)->findOrFail($id);
        $setting = TbSetting::first();

        if ($user == "") {
            return redirect()->route('register');
        } else {

            return view('fontend.forgotMail', [
                'user' => $user,
                'setting' => $setting,
            ]);
        }
    }

    public function forgotPasswordUpdate(Request $request, $id)
    {

        $request->validate(
            [
                'password' => ['required', 'min:8', 'confirmed'],
            ],
            [
                'password.required' => 'กรุณากรอกข้อมูล',
                'password.min' => 'รหัสผ่านต้องไม่น้อยกว่า 8 ตัวอักษร',
                'password.confirmed' => 'รหัสผ่านไม่ตรงกัน กรุณาตรวจสอบข้อมูล',
            ]
        );


        if ($id == "") {
            return redirect()->route('register');
        } else {

            $user                          = User::findOrFail($id);
            $user->password                = Hash::make($request->password);
            $user->updated_at              = date('Y-m-d H:i:s');
            $user->save();

            return back()->with('feedback', 'ปลี่ยนรหัสผ่านใหม่เรียบร้อยแล้ว!! ลองเข้าสู่ระบบอีกครั้ง');
        }
    }

    public function forgotPasswordUser()
    {

        $setting = TbSetting::first();
        $articles = TbArticle::select('art_name', 'art_parmalink', 'art_seo_detail', 'art_thumb', 'art_show', 'created_at')->where('art_show', 1)->orderBy('created_at', 'desc')->paginate(8);
        $article_randoms = TbArticle::select('art_name', 'art_parmalink', 'art_thumb', 'art_show')->where('art_show', 1)->inRandomOrder()->limit(5)->get();


        //title share
        if (!empty($setting->setting_nameWeb)) {
            $og_site_name = $setting->setting_nameWeb;
        } else {
            $og_site_name = "";
        }
        if (!empty($setting->setting_keyword)) {
            $og_keywords = $setting->setting_keyword;
        } else {
            $og_keywords = "";
        }
        if (!empty($setting->setting_detail)) {
            $og_description = $setting->setting_detail;
        } else {
            $og_description = "";
        }
        if (!empty($setting->setting_coverShare)) {
            $og_image = asset('storage/setting/' . $setting->setting_coverShare);
        } else {
            $og_image = "";
        }

        return view('fontend.forgotPasswordUser', [
            'og_site_name' => 'ลืมรหัสผ่าน',
            'og_keywords' => $og_keywords,
            'og_title' => 'ลืมรหัสผ่าน',
            'og_description' => $og_description,
            'og_url' => route('fronend.forgotpassword'),
            'og_image' => $og_image,
            'articles' => $articles,
            'article_randoms' => $article_randoms,
        ]);
    }

    public function forgotPasswordSendMail(Request $request)
    {

        $request->validate(
            [
                'email' => ['required', 'max:255', 'email', new userCheckMail],
            ],
            [
                'email.required' => 'กรุณากรอกข้อมูลอีเมล',
                'email.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'email.email' => 'รูปแบบอีเมลไม่ถูกต้องกรุณาตรวจสอบอีกครั้ง',
            ]
        );

        $user = User::where('email', $request->email)->first();

        $statusMail = $this->forgotPasswordUserSendmail($user->id);

        if ($statusMail != 'สำเร็จ') {
            //return back()->with('feedback-er', $statusMail);
            return back()->with('feedback-er', 'ส่งอีเมลไม่สำเร็จ!! กรุณาลองใหม่อีกครั้ง!');
        } else {
            return redirect()->route('fronend.forgotpassword.sent');
        }
    }
    public function forgotPasswordSent()
{
    $setting = TbSetting::first();

    return view('fontend.forgotPasswordSent', [
        'og_site_name' => 'ส่งอีเมลสำเร็จ',
        'og_title' => 'ส่งอีเมลสำเร็จ',
        'og_keywords' => !empty($setting->setting_keyword) ? $setting->setting_keyword : '',
        'og_description' => !empty($setting->setting_detail) ? $setting->setting_detail : '',
        'og_url' => route('fronend.forgotpassword'),
        'og_image' => !empty($setting->setting_coverShare) ? asset('storage/setting/'.$setting->setting_coverShare) : '',
    ]);
}

    public function previewPromotion($id)
    {

        $setting            = TbSetting::select('setting_iconWeb', 'setting_nameWeb', 'setting_logoWeb')->first();
        $promotion          = TbPromotionCalendar::where('promo_show', 1)->findOrFail($id);
        return view('fontend.promotionPreview', [
            'setting'           => $setting,
            'promotion'         => $promotion,
        ]);
    }

    public function pageRedirect()
    {

        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $actual_link = strtolower(str_replace('www', "", $actual_link));
        $redirect = TbPagesRedirect::select('redirect_old', 'redirect_new')->orWhere('redirect_old', 'LIKE', '%' . $actual_link . '%')->first();

        if (!empty($redirect)) {

            return redirect($redirect->redirect_new);
        }
    }

    public function listOnepage($parmalink)
    {

        $data           = TbPromotionOnepage::where('parmalink', $parmalink)->first();

        if (!empty($data)) {

            $setting        = TbSetting::first();
            $customcode     = TbCustomcode::count();
            $extension      = TbExtension::first();
            $settingForm    = TbPromotionOnepagesForm::orderBy('sort', 'asc')->get();
            $settingPage    = TbPromotionOnepagesSetting::first();
            $settingSection = TbPromotionOnepagesSection::orderBy('sort', 'asc')->get();
            $settingBanner  = TbPromotionOnepagesSection::where('section', 'banner')->where('show', 1)->first();
            $settingFooter  = TbPromotionOnepagesSection::where('section', 'footer')->where('show', 1)->first();
            $settingTab     = TbPromotionOnepagesSection::where('section', 'tab')->where('show', 1)->first();
            $settingMenu    = TbPromotionOnepagesMenu::where('onepageId', $data->id)->where('show', 1)->first();
            $settingSort    = TbPromotionOnepagesSort::where('onepageId', $data->id)->orderBy('sort', 'asc')->get();

            if (!empty($data->og_image)) {
                $og_image = asset('storage/onepages/' . $data->og_image);
            } else {
                $og_image = asset('storage/setting/' . $setting->setting_coverShare);
            }
            return view('layouts.temp_onepage', [
                'data' => $data,
                'setting' => $setting,
                'customcode' => $customcode,
                'extension' => $extension,
                'parmalink' => $parmalink,
                'og_image' => $og_image,
                'settingForm' => $settingForm,
                'settingPage' => $settingPage,
                'settingSection' => $settingSection,
                'settingBanner' => $settingBanner,
                'settingFooter' => $settingFooter,
                'settingMenu' => $settingMenu,
                'settingTab' => $settingTab,
                'settingSort' => $settingSort,
            ]);
        } else {
            return redirect('/');
        }
    }

    private function forgotPasswordUserSendmail($id)
    {

        $user = User::findOrFail($id);
        $setting = TbSetting::first();
        $page = TbPagesMap::first();

        $data = new \stdClass();
        $data->page                     = $page;
        $data->setting_nameWeb          = $setting->setting_nameWeb;
        $data->setting_logoWeb          = $setting->setting_logoWeb;
        $data->id                       =  $user->id;
        $data->user_code                = $user->user_code;
        $data->sender                   = 'กู้รหัสผ่านบัญชีผู้ใช้ ' . $setting->setting_nameWeb . ' ของคุณ';

		try{
			Mail::to($user->email)->later(now()->addMinutes(5), new forgotMail($data));		

			if (Mail::failures()) {
				$mailStatus = 'ล้มเหลว';
			} else {
				$mailStatus = 'สำเร็จ';
			}
		}catch(\Exception $e){
			// Never reached
			$mailStatus = 'ล้มเหลว';
		}        

        $history                            = new HistorySendMail();
        $history->userId                    = $user->id;
        $history->remark                    = "ลืมรหัสผ่าน";
        $history->status                    = $mailStatus;
        $history->created_by                = 'SYSTEM';
        $history->created_at                = date('Y-m-d H:i:s');
        $history->updated_at                = date('Y-m-d H:i:s');
        $history->save();

        return $mailStatus;
    }

    private function crateCRM($campaignid, $firstname, $lastname, $email, $company, $mobile, $lane, $code, $cf_650, $designation, $department, $industry, $description, $city)
    {

        $checkemail     = false;
        // true : ใน Campaign นึงลงได้หลายครั้งแต่จะเก็บข้อมูลใว้ที่ ตาราง app_lead_registered_history
        $landingpage    = filter_input(INPUT_POST, 'landingpage') == 'false' ? true : false;
        $leadstatus     = 'Hot';
        // $leadfilter     = 'Junk';
        $leadfilter     = 'Qualified';

        /*เอาใว้ใส่ค่า - ให้อัตโนมัติหากไม่ได้ส่งค่ามา */
        $firstname      = $firstname ? $firstname : '-';
        $lastname       = $lastname ? $lastname : '-';
        $email          = $email ? $email : '-';
        $company        = $company ? $company : '-';
        $cf_650         = $cf_650 ? $cf_650 : '-';
        $mobile         = $mobile ? $mobile : '-';

        $urlreference   = filter_input(INPUT_POST, 'urlreference') ? filter_input(INPUT_POST, 'urlreference') : filter_input(INPUT_POST, 'urlreferent');

        //กำหนดค่า
        $params = array(
            'campaignid'        => $campaignid, //ID ของ Campaign
            'firstname'         => $firstname,
            'lastname'          => $lastname,
            'designation'       => $designation, //ตำแหน่ง
            'cf_805'            => $department, //แผนก
            'email'             => $email,
            'company'           => $company,
            'website'           => '-',
            'industry'          => $industry,
            'leadstatus'        => $leadstatus, //leadstatus
            'leadsource'        => 'Marketing Campaign', //leadsource
            'phone'             => '-',
            'mobile'            => $mobile,
            'fax'               => '-',
            'lane'              => $lane,
            'city'              => $city,
            'cf_650'            => $cf_650, //จังหวัด
            'code'              => $code,
            'country'           => '-',
            'message'         => $description,
            'cf_842'            => $leadfilter, //leads filter
            'cf_659'            => $urlreference, //Url reference
            //'assigned'          => '446', // กำหนด $assigned มาโดยตรงโดยไม่อิง Campaign
            'landingpage'       => $landingpage, //ใน Campaign นึงลงได้หลายครั้งแต่จะเก็บข้อมูลใว้ที่ ตาราง app_lead_registered_history
            'checkemail'        => $checkemail, //เชคอีเมลล์ซ้ำใน Campaigns, true = หากซ้ำไม่ให้ลงทะเบียน , false = ซ้ำลงทะเบียนได้
        );

        //ทำการสร้าง Leads
        $result = $this->createlead($params);
        // if(!empty($result)){
        if ($result[0] == true) {

            // ฟังค์ชั่น ส่งเมลล์ เซลล์
            // $result[19]

            return $result[24];
        } else {
            return false;
        }
        // }
        // return $result;

    }

    private function createlead($params = array())
    {
        // [Mock สำหรับโปรเจกต์จบ] เดิมยิง SOAP สร้าง Lead ไป CRM จริงของบริษัท
        // ฟังก์ชันนี้เป็น dead code (ไม่ถูกเรียกแล้ว เพราะ crateCRM() ถูกปิดใช้งานไปแล้ว)
        // mock ไว้เผื่ออ้างอิง ไม่ยิง request ออกไปจริง
        \Log::info('[Mock CRM] createlead called', $params);
        return [true, 'MOCK-LEAD-' . uniqid()];
    }

    private function TicketForUser($id)
    {

        $setting  = TbSetting::first();
        $page     = TbPagesMap::first();
        $historys = HistoryTicket::where('ticketId', $id)->get();


        if (count($historys) != 0) {
            foreach ($historys as $history) {

                $ticket = Ticket::where('id', $id)->first();

                if (!empty($ticket)) {
                    $ticketFile         = TicketFile::where('ticketId', $ticket->id)->get();

                    $data = new \stdClass();
                    $data->setting_nameWeb = $setting->setting_nameWeb;
                    $data->setting_logoWeb = $setting->setting_logoWeb;
                    $data->setting_email_bcc = $setting->setting_email_bcc;
                    $data->page            = $page;
                    $data->ticket          = $ticket;
                    $data->ticketFile      = $ticketFile;
                    $data->name            = $ticket->name;
                    $data->subject         = "[PTCAD] Ticket ID : " . $ticket->code;
                    $data->customer_email  = $ticket->email;

                    if (!empty($ticket->email)) {

                        $emailCustomer            = explode(",", $ticket->email);
                        $data->emailCustomer      = $emailCustomer;
						
						if(!empty($ticket->email_cc)){
							$emailCC            	  = explode(",", $ticket->email_cc);
							$data->emailCC      	  = $emailCC;
						}

                        $emailSupport             = explode(",", $setting->setting_email_support);
                        $data->emailSupport       = $emailSupport;

                        if (!empty($setting->setting_email_support)) {
							
							if(!empty($data->emailCC)){
								
								try{
									Mail::send('emails.TicketForUser', ['data' => $data], function ($m) use ($data) {
										$m->to($data->emailCustomer, $data->name)
											->cc($data->emailCC, $data->emailCC)
											->bcc($data->emailSupport, 'Support ' . $data->setting_nameWeb)
											->replyTo($data->emailSupport, $data->setting_nameWeb)
											->subject($data->subject);

										if (!empty($data->ticketFile)) {
											foreach ($data->ticketFile as $file) {
												$m->attach(asset('storage/ticket/' . $file->name));
											}
										}
									});
									
									if (Mail::failures()) {
										$status = 2;
										$mailStatus = 'ล้มเหลว';
									} else {
										$status = 1;
										$mailStatus = 'สำเร็จ';
									}
									
								}catch(\Exception $e){
									// Never reached
									$status = 2;
									$mailStatus = 'ล้มเหลว : '.$e->getMessage();
								}
								
							}else{
								
								try{
									Mail::send('emails.TicketForUser', ['data' => $data], function ($m) use ($data) {
										$m->to($data->emailCustomer, $data->name)
											->bcc($data->emailSupport, 'Support ' . $data->setting_nameWeb)
											->replyTo($data->emailSupport, $data->setting_nameWeb)
											->subject($data->subject);

										if (!empty($data->ticketFile)) {
											foreach ($data->ticketFile as $file) {
												$m->attach(asset('storage/ticket/' . $file->name));
											}
										}
									});
									
									if (Mail::failures()) {
										$status = 2;
										$mailStatus = 'ล้มเหลว';
									} else {
										$status = 1;
										$mailStatus = 'สำเร็จ';
									}
									
								}catch(\Exception $e){
									// Never reached
									$status = 2;
									$mailStatus = 'ล้มเหลว : '.$e->getMessage();
								}
								
							}
                            
                        } else {
							
							if(!empty($data->emailCC)){
								
								try{
									Mail::send('emails.TicketForUser', ['data' => $data], function ($m) use ($data) {
										$m->to($data->emailCustomer, $data->name)
											->cc($data->emailCC, $data->emailCC)
											->bcc($data->setting_email_bcc, 'Support ' . $data->setting_nameWeb)
											->replyTo($data->setting_email_bcc, $data->setting_nameWeb)
											->subject($data->subject);

										if (!empty($data->ticketFile)) {
											foreach ($data->ticketFile as $file) {
												$m->attach(asset('storage/ticket/' . $file->name));
											}
										}
									});
									
									if (Mail::failures()) {
										$status = 2;
										$mailStatus = 'ล้มเหลว';
									} else {
										$status = 1;
										$mailStatus = 'สำเร็จ';
									}
									
								}catch(\Exception $e){
									// Never reached
									$status = 2;
									$mailStatus = 'ล้มเหลว : '.$e->getMessage();
								}
								
							}else{
								
								try{
									Mail::send('emails.TicketForUser', ['data' => $data], function ($m) use ($data) {
										$m->to($data->emailCustomer, $data->name)
											->bcc($data->setting_email_bcc, 'Support ' . $data->setting_nameWeb)
											->replyTo($data->setting_email_bcc, $data->setting_nameWeb)
											->subject($data->subject);

										if (!empty($data->ticketFile)) {
											foreach ($data->ticketFile as $file) {
												$m->attach(asset('storage/ticket/' . $file->name));
											}
										}
									});
									
									if (Mail::failures()) {
										$status = 2;
										$mailStatus = 'ล้มเหลว';
									} else {
										$status = 1;
										$mailStatus = 'สำเร็จ';
									}
									
								}catch(\Exception $e){
									// Never reached
									$status = 2;
									$mailStatus = 'ล้มเหลว : '.$e->getMessage();
								}
								
							}
							
                        }
						
                        $history                            = HistoryTicket::findOrFail($history->id);
                        $history->mailStatus                = $status;
                        $history->mailRemark                = $mailStatus;
                        $history->updated_by                = $ticket->updated_by;
                        $history->created_at                = date('Y-m-d H:i:s');
                        $history->updated_at                = date('Y-m-d H:i:s');
                        $history->save();

                        return 'พบข้อมูล ' . count($historys) . ' รายการ <br/> สถานะ ' . $mailStatus;
                    }
                }
            }
        } else {
            return 'ไม่พบข้อมูล';
        }
    }

    //------------------------------------------  page->main
    private function recommendProductAndCategory()
    {

        $response = [];
        $TbRecommendProductCategory = TbRecommendProductCategory::select('option_type', 'categoryId', 'show', 'sort', 'thumb', 'recommend_product')
            ->where('show', 1)
            ->orderBy('sort', 'asc')
            ->get();

        foreach ($TbRecommendProductCategory as $data) {

            //select data
            if ($data->option_type == 1) {
                $categoryName = TbCategory::where('id', $data->categoryId)->value('category_name');
            } else {
                $categoryName = TbCategorySub::where('id', $data->categoryId)->value('categorysub_name');
            }

            //add data
            $response[] = array(
                'thumb' => asset('storage/recommendProduct/' . $data->thumb),
                'name' => $categoryName,
                'product' => $this->get_product_array($data->recommend_product),
            );
        }

        return $response;
    }

    private function get_product_array($productId)
    {

        if (!empty($productId)) {

            $recommend = explode(",", $productId);
            asort($recommend);
            $responsePro = [];

            foreach ($recommend as $key => $proId) {
                $product = TbProduct::select('tb_product.id', 'tb_product.pro_name', 'tb_product.pro_permalink', 'tb_product.pro_option', 'tb_brand.brand_name', 'tb_brand.brand_permalink')->leftjoin('tb_brand', 'tb_brand.id', 'tb_product.pro_brand')->where('tb_product.pro_show', 1)->where('tb_product.id', $proId)->first();

                if (!empty($product)) {
                    $responsePro[] = array(
                        'proId' => $product->id,
                        'pro_permalink' => $product->pro_permalink,
                        'cover' => $this->getproductCover($product->id),
                        'pro_name' => $product->pro_name,
                        'pro_option' => $product->pro_option,
                        'stu_display' => $this->getStatusDisplay($product->id),
                        'contact_sale' => $this->getproductContact($product->id),
                        'price' => check_price_product_on_category_page($product->id),
                        'brand_name' => $product->brand_name,
                        'brand_permalink' => $product->brand_permalink,
                    );
                }
            }

            return $responsePro;
        }
    }

    private function getStatusDisplay($proId)
    {

        $products = TbProductDetail::select(
            'tb_product_detail.id',
            'tb_product_detail.proId',
            'tb_product_detail.detail_status',
            'tb_product_status.id',
            'tb_product_status.stu_display',
        )
            ->leftjoin('tb_product_status', 'tb_product_status.id', 'tb_product_detail.detail_status')
            ->where('tb_product_detail.proId', $proId)
            ->where('tb_product_detail.detail_show', 1)
            ->orderBy('tb_product_detail.detail_name', 'asc')
            ->get();

        $data = [];
        foreach ($products as $product) {

            $data = $product->stu_display;
        }

        return $data;
    }

    private function getproductContact($proId)
    {

        $products = TbProductDetail::select(
            'tb_product_detail.id',
            'tb_product_detail.proId',
            'tb_product_detail.detail_product_contact_sale_status',
        )
            ->where('tb_product_detail.proId', $proId)
            ->where('tb_product_detail.detail_show', 1)
            ->orderBy('tb_product_detail.detail_name', 'asc')
            ->get();

        $data = [];
        foreach ($products as $product) {

            $data = $product->detail_product_contact_sale_status;
        }

        return $data;
    }

    private function recommendProduct()
    {

        $response = [];

        $data = TbRecommendProduct::select('id', 'recommend_name', 'recommend_product', 'show', 'sort')->where('show', 1)->orderBy('sort', 'desc')->get();
        foreach ($data as $recommend) {

            $response[] = array(
                'id' => $recommend->id,
                'name' => $recommend->recommend_name,
                'product' => $this->get_product_array($recommend->recommend_product)
            );
        }

        return $response;
    }
    //------------------------------------------  end page->main

    //------------------------------------------  category
    private function getCategory($permalink)
    {

        $check_category = TbCategory::select('category_permalink', 'category_show')->where('category_permalink', $permalink)->where('category_show', 1)->count();
        if ($check_category != 0) {
            //TbCategory
            $category = TbCategory::select('category_name', 'category_permalink', 'category_show')->where('category_permalink', $permalink)->where('category_show', 1)->first();
            $response = $category->category_name;
        } else {

            //เช็คว่าเป็น TbCategorySub หรือไม่
            $check_categorySub = TbCategorySub::select('categorysub_permalink', 'categorysub_show')->where('categorysub_permalink', $permalink)->where('categorysub_show', 1)->count();
            if ($check_categorySub != 0) {
                //TbCategorySub
                $categorySub = TbCategorySub::select('categorysub_name', 'categorysub_permalink', 'categorysub_show')->where('categorysub_permalink', $permalink)->where('categorysub_show', 1)->first();
                $response = $categorySub->categorysub_name;
            } else {
                //ไม่มีข้อมูล
                $response = $permalink;
            }
        }
        return $response;
    }
	
	private function getSubCategory($permalink){
		
		$check_category = TbCategory::select('category_permalink', 'category_show')->where('category_permalink', $permalink)->where('category_show', 1)->count();
		$response = array();
		if ($check_category != 0) {
            //TbCategory
            $category = TbCategory::select('id')->where('category_permalink', $permalink)->where('category_show', 1)->first();
            $categorySub = TbCategorySub::select('id','categorysub_name','categorysub_permalink')->where('category_id', $category->id)->where('categorysub_show', 1)->orderBy('categorysub_sort','DESC')->get();
			
			if(!empty($categorySub)){
				$response = $categorySub;
			}
		}

		return $response;
	}

    private function getCategoryDetail($permalink)
    {

        $check_category = TbCategory::select('category_permalink', 'category_show')->where('category_permalink', $permalink)->where('category_show', 1)->count();
        if ($check_category != 0) {
            //TbCategory
            $category = TbCategory::select('category_note', 'category_permalink', 'category_show')->where('category_permalink', $permalink)->where('category_show', 1)->first();
            $response = $category->category_note;
        } else {

            //เช็คว่าเป็น TbCategorySub หรือไม่
            $check_categorySub = TbCategorySub::select('categorysub_permalink', 'categorysub_show')->where('categorysub_permalink', $permalink)->where('categorysub_show', 1)->count();
            if ($check_categorySub != 0) {
                //TbCategorySub
                $categorySub = TbCategorySub::select('categorysub_note', 'categorysub_permalink', 'categorysub_show')->where('categorysub_permalink', $permalink)->where('categorysub_show', 1)->first();
                $response = $categorySub->categorysub_note;
            } else {
                //ไม่มีข้อมูล
                $response = $permalink;
            }
        }
        return $response;
    }
    //------------------------------------------  end category

    //------------------------------------------  product
    private function getproductSKU($proId)
    {

        $response = TbProductDetail::select('proId', 'detail_sku', 'detail_name')->where('proId', $proId)->orderBy('detail_name', 'asc')->value('detail_sku');

        return $response;
    }

    private function getproductCover($proId)
    {

        $setting = TbSetting::first();
        $picture = TbProductPicture::select('proId', 'picture_name')->where('picture_status', 1)->where('proId', $proId)->first();

        if (!empty($picture)) {
            $image = asset('storage/product/' . $picture->picture_name);
        } else {
            $image = asset('storage/setting/' . $setting->setting_coverShare);
        }

        return $image;
    }

    private function getproductImages($proId)
    {

        $response = [];
        $pictures = TbProductPicture::select('proId', 'picture_name')->where('picture_status', 2)->where('proId', $proId)->get();

        if (count($pictures) != 0) {
            foreach ($pictures as $pic) {
                $response[] = array(
                    'id' => $pic->id,
                    'images' => asset('storage/product/' . $pic->picture_name),
                );
            }
        }

        return $response;
    }

    private function getproductPriceStatus($proId)
    {

        $response = TbProductDetail::select('proId', 'detail_product_contact_sale_status')->where('proId', $proId)->value('detail_product_contact_sale_status');

        return $response;
    }

    private function getBrandProduct($brand)
    {

        $products = [];

        $items = TbProduct::where('pro_show', 1)->where('pro_brand', $brand)->orderBy('pro_name', 'ASC')->get();

        foreach ($items as $item) {

            $products[] = array(
                'id' => $item->id,
                'sku' => $this->getproductSKU($item->id),
                'name' => $item->pro_name,
                'permalink' => $item->pro_permalink,
                'option' => $item->pro_option,
                'pictureName' => $this->getproductCover($item->id),
                'priceStatus' => $this->getproductPriceStatus($item->id),
                'price' => check_price_product_on_category_page($item->id),
                'brand' => $this->getBrand($item->pro_brand),
                'brand_permalink' => $this->getBrandLink($item->pro_brand),
            );
        }

        return $products;
    }

    private function getCategoryProduct($permalink)
    {

        $products = [];
        $check_category = TbCategory::select('category_permalink', 'category_show')->where('category_permalink', $permalink)->where('category_show', 1)->count();
        if ($check_category != 0) {
            //TbCategory
            $category = TbCategory::select('id', 'category_name', 'category_permalink', 'category_show')->where('category_permalink', $permalink)->where('category_show', 1)->first();
            $items = TbProduct::where('pro_show', 1)->where('pro_catId', $category->id)->orderBy('pro_name', 'ASC')->get();

            foreach ($items as $item) {

                $products[] = array(
                    'id' => $item->id,
                    'sku' => $this->getproductSKU($item->id),
                    'name' => $item->pro_name,
                    'permalink' => $item->pro_permalink,
                    'option' => $item->pro_option,
                    'pictureName' => $this->getproductCover($item->id),
                    'priceStatus' => $this->getproductPriceStatus($item->id),
                    'price' => check_price_product_on_category_page($item->id),
					'brand' => $this->getBrand($item->pro_brand),
					'brand_permalink' => $this->getBrandLink($item->pro_brand),
                );
            }
        } else {

            // เช็คว่าเป็น TbCategorySub หรือไม่
            $check_categorySub = TbCategorySub::select('categorysub_permalink', 'categorysub_show')->where('categorysub_permalink', $permalink)->where('categorysub_show', 1)->count();
            if ($check_categorySub != 0) {
                //TbCategorySub
                $categorySub = TbCategorySub::select('id', 'categorysub_name', 'categorysub_permalink', 'categorysub_show')->where('categorysub_permalink', $permalink)->where('categorysub_show', 1)->first();
                $items = TbProduct::select(
                    'tb_product.id',
                    'tb_product.pro_catId',
                    'tb_product.pro_option',
                    'tb_product.pro_name',
                    'tb_product.pro_permalink',
                    'tb_product.pro_show',
                    'tb_product.pro_brand',
                    'tb_product_picture.proId',
                    'tb_product_picture.picture_name',
                    'tb_product_picture.picture_status'
                )
                    ->leftjoin('tb_product_picture', 'tb_product_picture.proId', 'tb_product.id')
                    ->where('tb_product_picture.picture_status', 1)
                    ->where('tb_product.pro_show', 1)
                    ->where('tb_product.pro_catsubId', $categorySub->id)
                    ->orderBy('tb_product.pro_name', 'ASC')
                    ->get();

                foreach ($items as $item) {

                    $products[] = array(
                        'id' => $item->id,
                        'sku' => $this->getproductSKU($item->id),
                        'name' => $item->pro_name,
                        'permalink' => $item->pro_permalink,
                        'option' => $item->pro_option,
                        'pictureName' => asset('storage/product/' . $item->picture_name),
                        'priceStatus' => $this->getproductPriceStatus($item->id),
                        'price' => check_price_product_on_category_page($item->id),
						'brand' => $this->getBrand($item->pro_brand),
						'brand_permalink' => $this->getBrandLink($item->pro_brand),
                    );
                }
            }
        }
        return $products;
    }
	
	private function getSaleProductAll()
    {

        $products = [];
        $check_category = TbCategory::select('category_show')->where('category_show', 1)->count();
        if ($check_category != 0) {
            //TbCategory
            //$items = TbProduct::where('pro_show', 1)->orderBy('pro_name', 'ASC')->get();
			
			$dateToday = date('Y-m-d');
			
			$items = TbProduct::select('tb_product.*')
								->leftJoin('tb_product_detail', 'tb_product_detail.proId', '=', 'tb_product.id')
								->where('tb_product.pro_show', 1)
								->where('tb_product_detail.detail_price_sale_status', 1)
								->where('tb_product_detail.detail_show', 1)
								->where(function ($query) use ($dateToday) {
									$query->whereRaw("DATE('$dateToday') BETWEEN STR_TO_DATE(tb_product_detail.detail_sale_date_start, '%d-%m-%Y') AND STR_TO_DATE(tb_product_detail.detail_sale_date_end, '%d-%m-%Y')")
										  ->orWhere('tb_product_detail.detail_price_sale_status_date', 2);
								})
								->groupBy('tb_product.id')
								->orderBy('tb_product.pro_name', 'ASC')
								->get();

            foreach ($items as $item) {

                $products[] = array(
                    'id' => $item->id,
                    'sku' => $this->getproductSKU($item->id),
                    'name' => $item->pro_name,
                    'permalink' => $item->pro_permalink,
                    'option' => $item->pro_option,
                    'pictureName' => $this->getproductCover($item->id),
                    'priceStatus' => $this->getproductPriceStatus($item->id),
                    'price' => check_price_product_on_category_page($item->id),
					'brand' => $this->getBrand($item->pro_brand),
					'brand_permalink' => $this->getBrandLink($item->pro_brand),
                );
            }
        }
        return $products;
    }
	
	private function getSaleProductSearch($start_date)
    {

        $products = [];
        $check_category = TbCategory::select('category_show')->where('category_show', 1)->count();
        if ($check_category != 0) {
            //TbCategory
            //$items = TbProduct::where('pro_show', 1)->orderBy('pro_name', 'ASC')->get();
			
			$items = TbProduct::select('tb_product.*')
				->leftjoin('tb_product_detail', 'tb_product_detail.proId', 'tb_product.id')
				->where('tb_product.pro_show', 1)
				->where(DB::raw('str_to_date(tb_product_detail.detail_sale_date_start, "%d-%m-%Y")'), '=', DB::raw('str_to_date("'.$start_date.'", "%d-%m-%Y")'))
				->where(DB::raw('str_to_date(tb_product_detail.detail_sale_date_end, "%d-%m-%Y")'), '>=', DB::raw('current_date'))
				->groupBy('tb_product.id')
				->orderBy('tb_product.pro_name', 'ASC')
				->get();

            foreach ($items as $item) {

                $products[] = array(
                    'id' => $item->id,
                    'sku' => $this->getproductSKU($item->id),
                    'name' => $item->pro_name,
                    'permalink' => $item->pro_permalink,
                    'option' => $item->pro_option,
                    'pictureName' => $this->getproductCover($item->id),
                    'priceStatus' => $this->getproductPriceStatus($item->id),
                    'price' => check_price_product_on_category_page($item->id),
					'brand' => $this->getBrand($item->pro_brand),
					'brand_permalink' => $this->getBrandLink($item->pro_brand),
                );
            }
        }
        return $products;
    }

    private function getCategoryProductAll()
    {

        $products = [];
        $check_category = TbCategory::select('category_show')->where('category_show', 1)->count();
        if ($check_category != 0) {
            //TbCategory
            $items = TbProduct::where('pro_show', 1)->orderBy('pro_name', 'ASC')->get();

            foreach ($items as $item) {

                $catName = '';
                if (!empty($item->pro_catId)) {
                    $catName = TbCategory::where('id', $item->pro_catId)->value('category_name');
                }

                $products[] = array(
                    'id' => $item->id,
                    'sku' => $this->getproductSKU($item->id),
                    'name' => $item->pro_name,
                    'permalink' => $item->pro_permalink,
                    'option' => $item->pro_option,
                    'pictureName' => $this->getproductCover($item->id),
                    'priceStatus' => $this->getproductPriceStatus($item->id),
                    'price' => check_price_product_on_category_page($item->id),
					'brand' => $this->getBrand($item->pro_brand),
					'brand_permalink' => $this->getBrandLink($item->pro_brand),
					'catId' => $item->pro_catId,
					'catName' => $catName,
                );
            }
        }
        return $products;
    }
	
	private function getMaterialProductAll()
    {

        $products = [];
		
		// Material All
		$items = TbProduct::where('pro_brand', 50)->orderBy('pro_name', 'ASC')->get();

		foreach ($items as $item) {

			$products[] = array(
				'id' => $item->id,
				'sku' => $this->getproductSKU($item->id),
				'name' => $item->pro_name,
				'permalink' => $item->pro_permalink,
				'option' => $item->pro_option,
				'pictureName' => $this->getproductCover($item->id),
				'priceStatus' => $this->getproductPriceStatus($item->id),
				'price' => check_price_product_on_category_page($item->id),
				'brand' => $this->getBrand($item->pro_brand),
				'brand_permalink' => $this->getBrandLink($item->pro_brand),
			);
		}
        return $products;
    }
	
	private function getMaList($arr_spec, $arr_machine)
    {

        $products = [];
				
		// Material
		if(!empty($arr_spec) && !empty($arr_machine)){
			
			$count_spec = count($arr_spec);
			if($count_spec > 1){
				$items = TbProduct::select('tb_product.id', 'tb_product.pro_name', 'tb_product.pro_permalink', 'tb_product.pro_option', 'tb_product.pro_brand')
								->leftjoin('tb_product_specification', 'tb_product.id', 'tb_product_specification.proId')
								->where('tb_product.pro_brand', 50)
								->where('tb_product_specification.spec_detail', 'Yes')
								->whereIn('tb_product_specification.spec_name', $arr_spec)
								->where(function ($query) use ($arr_machine) {
									foreach ($arr_machine as $ma) {
										// Loop over the search terms
										$query->Where('tb_product.pro_content', 'like', '%' . $ma . '%');
									}
								})
								->groupBy('tb_product.id')
								->having(DB::raw('count(tb_product.id)'), '=', $count_spec)
								->orderBy('pro_name', 'ASC')
								->get();
			}else{
				$items = TbProduct::select('tb_product.id', 'tb_product.pro_name', 'tb_product.pro_permalink', 'tb_product.pro_option', 'tb_product.pro_brand')
								->leftjoin('tb_product_specification', 'tb_product.id', 'tb_product_specification.proId')
								->where('tb_product.pro_brand', 50)
								->where('tb_product_specification.spec_detail', 'Yes')
								->whereIn('tb_product_specification.spec_name', $arr_spec)
								->where(function ($query) use ($arr_machine) {
									foreach ($arr_machine as $ma) {
										// Loop over the search terms
										$query->Where('tb_product.pro_content', 'like', '%' . $ma . '%');
									}
								})
								->groupBy('tb_product.id')
								->orderBy('pro_name', 'ASC')
								->get();
			}
			
		}else if(!empty($arr_machine)){
			
			$items = TbProduct::select('tb_product.id', 'tb_product.pro_name', 'tb_product.pro_permalink', 'tb_product.pro_option', 'tb_product.pro_brand')
								->leftjoin('tb_product_specification', 'tb_product.id', 'tb_product_specification.proId')
								->where('tb_product.pro_brand', 50)
								->where('tb_product_specification.spec_detail', 'Yes')
								->where(function ($query) use ($arr_machine) {
									foreach ($arr_machine as $ma) {
										// Loop over the search terms
										$query->Where('tb_product.pro_content', 'like', '%' . $ma . '%');
									}
								})
								->groupBy('tb_product.id')
								->orderBy('pro_name', 'ASC')
								->get();
			
		}else if(!empty($arr_spec)){
			
			$count_spec =  count($arr_spec);
			if($count_spec > 1){
				$items = TbProduct::select('tb_product.id', 'tb_product.pro_name', 'tb_product.pro_permalink', 'tb_product.pro_option', 'tb_product.pro_brand')
								->leftjoin('tb_product_specification', 'tb_product.id', 'tb_product_specification.proId')
								->where('tb_product.pro_brand', 50)
								->where('tb_product_specification.spec_detail', 'Yes')
								->whereIn('tb_product_specification.spec_name', $arr_spec)
								->groupBy('tb_product.id')
								->having(DB::raw('count(tb_product.id)'), '=', $count_spec)
								->orderBy('pro_name', 'ASC')
								->get();
			}else{
				$items = TbProduct::select('tb_product.id', 'tb_product.pro_name', 'tb_product.pro_permalink', 'tb_product.pro_option', 'tb_product.pro_brand')
								->leftjoin('tb_product_specification', 'tb_product.id', 'tb_product_specification.proId')
								->where('tb_product.pro_brand', 50)
								->where('tb_product_specification.spec_detail', 'Yes')
								->whereIn('tb_product_specification.spec_name', $arr_spec)
								->groupBy('tb_product.id')
								->orderBy('pro_name', 'ASC')
								->get();
			}
			
		}else{
			$items = TbProduct::select('tb_product.id', 'tb_product.pro_name', 'tb_product.pro_permalink', 'tb_product.pro_option', 'tb_product.pro_brand')
								->leftjoin('tb_product_specification', 'tb_product.id', 'tb_product_specification.proId')
								->where('tb_product.pro_brand', 50)
								->groupBy('tb_product.id')
								->orderBy('pro_name', 'ASC')
								->get();
		}
		
		

		foreach ($items as $item) {

			$products[] = array(
				'id' => $item->id,
				'sku' => $this->getproductSKU($item->id),
				'name' => $item->pro_name,
				'permalink' => $item->pro_permalink,
				'option' => $item->pro_option,
				'pictureName' => $this->getproductCover($item->id),
				'priceStatus' => $this->getproductPriceStatus($item->id),
				'price' => check_price_product_on_category_page($item->id),
				'brand' => $this->getBrand($item->pro_brand),
				'brand_permalink' => $this->getBrandLink($item->pro_brand),
			);
		}
        return $products;
    }
	
	private function getMaProduct($permalink)
    {

        $products = [];
		
		// Material Product
		$item = TbProduct::where('pro_permalink', $permalink)->first();

		$products = array(
			'id' => $item->id,
			'sku' => $this->getproductSKU($item->id),
			'name' => $item->pro_name,
			'permalink' => $item->pro_permalink,
			'option' => $item->pro_option,
			'pictureName' => $this->getproductCover($item->id),
			'priceStatus' => $this->getproductPriceStatus($item->id),
			'price' => check_price_product_on_category_page($item->id),
			'brand' => $this->getBrand($item->pro_brand),
			'brand_permalink' => $this->getBrandLink($item->pro_brand),
			'brand_logo' => $this->getBrandLogo($item->pro_brand),
			'pro_highlight' => $item->pro_highlight,
			'pro_content' => $item->pro_content,
			
		);
		
        return $products;
    }

    private function getProductSearch($search)
    {

        $products = [];
        $check_category = TbCategory::select('category_show')->where('category_show', 1)->count();
        if ($check_category != 0) {
			
			$items = TbProduct::where('pro_show', 1)
						->where(function($query) use ($search) {
							$query->where('pro_name', 'LIKE', '%' . $search . '%')
								  ->orWhere('pro_keyword', 'LIKE', '%' . $search . '%');
						})
						->orderBy('pro_name', 'ASC')->get();

            foreach ($items as $item) {

                $products[] = array(
                    'id' => $item->id,
                    'sku' => $this->getproductSKU($item->id),
                    'name' => $item->pro_name,
                    'permalink' => $item->pro_permalink,
                    'option' => $item->pro_option,
                    'pictureName' => $this->getproductCover($item->id),
                    'priceStatus' => $this->getproductPriceStatus($item->id),
                    'price' => check_price_product_on_category_page($item->id),
                    'brand' => $this->getBrand($item->pro_brand),
					'brand_permalink' => $this->getBrandLink($item->pro_brand),
                );
            }
        }
        return $products;
    }

    private function getCondition($settingPayment)
    {

        if (!empty($settingPayment)) {
            $response = TbProductCondition::select('id', 'condition_img', 'condition_name', 'condition_des', 'condition_show')->where('id', '!=', $settingPayment->conditionId)->where('condition_show', 1)->get();
        } else {
            $response = TbProductCondition::select('id', 'condition_img', 'condition_name', 'condition_des', 'condition_show')->where('condition_show', 1)->get();
        }

        return $response;
    }

    private function checkProductBreadcrumb($permalink)
    {

        $products = TbProduct::select(
            'tb_product.id',
            'tb_product.pro_catId',
            'tb_product.pro_catsubId',
            'tb_product.pro_name',
            'tb_product.pro_permalink',
            'tb_product.pro_show',
            'tb_category.id',
            'tb_category.category_name',
            'tb_category.category_permalink',
            'tb_category_sub.id',
            'tb_category_sub.categorysub_name',
            'tb_category_sub.categorysub_permalink'
        )
            ->leftjoin('tb_category', 'tb_category.id', 'tb_product.pro_catId')
            ->leftjoin('tb_category_sub', 'tb_category_sub.id', 'tb_product.pro_catsubId')
            ->where('tb_product.pro_show', 1)
            ->where('tb_product.pro_permalink', $permalink)
            ->first();

        if (!empty($products)) {

            if (!empty($products->categorysub_name)) {

                $breadcrumb = [
                    ['route' => route('fronend.home'), 'name' => 'หน้าหลัก'],
                    ['route' => route('fronend.category', $products->category_permalink), 'name' => $products->category_name],
                    ['route' => route('fronend.category', $products->categorysub_permalink), 'name' => $products->categorysub_name],
                    ['route' => '', 'name' => $products->pro_name],
                ];
            } else {

                $breadcrumb = [
                    ['route' => route('fronend.home'), 'name' => 'หน้าหลัก'],
                    ['route' => route('fronend.category', $products->category_permalink), 'name' => $products->category_name],
                    ['route' => '', 'name' => $products->pro_name],
                ];
            }
        } else {

            $breadcrumb = [
                ['route' => route('fronend.home'), 'name' => 'หน้าหลัก'],
                ['route' => '', 'name' => $permalink],
            ];
        }



        return $breadcrumb;
    }

    private function getBrand($id)
    {

        if (!empty($id)) {
            $data = TbBrand::select('id', 'brand_name')->findOrFail($id);
            $response = $data->brand_name;
        } else {
            $response = null;
        }
        return $response;
    }
	
	private function getBrandLink($id)
    {

        if (!empty($id)) {
            $data = TbBrand::select('id', 'brand_permalink')->findOrFail($id);
            $response = $data->brand_permalink;
        } else {
            $response = null;
        }
        return $response;
    }
	
	private function getBrandLogo($id)
    {

        if (!empty($id)) {
            $data = TbBrand::select('id', 'brand_img')->findOrFail($id);
            $response = $data->brand_img;
			
			if(!empty($response)){
				$response = asset('storage/brand/' . $response);
			}else{
				$response = null;
			}
			
        } else {
            $response = null;
        }
        return $response;
    }

    private function getType($id)
    {

        if (!empty($id)) {
            $data = TbProductType::select('id', 'type_name')->findOrFail($id);
            $response = $data->type_name;
        } else {
            $response = null;
        }
        return $response;
    }

    private function getproductCategory($id)
    {

        if (!empty($id)) {
            $data = TbCategory::select('id', 'category_name')->findOrFail($id);
            $response = $data->category_name;
        } else {
            $response = null;
        }
        return $response;
    }

    private function getproductCategorysub($id)
    {

        if (!empty($id)) {
            $data = TbCategorySub::select('id', 'categorysub_name')->findOrFail($id);
            $response = $data->categorysub_name;
        } else {
            $response = null;
        }
        return $response;
    }

    private function getCodition($codition)
    {

        $response = [];
        if (!empty($codition)) {

            $Items = explode(",", $codition);
            asort($Items);

            foreach ($Items as $item) {

                $condition = TbSettingPayment::value('conditionId');
                if (!empty($condition)) {

                    if ($condition != $item) {

                        $response[] = array(
                            'id' => $item,
                            'name' => TbProductCondition::where('id', $item)->where('condition_show', 1)->value('condition_name'),
                            'img' => TbProductCondition::where('id', $item)->where('condition_show', 1)->value('condition_img'),
                            'des' => TbProductCondition::where('id', $item)->where('condition_show', 1)->value('condition_des'),
                        );
                    }
                } else {

                    $response[] = array(
                        'id' => $item,
                        'name' => TbProductCondition::where('id', $item)->where('condition_show', 1)->value('condition_name'),
                        'img' => TbProductCondition::where('id', $item)->where('condition_show', 1)->value('condition_img'),
                        'des' => TbProductCondition::where('id', $item)->where('condition_show', 1)->value('condition_des'),
                    );
                }
            }
        }

        return $response;
    }

    private function getproductInstallment()
    {

        $condition = TbSettingPayment::where('installment_status', 1)->value('conditionId');
        if (!empty($condition)) {
            return TbProductCondition::where('condition_show', 1)->findOrFail($condition);
        } else {
            return '';
        }
    }

    private function getRelated($proRelated)
    {

        $Items = explode(",", $proRelated);
        asort($Items);

        $response = [];
        foreach ($Items as $proId) {

            $checkProduct = TbProduct::select('id', 'pro_show',)->where('pro_show', 1)->where('id', $proId)->count();

            if ($checkProduct != 0) {

                $product = TbProduct::select('tb_product.id', 'tb_product.pro_name', 'tb_product.pro_option', 'tb_product.pro_permalink', 'tb_product.pro_show', 'tb_brand.brand_name', 'tb_brand.brand_permalink')
							->leftjoin('tb_brand', 'tb_brand.id', 'tb_product.pro_brand')
							->where('tb_product.pro_show', 1)
							->where('tb_product.id', $proId)
							->first();

                $detail_product_contact_sale_status = TbProductDetail::select('proId', 'detail_status', 'detail_product_contact_sale_status', 'detail_show')
                    ->where('detail_show', 1)
                    ->where('proId', $proId)
                    ->value('detail_product_contact_sale_status');

                $stu_display = TbProductDetail::select('tb_product_status.id', 'tb_product_status.stu_display', 'tb_product_detail.proId', 'tb_product_detail.detail_status', 'tb_product_detail.detail_show')
                    ->leftjoin('tb_product_status', 'tb_product_status.id', 'tb_product_detail.detail_status')
                    ->where('tb_product_detail.detail_show', 1)
                    ->where('tb_product_detail.proId', $proId)
                    ->value('stu_display');

                $response[] = array(
                    'proId' => $proId,
                    'name' => $product->pro_name,
                    'permalink' => $product->pro_permalink,
                    'picture' => TbProductPicture::where('proId', $proId)->where('picture_status', '1')->value('picture_name'),
                    'contactSale' => $detail_product_contact_sale_status,
                    'option' => $product->pro_option,
                    'display' => $stu_display,
                    'price' => check_price_product_on_category_page($proId),
                    'brand' => $product->brand_name,
                    'brand_permalink' => $product->brand_permalink,
                );
            }
        }

        return $response;
    }

    private function getSpecification($id)
    {

        $response = [];
        $check = TbProduct::select('id', 'pro_permalink', 'pro_show')->where('pro_show', 1)->findOrFail($id);
        if (!empty($check)) {
            $specification = TbProductSpecification::select('proId', 'spec_name', 'spec_detail')->where('proId', $check->id)->get();

            foreach ($specification as $spac) {
                $response[] = array(
                    'spec_name' => $spac->spec_name,
                    'spec_detail' => $spac->spec_detail,
                );
            }
        }

        return $response;
    }

    private function checkOption($proId)
    {

        $product = TbProduct::select(
            'tb_product.id',
            'tb_product.pro_catId',
            'tb_product.pro_catsubId',
            'tb_product.pro_name',
            'tb_category.id',
            'tb_category.category_option',
            'tb_category_sub.id',
            'tb_category_sub.categorysub_option',
            'tb_product_detail.proId',
        )
            ->leftjoin('tb_category', 'tb_category.id', 'tb_product.pro_catId')
            ->leftjoin('tb_category_sub', 'tb_category_sub.id', 'tb_product.pro_catsubId')
            ->leftjoin('tb_product_detail', 'tb_product_detail.proId', 'tb_product.id')
            ->where('tb_product_detail.proId', $proId)
            ->first();

        if (!empty($product->categorysub_option)) {
            if ($product->categorysub_option == 1) {
                $option = 1;
            } else {
                $option = 2;
            }
        } else {

            if ($product->category_option == 1) {
                $option = 1;
            } else {
                $option = 2;
            }
        }

        return $option;
    }

    private function getcategoryDisplaystatus($proId)
    {

        $data = TbProduct::select('tb_product.id', 'tb_product.pro_catId', 'tb_category.id', 'tb_category.category_display_status')
            ->leftjoin('tb_category', 'tb_category.id', 'tb_product.pro_catId')
            ->where('tb_product.id', $proId)
            ->value('tb_category.category_display_status');

        return $data;
    }

    private function getAvailability($option, $proId)
    {


        if ($option == 1) {

            $data = TbProductDetail::select('proId', 'detail_status')->where('proId', $proId)->value('detail_status');

            if (!empty($data)) {

                if ($data == 2) {
                    $response = "out of stock";
                } else if ($data == 1) {
                    $response = "in stock";
                } else {
                    $response = "";
                }
            } else {

                $response = '';
            }
        } else {
            $response = '';
        }


        return $response;
    }

    private function getproductDetail($proId)
    {

        $response = [];

        $data = TbProductDetail::where('proId', $proId)->where('detail_show', 1)->whereNotIn('detail_status', array(2))->orderBy('sort', 'asc')->get();

        if (count($data) != 0) {

            foreach ($data as $product) {

                $response[] = array(
                    'id' => $product->id,
                    'sku' => $product->detail_sku,
                    'name' => $product->detail_name,
                    'other' => $product->detail_other,
                    'contactSaleStatus' => $product->detail_product_contact_sale_status,
                    'display' => TbProductStatus::where('id', $product->detail_status)->value('stu_display'),
                    'detail_check_stock_status' => $product->detail_check_stock_status,
                    'detail_stock' => $product->detail_stock,
                );
            }
        }

        return $response;
    }

    private function getproducrStatus($detailId)
    {

        if (!empty($detailId)) {
            $data = TbProductDetail::where('detail_show', 1)
                ->leftjoin('tb_product_status', 'tb_product_status.id', 'tb_product_detail.detail_status')
                ->findOrFail($detailId);

            if (!empty($data)) {
                return $data->stu_display;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    private function getProduct($permalink)
	{
		$response = [];
		$product = TbProduct::where('pro_show', 1)->where('pro_permalink', $permalink)->first();

		if (!empty($product)) {

			$detail = TbProductDetail::where('proId', $product->id)
				->where('detail_show', 1)
				->orderBy('sort', 'asc')
				->first();

			if (!empty($detail)) {

				$detailId                       = $detail->id;
				$detailSku                      = $detail->detail_sku;
				$detailName                     = $detail->detail_name;
				$detailOther                    = $detail->detail_other;
				$detailContact                  = $detail->detail_product_contact_sale_status;
				$detail_check_stock_status      = $detail->detail_check_stock_status;
				$detail_stock                   = $detail->detail_stock;
				$min_order                      = $detail->min_order;
				$max_order                      = $detail->max_order;

				// ✅ เพิ่ม
				$detail_price_sale_status       = $detail->detail_price_sale_status;
				$detail_price_sale_status_date  = $detail->detail_price_sale_status_date;
				$detail_sale_date_start         = $detail->detail_sale_date_start;
				$detail_sale_date_end           = $detail->detail_sale_date_end;
				$hide_addtocart_status          = $detail->hide_addtocart_status;

			} else {

				$detailId                       = '';
				$detailSku                      = '';
				$detailName                     = '';
				$detailOther                    = '';
				$detailContact                  = '';
				$detail_check_stock_status      = '';
				$detail_stock                   = '';
				$min_order                      = '';
				$max_order                      = '';

				// ✅ เพิ่ม
				$detail_price_sale_status       = '';
				$detail_price_sale_status_date  = '';
				$detail_sale_date_start         = '';
				$detail_sale_date_end           = '';
				$hide_addtocart_status          = '';
			}

			$response = array(
				'pro_id' => $product->id,
				'pro_option' => $product->pro_option,
				'pro_sku' => $this->getproductSKU($product->id),
				'pro_name' => $product->pro_name,
				'pro_permalink' => $product->pro_permalink,
				'pro_keyword' => $product->pro_keyword,
				'pro_seo_detail' => $product->pro_seo_detail,
				'pro_related' => $this->getRelated($product->pro_related),
				'pro_brand' => $this->getBrand($product->pro_brand),
				'pro_type' => $this->getType($product->pro_type),
				'pro_catId' => $this->getproductCategory($product->pro_catId),
				'pro_catsubId' => $this->getproductCategorysub($product->pro_catsubId),
				'pro_download' => $product->pro_download,
				'pro_free_trial' => $product->pro_free_trial,
				'pro_codition' => $this->getCodition($product->pro_codition),
				'pro_highlight' => $product->pro_highlight,
				'pro_content' => $product->pro_content,
				'pro_feature' => $product->pro_feature,
				'pro_gift' => $product->pro_gift,
				'pro_specification' => $this->getSpecification($product->id),
				'pro_cover' => $this->getproductCover($product->id),
				'pro_image' => $this->getproductImages($product->id),
				'checkOption' => $this->checkOption($product->id),

				'detailId' => $detailId,
				'detailSku' => $detailSku,
				'detailName' => $detailName,
				'detailOther' => $detailOther,
				'detailStatus' => $this->getproducrStatus($detailId),
				'detailContact' => $detailContact,
				'detailPrice' => check_price_product_on_category_page($product->id),
				'detailPriceCover' => check_price_product_on_content_page($detailId),
				'detail_check_stock_status' => $detail_check_stock_status,
				'detail_stock' => $detail_stock,
				'min_order' => $min_order,
				'max_order' => $max_order,

				// ✅ เพิ่ม
				'detail_price_sale_status' => $detail_price_sale_status,
				'detail_price_sale_status_date' => $detail_price_sale_status_date,
				'detail_sale_date_start' => $detail_sale_date_start,
				'detail_sale_date_end' => $detail_sale_date_end,
				'hide_addtocart_status' => $hide_addtocart_status,

				'og_price' => og_productPrice($detailId),
				'availability' => $this->getAvailability($product->pro_option, $product->id),
				'categoryDisplaystatus' => $this->getcategoryDisplaystatus($product->id),
				'proDetail' => $this->getproductDetail($product->id),
				'proInstallment' => $this->getproductInstallment(),
			);
		}

		return $response;
	}
    //------------------------------------------  end product

    //------------------------------------------ other
    private function paginate($items, $perPage, $page = null, $options = [])
    {
        $items  = collect($items);
        $page   = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items  = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    private function notify_message($Message, $Token)
    {

        $chOne = curl_init();
        curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
        curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($chOne, CURLOPT_POST, 1);
        curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=" . $Message);
        $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: ' . $Token . '',);
        curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($chOne);

        //Result error
        if (curl_error($chOne)) {
            echo 'error:' . curl_error($chOne);
        } else {
            $result_ = json_decode($result, true);
            echo "status : " . $result_['status'];
            echo "message : " . $result_['message'];
        }
        curl_close($chOne);

        return $chOne;
    }

    private function compareDate($date1, $date2)
    {
        $arrDate1 = explode("-", $date1);
        $arrDate2 = explode("-", $date2);
        $timStmp1 = mktime(0, 0, 0, $arrDate1[1], $arrDate1[2], $arrDate1[0]);
        $timStmp2 = mktime(0, 0, 0, $arrDate2[1], $arrDate2[2], $arrDate2[0]);

        if ($timStmp1 == $timStmp2) {
            return 1;
        } else if ($timStmp1 > $timStmp2) {
            return 0;
        } else if ($timStmp1 < $timStmp2) {
            return 2;
        }
    }

    private function generateRandomNumber($length)
    {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
	
	private function generateTicketCode()
    {
		
		$current_date = date('Y-m-d');
		$format_date = date('ymd');
		$count_ticket_today = Ticket::whereDate('created_at', '=', $current_date)->count();
		$count_ticket = $count_ticket_today+1;
		$format_count = str_pad($count_ticket, 3, '0', STR_PAD_LEFT);
		
		$ticketcode = $format_date.$format_count;
		
        return $ticketcode;
    }
	
	private function generateQuotationCode()
    {
		
		$current_date = date('Y-m-d');
		$format_date = date('ymd');
		/*
		$current_month = date("m", time());
		$current_quarter = ceil($current_month/3);
		*/
		$format_q_date = 'Q'.$format_date;
		
		$count_quote_today = TbQuotation::whereDate('created_at', '=', $current_date)->count();
		$num_quote = $count_quote_today+1;
		$format_count = str_pad($num_quote, 3, '0', STR_PAD_LEFT);
		
		$quotecode = $format_count.'-'.$format_q_date;
		
        return $quotecode;
    }
	
    private function generateRandomString($length)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    //------------------------------------------ end other
	
	public function removeFontFamilyStyles($html)
    {
		if(!empty($html)){
			$html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
			
			$doc = new \DOMDocument();
			libxml_use_internal_errors(true); // Disable libxml errors
			$doc->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
			libxml_clear_errors();
			
			$xpath = new \DOMXPath($doc);

			// Remove font-family in style attribute
			$styleNodes = $xpath->query('//*[@style]');
			foreach ($styleNodes as $node) {
				$style = $node->getAttribute('style');
				$styleArray = explode(';', $style);
				$newStyleArray = array_filter($styleArray, function($styleItem) {
					return stripos($styleItem, 'font-family') === false;
				});
				$newStyle = implode(';', $newStyleArray);
				$node->setAttribute('style', $newStyle);
			}

			// Remove face attribute in font tags
			$fontNodes = $xpath->query('//font[@face]');
			foreach ($fontNodes as $node) {
				$node->removeAttribute('face');
			}
			
			return $doc->saveHTML();
		}else{
			return null;
		}
        
    }
	
	/**
	 * ส่งอีเมลใบเสนอราคาให้ลูกค้า – แนบ PDF ถ้ามี
	 * @return array [status(bool), message(string)]
	 */
	private function sendQuotationForUser(int $quotationId): array
	{
		try {
			$setting    = TbSetting::first();
			$page       = TbPagesMap::first();
			$quotation  = TbQuotation::findOrFail($quotationId);

			// หาไฟล์ PDF ล่าสุดของใบเสนอราคา
			$h = HistoryQuotation::where('quotationId', $quotationId)->orderByDesc('id')->first();

			$pdfAbs = null;    // absolute path สำหรับแนบไฟล์
			$pdfUrl = null;    // URL สำหรับใส่ปุ่มในอีเมล
			if ($h && !empty($h->name_file)) {
				$filename = basename($h->name_file);
				$pdfAbs   = public_path("storage/pdfQuotation/{$filename}");
				if (is_file($pdfAbs) && is_readable($pdfAbs) && filesize($pdfAbs) > 0) {
					$pdfUrl = asset("storage/pdfQuotation/{$filename}");
				} else {
					$pdfAbs = null;
				}
			}

			// เตรียมข้อมูลสำหรับเทมเพลตอีเมล
			$data                 = new \stdClass();
			$data->setting        = $setting;
			$data->page           = $page;
			$data->quotation      = $quotation;
			$data->subject        = "[PTCAD] ใบเสนอราคาเลขที่ {$quotation->quotationNumber}";
			$data->customer_name  = trim($quotation->name.' '.$quotation->lastname);
			$data->pdf_url        = $pdfUrl; // ถ้าไม่มีไฟล์ จะเป็น null
			$data->confirm_url    = route('fronend.quotation.status'); // หน้าคอนเฟิร์ม (ไม่มี id โผล่)
			$data->site_url       = config('app.url');

			// ผู้รับ (รองรับคอมม่า)
			$to = array_filter(array_map('trim', explode(',', $quotation->email ?: '')));
			if (empty($to)) {
				return [false, 'ไม่มีอีเมลลูกค้า'];
			}

			// CC (ถ้ามี)
			$cc = [];

			// BCC (เผื่อเก็บสำเนาที่บริษัท)
			$bcc = [];
			if (!empty($setting->setting_email_bcc)) {
				$bcc = array_filter(array_map('trim', explode(',', $setting->setting_email_bcc)));
			}

			// ส่งเมล
			Mail::send('emails.QuotationForUser', ['data' => $data], function ($m) use ($data, $to, $cc, $bcc, $pdfAbs) {
				$m->to($to, $data->customer_name)
				  ->subject($data->subject)
				  ->replyTo($bcc, 'PTCAD');

				if (!empty($cc))  $m->cc($cc);
				if (!empty($bcc)) $m->bcc($bcc);

				// แนบไฟล์ถ้ามี
				if ($pdfAbs) {
					$m->attach($pdfAbs, [
						'as'   => "Quotation-{$data->quotation->quotationNumber}.pdf",
						'mime' => 'application/pdf',
					]);
				}
			});

			if (Mail::failures()) {
				Log::warning('Quotation email failures', ['to' => $to, 'quotationId' => $quotationId]);
				return [false, 'Mail::failures()'];
			}

			return [true, 'sent'];

		} catch (\Throwable $e) {
			Log::error('sendQuotationForUser exception', [
				'quotationId' => $quotationId,
				'error'       => $e->getMessage(),
			]);
			return [false, $e->getMessage()];
		}
	}

}