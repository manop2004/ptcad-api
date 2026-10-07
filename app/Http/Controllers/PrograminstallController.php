<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Providers\RouteServiceProvider;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Storage;

use App\Models\TbProgramInstall;
use App\Models\TbProgramInstallInstall;
use App\Models\UsersLevel;

class PrograminstallController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function add($p){

        $breadcrumb = [
            ['name' => 'เพิ่มตัวติดตั้งโปรแกรม'],
        ];
        $title_page = 'เพิ่มตัวติดตั้งโปรแกรม';

        return view('admin.program.install.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => '',
            'p' => $p,
        ]);

    }

    public function crate(Request $request,$p){

        $request->validate(
            [
                'install_name' => 'required',
                'install_file' => 'required|max:5120',
            ],
            [
                'install_name.required' => 'กรุณากรอกข้อมูล',
                'install_file.required' => 'กรุณาเลือกไฟล์',
                'install_file.max' => 'กรุณาเลือกไฟล์ขนาดไม่เกิน 5 MB',
            ]
        );

        if($request->show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        $data = new TbProgramInstall;
        $data->programId                = $p;
        $data->install_name             = $request->install_name;
        $data->show                     = $show;
        $data->created_by               = Auth::user()->displayname;
        $data->updated_by               = Auth::user()->displayname;
        $data->created_at               = date('Y-m-d H:i:s');
        $data->updated_at               = date('Y-m-d H:i:s');

        if (!empty($request->install_file)) {

            if ($request->hasFile('install_file')) {
                $newFilename = uniqid() . '.' . $request->install_file->extension();
                $data->install_file = $newFilename;
                $file = $request->file('install_file');
                $file->move('storage/installProgram/', $newFilename);
            }

        }

        $data->save();

        return redirect()->route('program.install.edit',['p'=>$p,'id'=>$data->id])->with('feedback', 'เพิ่มข้อมูลเรียบร้อยแล้ว!');

    }

    public function edit($p,$id)
    {
        $breadcrumb = [
            ['name' => 'อัพเดตตัวติดตั้งโปรแกรม'],
        ];
        $title_page = 'อัพเดตตัวติดตั้งโปรแกรม';

        $data  = TbProgramInstall::findOrFail($id);

        return view('admin.program.install.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => $data,
            'p' => $p,
        ]);
    }

    public function update(Request $request,$p,$id){

        $request->validate(
            [
                'install_name' => 'required',
            ],
            [
                'install_name.required' => 'กรุณากรอกข้อมูล',
            ]
        );

        if($request->show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        $data = TbProgramInstall::findOrFail($id);
        $data->install_name             = $request->install_name;
        $data->show                     = $show;
        $data->updated_by               = Auth::user()->displayname;
        $data->updated_at               = date('Y-m-d H:i:s');

        if (!empty($request->install_file)) {

            if ($request->hasFile('install_file')) {
                @unlink(Storage::disk('public')->path('installProgram/') . $request->install_file_old);

                $newFilename = uniqid() . '.' . $request->install_file->extension();
                $data->install_file = $newFilename;
                $file = $request->file('install_file');
                $file->move('storage/installProgram/', $newFilename);
            }

        }

        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function status($id){

        $data = TbProgramInstall::findOrFail($id);

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
        TbProgramInstall::where('id', $id)->delete();
        return back()->with('feedback', 'ลบข้อมูลเรียบร้อยแล้ว!');

    }

    public function deleteFile(Request $request){

        $check = TbProgramInstall::where('id',$request->deleteId2)->first();
        if (!empty($check->install_file)) {
            @unlink(Storage::disk('public')->path('installProgram/').$check->install_file);
        }

        $data = TbProgramInstall::where('id',$request->deleteId2)->first();
        $data->install_file              = null;
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function jsondata($p)
    {

        $data = TbProgramInstall::where('programId',$p)->get();

        return Datatables::of($data)
                ->addColumn('name', function ($data) {
                    return $data->install_name;
                })
                ->addColumn('show', function ($data) {
                    return $data->show;
                })
                ->addColumn('updated', function ($data) {
                    return $data->updated_by.'<br/>'.$data->updated_at;
                })
                ->addColumn('actions', function ($data) {
                    $id = $data->id;
                    $status = $data->show;
                    $name = $data->install_name;
                    $programId = $data->programId;
                    return view('admin.program.install.button', compact('id','status','name','programId'));
                })
                ->escapeColumns([])
                ->addIndexColumn()
                ->make(true);
    }

}
