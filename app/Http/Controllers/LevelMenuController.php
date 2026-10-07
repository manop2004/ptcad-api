<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\TbLevel;
use App\Models\TbLevelMenu;

class LevelMenuController extends Controller
{
    public function index()
    {
        $breadcrumb = [
            ['name' => 'จัดการสิทธิ์ตาม Role'],
        ];
        $title_page = 'จัดการสิทธิ์ตาม Role';

        $levels = TbLevel::where('status', 1)->orderBy('id', 'asc')->get();

        return view('admin.levelmenu.main', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'levels' => $levels,
        ]);
    }

    public function edit($level)
    {
        $breadcrumb = [
            ['name' => 'ตั้งค่าสิทธิ์เริ่มต้นของ Role'],
        ];
        $title_page = 'ตั้งค่าสิทธิ์เริ่มต้นของ Role';

        $levelData = TbLevel::findOrFail($level);
        $menuData = TbLevelMenu::where('level', $level)->first();

        return view('admin.levelmenu.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'levelData' => $levelData,
            'menuData' => $menuData,
        ]);
    }

    public function update(Request $request, $level)
    {
        TbLevel::findOrFail($level); // แค่เช็คว่า Role นี้มีจริง

        $fields = [
            'l_artlicle', 'l_promotion', 'l_software', 'l_program', 'l_banner',
            'l_page', 'l_category', 'l_customcode', 'l_setting', 'l_recommend',
            'l_user', 'l_user_Action', 'l_user_staff_Action', 'l_bank',
            'l_membergetmember', 'l_membergetmember_setting',
            'l_quotation', 'l_quotation_setting',
            'l_product', 'l_product_Import', 'l_product_Export', 'l_product_Action',
            'l_ticket',
        ];

        $menuData = TbLevelMenu::where('level', $level)->first();
        if (empty($menuData)) {
            $menuData = new TbLevelMenu;
            $menuData->level = $level;
        }

        foreach ($fields as $field) {
            $menuData->$field = $request->$field == 1 ? 1 : 2;
        }

        $menuData->save();

        return back()->with('feedback', 'บันทึกสิทธิ์เริ่มต้นของ Role เรียบร้อยแล้ว!');
    }
}