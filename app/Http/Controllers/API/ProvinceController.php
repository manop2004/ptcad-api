<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\TbSettingProvince;
use App\Models\TbSettingAmphure;
use App\Models\TbSettingDistrict;

class ProvinceController extends Controller
{

    public function province(Request $request){

        $provinces                    = TbSettingProvince::get();

        foreach($provinces as $province){

            if(!empty($request->id)){
                if($province->id == $request->id){

                    $option[] = array(
                        'id' => $province->id,
                        'prov_name_th' => $province->prov_name_th,
                        'selected' => 'selected',
                    );

                }else{
                    $option[] = array(
                        'id' => $province->id,
                        'prov_name_th' => $province->prov_name_th,
                        'selected' => '',
                    );
                }
            }else{
                $option[] = array(
                    'id' => $province->id,
                    'prov_name_th' => $province->prov_name_th,
                    'selected' => '',
                );
            }

        }

        return $option;
    }

    public function amphure(Request $request){

        $amphures               = TbSettingAmphure::where('province_id',$request->id)->get();

        foreach($amphures as $amphure){

            if(!empty($request->amphureId)){
                if($amphure->id == $request->amphureId){

                    $option[] = array(
                        'id' => $amphure->id,
                        'amp_name_th' => $amphure->amp_name_th,
                        'selected' => 'selected',
                    );

                }else{
                    $option[] = array(
                        'id' => $amphure->id,
                        'amp_name_th' => $amphure->amp_name_th,
                        'selected' => '',
                    );
                }
            }else{
                $option[] = array(
                    'id' => $amphure->id,
                    'amp_name_th' => $amphure->amp_name_th,
                    'selected' => '',
                );
            }

        }

        return $option;

    }

    public function district(Request $request){

        $districts               = TbSettingDistrict::where('amphure_id',$request->amphureId)->get();

        foreach($districts as $district){

            if(!empty($request->districtId)){
                if($district->id == $request->districtId){

                    $option[] = array(
                        'id' => $district->id,
                        'dis_name_th' => $district->dis_name_th,
                        'selected' => 'selected',
                    );

                }else{
                    $option[] = array(
                        'id' => $district->id,
                        'dis_name_th' => $district->dis_name_th,
                        'selected' => '',
                    );
                }
            }else{
                $option[] = array(
                    'id' => $district->id,
                    'dis_name_th' => $district->dis_name_th,
                    'selected' => '',
                );
            }

        }

        return $option;
    }

    public function zipcode(Request $request){

        $zipcode               = TbSettingDistrict::where('id',$request->districtId)->first();

        $option[] = array(
            'zipcode' => $zipcode->dis_code,
        );

        return $option;
    }

}
