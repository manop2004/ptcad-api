<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Providers\RouteServiceProvider;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Storage;

use App\Models\TbSettingBank;
use App\Models\TbPaymentBank;

class BankController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $breadcrumb = [
            ['name' => 'บัญชีธนาคาร'],
        ];
        $title_page = 'บัญชีธนาคาร';
        $count = TbPaymentBank::count();

        return view('admin.bank.main', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'count' => $count,
            'data' => '',
        ]);

    }

    public function add(){

        $breadcrumb = [
            ['name' => 'เพิ่มบัญชีธนาคาร'],
        ];

        $title_page = 'เพิ่มบัญชีธนาคาร';
        $banks = TbSettingBank::get();

        return view('admin.bank.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => '',
            'banks' => $banks,
        ]);

    }

    public function crate(Request $request){

        $request->validate(
            [
                'bankId' => 'required',
                'bank_name' => 'required|max:255',
                'bank_number' => 'required|max:255|unique:tb_payment_bank',
                'bank_branch' => 'max:255',
            ],
            [
                'bankId.required' => 'กรุณาเลือกธนาคาร',
                'bank_name.required' => 'กรุณากรอกข้อมูล',
                'bank_name.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'bank_number.required' => 'กรุณากรอกข้อมูล',
                'bank_number.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'bank_branch.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
             ]
        );

        if($request->bank_show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        $data = new TbPaymentBank;
        $data->bankId                       = $request->bankId;
        $data->bank_name                    = $request->bank_name;
        $data->bank_number                  = $request->bank_number;
        $data->bank_branch                  = $request->bank_branch;
        $data->bank_show                    = $show;
        $data->created_by                    = Auth::user()->displayname;
        $data->updated_by                    = Auth::user()->displayname;
        $data->created_at                    = date('Y-m-d H:i:s');
        $data->updated_at                    = date('Y-m-d H:i:s');
        $data->save();

        return redirect()->route('bank.edit',[$data->id])->with('feedback', 'เพิ่มข้อมูลเรียบร้อยแล้ว!');

    }

    public function edit($id)
    {
        $breadcrumb = [
            ['name' => 'อัพเดตบัญชีธนาคาร'],
        ];

        $title_page = 'อัพเดตบัญชีธนาคาร';
        $data  = TbPaymentBank::findOrFail($id);
        $banks = TbSettingBank::get();

        return view('admin.bank.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => $data,
            'banks' => $banks,
        ]);
    }

    public function update(Request $request,$id){

        $request->validate(
            [
                'bankId' => 'required',
                'bank_name' => 'required|max:255',
                'bank_number' => 'required|max:255|unique:tb_payment_bank,bank_number,'.$id,
                'bank_branch' => 'max:255',
            ],
            [
                'bankId.required' => 'กรุณาเลือกธนาคาร',
                'bank_name.required' => 'กรุณากรอกข้อมูล',
                'bank_name.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'bank_number.required' => 'กรุณากรอกข้อมูล',
                'bank_number.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'bank_branch.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
             ]
        );

        if($request->bank_show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        $data = TbPaymentBank::findOrFail($id);

        $data->bankId                       = $request->bankId;
        $data->bank_name                    = $request->bank_name;
        $data->bank_number                  = $request->bank_number;
        $data->bank_branch                  = $request->bank_branch;
        $data->bank_show                    = $show;
        $data->updated_by                   = Auth::user()->displayname;
        $data->updated_at                   = date('Y-m-d H:i:s');
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function status($id){

        $data = TbPaymentBank::findOrFail($id);

        if($data->bank_show == 2){
            $status = 1;
        }elseif($data->bank_show == 1) {
            $status = 2;
        }

        $data->bank_show                    = $status;
        $data->updated_by                   = Auth::user()->displayname;
        $data->updated_at                   = date('Y-m-d H:i:s');
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');
    }

    public function delete(Request $request){

        TbPaymentBank::where('id', $request->deleteId)->delete();
        return back()->with('feedback', 'ลบข้อมูลเรียบร้อยแล้ว!');

    }

    public function jsondata()
    {

        $data = TbPaymentBank::get();

        return Datatables::of($data)
                ->addColumn('bankId', function ($data) {
                    $bank = TbSettingBank::findOrfail($data->bankId);
                    return $bank->bank_name;
                })
                ->addColumn('bank_name', function ($data) {
                    return $data->bank_name;
                })
                ->addColumn('bank_number', function ($data) {
                    return '<a href="'.$data->bank_number.'" target="_bank">'.$data->bank_number.'</a>';
                })
                ->addColumn('bank_show', function ($data) {
                    return $data->bank_show;
                })
                ->addColumn('crated', function ($data) {
                    return $data->created_at.'<br/><small><i class="fa fa-user"></i> '.$data->created_by.'</small>';
                })
                ->addColumn('updated', function ($data) {
                    return $data->updated_at.'<br/><small><i class="fa fa-user"></i> '.$data->updated_by.'</small>';
                })
                ->addColumn('actions', function ($data) {
                    $id = $data->id;
                    $name = $data->bank_name;
                    $status = $data->bank_show;
                    return view('admin.bank.button', compact('id','status','name'));
                })
                ->escapeColumns([])
                ->addIndexColumn()
                ->make(true);
    }

}
