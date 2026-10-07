<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Providers\RouteServiceProvider;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Storage;

use App\Models\TbBrand;
use App\Models\TbProduct;
use App\Models\UsersLevel;

class BrandController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $breadcrumb = [
            ['name' => 'แบรนด์สินค้า'],
        ];
        $title_page = 'แบรนด์สินค้า';

        $countbrand = TbBrand::count();

        return view('admin.brand.main', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'countbrand' => number_format($countbrand),
            'data' => '',
        ]);

    }

    public function add(){

        $breadcrumb = [
            ['name' => 'เพิ่มแบรนด์สินค้า'],
        ];
        $title_page = 'เพิ่มแบรนด์สินค้า';

        return view('admin.brand.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => '',
        ]);

    }

    public function crate(Request $request){

        $request->validate(
            [
                'brand_name' => 'required',
                'brand_img' => 'required',
            ],
            [
                'brand_name.required' => 'กรุณากรอกข้อมูล',
                'brand_img.required' => 'กรุณาเลือกรูปภาพ',
            ]
        );

        if($request->brand_show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }
        if($request->brand_recommend != ''){
			$brand_recommend = 1;
		} else {
			$brand_recommend = 2;
		}

        $data = new TbBrand;
        $data->brand_name               = $request->brand_name;
        $data->brand_permalink          = $this->rewrite_url($request->brand_permalink);
        $data->brand_recommend          = $brand_recommend;
        $data->brand_show               = $show;
        $data->created_by               = Auth::user()->displayname;
        $data->updated_by               = Auth::user()->displayname;
        $data->created_at               = date('Y-m-d H:i:s');
        $data->updated_at               = date('Y-m-d H:i:s');

        if (!empty($request->brand_img)) {

            if ($request->hasFile('brand_img')) {
                @unlink(Storage::disk('public')->path('brand/') . $request->brand_img_old);

                $newFilename = uniqid() . '.' . $request->brand_img->extension();
                $data->brand_img = $newFilename;
                $file = $request->file('brand_img');
                $file->move('storage/brand/', $newFilename);
            }

        }

        $data->save();

        return redirect()->route('brand.edit',[$data->id])->with('feedback', 'เพิ่มข้อมูลเรียบร้อยแล้ว!');

    }

    public function edit($id)
    {
        $breadcrumb = [
            ['name' => 'อัพเดตแบรนด์สินค้า'],
        ];
        $title_page = 'อัพเดตแบรนด์สินค้า';

        $data = TbBrand::findOrFail($id);

        return view('admin.brand.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => $data,
        ]);
    }

    public function update(Request $request,$id){

        $request->validate(
            [
                'brand_name' => 'required',
            ],
            [
                'brand_name.required' => 'กรุณากรอกข้อมูล',
            ]
        );

        if($request->brand_show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }
        if($request->brand_recommend != ''){
			$brand_recommend = 1;
		} else {
			$brand_recommend = 2;
		}

        $data = TbBrand::findOrFail($id);
        $data->brand_name               = $request->brand_name;
        $data->brand_permalink          = $this->rewrite_url($request->brand_permalink);
        $data->brand_recommend          = $brand_recommend;
        $data->brand_show               = $show;
        $data->updated_by               = Auth::user()->displayname;
        $data->updated_at               = date('Y-m-d H:i:s');

        if (!empty($request->brand_img)) {

            if ($request->hasFile('brand_img')) {
                @unlink(Storage::disk('public')->path('brand/') . $request->brand_img_old);

                $newFilename = uniqid() . '.' . $request->brand_img->extension();
                $data->brand_img = $newFilename;
                $file = $request->file('brand_img');
                $file->move('storage/brand/', $newFilename);
            }

        }
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function status($id){

        $data = TbBrand::findOrFail($id);

        if($data->brand_show == 2){
            $status = 1;
        }elseif($data->brand_show == 1) {
            $status = 2;
        }

        $data->brand_show                   = $status;
        $data->updated_by                   = Auth::user()->displayname;
        $data->updated_at                   = date('Y-m-d H:i:s');
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');
    }

    public function delete(Request $request){

        $id = $request->deleteId;

        $product = TbProduct::where('pro_brand',$id)->count();

        if($product == 0){
            $check = TbBrand::findOrFail($request->deleteId);
            if(!empty($check)){
                @unlink(Storage::disk('public')->path('brand/') . $check->brand_img);
            }
            TbBrand::where('id', $request->deleteId)->delete();
            return back()->with('feedback', 'ลบข้อมูลเรียบร้อยแล้ว!');
        }else{
            return back()->with(['feedback-er' =>'ไม่สามารถลบข้อมูลได้!','text-er'=>'เนื่องจากในข้อมูลสินค้ามีการใช้งานอยู่']);
        }

        

    }

    public function deleteImg(Request $request){

        $check = TbBrand::findOrfail($request->deleteId);
        if (!empty($check->brand_img)) {
            @unlink(Storage::disk('public')->path('brand/').$check->brand_img);
        }

        $data = TbBrand::findOrfail($request->deleteId);
        $data->brand_img              = null;
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function jsondata()
    {

        $data = TbBrand::get();

        return Datatables::of($data)
                ->addColumn('brand_img', function ($data) {
                    if(!empty($data->brand_img)){
                        if(!empty($data->brand_permalink)){
                            return '<a href="'.$data->brand_permalink.'"><img src="'.asset('storage/brand/'.$data->brand_img).'" alt="" class="table-width text-align-center" rel="nofollow"></a>';
                        }else{
                            return '<img src="'.asset('storage/brand/'.$data->brand_img).'" alt="" class="table-width text-align-center" rel="nofollow">';
                        }
                    }else{
                        return '<img src="'.asset('images/default-img/default-brand_2048_587.jpg').'" alt="..." class="table-width text-align-center" rel="nofollow">';
                    }
                })
                ->addColumn('brand_name', function ($data) {
                    return $data->brand_name;
                })
                ->addColumn('brand_recommend', function ($data) {
                    return $data->brand_recommend;
                })
                ->addColumn('brand_show', function ($data) {
                    return $data->brand_show;
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
                        $status = $data->brand_show;
                        $name = $data->brand_name;
                        return view('admin.brand.button', compact('id','status','name'));
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
