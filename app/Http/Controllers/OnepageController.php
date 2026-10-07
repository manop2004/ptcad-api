<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Providers\RouteServiceProvider;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\TbPromotionOnepage;
use App\Models\TbPromotionOnepagesForm;
use App\Models\TbPromotionOnepagesSetting;
use App\Models\TbPromotionOnepagesSection;

class OnepageController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    //section ==================================================================================
   

    //tab ==================================================================================
    public function settingTab($page,$section){

        $breadcrumb = [
            ['name' => 'Setting Tab'],
        ];
        $title_page = 'Setting Tab';
        $item = TbPromotionOnepage::findOrFail($page);
        $count = TbPromotionOnepagesSection::where('section',$section)->where('onepageId',$page)->count();
        $data = '';
        $section = $section;

        return view('admin.onepage.tab.main', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'item' => $item,
            'count' => $count,
            'data' => $data,
            'section' => $section,
        ]);

    }

    public function settingTabadd($page){

        $breadcrumb = [
            ['name' => 'Setting Tab'],
        ];
        $title_page = 'Setting Tab';
        $item = TbPromotionOnepage::findOrFail($page);

        return view('admin.onepage.tab.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'item' => $item,
            'data' => '',
        ]);

    }

    public function settingTabcrate(Request $request,$page){

        $request->validate(
            [
                'name' => 'required|max:255',
            ],
            [
                'name.required' => 'กรุณากรอกข้อมูล',
                'name.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
            ]
        );

        if($request->show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        $data = new TbPromotionOnepagesSection;
        $data->onepageId               = $request->onepageId;
        $data->bgColor                 = $request->bgColor;
        $data->section                 = $request->section;
        $data->name                    = $request->name;
        $data->detail                  = $request->detail;
        $data->sort                    = 0;
        $data->show                    = $show;
        $data->created_by              = Auth::user()->displayname;
        $data->updated_by              = Auth::user()->displayname;
        $data->created_at              = date('Y-m-d H:i:s');
        $data->updated_at              = date('Y-m-d H:i:s');
        $data->save();

        return redirect()->route('onepage.setting.tab.edit',['page'=>$page,'id'=>$data->id])->with('feedback', 'เพิ่มข้อมูลเรียบร้อยแล้ว!');

    }

    public function settingTabedit($page,$id)
    {
        $breadcrumb = [
            ['name' => 'Setting Tab'],
        ];
        $title_page = 'Setting Tab';
        $item = TbPromotionOnepage::findOrFail($page);
        $data = TbPromotionOnepagesSection::where('onepageId',$page)->findOrFail($id);

        return view('admin.onepage.tab.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'item' => $item,
            'data' => $data,
        ]);
    }

    public function settingTabupdate(Request $request,$page,$id){

        $request->validate(
            [
                'name' => 'required|max:255',
            ],
            [
                'name.required' => 'กรุณากรอกข้อมูล',
                'name.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
            ]
        );

        if($request->show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        $data = TbPromotionOnepagesSection::findOrFail($id);
        $data->bgColor                 = $request->bgColor;
        $data->section                 = $request->section;
        $data->name                    = $request->name;
        $data->detail                  = $request->detail;
        $data->sort                    = 0;
        $data->show                    = $show;
        $data->updated_by              = Auth::user()->displayname;
        $data->updated_at              = date('Y-m-d H:i:s');
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function settingTabJsondata($page,$section)
    {

        $data = TbPromotionOnepagesSection::where('section',$section)->where('onepageId',$page)->get();

        return Datatables::of($data)
                ->addColumn('name', function ($data) {
                    return $data->name;
                })
                ->addColumn('show', function ($data) {
                    return $data->show;
                })
                ->addColumn('created', function ($data) {
                    return $data->created_at.'<br/>'.$data->created_by;
                })
                ->addColumn('updated', function ($data) {
                    return $data->updated_at.'<br/>'.$data->updated_by;
                })
                ->addColumn('actions', function ($data) {
                    $id         = $data->id;
                    $status     = $data->show;
                    $name       = $data->name;
                    $onepageId  = $data->onepageId;
                    return view('admin.onepage.tab.button', compact('id','status','name','onepageId'));
                })
                ->escapeColumns([])
                ->addIndexColumn()
                ->make(true);
    }

    //footer  ==================================================================================


    private function rewrite_url($url){
        $str_replace = strtolower(str_replace(" ","-",$url));
        $data = preg_replace('/[^a-z0-9\_\- ]/i', '', $str_replace);
        return $data ;
    }

    private function rewrite_color($color){
        $str_replace = strtolower(str_replace("#","",$color));
        $data = preg_replace('/[^a-z0-9\_\- ]/i', '', $str_replace);
        return $data ;
    }

}
