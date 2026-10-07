<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Models\TbProduct;
use App\Models\TbProductDetail;
use App\Models\TbProductPicture;
use App\Models\TbCategorySub;

class ProductController extends Controller
{

    public function jsonDetail(Request $request)
	{
		$detailId = $request->detailId;

		if (!empty($detailId)) {

			$response = TbProductDetail::select(
				'tb_product.id','tb_product.pro_show',
				'tb_product_detail.id','tb_product_detail.proId','tb_product_detail.detail_sku','tb_product_detail.detail_name','tb_product_detail.detail_other','tb_product_detail.detail_status',
				'tb_product_detail.detail_preorder_day','tb_product_detail.detail_product_weight','tb_product_detail.detail_product_wide','tb_product_detail.detail_product_long',
				'tb_product_detail.detail_product_high','tb_product_detail.detail_product_contact_sale_status','tb_product_detail.detail_price',
				'tb_product_detail.detail_price_sale_status','tb_product_detail.detail_price_sale','tb_product_detail.detail_price_sale_status_date',
				'tb_product_detail.detail_sale_date_start','tb_product_detail.detail_sale_date_end','tb_product_detail.detail_show',
				'tb_product_detail.hide_addtocart_status',
				'tb_product_status.id','tb_product_status.stu_name','tb_product_status.stu_preorder','tb_product_status.stu_color','tb_product_status.stu_display',
				'tb_product_picture.detailId','tb_product_picture.picture_name',
				'tb_product_detail.min_order',
				'tb_product_detail.max_order',
				'tb_product_detail.detail_check_stock_status',
				'tb_product_detail.detail_stock'
			)
			->leftjoin('tb_product','tb_product.id','tb_product_detail.proId')
			->leftjoin('tb_product_status','tb_product_status.id','tb_product_detail.detail_status')
			->leftjoin('tb_product_picture','tb_product_picture.detailId','tb_product_detail.id')
			->where('tb_product.pro_show',1)
			->where('tb_product_detail.detail_show',1)
			->where('tb_product_detail.id',$detailId)
			->first();

			if (!empty($response)) {

				$priceDetail = check_price_product_on_content_page($detailId);

				if($response->stu_preorder == 1){
					$status = $response->stu_name.' ('.$response->stu_preorder.')';
				}else{
					$status = $response->stu_name;
				}

				if(!empty($response->detail_other)){
					$detail = $response->detail_other;
				}else{
					$detail = $response->detail_name;
				}

				if(!empty($response->picture_name)){
					$picture = '';
					$image = asset('storage/product/'.$response->picture_name);
				}else{
					$picture_name = TbProductPicture::select('proId','picture_name')
						->where('picture_status',1)
						->where('proId',$response->proId)
						->value('picture_name');

					$picture = asset('storage/product/'.$picture_name);
					$image = '';
				}

				// ✅ เงื่อนไขซ่อน Add to cart
				$hideAddToCartButton = 0;

				if (
					(int)$response->hide_addtocart_status === 1 &&
					(int)$response->detail_price_sale_status === 1
				) {
					// ไม่กำหนดเวลา -> ซ่อนทันที
					if ((int)$response->detail_price_sale_status_date === 2) {
						$hideAddToCartButton = 1;
					}

					// กำหนดเวลา -> ซ่อนเมื่อวันนี้อยู่ในช่วง start/end
					if ((int)$response->detail_price_sale_status_date === 1) {
						try {
							$today = Carbon::today();
							$start = !empty($response->detail_sale_date_start)
								? Carbon::createFromFormat('d-m-Y', trim($response->detail_sale_date_start))->startOfDay()
								: null;
							$end = !empty($response->detail_sale_date_end)
								? Carbon::createFromFormat('d-m-Y', trim($response->detail_sale_date_end))->endOfDay()
								: null;

							if ($start && $end && $today->between($start, $end)) {
								$hideAddToCartButton = 1;
							}
						} catch (\Exception $e) {
							$hideAddToCartButton = 0;
						}
					}
				}

				$response = [
					'sku' => $response->detail_sku,
					'status' => $status,
					'background' => $response->stu_color,
					'price' => $priceDetail,
					'detail' => $detail,
					'image' => $image,
					'picture' => $picture,
					'display' => $response->stu_display,

					'min_order' => !empty($response->min_order) ? (int)$response->min_order : null,
					'max_order' => !empty($response->max_order) ? (int)$response->max_order : null,
					'detail_check_stock_status' => isset($response->detail_check_stock_status) ? (int)$response->detail_check_stock_status : 0,
					'detail_stock' => isset($response->detail_stock) ? (int)$response->detail_stock : 0,

					// ✅ ส่งค่าเพิ่ม
					'hide_addtocart_status' => isset($response->hide_addtocart_status) ? (int)$response->hide_addtocart_status : 2,
					'detail_price_sale_status' => isset($response->detail_price_sale_status) ? (int)$response->detail_price_sale_status : 2,
					'detail_price_sale_status_date' => isset($response->detail_price_sale_status_date) ? (int)$response->detail_price_sale_status_date : 2,
					'detail_sale_date_start' => $response->detail_sale_date_start,
					'detail_sale_date_end' => $response->detail_sale_date_end,
					'hide_addtocart_button' => $hideAddToCartButton,
				];

				return response()->json($response);

			} else {
				return 'false';
			}
		} else {
			return 'false';
		}
	}

    public function getSubcategory(Request $request){

        $response = TbCategorySub::select('category_id','categorysub_show','categorysub_sort','categorysub_permalink','categorysub_name')
        ->where('category_id', $request->id)->where('categorysub_show','1')->orderby('categorysub_sort','desc')->get();

        if(count($response) != 0){
            return $response;
        }else{
            return 0;
        }

    }

}
