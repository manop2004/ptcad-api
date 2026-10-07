<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Providers\RouteServiceProvider;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Storage;

use App\Models\TbSoftware;
use App\Models\TbSoftwareNotify;
use App\Models\User;

class SoftwareController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $breadcrumb = [
            ['name' => 'ซอฟต์แวร์'],
        ];
        $title_page = 'ซอฟต์แวร์';
        $count = TbSoftware::count();

        return view('admin.software.main', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'count' => $count,
            'data' => '',
        ]);

    }

    public function add(){

        $breadcrumb = [
            ['name' => 'เพิ่มซอฟต์แวร์'],
        ];
        $title_page = 'เพิ่มซอฟต์แวร์';
        $users = User::select('id','name','lastname','level')->where('level',6)->get();

        return view('admin.software.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'users' => $users,
            'data' => '',
        ]);

    }

    public function crate(Request $request){

        $request->validate(
            [
                'userId' => 'required',
                'productCode' => 'required|max:255',
                'serial_number' => 'required|max:255',
                'license_type' => 'required|in:1,2',
                'date_start' => 'required|max:255',
                'date_exp' => 'required|max:255',
                'price' => 'required|max:255',
            ],
            [
                'userId.required' => 'กรุณาเลือกข้อมูล',
                'serial_number.required' => 'กรุณากรอกข้อมูล',
                'serial_number.max' => 'กรุณากรอกข้อมูล',
                'productCode.required' => 'กรุณากรอกข้อมูล',
                'productCode.max' => 'กรุณากรอกข้อความไม่เกิน 255 ตัวอักษร',
                'license_type.required' => 'กรุณาเลือกประเภท License',
                'license_type.in' => 'กรุณาเลือกประเภท License ให้ถูกต้อง',
                'date_start.required' => 'กรุณากรอกข้อมูล',
                'date_start.max' => 'กรุณากรอกข้อความไม่เกิน 255 ตัวอักษร',
                'date_exp.required' => 'กรุณากรอกข้อมูล',
                'date_exp.max' => 'กรุณากรอกข้อความไม่เกิน 255 ตัวอักษร',
                'price.required' => 'กรุณากรอกข้อมูล',
                'price.max' => 'กรุณากรอกข้อความไม่เกิน 255 ตัวอักษร',
            ]
        );


        if($request->show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        $data = new TbSoftware;
        $data->userId                   = $request->userId;
        $data->productCode              = $request->productCode;
        $data->serial_number            = $request->serial_number;
        $data->license_type             = $request->license_type;
        $data->date_start               = date("Y-m-d",strtotime($request->date_start));
        $data->date_exp                 = date("Y-m-d",strtotime($request->date_exp));
        $data->price                    = $this->rewrite($request->price);
        $data->note                     = $request->note;
        $data->show                     = $show;
        $data->created_by               = Auth::user()->displayname;
        $data->updated_by               = Auth::user()->displayname;
        $data->created_at               = date('Y-m-d H:i:s');
        $data->updated_at               = date('Y-m-d H:i:s');
        $data->save();

        $software = new TbSoftwareNotify;
        $software->userId                   = $request->userId;
        $software->softwareId               = $data->id;
        $software->productCode              = $request->productCode;
        $software->serial_number            = $request->serial_number;
        $software->license_type             = $request->license_type;
        $software->date_start               = date("Y-m-d",strtotime($request->date_start));
        $software->date_exp                 = date("Y-m-d",strtotime($request->date_exp));
        $software->price                    = $this->rewrite($request->price);
        $software->note                     = $request->note;
        $software->show                     = 1;
        $software->created_by               = 'SYSTEM';
        $software->updated_by               = 'SYSTEM';
        $software->created_at               = date('Y-m-d H:i:s');
        $software->updated_at               = date('Y-m-d H:i:s');
        $software->save();

        return redirect()->route('software.edit',['id'=>$data->id])->with('feedback', 'เพิ่มข้อมูลเรียบร้อยแล้ว!');

    }

    public function edit($id)
    {
        $breadcrumb = [
            ['name' => 'อัพเดตซอฟต์แวร์'],
        ];
        $title_page = 'อัพเดตซอฟต์แวร์';

        $data  = TbSoftware::findOrFail($id);
        $users = User::select('id','name','lastname','level')->where('level',6)->get();

        return view('admin.software.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => $data,
            'users' => $users,
        ]);
    }

    public function update(Request $request,$id){

        $request->validate(
            [
                'userId' => 'required',
                'productCode' => 'required|max:255',
                'serial_number' => 'required|max:255',
                'license_type' => 'required|in:1,2',
                'date_start' => 'required|max:255',
                'date_exp' => 'required|max:255',
                'price' => 'required|max:255',
            ],
            [
                'userId.required' => 'กรุณาเลือกข้อมูล',
                'productCode.required' => 'กรุณากรอกข้อมูล',
                'productCode.max' => 'กรุณากรอกข้อมูล',
                'serial_number.required' => 'กรุณากรอกข้อมูล',
                'serial_number.max' => 'กรุณากรอกข้อความไม่เกิน 255 ตัวอักษร',
                'license_type.required' => 'กรุณาเลือกประเภท License',
                'license_type.in' => 'กรุณาเลือกประเภท License ให้ถูกต้อง',
                'date_start.required' => 'กรุณากรอกข้อมูล',
                'date_start.max' => 'กรุณากรอกข้อความไม่เกิน 255 ตัวอักษร',
                'date_exp.required' => 'กรุณากรอกข้อมูล',
                'date_exp.max' => 'กรุณากรอกข้อความไม่เกิน 255 ตัวอักษร',
                'price.required' => 'กรุณากรอกข้อมูล',
                'price.max' => 'กรุณากรอกข้อความไม่เกิน 255 ตัวอักษร',
            ]
        );

        if($request->show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        $data = TbSoftware::findOrFail($id);
        $data->userId                   = $request->userId;
        $data->productCode              = $request->productCode;
        $data->serial_number            = $request->serial_number;
        $data->license_type             = $request->license_type;
        $data->date_start               = date("Y-m-d",strtotime($request->date_start));
        $data->date_exp                 = date("Y-m-d",strtotime($request->date_exp));
        $data->note                     = $request->note;
        $data->price                    = $this->rewrite($request->price);
        $data->show                     = $show;
        $data->updated_by               = Auth::user()->displayname;
        $data->updated_at               = date('Y-m-d H:i:s');
        $data->save();

        return redirect()->route('software.edit',['id'=>$data->id])->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function status($id){

        $data = TbSoftware::findOrFail($id);

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

        $id         = $request->deleteId;

        TbSoftware::where('id', $id)->delete();
        return back()->with('feedback', 'ลบข้อมูลเรียบร้อยแล้ว!');

    }

    private function rewrite($url){
        $str_replace = strtolower(str_replace(" ","-",$url));
        $data = preg_replace('/[^a-z0-9\_\- ]/i', '', $str_replace);
        return $data ;
    }

    public function jsondata()
    {

        $data = TbSoftware::select(
            'tb_software.id','tb_software.userId','tb_software.serial_number','tb_software.show',
            'tb_software.created_at','tb_software.created_by','tb_software.date_exp','tb_software.license_type',
            'users.name','users.lastname'
        )
        ->leftjoin('users','users.id','tb_software.userId')
        ->get();

        return Datatables::of($data)
                ->addColumn('fullname', function ($data) {
                    return $data->name.' '.$data->lastname;
                })
                ->addColumn('serial_number', function ($data) {
                    return $data->serial_number;
                })
                ->addColumn('license_type', function ($data) {
                    return $data->license_type == 2
                        ? '<span class="badge badge-info">Annual</span>'
                        : '<span class="badge badge-secondary">Perpetual</span>';
                })
                ->addColumn('date_exp', function ($data) {
                    return date("Y-m-d",strtotime($data->date_exp));
                })
                ->addColumn('show', function ($data) {
                    return $data->show;
                })
                ->addColumn('updated', function ($data) {
                    return $data->created_at.'<br/>'.$data->created_by;
                })
                ->addColumn('actions', function ($data) {
                    $id = $data->id;
                    $status = $data->show;
                    $name = $data->serial_number;
                    return view('admin.software.button', compact('id','status','name'));
                })
                ->escapeColumns([])
                ->addIndexColumn()
                ->make(true);
    }
        // ===== [เพิ่มใหม่] Civil ProMax License Key Import =====

    private array $civilProMaxColumnSkuMap = [
        '3 เดือน'  => 'CIVILPROMAX-3M',
        '6 เดือน'  => 'CIVILPROMAX-6M',
        '12 เดือน' => 'CIVILPROMAX-1Y',
    ];

    public function civilProMaxImportForm()
    {
        $stockSummary = \App\Models\LicenseKeyStock::selectRaw('detail_sku, count(*) as total')
            ->where('status', \App\Models\LicenseKeyStock::STATUS_AVAILABLE)
            ->whereIn('detail_sku', array_values($this->civilProMaxColumnSkuMap))
            ->groupBy('detail_sku')
            ->pluck('total', 'detail_sku');

        return view('admin.civilpromax.import', compact('stockSummary'));
    }

    public function civilProMaxImportStore(Request $request)
{
    $request->validate(['stock_file' => 'required|file|mimes:csv,txt']);
 
    $handle = fopen($request->file('stock_file')->getRealPath(), 'r');
 
    // -----------------------------------------------------------------
    // ขั้นที่ 1: ลองหาแถวหัวตารางแบบเดิมก่อน (คอลัมน์ 3/6/12 เดือน) - ไม่เปลี่ยนจากโค้ดเดิม
    // สแกนแค่ 10 แถวแรกพอ ไม่ต้องทั้งไฟล์
    // -----------------------------------------------------------------
    $columnIndexMap = [];
    $maxRowsToScan = 10;
    $rowsScanned = 0;
    $rowsBeforeHeader = []; // เก็บแถวที่อ่านผ่านไประหว่างหา header ไว้ เผื่อต้องใช้ตอน fallback
 
    while ($rowsScanned < $maxRowsToScan && ($row = fgetcsv($handle)) !== false) {
        $rowsScanned++;
        $cleanRow = array_map(fn($h) => trim(str_replace("\xEF\xBB\xBF", '', $h ?? '')), $row);
 
        $tempMap = [];
        foreach ($this->civilProMaxColumnSkuMap as $columnName => $sku) {
            $idx = array_search($columnName, $cleanRow, true);
            if ($idx !== false) {
                $tempMap[$idx] = $sku;
            }
        }
 
        if (count($tempMap) === count($this->civilProMaxColumnSkuMap)) {
            $columnIndexMap = $tempMap;
            break;
        }
 
        $rowsBeforeHeader[] = $row; // เก็บไว้เผื่อเป็นไฟล์แบบใหม่ (ไม่มี header 3 คอลัมน์แบบเดิม)
    }
 
    $imported = 0;
    $duplicated = 0;
    $unrecognized = []; // เก็บคีย์ที่หาระยะเวลาไม่เจอเลย (โหมดใหม่เท่านั้น)
 
    // -----------------------------------------------------------------
    // โหมดเดิม: เจอคอลัมน์ 3/6/12 เดือนครบ -> ทำงานแบบเดิมทุกอย่าง ไม่เปลี่ยน
    // -----------------------------------------------------------------
    if (!empty($columnIndexMap)) {
 
        while (($row = fgetcsv($handle)) !== false) {
            foreach ($columnIndexMap as $colIdx => $sku) {
                $key = trim($row[$colIdx] ?? '');
                if ($key === '') continue;
 
                if (\App\Models\LicenseKeyStock::where('license_key', $key)->exists()) {
                    $duplicated++;
                    continue;
                }
 
                \App\Models\LicenseKeyStock::create([
                    'detail_sku'  => $sku,
                    'license_key' => $key,
                    'status'      => \App\Models\LicenseKeyStock::STATUS_AVAILABLE,
                    'created_by'  => auth()->user()->displayname ?? 'ADMIN',
                ]);
                $imported++;
            }
        }
 
    // -----------------------------------------------------------------
    // [เพิ่มใหม่] โหมดใหม่: ไม่เจอคอลัมน์ 3/6/12 เดือน -> อ่านระยะเวลาจากในตัวคีย์เอง
    // -----------------------------------------------------------------
    } else {
 
        // periodMap: รหัสระยะเวลาที่ฝังในตัวคีย์ -> SKU จริงในระบบ
        // ถ้าในอนาคตมีระยะเวลาใหม่ (เช่น 2Y) แค่เพิ่มบรรทัดในนี้ ไม่ต้องแก้ที่อื่น
        $periodMap = [
            '3M' => 'CIVILPROMAX-3M',
            '6M' => 'CIVILPROMAX-6M',
            '1Y' => 'CIVILPROMAX-1Y',
        ];
 
        // รวมแถวที่เคยอ่านผ่านไปตอนหา header (สูงสุด 10 แถวแรก) เข้ากับแถวที่เหลือทั้งหมด
        $remainingRows = [];
        while (($row = fgetcsv($handle)) !== false) {
            $remainingRows[] = $row;
        }
        $allRows = array_merge($rowsBeforeHeader, $remainingRows);
 
        foreach ($allRows as $row) {
            $key = trim(str_replace("\xEF\xBB\xBF", '', $row[0] ?? ''));
            if ($key === '') continue;
 
            // ดึงรหัสระยะเวลาจากในตัวคีย์ เช่น "PTCADPAR-1Y-45ACAC89" -> "1Y"
            if (!preg_match('/(\d+)\s*(Y|M)\b/i', $key, $matches)) {
                $unrecognized[] = $key; // หาระยะเวลาในตัวคีย์นี้ไม่เจอ - ข้ามไป รายงานกลับให้เห็น
                continue;
            }
 
            $periodToken = strtoupper($matches[1] . $matches[2]); // เช่น "1Y", "3M"
            $sku = $periodMap[$periodToken] ?? null;
 
            if (empty($sku)) {
                $unrecognized[] = $key; // เจอรหัสระยะเวลาแต่ไม่รู้จัก (เช่น "9M" ที่ไม่เคยมี) - ข้ามไป
                continue;
            }
 
            if (\App\Models\LicenseKeyStock::where('license_key', $key)->exists()) {
                $duplicated++;
                continue;
            }
 
            \App\Models\LicenseKeyStock::create([
                'detail_sku'  => $sku,
                'license_key' => $key,
                'status'      => \App\Models\LicenseKeyStock::STATUS_AVAILABLE,
                'created_by'  => auth()->user()->displayname ?? 'ADMIN',
            ]);
            $imported++;
        }
    }
 
    fclose($handle);
 
    // -----------------------------------------------------------------
    // อัปเดตยอดสต็อกคงเหลือของทุก SKU ที่รู้จัก (ทำเสมอ ไม่ว่าจะโหมดไหน)
    // -----------------------------------------------------------------
    foreach (array_values($this->civilProMaxColumnSkuMap) as $sku) {
        $remaining = \App\Models\LicenseKeyStock::where('detail_sku', $sku)
            ->where('status', \App\Models\LicenseKeyStock::STATUS_AVAILABLE)->count();
 
        \App\Models\TbProductDetail::where('detail_sku', $sku)->update([
            'detail_stock' => $remaining,
            'updated_at'   => now(),
        ]);
    }
 
    $message = "นำเข้าสำเร็จ {$imported} คีย์ — ข้ามคีย์ซ้ำ {$duplicated} รายการ";
 
    if (!empty($unrecognized)) {
        $count = count($unrecognized);
        $sample = implode(', ', array_slice($unrecognized, 0, 5));
        $message .= " | ⚠️ หาระยะเวลาไม่เจอ {$count} คีย์ (ตัวอย่าง: {$sample}" . ($count > 5 ? ' ...' : '') . ")";
    }
 
    return back()->with('import_success', $message);
}
        public function civilProMaxStockList(Request $request)
    {
        $query = \App\Models\LicenseKeyStock::query()
            ->leftJoin('tb_order', 'tb_order.id', 'tb_license_key_stock.orderId')
            ->select('tb_license_key_stock.*', 'tb_order.orderNumber');

        if ($request->filled('sku') && $request->sku !== 'all') {
            $query->where('tb_license_key_stock.detail_sku', $request->sku);
        }
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('tb_license_key_stock.status', $request->status);
        }
        if ($request->filled('search')) {
            $query->where('tb_license_key_stock.license_key', 'like', '%' . $request->search . '%');
        }

        $keys = $query->orderByDesc('tb_license_key_stock.id')->paginate(30)->withQueryString();

        $summary = \App\Models\LicenseKeyStock::selectRaw('detail_sku, status, count(*) as total')
            ->groupBy('detail_sku', 'status')
            ->get();

        return view('admin.civilpromax.stock', compact('keys', 'summary'));
    }

}