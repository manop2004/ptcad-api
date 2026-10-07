<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\TbSetting;
use App\Models\TbOrder;
use App\Models\TbOrderDetail;
use App\Models\TbProduct;
use App\Models\TbProductDetail;
use App\Models\HistoryOrderStatus;
use App\Models\HistorySendMail;
use App\Models\TbPagesMap;
use App\Models\TbExtension;
use App\Models\Review;
use App\Models\ReviewImage;

use App\Mail\orderThankyou;

class ThankUController extends Controller
{

    // ส่งเมล ขอบคุณ ให้ Order ที่เปลี่ยนสถานะเป็น "จัดส่งสินค้าแล้ว" 7 วัน
    public function SendMailThankyou(){
		
		$orders = HistoryOrderStatus::select(
											'history_order_status.*', 
											'users.email', 
											'tb_order.residence_name', 
											'tb_order.residence_lastname'
										)
										->join('tb_order', 'history_order_status.orderNumber', '=', 'tb_order.orderNumber')
										->join('users', 'tb_order.userCode', '=', 'users.user_code')
										->where('tb_order.payment_status', 5)
										->where(function ($query) {
											$query->where('history_order_status.order_message', 'LIKE', 'จัดส่งสินค้าแล้ว')
												  ->orWhere('history_order_status.order_status', 'LIKE', 'อัพเดตผู้ให้บริการขนส่ง');
										})
										->whereDate('history_order_status.created_at', DB::raw('DATE(NOW() - INTERVAL 7 DAY)'))
										//->whereDate('history_order_status.created_at', '2025-03-12')
										->whereNotNull('users.email')
										->get();
										
		$setting = TbSetting::first();
        $page = TbPagesMap::first();
        
        foreach($orders as $order){
			
            $products = TbOrder::select('*')
							->leftJoin('tb_order_detail', 'tb_order_detail.orderId', '=', 'tb_order.id')
							->leftJoin('tb_product_detail', function($join) {
								$join->on('tb_product_detail.detail_sku', 'LIKE', 'tb_order_detail.product_sku');
							})
							->leftJoin('tb_product', 'tb_product.id', '=', 'tb_product_detail.proId')
							->leftJoin('reviews', function($join) {
								$join->on('reviews.order_id', '=', 'tb_order.id')
									 ->on('reviews.product_id', '=', 'tb_product.id');
							})
							->where('tb_order.orderNumber', 'LIKE', $order->orderNumber)
							->whereNull('reviews.id')
							->whereNotNull('tb_product.id')
							->groupBy('tb_product.id')
							->get();
														
			if(!empty($order->email)){
				
				$data = new \stdClass();
				$data->setting_nameWeb = $setting->setting_nameWeb;
				$data->setting_logoWeb = $setting->setting_logoWeb;
				$data->setting = $setting;
				$data->order = $order;
				$data->page = $page;
				$data->products = $products;
				$mail_bcc = array('yukonthorn_ta@applicadthai.com');
            
				try{
					Mail::to($order->email)->bcc($mail_bcc)->later(now()->addMinutes(5), new orderThankyou($data));
					
					if(Mail::failures()) { $mailStatus = 'ล้มเหลว'; }else{ $mailStatus = 'สำเร็จ'; }
					
				}catch(\Exception $e){
					
					// Never reached
					$mailStatus = 'ล้มเหลว';
				}
			}

        }

    }

}