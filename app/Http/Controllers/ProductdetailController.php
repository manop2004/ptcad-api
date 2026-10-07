<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Storage;

use App\Models\TbProduct;
use App\Models\TbProductDetail;
use App\Models\TbProductPicture;
use App\Models\TbProductStatus;

class ProductdetailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function add($tab, $id)
    {
        $breadcrumb = [
            ['name' => 'เพิ่มรูปแบบสินค้า'],
        ];
        $title_page = 'เพิ่มรูปแบบสินค้า';

        $pro_status = TbProductStatus::where('stu_show', 1)->get();
        $sort = TbProductDetail::orderBy('sort', 'desc')->value('sort');
        $productType = $this->productTypeGet($id);

        return view('admin.product.model-content.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'detailThumb' => '',
            'detail' => '',
            'tab' => $tab,
            'id' => $id,
            'pro_status' => $pro_status,
            'productType' => $productType,
            'sort' => $sort,
        ]);
    }

    public function crate(Request $request)
    {
        $rules = [
            'detail_sku' => 'required|max:255',
            'vendor_sku' => 'nullable|max:255',
            'hide_addtocart_status' => 'nullable|in:1,2',
            'sort' => 'required',
            'min_order' => 'nullable|integer|min:1',
            'max_order' => 'nullable|integer|min:1',
        ];

        $messages = [
            'detail_sku.required' => 'กรุณากรอกข้อมูล',
            'detail_sku.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
            'vendor_sku.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
            'hide_addtocart_status.in' => 'กรุณาเลือกสถานะปุ่ม Add to cart ให้ถูกต้อง',
            'sort.required' => 'กรุณากรอกข้อมูล',

            'min_order.integer' => 'สั่งซื้อขั้นต่ำต้องเป็นตัวเลขจำนวนเต็ม',
            'min_order.min' => 'สั่งซื้อขั้นต่ำต้องมากกว่าหรือเท่ากับ 1',

            'max_order.integer' => 'ซื้อได้สูงสุดต้องเป็นตัวเลขจำนวนเต็ม',
            'max_order.min' => 'ซื้อได้สูงสุดต้องมากกว่าหรือเท่ากับ 1',
        ];

        if ($request->detail_sku != '-') {
            $rules['detail_sku'] .= '|unique:tb_product_detail,detail_sku';
            $messages['detail_sku.unique'] = 'SKU นี้มีการใช้งานอยู่แล้ว กรุณาตรวจสอบข้อมูลอีกครั้ง';
        }

        if ($request->detail_check_stock_status == 1) {
            $rules['detail_stock'] = 'required|integer|min:0';
            $messages['detail_stock.required'] = 'กรุณากรอกจำนวนสต็อก';
            $messages['detail_stock.integer'] = 'จำนวนสต็อกต้องเป็นจำนวนเต็ม';
            $messages['detail_stock.min'] = 'จำนวนสต็อกต้องเป็น 0 หรือมากกว่า';
        }

        if ((string)$request->detail_product_contact_sale_status !== '1') {
            $rules['detail_price'] = ['required', 'regex:/^\d+$/'];
            $messages['detail_price.required'] = 'กรุณากรอกราคาปกติ';
            $messages['detail_price.regex'] = 'ราคาปกติต้องเป็นตัวเลขจำนวนเต็มเท่านั้น';
        }

        if ((string)$request->detail_price_sale_status == '1') {
            $rules['detail_price_sale'] = ['required', 'regex:/^\d+$/'];
            $messages['detail_price_sale.required'] = 'กรุณากรอกราคาลด';
            $messages['detail_price_sale.regex'] = 'ราคาลดต้องเป็นตัวเลขจำนวนเต็มเท่านั้น';

            if ($request->detail_price_sale_status_date == 1) {
                $rules['detail_sale_date_start'] = 'required|max:255';
                $rules['detail_sale_date_end'] = 'required|max:255';

                $messages['detail_sale_date_start.required'] = 'กรุณากรอกวันที่เริ่มลดราคา';
                $messages['detail_sale_date_start.max'] = 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร';
                $messages['detail_sale_date_end.required'] = 'กรุณากรอกวันที่สิ้นสุดลดราคา';
                $messages['detail_sale_date_end.max'] = 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร';
            }
        }

        $request->validate($rules, $messages);

        $minOrder = $request->min_order !== null && $request->min_order !== '' ? (int)$request->min_order : null;
        $maxOrder = $request->max_order !== null && $request->max_order !== '' ? (int)$request->max_order : null;

        if ($minOrder !== null && $maxOrder !== null && $maxOrder < $minOrder) {
            return back()
                ->withErrors(['max_order' => 'ซื้อได้สูงสุดต้องมากกว่าหรือเท่ากับสั่งซื้อขั้นต่ำ'])
                ->withInput();
        }

        $detail_product_contact_sale_status = ($request->detail_product_contact_sale_status != '') ? 1 : 2;
        $detail_price_sale_status = ($request->detail_price_sale_status != '') ? 1 : 2;
        $show = ($request->detail_show == 'on') ? 1 : 2;

        $detail_status = !empty($request->detail_status) ? $request->detail_status : 1;
        $detail_stock = $request->detail_stock;

        if ($detail_status == 2) {
            $detail_stock = 0;
        }

        if ($request->detail_check_stock_status == 1) {
            if ($detail_stock >= 1) {
                $detail_status = 1;
            } else {
                $detail_status = 2;
            }
            $detail_check_stock_status = 1;
        } else {
            $detail_check_stock_status = 2;
        }

        $data = new TbProductDetail;
        $data->proId = $request->proId;
        $data->sort = $request->sort;
        $data->detail_sku = $request->detail_sku;
        $data->vendor_sku = $request->vendor_sku;
        $data->hide_addtocart_status = $request->hide_addtocart_status ?: 2;
        $data->detail_name = $request->detail_name;
        $data->detail_other = $request->detail_other;
        $data->detail_status = $detail_status;
        $data->detail_preorder_day = $request->detail_preorder_day;
        $data->detail_product_weight = $request->detail_product_weight;
        $data->detail_product_wide = $request->detail_product_wide;
        $data->detail_product_long = $request->detail_product_long;
        $data->detail_product_high = $request->detail_product_high;
        $data->min_order = $minOrder;
        $data->max_order = $maxOrder;

        if ($detail_product_contact_sale_status == 2) {
            $data->detail_product_contact_sale_status = 2;
            $data->detail_price = $this->sanitizeInteger($request->detail_price);
        } else {
            $data->detail_product_contact_sale_status = 1;
            $data->detail_price = null;
        }

        if ($detail_price_sale_status == 1) {
            $data->detail_price_sale_status = 1;
            $data->detail_price_sale = $this->sanitizeInteger($request->detail_price_sale);
            $data->detail_price_sale_status_date = $request->detail_price_sale_status_date;
            $data->detail_sale_date_start = $request->detail_sale_date_start;
            $data->detail_sale_date_end = $request->detail_sale_date_end;
        } else {
            $data->detail_price_sale_status = 2;
            $data->detail_price_sale = null;
            $data->detail_price_sale_status_date = 2;
            $data->detail_sale_date_start = null;
            $data->detail_sale_date_end = null;
        }

        $data->detail_check_stock_status = $detail_check_stock_status;
        $data->detail_stock = $detail_stock;
        $data->detail_show = $show;
        $data->created_by = Auth::user()->displayname;
        $data->updated_by = Auth::user()->displayname;
        $data->created_at = date('Y-m-d H:i:s');
        $data->updated_at = date('Y-m-d H:i:s');
        $data->save();

        if (!empty($request->pro_thumb)) {
            $checkThumb = TbProductPicture::where('detailId', $data->id)->where('picture_status', 1)->first();

            if (!empty($checkThumb)) {
                $thumb = TbProductPicture::findOrFail($checkThumb->id);
                if ($request->hasFile('pro_thumb')) {
                    @unlink(Storage::disk('public')->path('product') . $request->pro_thumb_old);

                    $newFilename = uniqid() . '.' . $request->pro_thumb->extension();
                    $thumb->picture_name = $newFilename;
                    $file = $request->file('pro_thumb');
                    $file->move('storage/product/', $newFilename);
                }
                $thumb->save();
            } else {
                $thumb = new TbProductPicture;
                $thumb->detailId = $data->id;
                $thumb->picture_status = 1;
                if ($request->hasFile('pro_thumb')) {
                    $newFilename = uniqid() . '.' . $request->pro_thumb->extension();
                    $thumb->picture_name = $newFilename;
                    $file = $request->file('pro_thumb');
                    $file->move('storage/product/', $newFilename);
                }
                $thumb->save();
            }
        }

        return redirect()->route('product.edit', ['tab' => 4, 'id' => $request->proId])->with('feedback', 'เพิ่มข้อมูลเรียบร้อยแล้ว!');
    }

    public function edit($tab, $proId, $id)
    {
        $breadcrumb = [
            ['name' => 'อัพเดตรูปแบบสินค้า'],
        ];
        $title_page = 'อัพเดตรูปแบบสินค้า';

        $pro_status = TbProductStatus::where('stu_show', 1)->get();
        $detail = TbProductDetail::findOrFail($id);
        $productType = $this->productTypeGet($proId);

        return view('admin.product.model-content.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'detailThumb' => '',
            'detail' => $detail,
            'tab' => $tab,
            'id' => $proId,
            'pro_status' => $pro_status,
            'productType' => $productType,
        ]);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'detail_sku' => 'required|max:255',
            'vendor_sku' => 'nullable|max:255',
            'hide_addtocart_status' => 'nullable|in:1,2',
            'sort' => 'required',
            'min_order' => 'nullable|integer|min:1',
            'max_order' => 'nullable|integer|min:1',
        ];

        $messages = [
            'detail_sku.required' => 'กรุณากรอกข้อมูล',
            'detail_sku.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
            'vendor_sku.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
            'hide_addtocart_status.in' => 'กรุณาเลือกสถานะปุ่ม Add to cart ให้ถูกต้อง',
            'sort.required' => 'กรุณากรอกข้อมูล',

            'min_order.integer' => 'สั่งซื้อขั้นต่ำต้องเป็นตัวเลขจำนวนเต็ม',
            'min_order.min' => 'สั่งซื้อขั้นต่ำต้องมากกว่าหรือเท่ากับ 1',

            'max_order.integer' => 'ซื้อได้สูงสุดต้องเป็นตัวเลขจำนวนเต็ม',
            'max_order.min' => 'ซื้อได้สูงสุดต้องมากกว่าหรือเท่ากับ 1',
        ];

        if ($request->detail_sku != '-') {
            $rules['detail_sku'] .= '|unique:tb_product_detail,detail_sku,' . $id;
            $messages['detail_sku.unique'] = 'SKU นี้มีการใช้งานอยู่แล้ว กรุณาตรวจสอบข้อมูลอีกครั้ง';
        }

        if ($request->detail_check_stock_status == 1) {
            $rules['detail_stock'] = 'required|integer|min:0';
            $messages['detail_stock.required'] = 'กรุณากรอกจำนวนสต็อก';
            $messages['detail_stock.integer'] = 'จำนวนสต็อกต้องเป็นจำนวนเต็ม';
            $messages['detail_stock.min'] = 'จำนวนสต็อกต้องเป็น 0 หรือมากกว่า';
        }

        if ((string)$request->detail_product_contact_sale_status !== '1') {
            $rules['detail_price'] = ['required', 'regex:/^\d+$/'];
            $messages['detail_price.required'] = 'กรุณากรอกราคาปกติ';
            $messages['detail_price.regex'] = 'ราคาปกติต้องเป็นตัวเลขจำนวนเต็มเท่านั้น';
        }

        if ((string)$request->detail_price_sale_status == '1') {
            $rules['detail_price_sale'] = ['required', 'regex:/^\d+$/'];
            $messages['detail_price_sale.required'] = 'กรุณากรอกราคาลด';
            $messages['detail_price_sale.regex'] = 'ราคาลดต้องเป็นตัวเลขจำนวนเต็มเท่านั้น';

            if ($request->detail_price_sale_status_date == 1) {
                $rules['detail_sale_date_start'] = 'required|max:255';
                $rules['detail_sale_date_end'] = 'required|max:255';

                $messages['detail_sale_date_start.required'] = 'กรุณากรอกวันที่เริ่มลดราคา';
                $messages['detail_sale_date_start.max'] = 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร';
                $messages['detail_sale_date_end.required'] = 'กรุณากรอกวันที่สิ้นสุดลดราคา';
                $messages['detail_sale_date_end.max'] = 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร';
            }
        }

        $request->validate($rules, $messages);

        $minOrder = $request->min_order !== null && $request->min_order !== '' ? (int)$request->min_order : null;
        $maxOrder = $request->max_order !== null && $request->max_order !== '' ? (int)$request->max_order : null;

        if ($minOrder !== null && $maxOrder !== null && $maxOrder < $minOrder) {
            return back()
                ->withErrors(['max_order' => 'ซื้อได้สูงสุดต้องมากกว่าหรือเท่ากับสั่งซื้อขั้นต่ำ'])
                ->withInput();
        }

        if ($request->detail_product_contact_sale_status != '') {
            $detail_product_contact_sale_status = 1;
        } else {
            $detail_product_contact_sale_status = 2;
        }

        if ($request->detail_price_sale_status != '') {
            $detail_price_sale_status = 1;
        } else {
            $detail_price_sale_status = 2;
        }

        if ($request->detail_show == 'on') {
            $show = 1;
        } else {
            $show = 2;
        }

        if (!empty($request->detail_status)) {
            $detail_status = $request->detail_status;
        } else {
            $detail_status = 1;
        }

        $detail_stock = $request->detail_stock;

        if ($detail_status == 2) {
            $detail_stock = 0;
        }

        if ($request->detail_check_stock_status == 1) {
            if ($detail_stock >= 1) {
                $detail_status = 1;
            } else {
                $detail_status = 2;
            }

            $detail_check_stock_status = 1;
        } else {
            $detail_check_stock_status = 2;
        }

        $data = TbProductDetail::findOrFail($id);
        $data->sort = $request->sort;
        $data->detail_sku = $request->detail_sku;
        $data->vendor_sku = $request->vendor_sku;
        $data->hide_addtocart_status = $request->hide_addtocart_status ?: 2;
        $data->detail_name = $request->detail_name;
        $data->detail_other = $request->detail_other;
        $data->detail_status = $detail_status;
        $data->detail_preorder_day = $request->detail_preorder_day;
        $data->detail_product_weight = $request->detail_product_weight;
        $data->detail_product_wide = $request->detail_product_wide;
        $data->detail_product_long = $request->detail_product_long;
        $data->detail_product_high = $request->detail_product_high;
        $data->min_order = $minOrder;
        $data->max_order = $maxOrder;

        if ($detail_product_contact_sale_status == 2) {
            $data->detail_product_contact_sale_status = $detail_product_contact_sale_status;
            $data->detail_price = $this->sanitizeInteger($request->detail_price);
        } else {
            $data->detail_product_contact_sale_status = 1;
            $data->detail_price = null;
        }

        if ($detail_price_sale_status == 1) {
            $data->detail_price_sale_status = $detail_price_sale_status;
            $data->detail_price_sale = $this->sanitizeInteger($request->detail_price_sale);
            $data->detail_price_sale_status_date = $request->detail_price_sale_status_date;
            $data->detail_sale_date_start = $request->detail_sale_date_start;
            $data->detail_sale_date_end = $request->detail_sale_date_end;
        } else {
            $data->detail_price_sale_status = 2;
            $data->detail_price_sale = null;
            $data->detail_price_sale_status_date = 2;
            $data->detail_sale_date_start = null;
            $data->detail_sale_date_end = null;
        }

        $data->detail_check_stock_status = $detail_check_stock_status;
        $data->detail_stock = $detail_stock;
        $data->detail_show = $show;
        $data->updated_by = Auth::user()->displayname;
        $data->updated_at = date('Y-m-d H:i:s');
        $data->save();

        if (!empty($request->pro_thumb)) {
            $checkThumb = TbProductPicture::where('detailId', $data->id)->where('picture_status', 1)->first();

            if (!empty($checkThumb)) {
                $thumb = TbProductPicture::findOrFail($checkThumb->id);
                if ($request->hasFile('pro_thumb')) {
                    @unlink(Storage::disk('public')->path('product') . $request->pro_thumb_old);

                    $newFilename = uniqid() . '.' . $request->pro_thumb->extension();
                    $thumb->picture_name = $newFilename;
                    $file = $request->file('pro_thumb');
                    $file->move('storage/product/', $newFilename);
                }
                $thumb->save();
            } else {
                $thumb = new TbProductPicture;
                $thumb->detailId = $data->id;
                $thumb->picture_status = 1;
                if ($request->hasFile('pro_thumb')) {
                    $newFilename = uniqid() . '.' . $request->pro_thumb->extension();
                    $thumb->picture_name = $newFilename;
                    $file = $request->file('pro_thumb');
                    $file->move('storage/product/', $newFilename);
                }
                $thumb->save();
            }
        }

        return redirect()->route('product.edit', ['tab' => 4, 'id' => $request->proId])->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');
    }

    public function updateModel(Request $request, $id)
    {
        $rules = [
            'detail_sku'  => 'required|max:255',
            'vendor_sku' => 'nullable|max:255',
            'hide_addtocart_status' => 'nullable|in:1,2',
            'detail_name' => 'required|max:255',
            'sort'        => 'required',
            'min_order'   => 'nullable|integer|min:1',
            'max_order'   => 'nullable|integer|min:1',
        ];

        $messages = [
            'detail_sku.required'  => 'กรุณากรอกข้อมูล',
            'detail_sku.max'       => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
            'vendor_sku.max'       => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
            'hide_addtocart_status.in' => 'กรุณาเลือกสถานะปุ่ม Add to cart ให้ถูกต้อง',
            'detail_name.required' => 'กรุณากรอกข้อมูล',
            'detail_name.max'      => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
            'sort.required'        => 'กรุณากรอกข้อมูล',

            'min_order.integer'    => 'สั่งซื้อขั้นต่ำต้องเป็นตัวเลขจำนวนเต็ม',
            'min_order.min'        => 'สั่งซื้อขั้นต่ำต้องมากกว่าหรือเท่ากับ 1',
            'max_order.integer'    => 'ซื้อได้สูงสุดต้องเป็นตัวเลขจำนวนเต็ม',
            'max_order.min'        => 'ซื้อได้สูงสุดต้องมากกว่าหรือเท่ากับ 1',
        ];

        if ($request->detail_sku != '-') {
            $rules['detail_sku'] .= '|unique:tb_product_detail,detail_sku,' . $id;
            $messages['detail_sku.unique'] = 'SKU นี้มีการใช้งานอยู่แล้ว กรุณาตรวจสอบข้อมูลอีกครั้ง';
        }

        if ($request->detail_check_stock_status == 1) {
            $rules['detail_stock'] = 'required|integer|min:0';
            $messages['detail_stock.required'] = 'กรุณากรอกจำนวนสต็อก';
            $messages['detail_stock.integer'] = 'จำนวนสต็อกต้องเป็นจำนวนเต็ม';
            $messages['detail_stock.min'] = 'จำนวนสต็อกต้องเป็น 0 หรือมากกว่า';
        }

        if ((string)$request->detail_product_contact_sale_status !== '1') {
            $rules['detail_price'] = ['required', 'regex:/^\d+$/'];
            $messages['detail_price.required'] = 'กรุณากรอกราคาปกติ';
            $messages['detail_price.regex'] = 'ราคาปกติต้องเป็นตัวเลขจำนวนเต็มเท่านั้น';
        }

        if ((string)$request->detail_price_sale_status == '1') {
            $rules['detail_price_sale'] = ['required', 'regex:/^\d+$/'];
            $messages['detail_price_sale.required'] = 'กรุณากรอกราคาลด';
            $messages['detail_price_sale.regex'] = 'ราคาลดต้องเป็นตัวเลขจำนวนเต็มเท่านั้น';

            if ($request->detail_price_sale_status_date == 1) {
                $rules['detail_sale_date_start'] = 'required|max:255';
                $rules['detail_sale_date_end'] = 'required|max:255';

                $messages['detail_sale_date_start.required'] = 'กรุณากรอกวันที่เริ่มลดราคา';
                $messages['detail_sale_date_start.max'] = 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร';
                $messages['detail_sale_date_end.required'] = 'กรุณากรอกวันที่สิ้นสุดลดราคา';
                $messages['detail_sale_date_end.max'] = 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร';
            }
        }

        $request->validate($rules, $messages);

        $minOrder = $request->min_order !== null && $request->min_order !== '' ? (int)$request->min_order : null;
        $maxOrder = $request->max_order !== null && $request->max_order !== '' ? (int)$request->max_order : null;

        if ($minOrder !== null && $maxOrder !== null && $maxOrder < $minOrder) {
            return back()
                ->withErrors(['max_order' => 'ซื้อได้สูงสุดต้องมากกว่าหรือเท่ากับสั่งซื้อขั้นต่ำ'])
                ->withInput();
        }

        if ($request->detail_product_contact_sale_status != '') {
            $detail_product_contact_sale_status = 1;
        } else {
            $detail_product_contact_sale_status = 2;
        }

        if ($request->detail_price_sale_status != '') {
            $detail_price_sale_status = 1;
        } else {
            $detail_price_sale_status = 2;
        }

        if ($request->detail_show == 'on') {
            $show = 1;
        } else {
            $show = 2;
        }

        if (!empty($request->detail_status)) {
            $detail_status = $request->detail_status;
        } else {
            $detail_status = 1;
        }

        $detail_stock = $request->detail_stock;

        if ($detail_status == 2) {
            $detail_stock = 0;
        }

        if ($request->detail_check_stock_status == 1) {
            if ($detail_stock >= 1) {
                $detail_status = 1;
            } else {
                $detail_status = 2;
            }

            $detail_check_stock_status = 1;
        } else {
            $detail_check_stock_status = 2;
        }

        $data = TbProductDetail::findOrFail($id);
        $data->sort = $request->sort;
        $data->detail_sku = $request->detail_sku;
        $data->vendor_sku = $request->vendor_sku;
        $data->hide_addtocart_status = $request->hide_addtocart_status ?: 2;
        $data->detail_name = $request->detail_name;
        $data->detail_other = $request->detail_other;
        $data->detail_status = $detail_status;
        $data->detail_preorder_day = $request->detail_preorder_day;
        $data->detail_product_weight = $request->detail_product_weight;
        $data->detail_product_wide = $request->detail_product_wide;
        $data->detail_product_long = $request->detail_product_long;
        $data->detail_product_high = $request->detail_product_high;
        $data->min_order = $minOrder;
        $data->max_order = $maxOrder;

        if ($detail_product_contact_sale_status == 2) {
            $data->detail_product_contact_sale_status = $detail_product_contact_sale_status;
            $data->detail_price = $this->sanitizeInteger($request->detail_price);
        } else {
            $data->detail_product_contact_sale_status = 1;
            $data->detail_price = null;
        }

        if ($detail_price_sale_status == 1) {
            $data->detail_price_sale_status = $detail_price_sale_status;
            $data->detail_price_sale = $this->sanitizeInteger($request->detail_price_sale);
            $data->detail_price_sale_status_date = $request->detail_price_sale_status_date;
            $data->detail_sale_date_start = $request->detail_sale_date_start;
            $data->detail_sale_date_end = $request->detail_sale_date_end;
        } else {
            $data->detail_price_sale_status = 2;
            $data->detail_price_sale = null;
            $data->detail_price_sale_status_date = 2;
            $data->detail_sale_date_start = null;
            $data->detail_sale_date_end = null;
        }

        $data->detail_check_stock_status = $detail_check_stock_status;
        $data->detail_stock = $detail_stock;
        $data->detail_show = $show;
        $data->updated_by = Auth::user()->displayname;
        $data->updated_at = date('Y-m-d H:i:s');
        $data->save();

        if (!empty($request->pro_thumb)) {
            $checkThumb = TbProductPicture::where('detailId', $data->id)->where('picture_status', 1)->first();

            if (!empty($checkThumb)) {
                $thumb = TbProductPicture::findOrFail($checkThumb->id);
                if ($request->hasFile('pro_thumb')) {
                    @unlink(Storage::disk('public')->path('product') . $request->pro_thumb_old);

                    $newFilename = uniqid() . '.' . $request->pro_thumb->extension();
                    $thumb->picture_name = $newFilename;
                    $file = $request->file('pro_thumb');
                    $file->move('storage/product/', $newFilename);
                }
                $thumb->save();
            } else {
                $thumb = new TbProductPicture;
                $thumb->detailId = $data->id;
                $thumb->picture_status = 1;
                if ($request->hasFile('pro_thumb')) {
                    $newFilename = uniqid() . '.' . $request->pro_thumb->extension();
                    $thumb->picture_name = $newFilename;
                    $file = $request->file('pro_thumb');
                    $file->move('storage/product/', $newFilename);
                }
                $thumb->save();
            }
        }

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');
    }

    public function deleteImg(Request $request)
    {
        $checkThumb = TbProductPicture::findOrFail($request->deleteId);

        if (!empty($checkThumb)) {
            @unlink(Storage::disk('public')->path('product') . $checkThumb->picture_name);
        }

        TbProductPicture::where('id', $request->deleteId)->delete();

        return back()->with('feedback', 'ลบข้อมูลเรียบร้อยแล้ว!');
    }

    public function status($id)
    {
        $data = TbProductDetail::findOrFail($id);

        if ($data->detail_show == 2) {
            $status = 1;
        } elseif ($data->detail_show == 1) {
            $status = 2;
        } else {
            $status = 2;
        }

        $data->detail_show = $status;
        $data->updated_by = Auth::user()->displayname;
        $data->updated_at = date('Y-m-d H:i:s');
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');
    }

    public function jsondata($id)
    {
        $data = TbProductDetail::with('tb_product_status', 'tb_product_pictures')->where('proId', $id)->get();

        return Datatables::of($data)
            ->addColumn('img', function ($data) {
                if (!empty($data->tb_product_pictures[0]->picture_name)) {
                    $image = "<img src='" . asset('storage/product/' . $data->tb_product_pictures[0]->picture_name) . "' alt='...' class='full-width' rel='nofollow'>";
                } else {
                    $image = "<img src='" . asset('images/default-img/no-img.jpg') . "' alt='...' class='full-width' rel='nofollow'>";
                }
                return $image;
            })
            ->addColumn('sku', function ($data) {
                $html = e($data->detail_sku);

                if (!empty($data->vendor_sku)) {
                    $html .= '<br><small class="text-muted">Vendor SKU: ' . e($data->vendor_sku) . '</small>';
                }

                if ((int)$data->hide_addtocart_status === 1) {
                    $html .= '<br><small class="text-danger">ซ่อนปุ่ม Add to cart</small>';
                } else {
                    $html .= '';
                }

                return $html;
            })
            ->addColumn('name', function ($data) {
                if (!empty($data->detail_other)) {
                    return $data->detail_name . '<br/><small>' . $data->detail_other . '</small>';
                } else {
                    return $data->detail_name;
                }
            })
            ->addColumn('price', function ($data) {
                return $this->checkPrice(
                    $data->detail_product_contact_sale_status,
                    $data->detail_price,
                    $data->detail_price_sale_status,
                    $data->detail_price_sale,
                    $data->detail_price_sale_status_date,
                    $data->detail_sale_date_start,
                    $data->detail_sale_date_end
                );
            })
            ->addColumn('status', function ($data) {
                return '<span class="badge" style="background:' . $data->tb_product_status['stu_color'] . '; color: #fff">' . $data->tb_product_status['stu_name'] . '</span>';
            })
            ->addColumn('show', function ($data) {
                return $data->detail_show;
            })
            ->addColumn('updated', function ($data) {
                return $data->updated_at . '<br/><small><i class="fa fa-user"></i> ' . $data->updated_by . '</small>';
            })
            ->addColumn('actions', function ($data) {
                $id = $data->id;
                $name = $data->detail_name;
                $status = $data->detail_show;
                $proId = $data->proId;
                return view('admin.product.buttonDetail', compact('id', 'name', 'status', 'proId'));
            })
            ->escapeColumns([])
            ->addIndexColumn()
            ->make(true);
    }

    public function delete(Request $request)
    {
        $checkThumb = TbProductPicture::where('detailId', $request->deleteId)->first();

        if (!empty($checkThumb)) {
            @unlink(Storage::disk('public')->path('product') . $checkThumb->picture_name);
        }

        TbProductDetail::where('id', $request->deleteId)->delete();

        return back()->with('feedback', 'ลบข้อมูลเรียบร้อยแล้ว!');
    }

    private function checkPrice($detail_product_contact_sale_status, $detail_price, $detail_price_sale_status, $detail_price_sale, $detail_price_sale_status_date, $detail_sale_date_start, $detail_sale_date_end)
    {
        if ($detail_product_contact_sale_status == 1) {
            $price = 0;
            $price_sale = '';
        } else {
            if ($detail_price_sale_status == 1) {
                if ($detail_price_sale_status_date == 1) {
                    $dateToday = date('d-m-Y');
                    $dateStart = $this->compareDate($dateToday, $detail_sale_date_start);
                    $dateEnd = $this->compareDate($dateToday, $detail_sale_date_end);

                    if ($dateStart != 2) {
                        if ($dateEnd != 0) {
                            $price = $this->toIntPrice($detail_price);
                            $price_sale = $this->toIntPrice($detail_price_sale);
                        } else {
                            $price = $this->toIntPrice($detail_price);
                            $price_sale = '';
                        }
                    } else {
                        $price = $this->toIntPrice($detail_price);
                        $price_sale = '';
                    }
                } else {
                    $price = $this->toIntPrice($detail_price);
                    $price_sale = $this->toIntPrice($detail_price_sale);
                }
            } else {
                $price = $this->toIntPrice($detail_price);
                $price_sale = '';
            }
        }

        if ($price_sale !== '' && $price_sale !== null) {
            return number_format((int)$price_sale, 0) . '.-' . '<br/><div style="text-decoration: line-through;"><small>' . number_format((int)$price, 0) . '</small></div>';
        } else {
            return number_format((int)$price, 0) . '.-';
        }
    }

    private function compareDate($date1, $date2)
    {
        $arrDate1 = explode("-", $date1);
        $arrDate2 = explode("-", $date2);

        if (count($arrDate1) !== 3 || count($arrDate2) !== 3) {
            return 0;
        }

        $timStmp1 = mktime(0, 0, 0, $arrDate1[1], $arrDate1[2], $arrDate1[0]);
        $timStmp2 = mktime(0, 0, 0, $arrDate2[1], $arrDate2[2], $arrDate2[0]);

        if ($timStmp1 == $timStmp2) {
            return 1;
        } elseif ($timStmp1 > $timStmp2) {
            return 0;
        } elseif ($timStmp1 < $timStmp2) {
            return 2;
        }

        return 0;
    }

    private function sanitizeInteger($value)
    {
        if ($value === null || $value === '') {
            return null;
        }

        $value = trim($value);
        $value = str_replace([',', '฿', ' '], '', $value);
        $value = preg_replace('/[^0-9]/', '', $value);

        if ($value === '' || !is_numeric($value)) {
            return null;
        }

        return (string)((int)$value);
    }

    private function toIntPrice($value): int
    {
        if ($value === null || $value === '') {
            return 0;
        }

        if (is_string($value)) {
            $value = str_replace([',', '฿', ' '], '', trim($value));
        }

        return is_numeric($value) ? (int)$value : 0;
    }

    private function rewrite_url($url)
    {
        return $this->sanitizeInteger($url);
    }

    private function productTypeGet($proId)
    {
        $data = TbProduct::select('tb_product.id', 'tb_product.pro_catId', 'tb_category.id', 'tb_category.category_display_status')
            ->leftjoin('tb_category', 'tb_category.id', 'tb_product.pro_catId')
            ->where('tb_product.id', $proId)
            ->value('tb_category.category_display_status');

        return $data;
    }
}