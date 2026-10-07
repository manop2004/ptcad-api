<?php

namespace App\Exports;

use App\Models\TbProductDetail;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProductExport implements FromView
{
    protected $category;
    protected $subcategory;
    protected $search;
    protected $searchSKU;
    protected $selectedIds;
    protected $excludedIds;
    protected $mode;
    protected $accessBrandId;
    protected $exportType;

    public function __construct(
        $category = null,
        $subcategory = null,
        $search = null,
        $searchSKU = null,
        array $selectedIds = [],
        array $excludedIds = [],
        string $mode = 'selected',
        array $accessBrandId = [],
        string $exportType = 'all'
    ) {
        $this->category = $category;
        $this->subcategory = $subcategory;
        $this->search = $search;
        $this->searchSKU = $searchSKU;
        $this->selectedIds = $selectedIds;
        $this->excludedIds = $excludedIds;
        $this->mode = $mode;
        $this->accessBrandId = $accessBrandId;
        $this->exportType = $exportType;
    }

    public function view(): View
    {
        $category = $this->category;
        $subcategory = $this->subcategory;
        $search = $this->search;
        $searchSKU = $this->searchSKU;
        $selectedIds = $this->selectedIds;
        $excludedIds = $this->excludedIds;
        $mode = $this->mode;
        $accessBrandId = $this->accessBrandId;
        $exportType = $this->exportType;

        $products = TbProductDetail::select(
            'tb_product.id',
            'tb_product.pro_name',
            'tb_product.pro_keyword',
            'tb_product.pro_catId',
            'tb_product.pro_catsubId',
            'tb_product.pro_show',
            'tb_product_detail.id as detail_id',
            'tb_product_detail.proId',
            'tb_product_detail.detail_sku',
            'tb_product_detail.vendor_sku',
            'tb_product_detail.detail_name',
            'tb_product_detail.detail_price',
            'tb_product_detail.detail_price_sale_status',
            'tb_product_detail.detail_price_sale',
            'tb_product_detail.detail_price_sale_status_date',
            'tb_product_detail.detail_sale_date_start',
            'tb_product_detail.detail_sale_date_end',
            'tb_product_detail.detail_status',
            'tb_product_detail.detail_preorder_day',
            'tb_product_detail.detail_check_stock_status',
            'tb_product_detail.detail_stock',
            'tb_product_detail.detail_other',
            'tb_product_detail.hide_addtocart_status'
        )
        ->leftJoin('tb_product', 'tb_product.id', '=', 'tb_product_detail.proId')
        ->where('tb_product.pro_show', 1)
        ->where('tb_product_detail.detail_show', 1)
        ->when(!empty($accessBrandId), function ($query) use ($accessBrandId) {
            return $query->whereIn('tb_product.pro_brand', $accessBrandId);
        })
        ->when($search, function ($query, $search) {
            if (!empty($search)) {
                return $query->where(function ($q) use ($search) {
                    $q->where('tb_product.pro_name', 'LIKE', '%' . $search . '%')
                      ->orWhere('tb_product.pro_keyword', 'LIKE', '%' . $search . '%');
                });
            }
        })
        ->when($searchSKU, function ($query, $searchSKU) {
            return $query->where(function ($q) use ($searchSKU) {
                $q->where('tb_product_detail.detail_sku', 'LIKE', '%' . $searchSKU . '%');
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
        })
        ->when($mode === 'selected' && !empty($selectedIds), function ($query) use ($selectedIds) {
            return $query->whereIn('tb_product.id', $selectedIds);
        })
        ->when($mode === 'all_filtered' && !empty($excludedIds), function ($query) use ($excludedIds) {
            return $query->whereNotIn('tb_product.id', $excludedIds);
        })
        ->orderBy('tb_product.id', 'desc')
        ->orderBy('tb_product_detail.id', 'asc')
        ->get();

        return view('admin.product.exports', [
            'products' => $products,
            'i' => 1,
            'exportType' => $exportType,
        ]);
    }
}