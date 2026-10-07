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

use App\Models\TbArticle;
use App\Models\LogTag;
use App\Models\TbBanner;
use App\Models\TbAd;
use App\Models\TbSettingAd;
use App\Models\TbSetting;
use App\Models\User;

class ArtlicleController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        $breadcrumb = [
            ['name' => 'บทความ'],
        ];
        $title_page = 'บทความ';
		
		if(!empty($request)){
			$search_article = ['staffId' => !empty($request->staffId) ? $request->staffId : null,
								'date_start' => !empty($request->date_start) ? $request->date_start : null,
								'date_end' => !empty($request->date_end) ? $request->date_end : null,
							];
								
			$article = TbArticle::where(function ($query) use ($request) {
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
			$article   = TbArticle::count();
		}
		
        return view('admin.artlicle.main', [
            'breadcrumb' => $breadcrumb,
            'title_page' => $title_page,
            'data' => '',
            'article' => $article,
            'search_article' => $search_article,
        ]);

    }

    public function add(){

        $breadcrumb = [
            ['name' => 'เพิ่มบทความ'],
        ];
        $title_page = 'เพิ่มบทความ';
		
		$usersStaff = User::whereIn('level',[1,2,3,4,5,7,8])->get();
		
		$staffId = Auth::user()->id;

        return view('admin.artlicle.form', [
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
                'art_name' => 'required|max:255',
                'art_parmalink' => 'required|max:255|unique:tb_article',
                'art_cat' => 'required',
            ],
            [
                'art_name.required' => 'กรุณากรอกข้อมูล',
                'art_name.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'art_parmalink.required' => 'กรุณากรอกข้อมูล',
                'art_parmalink.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'art_parmalink.unique' => 'Parmalink นี้มีการใช้งานอยู่แล้ว กรุณาตรวจสอบข้อมูลอีกครั้ง',
                'art_cat.required' => 'กรุณาเลือกหมวดหมู่บทความ',
            ]
        );

        if($request->art_show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        if($request->art_author == 'on'){
            $author = 1;
        }else{
            $author = 2;
        }

        if($request->art_keyword != ''){
			$art_keyword = implode(",", $request->art_keyword);
		} else {
			$art_keyword = '';
		}

        if($request->art_recommend != ''){
			$art_recommend = 1;
		} else {
			$art_recommend = 2;
		}

        $data = new TbArticle;
        $data->art_name                 = $request->art_name;
        $data->art_cat                  = $request->art_cat;
        $data->art_keyword              = $art_keyword;
        $data->art_detail               = $request->art_detail;
        $data->art_author               = $author;
        $data->art_seo_detail           = $request->art_seo_detail;
        $data->art_parmalink            = $this->rewrite_url($request->art_parmalink);
        $data->art_show                 = $show;
        $data->art_recommend            = $art_recommend;
        $data->created_by               = Auth::user()->displayname;
        $data->updated_by               = Auth::user()->displayname;
        $data->created_at               = date('Y-m-d H:i:s');
        $data->updated_at               = date('Y-m-d H:i:s');
        $data->user_id           		= $request->user_id;

        if (!empty($request->art_thumb)) {

            if ($request->hasFile('art_thumb')) {
                @unlink(Storage::disk('public')->path('article/') . $request->art_thumb_old);

                $newFilename = uniqid() . '.' . $request->art_thumb->extension();
                $data->art_thumb = $newFilename;
                $file = $request->file('art_thumb');
                $file->move('storage/article/', $newFilename);
            }

        }

        $data->save();

        $log = LogTag::first();

        if(!empty($log)){
            $articleTags = explode(",",$log->value);
            $TagNew = explode(",",$art_keyword);

            $totalArray	=	array_merge($articleTags,$TagNew);
            $setlog	=	array_unique($totalArray);

            $setlogBase = implode(",", $setlog);

            $loh_history        = LogTag::first();
            $loh_history->value = $setlogBase;
            $loh_history->save();
        }else{

            $loh_history        = new LogTag;
            $loh_history->value = $art_keyword;
            $loh_history->save();
        }
        return redirect()->route('artlicle.edit',[$data->id])->with('feedback', 'เพิ่มข้อมูลเรียบร้อยแล้ว!');

    }

    public function edit($id)
    {
        $breadcrumb = [
            ['name' => 'อัพเดตบทความ'],
        ];

        $title_page = 'อัพเดตบทความ';
        $data = TbArticle::findOrFail($id);
		
		$usersStaff = User::whereIn('level',[1,2,3,4,5,7,8])->get();
		
		$staffId = !empty($data->user_id) ? $data->user_id : '';

        return view('admin.artlicle.form', [
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
                'art_name' => 'required|max:255',
                'art_parmalink' => 'required|max:255|unique:tb_article,art_parmalink,'.$id,
                'art_cat' => 'required',
            ],
            [
                'art_name.required' => 'กรุณากรอกข้อมูล',
                'art_name.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'art_parmalink.required' => 'กรุณากรอกข้อมูล',
                'art_parmalink.max' => 'กรุณากรอกข้อมูลไม่เกิน 255 ตัวอักษร',
                'art_parmalink.unique' => 'Parmalink นี้มีการใช้งานอยู่แล้ว กรุณาตรวจสอบข้อมูลอีกครั้ง',
                'art_cat.required' => 'กรุณาเลือกหมวดหมู่บทความ',
            ]
        );

        if($request->art_show == 'on'){
            $show = 1;
        }else{
            $show = 2;
        }

        if($request->art_author == 'on'){
            $author = 1;
        }else{
            $author = 2;
        }

        if($request->art_keyword != ''){
			$art_keyword = implode(",", $request->art_keyword);
		} else {
			$art_keyword = '';
		}

        if($request->art_recommend != ''){
			$art_recommend = 1;
		} else {
			$art_recommend = 2;
		}

        $data = TbArticle::findOrfail($id);
        $data->art_name                 = $request->art_name;
        $data->art_cat                  = $request->art_cat;
        $data->art_keyword              = $art_keyword;
        $data->art_detail               = $request->art_detail;
        $data->art_author               = $author;
        $data->art_seo_detail           = $request->art_seo_detail;
        $data->art_parmalink            = $this->rewrite_url($request->art_parmalink);
        $data->art_show                 = $show;
        $data->art_recommend            = $art_recommend;
        $data->updated_by               = Auth::user()->displayname;
        $data->updated_at               = date('Y-m-d H:i:s');
        $data->user_id               	= $request->user_id;

        if (!empty($request->art_thumb)) {

            if ($request->hasFile('art_thumb')) {
                @unlink(Storage::disk('public')->path('article/') . $request->art_thumb_old);

                $newFilename = uniqid() . '.' . $request->art_thumb->extension();
                $data->art_thumb = $newFilename;
                $file = $request->file('art_thumb');
                $file->move('storage/article/', $newFilename);
            }

        }

        $data->save();

        $log = LogTag::first();

        if(!empty($log)){
            $articleTags = explode(",",$log->value);
            $TagNew = explode(",",$art_keyword);

            $totalArray	=	array_merge($articleTags,$TagNew);
            $setlog	=	array_unique($totalArray);

            $setlogBase = implode(",", $setlog);

            $loh_history        = LogTag::first();
            $loh_history->value = $setlogBase;
            $loh_history->save();
        }else{

            $loh_history        = new LogTag;
            $loh_history->value = $art_keyword;
            $loh_history->save();
        }

        return back()->with('feedback', 'เพิ่มข้อมูลเรียบร้อยแล้ว!');

    }

    public function jsondata(Request $request)
    {

		if(!empty($request)){
			$data = TbArticle::select('tb_article.id', 'tb_article.art_name', 'tb_article.art_keyword', 'tb_article.art_cat', 'tb_article.art_show', 'tb_article.created_at', 'tb_article.created_by', 'tb_article.updated_at', 'tb_article.updated_by', 'tb_article.art_parmalink' ,'tb_article.art_view', 'users.name')
				->leftJoin('users', 'users.id', '=', 'tb_article.user_id')
				->where(function ($query) use ($request) {
					if(!empty($request->staffId)){
						$query->where('tb_article.user_id', $request->staffId);
					}
					if(!empty($request->date_start)){
						$query->where('tb_article.created_at', '>=', $request->date_start . ' 00:00:00');
					}
					if(!empty($request->date_end)){
						$query->where('tb_article.created_at', '<=', $request->date_end . ' 23:59:59');
					}
				})->get();
		}else{
			$data = TbArticle::select('tb_article.id', 'tb_article.art_name', 'tb_article.art_keyword', 'tb_article.art_cat', 'tb_article.art_show', 'tb_article.created_at', 'tb_article.created_by', 'tb_article.updated_at', 'tb_article.updated_by', 'tb_article.art_parmalink' ,'tb_article.art_view', 'users.name')
				->leftJoin('users', 'users.id', '=', 'tb_article.user_id')
				->get();
		}
		
        return Datatables::of($data)
                ->addColumn('art_name', function ($data) {
                    return '<a href="'.route('fronend.article.content',$data->art_parmalink).'" target="_bank">'.$data->art_name.'</a>';
                })
                ->addColumn('art_keyword', function ($data) {
                    return $data->art_keyword;
                })
                ->addColumn('art_cat', function ($data) {
                    return $data->art_cat;
                })
                ->addColumn('art_show', function ($data) {
                    return $data->art_show;
                })
                ->addColumn('crated', function ($data) {
                    return $data->created_at.'<br/><strong><i class="fa fa-user"></i> '.$data->name.'</strong><br/><strong class="text-danger"><i class="fa fa-eye"></i> '.$data->art_view.'</strong>';
                })
                ->addColumn('updated', function ($data) {
                    return $data->updated_at.'<br/><small><i class="fa fa-user"></i> '.$data->updated_by.'</small>';
                })
                ->addColumn('actions', function ($data) {
                    $id = $data->id;
                    $name = $data->art_name;
                    $status = $data->art_show;
                    return view('admin.artlicle.button', compact('id','status','name'));
                })
                ->escapeColumns([])
                ->addIndexColumn()
                ->make(true);
    }

    public function status($id){

        $data = TbArticle::findOrFail($id);

        if($data->art_show == 2){
            $status = 1;
        }elseif($data->art_show == 1) {
            $status = 2;
        }

        $data->art_show                     = $status;
        $data->updated_by                   = Auth::user()->displayname;
        $data->updated_at                   = date('Y-m-d H:i:s');
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');
    }

    public function delete(Request $request){

        $check = TbArticle::findOrFail($request->deleteId);
        if(!empty($check)){
            @unlink(Storage::disk('public')->path('article/') . $check->art_thumb);
        }

        TbArticle::where('id', $request->deleteId)->delete();
        return back()->with('feedback', 'ลบข้อมูลเรียบร้อยแล้ว!');

    }

    public function random(Request $request){

        $TbArticle = TbArticle::select('art_cat','art_name','art_parmalink','art_seo_detail','art_show','art_thumb')
        ->where('art_show',1)
        ->inRandomOrder()
        ->limit(10)
        ->get();

        foreach($TbArticle as $data){

            if(!empty($data->art_thumb)){
                $img = asset('storage/article/'.$data->art_thumb);
            }else{
                $img = asset('images/default-img/no-img.jpg');
            }

            $result[] = array(
                'art_name' => $data->art_name,
                'art_parmalink' => route('fronend.articles.detail',$data->art_parmalink),
                'art_seo_detail' => $data->art_seo_detail,
                'art_thumb' => $img,
            );
        }

        return $result;
    }

    public function search(Request $request){

        $TbArticle = TbArticle::select('art_name','art_parmalink','art_seo_detail','art_show','art_thumb')
        ->orWhere('art_name', 'LIKE', '%' . $request->keyword . '%')
        ->orWhere('art_parmalink', 'LIKE', '%' . $request->keyword . '%')
        ->where('art_show',1)
        ->inRandomOrder()
        ->limit(10)
        ->get();

        if(count($TbArticle ) != 0){
            foreach($TbArticle as $data){

                if(!empty($data->art_thumb)){
                    $img = asset('storage/article/'.$data->art_thumb);
                }else{
                    $img = asset('images/default-img/no-img.jpg');
                }

                $result[] = array(
                    'art_name' => $data->art_name,
                    'art_parmalink' => route('fronend.articles.detail',$data->art_parmalink),
                    'art_seo_detail' => $data->art_seo_detail,
                    'art_thumb' => $img,
                );
            }

            return $result;
        }else{
            return [];
        }
    }

    public function deleteImg(Request $request){

        $check = TbArticle::where('id',$request->deleteId)->first();
        if (!empty($check->art_thumb)) {
            @unlink(Storage::disk('public')->path('article/').$check->art_thumb);
        }

        $data = TbArticle::where('id',$request->deleteId)->first();
        $data->art_thumb              = null;
        $data->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!');
    }

    private function rewrite_url($url){
        $str_replace = strtolower(str_replace(" ","-",$url));
        $data = preg_replace('/[^a-z0-9\_\- ]/i', '', $str_replace);
        return $data ;
    }

}