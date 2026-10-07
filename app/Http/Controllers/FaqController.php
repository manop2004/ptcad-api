<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\Datatables\Datatables;

use App\Models\Faq;

class FaqController extends Controller
{

    public function __construct()
{
    $this->middleware('auth')->except(['view', 'frontendIndex']);
}

    public function index()
    {
        $breadcrumb = [
            ['name' => 'FAQ'],
        ];
        $title_page = 'FAQ - คำถามที่พบบ่อย';

        $faq = Faq::count();

        return view('admin.faq.main', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => '',
            'faq' => $faq,
        ]);
    }

    /**
     * หน้าแสดงผล FAQ ฝั่งลูกค้า (หลัง login) — list แบบ accordion + ปุ่ม copy link
     */
    public function frontendIndex()
    {
        $breadcrumb = [
            ['route' => route('fronend.home'), 'name' => 'หน้าหลัก'],
            ['route' => '', 'name' => 'FAQ'],
        ];

        $faqs = Faq::where('faq_show', 1)
            ->orderBy('faq_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('fontend.account.faq', [
            'breadcrumb' => $breadcrumb,
            'faqs' => $faqs,
        ]);
    }

    public function add()
    {
        $breadcrumb = [
            ['name' => 'เพิ่ม FAQ'],
        ];
        $title_page = 'เพิ่ม FAQ';

        return view('admin.faq.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => '',
        ]);
    }

    public function crate(Request $request)
    {
        $request->validate(
            [
                'faq_title' => 'required|max:255',
                'faq_parmalink' => 'nullable|max:255|unique:tb_faq,faq_parmalink',
                'faq_file' => 'required|mimes:pdf|max:20480',
            ],
            [
                'faq_title.required' => 'กรุณากรอกชื่อหัวข้อ',
                'faq_title.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'faq_parmalink.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'faq_parmalink.unique' => 'Permalink นี้มีการใช้งานอยู่แล้ว กรุณาตรวจสอบข้อมูลอีกครั้ง',
                'faq_file.required' => 'กรุณาแนบไฟล์ PDF',
                'faq_file.mimes' => 'รองรับเฉพาะไฟล์ PDF เท่านั้น',
                'faq_file.max' => 'ขนาดไฟล์ต้องไม่เกิน 20MB',
            ]
        );

        if ($request->faq_show == 'on') {
            $show = 1;
        } else {
            $show = 2;
        }

        // ถ้าไม่ได้กรอก permalink เอง ให้สร้างจากชื่อหัวข้ออัตโนมัติ
        $parmalink = !empty($request->faq_parmalink) ? $request->faq_parmalink : $request->faq_title;
        $parmalink = $this->rewrite_url($parmalink);
        $parmalink = $this->ensureUniqueParmalink($parmalink);

        $data = new Faq;
        $data->faq_title        = $request->faq_title;
        $data->faq_parmalink    = $parmalink;
        $data->faq_order        = !empty($request->faq_order) ? $request->faq_order : 0;
        $data->faq_show         = $show;
        $data->created_by       = Auth::user()->displayname;
        $data->updated_by       = Auth::user()->displayname;
        $data->created_at       = date('Y-m-d H:i:s');
        $data->updated_at       = date('Y-m-d H:i:s');

        if ($request->hasFile('faq_file')) {
            $newFilename = uniqid() . '.' . $request->faq_file->extension();
            $data->faq_file = $newFilename;
            $file = $request->file('faq_file');
            $file->move('storage/faq_files/', $newFilename);
        }

        $data->save();

        return redirect()->route('faq.edit', [$data->id])->with('feedback', 'เพิ่มข้อมูลเรียบร้อยแล้ว!');
    }

    public function edit($id)
    {
        $breadcrumb = [
            ['name' => 'อัพเดต FAQ'],
        ];
        $title_page = 'อัพเดต FAQ';

        $data = Faq::findOrFail($id);

        return view('admin.faq.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => $data,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'faq_title' => 'required|max:255',
                'faq_parmalink' => 'nullable|max:255|unique:tb_faq,faq_parmalink,' . $id,
                'faq_file' => 'nullable|mimes:pdf|max:20480',
            ],
            [
                'faq_title.required' => 'กรุณากรอกชื่อหัวข้อ',
                'faq_title.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'faq_parmalink.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'faq_parmalink.unique' => 'Permalink นี้มีการใช้งานอยู่แล้ว กรุณาตรวจสอบข้อมูลอีกครั้ง',
                'faq_file.mimes' => 'รองรับเฉพาะไฟล์ PDF เท่านั้น',
                'faq_file.max' => 'ขนาดไฟล์ต้องไม่เกิน 20MB',
            ]
        );

        if ($request->faq_show == 'on') {
            $show = 1;
        } else {
            $show = 2;
        }

        $data = Faq::findOrFail($id);

        // ถ้าไม่ได้กรอก permalink เอง คงไว้ตามเดิม (ไม่สร้างใหม่จากชื่อ เพื่อไม่ให้ลิงก์ที่เคยแจกไปแล้วพัง)
        $parmalink = !empty($request->faq_parmalink) ? $this->rewrite_url($request->faq_parmalink) : $data->faq_parmalink;
        if ($parmalink != $data->faq_parmalink) {
            $parmalink = $this->ensureUniqueParmalink($parmalink, $id);
        }

        $data->faq_title        = $request->faq_title;
        $data->faq_parmalink    = $parmalink;
        $data->faq_order        = !empty($request->faq_order) ? $request->faq_order : 0;
        $data->faq_show         = $show;
        $data->updated_by       = Auth::user()->displayname;
        $data->updated_at       = date('Y-m-d H:i:s');

        if ($request->hasFile('faq_file')) {
            @unlink(Storage::disk('public')->path('faq_files/') . $data->faq_file);

            $newFilename = uniqid() . '.' . $request->faq_file->extension();
            $data->faq_file = $newFilename;
            $file = $request->file('faq_file');
            $file->move('storage/faq_files/', $newFilename);
        }

        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');
    }

    /**
     * หน้าเว็บที่ลูกค้าเปิดจากลิงก์ที่ copy ไป
     * เข้าแล้วจะเด้งไปเปิดไฟล์ PDF ทันที (เหมือนลิงก์ย่อ)
     */
    public function view($parmalink)
    {
        $data = Faq::where('faq_parmalink', $parmalink)->where('faq_show', 1)->first();

        if (empty($data) || empty($data->faq_file)) {
            abort(404);
        }

        return redirect(asset('storage/faq_files/' . $data->faq_file));
    }

    public function jsondata()
    {
        $data = Faq::orderBy('faq_order', 'asc')->orderBy('created_at', 'desc')->get();

        return Datatables::of($data)
            ->addColumn('faq_title', function ($data) {
                return $data->faq_title;
            })
            ->addColumn('faq_file', function ($data) {
                if (!empty($data->faq_file)) {
                    return '<a href="' . asset('storage/faq_files/' . $data->faq_file) . '" target="_blank">ดูไฟล์</a>';
                }
                return '<span class="text-danger">ไม่มีไฟล์</span>';
            })
            ->addColumn('faq_parmalink', function ($data) {
                $link = route('faq.view', $data->faq_parmalink);
                return '<a href="#" class="faq-copy-link" data-link="' . $link . '" title="คลิกเพื่อ copy ลิงก์"><i class="fa fa-copy"></i> Copy Link</a>';
            })
            ->addColumn('faq_show', function ($data) {
                return $data->faq_show;
            })
            ->addColumn('crated', function ($data) {
                return $data->created_at . '<br/><small><i class="fa fa-user"></i> ' . $data->created_by . '</small>';
            })
            ->addColumn('actions', function ($data) {
                $id = $data->id;
                $name = $data->faq_title;
                $status = $data->faq_show;
                return view('admin.faq.button', compact('id', 'status', 'name'));
            })
            ->escapeColumns([])
            ->addIndexColumn()
            ->make(true);
    }

    public function status($id)
    {
        $data = Faq::findOrFail($id);

        if ($data->faq_show == 2) {
            $status = 1;
        } elseif ($data->faq_show == 1) {
            $status = 2;
        }

        $data->faq_show    = $status;
        $data->updated_by  = Auth::user()->displayname;
        $data->updated_at  = date('Y-m-d H:i:s');
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');
    }

    public function delete(Request $request)
    {
        $check = Faq::findOrFail($request->deleteId);
        if (!empty($check)) {
            @unlink(Storage::disk('public')->path('faq_files/') . $check->faq_file);
        }

        Faq::where('id', $request->deleteId)->delete();

        return back()->with('feedback', 'ลบข้อมูลเรียบร้อยแล้ว!');
    }

    private function rewrite_url($url)
{
    $str_replace = strtolower(str_replace(" ", "-", $url));
    $data = preg_replace('/[^a-z0-9\_\- ]/i', '', $str_replace);
 
    // ตัดขีด/เว้นวรรคส่วนเกินหัว-ท้ายที่อาจเหลือ ให้ permalink ดูสะอาดขึ้น
    $data = trim($data, '-_ ');
 
    // [เพิ่มใหม่] ถ้าตัดภาษาไทย/สัญลักษณ์ออกหมดแล้วไม่เหลือ a-z0-9 เลยสักตัว
    // (เช่น ชื่อหัวข้อเป็นภาษาไทยล้วน) ให้สุ่มตัวอักษรภาษาอังกฤษ+ตัวเลขแทน
    if ($data === '' || !preg_match('/[a-z0-9]/i', $data)) {
        $data = $this->randomAsciiSlug();
    }
 
    return $data;
}
 
/**
 * [เพิ่มใหม่] สุ่มตัวอักษรภาษาอังกฤษ+ตัวเลข (a-z, 0-9) ความยาว 8 ตัว ไม่ต้องมีความหมาย
 * ใช้ตอนชื่อหัวข้อ FAQ เป็นภาษาไทยล้วน ทำให้ rewrite_url() ปกติได้ค่าว่างเปล่า
 */
private function randomAsciiSlug($length = 8)
{
    $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
    $result = '';
    for ($i = 0; $i < $length; $i++) {
        $result .= $characters[random_int(0, strlen($characters) - 1)];
    }
    return $result;
}

    /**
     * เช็คว่า permalink ซ้ำไหม ถ้าซ้ำให้ต่อท้ายด้วยตัวเลข (-1, -2, ...) จนกว่าจะไม่ซ้ำ
     */
    private function ensureUniqueParmalink($parmalink, $exceptId = null)
    {
        $original = $parmalink;
        $i = 1;
        while (
            Faq::where('faq_parmalink', $parmalink)
                ->when($exceptId, function ($q) use ($exceptId) {
                    $q->where('id', '!=', $exceptId);
                })
                ->exists()
        ) {
            $parmalink = $original . '-' . $i;
            $i++;
        }
        return $parmalink;
    }
}