<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Providers\RouteServiceProvider;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Storage;

use App\Models\TbSettingPopup;

class PopupController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $breadcrumb = [
            ['name' => 'POPUP'],
        ];
        $title_page = 'POPUP';
        $data = TbSettingPopup::first();

        return view('admin.popup.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => $data,
        ]);

    }

    public function crate(Request $request){

        if($request->popup_show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        $data = new TbSettingPopup;
        $data->popup_type               = $request->popup_type;
        $data->popup_detail             = $request->popup_detail;
        $data->sizeModel                = $request->sizeModel;
        $data->popup_show               = $show;
        $data->created_by               = Auth::user()->displayname;
        $data->updated_by               = Auth::user()->displayname;
        $data->created_at               = date('Y-m-d H:i:s');
        $data->updated_at               = date('Y-m-d H:i:s');

        if (!empty($request->popup_img)) {

            if ($request->hasFile('popup_img')) {
                @unlink(Storage::disk('public')->path('popup/') . $request->popup_img_old);

                $newFilename = uniqid() . '.' . $request->popup_img->extension();
                $data->popup_img = $newFilename;
                $file = $request->file('popup_img');
                $file->move('storage/popup/', $newFilename);
            }

        }
        $data->save();

        return redirect()->route('popup.index',[$data->id])->with('feedback', 'เพิ่มข้อมูลเรียบร้อยแล้ว!');

    }

    public function update(Request $request,$id){

        if($request->popup_show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        $data = TbSettingPopup::findOrFail($id);

        $data->popup_type              = $request->popup_type;
        $data->popup_detail            = $request->popup_detail;
        $data->sizeModel                = $request->sizeModel;
        $data->popup_show              = $show;
        $data->updated_by               = Auth::user()->displayname;
        $data->updated_at               = date('Y-m-d H:i:s');

        if (!empty($request->popup_img)) {

            if ($request->hasFile('popup_img')) {
                @unlink(Storage::disk('public')->path('popup/') . $request->popup_img_old);

                $newFilename = uniqid() . '.' . $request->popup_img->extension();
                $data->popup_img = $newFilename;
                $file = $request->file('popup_img');
                $file->move('storage/popup/', $newFilename);
            }

        }

        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function deleteImg(Request $request){

        $check = TbSettingPopup::findOrfail($request->deleteId);
        if (!empty($check->popup_img)) {
            @unlink(Storage::disk('public')->path('popup/').$check->popup_img);
        }

        $data = TbSettingPopup::findOrfail($request->deleteId);
        $data->popup_img              = null;
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

}
