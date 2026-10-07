<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Providers\RouteServiceProvider;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Storage;

use App\Models\TbProduct;
use App\Models\TbCategory;
use App\Models\TbCategorySub;
use App\Models\UsersLevel;

class CategorysubController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($categoryId)
    {

        $category = TbCategory::findOrFail($categoryId);

        $breadcrumb = [
            ['name' => $category->category_name],
        ];
        $title_page = $category->category_name;
        $count = TbCategorySub::where('category_id',$categoryId)->count();

        return view('admin.categorysub.main', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'categoryId' => $categoryId,
            'count' => $count,
            'data' => '',
        ]);

    }

    public function add($categoryId){

        $breadcrumb = [
            ['name' => 'เพิ่มหมวดหมู่สินค้าย่อย'],
        ];
        $title_page = 'เพิ่มหมวดหมู่สินค้าย่อย';

        $category = TbCategory::findOrFail($categoryId);
        $sort = TbCategorySub::orderBy('categorysub_sort','desc')->first();

        return view('admin.categorysub.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'category' => $category,
            'categoryId' => $categoryId,
            'sort' => $sort,
            'data' => '',
        ]);

    }

    public function crate(Request $request){

        $request->validate(
            [
                'categorysub_name' => 'required',
                'categorysub_permalink' => 'required',
            ],
            [
                'categorysub_name.required' => 'กรุณากรอกข้อมูล',
                'categorysub_permalink.required' => 'กรุณากรอกข้อมูล',
            ]
        );

        if($request->categorysub_show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        $data = new TbCategorySub;
        $data->categorysub_name            = $request->categorysub_name;
        $data->categorysub_permalink       = $this->rewrite_url($request->categorysub_permalink);
        $data->category_id                 = $request->category_id;
        $data->categorysub_note            = $request->categorysub_note;
        $data->categorysub_sort            = $request->categorysub_sort;
        $data->categorysub_option          = $request->categorysub_option;
        $data->categorysub_show            = $show;
        $data->created_by                  = Auth::user()->displayname;
        $data->updated_by                  = Auth::user()->displayname;
        $data->created_at                  = date('Y-m-d H:i:s');
        $data->updated_at                  = date('Y-m-d H:i:s');
        $data->save();

        return redirect()->route('categorysub.edit',['categoryId' => $request->category_id,'subId' => $data->id])->with('feedback', 'เพิ่มข้อมูลเรียบร้อยแล้ว!');

    }

    public function edit($categoryId,$subId)
    {

        $breadcrumb = [
            ['name' => 'อัพเดตหมวดหมู่สินค้าย่อย'],
        ];
        $title_page = 'อัพเดตหมวดหมู่สินค้าย่อย';

        $category = TbCategory::findOrfail($categoryId);
        $data  = TbCategorySub::findOrFail($subId);
        $sort = TbCategorySub::orderBy('categorysub_sort','desc')->first();

        return view('admin.categorysub.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'category' => $category,
            'categoryId' => $categoryId,
            'sort' => $sort,
            'data' => $data,
        ]);
    }

    public function update(Request $request,$categoryId,$subId){

        $request->validate(
            [
                'categorysub_name' => 'required',
                'categorysub_permalink' => 'required',
            ],
            [
                'categorysub_name.required' => 'กรุณากรอกข้อมูล',
                'categorysub_permalink.required' => 'กรุณากรอกข้อมูล',
            ]
        );

        if($request->categorysub_show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        $data = TbCategorySub::findOrFail($subId);
        $data->categorysub_name            = $request->categorysub_name;
        $data->categorysub_permalink       = $this->rewrite_url($request->categorysub_permalink);
        $data->category_id                 = $request->category_id;
        $data->categorysub_note            = $request->categorysub_note;
        $data->categorysub_sort            = $request->categorysub_sort;
        $data->categorysub_option          = $request->categorysub_option;
        $data->categorysub_show            = $show;
        $data->updated_by                  = Auth::user()->displayname;
        $data->updated_at                  = date('Y-m-d H:i:s');
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function status($categoryId,$subId){

        $data = TbCategorySub::findOrFail($subId);

        if($data->categorysub_show == 2){
            $status = 1;
        }elseif($data->categorysub_show == 1) {
            $status = 2;
        }

        $data->categorysub_show             = $status;
        $data->updated_by                   = Auth::user()->displayname;
        $data->updated_at                   = date('Y-m-d H:i:s');
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');
    }

    public function delete(Request $request){

        $id = $request->deleteId;

        $product = TbProduct::where('pro_catsubId',$id)->count();

        if($product == 0){

            TbCategorySub::where('id', $request->deleteId)->delete();
            return back()->with('feedback', 'ลบข้อมูลเรียบร้อยแล้ว!');

        }else{
            return back()->with(['feedback-er' =>'ไม่สามารถลบข้อมูลได้!','text-er'=>'เนื่องจากในข้อมูลสินค้ามีการใช้งานอยู่']);
        }

    }

    public function jsondata(Request $request)
    {

        $data = TbCategorySub::where('category_id',$request->categoryId)->get();

        return Datatables::of($data)
                ->addColumn('categorysub_name', function ($data) {
                    return $data->categorysub_name;
                })
                ->addColumn('categorysub_show', function ($data) {
                    return $data->categorysub_show;
                })
                ->addColumn('categorysub_sort', function ($data) {
                    return $data->categorysub_sort;
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
                        $categoryId = $data->category_id;
                        $status = $data->categorysub_show;
                        $name = $data->categorysub_name;
                        return view('admin.categorysub.button', compact('id','categoryId','status','name'));
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
