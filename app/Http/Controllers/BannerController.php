<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Providers\RouteServiceProvider;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Storage;

use App\Models\TbBanner;

class BannerController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $breadcrumb = [
            ['name' => 'แบรนเนอร์'],
        ];
        $title_page = 'แบรนเนอร์';
        $countbanner = TbBanner::count();

        return view('admin.banner.main', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'countbanner' => $countbanner,
            'data' => '',
        ]);

    }

    public function add(){

        $breadcrumb = [
            ['name' => 'เพิ่มแบรนเนอร์'],
        ];
        $title_page = 'เพิ่มแบรนเนอร์';

        $sort = TbBanner::orderBy('banner_sort','desc')->first();

        return view('admin.banner.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'sort' => $sort,
            'data' => '',
        ]);

    }

    public function crate(Request $request){

        $request->validate(
            [
                'banner_img_desktop' => 'required',
                'banner_img_mobile' => 'required',
                'banner_note' => 'required',
            ],
            [
                'banner_img_desktop.required' => 'กรุณาเลือกรูปภาพ',
                'banner_img_mobile.required' => 'กรุณาเลือกรูปภาพ',
                'banner_note.required' => 'กรุณาเลือกกรอกข้อมูล',
            ]
        );

        if($request->banner_show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }
        if(!empty($request->banner_sort)){
            $sort = $request->banner_sort;
        }else{
            $sort = 0;
        }

        $data = new TbBanner;
        $data->banner_link              = $request->banner_link;
        $data->banner_note              = $request->banner_note;
        if(!empty($request->banner_start_date)){
            $data->banner_start_date    = date("Y-m-d",strtotime($request->banner_start_date));
        }else{
            $data->banner_start_date    = null;
        }
        if(!empty($request->banner_end_date)){
            $data->banner_end_date      = date("Y-m-d",strtotime($request->banner_end_date));
        }else{
            $data->banner_end_date     = null;
        }
        $data->banner_show              = $show;
        $data->banner_sort              = $sort;
        $data->created_by               = Auth::user()->displayname;
        $data->updated_by               = Auth::user()->displayname;
        $data->created_at               = date('Y-m-d H:i:s');
        $data->updated_at               = date('Y-m-d H:i:s');

        if (!empty($request->banner_img_desktop)) {

            if ($request->hasFile('banner_img_desktop')) {
                @unlink(Storage::disk('public')->path('banner/') . $request->banner_img_desktop_old);

                $newFilename = uniqid() . '.' . $request->banner_img_desktop->extension();
                $data->banner_img_desktop = $newFilename;
                $file = $request->file('banner_img_desktop');
                $file->move('storage/banner/', $newFilename);
            }

        }

        if (!empty($request->banner_img_mobile)) {

            if ($request->hasFile('banner_img_mobile')) {
                @unlink(Storage::disk('public')->path('banner/') . $request->banner_img_mobile_old);

                $newFilename = uniqid() . '.' . $request->banner_img_mobile->extension();
                $data->banner_img_mobile = $newFilename;
                $file = $request->file('banner_img_mobile');
                $file->move('storage/banner/', $newFilename);
            }

        }

        $data->save();

        // ถ้าส่ง return_to มาด้วย (เช่นจากหน้า Hero Banner) ให้กลับไปหน้านั้นแทน
        if (!empty($request->return_to)) {
            return redirect($request->return_to)->with('feedback', 'เพิ่มข้อมูลเรียบร้อยแล้ว!');
        }

        return redirect()->route('banner.edit',[$data->id])->with('feedback', 'เพิ่มข้อมูลเรียบร้อยแล้ว!');

    }

    public function edit($id)
    {
        $breadcrumb = [
            ['name' => 'อัพเดตแบรนเนอร์'],
        ];
        $title_page = 'อัพเดตแบรนเนอร์';

        $data = TbBanner::findOrFail($id);

        return view('admin.banner.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => $data,
        ]);
    }

    public function update(Request $request,$id){

        $request->validate(
            [
                'banner_note' => 'required',
            ],
            [
                'banner_note.required' => 'กรุณาเลือกกรอกข้อมูล',
            ]
        );

        if($request->banner_show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }
        if(!empty($request->banner_sort)){
            $sort = $request->banner_sort;
        }else{
            $sort = 0;
        }

        $data = TbBanner::findOrFail($id);

        $data->banner_link              = $request->banner_link;
        $data->banner_link              = $request->banner_link;
        $data->banner_note              = $request->banner_note;
        if(!empty($request->banner_start_date)){
            $data->banner_start_date    = date("Y-m-d",strtotime($request->banner_start_date));
        }else{
            $data->banner_start_date    = null;
        }
        if(!empty($request->banner_end_date)){
            $data->banner_end_date      = date("Y-m-d",strtotime($request->banner_end_date));
        }else{
            $data->banner_end_date     = null;
        }
        $data->banner_show              = $show;
        $data->banner_sort              = $sort;
        $data->updated_by               = Auth::user()->displayname;
        $data->updated_at               = date('Y-m-d H:i:s');

        if (!empty($request->banner_img_desktop)) {

            if ($request->hasFile('banner_img_desktop')) {
                @unlink(Storage::disk('public')->path('banner/') . $request->banner_img_desktop_old);

                $newFilename = uniqid() . '.' . $request->banner_img_desktop->extension();
                $data->banner_img_desktop = $newFilename;
                $file = $request->file('banner_img_desktop');
                $file->move('storage/banner/', $newFilename);
            }

        }

        if (!empty($request->banner_img_mobile)) {

            if ($request->hasFile('banner_img_mobile')) {
                @unlink(Storage::disk('public')->path('banner/') . $request->banner_img_mobile_old);

                $newFilename = uniqid() . '.' . $request->banner_img_mobile->extension();
                $data->banner_img_mobile = $newFilename;
                $file = $request->file('banner_img_mobile');
                $file->move('storage/banner/', $newFilename);
            }

        }

        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function status($id){

        $data = TbBanner::findOrFail($id);

        if($data->banner_show == 2){
            $status = 1;
        }elseif($data->banner_show == 1) {
            $status = 2;
        }

        $data->banner_show                  = $status;
        $data->updated_by                   = Auth::user()->displayname;
        $data->updated_at                   = date('Y-m-d H:i:s');
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');
    }

    public function delete(Request $request){

        $check = TbBanner::findOrFail($request->deleteId);
        if(!empty($check)){
            @unlink(Storage::disk('public')->path('banner/') . $check->banner_img_desktop);
            @unlink(Storage::disk('public')->path('banner/') . $check->banner_img_mobile);
        }
        TbBanner::where('id', $request->deleteId)->delete();
        return back()->with('feedback', 'ลบข้อมูลเรียบร้อยแล้ว!');

    }

    public function deleteDesktop(Request $request){

        $check = TbBanner::findOrfail($request->deleteId);
        if (!empty($check->banner_img_desktop)) {
            @unlink(Storage::disk('public')->path('banner/').$check->banner_img_desktop);
        }

        $data = TbBanner::findOrfail($request->deleteId);
        $data->banner_img_desktop              = null;
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }


    public function deleteMobile(Request $request){

        $check = TbBanner::findOrfail($request->deleteId2);
        if (!empty($check->banner_img_mobile)) {
            @unlink(Storage::disk('public')->path('banner/').$check->banner_img_mobile);
        }

        $data = TbBanner::findOrfail($request->deleteId2);
        $data->banner_img_mobile              = null;
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }


    public function jsondata()
    {

        $data = TbBanner::get();

        return Datatables::of($data)
                ->addColumn('banner_img_desktop', function ($data) {
                    if(!empty($data->banner_img_desktop)){
                        return '<img src="'.asset('storage/banner/'.$data->banner_img_desktop).'" alt="" class="table-width text-align-center" rel="nofollow">';
                    }else{
                        return '<img src="'.asset('images/default-img/default-banner_2048_587.jpg').'" alt="..." class="table-width text-align-center" rel="nofollow">';
                    }
                })
                ->addColumn('banner_img_mobile', function ($data) {
                    if(!empty($data->banner_img_mobile)){
                        return '<img src="'.asset('storage/banner/'.$data->banner_img_mobile).'" alt="" class="table-width text-align-center" rel="nofollow">';
                    }else{
                        return '<img src="'.asset('images/default-img/default-banner-900-1050.jpg').'" alt="..." class="table-width text-align-center" rel="nofollow">';
                    }
                })
                ->addColumn('banner_date', function ($data) {
                    if(!empty($data->banner_start_date) && !empty($data->banner_end_date)){
                        return date("d-m-Y",strtotime($data->banner_start_date)).'<br/>'.date("d-m-Y",strtotime($data->banner_end_date));
                    }else if(!empty($data->banner_start_date) && empty($data->banner_end_date)){
                        return date("d-m-Y",strtotime($data->banner_start_date));
                    }else if(empty($data->banner_start_date) && !empty($data->banner_end_date)){
                        return date("d-m-Y",strtotime($data->banner_end_date));
                    }else{
                        return '';
                    }
                })
                ->addColumn('banner_sort', function ($data) {
                    return $data->banner_sort;
                })
                ->addColumn('banner_show', function ($data) {
                    return $data->banner_show;
                })
                ->addColumn('updated', function ($data) {
                    return $data->updated_by.'<br/>'.$data->updated_at;
                })
                ->addColumn('actions', function ($data) {
                    $id = $data->id;
                    $status = $data->banner_show;
                    $name = $data->banner_note;
                    return view('admin.banner.button', compact('id','status','name'));
                })
                ->escapeColumns([])
                ->addIndexColumn()
                ->make(true);
    }

}   