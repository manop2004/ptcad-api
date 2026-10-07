<?php

namespace App\Exports;

use App\Models\TbProductDetail;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\UserGetmember;

class UserMemberGetMember implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
   
    public function __construct(int $status = null, string $search = null)
    {
        $this->status = $status;
        $this->search = $search;
    }

    public function view(): View
    {
        $status = $this->status;
        $search = $this->search;

        $data = UserGetmember::select(
            'users.user_code','users.name','users.lastname','users.email','users.tel',
            'user_getmember.userCode','user_getmember.userCode_Ref','user_getmember.status','user_getmember.created_at',
            'tb_setting_districts.dis_name_th', 'tb_setting_amphures.amp_name_th', 'tb_setting_provinces.prov_name_th','users_address.address','users_address.zipcode'
        )
        ->leftjoin('users','users.user_code','user_getmember.userCode_Ref')
        ->leftjoin('users_address','users_address.userId','users.id')
        ->leftjoin('tb_setting_provinces','tb_setting_provinces.id','users_address.province')
        ->leftjoin('tb_setting_amphures','tb_setting_amphures.id','users_address.amphures')
        ->leftjoin('tb_setting_districts','tb_setting_districts.id','users_address.district')
        ->when($search, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->orWhere('users.name', 'LIKE', '%' . $search . '%')
                ->orWhere('users.lastname', 'LIKE', '%' . $search . '%')
                ->orWhere('users.email', 'LIKE', '%' . $search . '%')
                ->orWhere('users.tel', 'LIKE', '%' . $search . '%');
            });
        })
        ->when($status, function ($query, $status) {
            if(!empty($status)){
                return $query->where('user_getmember.status',$status);
            }
        })
        ->orderBy('user_getmember.created_at','desc')
        ->get();

        return view('admin.getmember.exports', [
            'data' => $data,
            'i'=>1,
        ]);
    }

}
