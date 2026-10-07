<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\Datatables\Datatables;

use App\Models\Document;
use App\Models\TbSoftwareNotify;
use App\Models\LicenseKeyStock;

class DocumentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $breadcrumb = [
            ['name' => 'Document'],
        ];
        $title_page = 'Document - เอกสาร';

        $document = Document::count();

        return view('admin.document.main', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => '',
            'document' => $document,
        ]);
    }

    /**
     * หน้าแสดง Document ฝั่งลูกค้า — เห็นเฉพาะคนที่มี License เท่านั้น
     */
    public function frontendIndex()
{
    $userAuth = Auth::user();

    if (!$this->userHasLicense($userAuth)) {
        abort(403, 'หน้านี้สำหรับผู้ที่มี License เท่านั้น');
    }

    $breadcrumb = [
        ['route' => route('fronend.home'), 'name' => 'หน้าหลัก'],
        ['route' => '', 'name' => 'Document'],
    ];

    $documents = Document::where('document_show', 1)
        ->orderBy('document_order', 'asc')
        ->orderBy('created_at', 'desc')
        ->get();

    return view('fontend.account.documents', [
        'breadcrumb' => $breadcrumb,
        'documents' => $documents,
    ]);
}

/**
 * เช็คว่า user มี License ไหม — ทั้งจาก DB เว็บเรา และจาก PTCAD API ตรง (License ที่สร้างไม่ผ่านเว็บเรา)
 * แคชไว้ 10 นาที กันยิง API ซ้ำถี่เกินไป
 */
private function userHasLicense($userAuth): bool
{
    // ใช้ Session Key เดียวกับที่ account_sidebar.blade.php ใช้ — แชร์ผลลัพธ์กัน ไม่ยิง API ซ้ำ
    $cacheKey = 'has_license_check';
    $cacheTimeKey = 'has_license_check_time';

    if (session()->has($cacheKey) && (time() - session($cacheTimeKey, 0)) < 30) {
        return session($cacheKey);
    }

    $hasLocal = TbSoftwareNotify::where('userId', $userAuth->id)->where('show', 1)->exists()
        || LicenseKeyStock::join('tb_order', 'tb_order.id', 'tb_license_key_stock.orderId')
            ->where('tb_order.userCode', $userAuth->user_code)
            ->where('tb_license_key_stock.status', LicenseKeyStock::STATUS_USED)
            ->exists();

    $hasLicense = $hasLocal;

    if (!$hasLicense) {
        try {
            $ptcadService = app(\App\Services\PtcadLicenseService::class);
            $remoteResult = $ptcadService->getLicensesByEmail($userAuth->email, (string) $userAuth->id);
            $hasLicense = !empty($remoteResult['success']) && !empty($remoteResult['data']['licenses']);
        } catch (\Exception $e) {
            \Log::warning('DocumentController - เช็ค License จาก PTCAD ไม่ได้', [
                'userId' => $userAuth->id,
                'message' => $e->getMessage(),
            ]);
            $hasLicense = false;
        }
    }

    session([$cacheKey => $hasLicense, $cacheTimeKey => time()]);

    return $hasLicense;
}

    public function add()
    {
        $breadcrumb = [
            ['name' => 'เพิ่ม Document'],
        ];
        $title_page = 'เพิ่ม Document';

        return view('admin.document.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => '',
        ]);
    }

    public function crate(Request $request)
    {
        $request->validate(
            [
                'document_title' => 'required|max:255',
                'document_file' => 'required|mimes:pdf|max:20480',
            ],
            [
                'document_title.required' => 'กรุณากรอกชื่อหัวข้อ',
                'document_title.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'document_file.required' => 'กรุณาแนบไฟล์ PDF',
                'document_file.mimes' => 'รองรับเฉพาะไฟล์ PDF เท่านั้น',
                'document_file.max' => 'ขนาดไฟล์ต้องไม่เกิน 20MB',
            ]
        );

        $show = $request->document_show == 'on' ? 1 : 2;

        $data = new Document;
        $data->document_title = $request->document_title;
        $data->document_order = !empty($request->document_order) ? $request->document_order : 0;
        $data->document_show  = $show;
        $data->created_by     = Auth::user()->displayname;
        $data->updated_by     = Auth::user()->displayname;
        $data->created_at     = date('Y-m-d H:i:s');
        $data->updated_at     = date('Y-m-d H:i:s');

        if ($request->hasFile('document_file')) {
            $newFilename = uniqid() . '.' . $request->document_file->extension();
            $data->document_file = $newFilename;
            $file = $request->file('document_file');
            $file->move('storage/document_files/', $newFilename);
        }

        $data->save();

        return redirect()->route('document.edit', [$data->id])->with('feedback', 'เพิ่มข้อมูลเรียบร้อยแล้ว!');
    }

    public function edit($id)
    {
        $breadcrumb = [
            ['name' => 'อัพเดต Document'],
        ];
        $title_page = 'อัพเดต Document';

        $data = Document::findOrFail($id);

        return view('admin.document.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => $data,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'document_title' => 'required|max:255',
                'document_file' => 'nullable|mimes:pdf|max:20480',
            ],
            [
                'document_title.required' => 'กรุณากรอกชื่อหัวข้อ',
                'document_title.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'document_file.mimes' => 'รองรับเฉพาะไฟล์ PDF เท่านั้น',
                'document_file.max' => 'ขนาดไฟล์ต้องไม่เกิน 20MB',
            ]
        );

        $show = $request->document_show == 'on' ? 1 : 2;

        $data = Document::findOrFail($id);
        $data->document_title = $request->document_title;
        $data->document_order = !empty($request->document_order) ? $request->document_order : 0;
        $data->document_show  = $show;
        $data->updated_by     = Auth::user()->displayname;
        $data->updated_at     = date('Y-m-d H:i:s');

        if ($request->hasFile('document_file')) {
            @unlink(Storage::disk('public')->path('document_files/') . $data->document_file);

            $newFilename = uniqid() . '.' . $request->document_file->extension();
            $data->document_file = $newFilename;
            $file = $request->file('document_file');
            $file->move('storage/document_files/', $newFilename);
        }

        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');
    }

    public function jsondata()
    {
        $data = Document::orderBy('document_order', 'asc')->orderBy('created_at', 'desc')->get();

        return Datatables::of($data)
            ->addColumn('document_title', function ($data) {
                return $data->document_title;
            })
            ->addColumn('document_file', function ($data) {
                if (!empty($data->document_file)) {
                    return '<a href="' . asset('storage/document_files/' . $data->document_file) . '" target="_blank">ดูไฟล์</a>';
                }
                return '<span class="text-danger">ไม่มีไฟล์</span>';
            })
            ->addColumn('document_show', function ($data) {
                return $data->document_show;
            })
            ->addColumn('crated', function ($data) {
                return $data->created_at . '<br/><small><i class="fa fa-user"></i> ' . $data->created_by . '</small>';
            })
            ->addColumn('actions', function ($data) {
                $id = $data->id;
                $name = $data->document_title;
                $status = $data->document_show;
                return view('admin.document.button', compact('id', 'status', 'name'));
            })
            ->escapeColumns([])
            ->addIndexColumn()
            ->make(true);
    }

    public function status($id)
    {
        $data = Document::findOrFail($id);
        $data->document_show = $data->document_show == 1 ? 2 : 1;
        $data->updated_by = Auth::user()->displayname;
        $data->updated_at = date('Y-m-d H:i:s');
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');
    }

    public function delete(Request $request)
    {
        $check = Document::findOrFail($request->deleteId);
        if (!empty($check)) {
            @unlink(Storage::disk('public')->path('document_files/') . $check->document_file);
        }

        Document::where('id', $request->deleteId)->delete();

        return back()->with('feedback', 'ลบข้อมูลเรียบร้อยแล้ว!');
    }
}