<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Providers\RouteServiceProvider;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Storage;

use App\Models\TbPagesRedirect;

class RedirectController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $breadcrumb = [
            ['name' => 'Rredirect Page'],
        ];
        $title_page = 'Rredirect Page';
        $count = TbPagesRedirect::count();

        return view('admin.redirect.main', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'count' => $count,
            'data' => '',
        ]);

    }

    public function add(){

        $breadcrumb = [
            ['name' => 'เพิ่ม Rredirect Page'],
        ];
        $title_page = 'เพิ่ม Rredirect Page';

        return view('admin.redirect.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => '',
        ]);

    }

    public function crate(Request $request){

        $request->validate(
            [
                'redirect_old' => 'required|max:255|unique:tb_pages_redirect',
                'redirect_new' => 'required|max:255',
            ],
            [
                'redirect_old.required' => 'กรุณากรอกข้อมูล',
                'redirect_old.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'redirect_old.unique' => 'url นี้มีการใช้งานอยู่แล้ว กรุณาตรวจสอบข้อมูลอีกครั้ง',
                'redirect_new.required' => 'กรุณากรอกข้อมูล',
                'redirect_new.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
             ]
        );

        if($request->redirect_show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        $data = new TbPagesRedirect;
        $data->redirect_old                 = $request->redirect_old;
        $data->redirect_new                 = $request->redirect_new;
        $data->redirect_show                = $show;
        $data->created_by                   = Auth::user()->displayname;
        $data->updated_by                   = Auth::user()->displayname;
        $data->created_at                   = date('Y-m-d H:i:s');
        $data->updated_at                   = date('Y-m-d H:i:s');
        $data->save();

        return redirect()->route('redirect.edit',[$data->id])->with('feedback', 'เพิ่มข้อมูลเรียบร้อยแล้ว!');

    }

    public function edit($id)
    {
        $breadcrumb = [
            ['name' => 'อัพเดต Rredirect Page'],
        ];
        $title_page = 'อัพเดต Rredirect Page';

        $data = TbPagesRedirect::findOrFail($id);

        return view('admin.redirect.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => $data,
        ]);
    }

    public function update(Request $request,$id){

        $request->validate(
            [
                'redirect_old' => 'required|max:255|unique:tb_pages_redirect,redirect_old,'.$id,
                'redirect_new' => 'required|max:255',
            ],
            [
                'redirect_old.required' => 'กรุณากรอกข้อมูล',
                'redirect_old.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'redirect_old.unique' => 'url นี้มีการใช้งานอยู่แล้ว กรุณาตรวจสอบข้อมูลอีกครั้ง',
                'redirect_new.required' => 'กรุณากรอกข้อมูล',
                'redirect_new.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
            ]
        );

        if($request->redirect_show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        $data = TbPagesRedirect::findOrFail($id);

        $data->redirect_old                 = $request->redirect_old;
        $data->redirect_new                 = $request->redirect_new;
        $data->redirect_show                = $show;
        $data->updated_by                   = Auth::user()->displayname;
        $data->updated_at                   = date('Y-m-d H:i:s');
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function status($id){

        $data = TbPagesRedirect::findOrFail($id);

        if($data->redirect_show == 2){
            $status = 1;
        }elseif($data->redirect_show == 1) {
            $status = 2;
        }

        $data->redirect_show                     = $status;
        $data->updated_by                   = Auth::user()->displayname;
        $data->updated_at                   = date('Y-m-d H:i:s');
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');
    }

    public function delete(Request $request){

        TbPagesRedirect::where('id', $request->deleteId)->delete();
        return back()->with('feedback', 'ลบข้อมูลเรียบร้อยแล้ว!');

    }

    public function jsondata()
    {

        $data = TbPagesRedirect::get();

        return Datatables::of($data)
                ->addColumn('redirect_old', function ($data) {
                    return $data->redirect_old;
                })
                ->addColumn('redirect_new', function ($data) {
                    return '<a href="'.$data->redirect_new.'" target="_bank">'.$data->redirect_new.'</a>';
                })
                ->addColumn('redirect_show', function ($data) {
                    return $data->redirect_show;
                })
                ->addColumn('crated', function ($data) {
                    return $data->created_at.'<br/><small><i class="fa fa-user"></i> '.$data->created_by.'</small>';
                })
                ->addColumn('updated', function ($data) {
                    return $data->updated_at.'<br/><small><i class="fa fa-user"></i> '.$data->updated_by.'</small>';
                })
                ->addColumn('actions', function ($data) {
                    $id = $data->id;
                    $name = $data->redirect_old;
                    $status = $data->redirect_show;
                    return view('admin.redirect.button', compact('id','status','name'));
                })
                ->escapeColumns([])
                ->addIndexColumn()
                ->make(true);
    }

}
