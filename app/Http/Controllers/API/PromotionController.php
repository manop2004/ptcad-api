<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\HistoryCalandar;
use App\Models\TbPromotionSettingLinenotify;

class PromotionController extends Controller
{

    //แจ้งเตือนโปรโมชั่น ผ่าน line notify
    public function check_linenotify_promotion(){

        $groupGet = TbPromotionSettingLinenotify::select('id','groupname','token_linenotify','grouptype1','grouptype2','show')
        ->where('show',1)
        ->get();

        //วันที่ปัจจุบัน
        $chk_day_now    = time();

        if(count($groupGet) != 0){
            foreach($groupGet as $group){
                if($group->grouptype1 == 1){

                    $notify = HistoryCalandar::with('tb_promotion_calendar')->where('groupType',1)->where('show',1)->get();
                    if(count($notify) != 0){
                        foreach($notify as $promotion){

                            $promotion_name = $this->rewrite($promotion->tb_promotion_calendar->promo_name);

                            if(!empty($promotion->tb_promotion_calendar->promo_start_date)){

                                if($promotion->tb_promotion_calendar->promo_type == 1){

                                    $chk_exp_day_start      = strtotime($promotion->tb_promotion_calendar->promo_start_date." -1 day");
                                    $date_exp               = date("d-m-Y",strtotime($promotion->tb_promotion_calendar->promo_start_date));
                                    $status_exp             = '1';
                                    if($promotion->send_status_startDate == 2){

                                        if($chk_day_now >= $chk_exp_day_start){

                                            $Token = 'Bearer '.$promotion->token_notify;
                                            $Message    = "\n\n$promotion_name\n\nกำลังจะเริ่มในวันที่ $date_exp\n\n ดูรายละเอียดเพิ่มเติม : ".route('fronend.preview.promotion',['id'=>$promotion->promotionId]);
                                            $this->notify_message($Message,$Token,$promotion->id,$status_exp);

                                        }
                                    }
                                }else{
                                    $chk_exp_day_start      = strtotime($promotion->tb_promotion_calendar->promo_start_date." -1 day");
                                    $date_exp               = date("d-m-Y",strtotime($promotion->tb_promotion_calendar->promo_start_date));
                                    $status_exp             = '1';
                                    if($promotion->send_status_startDate == 2){

                                        if($chk_day_now >= $chk_exp_day_start){

                                            $Token = 'Bearer '.$promotion->token_notify;
                                            $Message    = "\n\n$promotion_name\n\n\n ดูรายละเอียดเพิ่มเติม : ".route('fronend.preview.promotion',['id'=>$promotion->promotionId]);
                                            $this->notify_message($Message,$Token,$promotion->id,$status_exp);

                                        }
                                    }
                                }


                            }

                            if($promotion->tb_promotion_calendar->promo_end_date_status == 2){
                                if(!empty($promotion->tb_promotion_calendar->promo_end_date)){

                                    $chk_exp_day_end        = strtotime($promotion->tb_promotion_calendar->promo_end_date." -1 day");
                                    $date_exp               = date("d-m-Y",strtotime($promotion->tb_promotion_calendar->promo_end_date));
                                    $status_exp             = '2';
                                    if($promotion->send_status_EndDate == 2){

                                        if($chk_day_now >= $chk_exp_day_end){

                                            $Token = 'Bearer '.$promotion->token_notify;
                                            $Message    = "\n\n$promotion_name\n\nกำลังจะสิ้นสุดลงในวันที่ $date_exp\n\n ดูรายละเอียดเพิ่มเติม : ".route('fronend.preview.promotion',['id'=>$promotion->promotionId]);
                                            $this->notify_message($Message,$Token,$promotion->id,$status_exp);

                                        }
                                    }
                                }
                            }

                        }
                    }

                }else{

                    $notify = HistoryCalandar::with('tb_promotion_calendar')->where('groupType',2)->where('show',1)->get();
                    if(count($notify) != 0){
                        foreach($notify as $promotion){

                            $promotion_name = $this->rewrite($promotion->tb_promotion_calendar->promo_name);

                            if(!empty($promotion->tb_promotion_calendar->promo_start_date)){

                                if($promotion->tb_promotion_calendar->promo_type == 1){

                                    $chk_exp_day_start      = strtotime($promotion->tb_promotion_calendar->promo_start_date." -1 day");
                                    $date_exp               = date("d-m-Y",strtotime($promotion->tb_promotion_calendar->promo_start_date));
                                    $status_exp             = '1';
                                    if($promotion->send_status_startDate == 2){

                                        if($chk_day_now >= $chk_exp_day_start){

                                            $Token = 'Bearer '.$promotion->token_notify;
                                            $Message    = "\n\n$promotion_name\n\nกำลังจะเริ่มในวันที่ $date_exp\n\n ดูรายละเอียดเพิ่มเติม : ".route('fronend.preview.promotion',['id'=>$promotion->promotionId]);
                                            $this->notify_message($Message,$Token,$promotion->id,$status_exp);

                                        }
                                    }
                                }else{
                                    $chk_exp_day_start      = strtotime($promotion->tb_promotion_calendar->promo_start_date." -1 day");
                                    $date_exp               = date("d-m-Y",strtotime($promotion->tb_promotion_calendar->promo_start_date));
                                    $status_exp             = '1';
                                    if($promotion->send_status_startDate == 2){

                                        if($chk_day_now >= $chk_exp_day_start){

                                            $Token = 'Bearer '.$promotion->token_notify;
                                            $Message    = "\n\n$promotion_name\n\n\n ดูรายละเอียดเพิ่มเติม : ".route('fronend.preview.promotion',['id'=>$promotion->promotionId]);
                                            $this->notify_message($Message,$Token,$promotion->id,$status_exp);

                                        }
                                    }
                                }
                            }

                            if($promotion->tb_promotion_calendar->promo_end_date_status == 2){
                                if(!empty($promotion->tb_promotion_calendar->promo_end_date)){

                                    $chk_exp_day_end        = strtotime($promotion->tb_promotion_calendar->promo_end_date." -1 day");
                                    $date_exp               = date("d-m-Y",strtotime($promotion->tb_promotion_calendar->promo_end_date));
                                    $status_exp             = '2';
                                    if($promotion->send_status_EndDate == 2){

                                        if($chk_day_now >= $chk_exp_day_end){

                                            $Token = 'Bearer '.$promotion->token_notify;
                                            $Message    = "\n\n$promotion_name\n\nกำลังจะสิ้นสุดลงในวันที่ $date_exp\n\n ดูรายละเอียดเพิ่มเติม : ".route('fronend.preview.promotion',['id'=>$promotion->promotionId]);
                                            $this->notify_message($Message,$Token,$promotion->id,$status_exp);

                                        }
                                    }
                                }
                            }

                        }
                    }

                }
            }
        }else{
            echo 'ไม่พบข้อมูล';
        }

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

            if(!empty($Id)){
                if($result_['status'] == 200){
                    $update = HistoryCalandar::findOrFail($Id);
                    if($status == 1){
                        $update->send_status_startDate = 1;
                        $update->send_message_startDate = 'แจ้งเตือนสำเร็จ';
                    }else{
                        $update->send_status_EndDate = 1;
                        $update->send_message_EndDate = 'แจ้งเตือนสำเร็จ';
                    }
                    $update->save();
                }else{
                    $update = HistoryCalandar::findOrFail($Id);
                    if($status == 1){
                        $update->send_status_startDate = 2;
                        $update->send_message_startDate = 'แจ้งเตือนไม่สำเร็จ! รอแจ้งเตือนใหม่อีกครั้ง';
                    }else{
                        $update->send_status_EndDate = 2;
                        $update->send_message_EndDate = 'แจ้งเตือนไม่สำเร็จ! รอแจ้งเตือนใหม่อีกครั้ง';
                    }
                    $update->save();
                }
            }
        }
        curl_close( $chOne );

        // return $chOne;
    }

    private function rewrite($item){
        $str_replace1 = strtolower(str_replace("&","AND",$item));
        $str_replace = strtolower(str_replace("%"," Percent",$str_replace1));
        $data = preg_replace("/\.$/"," ", $str_replace);
        return $data ;
    }

}
