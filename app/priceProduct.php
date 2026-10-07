<?php

use App\Models\TbProductDetail;

function toFloatPrice($value): float
{
    if ($value === null || $value === '') {
        return 0.0;
    }

    if (is_string($value)) {
        $value = str_replace([',', '฿', ' '], '', trim($value));
    }

    return is_numeric($value) ? (float) $value : 0.0;
}

function check_price_product_on_content_page($detailId){

    $dateToday = date('Y-m-d');

    $data = TbProductDetail::where('detail_show',1)->find($detailId);

    if(empty($data)){
        return 0;
    }else{

        if ($data->detail_product_contact_sale_status == 2){
            if ($data->detail_price_sale_status == 1){
                if ($data->detail_price_sale_status_date == 1){
                    if (!empty($data->detail_sale_date_start) && !empty($data->detail_sale_date_end)){
                        $startdate = compareDate($dateToday, date("Y-m-d",strtotime($data->detail_sale_date_start)));
                        $enddate = compareDate($dateToday, date("Y-m-d",strtotime($data->detail_sale_date_end)));

                        if ($startdate != 2 && $enddate != 0){

                            $response = '฿ '.number_format(toFloatPrice($data->detail_price_sale)).'<span class="f-20 co-red decoration-line-through price-through">฿ '.number_format(toFloatPrice($data->detail_price)).'</span>';

                        }else{

                            $response = '฿ '.number_format(toFloatPrice($data->detail_price));

                        }

                    }else if(!empty($data->detail_sale_date_start) && empty($data->detail_sale_date_end)){
                        $startdate = compareDate($dateToday, date("Y-m-d",strtotime($data->detail_sale_date_start)));

                        if ($startdate != 2){

                            $response = '฿ '.number_format(toFloatPrice($data->detail_price_sale)).'<span class="f-20 co-red decoration-line-through price-through">฿ '.number_format(toFloatPrice($data->detail_price)).'</span>';

                        }else{

                            $response = '฿ '.number_format(toFloatPrice($data->detail_price));

                        }

                    }elseif (empty($data->detail_sale_date_start) && !empty($data->detail_sale_date_end)){
                        $enddate = compareDate($dateToday, date("Y-m-d",strtotime($data->detail_sale_date_end)));

                        if ($enddate != 0){

                            $response = '฿ '.number_format(toFloatPrice($data->detail_price_sale)).'<span class="f-20 co-red decoration-line-through price-through">฿ '.number_format(toFloatPrice($data->detail_price)).'</span>';

                        }else{

                            $response = '฿ '.number_format(toFloatPrice($data->detail_price));

                        }

                    }else{

                        $response = '฿ '.number_format(toFloatPrice($data->detail_price_sale)).'<span class="f-20 co-red decoration-line-through price-through">฿ '.number_format(toFloatPrice($data->detail_price)).'</span>';

                    }
                }else{

                    $response = '฿ '.number_format(toFloatPrice($data->detail_price_sale)).'<span class="f-20 co-red decoration-line-through price-through">฿ '.number_format(toFloatPrice($data->detail_price)).'</span>';

                }
            }else{

                $response = '฿ '.number_format(toFloatPrice($data->detail_price));

            }
        }else{
            $response = null;
        }

        return $response;
    }

}

function check_price_product_on_category_page($proId) {
    $dateToday = date('Y-m-d');

    $data = TbProductDetail::select(
        'tb_product_detail.id', 'tb_product_detail.proId', 'tb_product_detail.detail_status',
        'tb_product_detail.detail_price', 'tb_product_detail.detail_price_sale_status', 'tb_product_detail.detail_product_contact_sale_status',
        'tb_product_detail.detail_price_sale', 'tb_product_detail.detail_price_sale_status_date', 'tb_product_detail.detail_sale_date_start',
        'tb_product_detail.detail_sale_date_end', 'tb_product_detail.detail_show',
        'tb_product.pro_option'
    )
    ->leftJoin('tb_product', 'tb_product.id', 'tb_product_detail.proId')
    ->where('tb_product_detail.proId', $proId)
    ->where('tb_product_detail.detail_show', 1)
    ->orderBy('tb_product_detail.sort', 'asc')
    ->first();

    if (empty($data)) return 0;

    if ($data->detail_product_contact_sale_status != 2) return null;

    $isSale = false;

    if ($data->detail_price_sale_status == 1) {
        if ($data->detail_price_sale_status_date == 1) {
            $startOK = true;
            $endOK = true;

            if (!empty($data->detail_sale_date_start)) {
                $startOK = compareDate($dateToday, date("Y-m-d", strtotime($data->detail_sale_date_start))) != 2;
            }

            if (!empty($data->detail_sale_date_end)) {
                $endOK = compareDate($dateToday, date("Y-m-d", strtotime($data->detail_sale_date_end))) != 0;
            }

            if ($startOK && $endOK) $isSale = true;
        } else {
            $isSale = true;
        }
    }

    if ($data->pro_option == 1) {
        if ($isSale) {
            return '<span class="co-red">฿ ' . number_format(toFloatPrice($data->detail_price_sale)) . '</span><small class="f-20 decoration-line-through price-through">฿ ' . number_format(toFloatPrice($data->detail_price)) . '</small>';
        } else {
            return '฿ ' . number_format(toFloatPrice($data->detail_price));
        }
    } else {
        if ($isSale) {
            $saleMin = checkSale_MIN($data->proId);
            $priceMin = TbProductDetail::where('proId', $data->proId)
                ->where('detail_show', 1)
                ->orderByRaw('CAST(detail_price AS UNSIGNED) ASC')
                ->value('detail_price');

            if ($saleMin) {
                return '<span class="co-red">฿ ' . number_format(toFloatPrice($saleMin)) . '</span><small class="f-20 decoration-line-through price-through">฿ ' . number_format(toFloatPrice($priceMin)) . '</small>';
            } else {
                return checkPrice_MIN_MAX($data->proId);
            }
        } else {
            return checkPrice_MIN_MAX($data->proId);
        }
    }
}

function check_price_product_sale_on_quotation_page($detailId){

    $dateToday = date('Y-m-d');

    $data = TbProductDetail::where('detail_show',1)->find($detailId);

    if(empty($data)){
        return 0;
    }else{

        if ($data->detail_product_contact_sale_status == 2){
            if ($data->detail_price_sale_status == 1){
                if ($data->detail_price_sale_status_date == 1){
                    if (!empty($data->detail_sale_date_start) && !empty($data->detail_sale_date_end)){
                        $startdate = compareDate($dateToday, date("Y-m-d",strtotime($data->detail_sale_date_start)));
                        $enddate = compareDate($dateToday, date("Y-m-d",strtotime($data->detail_sale_date_end)));

                        if ($startdate != 2 && $enddate != 0){
                            $response = toFloatPrice($data->detail_price_sale);
                        }else{
                            $response = 0;
                        }

                    }else if(!empty($data->detail_sale_date_start) && empty($data->detail_sale_date_end)){
                        $startdate = compareDate($dateToday, date("Y-m-d",strtotime($data->detail_sale_date_start)));

                        if ($startdate != 2){
                            $response = toFloatPrice($data->detail_price_sale);
                        }else{
                            $response = 0;
                        }

                    }elseif (empty($data->detail_sale_date_start) && !empty($data->detail_sale_date_end)){
                        $enddate = compareDate($dateToday, date("Y-m-d",strtotime($data->detail_sale_date_end)));

                        if ($enddate != 0){
                            $response = toFloatPrice($data->detail_price_sale);
                        }else{
                            $response = 0;
                        }

                    }else{
                        $response = toFloatPrice($data->detail_price_sale);
                    }
                }else{

                    $response = toFloatPrice($data->detail_price_sale);
                }
            }else{
                $response = toFloatPrice($data->detail_price);
            }
        }else{
            $response = 0;
        }

        return $response;
    }

}

function og_productPrice($detailId){

    $dateToday = date('Y-m-d');

    $data = TbProductDetail::where('detail_show',1)->find($detailId);

    if(empty($data)){
        return 0;
    }else{

        if ($data->detail_product_contact_sale_status == 2){
            if ($data->detail_price_sale_status == 1){
                if ($data->detail_price_sale_status_date == 1){
                    if (!empty($data->detail_sale_date_start) && !empty($data->detail_sale_date_end)){
                        $startdate = compareDate($dateToday, date("Y-m-d",strtotime($data->detail_sale_date_start)));
                        $enddate = compareDate($dateToday, date("Y-m-d",strtotime($data->detail_sale_date_end)));

                        if ($startdate != 2 && $enddate != 0){
                            $response = toFloatPrice($data->detail_price_sale);
                        }else{
                            $response = toFloatPrice($data->detail_price);
                        }

                    }else if(!empty($data->detail_sale_date_start) && empty($data->detail_sale_date_end)){
                        $startdate = compareDate($dateToday, date("Y-m-d",strtotime($data->detail_sale_date_start)));

                        if ($startdate != 2){
                            $response = toFloatPrice($data->detail_price_sale);
                        }else{
                            $response = toFloatPrice($data->detail_price);
                        }

                    }elseif (empty($data->detail_sale_date_start) && !empty($data->detail_sale_date_end)){
                        $enddate = compareDate($dateToday, date("Y-m-d",strtotime($data->detail_sale_date_end)));

                        if ($enddate != 0){
                            $response = toFloatPrice($data->detail_price_sale);
                        }else{
                            $response = toFloatPrice($data->detail_price);
                        }

                    }else{
                        $response = toFloatPrice($data->detail_price_sale);
                    }
                }else{

                    $response = toFloatPrice($data->detail_price_sale);
                }
            }else{
                $response = toFloatPrice($data->detail_price);
            }
        }else{
            $response = 0;
        }

        return $response;
    }

}

function checkPrice_MIN_MAX($proId){

    $detailMin = TbProductDetail::select('proId','detail_price')
        ->where('proId',$proId)
        ->where('detail_show', 1)
        ->orderByRaw('CAST(detail_price AS UNSIGNED) ASC')
        ->value('detail_price');

    return '฿ '.number_format(toFloatPrice($detailMin));
}

function compareDate($date1,$date2) {
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

function shortStr($string,$number){

    if (strlen($string) >= 20) {
        return substr($string, 0, $number). "...";
    }
    else {
        return $string;
    }

}

function checkSale_MIN($proId) {
    $dateToday = date('Y-m-d');
    return TbProductDetail::where('proId', $proId)
        ->where('detail_show', 1)
        ->where('detail_price_sale_status', 1)
        ->where('detail_product_contact_sale_status', 2)
        ->where(function($q) use ($dateToday) {
            $q->where('detail_price_sale_status_date', '!=', 1)
              ->orWhere(function($query) use ($dateToday) {
                  $query->where(function($q2) use ($dateToday) {
                      $q2->whereNotNull('detail_sale_date_start')
                         ->whereNotNull('detail_sale_date_end')
                         ->whereRaw("STR_TO_DATE('$dateToday', '%Y-%m-%d') BETWEEN STR_TO_DATE(detail_sale_date_start, '%Y-%m-%d') AND STR_TO_DATE(detail_sale_date_end, '%Y-%m-%d')");
                  })->orWhere(function($q2) use ($dateToday) {
                      $q2->whereNotNull('detail_sale_date_start')
                         ->whereNull('detail_sale_date_end')
                         ->whereRaw("STR_TO_DATE('$dateToday', '%Y-%m-%d') >= STR_TO_DATE(detail_sale_date_start, '%Y-%m-%d')");
                  })->orWhere(function($q2) use ($dateToday) {
                      $q2->whereNull('detail_sale_date_start')
                         ->whereNotNull('detail_sale_date_end')
                         ->whereRaw("STR_TO_DATE('$dateToday', '%Y-%m-%d') <= STR_TO_DATE(detail_sale_date_end, '%Y-%m-%d')");
                  });
              });
        })
        ->orderByRaw('CAST(detail_price_sale AS UNSIGNED) ASC')
        ->value('detail_price_sale');
}