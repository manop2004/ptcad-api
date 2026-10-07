<?php
/*
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MOIREI\GoogleMerchantApi\Contents\Product\Product as GMProduct;
use MOIREI\GoogleMerchantApi\Facades\ProductApi;
use MOIREI\GoogleMerchantApi\Facades\OrderApi;

use App\Models\TbBrand;
use App\Models\TbProduct;
use App\Models\TbProductAPI;
use App\Models\TbProductPicture;
use App\Models\TbProductDetail;

class GooglemerchantController extends Controller
{

    public function insert(){

        $items = TbProduct::select('id','pro_name','pro_seo_detail','pro_brand','pro_permalink')->where('pro_show',1)->get();

        foreach($items as $item){

            //check sale price
            if(!empty($this->check_sale($item->id))){
                $result_sale = array(
                    "value" => $this->check_sale($item->id),
                    "currency" => 'THB'
                );
            }else{
                $result_sale = '';
            }

            $attributes = [
                'id'                        => $this->check_sku($item->id),
                'name'                      => $item->pro_name,
                'brand'                     =>  $this->check_brand($item->pro_brand),
                'short_description'         => $item->pro_seo_detail,
                'url'                       =>  route('fronend.product.content',$item->pro_permalink),
                'image_url'                 =>  $this->check_image($item->id),
                'gm_price' => array(
                    "value" => $this->check_price($item->id),
                    "currency" => 'THB'
                ),
                'salePrice'                 => $result_sale,
            ];

            ProductApi::merchant([
                'app_name' => 'Merchant Center',
                'merchant_id' => '137677823',
                'client_credentials_path' => storage_path('app/google-merchant-api/service-account-credentials.json')
            ])->insert(function($product) use($attributes){
                $product->with($attributes);
            })->then(function($data){
                echo 'Product inserted';
            })->otherwise(function(){
                echo 'Insert failed';
            })->catch(function($e){
                dump($e);
            });

        }

    }

    public function view(){

        $items = TbProduct::select('id','pro_name','pro_seo_detail','pro_brand','pro_permalink')->where('pro_show',1)->get();

        $attributes = [];
        foreach($items as $item){

            //check sale price
            if(!empty($this->check_sale($item->id))){
                $result_sale = array(
                    "value" => $this->check_sale($item->id),
                    "currency" => 'THB'
                );
            }else{
                $result_sale = '';
            }

            $attributes[] = array(
                'id'                        => $this->check_sku($item->id),
                'name'                      => $item->pro_name,
                'brand'                     =>  $this->check_brand($item->pro_brand),
                'short_description'         => $item->pro_seo_detail,
                'url'                       =>  route('fronend.product.content',$item->pro_permalink),
                'image_url'                 =>  $this->check_image($item->id),
                'gm_price' => array(
                    "value" => $this->check_price($item->id),
                    "currency" => 'THB'
                ),
                'salePrice'                 => $result_sale,
            );

        }

        return $attributes;

    }

    public function list(){

        ProductApi::merchant([
            'app_name' => 'Content API For Website',
            'merchant_id' => '137677823',
            'client_credentials_path' => storage_path('app/google-merchant-api/service-account-credentials.json')
        ])->get()->then(function($data){
            echo response()->json($data);
        })->otherwise(function(){
            echo 'failed';
        })->catch(function($e){
            dump($e);
        });

    }

    public function delete(){


    }

    private function check_sku($data){
        if(!empty($data)){
            $check = TbProductDetail::where('proId',$data)->where('detail_sku','!=','-')->orderBy('sort', 'asc')->value('detail_sku');
            if(!empty($check)){
                $result = $check ;
            }else{
                $result = 'SKU-'.$this->generateRandomString();
            }
        }else{
            $result = $result = 'SKU-'.$this->generateRandomString();
        }

        return $result;
    }

    private function check_price($data){
        if(!empty($data)){
            $check = TbProductDetail::where('proId',$data)->where('detail_product_contact_sale_status',2)->orderBy('sort', 'asc')->first();
            if(!empty($check)){
                $result = $check->detail_price;
            }else{
                $result = "0";
            }
        }else{
            $result = "0";
        }

        return $result;
    }

    private function check_image($data){
        if(!empty($data)){
            $img = TbProductPicture::where('proId',$data)->where('picture_status',1)->value('picture_name');
            if(!empty($img)){
                $result = asset('storage/product/'.$img);
            }else{
                $result = asset('images/default-img/no-img.jpg');
            }
        }else{
            $result = asset('images/default-img/no-img.jpg');
        }

        return $result;
    }

    private function check_brand($data){
        if(!empty($data)){
            $check = TbBrand::where('id',$data)->value('brand_name');
            if(!empty($check)){
                $result = $check;
            }else{
                $result = '';
            }
        }else{
            $result = '';
        }

        return $result;
    }

    private function check_sale($proId){

        $dateToday = date('Y-m-d');

        $data = TbProductDetail::select(
            'tb_product_detail.id','tb_product_detail.proId','tb_product_detail.detail_sku','tb_product_detail.detail_name',
            'tb_product_detail.detail_other','tb_product_detail.detail_status',
            'tb_product_detail.detail_preorder_day','tb_product_detail.detail_product_weight','tb_product_detail.detail_product_wide',
            'tb_product_detail.detail_product_long','tb_product_detail.detail_product_high','tb_product_detail.detail_product_contact_sale_status',
            'tb_product_detail.detail_price','tb_product_detail.detail_price_sale_status','tb_product_detail.detail_price_sale',
            'tb_product_detail.detail_price_sale_status_date','tb_product_detail.detail_sale_date_start',
            'tb_product_detail.detail_sale_date_end','tb_product_detail.detail_show','tb_product_detail.sort',
            'tb_product.id','tb_product.pro_option'
        )
        ->leftjoin('tb_product','tb_product.id','tb_product_detail.proId')
        ->where('tb_product_detail.proId',$proId)
        ->where('tb_product_detail.detail_show',1)
        ->orderBy('tb_product_detail.sort','asc')
        ->first();

        if ($data->detail_product_contact_sale_status == 2){
            if ($data->detail_price_sale_status == 1){
                if ($data->detail_price_sale_status_date == 1){
                    if (!empty($data->detail_sale_date_start) && !empty($data->detail_sale_date_end)){
                            $startdate = $this->compareDate($dateToday, date("Y-m-d",strtotime($data->detail_sale_date_start)));
                            $enddate = $this->compareDate($dateToday, date("Y-m-d",strtotime($data->detail_sale_date_end)));

                        if ($startdate != 2 && $enddate != 0){
                            return $data->detail_price_sale;
                        }else{
                            return '';
                        }

                    }else if(!empty($data->detail_sale_date_start) && empty($data->detail_sale_date_end)){
                        $startdate = $this->compareDate($dateToday, date("Y-m-d",strtotime($data->detail_sale_date_start)));

                        if ($startdate != 2){
                            return $data->detail_price_sale;
                        }else{
                            return '';
                        }

                    }elseif (empty($data->detail_sale_date_start) && !empty($data->detail_sale_date_end)){
                        $enddate = $this->compareDate($dateToday, date("Y-m-d",strtotime($data->detail_sale_date_end)));

                        if ($enddate != 0){
                            return $data->detail_price_sale;
                        }else{
                            return '';
                        }

                    }else{
                        return $data->detail_price_sale;
                    }
                }else{
                    return $data->detail_price_sale;
                }
            }else{
                return '';
            }
        }else{
            return '';
        }
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

    private function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
*/