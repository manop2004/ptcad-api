<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\UsersCoupon;
use App\Models\UserGetmember;
use App\Models\TbSetting;
use App\Models\TbSettingGetmember;
use App\Models\HistorySendMail;
use App\Models\TbPagesMap;

use App\Mail\getmemberToNewMember;
use App\Mail\getmemberToStaff;

class GetmemberController extends Controller
{

    //getmember สำหรับผู้แนะนำ
    public function check_MemberRef_By_Getmember(){

        $setting = TbSettingGetmember::first();

        if(!empty($setting)){

            $userCoupons = UsersCoupon::select(
                'users.id','users.user_code_friend_status','users.email','users.user_code','users.user_code_friend',
                'users_coupon.userId','users_coupon.coupon_code','users_coupon.coupon_use',
                'tb_order.conditionName','tb_order.payment_status'
            )
            ->leftjoin('users','users.id','users_coupon.userId')
            ->leftjoin('tb_order','tb_order.conditionName','users_coupon.coupon_code')
            ->where('users.user_code_friend_status',2)
            ->where('tb_order.payment_status',2)
            ->where('users_coupon.coupon_code',$setting->getmember_recommender_coupon)
            ->where('users_coupon.coupon_use','!=',0)
            ->get();

            if(count($userCoupons) != 0){

                foreach($userCoupons as $userCoupon){

                    $user = User::select('id','user_code','email')->where('user_code',$userCoupon->user_code_friend)->first();

                    if(!empty($user)){
                        $update = UserGetmember::where('userCode_Ref',$userCoupon->user_code_friend)->first();
                        $update->conditionStatus            = 1;
                        $update->save();

                        $updateUser = User::where('user_code',$userCoupon->user_code)->first();
                        $updateUser->user_code_friend_status    = 1;
                        $updateUser->save();

                    }

                }

                return 'สำเร็จ';
            }
        }

    }

    //getmember สำหรับผู้ถูกแนะนำ
    public function check_Newmember_By_Getmember(){

        $setting = TbSettingGetmember::first();

        if(!empty($setting)){

            $users = User::select('id','email','user_code_friend_status')->where('user_code_friend_status',2)->get();

            if(count($users) != 0){
                foreach($users as $user){

                    $crate = new UsersCoupon;
                    $crate->userId              = $user->id;
                    $crate->coupon_code         = $setting->getmember_recommender_coupon;
                    $crate->coupon_use          = 0;
                    $crate->created_by          = 'SYSTEM';
                    $crate->created_at          = date('Y-m-d H:i:s');
                    $crate->updated_by          = 'SYSTEM';
                    $crate->updated_at          = date('Y-m-d H:i:s');
                    $crate->save();

                    $user = User::findOrFail($user->id);
                    $user->user_code_friend_status   = 1;
                    $user->save();

                    $this->sendMail_Newmember_By_Getmember($user->id);

                }

                return 'สำเร็จ';
            }
        }

    }

    private function sendMail_Newmember_By_Getmember($id){

        $setting = TbSetting::first();
        $user = User::select('id','email')->findOrFail($id);

        $data = new \stdClass();
        $data->setting_nameWeb = $setting->setting_nameWeb;
        $data->setting_logoWeb = $setting->setting_logoWeb;

        $mail_bcc = explode(",",$setting->setting_email_bcc);

        if(!empty($setting->setting_email_bcc)){
			try{
				Mail::to($user->email)->bcc($mail_bcc)->later(now()->addMinutes(5), new getmemberToNewMember($data));
			
				if(Mail::failures()) { $mailStatus = 'ล้มเหลว'; }else{ $mailStatus = 'สำเร็จ'; }
			}catch(\Exception $e){
				// Never reached
				$mailStatus = 'ล้มเหลว';
			}
        }else{
			try{
				Mail::to($user->email)->later(now()->addMinutes(5), new getmemberToNewMember($data));
				
				if(Mail::failures()) { $mailStatus = 'ล้มเหลว'; }else{ $mailStatus = 'สำเร็จ'; }
			}catch(\Exception $e){
				// Never reached
				$mailStatus = 'ล้มเหลว';
			}
        }

        $history                            = new HistorySendMail();
        $history->userId                    = $user->id;
        $history->remark                    = "แจ้งเตือนสมาชิกเพื่อให้ทราบว่าตนเองได้รับของขวัญต้อนรับสมาชิกใหม่";
        $history->status                    = $mailStatus;
        $history->created_by                = 'SYSTEM';
        $history->created_at                = date('Y-m-d H:i:s');
        $history->updated_at                = date('Y-m-d H:i:s');
        $history->save();

    }

    //getmembet สำหรับพนักงาน
    public function check_UserGetmember_ToStaff(){

        $uesrCount = UserGetmember::where('conditionStatus',1)->count();

        if($uesrCount != 0){
            $this->sendMail_ToStaff_Getmember();

            return 'สำเร็จ';

        }

    }

    private function sendMail_ToStaff_Getmember(){

        $setting = TbSetting::first();
        $page = TbPagesMap::first();

        $data = new \stdClass();
        $data->setting_nameWeb = $setting->setting_nameWeb;
        $data->setting_logoWeb = $setting->setting_logoWeb;
        $data->page = $page;

        $mail_bcc = explode(",",$setting->setting_email_bcc);
        
		try{
			Mail::to($mail_bcc)->later(now()->addMinutes(5), new getmemberToStaff($data));
		}catch(\Exception $e){
			// Never reached
		}

    }

}
