<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Providers\RouteServiceProvider;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Storage;

use App\Models\TbType;
use App\Models\TbProduct;
use App\Models\TbProgram;
use App\Models\TbProgramInstall;
use App\Models\UsersLevel;

class ProgramController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $breadcrumb = [
            ['name' => 'ตัวติดตั้งโปรแกรม'],
        ];
        $title_page = 'ตัวติดตั้งโปรแกรม';
        $count = TbProgram::count();

        return view('admin.program.main', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'count' => $count,
            'data' => '',
        ]);

    }

    public function add(){

        $breadcrumb = [
            ['name' => 'เพิ่มตัวติดตั้งโปรแกรม'],
        ];
        $title_page = 'เพิ่มตัวติดตั้งโปรแกรม';

        return view('admin.program.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => '',
            'tab' => 'tab1',
        ]);

    }

    public function crate(Request $request){

        $request->validate(
            [
                'program_name' => 'required',
            ],
            [
                'program_name.required' => 'กรุณากรอกข้อมูล',
            ]
        );

        if($request->show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        $data = new TbProgram;
        $data->program_name             = $request->program_name;
        $data->program_note             = $request->program_note;
        $data->show                     = $show;
        $data->created_by               = Auth::user()->displayname;
        $data->updated_by               = Auth::user()->displayname;
        $data->created_at               = date('Y-m-d H:i:s');
        $data->updated_at               = date('Y-m-d H:i:s');
        $data->save();

        return redirect()->route('program.edit',['id'=>$data->id,'tab'=>'tab1'])->with('feedback', 'เพิ่มข้อมูลเรียบร้อยแล้ว!');

    }

    public function edit($tab,$id)
    {
        $breadcrumb = [
            ['name' => 'อัพเดตตัวติดตั้งโปรแกรม'],
        ];
        $title_page = 'อัพเดตตัวติดตั้งโปรแกรม';

        $data  = TbProgram::findOrFail($id);
        $install  = TbProgramInstall::where('id',$id)->first();

        return view('admin.program.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => $data,
            'install' => $install,
            'tab' => $tab,
        ]);
    }

    public function update(Request $request,$tab,$id){

        $request->validate(
            [
                'program_name' => 'required',
            ],
            [
                'program_name.required' => 'กรุณากรอกข้อมูล',
            ]
        );

        if($request->show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        $data = TbProgram::findOrFail($id);
        $data->program_name             = $request->program_name;
        $data->program_note             = $request->program_note;
        $data->show                     = $show;
        $data->updated_by               = Auth::user()->displayname;
        $data->updated_at               = date('Y-m-d H:i:s');
        $data->save();

        return redirect()->route('program.edit',['tab'=>$tab,'id'=>$data->id])->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function status($id){

        $data = TbProgram::findOrFail($id);

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

        $id         = $request->deleteId;

        $programInstall = TbProgramInstall::where('programId',$id)->count();

        if($programInstall == 0){

            TbProgram::where('id', $id)->delete();
            return back()->with('feedback', 'ลบข้อมูลเรียบร้อยแล้ว!');

        }else{

            return back()->with(['feedback-er' =>'ไม่สามารถลบข้อมูลได้!','text-er'=>'เนื่องจากในโปรแกรมมีตัวติดตั้งการใช้งานอยู่']);
        }

    }

    public function jsondata()
    {

        $data = TbProgram::get();

        return Datatables::of($data)
                ->addColumn('name', function ($data) {
                    return $data->program_name;
                })
                ->addColumn('show', function ($data) {
                    return $data->show;
                })
                ->addColumn('updated', function ($data) {
                    return $data->updated_by.'<br/>'.$data->updated_at;
                })
                ->addColumn('actions', function ($data) {

                    $UserLevel = UsersLevel::where('UserId',Auth::user()->id)->first();
                    if($UserLevel->l_product_Action == 2){
                        return '<small class="text-danger">ไม่มีสิทธิ์เข้าถึง</small>';
                    }else{
                        $id = $data->id;
                        $status = $data->show;
                        $name = $data->program_name;
                        return view('admin.program.button', compact('id','status','name'));
                    }
                })
                ->escapeColumns([])
                ->addIndexColumn()
                ->make(true);
    }

}
