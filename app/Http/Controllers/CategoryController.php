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
use App\Models\TbCategory;
use App\Models\TbCategorySub;
use App\Models\UsersLevel;

class CategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $breadcrumb = [
            ['name' => 'หมวดหมู่สินค้า'],
        ];
        $title_page = 'หมวดหมู่สินค้า';
        $count = TbCategory::count();

        return view('admin.category.main', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'count' => $count,
            'data' => '',
        ]);

    }

    public function add(){

        $breadcrumb = [
            ['name' => 'เพิ่มหมวดหมู่สินค้า'],
        ];
        $title_page = 'เพิ่มหมวดหมู่สินค้า';

        $types = TbType::where('type_show',1)->get();
        $sort = TbCategory::orderBy('category_sort','desc')->first();

        return view('admin.category.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'types' => $types,
            'sort' => $sort,
            'data' => '',
        ]);

    }

    public function crate(Request $request){

        $request->validate(
            [
                'category_name' => 'required',
                'category_permalink' => 'required',
                'category_type' => 'required',
            ],
            [
                'category_name.required' => 'กรุณากรอกข้อมูล',
                'category_permalink.required' => 'กรุณากรอกข้อมูล',
                'category_type.required' => 'กรุณาเลือกข้อมูล',
            ]
        );

        if($request->category_show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        $data = new TbCategory;
        $data->category_name            = $request->category_name;
        $data->category_permalink       = $this->rewrite_url($request->category_permalink);
        $data->category_type            = $request->category_type;
        $data->category_note            = $request->category_note;
        $data->category_sort            = $request->category_sort;
        $data->category_option          = $request->category_option;
        $data->category_display_status  = $request->category_display_status;
        $data->category_show            = $show;
        $data->created_by               = Auth::user()->displayname;
        $data->updated_by               = Auth::user()->displayname;
        $data->created_at               = date('Y-m-d H:i:s');
        $data->updated_at               = date('Y-m-d H:i:s');
        $data->save();

        return redirect()->route('category.edit',[$data->id])->with('feedback', 'เพิ่มข้อมูลเรียบร้อยแล้ว!');

    }

    public function edit($id)
    {
        $breadcrumb = [
            ['name' => 'อัพเดตหมวดหมู่สินค้า'],
        ];
        $title_page = 'อัพเดตหมวดหมู่สินค้า';

        $data  = TbCategory::findOrFail($id);
        $types = TbType::where('type_show',1)->get();
        $sort = TbCategory::orderBy('category_sort','desc')->first();

        return view('admin.category.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'types' => $types,
            'data' => $data,
            'sort' => $sort,
        ]);
    }

    public function update(Request $request,$id){

        $request->validate(
            [
                'category_name' => 'required',
                'category_permalink' => 'required',
                'category_type' => 'required',
            ],
            [
                'category_name.required' => 'กรุณากรอกข้อมูล',
                'category_permalink.required' => 'กรุณากรอกข้อมูล',
                'category_type.required' => 'กรุณาเลือกข้อมูล',
            ]
        );

        if($request->category_show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        $data = TbCategory::findOrFail($id);
        $data->category_name            = $request->category_name;
        $data->category_permalink       = $this->rewrite_url($request->category_permalink);
        $data->category_type            = $request->category_type;
        $data->category_note            = $request->category_note;
        $data->category_sort            = $request->category_sort;
        $data->category_option          = $request->category_option;
        $data->category_display_status  = $request->category_display_status;
        $data->category_show            = $show;
        $data->updated_by               = Auth::user()->displayname;
        $data->updated_at               = date('Y-m-d H:i:s');
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function status($id){

        $data = TbCategory::findOrFail($id);

        if($data->category_show == 2){
            $status = 1;
        }elseif($data->category_show == 1) {
            $status = 2;
        }

        $data->category_show                = $status;
        $data->updated_by                   = Auth::user()->displayname;
        $data->updated_at                   = date('Y-m-d H:i:s');
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');
    }

    public function delete(Request $request){

        $id = $request->deleteId;

        $product = TbProduct::where('pro_catId',$id)->count();

        if($product == 0){

            $categorySub = TbCategorySub::where('category_id',$id)->count();

            if($categorySub == 0){

                TbCategory::where('id', $id)->delete();
                return back()->with('feedback', 'ลบข้อมูลเรียบร้อยแล้ว!');

            }else{

                return back()->with(['feedback-er' =>'ไม่สามารถลบข้อมูลได้!','text-er'=>'เนื่องจากในหมวดหมู่ย่อยมีการใช้งานอยู่']);
            }
            

        }else{
            return back()->with(['feedback-er' =>'ไม่สามารถลบข้อมูลได้!','text-er'=>'เนื่องจากในข้อมูลสินค้ามีการใช้งานอยู่']);
        }

    }

    public function jsondata()
    {

        $data = TbCategory::get();

        return Datatables::of($data)
                ->addColumn('category_name', function ($data) {
                    return $data->category_name;
                })
                ->addColumn('category_show', function ($data) {
                    return $data->category_show;
                })
                ->addColumn('category_sort', function ($data) {
                    return $data->category_sort;
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
                        $status = $data->category_show;
                        $name = $data->category_name;
                        return view('admin.category.button', compact('id','status','name'));
                    }
                    
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
