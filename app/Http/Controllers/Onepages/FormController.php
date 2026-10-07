<?php

namespace App\Http\Controllers\Onepages;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\TbPromotionOnepage;
use App\Models\TbPromotionOnepagesForm;
use App\Models\TbPromotionOnepagesSetting;

class FormController extends Controller
{
    public function index($page){

        $item = TbPromotionOnepage::findOrFail($page);
        $settingForm = TbPromotionOnepagesSetting::where('onepageId',$page)->first();
        $data = TbPromotionOnepagesForm::where('onepageId',$page)->orderBy('sort','asc')->get();

        $breadcrumb = [
            ['name' => 'Setting Form One Page Promotion'],
        ];
        $title_page = $item->name;

        return view('admin.onepage.form.main', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'item' => $item,
            'settingForm' => $settingForm,
            'data' => $data,
        ]);

    }

    public function crate(Request $request,$page){

        if($request->field == [null]){
            return redirect()->back()->with('feedback-er', 'กรุณาเลือกข้อมูลสำหรับฟอร์ม!');
        }

        TbPromotionOnepagesForm::where('onepageId', $page)->delete();

        if(!empty($request->field)){
            for($i=0 ;$i < count($request->field); $i++) {

                if($request->field[$i] != null){
                    $data = new TbPromotionOnepagesForm;
                    $data->onepageId               = $request->onepageId;
                    $data->field                   = $request->field[$i];
                    if($request->field[$i] == 'firstname'){
                        $data->fieldTH             = $request->fieldTH[$i];
                        $data->type                = 'input';
                    }
                    if($request->field[$i] == 'lastname'){
                        $data->fieldTH             = $request->fieldTH[$i];
                        $data->type                = 'input';
                    }
                    if($request->field[$i] == 'company'){
                        $data->fieldTH             = $request->fieldTH[$i];
                        $data->type                = 'input';
                    }
                    if($request->field[$i] == 'designation'){
                        $data->fieldTH             = $request->fieldTH[$i];
                        $data->type                = 'input';
                    }
                    if($request->field[$i] == 'department'){
                        $data->fieldTH             = $request->fieldTH[$i];
                        $data->type                = 'input';
                    }
                    if($request->field[$i] == 'website'){
                        $data->fieldTH             = $request->fieldTH[$i];
                        $data->type                = 'input';
                    }
                    if($request->field[$i] == 'industry'){
                        $data->fieldTH             = $request->fieldTH[$i];
                        $data->type                = 'select';
                    }
                    if($request->field[$i] == 'email'){
                        $data->fieldTH             = $request->fieldTH[$i];
                        $data->type                = 'input';
                    }
                    if($request->field[$i] == 'phone'){
                        $data->fieldTH             = $request->fieldTH[$i];
                        $data->type                = 'input';
                    }
                    if($request->field[$i] == 'mobile'){
                        $data->fieldTH             = $request->fieldTH[$i];
                        $data->type                = 'input';
                    }
                    if($request->field[$i] == 'fax'){
                        $data->fieldTH             = $request->fieldTH[$i];
                        $data->type                = 'input';
                    }
                    if($request->field[$i] == 'description'){
                        $data->fieldTH             = $request->fieldTH[$i];
                        $data->type                = 'textarea';
                    }
                    if($request->field[$i] == 'address'){
                        $data->fieldTH             = $request->fieldTH[$i];
                        $data->type                = 'textarea';
                    }
                    if($request->field[$i] == 'province'){
                        $data->fieldTH             = $request->fieldTH[$i];
                        $data->type                = 'select';
                    }
                    $data->col                     = $request->col[$i];
                    $data->sort                    = $request->sort[$i];
                    $data->created_by              = Auth::user()->displayname;
                    $data->updated_by              = Auth::user()->displayname;
                    $data->created_at              = date('Y-m-d H:i:s');
                    $data->updated_at              = date('Y-m-d H:i:s');
                    $data->save();
                }
            }
        }
        return redirect()->back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function delete(Request $request){

        TbPromotionOnepagesForm::where('id', $request->deleteId)->delete();
        return back()->with('feedback', 'ลบข้อมูลเรียบร้อยแล้ว!');

    }
}
