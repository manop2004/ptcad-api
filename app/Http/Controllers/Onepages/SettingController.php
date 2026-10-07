<?php

namespace App\Http\Controllers\Onepages;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

use App\Models\TbPromotionOnepage;
use App\Models\TbPromotionOnepagesForm;
use App\Models\TbPromotionOnepagesSetting;

class SettingController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($page){

        $breadcrumb = [
            ['name' => 'Setting Form One Page Promotion'],
        ];
        $title_page = 'Setting Form One Page Promotion';
        $item = TbPromotionOnepage::findOrFail($page);
        $settingForm = TbPromotionOnepagesSetting::where('onepageId',$page)->first();
        $data = TbPromotionOnepagesForm::where('onepageId',$page)->orderBy('sort','asc')->get();

        return view('admin.onepage._setting.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'item' => $item,
            'settingForm' => $settingForm,
            'data' => $data,
        ]);

    }

    public function crate(Request $request,$page){

        $request->validate(
            [
                'formName' => 'required|max:255',
                'formPDPA' => 'required',
            ],
            [
                'formName.required' => 'กรุณากรอกข้อมูล',
                'formName.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'formPDPA.required' => 'กรุณากรอกข้อมูล',
            ]
        );

        $check = TbPromotionOnepagesSetting::where('onepageId',$page)->first();

        if($request->checklabel == 'on'){
            $checklabel = 1;
        }else{
            $checklabel = 2;
        }

        if($request->checkpdpa == 'on'){
            $checkpdpa = 1;
        }else{
            $checkpdpa = 2;
        }

        if($request->radiusTopright == 'on'){
            $radiusTopright = 1;
        }else{
            $radiusTopright = 2;
        }

        if($request->radiusBottomright == 'on'){
            $radiusBottomright = 1;
        }else{
            $radiusBottomright = 2;
        }

        if($request->radiusTopleft == 'on'){
            $radiusTopleft = 1;
        }else{
            $radiusTopleft = 2;
        }

        if($request->radiusBottomleft == 'on'){
            $radiusBottomleft = 1;
        }else{
            $radiusBottomleft = 2;
        }

        if(!empty($check)){
            $settingForm = TbPromotionOnepagesSetting::where('onepageId',$page)->first();
            $settingForm->onepageId         = $request->onepageId;
            $settingForm->formName          = $request->formName;
            $settingForm->checklabel        = $checklabel;
            $settingForm->formDetail        = $request->formDetail;
            $settingForm->formPDPA          = $request->formPDPA;
            $settingForm->checkpdpa         = $checkpdpa;
            $settingForm->radiusForm        = $request->radiusForm;
            $settingForm->radiusTopright    = $radiusTopright;
            $settingForm->radiusBottomright = $radiusBottomright;
            $settingForm->radiusTopleft     = $radiusTopleft;
            $settingForm->radiusBottomleft  = $radiusBottomleft;
            $settingForm->bgButton          = $request->bgButton;
            $settingForm->wordButton        = $request->wordButton;
            $settingForm->widthButton       = $request->widthButton;
            $settingForm->colorButton       = $request->colorButton;
            $settingForm->bgColor           = $this->rewrite_color($request->bgColor);
            $settingForm->pdpaColor         = $this->rewrite_color($request->pdpaColor);
            $settingForm->fontColor         = $this->rewrite_color($request->fontColor);
            $settingForm->updated_by        = Auth::user()->displayname;
            $settingForm->updated_at        = date('Y-m-d H:i:s');

            if (!empty($request->imageButton)) {

                if ($request->hasFile('imageButton')) {
                    @unlink(Storage::disk('public')->path('onepages/') . $request->imageButton_old);

                    $newFilename = uniqid() . '.' . $request->imageButton->extension();
                    $settingForm->imageButton = $newFilename;
                    $file = $request->file('imageButton');
                    $file->move('storage/onepages/', $newFilename);
                }

            }

            $settingForm->save();
        }else{

            $settingForm = new TbPromotionOnepagesSetting;
            $settingForm->onepageId         = $request->onepageId;
            $settingForm->formName          = $request->formName;
            $settingForm->checklabel        = $checklabel;
            $settingForm->formDetail        = $request->formDetail;
            $settingForm->formPDPA          = $request->formPDPA;
            $settingForm->checkpdpa         = $checkpdpa;
            $settingForm->radiusForm        = $request->radiusForm;
            $settingForm->radiusTopright    = $radiusTopright;
            $settingForm->radiusBottomright = $radiusBottomright;
            $settingForm->radiusTopleft     = $radiusTopleft;
            $settingForm->radiusBottomleft  = $radiusBottomleft;
            $settingForm->bgButton          = $request->bgButton;
            $settingForm->wordButton        = $request->wordButton;
            $settingForm->widthButton       = $request->widthButton;
            $settingForm->colorButton       = $request->colorButton;
            $settingForm->bgColor           = $this->rewrite_color($request->bgColor);
            $settingForm->pdpaColor         = $this->rewrite_color($request->pdpaColor);
            $settingForm->fontColor         = $this->rewrite_color($request->fontColor);
            $settingForm->created_by        = Auth::user()->displayname;
            $settingForm->updated_by        = Auth::user()->displayname;
            $settingForm->created_at        = date('Y-m-d H:i:s');
            $settingForm->updated_at        = date('Y-m-d H:i:s');

            if (!empty($request->imageButton)) {

                if ($request->hasFile('imageButton')) {
                    @unlink(Storage::disk('public')->path('onepages/') . $request->imageButton_old);

                    $newFilename = uniqid() . '.' . $request->imageButton->extension();
                    $settingForm->imageButton = $newFilename;
                    $file = $request->file('imageButton');
                    $file->move('storage/onepages/', $newFilename);
                }

            }

            $settingForm->save();

        }

        return redirect()->back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function deleteImg(Request $request){

        $check = TbPromotionOnepagesSetting::where('id',$request->deleteId)->first();
        if (!empty($check->imageButton)) {
            @unlink(Storage::disk('public')->path('onepages/').$check->imageButton);
        }

        $data = TbPromotionOnepagesSetting::where('id',$request->deleteId)->first();
        $data->imageButton              = null;
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');
    }

    private function rewrite_color($color){
        $str_replace = strtolower(str_replace("#","",$color));
        $data = preg_replace('/[^a-z0-9\_\- ]/i', '', $str_replace);
        return $data ;
    }

    public function page($page){

        $breadcrumb = [
            ['name' => 'Setting Form One Page Promotion'],
        ];
        $title_page = 'Setting Form One Page Promotion';
        $item = TbPromotionOnepage::findOrFail($page);
        $settingForm = TbPromotionOnepagesSetting::where('onepageId',$page)->first();
        $data = TbPromotionOnepagesForm::where('onepageId',$page)->orderBy('sort','asc')->get();

        return view('admin.onepage._setting.page', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'item' => $item,
            'settingForm' => $settingForm,
            'data' => $data,
        ]);

    }

}
