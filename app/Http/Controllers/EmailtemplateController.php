<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Providers\RouteServiceProvider;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Storage;

use App\Models\TbPromotionEmailtemplate;

class EmailtemplateController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $breadcrumb = [
            ['name' => 'Email Template'],
        ];
        $title_page = 'Email Template';
        $count = TbPromotionEmailtemplate::count();

        return view('admin.emailtemplate.main', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'count' => $count,
            'data' => '',
        ]);

    }

    public function add(){

        $breadcrumb = [
            ['name' => 'เพิ่ม Email Template'],
        ];
        $title_page = 'เพิ่ม Email Template';

        return view('admin.emailtemplate.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => '',
        ]);

    }

    public function crate(Request $request){

        $request->validate(
            [
                'email_title' => 'required|unique:tb_promotion_emailtemplate',
                
            ],
            [
                'email_title.required' => 'กรุณาเลือกกรอกข้อมูล',
                'email_title.unique' => 'มีการใช้ข้อมูลนี้แล้ว! กรุณาตรวจสอบข้อมูล',
            ]
        );

        if($request->show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        $data = new TbPromotionEmailtemplate;
        $data->email_title             = $request->email_title;
        $data->email_content           = $request->email_content;
        $data->email_link              = $this->rewrite_url($request->email_title);
        $data->show                    = $show;
        $data->created_by              = Auth::user()->displayname;
        $data->updated_by              = Auth::user()->displayname;
        $data->created_at              = date('Y-m-d H:i:s');
        $data->updated_at              = date('Y-m-d H:i:s');
        $data->save();

        return redirect()->route('promotion.emailtemplate.edit',[$data->id])->with('feedback', 'เพิ่มข้อมูลเรียบร้อยแล้ว!');

    }

    public function edit($id)
    {
        $breadcrumb = [
            ['name' => 'อัพเดต Email Template'],
        ];
        $title_page = 'อัพเดต Email Template';

        $data = TbPromotionEmailtemplate::findOrFail($id);

        return view('admin.emailtemplate.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => $data,
        ]);
    }

    public function update(Request $request,$id){

        $request->validate(
            [
                'email_title' => 'required|unique:tb_promotion_emailtemplate,email_title,'.$id,
            ],
            [
                'email_title.required' => 'กรุณาเลือกกรอกข้อมูล',
                'email_title.unique' => 'มีการใช้ข้อมูลนี้แล้ว! กรุณาตรวจสอบข้อมูล',
            ]
        );

        if($request->show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        $data = TbPromotionEmailtemplate::findOrFail($id);

        $data->email_title             = $request->email_title;
        $data->email_content           = $request->email_content;
        $data->show                    = $show;
        $data->updated_by              = Auth::user()->displayname;
        $data->updated_at              = date('Y-m-d H:i:s');
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function status($id){

        $data = TbPromotionEmailtemplate::findOrFail($id);

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

        TbPromotionEmailtemplate::where('id', $request->deleteId)->delete();
        return back()->with('feedback', 'ลบข้อมูลเรียบร้อยแล้ว!');
    }

    public function jsondata()
    {

        $data = TbPromotionEmailtemplate::get();

        return Datatables::of($data)
                ->addColumn('email_title', function ($data) {
                    return $data->email_title;
                })
                ->addColumn('link', function ($data) {
                    return '<a href="'.route('fronend.emailtemplate',$data->email_link).'" target="_bank">'.route('fronend.emailtemplate',$data->email_link).'</a>';
                })
                ->addColumn('show', function ($data) {
                    return $data->show;
                })
                ->addColumn('updated', function ($data) {
                    return $data->created_at.'<br/><small><i class="fa fa-user"></i> '.$data->created_by.'</small>';
                })
                ->addColumn('actions', function ($data) {
                    $id = $data->id;
                    $status = $data->show;
                    $name = $data->email_title;
                    return view('admin.emailtemplate.button', compact('id','status','name'));
                })
                ->escapeColumns([])
                ->addIndexColumn()
                ->make(true);
    }

    private function rewrite_url($url){
        $str_replace = strtolower(str_replace(" ","-",$url));
        $data = preg_replace('/[^a-z0-9\_\- ]/i', '', $str_replace);
        return $data ;
    }

}
