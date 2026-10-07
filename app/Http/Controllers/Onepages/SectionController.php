<?php

namespace App\Http\Controllers\Onepages;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;

use App\Models\TbPromotionOnepage;
use App\Models\TbPromotionOnepagesSection;

class SectionController extends Controller
{
    public function index($page){

        $breadcrumb = [
            ['name' => 'Setting Section'],
        ];
        $title_page     = 'Setting Section';
        $section        = 'section';
        $item           = TbPromotionOnepage::findOrFail($page);
        $count          = TbPromotionOnepagesSection::where('section',$section)->where('onepageId',$page)->count();
        $data           = '';

        return view('admin.onepage.section.main', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'item' => $item,
            'count' => $count,
            'data' => $data,
            'section' => $section,
            'page' => $page,
        ]);

    }

    public function add($page){

        $breadcrumb = [
            ['name' => 'Setting Section'],
        ];
        $title_page = 'Setting Section';
        $section = 'section';
        $item = TbPromotionOnepage::findOrFail($page);

        return view('admin.onepage.section.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'item' => $item,
            'section' => $section,
            'page' => $page,
            'data' => '',
        ]);

    }

    public function crate(Request $request){

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
        $data->save();

        return redirect()->route('onepage.setting.section.edit',['page'=>$request->onepageId,'id'=>$data->id])->with('feedback', 'เพิ่มข้อมูลเรียบร้อยแล้ว!');

    }

    public function edit($page,$id)
    {

        $breadcrumb = [
            ['name' => 'Setting Section'],
        ];

        $title_page = 'Setting Section';
        $item = TbPromotionOnepage::findOrFail($page);

        $data = TbPromotionOnepagesSection::where('onepageId',$page)->findOrFail($id);

        return view('admin.onepage.section.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'item' => $item,
            'page' => $page,
            'data' => $data,
        ]);
    }

    public function update(Request $request,$id){

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
        $data->name                    = $request->name;
        $data->bgColor                 = $request->bgColor;
        $data->detail                  = $request->detail;
        $data->sort                    = 0;
        $data->show                    = $show;
        $data->updated_by              = Auth::user()->displayname;
        $data->updated_at              = date('Y-m-d H:i:s');
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function jsondata($page,$section)
    {

        $data = TbPromotionOnepagesSection::where('section',$section)->where('onepageId',$page)->get();

        return Datatables::of($data)
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
                    $id         = $data->id;
                    $status     = $data->show;
                    $name       = $data->name;
                    $page       = $data->onepageId;
                    return view('admin.onepage.section.button', compact('id','status','name','page'));
                })
                ->escapeColumns([])
                ->addIndexColumn()
                ->make(true);
    }

    public function status($id){

        $data = TbPromotionOnepagesSection::findOrFail($id);

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

        TbPromotionOnepagesSection::where('id', $request->deleteId)->delete();
        return back()->with('feedback', 'ลบข้อมูลเรียบร้อยแล้ว!');

    }
}
