<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Providers\RouteServiceProvider;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\UsersAddress;
use App\Models\TbSettingCompanyBusiness;
use App\Models\TbSettingCompanyPosition;

class ReportuserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $breadcrumb = [
            ['name' => 'รายงานผู้ใช้'],
        ];
        $title_page = 'รายงานผู้ใช้';

        $userTotal = User::count();
        $personTotal = User::where('user_type',1)->where('level',6)->count();
        $companyTotal = User::where('user_type',2)->where('level',6)->count();
        $staffTotal = User::where('level','!=',6)->count();

        $memberTotal = User::where('level',6)->count();
        $memberAddressTotal = UsersAddress::count();
        //ภูมิภาค
        $geographiesNorth = $this->geographyGet(1);
        $geographiesCentral = $this->geographyGet(2);
        $geographiesNortheast = $this->geographyGet(3);
        $geographiesWestern = $this->geographyGet(4);
        $geographiesEastern = $this->geographyGet(5);
        $geographiesSouth = $this->geographyGet(6);
        //sex member
        $userGender1 = $this->sexmemberGet(1);
        $userGender2 = $this->sexmemberGet(2);
        $userGender3 = $this->sexmemberGet(3);

        return view('admin.user.report.dashboard', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'userTotal' => $userTotal,
            'personTotal' => $personTotal,
            'companyTotal' => $companyTotal,
            'staffTotal' => $staffTotal,
            'memberTotal' => $memberTotal,
            'memberAddressTotal' => $memberAddressTotal,
            'geographiesNorth' => $geographiesNorth,
            'geographiesCentral' => $geographiesCentral,
            'geographiesNortheast' => $geographiesNortheast,
            'geographiesEastern' => $geographiesEastern,
            'geographiesSouth' => $geographiesSouth,
            'geographiesWestern' => $geographiesWestern,
            'userGender1' => $userGender1,
            'userGender2' => $userGender2,
            'userGender3' => $userGender3,
            'data' => '',
        ]);

    }

    public function average(){
        $breadcrumb = [
            ['name' => 'รายงานอัตราการเติบโตของสมาชิก'],
        ];
        $title_page = 'รายงานอัตราการเติบโตของสมาชิก';

        $memberTotal = User::where('level',6)->count();

        return view('admin.user.report.average', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'memberTotal' => $memberTotal,
            'data' => '',
        ]);
    }

    public function jsonaverage(Request $request){

        if(!empty($request)){
            $date = $request->Year;
        }else{
            $date = date('Y');
        }

        $result_01 = User::select('created_at','level')->where('level',6)->whereMonth('created_at','01')->whereYear('created_at',$date)->count();
        $result_02 = User::select('created_at','level')->where('level',6)->whereMonth('created_at','02')->whereYear('created_at',$date)->count();
        $result_03 = User::select('created_at','level')->where('level',6)->whereMonth('created_at','03')->whereYear('created_at',$date)->count();
        $result_04 = User::select('created_at','level')->where('level',6)->whereMonth('created_at','04')->whereYear('created_at',$date)->count();
        $result_05 = User::select('created_at','level')->where('level',6)->whereMonth('created_at','05')->whereYear('created_at',$date)->count();
        $result_06 = User::select('created_at','level')->where('level',6)->whereMonth('created_at','06')->whereYear('created_at',$date)->count();
        $result_07 = User::select('created_at','level')->where('level',6)->whereMonth('created_at','07')->whereYear('created_at',$date)->count();
        $result_08 = User::select('created_at','level')->where('level',6)->whereMonth('created_at','08')->whereYear('created_at',$date)->count();
        $result_09 = User::select('created_at','level')->where('level',6)->whereMonth('created_at','09')->whereYear('created_at',$date)->count();
        $result_10 = User::select('created_at','level')->where('level',6)->whereMonth('created_at','10')->whereYear('created_at',$date)->count();
        $result_11 = User::select('created_at','level')->where('level',6)->whereMonth('created_at','11')->whereYear('created_at',$date)->count();
        $result_12 = User::select('created_at','level')->where('level',6)->whereMonth('created_at','12')->whereYear('created_at',$date)->count();

        $total = User::select('created_at','level')->where('level',6)->whereYear('created_at',$date)->count();

        $response[] = array(
            'result_01'=>number_format($result_01),
            'result_02'=>number_format($result_02),
            'result_03'=>number_format($result_03),
            'result_04'=>number_format($result_04),
            'result_05'=>number_format($result_05),
            'result_06'=>number_format($result_06),
            'result_07'=>number_format($result_07),
            'result_08'=>number_format($result_08),
            'result_09'=>number_format($result_09),
            'result_10'=>number_format($result_10),
            'result_11'=>number_format($result_11),
            'result_12'=>number_format($result_12),
            'total'=>number_format($total),
        );
        return $response;

    }

    public function averageYear(){

        $firstYear = (int)date('Y')-4;
        $lastYear = date('Y');
        $id = 1;

        $response = array();
        for($i=$firstYear;$i<=$lastYear;$i++)
        {
            $num = $id++;
            $response += array(
                'result_'.$num => User::select('created_at','level')->where('level',6)->whereYear('created_at',$i)->count(),
                'display_'.$num => $i,
            );
        }
        return $response;

    }


    private function sexmemberGet($number){

        $data = User::where('level',6)->where('sex',$number)->count();

        return $data;
    }

    private function geographyGet($number){

        $data = UsersAddress::select('tb_setting_provinces.id','tb_setting_provinces.geography_id','users_address.province','users_address.userId','users.id','users.level')
        ->leftJoin('tb_setting_provinces','tb_setting_provinces.id','users_address.province')
        ->leftJoin('users','users.id','users_address.userId')
        ->where('users.level',6)->where('tb_setting_provinces.geography_id',$number)->count();

        return $data;
    }

    public function jsonprovince()
    {

        $result = UsersAddress::select(
            DB::raw('COUNT(province) as CountPrv', 'province'),
            'tb_setting_provinces.id','tb_setting_provinces.prov_name_th',
            'users_address.province'
        )
        ->leftJoin('tb_setting_provinces','tb_setting_provinces.id','users_address.province')
        ->groupBy('users_address.province')
        ->orderBy('CountPrv','desc')
        ->limit(10)
        ->get();

        // return $result ;
        return Datatables::of($result)
            ->addColumn('provinces', function ($result) {
                return $result->prov_name_th;
            })
            ->addColumn('count', function ($result) {
                return $result->CountPrv;
            })
            ->escapeColumns([])
            ->addIndexColumn()
            ->make(true);
    }

    public function jsonbusiness(){

        $result = TbSettingCompanyBusiness::get();

        if (!empty($result)) {
            foreach($result as $item){

                $response[] = array(
                    'name'      =>$item->business_name,
                    'value'     =>User::where('level',6)->where('businessId',$item->id)->count(),
                    'color'     =>$this->random_color(),
                );
            }
            return $response;

        } else {
            return 'false';
        }

    }

    public function jsonposition(){

        $result = TbSettingCompanyPosition::get();

        if (!empty($result)) {

            foreach($result as $item){

                $response[] = array(
                    'name'      =>$item->position_name,
                    'value'     =>User::where('user_type',1)->where('positionId',$item->id)->count(),
                    'color'     =>$this->random_color(),
                );
            }
            return $response;

        } else {
            return 'false';
        }

    }

    private function random_color() {
        $chars = 'ABCDEF0123456789';
        $color = '#';
        for ( $i = 0; $i < 6; $i++ ) {
            $color .= $chars[rand(0, strlen($chars) - 1)];
        }
        return $color;
    }

}
