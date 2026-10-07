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

use App\Models\TbSettingCompanyBusiness;
use App\Models\User;

class BusinessControlle extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $breadcrumb = [
            ['name' => 'ประเภทธุรกิจ'],
        ];
        $title_page = 'ประเภทธุรกิจ';

        $count   = TbSettingCompanyBusiness::count();

        return view('admin.business.main', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => '',
            'count' => $count,
        ]);

    }

    public function add(){

        $breadcrumb = [
            ['name' => 'เพิ่มประเภทธุรกิจ'],
        ];
        $title_page = 'เพิ่มประเภทธุรกิจ';

        return view('admin.business.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => '',
        ]);

    }

    public function crate(Request $request){

        $request->validate(
            [
                'business_name' => 'required|max:255',
            ],
            [
                'business_name.required' => 'กรุณากรอกข้อมูล',
                'business_name.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
            ]
        );

        if($request->business_show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        $data = new TbSettingCompanyBusiness;
        $data->business_name             = $request->business_name;
        $data->business_show             = $show;
        $data->created_by                = Auth::user()->displayname;
        $data->updated_by                = Auth::user()->displayname;
        $data->created_at                = date('Y-m-d H:i:s');
        $data->updated_at                = date('Y-m-d H:i:s');
        $data->save();

        return redirect()->route('business.edit',[$data->id])->with('feedback', 'เพิ่มข้อมูลเรียบร้อยแล้ว!');

    }

    public function edit($id)
    {
        $breadcrumb = [
            ['name' => 'อัพเดตประเภทธุรกิจ'],
        ];
        $title_page = 'อัพเดตประเภทธุรกิจ';

        $data = TbSettingCompanyBusiness::findOrFail($id);

        return view('admin.business.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => $data,
        ]);
    }

    public function update(Request $request,$id){

        $request->validate(
            [
                'business_name' => 'required|max:255',
            ],
            [
                'business_name.required' => 'กรุณากรอกข้อมูล',
                'business_name.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
            ]
        );

        if($request->business_show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        $data = TbSettingCompanyBusiness::findOrfail($id);
        $data->business_name              = $request->business_name;
        $data->business_show              = $show;
        $data->updated_by                 = Auth::user()->displayname;
        $data->updated_at                 = date('Y-m-d H:i:s');
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function jsondata()
    {

        $data = TbSettingCompanyBusiness::get();

        return Datatables::of($data)
                ->addColumn('business_name', function ($data) {
                    return $data->business_name;
                })
                ->addColumn('business_show', function ($data) {
                    return $data->business_show;
                })
                ->addColumn('crated', function ($data) {
                    return $data->created_at.'<br/><small><i class="fa fa-user"></i> '.$data->created_by.'</small>';
                })
                ->addColumn('updated', function ($data) {
                    return $data->updated_at.'<br/><small><i class="fa fa-user"></i> '.$data->updated_by.'</small>';
                })
                ->addColumn('actions', function ($data) {
                    $id = $data->id;
                    $name = $data->business_name;
                    $status = $data->business_show;
                    return view('admin.business.button', compact('id','status','name'));
                })
                ->escapeColumns([])
                ->addIndexColumn()
                ->make(true);
    }

    public function status($id){

        $data = TbSettingCompanyBusiness::findOrFail($id);

        if($data->business_show == 2){
            $status = 1;
        }elseif($data->business_show == 1) {
            $status = 2;
        }

        $data->business_show                = $status;
        $data->updated_by                   = Auth::user()->displayname;
        $data->updated_at                   = date('Y-m-d H:i:s');
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');
    }

    public function delete(Request $request){

        $id = $request->deleteId;

        $check = User::where('businessId',$id)->count();

        if($check == 0){
            TbSettingCompanyBusiness::where('id', $request->deleteId)->delete();
        return back()->with('feedback', 'ลบข้อมูลเรียบร้อยแล้ว!');

        }else{
            return back()->with(['feedback-er' =>'ไม่สามารถลบข้อมูลได้!','text-er'=>'เนื่องจากในข้อมูลสมาชิกมีการใช้งานอยู่']);
        }

    }

}
