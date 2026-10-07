<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Providers\RouteServiceProvider;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\TbPromotionCalendar;
use App\Models\User;
use App\Models\HistoryCalandar;
use App\Models\TbPromotionSettingLinenotify;
use App\Models\HistoryPdpa;
use App\Exports\userConsentList;

class PromotionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $breadcrumb = [
            ['name' => 'โปรโมชั่น'],
        ];
        $title_page = 'โปรโมชั่น';
        $count = TbPromotionCalendar::count();

        return view('admin.promotion.main', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'count' => $count,
            'data' => '',
        ]);

    }

    public function calendar(){

        $breadcrumb = [
            ['name' => 'ปฎิทินโปรโมชั่น'],
        ];
        $title_page = 'ปฎิทินโปรโมชั่น';

        return view('admin.promotion.calendar', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => '',
        ]);

    }

    public function add(){

        $breadcrumb = [
            ['name' => 'เพิ่มโปรโมชั่น'],
        ];
        $title_page = 'เพิ่มโปรโมชั่น';

        return view('admin.promotion.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => '',
        ]);

    }

    public function crate(Request $request){

        $request->validate(
            [
                'promo_name' => 'required',
                'promo_img' => 'max:1024',
            ],
            [
                'promo_name.required' => 'กรุณาเลือกกรอกข้อมูล',
                'promo_img.max' => 'ไม่สามารถอัพโหลดภาพได้เนื่องจากภาพมีขนาดใหญ่เกินไป กรุณาลดขนาดไฟล์ไม่เกิน 1MB',
            ]
        );

        if($request->promo_show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        if(!empty($request->line_notify_group1)){
            $line_notify_group1 = 1;
        }else{
            $line_notify_group1 = 2;
        }

        if(!empty($request->line_notify_group2)){
            $line_notify_group2 = 1;
        }else{
            $line_notify_group2 = 2;
        }

        if(!empty($request->promo_type)){
            $promo_type = 2;
        }else{
            $promo_type = 1;
        }

        $data = new TbPromotionCalendar;
        $data->promo_name              = $request->promo_name;
        $data->promo_link              = $request->promo_link;
        $data->promo_note              = $request->promo_note;
        $data->promo_color             = $request->promo_color;
        $data->promo_type              = $promo_type;
        if($request->promo_type == 2){
            $data->promo_start_date        = date("Y-m-d");
            $data->promo_start_date_status = 2;
            $data->promo_end_date          = null;
            $data->promo_end_date_status   = 1;
        }else{
            $data->promo_start_date        = date("Y-m-d",strtotime($request->promo_start_date));
            $data->promo_start_date_status = 2;
            $data->promo_end_date          = date("Y-m-d",strtotime($request->promo_end_date));
            $data->promo_end_date_status   = 2;
        }
        $data->line_notify_group1      = $line_notify_group1;
        $data->line_notify_group2      = $line_notify_group2;
        $data->promo_show              = $show;
        $data->created_by              = Auth::user()->displayname;
        $data->updated_by              = Auth::user()->displayname;
        $data->created_at              = date('Y-m-d H:i:s');
        $data->updated_at              = date('Y-m-d H:i:s');

        if (!empty($request->promo_img)) {

            if ($request->hasFile('promo_img')) {
                @unlink(Storage::disk('public')->path('promotion/') . $request->promo_img_old);

                $newFilename = uniqid() . '.' . $request->promo_img->extension();
                $data->promo_img = $newFilename;
                $file = $request->file('promo_img');
                $file->move('storage/promotion/', $newFilename);
            }

        }

        $data->save();

        if($line_notify_group1 == 1){
            $group1 = TbPromotionSettingLinenotify::where('grouptype1',1)->get();

            foreach($group1 as $get1){
                $history1 = new HistoryCalandar;
                $history1->promotionId              = $data->id;
                $history1->groupType                = 1;
                $history1->groupName                = $get1->groupname;
                $history1->token_notify             = $get1->token_linenotify;
                $history1->show                     = 1;
                $history1->save();
            }
        }

        if($line_notify_group2 == 1){
            $group2 = TbPromotionSettingLinenotify::where('grouptype2',1)->get();

            foreach($group2 as $get2){
                $history2 = new HistoryCalandar;
                $history2->promotionId              = $data->id;
                $history2->groupType                = 2;
                $history2->groupName                = $get2->groupname;
                $history2->token_notify             = $get2->token_linenotify;
                $history2->show                     = 1;
                $history2->save();
            }
        }

        return redirect()->route('promotion.edit',[$data->id])->with('feedback', 'เพิ่มข้อมูลเรียบร้อยแล้ว!');

    }

    public function edit($id)
    {
        $breadcrumb = [
            ['name' => 'อัพเดตโปรโมชั่น'],
        ];
        $title_page = 'อัพเดตโปรโมชั่น';

        $data = TbPromotionCalendar::findOrFail($id);

        return view('admin.promotion.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => $data,
        ]);
    }

    public function update(Request $request,$id){

        $request->validate(
            [
                'promo_name' => 'required',
                'promo_img' => 'max:1024',
            ],
            [
                'promo_name.required' => 'กรุณาเลือกกรอกข้อมูล',
                'promo_img.max' => 'ไม่สามารถอัพโหลดภาพได้เนื่องจากภาพมีขนาดใหญ่เกินไป กรุณาลดขนาดไฟล์ไม่เกิน 1MB',
            ]
        );

        if($request->promo_show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        if(!empty($request->line_notify_group1)){
            $line_notify_group1 = 1;
        }else{
            $line_notify_group1 = 2;
        }

        if(!empty($request->line_notify_group2)){
            $line_notify_group2 = 1;
        }else{
            $line_notify_group2 = 2;
        }

        if(!empty($request->promo_type)){
            $promo_type = 2;
        }else{
            $promo_type = 1;
        }


        $data = TbPromotionCalendar::findOrFail($id);

        $data->promo_name              = $request->promo_name;
        $data->promo_link              = $request->promo_link;
        $data->promo_note              = $request->promo_note;
        $data->promo_color             = $request->promo_color;
        $data->promo_type              = $promo_type;
        if($request->promo_type == 2){
            $data->promo_start_date        = date("Y-m-d");
            $data->promo_start_date_status = 2;
            $data->promo_end_date          = null;
            $data->promo_end_date_status   = 1;
        }else{
            $data->promo_start_date        = date("Y-m-d",strtotime($request->promo_start_date));
            $data->promo_start_date_status = 2;
            $data->promo_end_date          = date("Y-m-d",strtotime($request->promo_end_date));
            $data->promo_end_date_status   = 2;
        }
        $data->line_notify_group1      = $line_notify_group1;
        $data->line_notify_group2      = $line_notify_group2;
        $data->promo_show              = $show;
        $data->updated_by              = Auth::user()->displayname;
        $data->updated_at              = date('Y-m-d H:i:s');

        if (!empty($request->promo_img)) {

            if ($request->hasFile('promo_img')) {
                @unlink(Storage::disk('public')->path('promotion/') . $request->promo_img_old);

                $newFilename = uniqid() . '.' . $request->promo_img->extension();
                $data->promo_img = $newFilename;
                $file = $request->file('promo_img');
                $file->move('storage/promotion/', $newFilename);
            }

        }

        $data->save();

        //อัพเดตตาราง history_calandar หากมีการยกเลิกการแจ้งเตือนเก่า
        $check1 = HistoryCalandar::where('promotionId',$id)->where('groupType',1)->get();
        if(count($check1) != 0){
            foreach($check1 as $get1){
                $history1_edit = HistoryCalandar::where('promotionId',$id)->where('groupType',1)->first();
                $history1_edit->show      = $line_notify_group1;
                $history1_edit->save();
            }
        }else{
            if($line_notify_group1 == 1){

                $group1 = TbPromotionSettingLinenotify::where('grouptype1',1)->get();

                foreach($group1 as $get2){
                    $history1 = new HistoryCalandar;
                    $history1->promotionId              = $id;
                    $history1->groupType                = 1;
                    $history1->groupName                = $get2->groupname;
                    $history1->token_notify             = $get2->token_linenotify;
                    $history1->show                     = 1;
                    $history1->save();
                }
            }
        }

        $check2 = HistoryCalandar::where('promotionId',$id)->where('groupType',2)->get();
        if(count($check2) != 0){
            foreach($check2 as $get3){
                $history2_edit = HistoryCalandar::where('promotionId',$id)->where('groupType',2)->first();
                $history2_edit->show      = $line_notify_group2;
                $history2_edit->save();
            }
        }else{
            if($line_notify_group2 == 1){

                $group2 = TbPromotionSettingLinenotify::where('grouptype2',1)->get();

                foreach($group2 as $get4){
                    $history2 = new HistoryCalandar;
                    $history2->promotionId              = $id;
                    $history2->groupType                = 2;
                    $history2->groupName                = $get4->groupname;
                    $history2->token_notify             = $get4->token_linenotify;
                    $history2->show                     = 1;
                    $history2->save();
                }
            }
        }

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }

    public function status($id){

        $data = TbPromotionCalendar::findOrFail($id);

        if($data->promo_show == 2){
            $status = 1;
        }elseif($data->promo_show == 1) {
            $status = 2;
        }

        $data->promo_show                  = $status;
        $data->updated_by                   = Auth::user()->displayname;
        $data->updated_at                   = date('Y-m-d H:i:s');
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');
    }

    public function delete(Request $request){

        $check = TbPromotionCalendar::findOrFail($request->deleteId);
        if(!empty($check)){
            @unlink(Storage::disk('public')->path('promo/') . $check->promo_img);
        }

        TbPromotionCalendar::where('id', $request->deleteId)->delete();
        return back()->with('feedback', 'ลบข้อมูลเรียบร้อยแล้ว!');

    }

    public function deleteImg(Request $request){

        $check = TbPromotionCalendar::findOrfail($request->deleteId);
        if (!empty($check->promo_img)) {
            @unlink(Storage::disk('public')->path('promo/').$check->promo_img);
        }

        $data = TbPromotionCalendar::findOrfail($request->deleteId);
        $data->promo_img              = null;
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }


    public function jsondata()
    {

        $data = TbPromotionCalendar::get();

        return Datatables::of($data)
                ->addColumn('promo_name', function ($data) {
                    return $data->promo_name;
                })
                ->addColumn('promo_date', function ($data) {
                    if($data->promo_end_date_status == 2){
                        return date("d-m-Y",strtotime($data->promo_start_date)).' - '.date("d-m-Y",strtotime($data->promo_end_date));
                    }else{
                        return date("d-m-Y",strtotime($data->promo_start_date));
                    }
                })
                ->addColumn('promo_show', function ($data) {
                    return $data->promo_show;
                })
                ->addColumn('updated', function ($data) {
                    return $data->created_at.'<br/>'.$data->updated_by;
                })
                ->addColumn('actions', function ($data) {
                    $id = $data->id;
                    $status = $data->promo_show;
                    $name = $data->promo_note;
                    return view('admin.promotion.button', compact('id','status','name'));
                })
                ->escapeColumns([])
                ->addIndexColumn()
                ->make(true);
    }

    public function calendarJson(){

        $datas = TbPromotionCalendar::where('promo_type',1)->where('promo_show',1)->get();

        foreach($datas as $data)
        {

            $response[] = array(
                'title' => $data->promo_name,
                'start' => date("Y-m-d",strtotime($data->promo_start_date)),
                'end' => date("Y-m-d",strtotime($data->promo_end_date)),
                'allDay' => true,
                'url' => route('fronend.preview.promotion',$data->id),
                'className' => $data->promo_color
            );
        }

        return $response;

    }

    public function pdpa(){

        $breadcrumb = [
            ['name' => 'รายชื่อที่อนุญาติให้ใช้ข้อมูล (PDPA)'],
        ];
        $title_page = 'รายชื่อที่อนุญาติให้ใช้ข้อมูล (PDPA)';

        return view('admin.promotion.pdpa', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => '',
        ]);

    }

    public function pdpaJsond(){

        $result_news = HistoryPdpa::where('pdpa_news',1)->count();
        $result_article = HistoryPdpa::where('pdpa_article',1)->count();
        $result_product = HistoryPdpa::where('pdpa_product',1)->count();
        $result_All = HistoryPdpa::where('pdpa_news',1)->where('pdpa_article',1)->where('pdpa_product',1)->count();

        $response[] = array(
            'news'=>$result_news,
            'article'=>$result_article,
            'product'=>$result_product,
            'all_'=>$result_All,
            'd_news'=>number_format($result_news),
            'd_article'=>number_format($result_article),
            'd_product'=>number_format($result_product),
            'd_all_'=>number_format($result_All),
        );
        return $response;

    }

    public function jsonTable(Request $request){


        $type = $request->get('type');

        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->get('search');
        $order = $request->get('order');

        $columnorder = array(
            'id',
            'pro_img',
            'pro_name',
            'pro_stu_id',
            'pro_status',
        );

        if (empty($order)) {
            $sort = 'created_at';
            $dir = 'desc';
        } else {
            $sort = $columnorder[$order[0]['column']];
            $dir = $order[0]['dir'];
        }

        $data = HistoryPdpa::
        when($type, function ($query, $type) {
            if(!empty($type)){

                if($type == 1){
                    return $query->where('pdpa_news',1);
                }else if($type == 2){
                    return $query->where('pdpa_article',1);
                }else if($type == 3){
                    return $query->where('pdpa_product',1);
                }else{
                    return $query->where('pdpa_product',1)->where('pdpa_article',1)->where('pdpa_news',1);
                }
            }
        })
        ->orderBy('created_at','desc')
        ->offset($start)
        ->limit($length)
        ->get();

        $recordsTotal = HistoryPdpa::
        when($type, function ($query, $type) {
            if(!empty($type)){

                if($type == 1){
                    return $query->where('pdpa_news',1);
                }else if($type == 2){
                    return $query->where('pdpa_article',1);
                }else if($type == 3){
                    return $query->where('pdpa_product',1);
                }else{
                    return $query->where('pdpa_product',1)->where('pdpa_article',1)->where('pdpa_news',1);
                }
            }
        })
        ->count();

        $recordsFiltered = HistoryPdpa::
        when($type, function ($query, $type) {
            if(!empty($type)){

                if($type == 1){
                    return $query->where('pdpa_news',1);
                }else if($type == 2){
                    return $query->where('pdpa_article',1);
                }else if($type == 3){
                    return $query->where('pdpa_product',1);
                }else{
                    return $query->where('pdpa_product',1)->where('pdpa_article',1)->where('pdpa_news',1);
                }
            }
        })
        ->orderBy('created_at','desc')
        ->count();

        return Datatables::of($data)
            ->addColumn('fullname', function ($data) {

                return $data->fullname;
            })
            ->addColumn('tel', function ($data) {

                return $data->tel;
            })
            ->addColumn('email', function ($data) {

                return $data->email;
            })
            ->addColumn('news', function ($data) {
                if($data->pdpa_news == 1){
                    return '<span class="badge badge-success wh-60">อนุญาต</span>';
                }else{
                    return '<span class="badge badge-danger wh-60">ไม่อนุญาต</span>';
                }
            })
            ->addColumn('product', function ($data) {
                if($data->pdpa_article == 1){
                    return '<span class="badge badge-success wh-60">อนุญาต</span>';
                }else{
                    return '<span class="badge badge-danger wh-60">ไม่อนุญาต</span>';
                }
            })
            ->addColumn('article', function ($data) {
                if($data->pdpa_product == 1){
                    return '<span class="badge badge-success wh-60">อนุญาต</span>';
                }else{
                    return '<span class="badge badge-danger wh-60">ไม่อนุญาต</span>';
                }
            })
            ->setTotalRecords($recordsTotal)
            ->setFilteredRecords($recordsFiltered)
            ->escapeColumns([])
            ->skipPaging()
            ->addIndexColumn()
            ->make(true);

    }

    public function pdpaExport(Request $request)
    {
        $type = $request->type;

        return Excel::download(new userConsentList($type), 'list_user_consent_'.date('Y-m-d_H:i:s').'.xlsx');

    }


    public function reportNotify()
    {

        $breadcrumb = [
            ['name' => 'รายงานการแจ้งเตือนโปรโมชั่น'],
        ];
        $title_page = 'รายงานการแจ้งเตือนโปรโมชั่น';
        $count = HistoryCalandar::count();

        return view('admin.promotion.reportnotify', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'count' => $count,
            'data' => '',
        ]);

    }

    public function reportNotifyJson()
    {

        $data = HistoryCalandar::with('tb_promotion_calendar')->get();

        return Datatables::of($data)
                ->addColumn('groupName', function ($data) {
                    return $data->groupName;
                })
                ->addColumn('promo_name', function ($data) {
                    return $data->tb_promotion_calendar->promo_name;
                })
                ->addColumn('send_status_startDate', function ($data) {
                    return $data->send_status_startDate;
                })
                ->addColumn('send_message_startDate', function ($data) {
                    return $data->send_message_startDate;
                })
                ->addColumn('send_status_EndDate', function ($data) {
                    return $data->send_status_EndDate;
                })
                ->addColumn('send_message_EndDate', function ($data) {
                    return $data->send_message_EndDate;
                })
                ->addColumn('show', function ($data) {
                    return $data->show;
                })
                ->addColumn('updated', function ($data) {
                    return $data->updated_at;
                })
                ->escapeColumns([])
                ->addIndexColumn()
                ->make(true);
    }


}
