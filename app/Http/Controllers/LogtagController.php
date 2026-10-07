<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Providers\RouteServiceProvider;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Storage;

use App\Models\LogTag;

class LogtagController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function json(){

        $data = LogTag::select('value')->first();

        if (!empty($data)) {
            return response()->json($data);
        } else {
            return 'false';
        }

    }


}
