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

use App\Models\User;
use App\Models\TbSettingAmphure;
use App\Models\TbSettingDistrict;
use App\Models\TbSettingProvince;
use App\Models\UsersAddress;
use App\Models\UsersAddressReceipt;

class UseraddressController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function address($id){

        $breadcrumb = [
            ['name' => 'ที่อยู่สำหรับจัดส่งสินค้า'],
        ];
        $title_page = 'ที่อยู่สำหรับจัดส่งสินค้า';

        $user                = User::findOrFail($id);
        $provinces           = TbSettingProvince::get();
        $check               = UsersAddress::where('userId',$id)->count();

        if($check  != 0){
            $data = UsersAddress::where('userId',$id)->first();
        }else{
            $data = '';
        }

        return view('admin.user.address.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => $data,
            'user' => $user,
            'provinces' => $provinces,
        ]);
    }

    public function addressCrate(Request $request){

        $request->validate(
            [
                'name' => 'required|max:255',
                'lastname' => 'required|max:255',
                'tel' => 'required|max:255',
                'address' => 'required',
                'province' => 'required',
                'amphures' => 'required',
                'district' => 'required',
                'zipcode' => 'required',
            ],
            [
                'name.required' => 'กรุณากรอกข้อมูล',
                'name.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'lastname.required' => 'กรุณากรอกข้อมูล',
                'lastname.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'address.required' => 'กรุณากรอกข้อมูล',
                'tel.required' => 'กรุณากรอกข้อมูล',
                'tel.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'province.required' => 'กรุณาเลือกข้อมูล',
                'amphures.required' => 'กรุณาเลือกข้อมูล',
                'district.required' => 'กรุณาเลือกข้อมูล',
                'zipcode.required' => 'กรุณากรอกข้อมูล',
            ]
        );

        $data = new UsersAddress;
        $data->userId                       = $request->userId;
        $data->name                         = $request->name;
        $data->lastname                     = $request->lastname;
        $data->tel                          = $request->tel;
        $data->address                      = $request->address;
        $data->province                     = $request->province;
        $data->amphures                     = $request->amphures;
        $data->district                     = $request->district;
        $data->zipcode                      = $request->zipcode;
        $data->message                      = $request->message;
        $data->created_by                   = Auth::user()->displayname;
        $data->updated_by                   = Auth::user()->displayname;
        $data->updated_at                   = now();
        $data->created_at                   = now();
        $data->save();

        return redirect()->back()->with('feedback', 'เพิ่มข้อมูลเรียบร้อยแล้ว!');

    }

    public function addressUpdate(Request $request,$id){

        $request->validate(
            [
                'name' => 'required|max:255',
                'lastname' => 'required|max:255',
                'tel' => 'required|max:255',
                'address' => 'required',
                'province' => 'required',
                'amphures' => 'required',
                'district' => 'required',
                'zipcode' => 'required',
            ],
            [
                'name.required' => 'กรุณากรอกข้อมูล',
                'name.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'lastname.required' => 'กรุณากรอกข้อมูล',
                'lastname.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'address.required' => 'กรุณากรอกข้อมูล',
                'tel.required' => 'กรุณากรอกข้อมูล',
                'tel.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'province.required' => 'กรุณาเลือกข้อมูล',
                'amphures.required' => 'กรุณาเลือกข้อมูล',
                'district.required' => 'กรุณาเลือกข้อมูล',
                'zipcode.required' => 'กรุณากรอกข้อมูล',
            ]
        );

        $data = UsersAddress::findOrfail($id);
        $data->userId                       = $request->userId;
        $data->name                         = $request->name;
        $data->lastname                     = $request->lastname;
        $data->tel                          = $request->tel;
        $data->address                      = $request->address;
        $data->province                     = $request->province;
        $data->amphures                     = $request->amphures;
        $data->district                     = $request->district;
        $data->zipcode                      = $request->zipcode;
        $data->message                      = $request->message;
        $data->updated_by                   = Auth::user()->displayname;
        $data->updated_at                   = now();
        $data->save();

        return redirect()->back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function receipt($id){

        $breadcrumb = [
            ['name' => 'ที่อยู่สำหรับจัดส่งใบเสร็จรับเงิน'],
        ];
        $title_page = 'ที่อยู่สำหรับจัดส่งใบเสร็จรับเงิน';

        $user                = User::findOrFail($id);
        $provinces           = TbSettingProvince::get();
        $check               = UsersAddressReceipt::where('userId',$id)->count();

        if($check  != 0){
            $data = UsersAddressReceipt::where('userId',$id)->first();
        }else{
            $data = '';
        }

        return view('admin.user.receipt.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => $data,
            'user' => $user,
            'provinces' => $provinces,
        ]);

    }

    public function receiptCrate(Request $request){

        $request->validate(
            [
                'name' => 'required|max:255',
                'lastname' => 'required|max:255',
                'tel' => 'required|max:255',
                'address' => 'required',
                'province' => 'required',
                'amphures' => 'required',
                'district' => 'required',
                'zipcode' => 'required',
                'taxid' => 'required',
            ],
            [
                'name.required' => 'กรุณากรอกข้อมูล',
                'name.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'lastname.required' => 'กรุณากรอกข้อมูล',
                'lastname.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'address.required' => 'กรุณากรอกข้อมูล',
                'tel.required' => 'กรุณากรอกข้อมูล',
                'tel.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'province.required' => 'กรุณาเลือกข้อมูล',
                'amphures.required' => 'กรุณาเลือกข้อมูล',
                'district.required' => 'กรุณาเลือกข้อมูล',
                'zipcode.required' => 'กรุณากรอกข้อมูล',
                'taxid.required' => 'กรุณากรอกข้อมูล',
            ]
        );

        $data = new UsersAddressReceipt;
        $data->taxid                        = $request->taxid;
        $data->company                      = $request->company;
        $data->branch                       = $request->branch;
        $data->userId                       = $request->userId;
        $data->name                         = $request->name;
        $data->lastname                     = $request->lastname;
        $data->tel                          = $request->tel;
        $data->address                      = $request->address;
        $data->province                     = $request->province;
        $data->amphures                     = $request->amphures;
        $data->district                     = $request->district;
        $data->zipcode                      = $request->zipcode;
        $data->created_by                   = Auth::user()->displayname;
        $data->updated_by                   = Auth::user()->displayname;
        $data->updated_at                   = now();
        $data->created_at                   = now();
        $data->save();

        return redirect()->back()->with('feedback', 'เพิ่มข้อมูลเรียบร้อยแล้ว!');

    }

    public function receiptUpdate(Request $request,$id){

        $request->validate(
            [
                'name' => 'required|max:255',
                'lastname' => 'required|max:255',
                'tel' => 'required|max:255',
                'address' => 'required',
                'province' => 'required',
                'amphures' => 'required',
                'district' => 'required',
                'zipcode' => 'required',
                'taxid' => 'required',
            ],
            [
                'name.required' => 'กรุณากรอกข้อมูล',
                'name.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'lastname.required' => 'กรุณากรอกข้อมูล',
                'lastname.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'address.required' => 'กรุณากรอกข้อมูล',
                'tel.required' => 'กรุณากรอกข้อมูล',
                'tel.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'province.required' => 'กรุณาเลือกข้อมูล',
                'amphures.required' => 'กรุณาเลือกข้อมูล',
                'district.required' => 'กรุณาเลือกข้อมูล',
                'zipcode.required' => 'กรุณากรอกข้อมูล',
                'taxid.required' => 'กรุณากรอกข้อมูล',
            ]
        );

        $data = UsersAddressReceipt::findOrfail($id);
        $data->taxid                        = $request->taxid;
        $data->company                      = $request->company;
        $data->branch                       = $request->branch;
        $data->userId                       = $request->userId;
        $data->name                         = $request->name;
        $data->lastname                     = $request->lastname;
        $data->tel                          = $request->tel;
        $data->address                      = $request->address;
        $data->province                     = $request->province;
        $data->amphures                     = $request->amphures;
        $data->district                     = $request->district;
        $data->zipcode                      = $request->zipcode;
        $data->updated_by                   = Auth::user()->displayname;
        $data->updated_at                   = now();
        $data->save();

        return redirect()->back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function json_province(Request $request){

        $data               = TbSettingProvince::get();
        return $data;

    }

    public function json_amphure(Request $request){

        $data               = TbSettingAmphure::where('province_id',$request->id)->get();
        return $data;

    }

    public function json_district(Request $request){

        $data               = TbSettingDistrict::where('amphure_id',$request->id)->get();
        return $data;

    }

    public function json_zipcode(Request $request){

        $data               = TbSettingDistrict::where('id',$request->id)->get();
        return $data;

    }

}
