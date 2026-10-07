<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Providers\RouteServiceProvider;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use App\Models\TbPage;
use App\Models\TbPagesMap;
use App\Models\TbSetting;

class PageControlle extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $breadcrumb = [
            ['name' => 'หน้าเพจ'],
        ];
        $title_page = 'หน้าเพจ';

        $count   = TbPage::count();

        return view('admin.page.main', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => '',
            'count' => $count,
        ]);

    }

    public function add(){

        $breadcrumb = [
            ['name' => 'เพิ่มหน้าเพจ'],
        ];
        $title_page = 'เพิ่มหน้าเพจ';

        return view('admin.page.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => '',
        ]);

    }

    public function crate(Request $request){

        $request->validate(
            [
                'pages_name' => 'required|max:255',
                'page_parmalink' => 'required|max:255|unique:tb_pages',
            ],
            [
                'pages_name.required' => 'กรุณากรอกข้อมูล',
                'pages_name.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'page_parmalink.required' => 'กรุณากรอกข้อมูล',
                'page_parmalink.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'page_parmalink.unique' => 'Parmalink นี้มีการใช้งานอยู่แล้ว กรุณาตรวจสอบข้อมูลอีกครั้ง',
            ]
        );

        if($request->page_show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        if($request->page_recommend == 'on'){
            $page_recommend = 1;
        }else{
            $page_recommend = 2;
        }

        $data = new TbPage;
        $data->pages_type                = $request->pages_type;
        $data->pages_name                = $request->pages_name;
        $data->page_detail               = $request->page_detail;
        $data->page_seo_detail           = $request->page_seo_detail;
        if($request->pages_type == 1){
            $data->page_parmalink        = $this->rewrite_url($request->page_parmalink);
        }else{
            $data->page_parmalink        = $request->page_parmalink;
        }
        $data->page_show                 = $show;
        $data->page_recommend            = $page_recommend;
        $data->created_by                = Auth::user()->displayname;
        $data->updated_by                = Auth::user()->displayname;
        $data->created_at                = date('Y-m-d H:i:s');
        $data->updated_at                = date('Y-m-d H:i:s');
        $data->save();

        return redirect()->route('page.edit',[$data->id])->with('feedback', 'เพิ่มข้อมูลเรียบร้อยแล้ว!');

    }

    public function edit($id)
    {
        $breadcrumb = [
            ['name' => 'อัพเดตหน้าเพจ'],
        ];
        $title_page = 'อัพเดตหน้าเพจ';

        $data = TbPage::findOrFail($id);

        return view('admin.page.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => $data,
        ]);
    }

    public function update(Request $request,$id){

        $request->validate(
            [
                'pages_name' => 'required|max:255',
                'page_parmalink' => 'required|max:255|unique:tb_pages,page_parmalink,'.$id,
            ],
            [
                'pages_name.required' => 'กรุณากรอกข้อมูล',
                'pages_name.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'page_parmalink.required' => 'กรุณากรอกข้อมูล',
                'page_parmalink.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'page_parmalink.unique' => 'Parmalink นี้มีการใช้งานอยู่แล้ว กรุณาตรวจสอบข้อมูลอีกครั้ง',
            ]
        );

        if($request->page_show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        if($request->page_recommend == 'on'){
            $page_recommend = 1;
        }else{
            $page_recommend = 2;
        }

        $data = TbPage::findOrfail($id);
        $data->pages_type                = $request->pages_type;
        $data->pages_name                = $request->pages_name;
        $data->page_detail               = $request->page_detail;
        $data->page_seo_detail           = $request->page_seo_detail;
        if($request->pages_type == 1){
            $data->page_parmalink        = $this->rewrite_url($request->page_parmalink);
        }else{
            $data->page_parmalink        = $request->page_parmalink;
        }
        $data->page_show                 = $show;
        $data->page_recommend            = $page_recommend;
        $data->updated_by                 = Auth::user()->displayname;
        $data->updated_at                 = date('Y-m-d H:i:s');
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function jsondata()
    {

        $data = TbPage::get();

        return Datatables::of($data)
                ->addColumn('pages_name', function ($data) {
                    return '<a href="'.route('page.preview',$data->page_parmalink).'" target="_bank">'.$data->pages_name.'</a>';
                })
                ->addColumn('page_recommend', function ($data) {
                    return $data->page_recommend;
                })
                ->addColumn('page_show', function ($data) {
                    return $data->page_show;
                })
                ->addColumn('crated', function ($data) {
                    return $data->created_at.'<br/><small><i class="fa fa-user"></i> '.$data->created_by.'</small>';
                })
                ->addColumn('updated', function ($data) {
                    return $data->updated_at.'<br/><small><i class="fa fa-user"></i> '.$data->updated_by.'</small>';
                })
                ->addColumn('actions', function ($data) {
                    $id = $data->id;
                    $name = $data->pages_name;
                    $status = $data->page_show;
                    return view('admin.page.button', compact('id','status','name'));
                })
                ->escapeColumns([])
                ->addIndexColumn()
                ->make(true);
    }

    public function status($id){

        $data = TbPage::findOrFail($id);

        if($data->page_show == 2){
            $status = 1;
        }elseif($data->page_show == 1) {
            $status = 2;
        }

        $data->page_show                    = $status;
        $data->updated_by                   = Auth::user()->displayname;
        $data->updated_at                   = date('Y-m-d H:i:s');
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');
    }

    public function delete(Request $request){

        TbPage::where('id', $request->deleteId)->delete();
        return back()->with('feedback', 'ลบข้อมูลเรียบร้อยแล้ว!');
    }

    public function preview($parmalink){

        $setting = TbSetting::first();
        $page = TbPage::where('page_parmalink',$parmalink)->first();
        $page_recommend = TbPage::select('page_parmalink','pages_type','pages_name','page_recommend','page_show')->where('page_recommend',1)->where('page_show',1)->get();

        if(!empty($page->pages_name)){
            $breadcrumb = [
                ['route' => route('fronend.home'), 'name' => 'หน้าหลัก'],
                ['route' => '', 'name' => $page->pages_name],
            ];
        }else{
            $breadcrumb = "";
        }

        if(!empty($page)){ $permalink = $parmalink; }else{ $permalink = '';}
        //title share
        if(!empty($page->pages_name)){ $og_site_name = $page->pages_name; }else{ $og_site_name = $setting->setting_nameWeb;}
        if(!empty($page->pages_name)){ $og_title = $page->pages_name; }else{ $og_title = $og_site_name = $setting->setting_nameWeb;}
        if(!empty($page->pages_keyword)){ $og_keywords = $page->pages_keyword; }else{ $og_keywords = "";}
        if(!empty($page->page_seo_detail)){ $og_description = $page->page_seo_detail; }else{ $og_description = "";}
        if(!empty($setting->setting_coverShare)){ $og_image = asset('storage/setting/'.$setting->setting_coverShare); }else{ $og_image = asset('storage/setting/'.$setting->setting_coverShare);}
        if(!empty($page)){ $og_url = route('fronend.page.content',$parmalink); }else{ $og_url = route('fronend.home');}

        if(!empty($page)){

            if($page->page_recommend == 1){
                $return_page = 'fontend.pages.recommend';
            }else{
                $return_page = 'fontend.pages.form';
            }

        }else{
            $return_page = 'fontend.pages.form';
        }

        return view($return_page,[
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

    public function setting(){

        $breadcrumb = [
            ['name' => 'ตั้งค่าหน้าเพจ'],
        ];
        $title_page = 'ตั้งค่าหน้าเพจ';

        $pages   = TbPage::where('page_show',1)->orderBy('pages_name','asc')->get();
        $data    = TbPagesMap::first();

        return view('admin.page.setting', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => $data,
            'pages' => $pages,
        ]);

    }

    public function settingCrate(Request $request){

        $data = new TbPagesMap;
        $data->page_about                = $request->page_about;
        $data->page_privacy_policy       = $request->page_privacy_policy;
        $data->page_business_policy      = $request->page_business_policy;
        $data->page_refund_policy        = $request->page_refund_policy;
        $data->page_return_policy        = $request->page_return_policy;
        $data->page_warranty_policy      = $request->page_warranty_policy;
        $data->page_howto_shopping       = $request->page_howto_shopping;
        $data->page_howto_register       = $request->page_howto_register;
        $data->page_membership           = $request->page_membership;
        $data->pages_check_delivery      = $request->pages_check_delivery;
        $data->pages_contact_support     = $request->pages_contact_support;
        $data->pages_payment             = $request->pages_payment;
        $data->created_by                = Auth::user()->displayname;
        $data->updated_by                = Auth::user()->displayname;
        $data->created_at                = date('Y-m-d H:i:s');
        $data->updated_at                = date('Y-m-d H:i:s');
        $data->save();

        return back()->with('feedback', 'เพิ่มข้อมูลเรียบร้อยแล้ว!');

    }

    public function settingUpdate(Request $request,$id){

        $data = TbPagesMap::findOrfail($id);
        $data->page_about                = $request->page_about;
        $data->page_privacy_policy       = $request->page_privacy_policy;
        $data->page_business_policy      = $request->page_business_policy;
        $data->page_refund_policy        = $request->page_refund_policy;
        $data->page_return_policy        = $request->page_return_policy;
        $data->page_warranty_policy      = $request->page_warranty_policy;
        $data->page_howto_shopping       = $request->page_howto_shopping;
        $data->page_howto_register       = $request->page_howto_register;
        $data->page_membership           = $request->page_membership;
        $data->pages_check_delivery      = $request->pages_check_delivery;
        $data->pages_contact_support     = $request->pages_contact_support;
        $data->pages_payment             = $request->pages_payment;
        $data->updated_by                 = Auth::user()->displayname;
        $data->updated_at                 = date('Y-m-d H:i:s');
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }
    
    private function rewrite_url($url){
        $str_replace = strtolower(str_replace(" ","-",$url));
        $data = preg_replace('/[^a-z0-9\_\- ]/i', '', $str_replace);
        return $data ;
    }

}
