<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Providers\RouteServiceProvider;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Storage;

use App\Models\TbPromotionSettingLinenotify;

class PromotionlinenotifyController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $breadcrumb = [
            ['name' => 'ตั้งค่าการแจ้งเตือน Line Notify'],
        ];
        $title_page = 'ตั้งค่าการแจ้งเตือน Line Notify';
        $count = TbPromotionSettingLinenotify::count();

        return view('admin.promotion.linenotify..main', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'count' => $count,
            'data' => '',
        ]);

    }

    public function add(){

        $breadcrumb = [
            ['name' => 'เพิ่มตั้งค่าการแจ้งเตือน Line Notify'],
        ];
        $title_page = 'เพิ่มตั้งค่าการแจ้งเตือน Line Notify';

        return view('admin.promotion.linenotify..form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => '',
        ]);

    }

    public function crate(Request $request){

        $request->validate(
            [
                'groupname' => 'required|max:255',
                'token_linenotify' => 'required|max:255',
                
            ],
            [
                'groupname.required' => 'กรุณากรอกข้อมูล',
                'groupname.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'token_linenotify.required' => 'กรุณากรอกข้อมูล',
                'token_linenotify.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
            ]
        );

        if($request->show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        if(!empty($request->grouptype1)){
            $grouptype1 = 1;
        }else{
            $grouptype1 = 2;
        }

        if(!empty($request->grouptype2)){
            $grouptype2 = 1;
        }else{
            $grouptype2 = 2;
        }

        $data = new TbPromotionSettingLinenotify;
        $data->groupname               = $request->groupname;
        $data->token_linenotify        = $request->token_linenotify;
        $data->grouptype1              = $grouptype1;
        $data->grouptype2              = $grouptype2;
        $data->show                    = $show;
        $data->created_by              = Auth::user()->displayname;
        $data->updated_by              = Auth::user()->displayname;
        $data->created_at              = date('Y-m-d H:i:s');
        $data->updated_at              = date('Y-m-d H:i:s');
        $data->save();

        return redirect()->route('promotion.setting.linetify.edit',[$data->id])->with('feedback', 'เพิ่มข้อมูลเรียบร้อยแล้ว!');

    }

    public function edit($id)
    {
        $breadcrumb = [
            ['name' => 'อัพเดตตั้งค่าการแจ้งเตือน Line Notify'],
        ];
        $title_page = 'อัพเดตตั้งค่าการแจ้งเตือน Line Notify';

        $data = TbPromotionSettingLinenotify::findOrFail($id);

        return view('admin.promotion.linenotify..form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => $data,
        ]);
    }

    public function update(Request $request,$id){

        $request->validate(
            [
                'groupname' => 'required|max:255',
                'token_linenotify' => 'required|max:255',
                
            ],
            [
                'groupname.required' => 'กรุณากรอกข้อมูล',
                'groupname.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'token_linenotify.required' => 'กรุณากรอกข้อมูล',
                'token_linenotify.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
            ]
        );

        if($request->show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        if(!empty($request->grouptype1)){
            $grouptype1 = 1;
        }else{
            $grouptype1 = 2;
        }

        if(!empty($request->grouptype2)){
            $grouptype2 = 1;
        }else{
            $grouptype2 = 2;
        }

        $data = TbPromotionSettingLinenotify::findOrFail($id);
        $data->groupname               = $request->groupname;
        $data->token_linenotify        = $request->token_linenotify;
        $data->grouptype1              = $grouptype1;
        $data->grouptype2              = $grouptype2;
        $data->show                    = $show;
        $data->updated_by              = Auth::user()->displayname;
        $data->updated_at              = date('Y-m-d H:i:s');
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function status($id){

        $data = TbPromotionSettingLinenotify::findOrFail($id);

        if($data->show == 2){
            $status = 1;
        }elseif($data->show == 1) {
            $status = 2;
        }

        $data->show                         = $status;
        $data->updated_by                   = Auth::user()->displayname;
        $data->updated_at                   = date('Y-m-d H:i:s');
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');
    }

    public function delete(Request $request){

        TbPromotionSettingLinenotify::where('id', $request->deleteId)->delete();
        return back()->with('feedback', 'ลบข้อมูลเรียบร้อยแล้ว!');

    }

    public function jsondata()
    {

        $data = TbPromotionSettingLinenotify::get();

        return Datatables::of($data)
                ->addColumn('name', function ($data) {
                    return $data->groupname;
                })
                ->addColumn('show', function ($data) {
                    return $data->show;
                })
                ->addColumn('updated', function ($data) {
                    return $data->created_at.'<br/>'.$data->updated_by;
                })
                ->addColumn('actions', function ($data) {
                    $id = $data->id;
                    $status = $data->show;
                    $name = $data->groupname;
                    return view('admin.promotion.linenotify.button', compact('id','status','name'));
                })
                ->escapeColumns([])
                ->addIndexColumn()
                ->make(true);
    }

}
