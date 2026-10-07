<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Providers\RouteServiceProvider;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Storage;

use App\Models\TbRecommendProduct;
use App\Models\TbProduct;
use App\Rules\checkProduct;

class recommendproductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $breadcrumb = [
            ['name' => 'ตั้งค่ารายการแนะนำ'],
        ];
        $title_page = 'แนะนำสินค้า';
        $count = TbRecommendProduct::count();

        return view('admin.recommendproduct.main', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'count' => $count,
            'data' => '',
        ]);

    }

    public function add(){

        $breadcrumb = [
            ['name' => 'เพิ่มแนะนำสินค้า'],
        ];
        $title_page = 'เพิ่มแนะนำสินค้า';
        $products = TbProduct::where('pro_show',1)->get();
        $sort = TbRecommendProduct::select('sort')->orderBy('sort','desc')->first();

        return view('admin.recommendproduct.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'products' => $products,
            'sort' => $sort,
            'data' => '',
        ]);

    }

    public function crate(Request $request){

        $request->validate(
            [
                'recommend_name' => 'required',
                'recommend_product' => new checkProduct(),
                
            ],
            [
                'recommend_name.required' => 'กรุณาเลือกกรอกข้อมูล',
            ]
        );

        if($request->show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        if($request->recommend_product != ''){
			$recommend_product = implode(",", $request->recommend_product);
		} else {
			$recommend_product = '';
		}

        $data = new TbRecommendProduct;
        $data->recommend_name          = $request->recommend_name;
        $data->recommend_product       = $recommend_product;
        $data->sort                    = $request->sort;
        $data->show                    = $show;
        $data->created_by              = Auth::user()->displayname;
        $data->updated_by              = Auth::user()->displayname;
        $data->created_at              = date('Y-m-d H:i:s');
        $data->updated_at              = date('Y-m-d H:i:s');
        $data->save();

        return redirect()->route('recommend.product.edit',[$data->id])->with('feedback', 'เพิ่มข้อมูลเรียบร้อยแล้ว!');

    }

    public function edit($id)
    {
        $breadcrumb = [
            ['name' => 'อัพเดตแนะนำสินค้า'],
        ];
        $title_page = 'อัพเดตแนะนำสินค้า';

        $data = TbRecommendProduct::findOrFail($id);
        $products = TbProduct::where('pro_show',1)->get();
        $sort = TbRecommendProduct::select('sort')->orderBy('sort','desc')->first();

        return view('admin.recommendproduct.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'products' => $products,
            'sort' => $sort,
            'data' => $data,
        ]);
    }

    public function update(Request $request,$id){

        $request->validate(
            [
                'recommend_name' => 'required',
                'recommend_product' => new checkProduct(),
            ],
            [
                'recommend_name.required' => 'กรุณาเลือกกรอกข้อมูล',
            ]
        );

        if($request->show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        if($request->recommend_product != ''){
			$recommend_product = implode(",", $request->recommend_product);
		} else {
			$recommend_product = '';
		}

        $data = TbRecommendProduct::findOrFail($id);

        $data->recommend_name               = $request->recommend_name;
        $data->recommend_product            = $recommend_product;
        $data->sort                         = $request->sort;
        $data->show                         = $show;
        $data->updated_by                   = Auth::user()->displayname;
        $data->updated_at                   = date('Y-m-d H:i:s');
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function status($id){

        $data = TbRecommendProduct::findOrFail($id);

        if($data->show == 2){
            $status = 1;
        }elseif($data->show == 1) {
            $status = 2;
        }

        $data->show                  = $status;
        $data->updated_by                   = Auth::user()->displayname;
        $data->updated_at                   = date('Y-m-d H:i:s');
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');
    }

    public function delete(Request $request){

        TbRecommendProduct::where('id', $request->deleteId)->delete();
        return back()->with('feedback', 'ลบข้อมูลเรียบร้อยแล้ว!');

    }


    public function jsondata()
    {

        $data = TbRecommendProduct::get();

        return Datatables::of($data)
                ->addColumn('recommend_name', function ($data) {
                    return $data->recommend_name;
                })
                ->addColumn('recommend_sort', function ($data) {
                    return $data->sort;
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
                    $name = $data->recommend_name;
                    return view('admin.recommendproduct.button', compact('id','status','name'));
                })
                ->escapeColumns([])
                ->addIndexColumn()
                ->make(true);
    }

    public function jsonGet(){

        $categorys = TbProduct::where('pro_show',1)->get();
        return $categorys;

    }

}
