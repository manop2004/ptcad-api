<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Providers\RouteServiceProvider;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Storage;

use App\Models\TbRecommendCategory;

class RecommendcategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $breadcrumb = [
            ['name' => 'ตั้งค่ารายการแนะนำ'],
        ];
        $title_page = 'แนะนำหมวดหมู่';
        $count = TbRecommendCategory::count();

        return view('admin.recommendcategory.main', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'count' => $count,
            'data' => '',
        ]);

    }

    public function add(){

        $breadcrumb = [
            ['name' => 'เพิ่มหมวดหมู่แนะนำ'],
        ];
        $title_page = 'แนะนำหมวดหมู่';
        $sort = TbRecommendCategory::select('recommend_sort')->orderBy('recommend_sort','desc')->first();

        return view('admin.recommendcategory.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'sort' => $sort,
            'data' => '',
        ]);

    }

    public function crate(Request $request){

        $request->validate(
            [
                'recommend_thumb' => 'max:256',
                
            ],
            [
                'recommend_thumb.max' => 'ไม่สามารถอัพโหลดภาพได้เนื่องจากภาพมีขนาดใหญ่เกินไป กรุณาลดขนาดไฟล์',
            ]
        );

        if($request->show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        $data = new TbRecommendCategory;
        $data->recommend_link               = $request->recommend_link;
        $data->recommend_note               = $request->recommend_note;
        $data->recommend_sort               = $request->recommend_sort;
        $data->show                         = $show;
        $data->created_by                   = Auth::user()->displayname;
        $data->updated_by                   = Auth::user()->displayname;
        $data->created_at                   = date('Y-m-d H:i:s');
        $data->updated_at                   = date('Y-m-d H:i:s');

        if (!empty($request->recommend_thumb)) {

            if ($request->hasFile('recommend_thumb')) {
                @unlink(Storage::disk('public')->path('recommend/') . $request->recommend_thumb_old);

                $newFilename = uniqid() . '.' . $request->recommend_thumb->extension();
                $data->recommend_thumb = $newFilename;
                $file = $request->file('recommend_thumb');
                $file->move('storage/recommend/', $newFilename);
            }

        }

        $data->save();

        return redirect()->route('recommend.category.edit',[$data->id])->with('feedback', 'เพิ่มข้อมูลเรียบร้อยแล้ว!');

    }

    public function edit($id)
    {
        $breadcrumb = [
            ['name' => 'อัพเดตหมวดหมู่แนะนำ'],
        ];
        $title_page = 'แนะนำหมวดหมู่';

        $data = TbRecommendCategory::findOrFail($id);
        $sort = TbRecommendCategory::select('recommend_sort')->orderBy('recommend_sort','desc')->first();

        return view('admin.recommendcategory.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'sort' => $sort,
            'data' => $data,
        ]);
    }

    public function update(Request $request,$id){

        $request->validate(
            [
                'recommend_thumb' => 'max:256',
            ],
            [
                'recommend_thumb.max' => 'ไม่สามารถอัพโหลดภาพได้เนื่องจากภาพมีขนาดใหญ่เกินไป กรุณาลดขนาดไฟล์',
            ]
        );

        if($request->show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        $data = TbRecommendCategory::findOrFail($id);
        $data->recommend_link               = $request->recommend_link;
        $data->recommend_note               = $request->recommend_note;
        $data->recommend_sort               = $request->recommend_sort;
        $data->show                         = $show;
        $data->updated_by                   = Auth::user()->displayname;
        $data->updated_at                   = date('Y-m-d H:i:s');

        if (!empty($request->recommend_thumb)) {

            if ($request->hasFile('recommend_thumb')) {
                @unlink(Storage::disk('public')->path('recommend_thumb/') . $request->recommend_thumb_old);

                $newFilename = uniqid() . '.' . $request->recommend_thumb->extension();
                $data->recommend_thumb = $newFilename;
                $file = $request->file('recommend_thumb');
                $file->move('storage/recommend/', $newFilename);
            }

        }

        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function status($id){

        $data = TbRecommendCategory::findOrFail($id);

        if($data->show == 2){
            $status = 1;
        }elseif($data->show == 1) {
            $status = 2;
        }

        $data->show               = $status;
        $data->updated_by                   = Auth::user()->displayname;
        $data->updated_at                   = date('Y-m-d H:i:s');
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');
    }

    public function delete(Request $request){

        $check = TbRecommendCategory::findOrFail($request->deleteId);
        if(!empty($check)){
            @unlink(Storage::disk('public')->path('recommend/') . $check->recommend_thumb);
        }
        TbRecommendCategory::where('id', $request->deleteId)->delete();
        return back()->with('feedback', 'ลบข้อมูลเรียบร้อยแล้ว!');

    }

    public function deleteImg(Request $request){

        $check = TbRecommendCategory::findOrfail($request->deleteId);
        if (!empty($check->recommend_thumb)) {
            @unlink(Storage::disk('public')->path('recommend/').$check->recommend_thumb);
        }

        $data = TbRecommendCategory::findOrfail($request->deleteId);
        $data->recommend_thumb              = null;
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }


    public function jsondata()
    {

        $data = TbRecommendCategory::get();

        return Datatables::of($data)
                ->addColumn('recommend_name', function ($data) {

                    if($data->recommend_thumb){
                        return '<img style="max-width:200px;" src="'.asset('storage/recommend/' . $data->recommend_thumb).'" alt="" class="full-width">';
                    }else{
                        return '<img style="max-width:200px;" src="'.asset('images/default-img/no-img.jpg').'" alt="..." class="full-width" >';
                    }
                })
                ->addColumn('recommend_sort', function ($data) {
                    return $data->recommend_sort;
                })
                ->addColumn('show', function ($data) {
                    return $data->show;
                })
                ->addColumn('updated', function ($data) {
                    return $data->updated_by.'<br/>'.$data->updated_at;
                })
                ->addColumn('actions', function ($data) {
                    $id = $data->id;
                    $status = $data->show;
                    $name = $data->recommend_note;
                    return view('admin.recommendcategory.button', compact('id','status','name'));
                })
                ->escapeColumns([])
                ->addIndexColumn()
                ->make(true);
    }

}
