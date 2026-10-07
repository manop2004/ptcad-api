<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Models\TbPromotionCoupon;
use App\Models\UsersCoupon;

class couponCheck implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $check = TbPromotionCoupon::where('coupon_code',$value)->first();
        $usercoupon = UsersCoupon::where('coupon_code',$value)->where('userId',Auth::user()->id)->count();

        if($usercoupon == 0){
            if(!empty($check)){
                if(!empty($check->coupon_date_exp)){
                    if($check->coupon_date_exp >= date('Y-m-d') ){
                        return true;
                    }
                }else{
                    return true;
                }
            }
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'ไม่พบข้อมูลรหัสคูปองนี้หรือคูปองอาจหมดอายุแล้ว กรุณาตรวจสอบข้อมูล!';
    }
}
