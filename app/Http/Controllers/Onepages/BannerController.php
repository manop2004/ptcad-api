<?php

namespace App\Http\Controllers\Onepages;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

use App\Models\TbPromotionOnepage;
use App\Models\TbPromotionOnepagesSection;

class BannerController extends Controller
{
    public function index($page){

        $breadcrumb = [
            ['name' => 'Setting Banner'],
        ];
        $title_page = 'Setting Banner';
        $section    = 'banner';
        $item       = TbPromotionOnepage::findOrFail($page);
        $count      = TbPromotionOnepagesSection::where('section',$section)->where('onepageId',$page)->count();
        $data       = TbPromotionOnepagesSection::where('section',$section)->where('onepageId',$page)->first();
        $section    = $section;

        return view('admin.onepage.banner.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'item' => $item,
            'count' => $count,
            'data' => $data,
            'section' => $section,
        ]);

    }

    public function crate(Request $request,$page){

        $request->validate(
            [
                'name' => 'required|max:255',
            ],
            [
                'name.required' => 'กรุณากรอกข้อมูล',
                'name.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
            ]
        );

        if($request->show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        $data = new TbPromotionOnepagesSection;
        $data->onepageId               = $request->onepageId;
        $data->bgColor                 = $request->bgColor;
        $data->section                 = $request->section;
        $data->name                    = $request->name;
        $data->detail                  = $request->detail;
        $data->sort                    = 0;
        $data->show                    = $show;
        $data->created_by              = Auth::user()->displayname;
        $data->updated_by              = Auth::user()->displayname;
        $data->created_at              = date('Y-m-d H:i:s');
        $data->updated_at              = date('Y-m-d H:i:s');

        if (!empty($request->images)) {

            if ($request->hasFile('images')) {
                @unlink(Storage::disk('public')->path('onepages/') . $request->images_old);

                $newFilename = uniqid() . '.' . $request->images->extension();
                $data->images = $newFilename;
                $file = $request->file('images');
                $file->move('storage/onepages/', $newFilename);
            }

        }

        $data->save();

        return redirect()->route('onepage.setting.banner',['page'=>$page,'section'=>'banner'])->with('feedback', 'เพิ่มข้อมูลเรียบร้อยแล้ว!');

    }

    public function update(Request $request,$page,$id){

        $request->validate(
            [
                'name' => 'required|max:255',
            ],
            [
                'name.required' => 'กรุณากรอกข้อมูล',
                'name.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
            ]
        );

        if($request->show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        $data = TbPromotionOnepagesSection::findOrFail($id);
        $data->bgColor                 = $request->bgColor;
        $data->section                 = $request->section;
        $data->name                    = $request->name;
        $data->detail                  = $request->detail;
        $data->sort                    = 0;
        $data->show                    = $show;
        $data->updated_by              = Auth::user()->displayname;
        $data->updated_at              = date('Y-m-d H:i:s');

        if (!empty($request->images)) {

            if ($request->hasFile('images')) {
                @unlink(Storage::disk('public')->path('onepages/') . $request->images_old);

                $newFilename = uniqid() . '.' . $request->images->extension();
                $data->images = $newFilename;
                $file = $request->file('images');
                $file->move('storage/onepages/', $newFilename);
            }

        }

        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function deleteImg(Request $request){

        $check = TbPromotionOnepagesSection::where('id',$request->deleteId)->first();
        if (!empty($check->images)) {
            @unlink(Storage::disk('public')->path('onepages/').$check->images);
        }

        $data = TbPromotionOnepagesSection::where('id',$request->deleteId)->first();
        $data->images              = null;
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');
    }
}
