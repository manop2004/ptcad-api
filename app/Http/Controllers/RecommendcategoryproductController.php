<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Providers\RouteServiceProvider;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Storage;

use App\Models\TbRecommendProductCategory;
use App\Models\TbProduct;
use App\Models\TbCategory;
use App\Models\TbCategorySub;
use App\Rules\checkProductRecommend;

class RecommendcategoryproductController extends Controller
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
        $title_page = 'แนะนำหมวดหมู่ & สินค้า';
        $count = TbRecommendProductCategory::count();

        return view('admin.recommendcategoryproduct.main', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'count' => $count,
            'data' => '',
        ]);

    }

    public function add(){

        $breadcrumb = [
            ['name' => 'เพิ่มแนะนำหมวดหมู่ & สินค้า'],
        ];
        $title_page = 'เพิ่มแนะนำหมวดหมู่ & สินค้า';
        $products = TbProduct::where('pro_show',1)->get();
        $sort = TbRecommendProductCategory::select('sort')->orderBy('sort','desc')->first();

        return view('admin.recommendcategoryproduct.form', [
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
                'categoryId' => 'required',
                'recommend_product_category' => ['required',new checkProductRecommend()],
            ],
            [
                'categoryId.required' => 'กรุณาเลือกข้อมูล',
                'recommend_product_category.required' => 'กรุณาเลือกข้อมูล',
            ]
        );

        if($request->show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        if($request->recommend_product_category != ''){
			$recommend_product = implode(",", $request->recommend_product_category);
		} else {
			$recommend_product = '';
		}

        $data = new TbRecommendProductCategory;
        $data->option_type             = $request->old_option_type;
        $data->categoryId              = $request->categoryId;
        $data->recommend_product       = $recommend_product;
        $data->sort                    = $request->sort;
        $data->show                    = $show;
        $data->created_by              = Auth::user()->displayname;
        $data->updated_by              = Auth::user()->displayname;
        $data->created_at              = date('Y-m-d H:i:s');
        $data->updated_at              = date('Y-m-d H:i:s');

        if ($request->hasFile('thumb')) {
            @unlink(Storage::disk('public')->path('recommendProduct') . $request->thumb_old);

            $newFilename = uniqid() . '.' . $request->thumb->extension();
            $data->thumb = $newFilename;
            $file = $request->file('thumb');
            $file->move('storage/recommendProduct/', $newFilename);
        }

        $data->save();

        return redirect()->route('recommend.category.product.edit',[$data->id])->with('feedback', 'เพิ่มข้อมูลเรียบร้อยแล้ว!');

    }

    public function edit($id)
    {
        $breadcrumb = [
            ['name' => 'อัพเดตแนะนำหมวดหมู่ & สินค้า'],
        ];
        $title_page = 'อัพเดตแนะนำหมวดหมู่ & สินค้า';

        $data = TbRecommendProductCategory::findOrFail($id);
        $products = TbProduct::where('pro_show',1)->get();
        $sort = TbRecommendProductCategory::select('sort')->orderBy('sort','desc')->first();

        return view('admin.recommendcategoryproduct.form', [
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
                'categoryId' => 'required',
                'recommend_product_category' => ['required',new checkProductRecommend()],
                
            ],
            [
                'categoryId.required' => 'กรุณาเลือกข้อมูล',
                'recommend_product_category.required' => 'กรุณาเลือกข้อมูล',
            ]
        );

        if($request->show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        if($request->recommend_product_category != ''){
			$recommend_product = implode(",", $request->recommend_product_category);
		} else {
			$recommend_product = '';
		}

        $data = TbRecommendProductCategory::findOrFail($id);
        $data->option_type             = $request->old_option_type;
        $data->categoryId              = $request->categoryId;
        $data->recommend_product       = $recommend_product;
        $data->sort                    = $request->sort;
        $data->show                    = $show;
        $data->updated_by                   = Auth::user()->displayname;
        $data->updated_at                   = date('Y-m-d H:i:s');

        if ($request->hasFile('thumb')) {
            @unlink(Storage::disk('public')->path('recommendProduct') . $request->thumb_old);

            $newFilename = uniqid() . '.' . $request->thumb->extension();
            $data->thumb = $newFilename;
            $file = $request->file('thumb');
            $file->move('storage/recommendProduct/', $newFilename);
        }

        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function status($id){

        $data = TbRecommendProductCategory::findOrFail($id);

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

        TbRecommendProductCategory::where('id', $request->deleteId)->delete();
        return back()->with('feedback', 'ลบข้อมูลเรียบร้อยแล้ว!');

    }

    public function deleteImg(Request $request){

        $data = TbRecommendProductCategory::findOrFail($request->deleteId);

        @unlink(Storage::disk('public')->path('product') . $data->thumb);

        $data->thumb                        = null;
        $data->updated_by                   = Auth::user()->displayname;
        $data->updated_at                   = date('Y-m-d H:i:s');
        $data->save();

        return back()->with('feedback', 'ลบข้อมูลเรียบร้อยแล้ว!');

    }


    public function jsondata()
    {

        $data = TbRecommendProductCategory::get();

        return Datatables::of($data)
                ->addColumn('recommend_name', function ($data) {
                    if($data->option_type == 1){
                        return TbCategory::where('id',$data->categoryId)->value('category_name');
                    }else{
                        return TbCategorySub::where('id',$data->categoryId)->value('categorysub_name');
                    }
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
                    if($data->option_type == 1){
                        $name = TbCategory::where('id',$data->categoryId)->value('category_name');
                    }else{
                        $name = TbCategorySub::where('id',$data->categoryId)->value('categorysub_name');
                    }
                    return view('admin.recommendcategoryproduct.button', compact('id','status','name'));
                })
                ->escapeColumns([])
                ->addIndexColumn()
                ->make(true);
    }

    public function jsonGet(Request $request){


        $catId = $request->catId;
        $old_cat = $request->old_cat;

        if($catId == 1){

            $data = TbCategory::where('category_show',1)->orderBy('category_sort','desc')->get();
            if(!empty($old_cat)){

                foreach($data as $category){

                    if($category->id == $old_cat){
                        $categorys[] = array(
                            'id' => $category->id,
                            'category_name' => $category->category_name,
                            'selected' => 'selected'
                        );
                    }else{
                        $categorys[] = array(
                            'id' => $category->id,
                            'category_name' => $category->category_name,
                            'selected' => ''
                        );
                    }
                }

            }else{

                foreach($data as $category){
                    $categorys[] = array(
                        'id' => $category->id,
                        'category_name' => $category->category_name,
                        'selected' => ''
                    );
                }
            }

        }else{

            $data = TbCategorySub::where('categorysub_show',1)->orderBy('categorysub_sort','desc')->get();

            if(!empty($old_cat)){

                foreach($data as $category){

                    if($category->id == $old_cat){
                        $categorys[] = array(
                            'id' => $category->id,
                            'category_name' => $category->categorysub_name,
                            'selected' => 'selected'
                        );
                    }else{
                        $categorys[] = array(
                            'id' => $category->id,
                            'category_name' => $category->categorysub_name,
                            'selected' => ''
                        );
                    }
                }

            }else{

                foreach($data as $category){
                    $categorys[] = array(
                        'id' => $category->id,
                        'category_name' => $category->categorysub_name,
                        'selected' => ''
                    );
                }
            }
        }

        return $categorys;

    }

    public function jsonproductGet(Request $request){

        $type = $request->type;
        $categoryId = $request->categoryId;
        $recommend_product = $request->recommend_product;

        if($type == 1){

            if(!empty($recommend_product)){

                $data = TbProduct::where('pro_show',1)->where('pro_catId',$categoryId)->orderBy('pro_name','desc')->get();
                $recommend = explode(",",$recommend_product);
                asort($recommend);

                foreach($data as $product){

                    $products[] = array(
                        'id' => $product->id,
                        'pro_name' => $product->pro_name,
                        'selected' => $this->selectedProduct($product->id, $recommend),
                    );

                }

            }else{
                $data = TbProduct::where('pro_show',1)->where('pro_catId',$categoryId)->orderBy('pro_name','desc')->get();

                foreach($data as $product){
                    $products[] = array(
                        'id' => $product->id,
                        'pro_name' => $product->pro_name,
                        'selected' => ''
                    );
                }
            }

        }else{

            $data = TbProduct::where('pro_show',1)->where('pro_catsubId',$categoryId)->orderBy('pro_name','desc')->get();

            if(!empty($recommend_product)){

                $recommend = explode(",",$recommend_product);
                asort($recommend);

                foreach($data as $product){

                    $products[] = array(
                        'id' => $product->id,
                        'pro_name' => $product->pro_name,
                        'selected' => $this->selectedProduct($product->id, $recommend),
                    );

                }

            }else{
                foreach($data as $product){
                    $products[] = array(
                        'id' => $product->id,
                        'pro_name' => $product->pro_name,
                        'selected' => ''
                    );
                }
            }

        }

        return $products;

    }

    private function selectedProduct($proId,$recommend){

        $key = in_array($proId, $recommend);
        if($key == true){
            $selected= 'selected';
        }else{
            $selected= '';
        }
        return $selected;

    }

}
