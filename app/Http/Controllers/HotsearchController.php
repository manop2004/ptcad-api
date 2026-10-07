<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Providers\RouteServiceProvider;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Storage;

use App\Models\TbSettingHotsearch;

class HotsearchController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $breadcrumb = [
            ['name' => 'Hot Search'],
        ];
        $title_page = 'Hot Search';
        $count = TbSettingHotsearch::count();

        return view('admin.hotsearch.main', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'count' => $count,
            'data' => '',
        ]);

    }

    public function add(){

        $breadcrumb = [
            ['name' => 'เพิ่ม Hot Search'],
        ];
        $title_page = 'เพิ่ม Hot Search';

        return view('admin.hotsearch.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => '',
        ]);

    }

    public function crate(Request $request){

        $request->validate(
            [
                'hotsearch_name' => 'required|max:255|unique:tb_setting_hotsearch',
                'hotsearch_url' => 'max:255',
            ],
            [
                'hotsearch_name.required' => 'กรุณากรอกข้อมูล',
                'hotsearch_name.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'hotsearch_name.unique' => 'มีข้อมูลนี้อยู่แล้ว กรุณาตรวจสอบข้อมูลอีกครั้ง',
                'hotsearch_url.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
             ]
        );

        if($request->hotsearch_show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        $data = new TbSettingHotsearch;
        $data->hotsearch_name                = $request->hotsearch_name;
        $data->hotsearch_url                 = $request->hotsearch_url;
        $data->hotsearch_show                = $show;
        $data->created_by                    = Auth::user()->displayname;
        $data->updated_by                    = Auth::user()->displayname;
        $data->created_at                    = date('Y-m-d H:i:s');
        $data->updated_at                    = date('Y-m-d H:i:s');
        $data->save();

        return redirect()->route('hotsearch.edit',[$data->id])->with('feedback', 'เพิ่มข้อมูลเรียบร้อยแล้ว!');

    }

    public function edit($id)
    {
        $breadcrumb = [
            ['name' => 'อัพเดต Hot Search'],
        ];
        $title_page = 'อัพเดต Hot Search';

        $data = TbSettingHotsearch::findOrFail($id);

        return view('admin.hotsearch.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => $data,
        ]);
    }

    public function update(Request $request,$id){

        $request->validate(
            [
                'hotsearch_name' => 'required|max:255|unique:tb_setting_hotsearch,hotsearch_name,'.$id,
                'hotsearch_url' => 'max:255',
            ],
            [
                'hotsearch_name.required' => 'กรุณากรอกข้อมูล',
                'hotsearch_name.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'hotsearch_name.unique' => 'มีข้อมูลนี้อยู่แล้ว กรุณาตรวจสอบข้อมูลอีกครั้ง',
                'hotsearch_url.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
            ]
        );

        if($request->hotsearch_show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        $data = TbSettingHotsearch::findOrFail($id);

        $data->hotsearch_name                 = $request->hotsearch_name;
        $data->hotsearch_url                 = $request->hotsearch_url;
        $data->hotsearch_show                = $show;
        $data->updated_by                   = Auth::user()->displayname;
        $data->updated_at                   = date('Y-m-d H:i:s');
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function status($id){

        $data = TbSettingHotsearch::findOrFail($id);

        if($data->hotsearch_show == 2){
            $status = 1;
        }elseif($data->hotsearch_show == 1) {
            $status = 2;
        }

        $data->hotsearch_show                     = $status;
        $data->updated_by                   = Auth::user()->displayname;
        $data->updated_at                   = date('Y-m-d H:i:s');
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');
    }

    public function delete(Request $request){

        TbSettingHotsearch::where('id', $request->deleteId)->delete();
        return back()->with('feedback', 'ลบข้อมูลเรียบร้อยแล้ว!');

    }

    public function jsondata()
    {

        $data = TbSettingHotsearch::get();

        return Datatables::of($data)
                ->addColumn('hotsearch_name', function ($data) {
                    return '<a href="'.$data->hotsearch_url.'" target="_bank">'.$data->hotsearch_name.'</a>';
                })
                ->addColumn('hotsearch_show', function ($data) {
                    return $data->hotsearch_show;
                })
                ->addColumn('crated', function ($data) {
                    return $data->created_at.'<br/><small><i class="fa fa-user"></i> '.$data->created_by.'</small>';
                })
                ->addColumn('updated', function ($data) {
                    return $data->updated_at.'<br/><small><i class="fa fa-user"></i> '.$data->updated_by.'</small>';
                })
                ->addColumn('actions', function ($data) {
                    $id = $data->id;
                    $name = $data->hotsearch_name;
                    $status = $data->hotsearch_show;
                    return view('admin.hotsearch.button', compact('id','status','name'));
                })
                ->escapeColumns([])
                ->addIndexColumn()
                ->make(true);
    }

}
