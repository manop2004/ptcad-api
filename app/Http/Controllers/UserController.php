<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Providers\RouteServiceProvider;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\UsersLevel;
use App\Models\TbLevel;
use App\Models\TbLevelMenu;
use App\Models\TbArticle;
use App\Models\HistoryChangeDisplay;
use App\Models\TbSettingMonth;
use App\Models\TbSettingUser;
use App\Models\UsersAddress;
use App\Models\TbBrand;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
	{
		$breadcrumb = [
			['name' => 'บัญชีผู้ใช้'],
		];

		$title_page = 'บัญชีผู้ใช้';

		$count = User::where('email', '!=', 'system@programmer.com')->count();

		$UserLevel = UsersLevel::where('UserId', Auth::user()->id)->first();

		$levels = TbLevel::where('status', 1)
			->orderBy('number', 'asc')
			->orderBy('id', 'asc')
			->get();

		return view('admin.user.main', [
			'breadcrumb' => $breadcrumb,
			'title_page' => $title_page,
			'count' => $count,
			'data' => '',
			'UserLevel' => $UserLevel,
			'levels' => $levels,
		]);
	}

    public function add(){

        $breadcrumb = [
            ['name' => 'เพิ่มบัญชีผู้ใช้'],
        ];
        $title_page = 'เพิ่มบัญชีผู้ใช้';

        $users = User::select(
            'users.level','users.name','users.lastname','users.id',
            'tb_level.number'
        )
        ->leftjoin('tb_level','tb_level.id','users.level')
        ->where('tb_level.number',2)
        ->get();

        $levels = TbLevel::where('status',1)->get();
        $months = TbSettingMonth::get();
        $UserLevel = UsersLevel::where('UserId',Auth::user()->id)->first();

        return view('admin.user.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => '',
            'levels' => $levels,
            'months' => $months,
            'history_penname' => '',
            'UserLevel' => $UserLevel,
            'users' => $users,
        ]);

    }

    public function crate(Request $request){

        $request->validate(
            [
                'displayname' => 'required|max:255|unique:users',
                'email' => 'required|email|max:255|unique:users',
                'name' => 'required|max:255',
                'lastname' => 'required|max:255',
                'password' => 'required|max:255|min:8',
            ],
            [
                'displayname.required' => 'กรุณากรอกข้อมูล',
                'displayname.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'displayname.unique' => 'ชื่อนี้มีการใช้งานอยู่แล้ว กรุณาตรวจสอบข้อมูลอีกครั้ง',
                'email.required' => 'กรุณากรอกข้อมูล',
                'email.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'email.email' => 'กรุณากรอกข้อมูล รูปแบบอีเมลไม่ถูกต้อง',
                'email.unique' => 'อีเมลนี้มีการใช้งานอยู่แล้ว กรุณาตรวจสอบข้อมูลอีกครั้ง',
                'name.required' => 'กรุณากรอกข้อมูล',
                'name.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'lastname.required' => 'กรุณากรอกข้อมูล',
                'lastname.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'password.required' => 'กรุณากรอกข้อมูล',
                'password.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'password.min' => 'รหัสผ่านต้องมากกว่า 8 ตัวอักษร',
            ]
        );



        if($request->pdpa_news != ""){
            $pdpa_news = 1;
        }else{
            $pdpa_news = 2;
        }

        if($request->pdpa_article != ""){
            $pdpa_article = 1;
        }else{
            $pdpa_article = 2;
        }

        if($request->pdpa_product != ""){
            $pdpa_product = 1;
        }else{
            $pdpa_product = 2;
        }

        $data = new User;
        $data->user_code                    = $this->generateRandomString();
        $data->staffId                      = $request->staffId;
        $data->displayname                  = $request->displayname;
        $data->email                        = $request->email;
        $data->password                     = Hash::make($request->password);
        $data->name                         = $request->name;
        $data->lastname                     = $request->lastname;
        $data->sex                          = $request->sex;
        $data->tel                          = $request->tel;
        $data->level                        = $request->level;
        $data->hbd_day                      = $request->hbd_day;
        $data->hbd_month                    = $request->hbd_month;
        $data->hbd_year                     = $request->hbd_year;
        $data->user_type                    = $request->user_type;
        $data->pdpa_news                    = $pdpa_news;
        $data->pdpa_article                 = $pdpa_article;
        $data->pdpa_product                 = $pdpa_product;
        $data->update_by                    = Auth::user()->displayname;
        $data->updated_at                   = now();

        if (!empty($request->img)) {
            if ($request->hasFile('img')) {
                $newFilename = uniqid() . '.' . $request->img->extension();
                $data->img = $newFilename;
                $file = $request->file('img');
                $file->move('storage/avatar/', $newFilename);
            }

        }

        $data->save();

        $menu = TbLevelMenu::where('id',$data->level)->first();

        $level = new UsersLevel;
        $level->UserId                      = $data->id;
        $level->l_artlicle                  = $menu->l_artlicle;
        $level->l_promotion                 = $menu->l_promotion;
        $level->l_software                  = $menu->l_software;
        $level->l_program                   = $menu->l_program;
        $level->l_page                      = $menu->l_page;
        $level->l_category                  = $menu->l_category;
        $level->l_customcode                = $menu->l_customcode;
        $level->l_setting                   = $menu->l_setting;
        $level->l_user                      = $menu->l_user;
        $level->l_bank                      = $menu->l_bank;
        $level->l_banner                    = $menu->l_banner;
        $level->l_product                   = $menu->l_product;
        $level->l_product_Import            = $menu->l_product_Import;
        $level->l_product_Export            = $menu->l_product_Export;
        $level->l_product_Action            = $menu->l_product_Action;
        $level->l_membergetmember           = $menu->l_membergetmember;
        $level->l_membergetmember_setting   = $menu->l_membergetmember_setting;
        $level->l_quotation                 = $menu->l_quotation;
        $level->l_quotation_setting         = $menu->l_quotation_setting;
        $level->l_recommend                 = $menu->l_recommend;
        $level->l_ticket                    = $menu->l_ticket;
        $level->crate_by                    = Auth::user()->displayname;
        $level->update_by                   = Auth::user()->displayname;
        $level->created_at                  = now();
        $level->updated_at                  = now();
        $level->save();

        return redirect()->route('user.edit',[$data->id])->with('feedback', 'เพิ่มข้อมูลเรียบร้อยแล้ว!');

    }

    public function edit($id)
    {

        $UserLevel          = User::where('id',Auth::user()->id)->where('level','!=',6)->count();
        if($UserLevel  != 0){


            $breadcrumb = [
                ['name' => 'อัพเดตบัญชีผู้ใช้'],
            ];
            $title_page = 'อัพเดตบัญชีผู้ใช้';

            $check = User::where('id',$id)->count();

            if($check != 0){
                $data           = User::findOrFail($id);
            }else{
                $data           = User::where('user_code',$id)->first();
            }

            $levels             = TbLevel::where('status',1)->get();
            $articleCount       = TbArticle::where('created_by',$data->displayname)->count();
            $history_penname    = HistoryChangeDisplay::where('userId',$id)->count();
            $months             = TbSettingMonth::get();
            $UserLevel          = UsersLevel::where('UserId',Auth::user()->id)->first();
            $users = User::select(
                'users.level','users.name','users.lastname','users.id',
                'tb_level.number'
            )
            ->leftjoin('tb_level','tb_level.id','users.level')
            ->where('tb_level.number',2)
            ->get();

            return view('admin.user.form', [
                'breadcrumb' => $breadcrumb,
                'title_page' => $title_page,
                'data' => $data,
                'levels' => $levels,
                'months' => $months,
                'articleCount' => $articleCount,
                'history_penname' => $history_penname,
                'UserLevel' => $UserLevel,
                'users' => $users,
            ]);
        }else{

            Auth::logout();
            return redirect()->route('home');

        }
    }

    public function updateStaff(Request $request,$id){

        $request->validate(
            [
                'staffId' => 'required'
            ],
            [
                'staffId.required' => 'กรุณาเลือกข้อมูล',
            ]
        );

        $data = User::findOrFail($id);
        $data->staffId                      = $request->staffId;
        $data->staff_update_by              = Auth::user()->displayname;
        $data->staff_update_at              = now();
        $data->save();


        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function update(Request $request,$id){

        $request->validate(
            [
                'displayname' => 'required|max:255|unique:users,displayname,'.$id,
                'email' => 'required|email|max:255|unique:users,email,'.$id,
                'name' => 'required|max:255',
                'lastname' => 'required|max:255',
            ],
            [
                'displayname.required' => 'กรุณากรอกข้อมูล',
                'displayname.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'displayname.unique' => 'ชื่อนี้มีการใช้งานอยู่แล้ว กรุณาตรวจสอบข้อมูลอีกครั้ง',
                'email.required' => 'กรุณากรอกข้อมูล',
                'email.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'email.email' => 'กรุณากรอกข้อมูล รูปแบบอีเมลไม่ถูกต้อง',
                'email.unique' => 'อีเมลนี้มีการใช้งานอยู่แล้ว กรุณาตรวจสอบข้อมูลอีกครั้ง',
                'name.required' => 'กรุณากรอกข้อมูล',
                'name.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'lastname.required' => 'กรุณากรอกข้อมูล',
                'lastname.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
            ]
        );

        $check_displayname = User::where('displayname',$request->displayname)->where('id',$id)->count();
        if($check_displayname == 0){
            $penname = new HistoryChangeDisplay ;
            $penname->userId                        = Auth::user()->id;
            $penname->displayname_new               = $request->displayname;
            $penname->displayname_old               = $request->displayname_old;
            $penname->updated_by                    = Auth::user()->name;
            $penname->save();
        }

        if($request->pdpa_news != ""){
            $pdpa_news = 1;
        }else{
            $pdpa_news = 2;
        }

        if($request->pdpa_article != ""){
            $pdpa_article = 1;
        }else{
            $pdpa_article = 2;
        }

        if($request->pdpa_product != ""){
            $pdpa_product = 1;
        }else{
            $pdpa_product = 2;
        }

        $data = User::findOrFail($id);

        if(empty($data->user_code)){
        $data->user_code                    = $this->generateRandomString();
        }
        $data->staffId                      = $request->staffId;
        $data->displayname                  = $request->displayname;
        $data->email                        = $request->email;
        $data->name                         = $request->name;
        $data->lastname                     = $request->lastname;
        $data->sex                          = $request->sex;
        $data->tel                          = $request->tel;
        $data->level                        = $request->level;
        $data->hbd_day                      = $request->hbd_day;
        $data->hbd_month                    = $request->hbd_month;
        $data->hbd_year                     = $request->hbd_year;
        if(!empty($request->user_type)){
            $data->user_type                    = $request->user_type;
        }
        $data->pdpa_news                    = $pdpa_news;
        $data->pdpa_article                 = $pdpa_article;
        $data->pdpa_product                 = $pdpa_product;
        $data->update_by                    = Auth::user()->displayname;
        $data->updated_at                   = now();

        if (!empty($request->img)) {

            if ($request->hasFile('img')) {
                @unlink(Storage::disk('public')->path('avatar/') . $request->img_old);

                $newFilename = uniqid() . '.' . $request->img->extension();
                $data->img = $newFilename;
                $file = $request->file('img');
                $file->move('storage/avatar/', $newFilename);
            }

        }

        $data->save();

        /*
        |--------------------------------------------------------------------------
        | Auto-create users_level record if missing
        |--------------------------------------------------------------------------
        | ป้องกันปัญหา Error 500 ตอน Admin คนใหม่ login เข้าหลังบ้าน
        | (เกิดจากตอน "ปรับยศ" ผ่านหน้านี้ ระบบไม่เคยสร้าง record ใน users_level
        | ให้อัตโนมัติเหมือนตอนสร้าง user ใหม่ผ่าน crate())
        |
        | เช็คก่อนว่ามี record อยู่แล้วหรือยัง ถ้ามีแล้ว "ไม่แตะ" เพื่อไม่ให้ไปรีเซ็ต
        | สิทธิ์ที่เคยตั้งไว้เองผ่านหน้า /setting/user/level/{id}
        |
        | ก็อปสิทธิ์จาก UserId = 260 (บัญชี Admin หลักตัวจริง) โดยตรง แทนที่จะดึงจาก
        | tb_level_menu เพราะตารางนั้นเป็นค่า default เก่าที่ปิดสิทธิ์ไว้เกือบทั้งหมด
        | ไม่ตรงกับสิทธิ์จริงที่ Admin หลักใช้งานอยู่
        */
        $MASTER_ADMIN_USER_ID = 260;

        $existingLevel = UsersLevel::where('UserId', $data->id)->first();

        if (empty($existingLevel)) {

            $masterLevel = UsersLevel::where('UserId', $MASTER_ADMIN_USER_ID)->first();

            if (!empty($masterLevel)) {
                $level = new UsersLevel;
                $level->UserId                      = $data->id;
                $level->l_artlicle                  = $masterLevel->l_artlicle;
                $level->l_promotion                 = $masterLevel->l_promotion;
                $level->l_software                  = $masterLevel->l_software;
                $level->l_program                   = $masterLevel->l_program;
                $level->l_page                      = $masterLevel->l_page;
                $level->l_category                  = $masterLevel->l_category;
                $level->l_customcode                = $masterLevel->l_customcode;
                $level->l_setting                   = $masterLevel->l_setting;
                $level->l_user                      = $masterLevel->l_user;
                $level->l_user_Action               = $masterLevel->l_user_Action;
                $level->l_user_staff_Action         = $masterLevel->l_user_staff_Action;
                $level->l_bank                       = $masterLevel->l_bank;
                $level->l_banner                    = $masterLevel->l_banner;
                $level->l_product                   = $masterLevel->l_product;
                $level->l_product_Import            = $masterLevel->l_product_Import;
                $level->l_product_Export            = $masterLevel->l_product_Export;
                $level->l_product_Action            = $masterLevel->l_product_Action;
                $level->l_membergetmember           = $masterLevel->l_membergetmember;
                $level->l_membergetmember_setting   = $masterLevel->l_membergetmember_setting;
                $level->l_quotation                 = $masterLevel->l_quotation;
                $level->l_quotation_setting         = $masterLevel->l_quotation_setting;
                $level->l_recommend                 = $masterLevel->l_recommend;
                $level->l_ticket                    = $masterLevel->l_ticket;
                $level->crate_by                    = Auth::user()->displayname;
                $level->update_by                   = Auth::user()->displayname;
                $level->created_at                  = now();
                $level->updated_at                  = now();
                $level->save();
            }
        }


        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function status($id){

        $data = User::findOrFail($id);

        if($data->status == 0){
            $status = 1;
        }else if($data->status == 1) {
            $status = 0;
        }

        $data->status               = $status;
        $data->update_by            = Auth::user()->displayname;
        $data->updated_at           = now();
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');
    }

    public function delete(Request $request){

        $check = User::findOrFail($request->deleteId);
        if(!empty($check)){
            @unlink(Storage::disk('public')->path('avatar/').$check->img);
        }

        User::where('id', $request->deleteId)->delete();

        return back()->with('feedback', 'ลบข้อมูลเรียบร้อยแล้ว!');
    }

    public function jsondata(Request $request)
    {

        $type = $request->get('type');

        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->get('search');
        $order = $request->get('order');

        $columnorder = array(
            'id',
            'name',
            'author',
            'tel',
            'email',
            'level',
            'lastlogin',
            'status',
        );

        if (empty($order)) {
            $sort = 'created_at';
            $dir = 'desc';
        } else {
            $sort = $columnorder[$order[0]['column']];
            $dir = $order[0]['dir'];
        }

        $data = User::where('email', '!=', 'system@programmer.com')
			->when($search, function ($query, $search) {
				return $query->where(function ($query) use ($search) {
					$query->orWhere('name', 'LIKE', '%' . $search . '%')
						->orWhere('company_name', 'LIKE', '%' . $search . '%')
						->orWhere('lastname', 'LIKE', '%' . $search . '%')
						->orWhere('user_code', 'LIKE', '%' . $search . '%')
						->orWhere('displayname', 'LIKE', '%' . $search . '%')
						->orWhere('email', 'LIKE', '%' . $search . '%')
						->orWhere('tel', 'LIKE', '%' . $search . '%');
				});
			})
			->when($type, function ($query, $type) {
				return $query->where('level', $type);
			})
			->orderBy('created_at', 'desc')
			->get();

        $recordsTotal = User::where('email','!=','system@programmer.com')
        ->when($search, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->orWhere('name', 'LIKE', '%' . $search . '%')
                      ->orWhere('company_name', 'LIKE', '%' . $search . '%')
                      ->orWhere('lastname', 'LIKE', '%' . $search . '%')
                      ->orWhere('displayname', 'LIKE', '%' . $search . '%')
                      ->orWhere('email', 'LIKE', '%' . $search . '%')
                      ->orWhere('tel', 'LIKE', '%' . $search . '%');
            });
        })
        ->when($type, function ($query, $type) {
			return $query->where('level', $type);
		})
        ->orderBy('created_at','desc')
        ->count();

        $recordsFiltered = User::where('email','!=','system@programmer.com')
        ->when($search, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->orWhere('name', 'LIKE', '%' . $search . '%')
                      ->orWhere('company_name', 'LIKE', '%' . $search . '%')
                      ->orWhere('lastname', 'LIKE', '%' . $search . '%')
                      ->orWhere('displayname', 'LIKE', '%' . $search . '%')
                      ->orWhere('email', 'LIKE', '%' . $search . '%')
                      ->orWhere('tel', 'LIKE', '%' . $search . '%');
            });
        })
        ->when($type, function ($query, $type) {
			return $query->where('level', $type);
		})
        ->orderBy('created_at','desc')
        ->count();

        return Datatables::of($data)
            ->addColumn('code', function ($data) {
                return $data->user_code;
            })
            ->addColumn('name', function ($data) {
                return $data->name.' '.$data->lastname;
            })
            ->addColumn('author', function ($data) {
                return $data->displayname;
            })
            ->addColumn('tel', function ($data) {
                return $data->tel;
            })
            ->addColumn('email', function ($data) {
                return $data->email;
            })
            ->addColumn('level', function ($data) {

                $level = TbLevel::where('id',$data->level)->first();
                return $level->name;
            })
            ->addColumn('lastlogin', function ($data) {
                return $data->lastlogin;
            })
            ->addColumn('status', function ($data) {
                return $data->status;
            })
            ->addColumn('actions', function ($data) {

                $UserLevel = UsersLevel::where('UserId',Auth::user()->id)->first();
                if($UserLevel->l_user_Action == 2){
                    if($UserLevel->l_user_staff_Action == 2){
                        return '<small class="text-danger">ไม่มีสิทธิ์เข้าถึง</small>';
                    }else{
                        return '<a href="'.route('user.edit',['id' => $data->id]).'" class="btn btn-warning btn-link btn-icon edit"><i class="fa fa-edit"></i></a>';
                    }
                }else{
                    $id = $data->id;
                    $name = $data->name;
                    $status = $data->status;
                    return view('admin.user.button', compact('id','status','name'));
                }
            })
            ->setTotalRecords($recordsTotal)
            ->setFilteredRecords($recordsFiltered)
            ->escapeColumns([])
            ->addIndexColumn()
            ->make(true);

    }

    public function jsonpenname($id)
    {

        $data = HistoryChangeDisplay::where('userId',$id)->get();

        return Datatables::of($data)
                ->addColumn('author_old', function ($data) {
                    return $data->displayname_old;
                })
                ->addColumn('count', function ($data) {
                    return number_format(TbArticle::where('created_by',$data->displayname_old)->count());
                })
                ->escapeColumns([])
                ->addIndexColumn()
                ->make(true);
    }

    public function profile($id){

        $breadcrumb = [
            ['name' => 'บัญชีผู้ใช้'],
        ];
        $title_page = 'บัญชีผู้ใช้';

        $user = User::findOrFail($id);
        $levels = TbLevel::where('status',1)->get();
        $articleCount = TbArticle::where('created_by',$user->displayname)->count();
        $months             = TbSettingMonth::get();
        $history_penname    = HistoryChangeDisplay::where('userId',$id)->count();

        return view('admin.user.profile', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => $user,
            'levels' => $levels,
            'articleCount' => $articleCount,
            'months' => $months,
            'history_penname' => $history_penname,
        ]);

    }

    public function level($id)
	{
		$breadcrumb = [
			['name' => 'ตั้งค่าสิทธิ์การใช้งานของผู้ใช้'],
		];

		$title_page = 'ตั้งค่าสิทธิ์การใช้งานของผู้ใช้';

		$user = User::findOrFail($id); // บัญชีผู้ใช้

		$userLevel = UsersLevel::where('UserId', $id)->first(); // เมนูที่ผู้ใช้สามารถเข้าถึง
		$level = TbLevel::findOrFail($user->level); // default level

        $levelTemplate = \App\Models\TbLevelMenu::where('level', $user->level)->first(); // [เพิ่มใหม่] แม่แบบสิทธิ์ของ Role นี้

		$brands = TbBrand::where('brand_show', 1)
			->whereNotNull('brand_name')
			->where('brand_name', '!=', '')
			->orderBy('brand_name', 'asc')
			->get();

		$selectedBrandIds = collect(explode(',', (string) $user->access_brand_id))
			->map(fn ($id) => (int) trim($id))
			->filter()
			->unique()
			->values()
			->toArray();

		return view('admin.user.level', [
			'breadcrumb' => $breadcrumb,
			'title_page' => $title_page,
			'data' => $user,
			'userLevel' => $userLevel,
			'level' => $level,
            'levelTemplate' => $levelTemplate,
			'brands' => $brands,
			'selectedBrandIds' => $selectedBrandIds,
		]);
	}

    public function levelupdate(Request $request, $id)
	{
		if ($request->l_artlicle == 1) {
			$l_artlicle = 1;
		} else {
			$l_artlicle = 2;
		}

		if ($request->l_promotion == 1) {
			$l_promotion = 1;
		} else {
			$l_promotion = 2;
		}

		if ($request->l_software == 1) {
			$l_software = 1;
		} else {
			$l_software = 2;
		}

		if ($request->l_program == 1) {
			$l_program = 1;
		} else {
			$l_program = 2;
		}

		if ($request->l_page == 1) {
			$l_page = 1;
		} else {
			$l_page = 2;
		}

		if ($request->l_category == 1) {
			$l_category = 1;
		} else {
			$l_category = 2;
		}

		if ($request->l_customcode == 1) {
			$l_customcode = 1;
		} else {
			$l_customcode = 2;
		}

		if ($request->l_setting == 1) {
			$l_setting = 1;
		} else {
			$l_setting = 2;
		}

		if ($request->l_user == 1) {
			$l_user = 1;
		} else {
			$l_user = 2;
		}

		if ($request->l_user_Action == 1) {
			$l_user_Action = 1;
		} else {
			$l_user_Action = 2;
		}

		if ($request->l_user_staff_Action == 1) {
			$l_user_staff_Action = 1;
		} else {
			$l_user_staff_Action = 2;
		}

		if ($request->l_bank == 1) {
			$l_bank = 1;
		} else {
			$l_bank = 2;
		}

		if ($request->l_banner == 1) {
			$l_banner = 1;
		} else {
			$l_banner = 2;
		}

		if ($request->l_product == 1) {
			$l_product = 1;
		} else {
			$l_product = 2;
		}

		if ($request->l_product_Import == 1) {
			$l_product_Import = 1;
		} else {
			$l_product_Import = 2;
		}

		if ($request->l_product_Export == 1) {
			$l_product_Export = 1;
		} else {
			$l_product_Export = 2;
		}

		if ($request->l_product_Action == 1) {
			$l_product_Action = 1;
		} else {
			$l_product_Action = 2;
		}

		if ($request->l_recommend == 1) {
			$l_recommend = 1;
		} else {
			$l_recommend = 2;
		}

		if ($request->l_ticket == 1) {
			$l_ticket = 1;
		} else {
			$l_ticket = 2;
		}

		if ($request->l_membergetmember == 1) {
			$l_membergetmember = 1;
		} else {
			$l_membergetmember = 2;
		}

		if ($request->l_membergetmember_setting == 1) {
			$l_membergetmember_setting = 1;
		} else {
			$l_membergetmember_setting = 2;
		}

		if ($request->l_quotation == 1) {
			$l_quotation = 1;
		} else {
			$l_quotation = 2;
		}

		if ($request->l_quotation_setting == 1) {
			$l_quotation_setting = 1;
		} else {
			$l_quotation_setting = 2;
		}

		/*
		|--------------------------------------------------------------------------
		| Update users.access_brand_id
		|--------------------------------------------------------------------------
		| รับค่าจาก checkbox name="access_brand_id[]"
		| บันทึกเป็น comma เช่น 1,24,50,51,54
		| และ validate เฉพาะ brand ที่ brand_show = 1 เท่านั้น
		*/

		$brandIds = collect($request->input('access_brand_id', []))
			->map(function ($brandId) {
				return trim($brandId);
			})
			->filter(function ($brandId) {
				return is_numeric($brandId);
			})
			->map(function ($brandId) {
				return (int) $brandId;
			})
			->unique()
			->values()
			->toArray();

		$validBrandIds = TbBrand::where('brand_show', 1)
			->whereIn('id', $brandIds)
			->pluck('id')
			->map(function ($brandId) {
				return (int) $brandId;
			})
			->unique()
			->values()
			->toArray();

		$user = User::findOrFail($id);
		$user->access_brand_id = count($validBrandIds) > 0 ? implode(',', $validBrandIds) : null;
		$user->update_by = Auth::user()->displayname;
		$user->updated_at = now();
		$user->save();

		/*
		|--------------------------------------------------------------------------
		| Update users_level permission
		|--------------------------------------------------------------------------
		*/

		$check = UsersLevel::where('UserId', $id)->first();

		if (!empty($check)) {
			$level = $check;

			$level->l_artlicle = $l_artlicle;
			$level->l_promotion = $l_promotion;
			$level->l_software = $l_software;
			$level->l_program = $l_program;
			$level->l_page = $l_page;
			$level->l_category = $l_category;
			$level->l_customcode = $l_customcode;
			$level->l_setting = $l_setting;
			$level->l_user = $l_user;
			$level->l_user_Action = $l_user_Action;
			$level->l_user_staff_Action = $l_user_staff_Action;
			$level->l_bank = $l_bank;
			$level->l_banner = $l_banner;
			$level->l_product = $l_product;
			$level->l_product_Import = $l_product_Import;
			$level->l_product_Export = $l_product_Export;
			$level->l_product_Action = $l_product_Action;
			$level->l_membergetmember = $l_membergetmember;
			$level->l_membergetmember_setting = $l_membergetmember_setting;
			$level->l_quotation = $l_quotation;
			$level->l_quotation_setting = $l_quotation_setting;
			$level->l_recommend = $l_recommend;
			$level->l_ticket = $l_ticket;
			$level->update_by = Auth::user()->displayname;
			$level->updated_at = now();
			$level->save();
		} else {
			$level = new UsersLevel;
			$level->UserId = $id;
			$level->l_artlicle = $l_artlicle;
			$level->l_promotion = $l_promotion;
			$level->l_software = $l_software;
			$level->l_program = $l_program;
			$level->l_page = $l_page;
			$level->l_category = $l_category;
			$level->l_customcode = $l_customcode;
			$level->l_setting = $l_setting;
			$level->l_user = $l_user;
			$level->l_user_Action = $l_user_Action;
			$level->l_user_staff_Action = $l_user_staff_Action;
			$level->l_bank = $l_bank;
			$level->l_banner = $l_banner;
			$level->l_product = $l_product;
			$level->l_product_Import = $l_product_Import;
			$level->l_product_Export = $l_product_Export;
			$level->l_product_Action = $l_product_Action;
			$level->l_membergetmember = $l_membergetmember;
			$level->l_membergetmember_setting = $l_membergetmember_setting;
			$level->l_quotation = $l_quotation;
			$level->l_quotation_setting = $l_quotation_setting;
			$level->l_recommend = $l_recommend;
			$level->l_ticket = $l_ticket;
			$level->crate_by = Auth::user()->displayname;
			$level->update_by = Auth::user()->displayname;
			$level->created_at = now();
			$level->updated_at = now();
			$level->save();
		}

		return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');
	}

    public function changpassword($id){
        $breadcrumb = [
            ['name' => 'เปลี่ยนรหัสผ่าน'],
        ];
        $title_page = 'เปลี่ยนรหัสผ่าน';

        $user = User::findOrFail($id);

        return view('admin.user.changpassword', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => $user,
        ]);
    }

    public function changpasswordUpdate(Request $request,$id){

        $request->validate(
            [
                'password' => 'required|min:8',
                'password_confirmation' => 'required|same:password',
            ],
            [

                'password.required' => 'กรุณากรอกรหัสผ่านใหม่',
                'password.min' => 'กรุณากรอกรหัสผ่านอย่างน้อย 8 อักษร',
                'password_confirmation.required' => 'กรุณายืนยันรหัสผ่าน',
                'password_confirmation.same' => 'รหัสผ่านไม่ตรงกัน กรุณาตรวจสอบข้อมูล',
            ]
        );

        $user                     = User::findOrFail($id);
        $user->password           = Hash::make($request->password);
        $user->update_by          = Auth::user()->displayname;
        $user->updated_at         = now();
        $user->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function setting()
    {

        $breadcrumb = [
            ['name' => 'ตั้งค่าบัญชีผู้ใช้งาน'],
        ];
        $title_page = 'ตั้งค่าบัญชีผู้ใช้งาน';
        $setting = TbSettingUser::first();

        return view('admin.user.setting', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => $setting,
        ]);

    }

    public function settingCrate(Request $request){

        if($request->pdpa_status == 'on'){
            $pdpa_status = 1;
        }else{
            $pdpa_status = 2;
        }

        if($request->business_status == 'on'){
            $business_status = 1;
        }else{
            $business_status = 2;
        }

        if($request->position_status == 'on'){
            $position_status = 1;
        }else{
            $position_status = 2;
        }

        $user                     = new TbSettingUser;
        $user->pdpa_status        = $pdpa_status;
        $user->pdpa_detail        = $request->pdpa_detail;
        $user->business_status    = $business_status;
        $user->position_status    = $position_status;
        $user->created_by         = Auth::user()->displayname;
        $user->created_at         = now();
        $user->updated_by         = Auth::user()->displayname;
        $user->updated_at         = now();
        $user->save();

        return back()->with('feedback', 'เพิ่มข้อมูลเรียบร้อยแล้ว!');

    }

    public function settingUpdate(Request $request,$id){

        if($request->pdpa_status == 'on'){
            $pdpa_status = 1;
        }else{
            $pdpa_status = 2;
        }

        if($request->business_status == 'on'){
            $business_status = 1;
        }else{
            $business_status = 2;
        }

        if($request->position_status == 'on'){
            $position_status = 1;
        }else{
            $position_status = 2;
        }

        $user                     = TbSettingUser::findOrFail($id);
        $user->pdpa_status        = $pdpa_status;
        $user->pdpa_detail        = $request->pdpa_detail;
        $user->business_status    = $business_status;
        $user->position_status    = $position_status;
        $user->updated_by         = Auth::user()->displayname;
        $user->updated_at         = now();
        $user->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    private function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}