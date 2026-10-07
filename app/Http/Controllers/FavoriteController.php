<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use App\Models\TbSetting;

class FavoriteController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

        $setting = TbSetting::first();
        $page_name = 'รายการโปรด';

        $breadcrumb = [
            ['route' => route('fronend.home'), 'name' => 'หน้าหลัก'],
            ['route' => '', 'name' => $page_name],
        ];

        //title share
        if(!empty($page_name)){ $og_site_name = $page_name; }else{ $og_site_name = "";}
        if(!empty($page_name)){ $og_title = $page_name; }else{ $og_title = $og_site_name = "";}
        if(!empty($setting->setting_keyword)){ $og_keywords = $setting->setting_keyword; }else{ $og_keywords = "";}
        if(!empty($setting->setting_detail)){ $og_description = $setting->setting_detail; }else{ $og_description = "";}
        if(!empty($setting->setting_coverShare)){ $og_image = asset('storage/setting/'.$setting->setting_coverShare); }else{ $og_image = asset('storage/setting/'.$setting->setting_coverShare);}
        if(!empty($page)){ $og_url = route('fronend.favorite'); }else{ $og_url = route('fronend.favorite');}

        return view('fontend.favorite',[
            'breadcrumb' => $breadcrumb,
            'og_site_name' => $og_site_name,
            'og_keywords' => $og_keywords,
            'og_title' => $og_title,
            'og_description' => $og_description,
            'og_url' => $og_url,
            'og_image' => $og_image,
            'page_name' => $page_name,
        ]);

   }

}
