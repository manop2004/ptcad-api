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

use App\Models\TbSettingCompanyPosition;
use App\Models\User;

class PositionControlle extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $breadcrumb = [
            ['name' => 'ตำแหน่ง/อาชีพ'],
        ];
        $title_page = 'ตำแหน่ง/อาชีพ';

        $count   = TbSettingCompanyPosition::count();

        return view('admin.position.main', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => '',
            'count' => $count,
        ]);

    }

    public function add(){

        $breadcrumb = [
            ['name' => 'เพิ่มตำแหน่ง/อาชีพ'],
        ];
        $title_page = 'เพิ่มตำแหน่ง/อาชีพ';

        return view('admin.position.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => '',
        ]);

    }

    public function crate(Request $request){

        $request->validate(
            [
                'position_name' => 'required|max:255',
            ],
            [
                'position_name.required' => 'กรุณากรอกข้อมูล',
                'position_name.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
            ]
        );

        if($request->position_show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        $data = new TbSettingCompanyPosition;
        $data->position_name             = $request->position_name;
        $data->position_show             = $show;
        $data->created_by                = Auth::user()->displayname;
        $data->updated_by                = Auth::user()->displayname;
        $data->created_at                = date('Y-m-d H:i:s');
        $data->updated_at                = date('Y-m-d H:i:s');
        $data->save();

        return redirect()->route('position.edit',[$data->id])->with('feedback', 'เพิ่มข้อมูลเรียบร้อยแล้ว!');

    }

    public function edit($id)
    {
        $breadcrumb = [
            ['name' => 'อัพเดตตำแหน่ง/อาชีพ'],
        ];
        $title_page = 'อัพเดตตำแหน่ง/อาชีพ';

        $data = TbSettingCompanyPosition::findOrFail($id);

        return view('admin.position.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => $data,
        ]);
    }

    public function update(Request $request,$id){

        $request->validate(
            [
                'position_name' => 'required|max:255',
            ],
            [
                'position_name.required' => 'กรุณากรอกข้อมูล',
                'position_name.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
            ]
        );

        if($request->position_show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        $data = TbSettingCompanyPosition::findOrfail($id);
        $data->position_name              = $request->position_name;
        $data->position_show              = $show;
        $data->updated_by                 = Auth::user()->displayname;
        $data->updated_at                 = date('Y-m-d H:i:s');
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function jsondata()
    {

        $data = TbSettingCompanyPosition::get();

        return Datatables::of($data)
                ->addColumn('position_name', function ($data) {
                    return $data->position_name;
                })
                ->addColumn('position_show', function ($data) {
                    return $data->position_show;
                })
                ->addColumn('crated', function ($data) {
                    return $data->created_at.'<br/><small><i class="fa fa-user"></i> '.$data->created_by.'</small>';
                })
                ->addColumn('updated', function ($data) {
                    return $data->updated_at.'<br/><small><i class="fa fa-user"></i> '.$data->updated_by.'</small>';
                })
                ->addColumn('actions', function ($data) {
                    $id = $data->id;
                    $name = $data->position_name;
                    $status = $data->position_show;
                    return view('admin.position.button', compact('id','status','name'));
                })
                ->escapeColumns([])
                ->addIndexColumn()
                ->make(true);
    }

    public function status($id){

        $data = TbSettingCompanyPosition::findOrFail($id);

        if($data->position_show == 2){
            $status = 1;
        }elseif($data->position_show == 1) {
            $status = 2;
        }

        $data->position_show                = $status;
        $data->updated_by                   = Auth::user()->displayname;
        $data->updated_at                   = date('Y-m-d H:i:s');
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');
    }

    public function delete(Request $request){

        $id = $request->deleteId;

        $check = User::where('positionId',$id)->count();

        if($check == 0){
            TbSettingCompanyPosition::where('id', $request->deleteId)->delete();
        return back()->with('feedback', 'ลบข้อมูลเรียบร้อยแล้ว!');

        }else{
            return back()->with(['feedback-er' =>'ไม่สามารถลบข้อมูลได้!','text-er'=>'เนื่องจากในข้อมูลสมาชิกมีการใช้งานอยู่']);
        }

    }

}
