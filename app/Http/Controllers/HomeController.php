<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;

use App\Models\TbOrder;
use App\Models\TbQuotation;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
	/*
    public function index()
    {

        $breadcrumb = [
            ['name' => 'Dashboard'],
        ];
        $title_page = 'Dashboard';
		
		// check access brand
		$current_user = Auth::user();
		$access_brand_id = $current_user->access_brand_id;
		
		if(!empty($access_brand_id)){
			
			if(strpos($access_brand_id, ',')){
				$access_brand_id = explode(',',trim($access_brand_id));
			}else{
				$access_brand_id = [$access_brand_id];
			}
			
			$orderToday = TbOrder::leftjoin('tb_order_payment','tb_order_payment.orderId','tb_order.id')
							->leftjoin('tb_order_detail','tb_order.id','tb_order_detail.orderId')
							->leftjoin('tb_product_detail','tb_order_detail.product_sku','tb_product_detail.detail_sku')
							->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
							->whereIn('tb_product.pro_brand',$access_brand_id)
							->where('tb_order.payment_status',2)
							->whereDate('tb_order_payment.created_at', Carbon::today())
							->groupBy('tb_order.id')
							->sum('tb_order.totalCart');
			
			$orderWait = TbOrder::leftjoin('tb_order_detail','tb_order.id','tb_order_detail.orderId')
							->leftjoin('tb_product_detail','tb_order_detail.product_sku','tb_product_detail.detail_sku')
							->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
							->whereIn('tb_product.pro_brand',$access_brand_id)
							->where('tb_order.payment_status',2)
							->groupBy('tb_order.id')
							->sum('tb_order.totalCart');
							
			$orderList = TbOrder::leftjoin('tb_order_detail','tb_order.id','tb_order_detail.orderId')
							->leftjoin('tb_product_detail','tb_order_detail.product_sku','tb_product_detail.detail_sku')
							->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
							->whereIn('tb_product.pro_brand',$access_brand_id)
							->where('tb_order.payment_status',1)
							->groupBy('tb_order.id')
							->sum('tb_order.totalCart');
							
			$quotation = TbQuotation::leftjoin('tb_product_detail','tb_quotation.productSku','tb_product_detail.detail_sku')
								->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
								->whereIn('tb_product.pro_brand',$access_brand_id)
								->count(DB::raw('DISTINCT tb_quotation.id'));
		}else{
			$orderToday = TbOrder::leftjoin('tb_order_payment','tb_order_payment.orderId','tb_order.id')
						->where('tb_order.payment_status',2)
						->whereDate('tb_order_payment.created_at', Carbon::today())
						->sum('tb_order.totalCart');
			$orderWait = TbOrder::where('payment_status',2)->sum('totalCart');
			$orderList = TbOrder::where('payment_status',1)->sum('totalCart');
			$quotation = TbQuotation::count();
		}
        

        return view('admin.dashboard',[
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'orderToday' => $orderToday,
            'orderWait' => $orderWait,
            'orderList' => $orderList,
            'quotation' => $quotation,
        ]);
    }
	*/
	public function index()
    {

        $data['breadcrumb'] = [
            ['name' => 'Dashboard'],
        ];
        $data['title_page'] = 'Dashboard';
		
		// check access brand
		$current_user = Auth::user();
		$access_brand_id = $current_user->access_brand_id;
		
		if(!empty($access_brand_id)){
			
			if(strpos($access_brand_id, ',')){
				$access_brand_id = explode(',',trim($access_brand_id));
			}else{
				$access_brand_id = [$access_brand_id];
			}
			
			$data['orderToday'] = TbOrder::selectRaw('
										COUNT(tb_order.id) AS order_today, 
										SUM(tb_order.totalCart) AS value_today
									')
									->leftjoin('tb_order_detail','tb_order.id','tb_order_detail.orderId')
									->leftjoin('tb_product_detail','tb_order_detail.product_sku','tb_product_detail.detail_sku')
									->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
									->whereIn('tb_product.pro_brand',$access_brand_id)
									->whereDate('tb_order.created_at', Carbon::today())
									->first();
							
			$data['quotationToday'] = TbQuotation::selectRaw('
											COUNT(tb_quotation.id) AS q_today, 
											SUM(tb_quotation.productTotal) AS q_value_today
										')
										->leftjoin('tb_product_detail','tb_quotation.productSku','tb_product_detail.detail_sku')
										->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
										->whereIn('tb_product.pro_brand',$access_brand_id)
										->whereDate('tb_quotation.created_at', Carbon::today())
										->first();
								
			$data['orderStatus'] = TbOrder::selectRaw('
											tb_setting_payment_status.status_name,
											COUNT(DISTINCT tb_order.id) AS count_order,
											SUM(tb_order.totalCart) AS total_price
										')
										->leftJoin('tb_setting_payment_status', 'tb_order.payment_status', '=', 'tb_setting_payment_status.id')
										->leftjoin('tb_order_detail','tb_order.id','tb_order_detail.orderId')
										->leftjoin('tb_product_detail','tb_order_detail.product_sku','tb_product_detail.detail_sku')
										->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
										->whereIn('tb_product.pro_brand',$access_brand_id)
										->whereYear('tb_order.created_at', date('Y'))
										->groupBy('tb_setting_payment_status.status_name')
										->orderBy('tb_setting_payment_status.rank', 'ASC')
										->get();
										
				$orderValueCurrentYear = TbOrder::selectRaw('
											SUM(CASE WHEN MONTH(tb_order.created_at) = 1 THEN tb_order.totalCart ELSE 0 END) AS total_order_value_1,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 2 THEN tb_order.totalCart ELSE 0 END) AS total_order_value_2,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 3 THEN tb_order.totalCart ELSE 0 END) AS total_order_value_3,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 4 THEN tb_order.totalCart ELSE 0 END) AS total_order_value_4,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 5 THEN tb_order.totalCart ELSE 0 END) AS total_order_value_5,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 6 THEN tb_order.totalCart ELSE 0 END) AS total_order_value_6,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 7 THEN tb_order.totalCart ELSE 0 END) AS total_order_value_7,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 8 THEN tb_order.totalCart ELSE 0 END) AS total_order_value_8,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 9 THEN tb_order.totalCart ELSE 0 END) AS total_order_value_9,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 10 THEN tb_order.totalCart ELSE 0 END) AS total_order_value_10,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 11 THEN tb_order.totalCart ELSE 0 END) AS total_order_value_11,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 12 THEN tb_order.totalCart ELSE 0 END) AS total_order_value_12
										')
										->leftJoin('tb_setting_payment_status', 'tb_order.payment_status', '=', 'tb_setting_payment_status.id')
										->leftjoin('tb_order_detail','tb_order.id','tb_order_detail.orderId')
										->leftjoin('tb_product_detail','tb_order_detail.product_sku','tb_product_detail.detail_sku')
										->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
										->whereIn('tb_product.pro_brand',$access_brand_id)
										->whereYear('tb_order.created_at', date('Y'))
										->where('tb_setting_payment_status.status_value', '=', 1) // เงื่อนไข status_value = 1
										->first();
							
			$data['monthlySalesCurrent'] = [];
			for ($i = 1; $i <= 12; $i++) {
				$data['monthlySalesCurrent'][] = $orderValueCurrentYear ->{'total_order_value_' . $i};
			}
			
			// ข้อมูลยอดขายรายเดือนปีที่แล้ว
			$orderValuePreviousYear = TbOrder::selectRaw('
											SUM(CASE WHEN MONTH(tb_order.created_at) = 1 THEN tb_order.totalCart ELSE 0 END) AS total_order_value_1,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 2 THEN tb_order.totalCart ELSE 0 END) AS total_order_value_2,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 3 THEN tb_order.totalCart ELSE 0 END) AS total_order_value_3,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 4 THEN tb_order.totalCart ELSE 0 END) AS total_order_value_4,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 5 THEN tb_order.totalCart ELSE 0 END) AS total_order_value_5,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 6 THEN tb_order.totalCart ELSE 0 END) AS total_order_value_6,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 7 THEN tb_order.totalCart ELSE 0 END) AS total_order_value_7,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 8 THEN tb_order.totalCart ELSE 0 END) AS total_order_value_8,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 9 THEN tb_order.totalCart ELSE 0 END) AS total_order_value_9,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 10 THEN tb_order.totalCart ELSE 0 END) AS total_order_value_10,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 11 THEN tb_order.totalCart ELSE 0 END) AS total_order_value_11,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 12 THEN tb_order.totalCart ELSE 0 END) AS total_order_value_12
										')
										->leftJoin('tb_setting_payment_status', 'tb_order.payment_status', '=', 'tb_setting_payment_status.id')
										->leftjoin('tb_order_detail','tb_order.id','tb_order_detail.orderId')
										->leftjoin('tb_product_detail','tb_order_detail.product_sku','tb_product_detail.detail_sku')
										->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
										->whereIn('tb_product.pro_brand',$access_brand_id)
										->whereYear('tb_order.created_at', date('Y') - 1)
										->where('tb_setting_payment_status.status_value', '=', 1) // เงื่อนไข status_value = 1
										->first();

			$data['monthlySalesPrevious'] = [];
			for ($i = 1; $i <= 12; $i++) {
				$data['monthlySalesPrevious'][] = $orderValuePreviousYear->{'total_order_value_' . $i};
			}
			
			// คำนวณเปอร์เซ็นต์ Growth
			$data['monthlyGrowth'] = [];
			for ($i = 0; $i < 12; $i++) {
				if ($data['monthlySalesPrevious'][$i] > 0) {
					$data['monthlyGrowth'][] = (($data['monthlySalesCurrent'][$i] - $data['monthlySalesPrevious'][$i]) / $data['monthlySalesPrevious'][$i]) * 100;
				} else {
					$data['monthlyGrowth'][] = null; // ไม่มีข้อมูลเปรียบเทียบ
				}
			}
			
			$data['totalSalesCurrent'] = array_sum($data['monthlySalesCurrent']); // รวมยอดขายปีปัจจุบัน
			$data['totalSalesPrevious'] = array_sum($data['monthlySalesPrevious']); // รวมยอดขายปีที่แล้ว

			$data['totalGrowth'] = null;
			// คำนวณการเติบโตทั้งหมด
			if ($data['totalSalesPrevious'] > 0) {
				$data['totalGrowth'] = (($data['totalSalesCurrent'] - $data['totalSalesPrevious']) / $data['totalSalesPrevious']) * 100;
			}
			
			// จำนวน ออเดอร์
			$orderCurrentYear = TbOrder::selectRaw('
											SUM(CASE WHEN MONTH(tb_order.created_at) = 1 THEN 1 ELSE 0 END) AS total_order_1,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 2 THEN 1 ELSE 0 END) AS total_order_2,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 3 THEN 1 ELSE 0 END) AS total_order_3,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 4 THEN 1 ELSE 0 END) AS total_order_4,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 5 THEN 1 ELSE 0 END) AS total_order_5,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 6 THEN 1 ELSE 0 END) AS total_order_6,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 7 THEN 1 ELSE 0 END) AS total_order_7,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 8 THEN 1 ELSE 0 END) AS total_order_8,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 9 THEN 1 ELSE 0 END) AS total_order_9,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 10 THEN 1 ELSE 0 END) AS total_order_10,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 11 THEN 1 ELSE 0 END) AS total_order_11,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 12 THEN 1 ELSE 0 END) AS total_order_12
										')
										->leftJoin('tb_setting_payment_status', 'tb_order.payment_status', '=', 'tb_setting_payment_status.id')
										->leftjoin('tb_order_detail','tb_order.id','tb_order_detail.orderId')
										->leftjoin('tb_product_detail','tb_order_detail.product_sku','tb_product_detail.detail_sku')
										->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
										->whereIn('tb_product.pro_brand',$access_brand_id)
										->whereYear('tb_order.created_at', date('Y'))
										->where('tb_setting_payment_status.status_value', '=', 1) // เงื่อนไข status_value = 1
										->first();
							
			$data['monthlyOrderCurrent'] = [];
			for ($i = 1; $i <= 12; $i++) {
				$data['monthlyOrderCurrent'][] = $orderCurrentYear ->{'total_order_' . $i};
			}
			
			// ข้อมูลยอดขายรายเดือนปีที่แล้ว
			$orderPreviousYear = TbOrder::selectRaw('
											SUM(CASE WHEN MONTH(tb_order.created_at) = 1 THEN 1 ELSE 0 END) AS total_order_1,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 2 THEN 1 ELSE 0 END) AS total_order_2,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 3 THEN 1 ELSE 0 END) AS total_order_3,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 4 THEN 1 ELSE 0 END) AS total_order_4,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 5 THEN 1 ELSE 0 END) AS total_order_5,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 6 THEN 1 ELSE 0 END) AS total_order_6,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 7 THEN 1 ELSE 0 END) AS total_order_7,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 8 THEN 1 ELSE 0 END) AS total_order_8,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 9 THEN 1 ELSE 0 END) AS total_order_9,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 10 THEN 1 ELSE 0 END) AS total_order_10,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 11 THEN 1 ELSE 0 END) AS total_order_11,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 12 THEN 1 ELSE 0 END) AS total_order_12
										')
										->leftJoin('tb_setting_payment_status', 'tb_order.payment_status', '=', 'tb_setting_payment_status.id')
										->leftjoin('tb_order_detail','tb_order.id','tb_order_detail.orderId')
										->leftjoin('tb_product_detail','tb_order_detail.product_sku','tb_product_detail.detail_sku')
										->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
										->whereIn('tb_product.pro_brand',$access_brand_id)
										->whereYear('tb_order.created_at', date('Y') - 1)
										->where('tb_setting_payment_status.status_value', '=', 1) // เงื่อนไข status_value = 1
										->first();

			$data['monthlyOrderPrevious'] = [];
			for ($i = 1; $i <= 12; $i++) {
				$data['monthlyOrderPrevious'][] = $orderPreviousYear->{'total_order_' . $i};
			}
			
			// คำนวณเปอร์เซ็นต์ Growth
			$data['monthlyOrderGrowth'] = [];
			for ($i = 0; $i < 12; $i++) {
				if ($data['monthlyOrderPrevious'][$i] > 0) {
					$data['monthlyOrderGrowth'][] = (($data['monthlyOrderCurrent'][$i] - $data['monthlyOrderPrevious'][$i]) / $data['monthlyOrderPrevious'][$i]) * 100;
				} else {
					$data['monthlyOrderGrowth'][] = null; // ไม่มีข้อมูลเปรียบเทียบ
				}
			}
			
			$data['totalOrderCurrent'] = array_sum($data['monthlyOrderCurrent']); // รวมยอดขายปีปัจจุบัน
			$data['totalOrderPrevious'] = array_sum($data['monthlyOrderPrevious']); // รวมยอดขายปีที่แล้ว

			$data['totalOrderGrowth'] = null;
			// คำนวณการเติบโตทั้งหมด
			if ($data['totalOrderPrevious'] > 0) {
				$data['totalOrderGrowth'] = (($data['totalOrderCurrent'] - $data['totalOrderPrevious']) / $data['totalOrderPrevious']) * 100;
			}
			
			// 10 อันดับสินค้าขายดี
			$data['topProducts'] = TbOrder::selectRaw('
													tb_order_detail.product_name,
													SUM(tb_order_detail.product_unit) AS count_qty
												')
												->leftJoin('tb_order_detail', 'tb_order.id', '=', 'tb_order_detail.orderId')
												->leftJoin('tb_setting_payment_status', 'tb_order.payment_status', '=', 'tb_setting_payment_status.id')
												->leftjoin('tb_product_detail','tb_order_detail.product_sku','tb_product_detail.detail_sku')
												->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
												->whereIn('tb_product.pro_brand',$access_brand_id)
												->whereYear('tb_order.created_at', '=', date('Y')) // ใช้ปีปัจจุบัน
												->where('tb_setting_payment_status.status_value', '=', 1) // เงื่อนไขสถานะ
												->groupBy('tb_order_detail.product_name')
												->orderBy('count_qty', 'DESC') // เรียงลำดับจากมากไปน้อย
												->limit(10) // จำกัดผลลัพธ์ 10 รายการ
												->get();
												
			$data['topSellingProducts'] = TbOrder::selectRaw('
													tb_order_detail.product_name,
													SUM(tb_order_detail.product_price_total) AS sum_product_price_total
												')
												->leftJoin('tb_order_detail', 'tb_order.id', '=', 'tb_order_detail.orderId')
												->leftJoin('tb_setting_payment_status', 'tb_order.payment_status', '=', 'tb_setting_payment_status.id')
												->leftjoin('tb_product_detail','tb_order_detail.product_sku','tb_product_detail.detail_sku')
												->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
												->whereIn('tb_product.pro_brand',$access_brand_id)
												->whereYear('tb_order.created_at', '=', date('Y')) // ใช้ปีปัจจุบัน
												->where('tb_setting_payment_status.status_value', '=', 1) // เงื่อนไขสถานะ
												->groupBy('tb_order_detail.product_name')
												->orderBy('sum_product_price_total', 'DESC') // เรียงลำดับจากยอดขายรวมมากไปน้อย
												->limit(10) // จำกัดผลลัพธ์ 10 รายการ
												->get();
			
		}else{
			$data['orderToday'] = TbOrder::selectRaw('
								COUNT(tb_order.id) AS order_today, 
								SUM(tb_order.totalCart) AS value_today
							')
							->whereDate('tb_order.created_at', Carbon::today())
							->first();
							
			$data['quotationToday'] = TbQuotation::selectRaw('
									COUNT(tb_quotation.id) AS q_today, 
									SUM(tb_quotation.productTotal) AS q_value_today
								')
								->whereDate('tb_quotation.created_at', Carbon::today())
								->first();
								
			$data['orderStatus'] = TbOrder::selectRaw('
									tb_setting_payment_status.status_name,
									COUNT(DISTINCT tb_order.id) AS count_order,
									SUM(tb_order.totalCart) AS total_price
								')
								->leftJoin('tb_setting_payment_status', 'tb_order.payment_status', '=', 'tb_setting_payment_status.id')
								->whereYear('tb_order.created_at', date('Y'))
								->groupBy('tb_setting_payment_status.status_name')
								->orderBy('tb_setting_payment_status.rank', 'ASC')
								->get();
								
			$orderValueCurrentYear = TbOrder::selectRaw('
											SUM(CASE WHEN MONTH(tb_order.created_at) = 1 THEN tb_order.totalCart ELSE 0 END) AS total_order_value_1,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 2 THEN tb_order.totalCart ELSE 0 END) AS total_order_value_2,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 3 THEN tb_order.totalCart ELSE 0 END) AS total_order_value_3,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 4 THEN tb_order.totalCart ELSE 0 END) AS total_order_value_4,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 5 THEN tb_order.totalCart ELSE 0 END) AS total_order_value_5,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 6 THEN tb_order.totalCart ELSE 0 END) AS total_order_value_6,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 7 THEN tb_order.totalCart ELSE 0 END) AS total_order_value_7,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 8 THEN tb_order.totalCart ELSE 0 END) AS total_order_value_8,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 9 THEN tb_order.totalCart ELSE 0 END) AS total_order_value_9,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 10 THEN tb_order.totalCart ELSE 0 END) AS total_order_value_10,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 11 THEN tb_order.totalCart ELSE 0 END) AS total_order_value_11,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 12 THEN tb_order.totalCart ELSE 0 END) AS total_order_value_12
										')
										->leftJoin('tb_setting_payment_status', 'tb_order.payment_status', '=', 'tb_setting_payment_status.id')
										->whereYear('tb_order.created_at', date('Y'))
										->where('tb_setting_payment_status.status_value', '=', 1) // เงื่อนไข status_value = 1
										->first();
							
			$data['monthlySalesCurrent'] = [];
			for ($i = 1; $i <= 12; $i++) {
				$data['monthlySalesCurrent'][] = $orderValueCurrentYear ->{'total_order_value_' . $i};
			}
			
			// ข้อมูลยอดขายรายเดือนปีที่แล้ว
			$orderValuePreviousYear = TbOrder::selectRaw('
											SUM(CASE WHEN MONTH(tb_order.created_at) = 1 THEN tb_order.totalCart ELSE 0 END) AS total_order_value_1,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 2 THEN tb_order.totalCart ELSE 0 END) AS total_order_value_2,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 3 THEN tb_order.totalCart ELSE 0 END) AS total_order_value_3,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 4 THEN tb_order.totalCart ELSE 0 END) AS total_order_value_4,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 5 THEN tb_order.totalCart ELSE 0 END) AS total_order_value_5,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 6 THEN tb_order.totalCart ELSE 0 END) AS total_order_value_6,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 7 THEN tb_order.totalCart ELSE 0 END) AS total_order_value_7,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 8 THEN tb_order.totalCart ELSE 0 END) AS total_order_value_8,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 9 THEN tb_order.totalCart ELSE 0 END) AS total_order_value_9,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 10 THEN tb_order.totalCart ELSE 0 END) AS total_order_value_10,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 11 THEN tb_order.totalCart ELSE 0 END) AS total_order_value_11,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 12 THEN tb_order.totalCart ELSE 0 END) AS total_order_value_12
										')
										->leftJoin('tb_setting_payment_status', 'tb_order.payment_status', '=', 'tb_setting_payment_status.id')
										->whereYear('tb_order.created_at', date('Y') - 1)
										->where('tb_setting_payment_status.status_value', '=', 1) // เงื่อนไข status_value = 1
										->first();

			$data['monthlySalesPrevious'] = [];
			for ($i = 1; $i <= 12; $i++) {
				$data['monthlySalesPrevious'][] = $orderValuePreviousYear->{'total_order_value_' . $i};
			}
			
			// คำนวณเปอร์เซ็นต์ Growth
			$data['monthlyGrowth'] = [];
			for ($i = 0; $i < 12; $i++) {
				if ($data['monthlySalesPrevious'][$i] > 0) {
					$data['monthlyGrowth'][] = (($data['monthlySalesCurrent'][$i] - $data['monthlySalesPrevious'][$i]) / $data['monthlySalesPrevious'][$i]) * 100;
				} else {
					$data['monthlyGrowth'][] = null; // ไม่มีข้อมูลเปรียบเทียบ
				}
			}
			
			$data['totalSalesCurrent'] = array_sum($data['monthlySalesCurrent']); // รวมยอดขายปีปัจจุบัน
			$data['totalSalesPrevious'] = array_sum($data['monthlySalesPrevious']); // รวมยอดขายปีที่แล้ว

			$data['totalGrowth'] = null;
			// คำนวณการเติบโตทั้งหมด
			if ($data['totalSalesPrevious'] > 0) {
				$data['totalGrowth'] = (($data['totalSalesCurrent'] - $data['totalSalesPrevious']) / $data['totalSalesPrevious']) * 100;
			}
			
			// จำนวน ออเดอร์
			$orderCurrentYear = TbOrder::selectRaw('
											SUM(CASE WHEN MONTH(tb_order.created_at) = 1 THEN 1 ELSE 0 END) AS total_order_1,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 2 THEN 1 ELSE 0 END) AS total_order_2,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 3 THEN 1 ELSE 0 END) AS total_order_3,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 4 THEN 1 ELSE 0 END) AS total_order_4,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 5 THEN 1 ELSE 0 END) AS total_order_5,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 6 THEN 1 ELSE 0 END) AS total_order_6,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 7 THEN 1 ELSE 0 END) AS total_order_7,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 8 THEN 1 ELSE 0 END) AS total_order_8,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 9 THEN 1 ELSE 0 END) AS total_order_9,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 10 THEN 1 ELSE 0 END) AS total_order_10,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 11 THEN 1 ELSE 0 END) AS total_order_11,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 12 THEN 1 ELSE 0 END) AS total_order_12
										')
										->leftJoin('tb_setting_payment_status', 'tb_order.payment_status', '=', 'tb_setting_payment_status.id')
										->whereYear('tb_order.created_at', date('Y'))
										->where('tb_setting_payment_status.status_value', '=', 1) // เงื่อนไข status_value = 1
										->first();
							
			$data['monthlyOrderCurrent'] = [];
			for ($i = 1; $i <= 12; $i++) {
				$data['monthlyOrderCurrent'][] = $orderCurrentYear ->{'total_order_' . $i};
			}
			
			// ข้อมูลยอดขายรายเดือนปีที่แล้ว
			$orderPreviousYear = TbOrder::selectRaw('
											SUM(CASE WHEN MONTH(tb_order.created_at) = 1 THEN 1 ELSE 0 END) AS total_order_1,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 2 THEN 1 ELSE 0 END) AS total_order_2,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 3 THEN 1 ELSE 0 END) AS total_order_3,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 4 THEN 1 ELSE 0 END) AS total_order_4,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 5 THEN 1 ELSE 0 END) AS total_order_5,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 6 THEN 1 ELSE 0 END) AS total_order_6,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 7 THEN 1 ELSE 0 END) AS total_order_7,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 8 THEN 1 ELSE 0 END) AS total_order_8,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 9 THEN 1 ELSE 0 END) AS total_order_9,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 10 THEN 1 ELSE 0 END) AS total_order_10,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 11 THEN 1 ELSE 0 END) AS total_order_11,
											SUM(CASE WHEN MONTH(tb_order.created_at) = 12 THEN 1 ELSE 0 END) AS total_order_12
										')
										->leftJoin('tb_setting_payment_status', 'tb_order.payment_status', '=', 'tb_setting_payment_status.id')
										->whereYear('tb_order.created_at', date('Y') - 1)
										->where('tb_setting_payment_status.status_value', '=', 1) // เงื่อนไข status_value = 1
										->first();

			$data['monthlyOrderPrevious'] = [];
			for ($i = 1; $i <= 12; $i++) {
				$data['monthlyOrderPrevious'][] = $orderPreviousYear->{'total_order_' . $i};
			}
			
			// คำนวณเปอร์เซ็นต์ Growth
			$data['monthlyOrderGrowth'] = [];
			for ($i = 0; $i < 12; $i++) {
				if ($data['monthlyOrderPrevious'][$i] > 0) {
					$data['monthlyOrderGrowth'][] = (($data['monthlyOrderCurrent'][$i] - $data['monthlyOrderPrevious'][$i]) / $data['monthlyOrderPrevious'][$i]) * 100;
				} else {
					$data['monthlyOrderGrowth'][] = null; // ไม่มีข้อมูลเปรียบเทียบ
				}
			}
			
			$data['totalOrderCurrent'] = array_sum($data['monthlyOrderCurrent']); // รวมยอดขายปีปัจจุบัน
			$data['totalOrderPrevious'] = array_sum($data['monthlyOrderPrevious']); // รวมยอดขายปีที่แล้ว

			$data['totalOrderGrowth'] = null;
			// คำนวณการเติบโตทั้งหมด
			if ($data['totalOrderPrevious'] > 0) {
				$data['totalOrderGrowth'] = (($data['totalOrderCurrent'] - $data['totalOrderPrevious']) / $data['totalOrderPrevious']) * 100;
			}
			
			// 10 อันดับสินค้าขายดี
			$data['topProducts'] = TbOrder::selectRaw('
													tb_order_detail.product_name,
													SUM(tb_order_detail.product_unit) AS count_qty
												')
												->leftJoin('tb_order_detail', 'tb_order.id', '=', 'tb_order_detail.orderId')
												->leftJoin('tb_setting_payment_status', 'tb_order.payment_status', '=', 'tb_setting_payment_status.id')
												->whereYear('tb_order.created_at', '=', date('Y')) // ใช้ปีปัจจุบัน
												->where('tb_setting_payment_status.status_value', '=', 1) // เงื่อนไขสถานะ
												->groupBy('tb_order_detail.product_name')
												->orderBy('count_qty', 'DESC') // เรียงลำดับจากมากไปน้อย
												->limit(10) // จำกัดผลลัพธ์ 10 รายการ
												->get();
												
			$data['topSellingProducts'] = TbOrder::selectRaw('
													tb_order_detail.product_name,
													SUM(tb_order_detail.product_price_total) AS sum_product_price_total
												')
												->leftJoin('tb_order_detail', 'tb_order.id', '=', 'tb_order_detail.orderId')
												->leftJoin('tb_setting_payment_status', 'tb_order.payment_status', '=', 'tb_setting_payment_status.id')
												->whereYear('tb_order.created_at', '=', date('Y')) // ใช้ปีปัจจุบัน
												->where('tb_setting_payment_status.status_value', '=', 1) // เงื่อนไขสถานะ
												->groupBy('tb_order_detail.product_name')
												->orderBy('sum_product_price_total', 'DESC') // เรียงลำดับจากยอดขายรวมมากไปน้อย
												->limit(10) // จำกัดผลลัพธ์ 10 รายการ
												->get();
		}

        return view('admin.dashboard2',$data);
    }

    public function jsonQuotation(){
		
		// check access brand
		$current_user = Auth::user();
		$access_brand_id = $current_user->access_brand_id;
		
		if(!empty($access_brand_id)){
			
			if(strpos($access_brand_id, ',')){
				$access_brand_id = explode(',',trim($access_brand_id));
			}else{
				$access_brand_id = [$access_brand_id];
			}
			
			$response[] = array(
				'type1'  =>$quotation = TbQuotation::leftjoin('tb_product_detail','tb_quotation.productSku','tb_product_detail.detail_sku')
								->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
								->whereIn('tb_product.pro_brand',$access_brand_id)
								->where('type', 1)
								->count(DB::raw('DISTINCT tb_quotation.id')),
				'type2' =>$quotation = TbQuotation::leftjoin('tb_product_detail','tb_quotation.productSku','tb_product_detail.detail_sku')
								->leftjoin('tb_product','tb_product_detail.proId','tb_product.id')
								->whereIn('tb_product.pro_brand',$access_brand_id)
								->where('type', 2)
								->count(DB::raw('DISTINCT tb_quotation.id')),
			);
		}else{
			$response[] = array(
				'type1'  =>TbQuotation::where('type', 1)->count(),
				'type2' =>TbQuotation::where('type', 2)->count(),
			);
		}

        
        return $response;

    }

    public function LogoutAdmin()
    {
        Auth::logout();
        return redirect()->route('administrator');
    }
}
