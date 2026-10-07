<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Providers\RouteServiceProvider;
use Yajra\Datatables\Datatables;

use App\Models\TbCustomcode;

class CustomcodeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($code)
    {

        $breadcrumb = [
            ['name' => 'Custom Code'],
        ];
        $title_page = 'Custom Code';
        $count = TbCustomcode::where('custom_type',$code)->count();

        return view('admin.custom.main', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'count' => $count,
            'type' => $code,
        ]);
    }

    public function add($code)
    {
        $breadcrumb = [
            ['name' => 'Custom Code'],
            ['name' => $code],
        ];
        $title_page = 'เพิ่ม Custom Code';

        return view('admin.custom.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'customcode' => '',
            'type' => $code,
        ]);
    }

    public function crate(Request $request){

        $request->validate(
            [
                'txt_title' => 'required',
                'txt_detail' => 'required',
            ],
            [
                'txt_title.required' => 'กรุณากรอกข้อมูล',
                'txt_detail.required' => 'กรุณากรอกข้อมูล',
            ]
        );

        function generateRandomString($length = 10) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }

        $code = generateRandomString();

        if($request->txt_show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        $custom = new TbCustomcode;
        $custom->custom_parmalink   = $code;
        $custom->custom_title       = $request->txt_title;
        $custom->custom_detail      = $request->txt_detail;
        $custom->custom_type        = $request->txt_type;
        $custom->displayType        = $request->displayType;
        $custom->custom_show        = $show;
        $custom->created_by         = Auth::user()->displayname;
        $custom->updated_by         = Auth::user()->displayname;
        $custom->save();

        return redirect()->route('custom.edit',[$request->txt_type,$custom->id])->with('feedback', 'เพิ่มข้อมูลเรียบร้อยแล้ว!');

    }

    public function edit($code,$id)
    {
        $breadcrumb = [
            ['name' => 'Custom Code'],
            ['name' => $code],
        ];
        $title_page = 'อัพเดต Custom Code';

        $data = TbCustomcode::findOrFail($id);

        return view('admin.custom.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'customcode' => $data,
            'type' => $code,
        ]);
    }

    public function update(Request $request,$id){

        if($request->txt_show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        $data = TbCustomcode::findOrFail($id);
        $data->custom_title             = $request->txt_title;
        $data->custom_detail            = $request->txt_detail;
        $data->displayType              = $request->displayType;
        $data->custom_show              = $show;
        $data->updated_by               = Auth::user()->displayname;
        $data->updated_at               = date('Y-m-d H:i:s');
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }


    public function delete(Request $request){

        TbCustomcode::where('id', $request->deleteId)->delete();

        return back()->with('feedback', 'ลบข้อมูลเรียบร้อยแล้ว!');
    }

    public function status(Request $request,$id){

        $data = TbCustomcode::findOrFail($id);

        if($data->custom_show == 2){
            $show = 1;
        }elseif($data->custom_show == 1) {
            $show = 2;
        }

        $data->custom_show              = $show;
        $data->updated_by               = Auth::user()->displayname;
        $data->updated_at               = date('Y-m-d H:i:s');
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');
    }

    public function jsondata(Request $request)
    {

        $data = TbCustomcode::where('custom_type',$request->code)->get();

        return Datatables::of($data)
                ->addColumn('title', function ($data) {
                    return $data->custom_title;
                })
                ->addColumn('display', function ($data) {
                    return $data->displayType;
                })
                ->addColumn('status', function ($data) {
                    return $data->custom_show;
                })
                ->addColumn('created_at', function ($data) {
                    return $data->created_at.'<br/><small><i class="fa fa-user"></i> '.$data->updated_by.'</small>';
                })
                ->addColumn('actions', function ($data) {
                    $id = $data->id;
                    $status = $data->custom_show;
                    $code = $data->custom_type;
                    $name = $data->custom_title;
                    return view('admin.custom.button', compact('id','status','code','name'));
                })
                ->escapeColumns([])
                ->addIndexColumn()
                ->make(true);
    }
}
