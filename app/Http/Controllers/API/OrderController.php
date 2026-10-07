<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\TbSetting;
use App\Models\TbOrder;
use App\Models\HistoryOrderStatus;
use App\Models\HistorySendMail;
use App\Models\TbPagesMap;
use App\Models\TbExtension;
use App\Models\LogNotiOrder;

use App\Mail\orderNotify;
use App\Mail\orderReport;

class OrderController extends Controller
{

    //เปลี่ยนสถานะออเดอร์ที่ยังไม่ชำระเงินเกิน 7 วัน
    public function check_orderExpire(){

        $orders     = TbOrder::select('id','payment_status','updated_at')->where('payment_status',1)->get();

        foreach($orders as $order){

            $dr= $this->expdate($order->updated_at,7); //ส่งค่าให้ฟังก์ชั่น วันที่ปัจจุบัน พร้อมจำนวนวัน
            $df=date("Y-m-d",$dr); //จัดรูปแบบวันที่ก่อนแสดง

            if($df < date('Y-m-d')){

                //เปลี่ยนสถานะเป็นยกเลิกออเดอร์
                $orderUpdate                        = TbOrder::findOrFail($order->id);
                $orderUpdate->payment_status        = '3';
                $orderUpdate->save();

                $history = new HistoryOrderStatus();
                $history->orderNumber           = $orderUpdate->orderNumber;
                $history->order_status          = 'ยกเลิกคำสั่งซื้อโดยระบบ เนื่องจากเกินกำหนดการชำระเงิน';
                $history->updated_by            = 'SYSTEM';
                $history->updated_at            = date('Y-m-d H:i:s');
                $history->created_by            = 'SYSTEM';
                $history->created_at            = date('Y-m-d H:i:s');
                $history->save();

                $log = new LogNotiOrder();
                $log->orderNumber       = $orderUpdate->orderNumber;
                $log->orderMessage      = 'ยกเลิกคำสั่งซื้อโดยระบบ เนื่องจากเกินกำหนดการชำระเงิน';
                $log->orderReport       = 2;
                $log->save();

                $this->sendMail_orderExpire($order->id);

            }

        }

    }

    //แจ้งเตือนออเดอร์ที่ชำระเงินแล้ว ยังไม่มีการปรับสถานะเป็นชำระเงินสำเร็จ
    public function check_order_warning(){

        $orders     = TbOrder::select('id','orderNumber','staffOf','payment_status')->where('payment_status',1)->get();
        $extension  = TbExtension::first();
        foreach($orders as $order){

            if(!empty($order->staffOf)){
                $user  = User::select('name','lastname')->findOrFail($order->staffOf);
                if(!empty($user)){
                    $staff = $user->name.' '.$user->lastname;
                }else{
                    $staff = 'ยังไม่มีผู้รับผิดชอบ';
                }
            }else{
                $staff = 'ยังไม่มีผู้รับผิดชอบ';
            }

            if(!empty($extension)){
                if($extension->ext_lineNotify_status == 1){
                    if(!empty($extension->ext_lineNotify)){
                        $Token      = 'Bearer '.$extension->ext_lineNotify;
                        $Message    = "\n----------------------------------\nคำสั่งซื้อ : $order->orderNumber\nผู้รับผิดชอบ : $staff\nได้ชำระเงินแล้ว\n\n----------------------------------\nกรุณาตรวจสอบข้อมูล\nเพื่อดำเนินการต่อไป\n----------------------------------\nคลิกดูรายละเอียด ".route('order.view',['id'=>$order->id]);
                        $Id         = '';
                        $status     = 1;

                        $log = new LogNotiOrder();
                        $log->orderNumber       = $order->orderNumber;
                        $log->orderMessage      = 'คำสั่งซื้อหมายเลข : '.$order->orderNumber.' ได้ชำระเงินแล้ว<br/>ผู้รับผิดชอบ : '.$staff.'<br/><br/>กรุณาตรวจสอบข้อมูล เพื่อดำเนินการต่อไป<br/>คลิกดูรายละเอียด '.route('order.view',['id'=>$order->id]);
                        $log->orderReport       = 2;
                        $log->save();

                        $this->notify_message($Message,$Token,$Id,$status);
                    }
                }

            }

        }

    }

    //แจ้งเตือนออเดอร์ที่ชำระเงินแล้ว และยังไม่มีการจัดส่ง
    public function check_order_warning_transfer(){

        $orders     = TbOrder::select('id','orderNumber','staffOf','payment_status')->where('payment_status',2)->get();
        $extension  = TbExtension::first();

        foreach($orders as $order){

            if(!empty($order->staffOf)){
                $user  = User::select('name','lastname')->findOrFail($order->staffOf);
                if(!empty($user)){
                    $staff = $user->name.' '.$user->lastname;
                }else{
                    $staff = 'ยังไม่มีผู้รับผิดชอบ';
                }
            }else{
                $staff = 'ยังไม่มีผู้รับผิดชอบ';
            }

            if(!empty($extension)){
                if($extension->ext_lineNotify_status == 1){
                    if(!empty($extension->ext_lineNotify)){
                        $Token      = 'Bearer '.$extension->ext_lineNotify;
                        $Message    = "\n----------------------------------\nคำสั่งซื้อ : $order->orderNumber\nผู้รับผิดชอบ : $staff\nกำลังรอการจัดส่ง\n\n----------------------------------\nกรุณาตรวจสอบข้อมูล\nเพื่อดำเนินการต่อไป\n----------------------------------\nคลิกดูรายละเอียด ".route('order.view',['id'=>$order->id]);
                        $Id         = '';
                        $status     = 1;

                        $log = new LogNotiOrder();
                        $log->orderNumber       = $order->orderNumber;
                        $log->orderMessage      = 'คำสั่งซื้อหมายเลข : '.$order->orderNumber.' กำลังรอการจัดส่ง<br/>ผู้รับผิดชอบ : '.$staff.'<br/><br/>กรุณาตรวจสอบข้อมูล เพื่อดำเนินการต่อไป<br/>คลิกดูรายละเอียด '.route('order.view',['id'=>$order->id]);
                        $log->orderReport       = 2;
                        $log->save();

                        $this->notify_message($Message,$Token,$Id,$status);
                    }
                }

            }

        }

    }

    //ส่งรายงานไปยัง Email เพื่อเก็บข้อมูลการส่งแจ้งเตือน
    public function report_order(){


        $setting    = TbSetting::first();
        $page       = TbPagesMap::first();
        $logs       = LogNotiOrder::where('orderReport',2)->get();
        $user       = User::where('level',3)->get();

        if(count($logs) != 0){
            $data = new \stdClass();
            $data->setting_nameWeb  = $setting->setting_nameWeb;
            $data->setting_logoWeb  = $setting->setting_logoWeb;
            $data->page             = $page;
            $data->logs             = $logs;
            $data->i                = 1;

            if(!empty($user)){
                $email_dev = [];
                foreach($user as $dev){
                    $email_dev[] = $dev->email;
                }

				try{
					Mail::to($email_dev)->later(now()->addMinutes(5), new orderReport($data));
					
					if(Mail::failures()) { 
						$mailStatus = 'ล้มเหลว'; 
					}else{ 
						$mailStatus = 'สำเร็จ'; 

						$data     = LogNotiOrder::where('orderReport',2)->get();
						foreach($data as $log){
							$log                        = LogNotiOrder::findOrFail($log->id);
							$log->orderReport           = 1;
							$log->save();
						}
					}
				}catch(\Exception $e){
					// Never reached
					$mailStatus = 'ล้มเหลว';
				}
            }

            
        }

    }

    private function expdate($startdate,$datenum){

        $startdatec=strtotime($startdate); // ทำให้ข้อความเป็นวินาที
        $tod=$datenum*86400; // รับจำนวนวันมาคูณกับวินาทีต่อวัน
        $ndate=$startdatec+$tod; // นับบวกไปอีกตามจำนวนวันที่รับมา
        return $ndate; // ส่งค่ากลับ

    }

    private function sendMail_orderExpire($orderId){

        $setting = TbSetting::first();
        $page = TbPagesMap::first();
        $order = TbOrder::with(
            'tb_setting_payment_status',
            'tb_order_payments',
            'tb_order_details',
            'tb_setting_province',
            'tb_setting_amphure',
            'tb_setting_district',
            'tb_receipt_province',
            'tb_receipt_amphures',
            'tb_receipt_district',
            'tb_setting_transport'
        )
        ->findOrFail($orderId);
        $user = User::where('user_code',$order->userCode)->first();

        $data = new \stdClass();
        $data->setting_nameWeb = $setting->setting_nameWeb;
        $data->setting_logoWeb = $setting->setting_logoWeb;
        $data->order = $order;
        $data->page = $page;

        $mail_bcc = explode(",",$setting->setting_email_bcc);

        if(!empty($setting->setting_email_bcc)){
            
			try{
				Mail::to($user->email)->bcc($mail_bcc)->later(now()->addMinutes(5), new orderNotify($data));
				
				if(Mail::failures()) { $mailStatus = 'ล้มเหลว'; }else{ $mailStatus = 'สำเร็จ'; }
			}catch(\Exception $e){
				// Never reached
				$mailStatus = 'ล้มเหลว';
			}
        }else{
            
			try{
				Mail::to($user->email)->later(now()->addMinutes(5), new orderNotify($data));
				
				if(Mail::failures()) { $mailStatus = 'ล้มเหลว'; }else{ $mailStatus = 'สำเร็จ'; }
			}catch(\Exception $e){
				// Never reached
				$mailStatus = 'ล้มเหลว';
			}
        }
		
        $history                            = new HistorySendMail();
        $history->userId                    = $user->id;
        $history->remark                    = "อัพเดตสถานะ ".$order->orderNumber;
        $history->status                    = $mailStatus;
        $history->created_by                = 'SYSTEM';
        $history->created_at                = date('Y-m-d H:i:s');
        $history->updated_at                = date('Y-m-d H:i:s');
        $history->save();

    }

    private function notify_message($Message,$Token,$Id,$status) {
        date_default_timezone_set("Asia/Bangkok");
        $chOne = curl_init();
        curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
        curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt( $chOne, CURLOPT_POST, 1);
        curl_setopt( $chOne, CURLOPT_POSTFIELDS, "&message=".$Message);
        $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: '.$Token.'', );
        curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
        curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec( $chOne );

        //Result error
        if(curl_error($chOne))
        {
            echo 'error:' . curl_error($chOne);
        }
        else {
            $result_ = json_decode($result, true);
            echo "status : ".$result_['status']; 
            echo "message : ". $result_['message'];
            echo '<pre></pre>';
        }
        curl_close( $chOne );

        // return $chOne;
    }

}
