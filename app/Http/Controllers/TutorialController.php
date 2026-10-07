<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Providers\RouteServiceProvider;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use App\Models\TbTutorial;
use App\Models\LogTag;
use App\Models\TbBanner;
use App\Models\TbAd;
use App\Models\TbSettingAd;
use App\Models\TbSetting;
use App\Models\User;

class TutorialController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        $breadcrumb = [
            ['name' => 'Tutorial'],
        ];
        $title_page = 'Tutorial';

        if(!empty($request)){
            $search_tutorial = ['staffId' => !empty($request->staffId) ? $request->staffId : null,
                                'date_start' => !empty($request->date_start) ? $request->date_start : null,
                                'date_end' => !empty($request->date_end) ? $request->date_end : null,
                            ];

            $tutorial = TbTutorial::where(function ($query) use ($request) {
                    if(!empty($request->staffId)){
                        $query->where('user_id', $request->staffId);
                    }
                    if(!empty($request->date_start)){
                        $query->where('created_at', '>=', $request->date_start . ' 00:00:00');
                    }
                    if(!empty($request->date_end)){
                        $query->where('created_at', '<=', $request->date_end . ' 23:59:59');
                    }
                })->count();
        }else{
            $tutorial   = TbTutorial::count();
        }

        return view('admin.tutorial.main', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => '',
            'tutorial' => $tutorial,
            'search_tutorial' => $search_tutorial,
        ]);

    }

    public function add(){

        $breadcrumb = [
            ['name' => 'เพิ่ม Tutorial'],
        ];
        $title_page = 'เพิ่ม Tutorial';

        $usersStaff = User::whereIn('level',[1,2,3,4,5,7,8])->get();

        $staffId = Auth::user()->id;

        return view('admin.tutorial.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => '',
            'usersStaff' => $usersStaff,
            'staffId' => $staffId,
        ]);

    }

    public function crate(Request $request){

        $request->validate(
            [
                'tut_name' => 'required|max:255',
                'tut_parmalink' => 'required|max:255|unique:tb_tutorial',
            ],
            [
                'tut_name.required' => 'กรุณากรอกข้อมูล',
                'tut_name.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'tut_parmalink.required' => 'กรุณากรอกข้อมูล',
                'tut_parmalink.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'tut_parmalink.unique' => 'Parmalink นี้มีการใช้งานอยู่แล้ว กรุณาตรวจสอบข้อมูลอีกครั้ง',
            ]
        );

        if($request->tut_show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        if($request->tut_keyword != ''){
            $tut_keyword = implode(",", $request->tut_keyword);
        } else {
            $tut_keyword = '';
        }

        $data = new TbTutorial;
        $data->tut_name                 = $request->tut_name;
        $data->tut_group = $request->tut_group;
        $data->tut_sort_order = $request->tut_sort_order;
        $data->tut_keyword              = $tut_keyword;
        $data->tut_detail               = $request->tut_detail;
        $data->tut_seo_detail           = $request->tut_seo_detail;
        $data->tut_parmalink            = $this->rewrite_url($request->tut_parmalink);
        $data->tut_duration             = $request->tut_duration;
        $data->tut_show                 = $show;
        $data->created_by               = Auth::user()->displayname;
        $data->updated_by               = Auth::user()->displayname;
        $data->created_at               = date('Y-m-d H:i:s');
        $data->updated_at               = date('Y-m-d H:i:s');
        $data->user_id                  = $request->user_id;

        if (!empty($request->tut_thumb)) {

    if ($request->hasFile('tut_thumb')) {
        @unlink(Storage::disk('public')->path('tutorial/') . $request->tut_thumb_old);

        $newFilename = uniqid() . '.' . $request->tut_thumb->extension();
        $data->tut_thumb = $newFilename;
        $file = $request->file('tut_thumb');
        $file->move('storage/tutorial/', $newFilename);
    }

} elseif (!empty($request->tut_thumb_auto)) {
    // ใช้รูปปกที่ระบบดึงมาจาก YouTube/Vimeo อัตโนมัติ (ไฟล์ถูกบันทึกไว้แล้วที่ storage/tutorial/)
    $data->tut_thumb = $request->tut_thumb_auto;
}

        if (!empty($request->tut_video)) {
            $data->tut_video = $request->tut_video;
        }

        $data->save();

        // เปลี่ยนเป็นบรรทัดนี้แทนครับ!
        return back()->with('feedback', 'เพิ่มข้อมูลเรียบร้อยแล้ว!');
    }

    public function edit($id)
    {
        $breadcrumb = [
            ['name' => 'อัพเดต Tutorial'],
        ];

        $title_page = 'อัพเดต Tutorial';
        $data = TbTutorial::findOrFail($id);

        $usersStaff = User::whereIn('level',[1,2,3,4,5,7,8])->get();

        $staffId = !empty($data->user_id) ? $data->user_id : '';

        return view('admin.tutorial.form', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => $data,
            'usersStaff' => $usersStaff,
            'staffId' => $staffId,
        ]);
    }

    public function update(Request $request,$id){

        $request->validate(
            [
                'tut_name' => 'required|max:255',
                'tut_parmalink' => 'required|max:255|unique:tb_tutorial,tut_parmalink,'.$id,
            ],
            [
                'tut_name.required' => 'กรุณากรอกข้อมูล',
                'tut_name.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'tut_parmalink.required' => 'กรุณากรอกข้อมูล',
                'tut_parmalink.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'tut_parmalink.unique' => 'Parmalink นี้มีการใช้งานอยู่แล้ว กรุณาตรวจสอบข้อมูลอีกครั้ง',
            ]
        );

        if($request->tut_show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        if($request->tut_keyword != ''){
            $tut_keyword = implode(",", $request->tut_keyword);
        } else {
            $tut_keyword = '';
        }

        $data = TbTutorial::findOrfail($id);
        $data->tut_name                 = $request->tut_name;
        $data->tut_keyword              = $tut_keyword;
        $data->tut_detail               = $request->tut_detail;
        $data->tut_seo_detail           = $request->tut_seo_detail;
        $data->tut_parmalink            = $this->rewrite_url($request->tut_parmalink);
        $data->tut_duration             = $request->tut_duration;
        $data->tut_group                = $request->tut_group;
        $data->tut_sort_order           = $request->tut_sort_order;
        $data->tut_show                 = $show;
        $data->updated_by               = Auth::user()->displayname;
        $data->updated_at               = date('Y-m-d H:i:s');
        $data->user_id                  = $request->user_id;

        if (!empty($request->tut_thumb)) {

    if ($request->hasFile('tut_thumb')) {
        @unlink(Storage::disk('public')->path('tutorial/') . $request->tut_thumb_old);

        $newFilename = uniqid() . '.' . $request->tut_thumb->extension();
        $data->tut_thumb = $newFilename;
        $file = $request->file('tut_thumb');
        $file->move('storage/tutorial/', $newFilename);
    }

} elseif (!empty($request->tut_thumb_auto)) {
    // ใช้รูปปกที่ระบบดึงมาจาก YouTube/Vimeo อัตโนมัติ (ไฟล์ถูกบันทึกไว้แล้วที่ storage/tutorial/)
    $data->tut_thumb = $request->tut_thumb_auto;
}

        if (!empty($request->tut_video)) {
            $data->tut_video = $request->tut_video;
        }

        $data->save();

        $log = LogTag::first();

        if(!empty($log)){
            $tutorialTags = explode(",",$log->value);
            $TagNew = explode(",",$tut_keyword);

            $totalArray =   array_merge($tutorialTags,$TagNew);//รวม array
            $setlog =   array_unique($totalArray);//ลบ array ที่ซ้ำออก เลือกแค่ 1

            $setlogBase = implode(",", $setlog);

            $loh_history        = LogTag::first();
            $loh_history->value = $setlogBase;
            $loh_history->save();
        }else{

            $loh_history        = new LogTag;
            $loh_history->value = $tut_keyword;
            $loh_history->save();
        }

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');

    }
    public function fetchVideoInfo(Request $request)
{
    $request->validate(['video_url' => 'required|url']);
    $url = $request->video_url;

    try {
        $duration = null;
        $thumbSourceUrl = null;

        // ===== ตรวจว่าเป็น YouTube หรือ Vimeo =====
        if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $url, $m)) {
            // ---------- YouTube ----------
            $videoId = $m[1];
            $apiKey = env('YOUTUBE_API_KEY');

            if (empty($apiKey)) {
                return response()->json(['success' => false, 'message' => 'ยังไม่ได้ตั้งค่า YOUTUBE_API_KEY ใน .env'], 500);
            }

            $resp = \Illuminate\Support\Facades\Http::get('https://www.googleapis.com/youtube/v3/videos', [
                'part' => 'contentDetails',
                'id'   => $videoId,
                'key'  => $apiKey,
            ]);

            if (!$resp->successful() || empty($resp->json('items.0.contentDetails.duration'))) {
                return response()->json(['success' => false, 'message' => 'ไม่พบข้อมูลวิดีโอนี้ใน YouTube กรุณาตรวจสอบลิงก์'], 422);
            }

            $iso = $resp->json('items.0.contentDetails.duration'); // เช่น PT12M48S
            $duration = $this->formatIsoDuration($iso);
            $thumbSourceUrl = "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg";

        } elseif (preg_match('/vimeo\.com\/(\d+)/', $url, $m)) {
            // ---------- Vimeo ----------
            $resp = \Illuminate\Support\Facades\Http::get('https://vimeo.com/api/oembed.json', ['url' => $url]);

            if (!$resp->successful()) {
                return response()->json(['success' => false, 'message' => 'ไม่พบข้อมูลวิดีโอนี้ใน Vimeo กรุณาตรวจสอบลิงก์'], 422);
            }

            $seconds = (int) $resp->json('duration', 0);
            $duration = $this->formatSecondsDuration($seconds);
            $thumbSourceUrl = $resp->json('thumbnail_url');

        } else {
            return response()->json(['success' => false, 'message' => 'ลิงก์นี้ไม่ใช่ YouTube หรือ Vimeo ที่รองรับ'], 422);
        }

        // ===== ดาวน์โหลดรูปปกมาเก็บใน storage เหมือนอัปโหลดเอง (ไม่กระทบโค้ดส่วนอื่น) =====
        $imageResp = \Illuminate\Support\Facades\Http::get($thumbSourceUrl);
        if (!$imageResp->successful()) {
            return response()->json(['success' => false, 'message' => 'ดึงรูปปกไม่สำเร็จ'], 422);
        }

        $newFilename = uniqid() . '.jpg';
file_put_contents(public_path('storage/tutorial/' . $newFilename), $imageResp->body());

        return response()->json([
            'success'      => true,
            'duration'     => $duration,
            'thumb_filename' => $newFilename,
            'thumb_preview_url' => asset('storage/tutorial/' . $newFilename),
        ]);

    } catch (\Exception $e) {
        \Log::error('[Tutorial] fetchVideoInfo exception: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'เกิดข้อผิดพลาด กรุณาลองใหม่'], 500);
    }
}

/**
 * แปลง ISO 8601 duration (เช่น PT12M48S) เป็นรูปแบบ mm:ss หรือ hh:mm:ss
 */
private function formatIsoDuration(string $iso): string
{
    $interval = new \DateInterval($iso);
    $h = $interval->h + ($interval->d * 24);
    $m = $interval->i;
    $s = $interval->s;

    if ($h > 0) {
        return sprintf('%d:%02d:%02d', $h, $m, $s);
    }
    return sprintf('%d:%02d', $m, $s);
}

/**
 * แปลงจำนวนวินาที (Vimeo) เป็นรูปแบบ mm:ss หรือ hh:mm:ss
 */
private function formatSecondsDuration(int $totalSeconds): string
{
    $h = intdiv($totalSeconds, 3600);
    $m = intdiv($totalSeconds % 3600, 60);
    $s = $totalSeconds % 60;

    if ($h > 0) {
        return sprintf('%d:%02d:%02d', $h, $m, $s);
    }
    return sprintf('%d:%02d', $m, $s);
}

    public function jsondata(Request $request)
    {

        if(!empty($request)){
            $data = TbTutorial::select('tb_tutorial.id', 'tb_tutorial.tut_name', 'tb_tutorial.tut_keyword', 'tb_tutorial.tut_show', 'tb_tutorial.created_at', 'tb_tutorial.created_by', 'tb_tutorial.updated_at', 'tb_tutorial.updated_by', 'tb_tutorial.tut_parmalink' ,'tb_tutorial.tut_view', 'users.name')
                ->leftJoin('users', 'users.id', '=', 'tb_tutorial.user_id')
                ->where(function ($query) use ($request) {
                    if(!empty($request->staffId)){
                        $query->where('tb_tutorial.user_id', $request->staffId);
                    }
                    if(!empty($request->date_start)){
                        $query->where('tb_tutorial.created_at', '>=', $request->date_start . ' 00:00:00');
                    }
                    if(!empty($request->date_end)){
                        $query->where('tb_tutorial.created_at', '<=', $request->date_end . ' 23:59:59');
                    }
                })->orderBy('tb_tutorial.tut_group')->orderBy('tb_tutorial.tut_sort_order')->get();
        }else{
            $data = TbTutorial::select('tb_tutorial.id', 'tb_tutorial.tut_name', 'tb_tutorial.tut_keyword', 'tb_tutorial.tut_show', 'tb_tutorial.created_at', 'tb_tutorial.created_by', 'tb_tutorial.updated_at', 'tb_tutorial.updated_by', 'tb_tutorial.tut_parmalink' ,'tb_tutorial.tut_view', 'users.name')
                ->leftJoin('users', 'users.id', '=', 'tb_tutorial.user_id')
                ->orderBy('tb_tutorial.tut_group')
                ->orderBy('tb_tutorial.tut_sort_order')
                ->get();
        }

        return Datatables::of($data)
                ->addColumn('tut_name', function ($data) {
    return $data->tut_name;
})
                ->addColumn('tut_keyword', function ($data) {
                    return $data->tut_keyword;
                })
                ->addColumn('tut_show', function ($data) {
                    return $data->tut_show;
                })
                ->addColumn('crated', function ($data) {
                    return $data->created_at.'<br/><strong><i class="fa fa-user"></i> '.$data->name.'</strong><br/><strong class="text-danger"><i class="fa fa-eye"></i> '.$data->tut_view.'</strong>';
                })
                ->addColumn('updated', function ($data) {
                    return $data->updated_at.'<br/><small><i class="fa fa-user"></i> '.$data->updated_by.'</small>';
                })
                ->addColumn('actions', function ($data) {
                    $id = $data->id;
                    $name = $data->tut_name;
                    $status = $data->tut_show;
                    return view('admin.tutorial.button', compact('id','status','name'));
                })
                ->escapeColumns([])
                ->addIndexColumn()
                ->make(true);
    }

    public function status($id){

        $data = TbTutorial::findOrFail($id);

        if($data->tut_show == 2){
            $status = 1;
        }elseif($data->tut_show == 1) {
            $status = 2;
        }

        $data->tut_show                     = $status;
        $data->updated_by                   = Auth::user()->displayname;
        $data->updated_at                   = date('Y-m-d H:i:s');
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');
    }

    public function delete(Request $request){

        $check = TbTutorial::findOrFail($request->deleteId);
        if(!empty($check)){
            @unlink(Storage::disk('public')->path('tutorial/') . $check->tut_thumb);
        }

        TbTutorial::where('id', $request->deleteId)->delete();
        return back()->with('feedback', 'ลบข้อมูลเรียบร้อยแล้ว!');

    }

    public function random(Request $request){

        $TbTutorial = TbTutorial::select('tut_name','tut_parmalink','tut_seo_detail','tut_show','tut_thumb')
        ->where('tut_show',1)
        ->inRandomOrder()
        ->limit(10)
        ->get();

        foreach($TbTutorial as $data){

            if(!empty($data->tut_thumb)){
                $img = asset('storage/tutorial/'.$data->tut_thumb);
            }else{
                $img = asset('images/default-img/no-img.jpg');
            }

            $result[] = array(
                'tut_name' => $data->tut_name,
                'tut_parmalink' => route('fronend.tutorial.content',$data->tut_parmalink),
                'tut_seo_detail' => $data->tut_seo_detail,
                'tut_thumb' => $img,
            );
        }

        return $result;
    }

    public function search(Request $request){

        $TbTutorial = TbTutorial::select('tut_name','tut_parmalink','tut_seo_detail','tut_show','tut_thumb')
        ->orWhere('tut_name', 'LIKE', '%' . $request->keyword . '%')
        ->orWhere('tut_parmalink', 'LIKE', '%' . $request->keyword . '%')
        ->where('tut_show',1)
        ->inRandomOrder()
        ->limit(10)
        ->get();

        if(count($TbTutorial ) != 0){
            foreach($TbTutorial as $data){

                if(!empty($data->tut_thumb)){
                    $img = asset('storage/tutorial/'.$data->tut_thumb);
                }else{
                    $img = asset('images/default-img/no-img.jpg');
                }

                $result[] = array(
                    'tut_name' => $data->tut_name,
                    'tut_parmalink' => route('fronend.tutorial.content',$data->tut_parmalink),
                    'tut_seo_detail' => $data->tut_seo_detail,
                    'tut_thumb' => $img,
                );
            }

            return $result;
        }else{
            return [];
        }
    }

    public function deleteImg(Request $request){

        $check = TbTutorial::where('id',$request->deleteId)->first();
        if (!empty($check->tut_thumb)) {
            @unlink(Storage::disk('public')->path('tutorial/').$check->tut_thumb);
        }

        $data = TbTutorial::where('id',$request->deleteId)->first();
        $data->tut_thumb              = null;
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');
    }

    public function deleteVideo(Request $request){

        $data = TbTutorial::where('id',$request->deleteId)->first();
        $data->tut_video              = null;
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');
    }

    private function rewrite_url($url){
        $str_replace = strtolower(str_replace(" ","-",$url));
        $data = preg_replace('/[^a-z0-9\_\- ]/i', '', $str_replace);
        return $data ;
    }

}