<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Providers\RouteServiceProvider;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Storage;

use App\Models\TbSettingTransport;

class TransportController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $breadcrumb = [
            ['name' => 'ผู้ให้บริการขนส่ง'],
        ];
        $title_page = 'ผู้ให้บริการขนส่ง';

        return view('admin.transport.main', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => '',
        ]);

    }

    public function status($id){

        $data = TbSettingTransport::findOrFail($id);

        if($data->transport_show == 2){
            $status = 1;
        }else {
            $status = 2;
        }

        $data->transport_show               = $status;
        $data->updated_by                   = Auth::user()->displayname;
        $data->updated_at                   = date('Y-m-d H:i:s');
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');
    }

    public function jsondata()
    {

        $data = TbSettingTransport::get();

        return Datatables::of($data)
                ->addColumn('transport_img', function ($data) {
                    return '<img style="width: 100%; max-width: 100px" src="/images/transport/'.$data->transport_img.'" />';
                })
                ->addColumn('transport_name', function ($data) {
                    return $data->transport_name;
                })->addColumn('transport_updateby', function ($data) {
                    return $data->transport_updateby.'<p><small>'.$data->updated_at.'</small></p>';
                })
                ->addColumn('actions', function ($data) {
                    $id = $data->id;
                    $status = $data->transport_show;
                    return view('admin.transport.button', compact('id', 'status'));
                })
                ->escapeColumns([])
                ->addIndexColumn()
                ->make(true);
    }

}
