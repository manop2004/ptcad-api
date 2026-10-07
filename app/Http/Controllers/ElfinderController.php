<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

if (!function_exists('elfinderAccess')) {
    /**
     * ตัวอย่างฟังก์ชันกำหนดสิทธิ์การเข้าถึงไฟล์/โฟลเดอร์
     * ปรับเปลี่ยนตามความต้องการ
     */
    function elfinderAccess($attr, $path, $data, $volume) {
        // ซ่อนไฟล์หรือโฟลเดอร์ที่ขึ้นต้นด้วย dot (.)
        return (strpos(basename($path), '.') === 0)
            ? !($attr === 'read' || $attr === 'write')
            : null;
    }
}

class ElfinderController extends Controller
{
    /**
     * แสดงหน้า elFinder (สำหรับเรียกดูไฟล์ทั่วไป)
     */
    public function index()
    {
        return view('admin.elfinder.index');
    }

    /**
     * เรียกใช้งาน connector ของ elFinder
     */
    public function connector(Request $request)
    {
        // ระบุที่ตั้งของ elFinder autoload file
        $autoload = public_path('elfinder_2/php/autoload.php');
        if (!file_exists($autoload)) {
            die('ElFinder autoload.php not found.');
        }
        include_once($autoload);

        // กำหนด options สำหรับ elFinder
        $opts = [
            'roots' => [
                [
                    'driver'        => 'LocalFileSystem',                  // ใช้ระบบไฟล์ local
                    'path'          => public_path('uploads'),             // โฟลเดอร์เก็บไฟล์ (สร้างโฟลเดอร์ uploads ใน public หากยังไม่มี)
                    'URL'           => url('uploads'),
                    'accessControl' => 'elfinderAccess',                   // ฟังก์ชันควบคุมการเข้าถึง
                ],
            ],
        ];

        // สร้าง instance elFinder และเรียก connector
        $connector = new \elFinderConnector(new \elFinder($opts));
        $connector->run();
        exit;
    }

    /**
     * แสดงหน้า elFinder สำหรับการใช้งานร่วมกับ CKEditor
     */
    public function ckeditor(Request $request)
    {
        return view('admin.elfinder.ckeditor');
    }
}
