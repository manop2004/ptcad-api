<?php

namespace App\Exports;

use App\Models\TbProductDetail;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use App\Models\HistoryPdpa;
class userConsentList implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
   
    public function __construct(int $type = null)
    {
        $this->type = $type;
    }

    public function view(): View
    {
        $type = $this->type;

        if($type == 1){
            $data = HistoryPdpa::where('pdpa_news',1)->orderBy('created_at','desc')->get();
        }else if($type == 2){
            $data = HistoryPdpa::where('pdpa_article',1)->orderBy('created_at','desc')->get();
        }else if($type == 3){
            $data = HistoryPdpa::where('pdpa_product',1)->orderBy('created_at','desc')->get();
        }else{
            $data = HistoryPdpa::where('pdpa_news',1)->where('pdpa_article',1)->where('pdpa_product',1)->orderBy('created_at','desc')->get();
        }

        return view('admin.promotion.exports', [
            'data' => $data,
            'i'=>1,
        ]);
    }

}
