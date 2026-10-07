<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;

use App\Models\TbProductHistoryImportfile;

class HistoryfileuploadController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function product()
    {

        $breadcrumb = [
            ['name' => 'ประวัติการอัพโหลดไฟล์ข้อมูลสินค้า'],
        ];
        $title_page = 'ประวัติการอัพโหลดไฟล์ข้อมูลสินค้า';

        return view('admin.history.product.main', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => '',
        ]);

    }

    public function productJson()
    {

        $data = TbProductHistoryImportfile::get();

        return Datatables::of($data)
                ->addColumn('file', function ($data) {
                    return '<a href="'.asset('storage/importProdust/'.$data->Year.'/'.$data->Month.'/'.$data->file_name).'" download>'.$data->file_name.'</a>';
                })
                ->addColumn('year', function ($data) {
                    return $data->Year;
                })
                ->addColumn('detail', function ($data) {
                    return $data->note;
                })
                ->addColumn('status', function ($data) {
                    return $data->Message;
                })
                ->addColumn('updateby', function ($data) {
                    return $data->created_at.'<p><small>'.$data->created_by.'</small></p>';
                })
                ->escapeColumns([])
                ->addIndexColumn()
                ->make(true);
    }

}
