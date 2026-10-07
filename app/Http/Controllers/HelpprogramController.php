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

use App\Models\TicketProgram;
use App\Models\User;

class HelpprogramController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $breadcrumb = [
            ['name' => 'Program Support'],
        ];
        $title_page = 'Program Support';

        $count   = TicketProgram::count();

        return view('admin.ticketprogram.main', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => '',
            'count' => $count,
        ]);

    }

    public function add(){

        $breadcrumb = [
            ['name' => 'เพิ่ม Program Support'],
        ];
        $title_page = 'เพิ่ม Program Support';

        return view('admin.ticketprogram.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => '',
        ]);

    }

    public function crate(Request $request){

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

        $data = new TicketProgram;
        $data->name                      = $request->name;
        $data->show                      = $show;
        $data->created_by                = Auth::user()->displayname;
        $data->updated_by                = Auth::user()->displayname;
        $data->created_at                = date('Y-m-d H:i:s');
        $data->updated_at                = date('Y-m-d H:i:s');
        $data->save();

        return redirect()->route('ticket.program.edit',[$data->id])->with('feedback', 'เพิ่มข้อมูลเรียบร้อยแล้ว!');

    }

    public function edit($id)
    {
        $breadcrumb = [
            ['name' => 'อัพเดต Program Support'],
        ];
        $title_page = 'อัพเดต Program Support';

        $data = TicketProgram::findOrFail($id);

        return view('admin.ticketprogram.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => $data,
        ]);
    }

    public function update(Request $request,$id){

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

        $data = TicketProgram::findOrfail($id);
        $data->name                       = $request->name;
        $data->show                       = $show;
        $data->updated_by                 = Auth::user()->displayname;
        $data->updated_at                 = date('Y-m-d H:i:s');
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function jsondata()
    {

        $data = TicketProgram::get();

        return Datatables::of($data)
                ->addColumn('name', function ($data) {
                    return $data->name;
                })
                ->addColumn('show', function ($data) {
                    return $data->show;
                })
                ->addColumn('crated', function ($data) {
                    return $data->created_at.'<br/><small><i class="fa fa-user"></i> '.$data->created_by.'</small>';
                })
                ->addColumn('updated', function ($data) {
                    return $data->updated_at.'<br/><small><i class="fa fa-user"></i> '.$data->updated_by.'</small>';
                })
                ->addColumn('actions', function ($data) {
                    $id = $data->id;
                    $name = $data->name;
                    $status = $data->show;
                    return view('admin.ticketprogram.button', compact('id','status','name'));
                })
                ->escapeColumns([])
                ->addIndexColumn()
                ->make(true);
    }

    public function status($id){

        $data = TicketProgram::findOrFail($id);

        if($data->show == 2){
            $status = 1;
        }elseif($data->show == 1) {
            $status = 2;
        }

        $data->show                = $status;
        $data->updated_by                   = Auth::user()->displayname;
        $data->updated_at                   = date('Y-m-d H:i:s');
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');
    }

    public function delete(Request $request){

        TicketProgram::where('id', $request->deleteId)->delete();
        return back()->with('feedback', 'ลบข้อมูลเรียบร้อยแล้ว!');

    }

}
