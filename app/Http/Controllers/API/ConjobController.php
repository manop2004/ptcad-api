<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\UsersAddress;
use App\Models\UsersAddressReceipt;
use App\Models\UsersCoupon;
use App\Models\UserGetmember;
use App\Models\TbSetting;
use App\Models\TbSettingGetmember;
use App\Models\HistorySendMail;
use App\Models\HistoryOrderStatus;
use App\Models\HistoryPdpa;
use App\Models\TbPagesMap;
use App\Models\TbOrder;
use App\Models\TbQuotation;
use App\Models\HistoryCalandar;
use App\Models\TbPromotionCalendar;
use App\Models\TbPromotionSettingLinenotify;
use App\Models\TbSoftware;
use App\Models\TbProduct;
use App\Models\TbProductDetail;
use App\Models\TbProductPicture;
use App\Models\TbCategory;
use App\Models\TbType;
use App\Models\TbOrderDetail;
use App\Models\TbSoftwareNotify;
use App\Models\TbExtension;

use App\Mail\getmemberToNewMember;
use App\Mail\getmemberToStaff;
use App\Mail\orderNotify;
use App\Mail\softwareExpNoti;

class ConjobController extends Controller
{

    public function testsendMail(){


        $setting = TbSetting::first();
        $user = User::select('id','email')->findOrFail('267');


        $data = new \stdClass();
        $data->setting_nameWeb = $setting->setting_nameWeb;
        $data->setting_logoWeb = $setting->setting_logoWeb;

        $mail_bcc = explode(",",$setting->setting_email_bcc);

        if(!empty($setting->setting_email_bcc)){
			
			try{
				Mail::to($user->email)->bcc($mail_bcc)->later(now()->addMinutes(5), new getmemberToNewMember($data));
			
				if(count(Mail::failures()) > 0){
					$errors = 'Failed to send password reset email, please try again.';
				}
			}catch(\Exception $e){
				// Never reached
				$errors = 'Failed to send password reset email, please try again.';
			}
			
			
        }else{
			
			try{
				Mail::to($user->email)->later(now()->addMinutes(5), new getmemberToNewMember($data));
				
				if(count(Mail::failures()) > 0){
					$errors = 'Failed to send password reset email, please try again.';
				}
			}catch(\Exception $e){
				// Never reached
				$errors = 'Failed to send password reset email, please try again.';
			}
			
        }
        

        // if(Mail::failures()) { $mailStatus = 'ล้มเหลว'; }else{ $mailStatus = 'สำเร็จ'; }

        // return $mailStatus;
       
    }

    //แจ้งเตือนวันหมดอายุ Software
    public function check_software_exp(){

        $softwares = TbSoftware::where('show',1)->get();
        $chk_day_now    = time();

        foreach($softwares as $software){

            $chk_day_end    = strtotime($software->date_exp." -7 day");
            $chk_day_expire = strtotime($software->date_exp);

            if($chk_day_now >= $chk_day_end && $chk_day_now < $chk_day_expire){

                $orderNumber                    = $this->generateOrderNumber();
                $user                           = User::findOrFail($software->userId);
                $usersAddress                   = UsersAddress::where('userId',$software->userId)->first();
                $usersReceipt                   = UsersAddressReceipt::where('userId',$software->userId)->first();
                $product                        = $this->productGet($software->productCode);
                if(!empty($product['pricesale'])){
                    $price                      = $product['pricesale'];
                }else{
                    $price                      = $product['price'];
                }

                $data                           = new TbOrder();
                $data->staffOf	                = $this->check_staff_IN_user($user->id);
                $data->staff_updated_by	        = 'SYSTEM';
                $data->staff_updated_at	        = date('Y-m-d H:i:s');
                $data->userCode                 = $user->user_code;
                $data->orderNumber              = 'ORD-'.$orderNumber;
                $data->residence_name           = $usersAddress->name;
                $data->residence_lastname       = $usersAddress->lastname;
                $data->residence_tel            = $usersAddress->tel;
                $data->residence_address        = $usersAddress->address;
                $data->residence_province       = $usersAddress->province;
                $data->residence_amphures       = $usersAddress->amphures;
                $data->residence_district       = $usersAddress->district;
                $data->residence_zipcode        = $usersAddress->zipcode;
                $data->residence_massage        = $usersAddress->massage;
                //add status ว่าต้องการใบเสร็จรับเงินไหม
                if(!empty($usersReceipt)){
                    $data->statusReceipts       = 1;
                }else{
                    $data->statusReceipts       = 2;
                }
                if(!empty($usersReceipt)){
                    $data->receipt_type         = $usersReceipt->type;
                    $data->receipt_tax          = $usersReceipt->taxid;
                    $data->receipt_company      = $usersReceipt->company;
                    $data->receipt_branch       = $usersReceipt->branch;
                    $data->receipt_name         = $usersReceipt->name;
                    $data->receipt_lastname     = $usersReceipt->lastname;
                    $data->receipt_tel          = $usersReceipt->tel;
                    $data->receipt_address      = $usersReceipt->address;
                    $data->receipt_province     = $usersReceipt->province;
                    $data->receipt_amphures     = $usersReceipt->amphures;
                    $data->receipt_district     = $usersReceipt->district;
                    $data->receipt_zipcode      = $usersReceipt->zipcode;
                }

                $data->subtotal                 = $price;
                if(!empty($product['vat'])){
                    $vat                        = ($price*$product['vat'])/100;
                    $data->priceVAT             = $vat;
                }else{
                    $vat                        = 0;
                }
                if($user->type == 2){
                    if(!empty($product['withholding'])){
                        $withholding            = ($price*$product['withholding'])/100;
                        $data->priceWithholding = $withholding;
                    }else{
                        $withholding            = 0;
                    }
                }else{
                    $withholding                = 0;
                }
                $data->priceNettotal            = '';
                $data->conditionType            = '';
                $data->conditionName            = '';
                $data->conditionValue           = '';
                $data->totaldiscount            = '';
                $data->totalCart                = ($price+$vat)-$withholding;
                $data->payment_type             = 1;
                $data->payment_status           = 1;
                $data->payment_massage          = null;
                $data->created_at               = date('Y-m-d H:i:s');
                $data->updated_at               = date('Y-m-d H:i:s');
                $data->save();

                $detail                         = new TbOrderDetail;
                $detail->orderId                = $data->id;
                $detail->product_sku            = $product['detail_sku'];
                if ($product['pro_option'] = 1){
                    $detail->product_name       = $product['pro_name'];
                }else{
                    $detail->product_name       = $product['detail_name'];
                }
                $detail->product_detail         = $product['detail_other'];
                $detail->product_img            = $product['picture_name'];
                $detail->product_price          = $price;
                $detail->product_price_sale     = null;
                $detail->product_unit           = 1;
                $detail->product_price_total    = $price * 1;
                $detail->save();

                $notify                         = TbSoftwareNotify::where('softwareId',$software->id)->first();
                $notify->orderId                = $data->id;
                $notify->price                  = $price;
                $notify->save();

                $this->send_mail_to_software_exp($data->id,$software->id,$user->id);

            }
        }

    }

    private function productGet($sku){

        $data = TbProduct::select(
            'tb_product.id','tb_product.pro_name','tb_product.pro_permalink','tb_product.pro_catId','tb_product.pro_option',
            'tb_product_detail.id','tb_product_detail.proId','tb_product_detail.detail_sku','tb_product_detail.detail_name',
            'tb_product_detail.detail_other','tb_product_detail.detail_product_contact_sale_status','tb_product_detail.detail_price',
            'tb_product_detail.detail_price_sale_status','tb_product_detail.detail_price_sale','tb_product_detail.detail_price_sale_status_date',
            'tb_product_detail.detail_sale_date_start','tb_product_detail.detail_sale_date_end','tb_product_detail.detail_show',
            'tb_product_picture.proId','tb_product_picture.picture_status','tb_product_picture.picture_name',
        )
        ->leftjoin('tb_product_detail','tb_product_detail.proId','tb_product.id')
        ->leftjoin('tb_product_picture','tb_product_picture.proId','tb_product.id')
        ->where('tb_product_picture.picture_status',1)
        ->where('tb_product.pro_show',1)
        ->where('tb_product_detail.detail_sku',$sku)
        ->first();

        $dateToday = date('Y-m-d');

        $dateToday ;
        if ($data->detail_product_contact_sale_status == 2){
            if ($data->detail_price_sale_status == 1){
                if ($data->detail_price_sale_status_date == 1){
                    if (!empty($data->detail_sale_date_start) && !empty($data->detail_sale_date_end)){
                            $startdate = $this->compareDate($dateToday, date("Y-m-d",strtotime($data->detail_sale_date_start)));
                            $enddate = $this->compareDate($dateToday, date("Y-m-d",strtotime($data->detail_sale_date_end)));

                        if ($startdate != 2 && $enddate != 0){
                            $price = $data->detail_price;
                            $pricesale = $data->detail_price_sale;
                        }else{
                            $price = $data->detail_price;
                            $pricesale = '';
                        }

                    }else if(!empty($data->detail_sale_date_start) && empty($data->detail_sale_date_end)){
                        $startdate = $this->compareDate($dateToday, date("Y-m-d",strtotime($data->detail_sale_date_start)));

                        if ($startdate != 2){
                            $price = $data->detail_price;
                            $pricesale = $data->detail_price_sale;
                        }else{
                            $price = $data->detail_price;
                            $pricesale = '';
                        }

                    }elseif (empty($data->detail_sale_date_start) && !empty($data->detail_sale_date_end)){
                        $enddate = $this->compareDate($dateToday, date("Y-m-d",strtotime($data->detail_sale_date_end)));

                        if ($enddate != 0){
                            $price = $data->detail_price;
                            $pricesale = $data->detail_price_sale;
                        }else{
                            $price = $data->detail_price;
                            $pricesale = '';
                        }

                    }else{
                        $price = $data->detail_price;
                        $pricesale = $data->detail_price_sale;
                    }
                }else{
                    $price = $data->detail_price;
                    $pricesale = $data->detail_price_sale;
                }
            }else{
                $price = $data->detail_price;
                $pricesale = '';
            }
        }else{
            $price = '0';
            $pricesale = '';
        }

        if(!empty($data->picture_name)){
            $image = asset('storage/product/'.$data->picture_name);
        }else{
            $image = asset('images/default-img/no-img.jpg');
        }

        $type = TbCategory::select('tb_category.id','tb_category.category_type','tb_type.id','tb_type.type_vat','tb_type.type_withholding')
        ->leftjoin('tb_type','tb_type.id','tb_category.category_type')
        ->where('tb_category.id',$data->pro_catId)
        ->first();

        $product = array(
            'id' => $data->proId,
            'pro_name' => $data->pro_name,
            'pro_option' => $data->pro_option,
            'pro_permalink' => $data->pro_permalink,
            'detail_sku' => $data->detail_sku,
            'detail_name' => 'null',
            'detail_other' => 'null',
            'picture_name' => $image,
            'price' => $price,
            'pricesale' => $pricesale,
            'vat' => $type->type_vat,
            'withholding' => $type->type_withholding,
        );

        return $product;

    }

    private function send_mail_to_software_exp($orderId,$softwareId,$userId){

        $setting    = TbSetting::first();
        $page       = TbPagesMap::first();
        $order      = TbOrder::findOrFail($orderId);
        $softwares  = TbSoftware::findOrFail($softwareId);
        $user       = User::findOrFail($userId);

        $data = new \stdClass();
        $data->setting_nameWeb  = $setting->setting_nameWeb;
        $data->setting_logoWeb  = $setting->setting_logoWeb;
        $data->page             = $page;
        $data->order            = $order;
        $data->softwares        = $softwares;

        $mail = explode(",",$user->email);

		try{
			Mail::to($mail)->later(now()->addMinutes(5), new softwareExpNoti($data));
		}catch(\Exception $e){
			// Never reached
		}

    }

    //check ผู้ใช้ที่เคยให้ pdpa ไว้ และบันทึกลงตาราง history
    public function check_pdpa_Crate_To_History(){

        $userget = User::select('id','name','lastname','tel','email','pdpa_news','pdpa_article','pdpa_product','level')->where('level',6)->get();

        foreach($userget as $user){
            $checkUser = HistoryPdpa::where('email',$user->email)->count();

            if($user->pdpa_news     == 1){$pdpa_news    = 1;}else{$pdpa_news    = 2;}
            if($user->pdpa_article  == 1){$pdpa_article = 1;}else{$pdpa_article = 2;}
            if($user->pdpa_product  == 1){$pdpa_product = 1;}else{$pdpa_product = 2;}

            if($checkUser == 0){
                //add
                $data = new HistoryPdpa();
                $data->userId               = $user->id;
                $data->fullname             = $user->name.' '.$user->user_lastname;
                $data->tel                  = $user->tel;
                $data->email                = $user->email;
                $data->pdpa_news            = $pdpa_news;
                $data->pdpa_article         = $pdpa_article;
                $data->pdpa_product         = $pdpa_product;
                $data->created_at           = date('Y-m-d H:i:s');
                $data->updated_at           = date('Y-m-d H:i:s');
                $data->save();

            }else{
                //update
                $data = HistoryPdpa::where('email',$user->email)->first();
                $data->fullname             = $user->name.' '.$user->user_lastname;
                $data->tel                  = $user->tel;
                $data->email                = $user->email;
                $data->pdpa_news            = $pdpa_news;
                $data->pdpa_article         = $pdpa_article;
                $data->pdpa_product         = $pdpa_product;
                $data->updated_at           = date('Y-m-d H:i:s');
                $data->save();
            }
        }

        $quotationget = TbQuotation::select('id','name','lastname','tel','email','pdpa_news','pdpa_article','pdpa_product')->get();

        foreach($quotationget as $quotation){
            $checkQuotation = HistoryPdpa::where('email',$quotation->email)->count();

            if($quotation->pdpa_news     == 1){$q_pdpa_news    = 1;}else{$q_pdpa_news    = 2;}
            if($quotation->pdpa_article  == 1){$q_pdpa_article = 1;}else{$q_pdpa_article = 2;}
            if($quotation->pdpa_product  == 1){$q_pdpa_product = 1;}else{$q_pdpa_product = 2;}

            if($checkQuotation == 0){
                //add
                $data = new HistoryPdpa();
                $data->userId               = User::select('id','email')->where('email',$quotation->email)->value('id');
                $data->fullname             = $quotation->name.' '.$quotation->uotation_lastname;
                $data->tel                  = $quotation->tel;
                $data->email                = $quotation->email;
                $data->pdpa_news            = $q_pdpa_news;
                $data->pdpa_article         = $q_pdpa_article;
                $data->pdpa_product         = $q_pdpa_product;
                $data->created_at           = date('Y-m-d H:i:s');
                $data->updated_at           = date('Y-m-d H:i:s');
                $data->save();

            }else{
                //update

                $data = HistoryPdpa::where('email',$quotation->email)->first();
                $data->fullname             = $quotation->name.' '.$quotation->lastname;
                $data->tel                  = $quotation->tel;
                $data->email                = $quotation->email;
                $data->pdpa_news            = $q_pdpa_news;
                $data->pdpa_article         = $q_pdpa_article;
                $data->pdpa_product         = $q_pdpa_product;
                $data->updated_at           = date('Y-m-d H:i:s');
                $data->save();
            }
        }

        return 'สำเร็จ';

    }

    private function check_staff_IN_user($userId){
        $user = User::select('id','staffId')->findOrFail($userId);

        if(!empty($user->staffId)){

            $response = $user->staffId;
        }else{
            $response = NULL;
        }

        return $response ;
    }

    private function generateOrderNumber($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    private function compareDate($date1,$date2) {
        $arrDate1 = explode("-",$date1);
        $arrDate2 = explode("-",$date2);
        $timStmp1 = mktime(0,0,0,$arrDate1[1],$arrDate1[2],$arrDate1[0]);
        $timStmp2 = mktime(0,0,0,$arrDate2[1],$arrDate2[2],$arrDate2[0]);

        if ($timStmp1 == $timStmp2) {
            return 1;
        } else if ($timStmp1 > $timStmp2) {
            return 0;
        } else if ($timStmp1 < $timStmp2) {
            return 2;
        }
    }
}
