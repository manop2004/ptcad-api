<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TbHomeProductCategory;
use Yajra\Datatables\Datatables;

class ProductCategoryController extends Controller
{
    /**
     * หน้า list (โครง DataTables — ข้อมูลจริงมาจาก jsondata())
     */
    public function index()
    {
        $breadcrumb = [
            ['name' => 'การ์ดสินค้าหน้าแรก'],
        ];
        $title_page = 'การ์ดสินค้าหน้าแรก';

        $count = TbHomeProductCategory::count();

        return view('admin.productcategory.main', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'count' => number_format($count),
        ]);
    }

    /**
     * ข้อมูล JSON สำหรับ DataTables (ajax) — pattern เดียวกับ ProductController::jsondata()
     */
    public function jsondata(Request $request)
    {
        $search = $request->get('search');
        $order  = $request->get('order');

        $columnorder = [
            'img',
            'title',
            'price',
            'sort_order',
            'featured',
            'status',
            'updated',
            'actions',
        ];

        if (empty($order)) {
            $sort = 'sort_order';
            $dir = 'asc';
        } else {
            $sort = $columnorder[$order[0]['column']] ?? 'sort_order';
            $dir = $order[0]['dir'] ?? 'asc';
        }

        // กัน sort ด้วยคอลัมน์คำนวณที่ไม่มีจริงใน DB
        if (in_array($sort, ['img', 'featured', 'status', 'updated', 'actions'])) {
            $sort = 'sort_order';
            $dir = 'asc';
        }

        $baseQuery = TbHomeProductCategory::query()
            ->when($search, function ($query, $search) {
                return $query->where('title', 'LIKE', '%' . $search . '%');
            });

        $data = (clone $baseQuery)->orderBy($sort, $dir)->get();

        $recordsTotal = TbHomeProductCategory::count();
        $recordsFiltered = (clone $baseQuery)->count();

        return Datatables::of($data)
            ->addColumn('img', function ($row) {
                if (!empty($row->image)) {
                    return "<img style='width:50px;' src='" . asset('storage/setting/' . $row->image) . "' alt='" . e($row->title) . "'>";
                }
                return "<span class='text-muted'>-</span>";
            })
            ->addColumn('title', function ($row) {
                $html = '<b>' . e($row->title) . '</b>';
                if (!empty($row->badge_text)) {
                    $html .= ' <span class="badge badge-info">' . e($row->badge_text) . '</span>';
                }
                if (!empty($row->subtitle)) {
                    $html .= '<br><small class="text-muted">' . e($row->subtitle) . '</small>';
                }
                return $html;
            })
            ->addColumn('price', function ($row) {
                return !empty($row->price) ? e($row->price) . ' ' . e($row->price_unit) : '-';
            })
            ->addColumn('sort_order', function ($row) {
                return $row->sort_order;
            })
            ->addColumn('featured', function ($row) {
                return $row->is_featured == 1
                    ? '<span class="badge badge-primary">เด่น</span>'
                    : '<span class="text-muted">-</span>';
            })
            ->addColumn('status', function ($row) {
                return view('admin.productcategory.button_status', compact('row'));
            })
            ->addColumn('updated', function ($row) {
                return $row->updated_at . '<br/><small><i class="fa fa-user"></i> ' . e($row->updated_by) . '</small>';
            })
            ->addColumn('actions', function ($row) {
                return view('admin.productcategory.button_actions', ['id' => $row->id]);
            })
            ->setTotalRecords($recordsTotal)
            ->setFilteredRecords($recordsFiltered)
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * ฟอร์มเพิ่มการ์ดใหม่
     */
    public function add()
    {
        $breadcrumb = [
            ['name' => 'เพิ่มการ์ดสินค้าหน้าแรก'],
        ];
        $title_page = 'เพิ่มการ์ดสินค้าหน้าแรก';

        return view('admin.productcategory.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => new TbHomeProductCategory(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
        ]);

        $data = new TbHomeProductCategory();
        $this->fillFromRequest($data, $request);
        $data->updated_by = Auth::user()->displayname;
        $data->save();

        return redirect()->route('productcategory.index')->with('feedback', 'เพิ่มการ์ดสินค้าเรียบร้อยแล้ว!');
    }

    public function edit($id)
    {
        $breadcrumb = [
            ['name' => 'แก้ไขการ์ดสินค้าหน้าแรก'],
        ];
        $title_page = 'แก้ไขการ์ดสินค้าหน้าแรก';

        $data = TbHomeProductCategory::findOrFail($id);

        return view('admin.productcategory.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => $data,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
        ]);

        $data = TbHomeProductCategory::findOrFail($id);
        $this->fillFromRequest($data, $request);
        $data->updated_by = Auth::user()->displayname;
        $data->save();

        return redirect()->route('productcategory.index')->with('feedback', 'อัพเดตการ์ดสินค้าเรียบร้อยแล้ว!');
    }

    public function destroy($id)
    {
        $data = TbHomeProductCategory::findOrFail($id);

        if (!empty($data->image)) {
            @unlink(public_path('storage/setting/') . $data->image);
        }

        $data->delete();

        return response()->json(['status' => 'success', 'message' => 'ลบการ์ดสินค้าเรียบร้อยแล้ว!']);
    }

    public function toggleStatus($id)
    {
        $data = TbHomeProductCategory::findOrFail($id);
        $data->status = $data->status == 1 ? 0 : 1;
        $data->save();

        return response()->json(['status' => 'success', 'new_status' => $data->status]);
    }

    private function fillFromRequest($data, Request $request)
    {
        $data->title        = $request->title;
        $data->subtitle     = $request->subtitle;
        $data->highlight    = $request->highlight;
        $data->feature1     = $request->feature1;
        $data->feature2     = $request->feature2;
        $data->feature3     = $request->feature3;
        $data->price        = $request->price;
        $data->price_unit   = $request->price_unit;
        $data->badge_text   = $request->badge_text;
        $data->is_featured  = !empty($request->is_featured) ? 1 : 0;
        $data->button_text  = !empty($request->button_text) ? $request->button_text : 'ดูรายละเอียด';
        $data->link         = $request->link;
        $data->sort_order   = !empty($request->sort_order) ? $request->sort_order : 0;
        $data->status       = !empty($request->status) ? 1 : 0;

        if ($request->hasFile('image')) {
            if (!empty($request->image_old)) {
                @unlink(public_path('storage/setting/') . $request->image_old);
            }
            $newFilename = uniqid() . '.' . $request->image->extension();
            $data->image = $newFilename;
            $file = $request->file('image');
            $file->move('storage/setting/', $newFilename);
        }
    }
}
