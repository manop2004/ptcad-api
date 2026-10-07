<?php

namespace App\Http\Controllers\Onepages;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Providers\RouteServiceProvider;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\TbPromotionOnepage;
use App\Models\TbPromotionOnepagesForm;
use App\Models\TbPromotionOnepagesSetting;
use App\Models\TbPromotionOnepagesSection;

class OnepageController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $breadcrumb = [
            ['name' => 'One Page Promotion'],
        ];
        $title_page = 'One Page Promotion';
        $count = TbPromotionOnepage::count();

        return view('admin.onepage.main', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'count' => $count,
            'data' => '',
        ]);

    }

    public function add(){

        $breadcrumb = [
            ['name' => 'One Page Promotion'],
        ];
        $title_page = 'One Page Promotion';

        return view('admin.onepage.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => '',
        ]);

    }

    public function crate(Request $request){

        $request->validate(
            [
                'parmalink' => 'required|max:255',
                'name' => 'required|max:255',
                'campaignid' => 'required|max:255',
                'mailtoteam' => 'required|max:255',
                'regis_type' => 'required',
                'og_image' => 'max:1024',
            ],
            [
                'parmalink.required' => 'กรุณากรอกข้อมูล',
                'parmalink.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'name.required' => 'กรุณากรอกข้อมูล',
                'name.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'campaignid.required' => 'กรุณากรอกข้อมูล',
                'campaignid.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'mailtoteam.required' => 'กรุณากรอกข้อมูล',
                'mailtoteam.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'regis_type.required' => 'กรุณาเลือกข้อมูล',
                'og_image.max' => 'ไม่สามารถอัพโหลดภาพได้เนื่องจากภาพมีขนาดใหญ่เกินไป กรุณาลดขนาดไฟล์ไม่เกิน 1MB',
            ]
        );

        if($request->show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        if($request->checkemail == 'on'){
            $checkemail = 'true';
        }else{
            $checkemail = 'false';
        }

        if($request->og_keywords != ''){
			$og_keywords = $request->og_keywords;
		} else {
			$og_keywords = '';
		}

        $data = new TbPromotionOnepage;
        $data->parmalink               = $this->rewrite_url($request->parmalink);
        $data->name                    = $request->name;
        $data->campaignid              = $request->campaignid;
        $data->mailtoteam              = $request->mailtoteam;
        $data->regis_type              = $request->regis_type;
        $data->checkemail              = $checkemail;
        $data->og_keywords             = $og_keywords;
        $data->og_description          = $request->og_description;
        $data->show                    = $show;
        $data->created_by              = Auth::user()->displayname;
        $data->updated_by              = Auth::user()->displayname;
        $data->created_at              = date('Y-m-d H:i:s');
        $data->updated_at              = date('Y-m-d H:i:s');

        if (!empty($request->og_image)) {

            if ($request->hasFile('og_image')) {
                @unlink(Storage::disk('public')->path('onepages/') . $request->og_image_old);

                $newFilename = uniqid() . '.' . $request->og_image->extension();
                $data->og_image = $newFilename;
                $file = $request->file('og_image');
                $file->move('storage/onepages/', $newFilename);
            }

        }

        $data->save();

        return redirect()->route('onepage.edit',[$data->id])->with('feedback', 'เพิ่มข้อมูลเรียบร้อยแล้ว!');

    }

    public function edit($id)
    {
        $breadcrumb = [
            ['name' => 'One Page Promotion'],
        ];
        $title_page = 'One Page Promotion';

        $data = TbPromotionOnepage::findOrFail($id);

        return view('admin.onepage.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => $data,
        ]);
    }

    public function update(Request $request,$id){

        $request->validate(
            [
                'parmalink' => 'required|max:255',
                'name' => 'required|max:255',
                'campaignid' => 'required|max:255',
                'mailtoteam' => 'required|max:255',
                'regis_type' => 'required',
                'og_image' => 'max:1024',
            ],
            [
                'parmalink.required' => 'กรุณากรอกข้อมูล',
                'parmalink.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'name.required' => 'กรุณากรอกข้อมูล',
                'name.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'campaignid.required' => 'กรุณากรอกข้อมูล',
                'campaignid.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'mailtoteam.required' => 'กรุณากรอกข้อมูล',
                'mailtoteam.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'regis_type.required' => 'กรุณาเลือกข้อมูล',
                'og_image.max' => 'ไม่สามารถอัพโหลดภาพได้เนื่องจากภาพมีขนาดใหญ่เกินไป กรุณาลดขนาดไฟล์ไม่เกิน 1MB',
            ]
        );

        if($request->show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        if($request->checkemail == 'on'){
            $checkemail = 'true';
        }else{
            $checkemail = 'false';
        }

        if($request->og_keywords != ''){
			$og_keywords = $request->og_keywords;
		} else {
			$og_keywords = '';
		}

        $data = TbPromotionOnepage::findOrFail($id);
        $data->parmalink               = $this->rewrite_url($request->parmalink);
        $data->name                    = $request->name;
        $data->campaignid              = $request->campaignid;
        $data->mailtoteam              = $request->mailtoteam;
        $data->regis_type              = $request->regis_type;
        $data->checkemail              = $checkemail;
        $data->og_keywords             = $og_keywords;
        $data->og_description          = $request->og_description;
        $data->show                    = $show;
        $data->updated_by              = Auth::user()->displayname;
        $data->updated_at              = date('Y-m-d H:i:s');

        if (!empty($request->og_image)) {

            if ($request->hasFile('og_image')) {
                @unlink(Storage::disk('public')->path('onepages/') . $request->og_image_old);

                $newFilename = uniqid() . '.' . $request->og_image->extension();
                $data->og_image = $newFilename;
                $file = $request->file('og_image');
                $file->move('storage/onepages/', $newFilename);
            }

        }

        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function status($id){

        $data = TbPromotionOnepage::findOrFail($id);

        if($data->show == 2){
            $status = 1;
        }elseif($data->show == 1) {
            $status = 2;
        }

        $data->show                         = $status;
        $data->updated_by                   = Auth::user()->displayname;
        $data->updated_at                   = date('Y-m-d H:i:s');
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');
    }

    public function delete(Request $request){

        TbPromotionOnepage::where('id', $request->deleteId)->delete();
        return back()->with('feedback', 'ลบข้อมูลเรียบร้อยแล้ว!');

    }

    public function jsondata()
    {

        $data = TbPromotionOnepage::get();

        return Datatables::of($data)
                ->addColumn('campaignid', function ($data) {
                    return $data->campaignid;
                })
                ->addColumn('name', function ($data) {
                    return $data->name;
                })
                ->addColumn('show', function ($data) {
                    return $data->show;
                })
                ->addColumn('created', function ($data) {
                    return $data->created_at.'<br/>'.$data->created_by;
                })
                ->addColumn('updated', function ($data) {
                    return $data->updated_at.'<br/>'.$data->updated_by;
                })
                ->addColumn('actions', function ($data) {
                    $id = $data->id;
                    $status = $data->show;
                    $name = $data->name;
                    return view('admin.onepage.button', compact('id','status','name'));
                })
                ->escapeColumns([])
                ->addIndexColumn()
                ->make(true);
    }

    public function deleteImg(Request $request){

        $check = TbPromotionOnepage::where('id',$request->deleteId)->first();
        if (!empty($check->og_image)) {
            @unlink(Storage::disk('public')->path('onepages/').$check->og_image);
        }

        $data = TbPromotionOnepage::where('id',$request->deleteId)->first();
        $data->og_image              = null;
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');
    }

    public function settingDeleteImg(Request $request){

        $check = TbPromotionOnepagesSetting::where('id',$request->deleteId)->first();
        if (!empty($check->og_image)) {
            @unlink(Storage::disk('public')->path('onepages/').$check->og_image);
        }

        $data = TbPromotionOnepagesSetting::where('id',$request->deleteId)->first();
        $data->imageButton              = null;
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');
    }

    private function rewrite_url($url){
        $str_replace = strtolower(str_replace(" ","-",$url));
        $data = preg_replace('/[^a-z0-9\_\- ]/i', '', $str_replace);
        return $data ;
    }

    private function rewrite_color($color){
        $str_replace = strtolower(str_replace("#","",$color));
        $data = preg_replace('/[^a-z0-9\_\- ]/i', '', $str_replace);
        return $data ;
    }

}
