<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Providers\RouteServiceProvider;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

use App\Exports\ProductExport;
use App\Imports\ProductImport;
use App\Rules\checkCodition;

use App\Models\UsersLevel;
use App\Models\TbBrand;
use App\Models\TbCategory;
use App\Models\TbCategorySub;
use App\Models\TbProduct;
use App\Models\TbProductType;
use App\Models\TbProductStatus;
use App\Models\TbProductDetail;
use App\Models\TbProductPicture;
use App\Models\TbProductCondition;
use App\Models\TbProductSpecification;
use App\Models\TbProductHistoryImportfile;
use App\Models\TbOrderDetail;
use App\Models\TbType;
use App\Models\User;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $breadcrumb = [
            ['name' => 'รายการสินค้า'],
        ];
        $title_page = 'รายการสินค้า';
		
		// check access brand
		$current_user = Auth::user();
		$access_brand_id = $current_user->access_brand_id;

        $categorys = TbCategory::where('category_show',1)->get();
        $statuss = TbProductStatus::where('stu_show',1)->get();
		if(!empty($access_brand_id)){
			if(strpos($access_brand_id, ',')){
				$access_brand_id = explode(',',trim($access_brand_id));
			}else{
				$access_brand_id = [$access_brand_id];
			}
			$count = TbProduct::whereIn('pro_brand',$access_brand_id)->count();
		}else{
			$count = TbProduct::count();
		}
        
        return view('admin.product.main', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'categorys' => $categorys,
            'statuss' => $statuss,
            'count' => number_format($count),
            'data' => '',
        ]);

    }

    public function add(){

        $breadcrumb = [
            ['name' => 'เพิ่มรายการสินค้า'],
        ];
        $title_page = 'เพิ่มรายการสินค้า';

        $brands = TbBrand::where('brand_show',1)->get();
        $types  = TbProductType::where('type_show',1)->get();
        $conditions  = TbProductCondition::where('condition_show',1)->get();
        $categorys = TbCategory::where('category_show',1)->get();
        $productMultiple = TbProduct::where('pro_show',1)->get();
        return view('admin.product.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'brands' => $brands,
            'types' => $types,
            'conditions' => $conditions,
            'categorys' => $categorys,
            'productMultiple' => $productMultiple,
            'data' => '',
            'tab' => 1,
        ]);

    }

    public function edit($tab,$id){

        $breadcrumb = [
            ['name' => 'อัพเดตรายการสินค้า'],
        ];
        $title_page = 'อัพเดตรายการสินค้า';

        $brands = TbBrand::where('brand_show',1)->get();
        $types  = TbProductType::where('type_show',1)->get();
        $conditions  = TbProductCondition::where('condition_show',1)->get();
        $categorys = TbCategory::where('category_show',1)->get();
        $data = TbProduct::findOrFail($id);
        $detail = TbProductDetail::where('proId',$id)->first();
        $pro_status = TbProductStatus::where('stu_show',1)->get();
        $productMultiple = TbProduct::where('pro_show',1)->get();

        if(!empty($data)){
            $coverThumb = TbProductPicture::where('proId',$data->id)->where('picture_status',1)->first();
            $pictureProduct = TbProductPicture::where('proId',$data->id)->where('picture_status',2)->get();
            $productType = $this->productTypeGet($data->id);
        }else{
            $coverThumb = '';
            $pictureProduct = '';
            $productType = '';
        }
        
        return view('admin.product.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'brands' => $brands,
            'types' => $types,
            'conditions' => $conditions,
            'categorys' => $categorys,
            'data' => $data,
            'coverThumb' => $coverThumb,
            'pictureProduct' => $pictureProduct,
            'detail' => $detail,
            'tab' => $tab,
            'id' => $id,
            'pro_status' => $pro_status,
            'productMultiple' => $productMultiple,
            'productType' => $productType,
        ]);

    }

    public function crate(Request $request){

        $request->validate(
            [
                'pro_name' => 'required|max:255|unique:tb_product',
                'pro_permalink' => 'required|max:255|unique:tb_product',
                'pro_catId' => 'required',
                'pro_codition' => new checkCodition(),
            ],
            [
                'pro_name.required' => 'กรุณากรอกข้อมูล',
                'pro_name.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'pro_name.unique' => 'มีข้อมูลสินค้านี้อยู่แล้ว! กรุณาตรวจสอบข้อมูล',
                'pro_permalink.required' => 'กรุณากรอกข้อมูล',
                'pro_permalink.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'pro_permalink.unique' => 'Parmalink นี้มีการใช้งานอยู่แล้ว กรุณาตรวจสอบข้อมูลอีกครั้ง',
                'pro_catId.required' => 'กรุณาเลือกข้อมูล',
            ]
        );

        if($request->pro_show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        if($request->pro_keyword != ''){
			$pro_keyword = implode(",", $request->pro_keyword);
		} else {
			$pro_keyword = '';
		}

        if($request->pro_codition != ''){
			$pro_codition = implode(",", $request->pro_codition);
		} else {
			$pro_codition = '';
		}

        if($request->pro_related != ''){
			$pro_related = implode(",", $request->pro_related);
		} else {
			$pro_related = '';
		}

        $data = new TbProduct;
        $data->pro_option               = $request->pro_option;
        $data->pro_name                 = $request->pro_name;
        $data->pro_permalink            = $this->rewrite_url($request->pro_permalink);
        $data->pro_keyword              = $pro_keyword;
        $data->pro_seo_detail           = $request->pro_seo_detail;
        $data->pro_related              = $pro_related;
        $data->pro_brand                = $request->pro_brand;
        $data->pro_type                 = $request->pro_type;
        $data->pro_catId                = $request->pro_catId;
        $data->pro_catsubId             = $request->pro_catsubId;
        $data->pro_free_trial           = $request->pro_free_trial;
        $data->pro_release_notes        = $request->pro_release_notes;
        $data->pro_show                 = $show;
        $data->pro_codition             = $pro_codition;
        $data->created_by               = Auth::user()->displayname;
        $data->updated_by               = Auth::user()->displayname;
        $data->created_at               = date('Y-m-d H:i:s');
        $data->updated_at               = date('Y-m-d H:i:s');

        if (!empty($request->pro_download)) {

            if ($request->hasFile('pro_download')) {
                @unlink(Storage::disk('public')->path('product_dowloads/') . $request->pro_download_old);

                $newFilename = uniqid() . '.' . $request->pro_download->extension();
                $data->pro_download = $newFilename;
                $file = $request->file('pro_download');
                $file->move('storage/product_dowloads/', $newFilename);
            }

        }

        $data->save();

        if (!empty($request->pro_thumb)) {

            $checkThumb = TbProductPicture::where('proId',$data->id)->where('picture_status',1)->first();
            if(!empty($checkThumb)){

                $thumb = TbProductPicture::findOrFail($checkThumb->id);
                if ($request->hasFile('pro_thumb')) {
                    @unlink(Storage::disk('public')->path('product') . $request->pro_thumb_old);
    
                    $newFilename = uniqid() . '.' . $request->pro_thumb->extension();
                    $thumb->picture_name = $newFilename;
                    $file = $request->file('pro_thumb');
                    $file->move('storage/product/', $newFilename);
                }
                $thumb->save();

            }else{

                $thumb = new TbProductPicture;
                $thumb->proId               = $data->id;
                $thumb->picture_status      = 1;
                if ($request->hasFile('pro_thumb')) {
                    $newFilename = uniqid() . '.' . $request->pro_thumb->extension();
                    $thumb->picture_name = $newFilename;
                    $file = $request->file('pro_thumb');
                    $file->move('storage/product/', $newFilename);
                }
                $thumb->save();
                
            }
            

        }


        return redirect()->route('product.edit',['tab'=>1,'id'=>$data->id])->with('feedback', 'เพิ่มข้อมูลเรียบร้อยแล้ว!');

    }

    public function crateSpec(Request $request){

        $request->validate(
            [
                'spec_name' => 'required|max:255',
            ],
            [
                'spec_name.required' => 'กรุณากรอกข้อมูล',
                'spec_name.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
            ]
        );

        $data = new TbProductSpecification;
        $data->spec_name                = $request->spec_name;
        $data->spec_detail              = $request->spec_detail;
        $data->proId                    = $request->spec_proId;
        $data->created_by               = Auth::user()->displayname;
        $data->updated_by               = Auth::user()->displayname;
        $data->created_at               = date('Y-m-d H:i:s');
        $data->updated_at               = date('Y-m-d H:i:s');
        $data->save();

        return redirect()->route('product.edit',['tab'=>3,'id'=>$request->spec_proId])->with('feedback', 'เพิ่มข้อมูลเรียบร้อยแล้ว!');

    }

    public function crateProductimg(Request $request){

        $request->validate([
            'pro_thumb' => 'required',
        ],
        [
            'pro_thumb.required' => 'กรุณาเลือกไฟล์รูปภาพสำหรับอัพโหลด',
        ]);

        $files = $request->file('pro_thumb');

        foreach ($files as $proImg) {

            // add table 8b_product
            $data                    = new TbProductPicture();
            $data->picture_status    = 2;
            $data->proId             = $request->proId;
            $data->created_by        = Auth::user()->name;
            $data->created_at        = date('Y-m-d H:i:s');
            $data->updated_by        = Auth::user()->name;
            $data->updated_at        = date('Y-m-d H:i:s');

            $newFilename = uniqid() . '.' . $proImg->extension();
            $data->picture_name      = $newFilename;
            $file = $proImg;
            $file->move('storage/product/',$newFilename);

            $data->save();
        }

        return redirect()->route('product.edit',['tab'=>5,'id'=>$request->proId])->with('feedback', 'เพิ่มข้อมูลเรียบร้อยแล้ว!');

    }

    public function update(Request $request,$id){

        $request->validate(
            [
                'pro_name' => 'required|max:255|unique:tb_product,pro_name,'.$id,
                'pro_permalink' => 'required|max:255|unique:tb_product,pro_permalink,'.$id,
                'pro_catId' => 'required',
                'pro_codition' => new checkCodition(),
            ],
            [
                'pro_name.required' => 'กรุณากรอกข้อมูล',
                'pro_name.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'pro_name.unique' => 'มีข้อมูลสินค้านี้อยู่แล้ว! กรุณาตรวจสอบข้อมูล',
                'pro_permalink.required' => 'กรุณากรอกข้อมูล',
                'pro_permalink.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'pro_permalink.unique' => 'Parmalink นี้มีการใช้งานอยู่แล้ว กรุณาตรวจสอบข้อมูลอีกครั้ง',
                'pro_catId.required' => 'กรุณาเลือกข้อมูล',
            ]
        );

        if($request->pro_show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        if($request->pro_keyword != ''){
			$pro_keyword = implode(",", $request->pro_keyword);
		} else {
			$pro_keyword = '';
		}

        if($request->pro_codition != ''){
			$pro_codition = implode(",", $request->pro_codition);
		} else {
			$pro_codition = '';
		}

        if($request->pro_related != ''){
			$pro_related = implode(",", $request->pro_related);
		} else {
			$pro_related = '';
		}

        $data = TbProduct::findOrFail($id);
        $data->pro_option               = $request->pro_option;
        $data->pro_name                 = $request->pro_name;
        $data->pro_permalink            = $this->rewrite_url($request->pro_permalink);
        $data->pro_keyword              = $pro_keyword;
        $data->pro_seo_detail           = $request->pro_seo_detail;
        $data->pro_related              = $pro_related;
        $data->pro_brand                = $request->pro_brand;
        $data->pro_type                 = $request->pro_type;
        $data->pro_catId                = $request->pro_catId;
        $data->pro_catsubId             = $request->pro_catsubId;
        $data->pro_free_trial           = $request->pro_free_trial;
        $data->pro_release_notes        = $request->pro_release_notes;
        $data->pro_show                 = $show;
        $data->pro_codition             = $pro_codition;
        $data->updated_by               = Auth::user()->displayname;
        $data->updated_at               = date('Y-m-d H:i:s');

        if (!empty($request->pro_download)) {

            if ($request->hasFile('pro_download')) {
                @unlink(Storage::disk('public')->path('product_dowloads/') . $request->pro_download_old);

                $newFilename = uniqid() . '.' . $request->pro_download->extension();
                $data->pro_download = $newFilename;
                $file = $request->file('pro_download');
                $file->move('storage/product_dowloads/', $newFilename);
            }

        }
        if (!empty($request->pro_installer)) {

            if ($request->hasFile('pro_installer')) {
                if (!empty($data->pro_installer)) {
                    @unlink(Storage::disk('public')->path('product_dowloads/') . $data->pro_installer);
                }

                $newFilename = uniqid() . '.' . $request->pro_installer->extension();
                $data->pro_installer = $newFilename;
                $file = $request->file('pro_installer');
                $file->move('storage/product_dowloads/', $newFilename);
            }

        }

        if (!empty($request->pro_activation_guide)) {

            if ($request->hasFile('pro_activation_guide')) {
                if (!empty($data->pro_activation_guide)) {
                    @unlink(Storage::disk('public')->path('product_dowloads/') . $data->pro_activation_guide);
                }

                $newFilename = uniqid() . '.' . $request->pro_activation_guide->extension();
                $data->pro_activation_guide = $newFilename;
                $file = $request->file('pro_activation_guide');
                $file->move('storage/product_dowloads/', $newFilename);
            }

        }

        $data->save();

        if (!empty($request->pro_thumb)) {

            $checkThumb = TbProductPicture::where('proId',$data->id)->where('picture_status',1)->first();
            if(!empty($checkThumb)){

                $thumb = TbProductPicture::findOrFail($checkThumb->id);
                if ($request->hasFile('pro_thumb')) {
                    @unlink(Storage::disk('public')->path('product') . $request->pro_thumb_old);
    
                    $newFilename = uniqid() . '.' . $request->pro_thumb->extension();
                    $thumb->picture_name = $newFilename;
                    $file = $request->file('pro_thumb');
                    $file->move('storage/product/', $newFilename);
                }
                $thumb->save();

            }else{

                $thumb = new TbProductPicture;
                $thumb->proId               = $data->id;
                $thumb->picture_status      = 1;
                if ($request->hasFile('pro_thumb')) {
                    $newFilename = uniqid() . '.' . $request->pro_thumb->extension();
                    $thumb->picture_name = $newFilename;
                    $file = $request->file('pro_thumb');
                    $file->move('storage/product/', $newFilename);
                }
                $thumb->save();
                
            }
            

        }

        return redirect()->route('product.edit',['tab'=>1,'id'=>$data->id])->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function updateContent(Request $request,$id){

        $data = TbProduct::findOrFail($id);
        $data->pro_highlight            = $request->pro_highlight;
        $data->pro_content              = $request->pro_content;
        $data->pro_feature              = $request->pro_feature;
        $data->pro_gift                 = $request->pro_gift;
        $data->updated_by               = Auth::user()->displayname;
        $data->updated_at               = date('Y-m-d H:i:s');
        $data->save();

        return redirect()->route('product.edit',['tab'=>2,'id'=>$data->id])->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }
    
    public function status($id){

        $data = TbProduct::findOrFail($id);

        if($data->pro_show == 2){
            $status = 1;
        }elseif($data->pro_show == 1) {
            $status = 2;
        }

        $data->pro_show                     = $status;
        $data->updated_by                   = Auth::user()->displayname;
        $data->updated_at                   = date('Y-m-d H:i:s');
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');
    }

    public function delete(Request $request){

        $checkThumb = TbProductPicture::where('proId',$request->deleteId)->get();

        foreach($checkThumb as $thumb){
            @unlink(Storage::disk('public')->path('product') . $thumb->picture_name);
        }

        TbProduct::where('id', $request->deleteId)->delete();

        return back()->with('feedback', 'ลบข้อมูลเรียบร้อยแล้ว!');

    }

    public function deleteImg(Request $request){

        $checkThumb = TbProductPicture::findOrFail($request->deleteId);

        if ($request->hasFile('pro_thumb')) {
            @unlink(Storage::disk('public')->path('product') . $checkThumb->picture_name);
        }

        TbProductPicture::where('id', $request->deleteId)->delete();

        return back()->with('feedback', 'ลบข้อมูลเรียบร้อยแล้ว!');

    }

    public function deleteSpec(Request $request){

        TbProductSpecification::where('id', $request->deleteId)->delete();
        return back()->with('feedback', 'ลบข้อมูลเรียบร้อยแล้ว!');

    }

    public function deleteSpecAll(Request $request){

        TbProductSpecification::where('proId', $request->deleteId3)->delete();
        return back()->with('feedback', 'ลบข้อมูลเรียบร้อยแล้ว!');

    }

    public function deleteFile(Request $request){

        $check = TbProduct::where('id',$request->deleteId2)->first();
        if (!empty($check->pro_download)) {
            @unlink(Storage::disk('public')->path('product_dowloads/').$check->pro_download);
        }

        $data = TbProduct::where('id',$request->deleteId2)->first();
        $data->pro_download              = null;
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function jsondata(Request $request)
	{
		$category       = $request->get('category');
		$subcategory    = $request->get('subcategory');
		$searchSKU      = $request->get('searchSKU');
		$draw           = $request->get('draw');
		$start          = $request->get('start');
		$length         = $request->get('length');
		$search         = $request->get('search');
		$order          = $request->get('order');

		$columnorder = array(
			'checkbox',
			'img',
			'sku',
			'name',
			'price',
			'show',
			'updated',
			'actions',
		);

		if (empty($order)) {
			$sort = 'created_at';
			$dir = 'desc';
		} else {
			$sort = $columnorder[$order[0]['column']] ?? 'created_at';
			$dir = $order[0]['dir'] ?? 'desc';
		}

		// กัน sort ด้วยคอลัมน์คำนวณ
		if (in_array($sort, ['checkbox', 'img', 'sku', 'name', 'price', 'show', 'updated', 'actions'])) {
			$sort = 'created_at';
			$dir = 'desc';
		}

		$current_user = Auth::user();
		$access_brand_id = $current_user->access_brand_id;

		if (!empty($access_brand_id)) {
			if (strpos($access_brand_id, ',')) {
				$access_brand_id = explode(',', trim($access_brand_id));
			} else {
				$access_brand_id = [$access_brand_id];
			}
		}

		if (!empty($searchSKU)) {
			$baseQuery = TbProductDetail::select(
				'tb_product_detail.proId',
				'tb_product_detail.detail_sku',
				'tb_product.id',
				'tb_product.pro_name',
				'tb_product.pro_catId',
				'tb_product.pro_catsubId',
				'tb_product.pro_option',
				'tb_product.pro_permalink',
				'tb_product.pro_show',
				'tb_product.created_at',
				'tb_product.created_by'
			)
			->leftJoin('tb_product', 'tb_product.id', '=', 'tb_product_detail.proId')
			->when(!empty($access_brand_id), function ($query) use ($access_brand_id) {
				return $query->whereIn('tb_product.pro_brand', $access_brand_id);
			})
			->when($search, function ($query, $search) {
				return $query->where(function ($query) use ($search) {
					$query->where('tb_product.pro_name', 'LIKE', '%' . $search . '%');
				});
			})
			->when($searchSKU, function ($query, $searchSKU) {
				return $query->where(function ($query) use ($searchSKU) {
					$query->where('tb_product_detail.detail_sku', 'LIKE', '%' . $searchSKU . '%');
				});
			})
			->when($category, function ($query, $category) {
				if (!empty($category)) {
					return $query->where('tb_product.pro_catId', $category);
				}
			})
			->when($subcategory, function ($query, $subcategory) {
				if (!empty($subcategory)) {
					return $query->where('tb_product.pro_catsubId', $subcategory);
				}
			});

			$data = (clone $baseQuery)
				->groupBy(
					'tb_product_detail.proId',
					'tb_product_detail.detail_sku',
					'tb_product.id',
					'tb_product.pro_name',
					'tb_product.pro_catId',
					'tb_product.pro_catsubId',
					'tb_product.pro_option',
					'tb_product.pro_permalink',
					'tb_product.pro_show',
					'tb_product.created_at',
					'tb_product.created_by'
				)
				->orderBy('tb_product.created_at', 'desc')
				->get();

			$recordsTotal = (clone $baseQuery)
				->distinct('tb_product.id')
				->count('tb_product.id');

			$recordsFiltered = (clone $baseQuery)
				->distinct('tb_product.id')
				->count('tb_product.id');

		} else {
			$baseQuery = TbProduct::select(
				'tb_product.id',
				'tb_product.pro_name',
				'tb_product.pro_catId',
				'tb_product.pro_catsubId',
				'tb_product.pro_option',
				'tb_product.pro_permalink',
				'tb_product.pro_show',
				'tb_product.created_at',
				'tb_product.created_by'
			)
			->when(!empty($access_brand_id), function ($query) use ($access_brand_id) {
				return $query->whereIn('tb_product.pro_brand', $access_brand_id);
			})
			->when($search, function ($query, $search) {
				return $query->where(function ($query) use ($search) {
					$query->where('tb_product.pro_name', 'LIKE', '%' . $search . '%');
				});
			})
			->when($category, function ($query, $category) {
				if (!empty($category)) {
					return $query->where('tb_product.pro_catId', $category);
				}
			})
			->when($subcategory, function ($query, $subcategory) {
				if (!empty($subcategory)) {
					return $query->where('tb_product.pro_catsubId', $subcategory);
				}
			});

			$data = (clone $baseQuery)
				->orderBy('tb_product.created_at', 'desc')
				->get();

			$recordsTotal = (clone $baseQuery)->count();
			$recordsFiltered = (clone $baseQuery)->count();
		}

		return Datatables::of($data)
			->addColumn('checkbox', function ($data) {
				if ((int)$data->pro_show !== 1) {
					return '';
				}

				return '<input type="checkbox" class="row-checkbox" value="' . $data->id . '" data-id="' . $data->id . '">';
			})
			->addColumn('img', function ($data) {
				$productPicture = TbProductPicture::where('proId', $data->id)
					->where('picture_status', 1)
					->first();

				if (!empty($productPicture)) {
					$image = "<img style='width: 50px;' src='" . asset('storage/product/' . $productPicture->picture_name) . "' alt='...' class='full-width' rel='nofollow'>";
				} else {
					$image = "<img style='width: 50px;' src='" . asset('images/default-img/no-img.jpg') . "' alt='...' class='full-width' rel='nofollow'>";
				}
				return $image;
			})
			->addColumn('sku', function ($data) {
				if ($data->pro_option == 1) {
					return TbProductDetail::select('detail_sku', 'proId')
						->where('proId', $data->id)
						->value('detail_sku');
				} else {
					return '-';
				}
			})
			->addColumn('name', function ($data) {
				return '<a href="' . route('fronend.product.content', $data->pro_permalink) . '" target="_bank">' . $data->pro_name . '</a>';
			})
			->addColumn('price', function ($data) {
				return $this->checkPrice($data->pro_option, $data->id) . '.-';
			})
			->addColumn('show', function ($data) {
				return $data->pro_show;
			})
			->addColumn('updated', function ($data) {
				return $data->created_at . '<br/><small><i class="fa fa-user"></i> ' . $data->created_by . '</small>';
			})
			->addColumn('actions', function ($data) {
				$UserLevel = UsersLevel::where('UserId', Auth::user()->id)->first();

				if ($UserLevel->l_product_Action == 2) {
					return '<small class="text-danger">ไม่มีสิทธิ์เข้าถึง</small>';
				} else {
					$id = $data->id;
					$name = $data->pro_name;
					$status = $data->pro_show;
					return view('admin.product.button', compact('id', 'name', 'status'));
				}
			})
			->setTotalRecords($recordsTotal)
			->setFilteredRecords($recordsFiltered)
			->escapeColumns([])
			->make(true);
	}

    public function jsondata_old(Request $request)
    {

        $category = $request->get('category');
        $subcategory = $request->get('subcategory');

        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->get('search');
        $order = $request->get('order');

        $columnorder = array(
            'id',
            'pro_img',
            'pro_name',
            'pro_stu_id',
            'pro_status',
        );

        if (empty($order)) {
            $sort = 'created_at';
            $dir = 'desc';
        } else {
            $sort = $columnorder[$order[0]['column']];
            $dir = $order[0]['dir'];
        }

        $data = TbProduct::select(
            'id','pro_name','pro_catId','pro_catsubId','pro_permalink','pro_option','pro_show','created_at','created_by'
         )
        ->when($search, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->orWhere('pro_name', 'LIKE', '%' . $search . '%');
            });
        })
        ->when($category, function ($query, $category) {
            if(!empty($category)){
                return $query->where('pro_catId',$category);
            }
        })
        ->when($subcategory, function ($query, $subcategory) {
            if(!empty($subcategory)){
                return $query->where('pro_catsubId',$subcategory);
            }
        })
        ->when($search, function ($query, $search) {

            return TbProduct::select(
                'tb_product.id','tb_product.pro_name','tb_product.pro_catId','tb_product.pro_show',
                'tb_product.pro_catsubId','tb_product.pro_permalink','tb_product.pro_option','tb_product.created_at','tb_product.created_by',
                'tb_product_detail.proId','tb_product_detail.detail_sku',
            )
            ->leftjoin('tb_product_detail','tb_product_detail.proId','tb_product.id')
            ->orWhere('tb_product_detail.detail_sku', 'LIKE', '%' . $search . '%')
            ->orderBy('tb_product.created_at','desc');

        })
        ->orderBy('created_at','desc')
        ->offset($start)
        ->limit($length)
        ->get();

        $recordsTotal = TbProduct::select(
            'id','pro_name','pro_catId','pro_catsubId','pro_permalink','pro_option','pro_show','created_at','created_by'
         )
        ->when($search, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->orWhere('pro_name', 'LIKE', '%' . $search . '%');
            });
        })
        ->when($category, function ($query, $category) {
            if(!empty($category)){
                return $query->where('pro_catId',$category);
            }
        })
        ->when($subcategory, function ($query, $subcategory) {
            if(!empty($subcategory)){
                return $query->where('pro_catsubId',$subcategory);
            }
        })
        ->when($search, function ($query, $search) {

            return TbProduct::select(
                'tb_product.id','tb_product.pro_name','tb_product.pro_catId','tb_product.pro_show',
                'tb_product.pro_catsubId','tb_product.pro_permalink','tb_product.pro_option','tb_product.created_at','tb_product.created_by',
                'tb_product_detail.proId','tb_product_detail.detail_sku',
            )
            ->leftjoin('tb_product_detail','tb_product_detail.proId','tb_product.id')
            ->orWhere('tb_product_detail.detail_sku', 'LIKE', '%' . $search . '%')
            ->orderBy('tb_product.created_at','desc');

        })
        ->orderBy('created_at','desc')
        ->count();

        $recordsFiltered = TbProduct::select(
            'id','pro_name','pro_catId','pro_catsubId','pro_permalink','pro_option','pro_show','created_at','created_by'
         )
        ->when($search, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->orWhere('pro_name', 'LIKE', '%' . $search . '%');
            });
        })
        ->when($category, function ($query, $category) {
            if(!empty($category)){
                return $query->where('pro_catId',$category);
            }
        })
        ->when($subcategory, function ($query, $subcategory) {
            if(!empty($subcategory)){
                return $query->where('pro_catsubId',$subcategory);
            }
        })
        ->when($search, function ($query, $search) {

            return TbProduct::select(
                'tb_product.id','tb_product.pro_name','tb_product.pro_catId','tb_product.pro_show',
                'tb_product.pro_catsubId','tb_product.pro_permalink','tb_product.pro_option','tb_product.created_at','tb_product.created_by',
                'tb_product_detail.proId','tb_product_detail.detail_sku',
            )
            ->leftjoin('tb_product_detail','tb_product_detail.proId','tb_product.id')
            ->orWhere('tb_product_detail.detail_sku', 'LIKE', '%' . $search . '%')
            ->orderBy('tb_product.created_at','desc');

        })
        ->orderBy('created_at','desc')
        ->count();

        return Datatables::of($data)
        ->addColumn('img', function ($data) {

            $productPicture = TbProductPicture::where('proId',$data->id)->where('picture_status',1)->first();
            if(!empty($productPicture)){
                $image = "<img style='width: 50px;' src='".asset('storage/product/'.$productPicture->picture_name)."' alt='...' class='full-width' rel='nofollow'>";
            }else{
                $image = "<img style='width: 50px;' src='".asset('images/default-img/no-img.jpg')."' alt='...' class='full-width' rel='nofollow'>";
            }
            return $image;
        })
        ->addColumn('sku', function ($data) {
            if($data->pro_option == 1){
                return TbProductDetail::select('detail_sku','proId')->where('proId',$data->id)->value('detail_sku');
            }else{
                return '-';
            }
        })
        ->addColumn('name', function ($data) {
            return '<a href="'.route('fronend.product.content',$data->pro_permalink).'" target="_bank">'.$data->pro_name.'</a>';
        })
        ->addColumn('type', function ($data) {
            if($data->pro_option == 1){
                return '<span class="badge badge-default">สินค้ารูปแบบเดียว</span>';
            }else{
                return '<span class="badge badge-default">สินค้าหลายรูปแบบ</span>';
            }
        })
        ->addColumn('price', function ($data) {
            return $this->checkPrice($data->pro_option,$data->id).'.-';
        })
        ->addColumn('show', function ($data) {
            return $data->pro_show;
        })
        ->addColumn('updated', function ($data) {
            return $data->created_at.'<br/><small><i class="fa fa-user"></i> '.$data->created_by.'</small>';
        })
        ->addColumn('actions', function ($data) {

            $UserLevel = UsersLevel::where('UserId',Auth::user()->id)->first();
            if($UserLevel->l_product_Action == 2){
                return '<small class="text-danger">ไม่มีสิทธิ์เข้าถึง</small>';
            }else{
                $id = $data->id;
                $name = $data->pro_name;
                $status = $data->pro_show;
                return view('admin.product.button', compact('id','name','status'));
            }
        })
        ->setTotalRecords($recordsTotal)
        ->setFilteredRecords($recordsFiltered)
        ->escapeColumns([])
        ->addIndexColumn()
        ->make(true);
    }

    public function jsonSpec($id)
    {

        $data = TbProductSpecification::where('proId',$id)->get();

        return Datatables::of($data)
                ->addColumn('name', function ($data) {
                    return $data->spec_name;
                })
                ->addColumn('detail', function ($data) {
                    return $data->spec_detail;
                })
                ->addColumn('actions', function ($data) {
                    $id = $data->id;
                    $name = $data->spec_name;
                    return view('admin.product.buttonSpec', compact('id','name'));
                })
                ->escapeColumns([])
                ->addIndexColumn()
                ->make(true);
    }

    public function jsonCatsub(Request $request){

        $categoryId = $request->categoryId;

        if (!empty($categoryId)) {
            $response = TbCategorySub::where('category_id',$categoryId)->get();
            if (!empty($response)) {
                return response()->json($response);
            } else {
                return 'false';
            }
        } else {
            return 'false';
        }

    }

    public function jsonGetpro(Request $request){

        $response = TbProduct::where('pro_show',1)->get();
        if (!empty($response)) {
            return response()->json($response);
        } else {
            return 'false';
        }

    }

    public function jsonStatus(Request $request)
    {

        $response = TbProductStatus::where('id',$request->id)->where('stu_show',1)->get();

        if (!empty($response)) {
            return response()->json($response);
        } else {
            return 'false';
        }
    }

    public function export(Request $request)
	{
		$category = $request->category;
		$subcategory = $request->subcategory;
		$search = $request->search;
		$searchSKU = $request->searchSKU;
		$mode = $request->mode; // selected | all_filtered
		$exportType = $request->export_type ?? 'all'; // promotion | main | all

		$selectedIds = collect($request->selected_ids ?? [])
			->filter(function ($id) {
				return !empty($id);
			})
			->map(function ($id) {
				return (int)$id;
			})
			->unique()
			->values()
			->all();

		$excludedIds = collect($request->excluded_ids ?? [])
			->filter(function ($id) {
				return !empty($id);
			})
			->map(function ($id) {
				return (int)$id;
			})
			->unique()
			->values()
			->all();

		$current_user = Auth::user();
		$access_brand_id = $current_user->access_brand_id;

		if (!empty($access_brand_id)) {
			if (strpos($access_brand_id, ',') !== false) {
				$access_brand_id = explode(',', trim($access_brand_id));
			} else {
				$access_brand_id = [$access_brand_id];
			}
		} else {
			$access_brand_id = [];
		}

		if ($mode === 'all_filtered') {
			$filename = match ($exportType) {
				'promotion' => 'product_promotion_filtered_' . date('Y-m-d_H-i-s') . '.xlsx',
				'main' => 'product_main_filtered_' . date('Y-m-d_H-i-s') . '.xlsx',
				default => 'product_all_filtered_' . date('Y-m-d_H-i-s') . '.xlsx',
			};

			return Excel::download(
				new ProductExport(
					$category,
					$subcategory,
					$search,
					$searchSKU,
					[],
					$excludedIds,
					'all_filtered',
					$access_brand_id,
					$exportType
				),
				$filename
			);
		}

		if (count($selectedIds) === 0) {
			return back()->withErrors(['export' => 'กรุณาเลือกรายการสินค้าก่อน Export']);
		}

		$validQuery = TbProduct::whereIn('id', $selectedIds)
			->where('pro_show', 1);

		if (!empty($access_brand_id)) {
			$validQuery->whereIn('pro_brand', $access_brand_id);
		}

		$validIds = $validQuery->pluck('id')
			->map(function ($id) {
				return (int)$id;
			})
			->all();

		if (count($validIds) === 0) {
			return back()->withErrors(['export' => 'ไม่พบรายการสินค้าที่เปิดใช้งานสำหรับ Export']);
		}

		$filename = match ($exportType) {
			'promotion' => 'product_promotion_selected_' . date('Y-m-d_H-i-s') . '.xlsx',
			'main' => 'product_main_selected_' . date('Y-m-d_H-i-s') . '.xlsx',
			default => 'product_all_selected_' . date('Y-m-d_H-i-s') . '.xlsx',
		};

		return Excel::download(
			new ProductExport(
				$category,
				$subcategory,
				$search,
				$searchSKU,
				$validIds,
				[],
				'selected',
				$access_brand_id,
				$exportType
			),
			$filename
		);
	}

    public function import(Request $request){

        $request->validate([
            'import' => 'required',
        ],
        [
            'import.required' => 'กรุณาเลือกไฟล์สำหรับอัพโหลด .xls, .xlsx, .csv',
        ]);

        //set namefile
        $newFilename = uniqid() . '.' . $request->import->extension();

        //set forder of the year
        $year = date('Y');
        $mount = date('M');
        Storage::makeDirectory('storage/importProdust/'.$year.'/'.$mount, 0775, true);

        //add file to db
        $importData                   = new TbProductHistoryImportfile;
        $importData->Message          = 'อัพโหลดไฟล์ไม่สำเร็จ';
        $importData->Month            = $mount;
        $importData->Year             = $year;
        $importData->note             = $request->import_note;
        $importData->created_by       = Auth::user()->displayname;
        $importData->created_at       = date('Y-m-d H:i:s');
        if ($request->hasFile('import')) {
            $file = $request->file('import');
            $importData->file_name  = $newFilename;
            $file->move('storage/importProdust/'.$year.'/'.$mount, $newFilename);
        }
        $importData->save();

        $importuploadFile = new ProductImport();
        Excel::import($importuploadFile,'storage/importProdust/'.$year.'/'.$mount.'/'.$newFilename);

        $rows = $importuploadFile->getRowCount();
        if($rows != 0){
            $importStatus           = TbProductHistoryImportfile::findOrFail($importData->id);;
            $importStatus->Message  = 'อัพโหลดไฟล์สำเร็จ';
            $importStatus->save();
        }

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    private function checkPrice($pro_option,$proId){

        $detailMin = TbProductDetail::select('proId','detail_price')->where('proId',$proId)->orderBy('detail_price','desc')->value('detail_price');
        $detailMax = TbProductDetail::select('proId','detail_price')->where('proId',$proId)->orderBy('detail_price','ASC')->value('detail_price');

        if($pro_option == 2){
            if(!empty($detailMin) && !empty($detailMax)){

                if($detailMin != $detailMax){

                    if($detailMin < $detailMax){
                        return '฿ '.number_format($detailMin).' - '.number_format($detailMax);
                    }else{
                        return '฿ '.number_format($detailMax).' - '.number_format($detailMin);
                    }

                }else{
                    return '฿ '.number_format($detailMin,2);
                }
            }
        }else{

            $detailPrice = TbProductDetail::select('proId','detail_price')->where('proId',$proId)->orderBy('detail_price','desc')->value('detail_price');
            if(!empty($detailPrice)){
                return '฿ '.number_format($detailMin,2);
            }else{
                return '฿ 0';
            }
        }
    }

    private function rewrite_url($url){
        $str_replace = strtolower(str_replace(" ","-",$url));
        $data = preg_replace('/[^a-z0-9\_\- ]/i', '', $str_replace);
        return $data ;
    }

    private function productTypeGet($proId){

        $data = TbProduct::select('tb_product.id','tb_product.pro_catId','tb_category.id','tb_category.category_display_status')
        ->leftjoin('tb_category','tb_category.id','tb_product.pro_catId')
        ->where('tb_product.id',$proId)
        ->value('tb_category.category_display_status');

        return $data;

    }

    public function report(){
        $breadcrumb = [
            ['name' => 'รายงานสินค้า'],
        ];
        $title_page = 'รายงานสินค้า';

        $count = TbProduct::count(); 
        $category = TbCategory::count();
        $product = TbProduct::count();
        $brand = TbBrand::count();
        $subcategory = TbCategorySub::count();
        $month = date('m');

        return view('admin.product.report.dashboard', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'count' => number_format($count),
            'data' => '',
            'month' => $month,
            'subcategory' => $subcategory,
            'category' => $category,
            'product' => $product,
            'brand' => $brand,
        ]);
    }

    public function jsonType(){

        $result = TbType::select('id','type_name','type_show')->where('type_show', 1)->get();
        if (!empty($result)) {

            foreach($result as $item){

                $countItem = TbProduct::leftJoin('tb_category', 'tb_category.id', 'tb_product.pro_catId')
                ->where('tb_category.category_type', $item->id)
                ->count();

                $response[] = array(
                    'name'=>$item->type_name,
                    'value'=>$countItem,
                );
            }
            return $response;


        } else {
            return 'false';
        }

    }

    public function jsonBestseller(Request $request)
    {

        $month = $request->get('month');
        $year = $request->get('year');

        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->get('search');
        $order = $request->get('order');

        $columnorder = array(
            'id',
            'sku',
            'name',
            'total',
        );

        if (empty($order)) {
            $sort = 'created_at';
            $dir = 'desc';
        } else {
            $sort = $columnorder[$order[0]['column']];
            $dir = $order[0]['dir'];
        }
		
		// check access brand
		$current_user = Auth::user();
		$access_brand_id = $current_user->access_brand_id;
		
		if(!empty($access_brand_id)){
			
			if(strpos($access_brand_id, ',')){
				$access_brand_id = explode(',',trim($access_brand_id));
			}else{
				$access_brand_id = [$access_brand_id];
			}
			
			$product = TbOrderDetail::select(
				DB::raw('SUM(tb_order_detail.product_price) as Total', 'tb_order_detail.product_price'),
				'tb_order_detail.product_sku','tb_order_detail.product_name','tb_order_detail.product_detail',
				'tb_order_detail.orderId','tb_order_detail.created_at',
				'tb_order.id','tb_order.payment_status',
				'tb_setting_payment_status.id',
			)
			->leftjoin('tb_order','tb_order.id','tb_order_detail.orderId')
			->leftjoin('tb_setting_payment_status','tb_setting_payment_status.id','tb_order.payment_status')
			->leftjoin('tb_product_detail','tb_order_detail.product_sku','tb_product_detail.detail_sku')
			->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
			->whereIn('tb_product.pro_brand',$access_brand_id)
			->where('tb_setting_payment_status.status_value',1)
			->groupBy('tb_order_detail.product_sku')
			->when($month, function ($query, $month) {
				if(!empty($month)){
					return $query->whereMonth('tb_order_detail.created_at',$month);
				}
			})
			->when($year, function ($query, $year) {
				if(!empty($year)){
					return $query->whereYear('tb_order_detail.created_at',$year);
				}
			})
			->orderBy('Total','desc')
			->limit($length)
			->get();

			$recordsTotal = TbOrderDetail::select(
				DB::raw('SUM(tb_order_detail.product_price) as Total', 'tb_order_detail.product_price'),
				'tb_order_detail.product_sku','tb_order_detail.product_name','tb_order_detail.product_detail',
				'tb_order_detail.orderId','tb_order_detail.created_at',
				'tb_order.id','tb_order.payment_status',
				'tb_setting_payment_status.id',
			)
			->leftjoin('tb_order','tb_order.id','tb_order_detail.orderId')
			->leftjoin('tb_setting_payment_status','tb_setting_payment_status.id','tb_order.payment_status')
			->leftjoin('tb_product_detail','tb_order_detail.product_sku','tb_product_detail.detail_sku')
			->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
			->whereIn('tb_product.pro_brand',$access_brand_id)
			->where('tb_setting_payment_status.status_value',1)
			->groupBy('tb_order_detail.product_sku')
			->when($month, function ($query, $month) {
				if(!empty($month)){
					return $query->whereMonth('tb_order_detail.created_at',$month);
				}
			})
			->when($year, function ($query, $year) {
				if(!empty($year)){
					return $query->whereYear('tb_order_detail.created_at',$year);
				}
			})
			->count();

			$recordsFiltered = TbOrderDetail::select(
				DB::raw('SUM(tb_order_detail.product_price) as Total', 'tb_order_detail.product_price'),
				'tb_order_detail.product_sku','tb_order_detail.product_name','tb_order_detail.product_detail',
				'tb_order_detail.orderId','tb_order_detail.created_at',
				'tb_order.id','tb_order.payment_status',
				'tb_setting_payment_status.id',
			)
			->leftjoin('tb_order','tb_order.id','tb_order_detail.orderId')
			->leftjoin('tb_setting_payment_status','tb_setting_payment_status.id','tb_order.payment_status')
			->leftjoin('tb_product_detail','tb_order_detail.product_sku','tb_product_detail.detail_sku')
			->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
			->whereIn('tb_product.pro_brand',$access_brand_id)
			->where('tb_setting_payment_status.status_value',1)
			->groupBy('tb_order_detail.product_sku')
			->when($month, function ($query, $month) {
				if(!empty($month)){
					return $query->whereMonth('tb_order_detail.created_at',$month);
				}
			})
			->when($year, function ($query, $year) {
				if(!empty($year)){
					return $query->whereYear('tb_order_detail.created_at',$year);
				}
			})
			->count();
			
		}else{
			$product = TbOrderDetail::select(
				DB::raw('SUM(tb_order_detail.product_price) as Total', 'tb_order_detail.product_price'),
				'tb_order_detail.product_sku','tb_order_detail.product_name','tb_order_detail.product_detail',
				'tb_order_detail.orderId','tb_order_detail.created_at',
				'tb_order.id','tb_order.payment_status',
				'tb_setting_payment_status.id',
			)
			->leftjoin('tb_order','tb_order.id','tb_order_detail.orderId')
			->leftjoin('tb_setting_payment_status','tb_setting_payment_status.id','tb_order.payment_status')
			->where('tb_setting_payment_status.status_value',1)
			->groupBy('tb_order_detail.product_sku')
			->when($month, function ($query, $month) {
				if(!empty($month)){
					return $query->whereMonth('tb_order_detail.created_at',$month);
				}
			})
			->when($year, function ($query, $year) {
				if(!empty($year)){
					return $query->whereYear('tb_order_detail.created_at',$year);
				}
			})
			->orderBy('Total','desc')
			->limit($length)
			->get();

			$recordsTotal = TbOrderDetail::select(
				DB::raw('SUM(tb_order_detail.product_price) as Total', 'tb_order_detail.product_price'),
				'tb_order_detail.product_sku','tb_order_detail.product_name','tb_order_detail.product_detail',
				'tb_order_detail.orderId','tb_order_detail.created_at',
				'tb_order.id','tb_order.payment_status',
				'tb_setting_payment_status.id',
			)
			->leftjoin('tb_order','tb_order.id','tb_order_detail.orderId')
			->leftjoin('tb_setting_payment_status','tb_setting_payment_status.id','tb_order.payment_status')
			->where('tb_setting_payment_status.status_value',1)
			->groupBy('tb_order_detail.product_sku')
			->when($month, function ($query, $month) {
				if(!empty($month)){
					return $query->whereMonth('tb_order_detail.created_at',$month);
				}
			})
			->when($year, function ($query, $year) {
				if(!empty($year)){
					return $query->whereYear('tb_order_detail.created_at',$year);
				}
			})
			->count();

			$recordsFiltered = TbOrderDetail::select(
				DB::raw('SUM(tb_order_detail.product_price) as Total', 'tb_order_detail.product_price'),
				'tb_order_detail.product_sku','tb_order_detail.product_name','tb_order_detail.product_detail',
				'tb_order_detail.orderId','tb_order_detail.created_at',
				'tb_order.id','tb_order.payment_status',
				'tb_setting_payment_status.id',
			)
			->leftjoin('tb_order','tb_order.id','tb_order_detail.orderId')
			->leftjoin('tb_setting_payment_status','tb_setting_payment_status.id','tb_order.payment_status')
			->where('tb_setting_payment_status.status_value',1)
			->groupBy('tb_order_detail.product_sku')
			->when($month, function ($query, $month) {
				if(!empty($month)){
					return $query->whereMonth('tb_order_detail.created_at',$month);
				}
			})
			->when($year, function ($query, $year) {
				if(!empty($year)){
					return $query->whereYear('tb_order_detail.created_at',$year);
				}
			})
			->count();
		}

        

        return Datatables::of($product)
            ->addColumn('sku', function ($result) {
                return $result->product_sku;

            })
            ->addColumn('name', function ($result) {
                if(!empty($result->product_detail)){
                    if($result->product_detail != 'null'){
                        return $result->product_detail.' ('.$result->product_name.')';
                    }else{
                        return $result->product_name;
                    }
                }else{
                    return $result->product_name;
                }

            })
            ->addColumn('total', function ($result) {
                return number_format($result->Total,2);
            })
            ->setTotalRecords($recordsTotal)
            ->setFilteredRecords($recordsFiltered)
            ->escapeColumns([])
            ->skipPaging()
            ->addIndexColumn()
            ->make(true);
    }
}
