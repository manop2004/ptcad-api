<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Providers\RouteServiceProvider;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Storage;

use App\Models\TbSettingInstallment;

class InstallmentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $breadcrumb = [
            ['name' => 'ข้อมูลการผ่อนชำระ'],
        ];
        $title_page = 'ข้อมูลการผ่อนชำระ';
        $count = TbSettingInstallment::count();

        return view('admin.installment.main', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'count' => $count,
            'data' => '',
        ]);

    }

    public function add(){

        $breadcrumb = [
            ['name' => 'เพิ่มข้อมูลการผ่อนชำระ'],
        ];
        $title_page = 'เพิ่มข้อมูลการผ่อนชำระ';

        return view('admin.installment.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => '',
        ]);

    }

    public function crate(Request $request){

        $request->validate(
            [
                'installment_name' => 'required',
                'installment_detail' => 'required',
            ],
            [
                'installment_name.required' => 'กรุณากรอกข้อมูล',
                'installment_detail.required' => 'กรุณากรอกข้อมูล',
            ]
        );

        if($request->installment_show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        $data = new TbSettingInstallment;
        $data->installment_name           = $request->installment_name;
        $data->installment_detail         = $request->installment_detail;
        $data->interest_detail         	  = $request->interest_detail;
        $data->installment_show           = $show;
        $data->created_by                 = Auth::user()->displayname;
        $data->updated_by                 = Auth::user()->displayname;
        $data->created_at                 = date('Y-m-d H:i:s');
        $data->updated_at                 = date('Y-m-d H:i:s');

        if (!empty($request->installment_img)) {

            if ($request->hasFile('installment_img')) {
                @unlink(Storage::disk('public')->path('installment/') . $request->installment_img_old);

                $newFilename = uniqid() . '.' . $request->installment_img->extension();
                $data->installment_img = $newFilename;
                $file = $request->file('installment_img');
                $file->move('storage/installment/', $newFilename);
            }

        }

        $data->save();

        return redirect()->route('installment.edit',[$data->id])->with('feedback', 'เพิ่มข้อมูลเรียบร้อยแล้ว!');

    }

    public function edit($id)
    {
        $breadcrumb = [
            ['name' => 'อัพเดตข้อมูลการผ่อนชำระ'],
        ];
        $title_page = 'อัพเดตข้อมูลการผ่อนชำระ';

        $data = TbSettingInstallment::findOrFail($id);

        return view('admin.installment.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => $data,
        ]);
    }

    public function update(Request $request,$id){

        $request->validate(
            [
                'installment_name' => 'required',
                'installment_detail' => 'required',
            ],
            [
                'installment_name.required' => 'กรุณากรอกข้อมูล',
                'installment_detail.required' => 'กรุณากรอกข้อมูล',
            ]
        );

        if($request->installment_show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        $data = TbSettingInstallment::findOrFail($id);
        $data->installment_name         = $request->installment_name;
        $data->installment_detail       = $request->installment_detail;
        $data->interest_detail       	= $request->interest_detail;
        $data->installment_show         = $show;
        $data->updated_by               = Auth::user()->displayname;
        $data->updated_at               = date('Y-m-d H:i:s');

        if (!empty($request->installment_img)) {

            if ($request->hasFile('installment_img')) {
                @unlink(Storage::disk('public')->path('installment/') . $request->installment_img_old);

                $newFilename = uniqid() . '.' . $request->installment_img->extension();
                $data->installment_img = $newFilename;
                $file = $request->file('installment_img');
                $file->move('storage/installment/', $newFilename);
            }

        }
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function status($id){

        $data = TbSettingInstallment::findOrFail($id);

        if($data->installment_show == 2){
            $status = 1;
        }elseif($data->installment_show == 1) {
            $status = 2;
        }

        $data->installment_show             = $status;
        $data->updated_by                   = Auth::user()->displayname;
        $data->updated_at                   = date('Y-m-d H:i:s');
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');
    }

    public function delete(Request $request){

        $check = TbSettingInstallment::findOrFail($request->deleteId);
        if(!empty($check)){
            @unlink(Storage::disk('public')->path('installment/') . $check->installment_img);
        }
        TbSettingInstallment::where('id', $request->deleteId)->delete();
        return back()->with('feedback', 'ลบข้อมูลเรียบร้อยแล้ว!');

    }

    public function deleteImg(Request $request){

        $check = TbSettingInstallment::findOrfail($request->deleteId);
        if (!empty($check->installment_img)) {
            @unlink(Storage::disk('public')->path('installment/').$check->installment_img);
        }

        $data = TbSettingInstallment::findOrfail($request->deleteId);
        $data->installment_img              = null;
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function jsondata()
    {

        $data = TbSettingInstallment::get();

        return Datatables::of($data)
                ->addColumn('installment_img', function ($data) {
                    if(!empty($data->installment_img)){
                        if(!empty($data->installment_permalink)){
                            return '<a href="'.$data->installment_permalink.'"><img src="'.asset('storage/installment/'.$data->installment_img).'" alt="" class="table-width text-align-center" rel="nofollow"></a>';
                        }else{
                            return '<img src="'.asset('storage/installment/'.$data->installment_img).'" alt="" class="table-width text-align-center" rel="nofollow">';
                        }
                    }else{
                        return '<img src="'.asset('images/default-img/default-banner_2048_587.jpg').'" alt="..." class="table-width text-align-center" rel="nofollow">';
                    }
                })
                ->addColumn('installment_name', function ($data) {
                    if(!empty($data->installment_detail)){
                        $installment_detail = '<br/><small>'.$data->installment_detail.'</small>';
                    }else{
                        $installment_detail = '';
                    }
					if(!empty($data->interest_detail)){
                        $interest_detail = '<br/><small>อัตราดอกเบี้ย <b style="color: red;">'.$data->interest_detail.'</b></small>';
                    }else{
                        $interest_detail = '';
                    }
                    return $data->installment_name.''.$installment_detail.$interest_detail;
                })
                ->addColumn('installment_show', function ($data) {
                    return $data->installment_show;
                })
                ->addColumn('updated', function ($data) {
                    return $data->updated_by.'<br/>'.$data->updated_at;
                })
                ->addColumn('actions', function ($data) {
                    $id = $data->id;
                    $status = $data->installment_show;
                    $name = $data->installment_name;
                    return view('admin.installment.button', compact('id','status','name'));
                })
                ->escapeColumns([])
                ->addIndexColumn()
                ->make(true);
    }

}
