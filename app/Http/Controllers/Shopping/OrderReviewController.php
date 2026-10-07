<?php

namespace App\Http\Controllers\Shopping;

use Carbon\Carbon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

use App\Models\TbSetting;
use App\Models\TbOrder;
use App\Models\TbOrderDetail;
use App\Models\HistoryOrderStatus;
use App\Models\HistorySendMail;
use App\Models\User;
use App\Models\TbPagesMap;
use App\Models\TbProduct;
use App\Models\TbProductDetail;
use App\Models\Review;
use App\Models\ReviewImage;
use Yajra\Datatables\Datatables;

class OrderReviewController extends Controller
{

    public function reviewOrder($order_number){

        if(!empty($order_number)){
			
			$products = TbOrder::select('*', 'users.id AS user_id')
							->leftJoin('users', 'users.user_code', '=', 'tb_order.userCode')
							->leftJoin('tb_order_detail', 'tb_order_detail.orderId', '=', 'tb_order.id')
							->leftJoin('tb_product_detail', function($join) {
								$join->on('tb_product_detail.detail_sku', '=', 'tb_order_detail.product_sku');
							})
							->leftJoin('tb_product', 'tb_product.id', '=', 'tb_product_detail.proId')
							->leftJoin('reviews', function($join) {
								$join->on('reviews.order_id', '=', 'tb_order.id')
									 ->on('reviews.product_id', '=', 'tb_product.id');
							})
							->where('tb_order.orderNumber', 'LIKE', $order_number)
							->whereNull('reviews.id')
							->whereNotNull('tb_product.id')
							->where('tb_order.payment_status', 5) // เงื่อนไข payment_status = จัดส่งสินค้าแล้ว
							->where('tb_order.created_at', '>=', Carbon::now()->subDays(180)) // ดึงเฉพาะออเดอร์ที่ไม่เกิน 6 เดือน
							->groupBy('tb_product.id')
							->get();
											
		}else{
			
		}
		
		$breadcrumb = [
            ['route' => route('fronend.home'), 'name' => 'หน้าหลัก'],
            ['route' => '', 'name' => 'บริการช่วยเหลือ'],
        ];

        return view('fontend.orderReview', [
            'og_site_name' => '',
            'og_keywords' => '',
            'og_title' => 'บริการช่วยเหลือ',
            'og_description' => '',
            'og_url' => '',
            'og_image' => '',
            'breadcrumb' => $breadcrumb,
            'products' => $products,
        ]);

    }
	
	public function store(Request $request)
    {
        // กำหนดกฎการตรวจสอบ (Validation Rules)
        $rules = [
			'reviews' => 'required|array',
			'reviews.*.rating'      => 'required|numeric|min:1|max:5',
			'reviews.*.review_text' => 'nullable|string|max:200',
			'reviews.*.image'       => 'nullable|file|mimes:jpeg,png,jpg,gif|max:3072',   // 3MB
			'reviews.*.video'       => 'nullable|file|mimetypes:video/mp4,video/quicktime,video/x-msvideo,video/x-ms-wmv|max:10240', // 10MB
			'reviews.*.user_id'     => 'required|integer',
			'reviews.*.product_id'  => 'required|integer',
			'reviews.*.order_id'    => 'required|integer',
		];

		// กำหนดข้อความ (Custom Messages) สำหรับแต่ละ Rule
		$messages = [
			// สำหรับฟิลด์หลัก reviews
			'reviews.required' => 'รบกวนให้คะแนนก่อนนะคะ',
			'reviews.array'    => 'รูปแบบข้อมูลรีวิวไม่ถูกต้อง',

			// สำหรับ rating
			'reviews.*.rating.required' => 'รบกวนให้คะแนนก่อนนะคะ',
			'reviews.*.rating.numeric'  => 'รูปแบบคะแนนไม่ถูกต้อง',
			'reviews.*.rating.min'      => 'รบกวนให้คะแนนก่อนนะคะ',
			'reviews.*.rating.max'      => 'รบกวนให้คะแนนก่อนนะคะ',

			// สำหรับ review_text
			'reviews.*.review_text.max' => 'ข้อความรีวิวต้องไม่เกิน 200 ตัวอักษร',

			// สำหรับ image
			'reviews.*.image.file'   => 'ไฟล์รูปภาพไม่ถูกต้อง',
			'reviews.*.image.mimes'  => 'รบกวนอัพโหลดเป็นไฟล์ JPEG, PNG, JPG หรือ GIF',
			'reviews.*.image.max'    => 'ไฟล์รูปภาพขนาดสูงสุด 3MB',

			// สำหรับ video
			'reviews.*.video.file'       => 'ไฟล์วิดีโอไม่ถูกต้อง',
			'reviews.*.video.mimetypes'  => 'รบกวนอัพโหลดเป็นไฟล์ MP4, MOV, AVI หรือ WMV',
			'reviews.*.video.max'        => 'ไฟล์วิดีโอขนาดสูงสุด 10MB',

			// สำหรับ user_id, product_id, order_id
			'reviews.*.user_id.required'    => 'ไม่พบ user_id',
			'reviews.*.product_id.required' => 'ไม่พบ product_id',
			'reviews.*.order_id.required'   => 'ไม่พบ order_id',
		];
		
		$validatedData = $request->validate($rules, $messages);

        // วนลูปบันทึกแต่ละรีวิว
        foreach ($validatedData['reviews'] as $key => $reviewData) {
            $imagePath = null;
            $videoPath = null;

            // ตรวจสอบและสร้างโฟลเดอร์ reviews_images หากยังไม่มี
            if (!File::exists(public_path('reviews_images'))) {
                File::makeDirectory(public_path('reviews_images'), 0755, true);
            }

            // ตรวจสอบและสร้างโฟลเดอร์ reviews_videos หากยังไม่มี
            if (!File::exists(public_path('reviews_videos'))) {
                File::makeDirectory(public_path('reviews_videos'), 0755, true);
            }

            // ถ้ามีไฟล์รูปภาพ
            if (isset($reviewData['image']) && $reviewData['image']) {
                $imageFile = $reviewData['image'];
                $imageName = uniqid() . '.' . $imageFile->getClientOriginalExtension();
                // ย้ายไฟล์ไปยัง public/reviews_images
                $imageFile->move(public_path('reviews_images'), $imageName);
                // เก็บ path ไว้ในตัวแปร (อาจเก็บเป็น reviews_images/xxx.jpg)
                $imagePath = 'reviews_images/' . $imageName;
            }

            // ถ้ามีไฟล์วิดีโอ
            if (isset($reviewData['video']) && $reviewData['video']) {
                $videoFile = $reviewData['video'];
                $videoName = uniqid() . '.' . $videoFile->getClientOriginalExtension();
                // ย้ายไฟล์ไปยัง public/reviews_videos
                $videoFile->move(public_path('reviews_videos'), $videoName);
                // เก็บ path ไว้ในตัวแปร (อาจเก็บเป็น reviews_videos/xxx.mp4)
                $videoPath = 'reviews_videos/' . $videoName;
            }

            // บันทึกลงฐานข้อมูล
            Review::create([
                'user_id'         => $reviewData['user_id'],
                'product_id'      => $reviewData['product_id'],
                'order_id'        => $reviewData['order_id'],
                'rating'          => $reviewData['rating'],
                'review_text'     => $reviewData['review_text'] ?? null,
                'image_url'       => $imagePath,
                'video_url'       => $videoPath,
                'review_approved' => 'pending', // ค่าเริ่มต้น
            ]);
        }

        // กลับไปยังหน้าก่อนหน้า หรือหน้าอื่น ๆ ตามต้องการ
        return redirect()->back()->with('success', 'ขอบพระคุณสำหรับการรีวิว ทุกกำลังใจและคำติชม เราจะนำไปพัฒนาและปรับปรุงสินค้าและบริการให้ดียิ่งขึ้น');
    }
	
	public function index(Request $request)
    {

        $breadcrumb = [
            ['name' => 'Review จากลูกค้า'],
        ];
        $title_page = 'Review จากลูกค้า';
		
		$count_review = Review::count();
		
        return view('admin.review.main', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'count_review' => $count_review,
        ]);

    }
	
	public function jsondata(Request $request)
    {		
		$data = Review::select(
								'reviews.*',
								DB::raw("CONCAT(IFNULL(users.name, ''),' ', IFNULL(users.lastname, '')) AS review_by"),
								'tb_product.pro_name',
								'tb_product.pro_permalink',
								'tb_order.orderNumber',
								DB::raw("CONCAT(IFNULL(approver.name, ''), ' ', IFNULL(approver.lastname, '')) AS approver_by")
							)
							->join('users', 'reviews.user_id', '=', 'users.id')
							->join('tb_product', 'reviews.product_id', '=', 'tb_product.id')
							->join('tb_order', 'reviews.order_id', '=', 'tb_order.id')
							->leftJoin('users as approver', 'reviews.approval_id', '=', 'approver.id')
							->orderBy('reviews.id', 'desc')
							->get();
				
        return Datatables::of($data)
                ->addColumn('orderNumber', function ($data) {
                    return '<a href="'.route('order.view',$data->order_id).'" target="_bank">'.$data->orderNumber.'</a>';
                })
                ->addColumn('review_by', function ($data) {
                    return $data->review_by;
                })
                ->addColumn('product_name', function ($data) {
                    return '<a href="'.route('fronend.product.content',$data->pro_permalink).'" target="_bank">'.$data->pro_name.'</a>';
                })
                ->addColumn('rating', function ($data) {
					$star = '⭐';
					$txt_star = '';

					for ($i = 0; $i < $data->rating; $i++) {
						$txt_star .= $star;
					}

					return $txt_star . ' (' . $data->rating. ')';
                })
                ->addColumn('review_approved', function ($data) {
                    return $data->review_approved;
                })
                ->addColumn('actions', function ($data) {
                    return '
								<a href="#" class="review-detail" 
									data-id="'.$data->id.'"
									data-order="'.$data->orderNumber.'" 
									data-buyer="'.$data->review_by.'" 
									data-product="'.$data->pro_name.'" 
									data-rating="'.$data->rating.'" 
									data-review="'.htmlspecialchars($data->review_text, ENT_QUOTES, 'UTF-8').'" 
									data-image="/'.($data->image_url ?? '').'" 
									data-video="/'.($data->video_url ?? '').'"
									data-createdtime="'.date('d/m/Y H:i',strtotime($data->created_at)).'"
									data-approver="'.$data->approver_by.'" 
									data-lastapproved="'.date('d/m/Y H:i',strtotime($data->approval_at)).'" >
									🔎
								</a>
							';
                })
                ->escapeColumns([])
                ->addIndexColumn()
                ->make(true);
    }
	
	public function updateStatus(Request $request)
	{
		$request->validate([
			 'review_id' => 'required|integer',
			 'status'    => 'required|in:approved,rejected',
		]);

		$review = Review::find($request->review_id);
		if (!$review) {
			return response()->json(['message' => 'รีวิวไม่พบ'], 404);
		}
		
		$review->review_approved = $request->status;
		$review->approval_id = Auth::user()->id;
		$review->approval_at = time();
		$review->updated_at = time();
		$review->save();

		return response()->json(['message' => 'อัปเดตสถานะรีวิวเรียบร้อยแล้ว']);
	}



}
