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

use App\Models\TbProductCondition;
use App\Models\TbProduct;
use App\Models\UsersLevel;

class ConditionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $breadcrumb = [
            ['name' => 'เงื่อนไขการบริการ'],
        ];
        $title_page = 'เงื่อนไขการบริการ';
        $count = TbProductCondition::count();

        return view('admin.condition.main', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'count' => $count,
            'data' => '',
        ]);

    }

    public function add(){

        $breadcrumb = [
            ['name' => 'เพิ่มเงื่อนไขการบริการ'],
        ];
        $title_page = 'เพิ่มเงื่อนไขการบริการ';

        return view('admin.condition.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => '',
        ]);

    }

    public function crate(Request $request){

        $request->validate(
            [
                'condition_name' => 'required',
                'condition_img' => 'required',
            ],
            [
                'condition_name.required' => 'กรุณากรอกข้อมูล',
                'condition_img.required' => 'กรุณาเลือกรูปภาพ',
            ]
        );

        if($request->condition_show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        $data = new TbProductCondition;
        $data->condition_name           = $request->condition_name;
        $data->condition_des            = $request->condition_des;
        $data->condition_show           = $show;
        $data->created_by               = Auth::user()->displayname;
        $data->updated_by               = Auth::user()->displayname;
        $data->created_at               = date('Y-m-d H:i:s');
        $data->updated_at               = date('Y-m-d H:i:s');

        if (!empty($request->condition_img)) {

            if ($request->hasFile('condition_img')) {
                @unlink(Storage::disk('public')->path('condition/') . $request->condition_img_old);

                $newFilename = uniqid() . '.' . $request->condition_img->extension();
                $data->condition_img = $newFilename;
                $file = $request->file('condition_img');
                $file->move('storage/condition/', $newFilename);
            }

        }

        $data->save();

        return redirect()->route('condition.edit',[$data->id])->with('feedback', 'เพิ่มข้อมูลเรียบร้อยแล้ว!');

    }

    public function edit($id)
    {
        $breadcrumb = [
            ['name' => 'อัพเดตเงื่อนไขการบริการ'],
        ];
        $title_page = 'อัพเดตเงื่อนไขการบริการ';

        $data = TbProductCondition::findOrFail($id);

        return view('admin.condition.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => $data,
        ]);
    }

    public function update(Request $request,$id){

        $request->validate(
            [
                'condition_name' => 'required',
            ],
            [
                'condition_name.required' => 'กรุณากรอกข้อมูล',
            ]
        );

        if($request->condition_show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        $data = TbProductCondition::findOrFail($id);
        $data->condition_name           = $request->condition_name;
        $data->condition_des            = $request->condition_des;
        $data->condition_show           = $show;
        $data->updated_by               = Auth::user()->displayname;
        $data->updated_at               = date('Y-m-d H:i:s');

        if (!empty($request->condition_img)) {

            if ($request->hasFile('condition_img')) {
                @unlink(Storage::disk('public')->path('condition/') . $request->condition_img_old);

                $newFilename = uniqid() . '.' . $request->condition_img->extension();
                $data->condition_img = $newFilename;
                $file = $request->file('condition_img');
                $file->move('storage/condition/', $newFilename);
            }

        }
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function status($id){

        $data = TbProductCondition::findOrFail($id);

        if($data->condition_show == 2){
            $status = 1;
        }elseif($data->condition_show == 1) {
            $status = 2;
        }

        $data->condition_show               = $status;
        $data->updated_by                   = Auth::user()->displayname;
        $data->updated_at                   = date('Y-m-d H:i:s');
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');
    }

    public function delete(Request $request){

        $id = $request->deleteId;

        $product = TbProduct::
        when($id, function ($query, $id) {
            return $query->where(function ($query) use ($id) {
                $query->orWhere('pro_codition', 'LIKE', '%' . $id . '%');
            });
        })
        ->count();

        if($product == 0){

            $check = TbProductCondition::findOrFail($id);
            if(!empty($check)){
                @unlink(Storage::disk('public')->path('condition/') . $check->condition_img);
            }
            TbProductCondition::where('id', $id)->delete();
            return back()->with('feedback', 'ลบข้อมูลเรียบร้อยแล้ว!');

        }else{
            return back()->with(['feedback-er' =>'ไม่สามารถลบข้อมูลได้!','text-er'=>'เนื่องจากในข้อมูลสินค้ามีการใช้งานอยู่']);
        }
        

    }

    public function deleteImg(Request $request){

        $check = TbProductCondition::findOrfail($request->deleteId);
        if (!empty($check->condition_img)) {
            @unlink(Storage::disk('public')->path('condition/').$check->condition_img);
        }

        $data = TbProductCondition::findOrfail($request->deleteId);
        $data->condition_img              = null;
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function jsondata()
    {

        $data = TbProductCondition::get();

        return Datatables::of($data)
                ->addColumn('condition_img', function ($data) {
                    if(!empty($data->condition_img)){
                        if(!empty($data->condition_permalink)){
                            return '<a href="'.$data->condition_permalink.'"><img src="'.asset('storage/condition/'.$data->condition_img).'" alt="" class="table-width text-align-center" rel="nofollow"></a>';
                        }else{
                            return '<img src="'.asset('storage/condition/'.$data->condition_img).'" alt="" class="table-width text-align-center" rel="nofollow">';
                        }
                    }else{
                        return '<img src="'.asset('images/default-img/default-condition_2048_587.jpg').'" alt="..." class="table-width text-align-center" rel="nofollow">';
                    }
                })
                ->addColumn('condition_name', function ($data) {
                    if(!empty($data->condition_des)){
                        $condition_des = '<br/><small>'.$data->condition_des.'</small>';
                    }else{
                        $condition_des = '';
                    }
                    return $data->condition_name.''.$condition_des;
                })
                ->addColumn('condition_show', function ($data) {
                    return $data->condition_show;
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
                        $status = $data->condition_show;
                        $name = $data->condition_name;
                        return view('admin.condition.button', compact('id','status','name'));
                    }
                    
                })
                ->escapeColumns([])
                ->addIndexColumn()
                ->make(true);
    }

}
