<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

use App\Models\TbSetting;
use App\Models\Ticket;
use App\Models\TicketProgram;
use App\Models\TicketFile;
use App\Models\HistoryTicket;
use App\Models\User;
use App\Models\TbPagesMap;
use App\Models\Notiticket;
use App\Models\TbArticle;
use App\Models\Holiday;

use Carbon\Carbon;

class HelpController extends Controller
{

    //สถานะการช่วยเหลือ
    //1 == เปิด ticket
    //2 == กำลังดำเนินการ
    //3 == แก้ไขสำเร็จ
    //4 == ยกเลิก

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        $breadcrumb = [
            ['name' => 'บริการช่วยเหลือ'],
        ];
        $title_page = 'บริการช่วยเหลือ';
				
		if(!empty($request)){
			
			$search_ticket = ['status' => !empty($request->status) ? $request->status : null,
								'service_type' => !empty($request->service_type) ? $request->service_type : null,
								'service_channel' => !empty($request->service_channel) ? $request->service_channel : null,
								'request_channel' => !empty($request->request_channel) ? $request->request_channel : null,
								'request_by' => !empty($request->request_by) ? $request->request_by : null,
								'program' => !empty($request->program) ? $request->program : null,
								'staffId' => !empty($request->staffId) ? $request->staffId : null,
								//'month' => !empty($request->month) ? $request->month : null,
								//'year' => !empty($request->year) ? $request->year : null,
								'date_start' => !empty($request->date_start) ? $request->date_start : null,
								'date_end' => !empty($request->date_end) ? $request->date_end : null,
								'department' => !empty($request->department) ? $request->department : null,
								];
			
			$count = Ticket::where(function ($query) use ($request) {
				if (!empty($request->status)) {
					$query->where('status', $request->status);
				}
				if(!empty($request->service_type)){
					$query->where('service_type', $request->service_type);
				}
				if(!empty($request->service_channel)){
					$query->where('service_channel', $request->service_channel);
				}
				if(!empty($request->request_channel)){
					$query->where('request_channel', $request->request_channel);
				}
				if(!empty($request->request_by)){
					$query->where('request_by', $request->request_by);
				}
				if(!empty($request->program)) {
					$query->whereRaw('FIND_IN_SET(?, program)', [$request->program]);
				}
				if(!empty($request->company)){
					$query->where('company', $request->company);
				}
				if(!empty($request->staffId)){
					$query->where('staffId', $request->staffId);
				}
				/*
				if(!empty($request->month)){
					$query->whereMonth('created_at',$request->month);
				}
				if(!empty($request->year)){
					$query->whereYear('created_at',$request->year);
				}
				*/
				if(!empty($request->date_start)){
					$query->where('created_at', '>=', $request->date_start . ' 00:00:00');
				}
				if(!empty($request->date_end)){
					$query->where('created_at', '<=', $request->date_end . ' 23:59:59');
				}
				if(!empty($request->department)){
					$query->where('department', $request->department);
				}
			})->count();
			
		}else{
			$count   = Ticket::count();
		}


        return view('admin.ticket.main', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => '',
            'request' => $request,
            'count' => $count,
            'search_ticket' => $search_ticket,
        ]);

    }

    public function add(){

		$breadcrumb = [
			['name' => 'เพิ่มตำแหน่ง/อาชีพ'],
		];
		$title_page = 'เพิ่มตำแหน่ง/อาชีพ';

		$users = User::where('level',5)->get();
		$programs = TicketProgram::where('show',1)->get();
		$ticket = $this->generateRandomNumber(10);

		$ServiceType = $this->GetServiceType();
		$ServiceChannel = $this->GetServiceChannel();
		$requestByType = $this->GetrequestByType();
		$requestChannelType = $this->GetRequestChannelType();
		$department = $this->GetPosition();

		return view('admin.ticket.form', [
			'breadcrumb' => $breadcrumb,
			'title_page' => $title_page,
			'data' => '',
			'users' => $users,
			'programs' => $programs,
			'ticket' => $ticket,
			'ServiceType' => $ServiceType,
			'ServiceChannel' => $ServiceChannel,
			'requestByType' => $requestByType,
			'requestChannelType' => $requestChannelType,
			'department' => $department,
			'ticketFile' => collect(),
			'HistoryTicket' => collect(),
			'allow_score' => false,
		]);

	}

    public function crate(Request $request){

        $request->validate(
            [
                'code' => 'required|max:255',
                'name' => 'required|max:255',
                'tel' => 'required|max:255',
                'email' => 'required|email|max:255',
                'subject' => 'required|max:255',
            ],
            [
                'code.required' => 'กรุณากรอกข้อมูล',
                'code.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'name.required' => 'กรุณากรอกข้อมูล',
                'name.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'tel.required' => 'กรุณากรอกข้อมูล',
                'tel.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'email.required' => 'กรุณากรอกข้อมูล',
                'email.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'email.email' => 'รูปแบบอีเมล ไม่ถูกต้องกรุณาตรวจสอบข้อมูล',
                'subject.required' => 'กรุณากรอกข้อมูล',
                'subject.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
            ]
        );

        $data = new Ticket;
        $data->code                         = $request->code;
        $data->name                         = $request->name;
        $data->company                      = $request->company;
        $data->tel                          = $request->tel;
        $data->email                        = $request->email;
        $data->subject                      = $request->subject;
        $data->program                      = $request->program;
        $data->message                      = $request->message;
        $data->note                         = $request->note;
        $data->status                       = $request->status;
        $data->created_by                   = Auth::user()->displayname;
        $data->updated_by                   = Auth::user()->displayname;
        $data->created_at                   = date('Y-m-d H:i:s');
        $data->updated_at                   = date('Y-m-d H:i:s');
        $data->request_by                   = $request->request_by;
        $data->request_channel				= $request->request_channel;
        $data->save();

        $this->TicketForUser($data->code);

        return redirect()->route('ticket.edit',[$data->id])->with('feedback', 'เพิ่มข้อมูลเรียบร้อยแล้ว!');

    }

    public function edit($id)
    {
        $breadcrumb = [
            ['name' => 'บริการช่วยเหลือ'],
        ];
        $title_page = 'บริการช่วยเหลือ';
		
		$userlogin = Auth::user();
		$level_view_score = array(1,3,7);	//Admin (แอดมิน) + Web Developer (นักพัฒนา) + Administrator (ผู้ดูแลระบบ)
		$allow_score = FALSE;
		if(in_array($userlogin->level, $level_view_score)){
			$allow_score = TRUE;
		}
		if($allow_score === FALSE && $userlogin->id == 273){
			$allow_score = TRUE;
		}

        $data = Ticket::findOrFail($id);
        $ticketFile = TicketFile::where('ticketId',$id)->get();
        $users = User::where('level',5)->get();
        $HistoryTicket = HistoryTicket::where('ticketId',$id)->orderBy('created_at','desc')->get();
		
		if(!empty($data)){
			if($data->status == 1){
				$data->statusname = "Open";
				$data->statusclass = "badge badge-secondary";
			}elseif($data->status == 2){
				$data->statusname = "In Progress";
				$data->statusclass = "badge badge-warning";
			}elseif($data->status == 3){
				$data->statusname = "Resolved";
				$data->statusclass = "badge badge-success";
			}else{
				$data->statusname = "Cancel";
				$data->statusclass = "badge badge-dark";
			}
		}
		
		if(!empty($data->staffId)){
            $staffname = User::select('name')->where('id',$data->staffId)->first();
			$data->staffname = $staffname->name;
        }else{
            $data->staffname = 'ยังไม่มีผู้รับผิดชอบ';
        }
		
		$ServiceType = $this->GetServiceType();
		$ServiceChannel = $this->GetServiceChannel();
		$requestByType = $this->GetrequestByType();
		$requestChannelType = $this->GetRequestChannelType();
		$programs = TicketProgram::where('show',1)->get();
		$department = $this->GetPosition();
		
        return view('admin.ticket.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => $data,
            'users' => $users,
            'ticketFile' => $ticketFile,
            'HistoryTicket' => $HistoryTicket,
            'ServiceType' => $ServiceType,
            'ServiceChannel' => $ServiceChannel,
            'requestByType' => $requestByType,
            'allow_score' => $allow_score,
            'programs' => $programs,
            'department' => $department,
            'requestChannelType' => $requestChannelType,
        ]);
    }
	
	public function GetStatus(){
		
		$status = Array();
		$status['1'] = 'Open';
		$status['2'] = 'In Progress';
		$status['3'] = 'Resolved';
		$status['4'] = 'Cancel';
		
		return $status;
		
	}
	
	public function GetServiceType(){
		
		$service_type = Array();
		$service_type['ติดตั้งโปรแกรม'] = 'ติดตั้งโปรแกรม';
		$service_type['ปัญหาการใช้งานโปรแกรม'] = 'ปัญหาการใช้งานโปรแกรม';
		$service_type['ปรึกษาข้อมูลเพิ่มเติม'] = 'ปรึกษาข้อมูลเพิ่มเติม';
		
		return $service_type;
		
	}
	
	public function GetServiceChannel(){
		
		$service_channel = Array();
		$service_channel['Onsite'] = 'Onsite';
		$service_channel['Remote'] = 'Remote';
		$service_channel['Email'] = 'Email';
		$service_channel['Line'] = 'Line';
		$service_channel['Phone'] = 'Phone';
		
		return $service_channel;
		
	}
	
	public function GetrequestByType(){
		
		$requestByType = Array();
		$requestByType['Sales'] = 'Sales';
		$requestByType['Support'] = 'Support';
		$requestByType['Customer'] = 'Customer';
		$requestByType['Unknow'] = 'Unknow';
		
		return $requestByType;
		
	}

    public function GetUserName($userId){
		
		$username = User::select('name','lastname')->where('id',$userId)->first();
		
		return $username;
		
	}

    public function update(Request $request,$id){
		
		
		if(!empty($request->status) && $request->status == 3){
			
			$request->validate(
				[
					'staffId' => 'required',
					'status' => 'required',
					'company' => 'required',
					'program' => 'required',
					'service_type' => 'required',
					'service_channel' => 'required',
					
				],
				[
					'staffId.required' => 'กรุณาเลือกข้อมูล',
					'status.required' => 'กรุณาเลือกข้อมูล',
					'company.required' => 'กรุณาเลือกข้อมูล',
					'program.required' => 'กรุณาเลือกข้อมูล',
					'service_type.required' => 'กรุณาเลือกข้อมูล',
					'service_channel.required' => 'กรุณาเลือกข้อมูล',
				]
			);
			
		}else{
			$request->validate(
				[
					'staffId' => 'required',
					'status' => 'required',
					'company' => 'required',
					'program' => 'required',
				],
				[
					'staffId.required' => 'กรุณาเลือกข้อมูล',
					'status.required' => 'กรุณาเลือกข้อมูล',
					'company.required' => 'กรุณาเลือกข้อมูล',
					'program.required' => 'กรุณาเลือกข้อมูล',
				]
			);
		}
		
		$remark = '';
		$checkres = '';
		$oldTicket = Ticket::where('id', $id)->first();
		$arr_status = $this->GetStatus();
		
		$program_ticket = '';
		if(!empty($request->program)){
			if(is_array($request->program)){
				$program_ticket = implode(',', $request->program);
			}else{
				$program_ticket = $request->program;
			}
		}
		
		# Check change Status
		if($oldTicket->status != $request->status){
			$remark .= ",Updated Status : ".$arr_status[$request->status];
		}
		# Check change Staff
		if($oldTicket->staffId != $request->staffId){
			$staffname_new = $this->GetUserName($request->staffId);
			$remark .= ",Updated Assigned To : ".$staffname_new->name;
		}
		# Check change Company
		if($oldTicket->company != $request->company){
			$remark .= ",Updated Company : ".$request->company;
		}
		# Check change Program
		if($oldTicket->program != $program_ticket){
			$remark .= ",Updated Program : ".$program_ticket;
		}
		# Check change service_type
		if($oldTicket->service_type != $request->service_type){
			$remark .= ",Updated Service Type : ".$request->service_type;
		}
		# Check change service_channel
		if($oldTicket->service_channel != $request->service_channel){
			$remark .= ",Updated Service Channel : ".$request->service_channel;
		}

		# Check change request_channel
		if($oldTicket->request_channel != $request->request_channel){
			$remark .= ",Updated Request Channel : ".$request->request_channel;
		}
		# Check Department
		if($oldTicket->department != $request->department){
			$remark .= ",Updated Department : ".$request->department;
		}
		$remark = substr($remark,1);

        $data = Ticket::findOrfail($id);
        $data->staffId                    = $request->staffId;
        $data->status                     = $request->status;
        $data->company					  = $request->company;
        $data->program					  = $program_ticket;
		$data->service_type               = $request->service_type;
        $data->service_channel            = $request->service_channel;
        $data->request_channel            = $request->request_channel;
        $data->department				  = $request->department;
        $data->note                       = null;
		
		if(!empty($request->staffId)){	// Check First Assigned To
			$checkass = HistoryTicket::select('id')->where('ticketId',$id)->whereNotNull('staffId')->first();
			if(empty($checkass)){
				$data->assigned_at = date('Y-m-d H:i:s');
			}
		}
		
		$resolved_1 = 'no';
		if($request->status == 3){	// Resolved send mail Review + Thank U
			// Check First Resolved
			$checkres = HistoryTicket::select('id')->where('ticketId',$id)->where('status',$request->status)->first();
			if(empty($checkres)){
				$resolved_1 = 'yes';
				$data->closed_at = date('Y-m-d H:i:s');
			}
			
		}
		
        $data->updated_by                 = Auth::user()->displayname;
        $data->updated_at                 = date('Y-m-d H:i:s');
        $data->save();
		
		$history = new HistoryTicket();
        $history->ticketId                	= $id;
        $history->ticketcode                = $request->code;
        $history->status                	= $request->status;
        $history->staffId                	= $request->staffId;
        $history->company                	= $request->company;
        $history->program                	= $program_ticket;
        $history->service_type              = $request->service_type;
        $history->service_channel           = $request->service_channel;
		$history->department				= $request->department;
        $history->note                    	= $request->note;
        $history->remark                    = $remark;
		
        $history->mailStatus                = 0;
        $history->mailRemark                = null;
		
        $history->updated_by                = Auth::user()->displayname;
        $history->created_at                = date('Y-m-d H:i:s');
        $history->updated_at                = date('Y-m-d H:i:s');
        $history->save();
		
		if($request->status == 3 && $resolved_1 == 'yes'){
			$this->ThankYouTicket($history->id);
			$this->ThankYouTicketUser($history->id);
		}
		
        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function jsondata(Request $request)
    {

		$q = Ticket::query()
			->select([
				'ticket.id',
				'ticket.code',
				'ticket.status',
				'ticket.company',
				'ticket.created_at',
				'ticket.created_by',
				'ticket.program',
				'ticket.staffId',
			])
			->leftJoin('users', 'users.id', '=', 'ticket.staffId')
			->addSelect(DB::raw('COALESCE(users.name, "ยังไม่มีผู้รับผิดชอบ") as staffname'));

		// ---- filters (ใช้ index ได้) ----
		if ($request->filled('status'))          $q->where('ticket.status', $request->status);
		if ($request->filled('service_type'))    $q->where('ticket.service_type', $request->service_type);
		if ($request->filled('service_channel')) $q->where('ticket.service_channel', $request->service_channel);
		if ($request->filled('request_channel')) $q->where('ticket.request_channel', $request->request_channel);
		if ($request->filled('department'))      $q->where('ticket.department', $request->department);
		if ($request->filled('company'))         $q->where('ticket.company', $request->company);
		if ($request->filled('staffId'))         $q->where('ticket.staffId', $request->staffId);
		if ($request->filled('date_start'))      $q->where('ticket.created_at', '>=', $request->date_start . ' 00:00:00');
		if ($request->filled('date_end'))        $q->where('ticket.created_at', '<=', $request->date_end   . ' 23:59:59');

		// NOTE: ถ้า program เป็น CSV, FIND_IN_SET ช้ามาก แนะนำ normalize (ดูส่วน schema)
		if ($request->filled('program')) {
			$q->whereRaw('FIND_IN_SET(?, ticket.program)', [$request->program]);
		}

        return datatables()
			->eloquent($q)
			->addColumn('code', fn($row) =>
				'<a href="'.route('ticket.edit',$row->id).'" style="text-decoration:none;color:#51cbce;font-weight:700;">'.$row->code.'</a>'
			)
			->editColumn('status', function ($row) {
				return match ((int)$row->status) {
					3 => '<span class="badge badge-success">Resolved</span>',
					2 => '<span class="badge badge-warning">In Progress</span>',
					1 => '<span class="badge badge-secondary">Open</span>',
					4 => '<span class="badge badge-dark">Cancel</span>',
					default => '<span class="badge badge-secondary">-</span>',
				};
			})
			->addColumn('created_at_text', fn($row) =>
				e($row->created_at).' <br/><small><i class="fa fa-user"></i> '.e($row->created_by).'</small>'
			)
			->rawColumns(['code','status','created_at_text'])
			->orderColumn('created_at_text', 'ticket.created_at $1') // ✅ map sorting ไปที่ ticket.created_at
			->toJson();


    }

    public function delete(Request $request){

        Ticket::where('id', $request->deleteId)->delete();
        return back()->with('feedback', 'ลบข้อมูลเรียบร้อยแล้ว!');

    }

    private function generateRandomNumber($length) {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    private function TicketForUser($code){

        $setting  = TbSetting::first();
        $page     = TbPagesMap::first();
        $historys = HistoryTicket::where('ticketcode',$code)->where('mailStatus',2)->get();


        if(count($historys) != 0){
            foreach($historys as $history){

                $ticket = Ticket::where('code',$history->ticketcode)->first();

                if(!empty($ticket)){
                    $ticketFile         = TicketFile::where('ticketId',$ticket->id)->get();

                    $data = new \stdClass();
                    $data->setting_nameWeb = $setting->setting_nameWeb;
                    $data->setting_logoWeb = $setting->setting_logoWeb;
                    $data->setting_email_bcc = $setting->setting_email_bcc;
                    $data->page            = $page;
                    $data->ticket          = $ticket;
                    $data->ticketFile      = $ticketFile;
                    $data->name            = $ticket->name;
                    $data->subject         = "[Ticket ID : ".$ticket->code."] ".$ticket->subject;
                    $data->customer_email  = $ticket->email;

                    if(!empty($ticket->email)){

                        $emailCustomer            = explode(",",$ticket->email);
                        $data->emailCustomer      = $emailCustomer;

                        $emailSupport             = explode(",",$setting->setting_email_support);
                        $data->emailSupport       = $emailSupport;

                        if(!empty($setting->setting_email_support)){
							
							try{
								Mail::send('emails.TicketForUser', ['data' => $data], function ($m) use ($data) {
									$m->to($data->emailCustomer, $data->name)
									->bcc($data->emailSupport,'Support '.$data->setting_nameWeb)
									->replyTo($data->emailSupport, $data->setting_nameWeb)
									->subject($data->subject);

									if(!empty($data->ticketFile)){
										foreach ($data->ticketFile as $file){
											$m->attach(asset('storage/ticket/'.$file->name));
										}
									}
								});
								
								if(Mail::failures()) { $status = 2; $mailStatus = 'ล้มเหลว'; }else{ $status = 1; $mailStatus = 'สำเร็จ'; }
							}catch(\Exception $e){
								// Never reached
								$status = 2;
								$mailStatus = 'ล้มเหลว';
							}
                            
                        }else{
							
							try{
								Mail::send('emails.TicketForUser', ['data' => $data], function ($m) use ($data) {
									$m->to($data->emailCustomer, $data->name)
									->bcc($data->setting_email_bcc,'Support '.$data->setting_nameWeb)
									->replyTo($data->setting_email_bcc, $data->setting_nameWeb)
									->subject($data->subject);

									if(!empty($data->ticketFile)){
										foreach ($data->ticketFile as $file){
											$m->attach(asset('storage/ticket/'.$file->name));
										}
									}
								});
								
								if(Mail::failures()) { $status = 2; $mailStatus = 'ล้มเหลว'; }else{ $status = 1; $mailStatus = 'สำเร็จ'; }
							}catch(\Exception $e){
								// Never reached
								$status = 2;
								$mailStatus = 'ล้มเหลว';
							}
                            
                        }

                        $history                            = HistoryTicket::findOrFail($history->id);
                        $history->mailStatus                = $status;
                        $history->mailRemark                = $mailStatus;
                        $history->updated_by                = 'SYSTEM';
                        $history->created_at                = date('Y-m-d H:i:s');
                        $history->updated_at                = date('Y-m-d H:i:s');
                        $history->save();

                        return 'พบข้อมูล '.count($historys).' รายการ <br/> สถานะ '.$mailStatus ;
                    }
                }

            }
        }else{
            return 'ไม่พบข้อมูล';
        }


    }
	
	private function ThankYouTicket($historyTicketId)
    {

        $setting  = TbSetting::first();
        $page     = TbPagesMap::first();
        $historys = HistoryTicket::where('id', $historyTicketId)->get();


        if(count($historys) != 0) {
            foreach ($historys as $history){

                $ticket = Ticket::where('id', $history->ticketId)->first();

                if (!empty($ticket)) {
                    //$ticketFile         = TicketFile::where('ticketId', $ticket->id)->get();

                    $data = new \stdClass();
                    $data->setting_nameWeb = $setting->setting_nameWeb;
                    $data->setting_logoWeb = $setting->setting_logoWeb;
                    $data->setting_email_bcc = $setting->setting_email_bcc;
                    $data->page            = $page;
                    $data->ticket          = $ticket;
                    //$data->ticketFile      = $ticketFile;
                    $data->name            = $ticket->name;
                    $data->secret_code     = $ticket->secret_code;
                    $data->subject         = "[PTCAD] Ticket ID : " . $ticket->code;
                    $data->customer_email  = $ticket->email;

                    if (!empty($ticket->email)) {

                        $emailCustomer            = explode(",", $ticket->email);
                        $data->emailCustomer      = $emailCustomer;
						/*
						if(!empty($ticket->email_cc)){
							$emailCC            	  = explode(",", $ticket->email_cc);
							$data->emailCC      	  = $emailCC;
						}
						*/
						$data->sendCustomer = 'yes';
						
						try{
							Mail::send('emails.ThankYouTicket', ['data' => $data], function ($m) use ($data) {
								$m->to($data->emailCustomer, $data->name)
									->subject($data->subject);
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
							$mailStatus = 'ล้มเหลว';
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
	
	private function ThankYouTicketUser($historyTicketId)
    {

        $setting  = TbSetting::first();
        $page     = TbPagesMap::first();
        $historys = HistoryTicket::where('id', $historyTicketId)->get();


        if(count($historys) != 0) {
            foreach ($historys as $history){

                $ticket = Ticket::where('id', $history->ticketId)->first();

                if (!empty($ticket)) {
                    //$ticketFile         = TicketFile::where('ticketId', $ticket->id)->get();

                    $data = new \stdClass();
                    $data->setting_nameWeb = $setting->setting_nameWeb;
                    $data->setting_logoWeb = $setting->setting_logoWeb;
                    $data->setting_email_support = $setting->setting_email_support;
                    $data->page            = $page;
                    $data->ticket          = $ticket;
                    //$data->ticketFile      = $ticketFile;
                    $data->name            = $ticket->name;
                    $data->secret_code     = $ticket->secret_code;
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
						
						$data->sendCustomer = 'no';

						if(!empty($data->emailCC)){
							
							try{
								Mail::send('emails.ThankYouTicket', ['data' => $data], function ($m) use ($data) {
									$m->to($data->emailSupport, 'Support ' . $data->setting_nameWeb)
										->cc($data->emailCC, $data->emailCC)
										->subject($data->subject);
								});
								
							}catch(\Exception $e){
								// Never reached
								return 'ไม่พบข้อมูล';
							}
						}else{
							
							try{
								Mail::send('emails.ThankYouTicket', ['data' => $data], function ($m) use ($data) {
									$m->to($data->emailSupport, 'Support ' . $data->setting_nameWeb)
										->subject($data->subject);
								});
								
							}catch(\Exception $e){
								// Never reached
								return 'ไม่พบข้อมูล';
							}
						}
                        

                        return 'พบข้อมูล';
                    }
                }
            }
        } else {
            return 'ไม่พบข้อมูล';
        }
    }
	
	public function indexStaff(Request $request)
	{
		//1 == เปิด ticket
		//2 == กำลังดำเนินการ
		//3 == แก้ไขสำเร็จ
		//4 == ยกเลิก

		$breadcrumb = [
			['name' => 'Report Ticket'],
		];
		$title_page = 'Report Ticket';

		$staffId    = $request->staffId;
		$date_start = $request->date_start;
		$date_end   = $request->date_end;

		// -------------------- ช่วงวันที่หลัก ใช้ร่วมกันทั้งหน้า (ให้ตรงกับกราฟ และจำกัดไม่เกิน 12 เดือน) --------------------
		$rangeStart = !empty($date_start) ? Carbon::parse($date_start)->startOfMonth() : Carbon::now()->startOfYear();
		$rangeEnd   = !empty($date_end)   ? Carbon::parse($date_end)->endOfMonth()   : Carbon::now()->endOfYear();
		if ($rangeStart->diffInMonths($rangeEnd) > 11) {
			$rangeStart = $rangeEnd->copy()->subMonths(11)->startOfMonth();
		}

		// -------------------- ตัวเลขรวมต่าง ๆ (โค้ดเดิม) --------------------
		$count = Ticket::where(function ($query) use ($request) {
				if (!empty($request->staffId)) {
					$query->where('staffId', $request->staffId);
				}
				if (!empty($request->date_start)) {
					$query->where('created_at', '>=', $request->date_start . ' 00:00:00');
				}
				if (!empty($request->date_end)) {
					$query->where('created_at', '<=', $request->date_end . ' 23:59:59');
				}
			})->count();

		$openTicket = Ticket::where('status', 1)->count();

		$inprogressTicket = Ticket::where(function ($query) use ($request) {
				if (!empty($request->staffId)) {
					$query->where('staffId', $request->staffId);
				}
				if (!empty($request->date_start)) {
					$query->where('created_at', '>=', $request->date_start . ' 00:00:00');
				}
				if (!empty($request->date_end)) {
					$query->where('created_at', '<=', $request->date_end . ' 23:59:59');
				}
			})->where('status', 2)->count();

		$closedTicket = Ticket::where(function ($query) use ($request) {
				if (!empty($request->staffId)) {
					$query->where('staffId', $request->staffId);
				}
				if (!empty($request->date_start)) {
					$query->where('created_at', '>=', $request->date_start . ' 00:00:00');
				}
				if (!empty($request->date_end)) {
					$query->where('created_at', '<=', $request->date_end . ' 23:59:59');
				}
			})->where('status', 3)->count();

		$cancelTicket = Ticket::where(function ($query) use ($request) {
				if (!empty($request->staffId)) {
					$query->where('staffId', $request->staffId);
				}
				if (!empty($request->date_start)) {
					$query->where('created_at', '>=', $request->date_start . ' 00:00:00');
				}
				if (!empty($request->date_end)) {
					$query->where('created_at', '<=', $request->date_end . ' 23:59:59');
				}
			})->where('status', 4)->count();

		$usersSupport = User::where('level', 5)->get();

		// -------------------- ประเภทการให้บริการ (ตาราง) ให้ตรงกับกราฟ --------------------
		$count_service_type = Ticket::select(
				DB::raw('COUNT(id) AS count_service_type'),
				DB::raw('COALESCE(NULLIF(TRIM(service_type), ""), "") AS service_type')
			)
			->when(!empty($staffId), fn($q) => $q->where('staffId', $staffId))
			->whereBetween('created_at', [
				$rangeStart->format('Y-m-d 00:00:00'),
				$rangeEnd->format('Y-m-d 23:59:59')
			])
			->where('status', '!=', 4) // ไม่รวม Cancel ให้ตรงกับกราฟ
			->groupBy(DB::raw('COALESCE(NULLIF(TRIM(service_type), ""), "")'))
			->orderBy('count_service_type', 'desc')
			->orderBy(DB::raw('COALESCE(NULLIF(TRIM(service_type), ""), "")'), 'asc')
			->get();

		// -------------------- ช่องทาง, โปรแกรม, อื่น ๆ (คงเงื่อนไขเดิม) --------------------
		$count_service_channel = Ticket::select(DB::raw('count(id) as count_service_channel'), 'service_channel')
			->where(function ($query) use ($request) {
				if (!empty($request->staffId)) {
					$query->where('staffId', $request->staffId);
				}
				if (!empty($request->date_start)) {
					$query->where('created_at', '>=', $request->date_start . ' 00:00:00');
				}
				if (!empty($request->date_end)) {
					$query->where('created_at', '<=', $request->date_end . ' 23:59:59');
				}
			})
			->groupBy('service_channel')
			->orderBy('count_service_channel', 'desc')
			->orderBy('service_channel', 'asc')
			->get();

		$programtickets = Ticket::select('program')
			->when(!empty($request->staffId), function ($query) use ($request) {
				return $query->where('staffId', $request->staffId);
			})
			->when(!empty($request->date_start), function ($query) use ($request) {
				$query->where('created_at', '>=', $request->date_start . ' 00:00:00');
			})
			->when(!empty($request->date_end), function ($query) use ($request) {
				$query->where('created_at', '<=', $request->date_end . ' 23:59:59');
			})
			->get();

		$program_count = [];
		foreach ($programtickets as $programticket) {
			$programs = array_map('trim', explode(',', $programticket->program));
			foreach ($programs as $program) {
				if (!empty($program)) {
					if (!isset($program_count[$program])) {
						$program_count[$program] = 0;
					}
					$program_count[$program]++;
				}
			}
		}
		$count_program = collect($program_count)
			->map(fn($count, $program) => (object)['program_name' => $program, 'count_program' => $count])
			->sortByDesc('count_program')
			->values()
			->all();

		$count_company = Ticket::select(
				DB::raw('count(id) as count_company'),
				DB::raw('REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(LOWER(company),";",""),"-",""),".",""),",","")," ",""), "coltd", ""),"pcl",""),"\'",""),"(thailand)",""),"companylimited",""),"public","") as cut_company'),
				'company'
			)
			->where(function ($query) use ($request) {
				if (!empty($request->staffId)) {
					$query->where('staffId', $request->staffId);
				}
				if (!empty($request->date_start)) {
					$query->where('created_at', '>=', $request->date_start . ' 00:00:00');
				}
				if (!empty($request->date_end)) {
					$query->where('created_at', '<=', $request->date_end . ' 23:59:59');
				}
			})
			->groupBy('cut_company')
			->orderBy('count_company', 'desc')
			->orderBy('cut_company', 'asc')
			->limit(10)
			->get();

		$emailTickets = Ticket::select('email_cc')
			->when(!empty($request->staffId), function ($query) use ($request) {
				return $query->where('staffId', $request->staffId);
			})
			->when(!empty($request->date_start), function ($query) use ($request) {
				$query->where('created_at', '>=', $request->date_start . ' 00:00:00');
			})
			->when(!empty($request->date_end), function ($query) use ($request) {
				$query->where('created_at', '<=', $request->date_end . ' 23:59:59');
			})
			->get();

		$email_count = [];
		foreach ($emailTickets as $emailTicket) {
			$emails = !is_null($emailTicket->email_cc) ? array_map('trim', explode(',', $emailTicket->email_cc)) : [''];
			foreach ($emails as $email) {
				$email = $email === '' ? '' : $email;
				if (!isset($email_count[$email])) {
					$email_count[$email] = 0;
				}
				$email_count[$email]++;
			}
		}
		$count_sales = collect($email_count)
			->map(fn($count, $email) => (object)['email_cc' => $email, 'count_sales' => $count])
			->sortByDesc('count_sales')
			->values()
			->take(10)
			->all();

		$score = Ticket::select(DB::raw('sum(score) as sum_score'), DB::raw('count(score) as count_score'))
			->where(function ($query) use ($request) {
				if (!empty($request->staffId)) {
					$query->where('staffId', $request->staffId);
				}
				if (!empty($request->date_start)) {
					$query->where('created_at', '>=', $request->date_start . ' 00:00:00');
				}
				if (!empty($request->date_end)) {
					$query->where('created_at', '<=', $request->date_end . ' 23:59:59');
				}
			})
			->whereNotNull('score')
			->get();

		$count_article = TbArticle::where(function ($query) use ($request) {
				if (!empty($request->staffId)) {
					$query->where('user_id', $request->staffId);
				}
				if (!empty($request->date_start)) {
					$query->where('created_at', '>=', $request->date_start . ' 00:00:00');
				}
				if (!empty($request->date_end)) {
					$query->where('created_at', '<=', $request->date_end . ' 23:59:59');
				}
			})->count();

		$count_view_article = TbArticle::where(function ($query) use ($request) {
				if (!empty($request->staffId)) {
					$query->where('user_id', $request->staffId);
				}
				if (!empty($request->date_start)) {
					$query->where('created_at', '>=', $request->date_start . ' 00:00:00');
				}
				if (!empty($request->date_end)) {
					$query->where('created_at', '<=', $request->date_end . ' 23:59:59');
				}
			})->sum('art_view');

		$count_topview_article = TbArticle::select(DB::raw('sum(art_view) as sum_view'), 'art_name', 'art_parmalink')
			->where(function ($query) use ($request) {
				if (!empty($request->staffId)) {
					$query->where('user_id', $request->staffId);
				}
				if (!empty($request->date_start)) {
					$query->where('created_at', '>=', $request->date_start . ' 00:00:00');
				}
				if (!empty($request->date_end)) {
					$query->where('created_at', '<=', $request->date_end . ' 23:59:59');
				}
			})
			->groupBy('id')
			->orderBy('sum_view', 'desc')
			->orderBy('created_at', 'desc')
			->limit(10)
			->get();

		$ticketDuration = Ticket::query()
			->select(DB::raw('AVG(duration_seconds) AS average_duration_seconds'))
			->fromSub(function ($query) use ($request) {
				$query->from('ticket')
					->selectRaw("
						TIMESTAMPDIFF(
							SECOND,
							MIN(CASE WHEN history_ticket.status = 1 THEN history_ticket.created_at END),
							MIN(CASE WHEN history_ticket.status = 2 THEN history_ticket.created_at END)
						) AS duration_seconds
					")
					->leftJoin('history_ticket', 'ticket.id', '=', 'history_ticket.ticketId')
					->leftJoin('holiday', function ($join) {
						$join->on(DB::raw('DATE(history_ticket.created_at)'), '=', 'holiday.date');
					})
					->where('ticket.status', '!=', 4)
					->whereIn('history_ticket.status', [1, 2])
					->whereNotNull('history_ticket.created_at')
					->whereNull('holiday.id')
					->whereRaw("WEEKDAY(history_ticket.created_at) BETWEEN 0 AND 4")
					->where(function ($q) {
						$q->where(function ($q2) {
							$q2->where('history_ticket.status', 1)
							   ->whereRaw("TIME_FORMAT(history_ticket.created_at, '%H%i') BETWEEN '0830' AND '1700'");
						})
						->orWhere('history_ticket.status', 2);
					})
					->when(!empty($request->staffId) && $request->staffId !== 'all', function ($q) use ($request) {
						$q->where('ticket.staffId', $request->staffId);
					})
					->when(!empty($request->date_start), function ($query) use ($request) {
						$query->where('ticket.created_at', '>=', $request->date_start . ' 00:00:00');
					})
					->when(!empty($request->date_end), function ($query) use ($request) {
						$query->where('ticket.created_at', '<=', $request->date_end . ' 23:59:59');
					})
					->groupBy('ticket.id')
					->havingRaw("MIN(CASE WHEN history_ticket.status = 1 THEN history_ticket.created_at END) IS NOT NULL")
					->havingRaw("MIN(CASE WHEN history_ticket.status = 2 THEN history_ticket.created_at END) IS NOT NULL");
			}, 'durations')
			->value('average_duration_seconds');

		$ticketDurationTime = $this->formatDuration($ticketDuration);
		/*
		$count_request_by = Ticket::select(DB::raw('count(id) as count_request_by'), 'request_by')
			->where(function ($query) use ($request) {
				if (!empty($request->staffId)) {
					$query->where('staffId', $request->staffId);
				}
				if (!empty($request->date_start)) {
					$query->where('created_at', '>=', $request->date_start . ' 00:00:00');
				}
				if (!empty($request->date_end)) {
					$query->where('created_at', '<=', $request->date_end . ' 23:59:59');
				}
			})
			->groupBy('request_by')
			->orderBy('count_request_by', 'desc')
			->orderBy('request_by', 'asc')
			->get();
		*/
		
		$count_request_channel = Ticket::select(DB::raw('count(id) as count_request_channel'), 'request_channel')
			->where(function ($query) use ($request) {
				if (!empty($request->staffId)) {
					$query->where('staffId', $request->staffId);
				}
				if (!empty($request->date_start)) {
					$query->where('created_at', '>=', $request->date_start . ' 00:00:00');
				}
				if (!empty($request->date_end)) {
					$query->where('created_at', '<=', $request->date_end . ' 23:59:59');
				}
			})
			->groupBy('request_channel')
			->orderBy('count_request_channel', 'desc')
			->orderBy('request_channel', 'asc')
			->get();

		$count_department = Ticket::select(DB::raw('count(id) as count_department'), 'department')
			->where(function ($query) use ($request, $staffId) {
				if (!empty($staffId)) {
					$query->where('staffId', $staffId);
				}
				if (!empty($request->date_start)) {
					$query->where('created_at', '>=', $request->date_start . ' 00:00:00');
				}
				if (!empty($request->date_end)) {
					$query->where('created_at', '<=', $request->date_end . ' 23:59:59');
				}
			})
			->groupBy('department')
			->orderBy('count_department', 'desc')
			->orderBy('department', 'asc')
			->get();

		// -------------------- Monthly Ticket (exclude cancel) vs Last Year --------------------
		// ใช้ช่วงเดียวกับ $rangeStart/$rangeEnd เพื่อความสอดคล้อง
		$start = $rangeStart->copy();
		$end   = $rangeEnd->copy();

		$startPrev = $start->copy()->subYear();
		$endPrev   = $end->copy()->subYear();

		$buildMonthlyCounts = function ($from, $to) use ($request) {
			$q = Ticket::query()
				->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as ym, COUNT(*) as c')
				->where('status', '!=', 4)
				->whereBetween('created_at', [$from->format('Y-m-d 00:00:00'), $to->format('Y-m-d 23:59:59')]);

			if (!empty($request->staffId)) {
				$q->where('staffId', $request->staffId);
			}

			$rows = $q->groupBy('ym')->orderBy('ym')->get();

			$map = [];
			foreach ($rows as $r) {
				$map[$r->ym] = (int) $r->c;
			}
			return $map;
		};

		$currMap = $buildMonthlyCounts($start, $end);
		$prevMap = $buildMonthlyCounts($startPrev, $endPrev);

		$labels     = [];
		$currValues = [];
		$prevValues = [];

		$cursor = $start->copy();
		while ($cursor <= $end) {
			$ym = $cursor->format('Y-m');
			$labels[] = $cursor->format('M Y');
			$currValues[] = $currMap[$ym] ?? 0;

			$ymPrev = $cursor->copy()->subYear()->format('Y-m');
			$prevValues[] = $prevMap[$ymPrev] ?? 0;

			$cursor->addMonth();
		}

		// -------------------- Service Type (stacked monthly) vs Last Year --------------------
		$buildMonthlyByServiceType = function ($from, $to) use ($request) {
			$q = Ticket::query()
				->selectRaw('
					DATE_FORMAT(created_at, "%Y-%m") AS ym,
					COALESCE(NULLIF(TRIM(service_type), ""), "") AS service_type,
					COUNT(*) AS c
				')
				->where('status', '!=', 4)
				->whereBetween('created_at', [$from->format('Y-m-d 00:00:00'), $to->format('Y-m-d 23:59:59')]);

			if (!empty($request->staffId)) {
				$q->where('staffId', $request->staffId);
			}

			$rows = $q->groupBy('ym', 'service_type')->orderBy('ym')->get();

			$map = [];
			foreach ($rows as $r) {
				$type = (string) $r->service_type; // '' = ไม่ได้ระบุ
				if (!isset($map[$type])) $map[$type] = [];
				$map[$type][$r->ym] = (int) $r->c;
			}
			return $map;
		};

		$currTypeMap = $buildMonthlyByServiceType($start, $end);
		$prevTypeMap = $buildMonthlyByServiceType($startPrev, $endPrev);

		$allServiceTypes = array_values(array_unique(array_merge(array_keys($currTypeMap), array_keys($prevTypeMap))));
		sort($allServiceTypes, SORT_NATURAL | SORT_FLAG_CASE);

		$stackCurr = [];
		$stackPrev = [];
		foreach ($allServiceTypes as $t) {
			$seriesCurr = [];
			$seriesPrev = [];

			$cursor = $start->copy();
			while ($cursor <= $end) {
				$ym     = $cursor->format('Y-m');
				$ymPrev = $cursor->copy()->subYear()->format('Y-m');

				$seriesCurr[] = $currTypeMap[$t][$ym] ?? 0;
				$seriesPrev[] = $prevTypeMap[$t][$ymPrev] ?? 0;

				$cursor->addMonth();
			}
			$stackCurr[$t] = $seriesCurr;
			$stackPrev[$t] = $seriesPrev;
		}
		
		// ----- Dept chart arrays (labels/values) -----
		$dept_labels = $count_department
			->map(fn($d) => $d->department ?: 'ไม่ได้ระบุ')
			->values()
			->all();

		$dept_values = $count_department
			->map(fn($d) => (int) $d->count_department)
			->values()
			->all();



		$dd_department = $this->GetPosition();

		return view('admin.ticket.dashboard', [
			'breadcrumb'            => $breadcrumb,
			'title_page'            => $title_page,
			'data'                  => '',
			'count'                 => $count,
			'openTicket'            => $openTicket,
			'inprogressTicket'      => $inprogressTicket,
			'closedTicket'          => $closedTicket,
			'cancelTicket'          => $cancelTicket,
			'usersSupport'          => $usersSupport,
			'count_service_type'    => $count_service_type,
			'count_service_channel' => $count_service_channel,
			'count_program'         => $count_program,
			'count_company'         => $count_company,
			'count_sales'           => $count_sales,
			'count_article'         => $count_article,
			'count_view_article'    => $count_view_article,
			'count_topview_article' => $count_topview_article,
			'score'                 => $score,
			'staffId'               => $staffId,
			'date_start'            => $date_start,
			'date_end'              => $date_end,
			'ticketDurationTime'    => $ticketDurationTime,
			//'count_request_by'      => $count_request_by,
			'count_request_channel'	=> $count_request_channel,
			'count_department'      => $count_department,

			// กราฟหลัก
			'chart_month_labels' => $labels,
			'chart_month_current'=> $currValues,
			'chart_month_prev'   => $prevValues,

			// กราฟ Stacked Service Type
			'stack_labels' => $labels,
			'stack_types'  => $allServiceTypes,
			'stack_curr'   => $stackCurr,
			'stack_prev'   => $stackPrev,
			
			'dept_labels' => $dept_labels,
			'dept_values' => $dept_values,

			'dd_department' => $dd_department,
		]);
	}


    public function jsonDatatableStaff(Request $request){

        $month = $request->get('month');
        $year = $request->get('year');

        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->get('search');
        $order = $request->get('order');

        $columnorder = array(
            'program',
            'total',
        );

        if (empty($order)) {
            $sort = 'created_at';
            $dir = 'desc';
        } else {
            $sort = $columnorder[$order[0]['column']];
            $dir = $order[0]['dir'];
        }

        $data = Ticket::select(DB::raw('count(program) as Total', 'program'),'program')
        ->when($month, function ($query, $month) {
            if(!empty($month)){
                return $query->whereMonth('created_at',$month);
            }
        })
        ->when($year, function ($query, $year) {
            if(!empty($year)){
                return $query->whereYear('created_at',$year);
            }
        })
        ->where('program','!=','')
        ->limit(10)
        ->get();

        $recordsTotal = Ticket::select(DB::raw('count(program) as Total', 'program'),'program')
        ->when($month, function ($query, $month) {
            if(!empty($month)){
                return $query->whereMonth('created_at',$month);
            }
        })
        ->when($year, function ($query, $year) {
            if(!empty($year)){
                return $query->whereYear('created_at',$year);
            }
        })
        ->where('program','!=','')
        ->limit(10)
        ->count();

        $recordsFiltered = Ticket::select(DB::raw('count(program) as Total', 'program'),'program')
        ->when($month, function ($query, $month) {
            if(!empty($month)){
                return $query->whereMonth('created_at',$month);
            }
        })
        ->when($year, function ($query, $year) {
            if(!empty($year)){
                return $query->whereYear('created_at',$year);
            }
        })
        ->where('program','!=','')
        ->limit(10)
        ->count();

        return Datatables::of($data)
            ->addColumn('program', function ($data) {
                return $data->program;
            })
            ->addColumn('total', function ($data) {
                return number_format($data->Total);
            })
            ->setTotalRecords($recordsTotal)
            ->setFilteredRecords($recordsFiltered)
            ->escapeColumns([])
            ->skipPaging()
            ->addIndexColumn()
            ->make(true);

    }

    public function seandmail($id){


        $setting  = TbSetting::first();
        $page     = TbPagesMap::first();

        $ticket = Ticket::findOrFail($id);

        if(!empty($ticket)){
            $ticketFile         = TicketFile::where('ticketId',$ticket->id)->get();

            $data = new \stdClass();
            $data->setting_nameWeb = $setting->setting_nameWeb;
            $data->setting_logoWeb = $setting->setting_logoWeb;
            $data->setting_email_bcc = $setting->setting_email_bcc;
            $data->page            = $page;
            $data->ticket          = $ticket;
            $data->ticketFile      = $ticketFile;
            $data->name            = $ticket->name;
            $data->subject         = "[Ticket ID : ".$ticket->code."] ".$ticket->subject;
            $data->customer_email  = $ticket->email;

            if(!empty($ticket->email)){

                $emailCustomer            = explode(",",$ticket->email);
                $data->emailCustomer      = $emailCustomer;

                $emailSupport             = explode(",",$setting->setting_email_support);
                $data->emailSupport       = $emailSupport;

                if(!empty($setting->setting_email_support)){
					
					try{
						Mail::send('emails.TicketForUser', ['data' => $data], function ($m) use ($data) {
							$m->to($data->emailCustomer, $data->name)
							->bcc($data->emailSupport,'Support '.$data->setting_nameWeb)
							->replyTo($data->emailSupport, $data->setting_nameWeb)
							->subject($data->subject);

							if(!empty($data->ticketFile)){
								foreach ($data->ticketFile as $file){
									$m->attach(asset('storage/ticket/'.$file->name));
								}
							}
						});
						
						if(Mail::failures()) { $status = 2; $mailStatus = 'ล้มเหลว'; }else{ $status = 1; $mailStatus = 'สำเร็จ'; }
					}catch(\Exception $e){
						// Never reached
						$status = 2;
						$mailStatus = 'ล้มเหลว';
					}
                    
                }else{
                    
					try{
						Mail::send('emails.TicketForUser', ['data' => $data], function ($m) use ($data) {
							$m->to($data->emailCustomer, $data->name)
							->bcc($data->setting_email_bcc,'Support '.$data->setting_nameWeb)
							->replyTo($data->setting_email_bcc, $data->setting_nameWeb)
							->subject($data->subject);

							if(!empty($data->ticketFile)){
								foreach ($data->ticketFile as $file){
									$m->attach(asset('storage/ticket/'.$file->name));
								}
							}
						});
						
						if(Mail::failures()) { $status = 2; $mailStatus = 'ล้มเหลว'; }else{ $status = 1; $mailStatus = 'สำเร็จ'; }
					}catch(\Exception $e){
						// Never reached
						$status = 2;
						$mailStatus = 'ล้มเหลว';
					}
                }

                $history                            = new HistoryTicket;
                $history->mailStatus                = $status;
                $history->mailRemark                = $mailStatus;
                $history->updated_by                = 'SYSTEM';
                $history->created_at                = date('Y-m-d H:i:s');
                $history->updated_at                = date('Y-m-d H:i:s');
                $history->save();

                return back()->with('feedback', 'ส่งอีเมลเรียบร้อยแล้ว!');

            }
        }else{
            return back()->with('feedback-er', 'ไม่พบข้อมูล!');
        }

    }
	
	public function getNotify(){
		
		$user = Auth::user();
		
		$ticket = array();
		
		// Support & admin
		if($user->level == 5 || $user->level == 7){
			$notiticket = Notiticket::where('userid',$user->id)->first();
			
			if(!empty($notiticket)){
				
				$ticket = Ticket::where('id', '>', $notiticket->last_ticketid)->where('status','1')->orderBy('id','asc')->first();
				//$ticket = Ticket::where('id', '>', $notiticket->last_ticketid)->orderBy('id','asc')->first();
				
				if(!empty($ticket)){
					//Updated
					$data = Notiticket::findOrfail($notiticket->id);
					$data->last_ticketid = $ticket->id;
					$data->save();
				}
				
			}else{
				
				$ticket = Ticket::where('status','1')->orderBy('id','asc')->first();
				//$ticket = Ticket::orderBy('id','asc')->first();
				
				if(!empty($ticket)){
					//Insert
					$data = new Notiticket;
					$data->userid = $user->id;
					$data->last_ticketid = $ticket->id;
					$data->save();
				}
			}
			
			$noti_ticket = array();
			
			if(!empty($ticket)){
				$noti_ticket['id'] = $ticket->id;
				$noti_ticket['name'] = $ticket->name;
				$noti_ticket['lastname'] = $ticket->lastname;
				$noti_ticket['company'] = $ticket->company;
				$noti_ticket['subject'] = $ticket->subject;
				$noti_ticket['program'] = $ticket->program;
			}
		}
		
		return json_encode($noti_ticket,JSON_UNESCAPED_UNICODE);
		
	}
	
	public function formatDuration($seconds) {
		
		$hours = floor($seconds / 3600);
		$minutes = floor(($seconds % 3600) / 60);
		$remainingSeconds = $seconds % 60;
		$parts = [];

		if ($hours > 0) {
			$parts[] = $hours . ' ชั่วโมง';
		}
		if ($minutes > 0) {
			$parts[] = $minutes . ' นาที';
		}
		if ($remainingSeconds > 0 || count($parts) == 0) {
			$parts[] = $remainingSeconds . ' วินาที';
		}

		return implode(' ', $parts);
		
	}
	
	public function getAllData(Request $request)
	{
		$type = $request->type;
		$staffId = $request->staffId;
		$date_start = $request->date_start;
		$date_end = $request->date_end;
		$data = [];

		if ($type == 'count_company') {
			$data = Ticket::select(DB::raw('count(id) as count_company'), 'company')
				->when($staffId, fn($q) => $q->where('staffId', $staffId))
				->when($date_start, fn($q) => $q->where('created_at', '>=', $date_start . ' 00:00:00'))
				->when($date_end, fn($q) => $q->where('created_at', '<=', $date_end . ' 23:59:59'))
				->groupBy('company')
				->orderBy('count_company', 'desc')
				->get();
		} elseif ($type == 'count_sales') {
			$data = Ticket::select(DB::raw('count(id) as count_sales'), 'email_cc')
				->when($staffId, fn($q) => $q->where('staffId', $staffId))
				->when($date_start, fn($q) => $q->where('created_at', '>=', $date_start . ' 00:00:00'))
				->when($date_end, fn($q) => $q->where('created_at', '<=', $date_end . ' 23:59:59'))
				->groupBy('email_cc')
				->orderBy('count_sales', 'desc')
				->get();
		} elseif ($type == 'count_topview_article') {
			$data = TbArticle::select(DB::raw('sum(art_view) as sum_view'), 'art_name', 'art_parmalink')
				->when($staffId, fn($q) => $q->where('user_id', $staffId))
				->when($date_start, fn($q) => $q->where('created_at', '>=', $date_start . ' 00:00:00'))
				->when($date_end, fn($q) => $q->where('created_at', '<=', $date_end . ' 23:59:59'))
				->groupBy('id')
				->orderBy('sum_view', 'desc')
				->get();
		} elseif ($type == 'count_request_channel') {
			$data = Ticket::select(DB::raw('count(id) as count_request_channel'), 'request_channel')
				->when($staffId, fn($q) => $q->where('staffId', $staffId))
				->when($date_start, fn($q) => $q->where('created_at', '>=', $date_start . ' 00:00:00'))
				->when($date_end, fn($q) => $q->where('created_at', '<=', $date_end . ' 23:59:59'))
				->groupBy('request_channel')
				->orderBy('count_request_channel', 'desc')
				->get();
		}

		return view('admin.ticket.modal_data', compact('data', 'type'));
	}
	
	public function GetPosition(){
		
		$position = Array();
		$position['CI-2D'] = 'CI-2D';
		$position['CI-3D'] = 'CI-3D';
		$position['CI-8Baht'] = 'CI-8Baht';
		$position['EDU&GOV'] = 'EDU&GOV';
		$position['MI-Hardware'] = 'MI-Hardware';
		$position['MI-Software'] = 'MI-Software';
		$position['Service without purchase'] = 'Service without purchase';
		
		return $position;
		
	}
	
	public function GetRequestChannelType(){

		$requestChannelType = Array();
		$requestChannelType['LineOA'] = 'LineOA';
		$requestChannelType['LiveChat'] = 'LiveChat';
		$requestChannelType['Facebook'] = 'Facebook';
		$requestChannelType['Phone'] = 'Phone';
		$requestChannelType['Website'] = 'Website';
		$requestChannelType['8Baht_Tools'] = '8Baht_Tools';
		$requestChannelType['8Baht_Docs'] = '8Baht_Docs';
		$requestChannelType['Support'] = 'Support';
		$requestChannelType['Sales'] = 'Sales';

		return $requestChannelType;

	}

}
