<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthCheckController extends Controller
{
    public function checkLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status_code' => 422,
                'message' => 'กรุณากรอก email และ password ให้ครบถ้วน',
            ], 422);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::once($credentials)) {
            return response()->json([
                'status_code' => 200,
                'message' => 'success',
            ], 200);
        }

        return response()->json([
            'status_code' => 401,
            'message' => 'email หรือ password ไม่ถูกต้อง',
        ], 401);
    }
}