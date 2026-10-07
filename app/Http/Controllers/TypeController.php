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
use App\Models\TbTypeSetting;
use App\Models\UsersLevel;
use App\Models\TbCategory;

class TypeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function setting()
    {

        $breadcrumb = [
            ['name' => 'ตั้งค่าภาษีมูลค่าเพิ่ม'],
        ];
        $title_page = 'ตั้งค่าภาษีมูลค่าเพิ่ม';
        $data = TbTypeSetting::first();

        return view('admin.type.setting', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => $data,
        ]);

    }

    public function settingCrate(Request $request){

        $request->validate(
            [
                'vat' => 'required',
            ],
            [
                'vat.required' => 'กรุณากรอกข้อมูล',
            ]
        );

        if($request->show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        $data = new TbTypeSetting;
        $data->type_vat                 = $request->vat;
        $data->type_show                = $show;
        $data->created_by               = Auth::user()->displayname;
        $data->updated_by               = Auth::user()->displayname;
        $data->created_at               = date('Y-m-d H:i:s');
        $data->updated_at               = date('Y-m-d H:i:s');
        $data->save();

        $types = TbType::get();
        if(count($types) != 0){
            foreach($types as $type){

                $update = TbType::findOrFail($type->id);
                $update->type_vat                 = $request->vat;
                $update->updated_by               = Auth::user()->displayname;
                $update->updated_at               = date('Y-m-d H:i:s');
                $update->save();

            }
        }

        return redirect()->route('type.settiing.edit',[$data->id])->with('feedback', 'เพิ่มข้อมูลเรียบร้อยแล้ว!');

    }

    public function settingUpdate(Request $request,$id){

        $request->validate(
            [
                'vat' => 'required',
            ],
            [
                'vat.required' => 'กรุณากรอกข้อมูล',
            ]
        );

        if($request->show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        $data = TbTypeSetting::findOrFail($id);
        $data->vat                      = $request->vat;
        $data->show                     = $show;
        $data->updated_by               = Auth::user()->displayname;
        $data->updated_at               = date('Y-m-d H:i:s');
        $data->save();

        $types = TbType::get();
        if(count($types) != 0){
            foreach($types as $type){

                $update = TbType::findOrFail($type->id);
                $update->type_vat                 = $request->vat;
                $update->updated_by               = Auth::user()->displayname;
                $update->updated_at               = date('Y-m-d H:i:s');
                $update->save();

            }
        }

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function index()
    {

        $breadcrumb = [
            ['name' => 'ประเภทสินค้า'],
        ];
        $title_page = 'ประเภทสินค้า';
        $count = TbType::count();

        return view('admin.type.main', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'count' => $count,
            'data' => '',
        ]);

    }

    public function add(){

        $breadcrumb = [
            ['name' => 'เพิ่มประเภทสินค้า'],
        ];
        $title_page = 'เพิ่มประเภทสินค้า';
        $settingVat = TbTypeSetting::first();

        return view('admin.type.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'settingVat' => $settingVat,
            'data' => '',
        ]);

    }

    public function crate(Request $request){

        $request->validate(
            [
                'type_name' => 'required',
            ],
            [
                'type_name.required' => 'กรุณากรอกข้อมูล',
            ]
        );

        if($request->type_show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        $data = new TbType;
        $data->type_name                = $request->type_name;
        $data->type_vat                 = $request->type_vat;
        $data->type_withholding         = $request->type_withholding;
        $data->type_show                = $show;
        $data->created_by               = Auth::user()->displayname;
        $data->updated_by               = Auth::user()->displayname;
        $data->created_at               = date('Y-m-d H:i:s');
        $data->updated_at               = date('Y-m-d H:i:s');
        $data->save();

        return redirect()->route('type.edit',[$data->id])->with('feedback', 'เพิ่มข้อมูลเรียบร้อยแล้ว!');

    }

    public function edit($id)
    {
        $breadcrumb = [
            ['name' => 'อัพเดตประเภทสินค้า'],
        ];
        $title_page = 'อัพเดตประเภทสินค้า';

        $data = TbType::findOrFail($id);
        $settingVat = TbTypeSetting::first();

        return view('admin.type.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'settingVat' => $settingVat,
            'data' => $data,
        ]);
    }

    public function update(Request $request,$id){

        $request->validate(
            [
                'type_name' => 'required',
            ],
            [
                'type_name.required' => 'กรุณากรอกข้อมูล',
            ]
        );

        if($request->type_show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        $data = TbType::findOrFail($id);
        $data->type_name                = $request->type_name;
        $data->type_vat                 = $request->type_vat;
        $data->type_withholding         = $request->type_withholding;
        $data->type_show                = $show;
        $data->updated_by               = Auth::user()->displayname;
        $data->updated_at               = date('Y-m-d H:i:s');
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function status($id){

        $data = TbType::findOrFail($id);

        if($data->type_show == 2){
            $status = 1;
        }elseif($data->type_show == 1) {
            $status = 2;
        }

        $data->type_show                   = $status;
        $data->updated_by                   = Auth::user()->displayname;
        $data->updated_at                   = date('Y-m-d H:i:s');
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');
    }

    public function delete(Request $request){

        $id = $request->deleteId;

        $category = TbCategory::where('category_type',$id)->count();

        if($category == 0){
            TbType::where('id', $request->deleteId)->delete();
            return back()->with('feedback', 'ลบข้อมูลเรียบร้อยแล้ว!');
        }else{
            return back()->with(['feedback-er' =>'ไม่สามารถลบข้อมูลได้!','text-er'=>'เนื่องจากในข้อมูลหมวดหมู่สินค้ามีการใช้งานอยู่']);
        }

    }

    public function jsondata()
    {

        $data = TbType::get();

        return Datatables::of($data)
                ->addColumn('type_name', function ($data) {
                    return $data->type_name;
                })
                ->addColumn('type_vat', function ($data) {
                    return $data->type_vat;
                })
                ->addColumn('type_withholding', function ($data) {
                    return $data->type_withholding;
                })
                ->addColumn('type_show', function ($data) {
                    return $data->type_show;
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
                        $status = $data->type_show;
                        $name = $data->type_name;
                        return view('admin.type.button', compact('id','status','name'));
                    }
                    
                })
                ->escapeColumns([])
                ->addIndexColumn()
                ->make(true);
    }

}
