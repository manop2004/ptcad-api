<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Exception;
use App\Models\User;
use App\Models\TbExtension;

class FacebookController extends Controller
{
    public function redirectTofacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {

        if(!empty(Auth::user()->id)){
            $user = Socialite::driver('facebook')->user();

            $finduser = User::where('facebook_id', $user->id)->first();
            if($finduser != ""){

                return redirect()->route('fronend.account')->with('feedback-er', 'บัญชีคุณผูกกับ Facebook อยู่แล้ว!!');

            }else{

                $ckData = User::where('email',$user->email)->get();

                if(count($ckData) != 0){
                    $user2 = User::findOrFail($ckData[0]->id);
                    $user2->facebook_id  = $user->id;
                    $user2->save();

                    return redirect()->route('fronend.account')->with('feedback', 'ผูกบัญชีของคุณผูกกับ Facebook เรียบร้อยแล้ว!!');
                }else{
                    return redirect()->route('fronend.account')->with('feedback-er', 'ที่อยู่อีเมลของคุณที่แจ้งในระบบ ไม่ตรงกับอีเมลบน Facebook!!');
                }
            }
        }else{
            try {
				
				# ยังไม่มีการ Login

                $user = Socialite::driver('facebook')->user();

                $finduser = User::where('facebook_id', $user->id)->first();		//ส่ง id ของ FB ($user->id) ไปหาใน table user
                if($finduser != ""){
					# ถ้าเจอว่าเคยผูกบัญชี FB หรือเคย Login ด้วย FB แล้ว ให้ Login ได้เลย
                    Auth::login($finduser);

                    //return redirect()->route('fronend.account');
					return redirect()->intended();

                }else{
					# ถ้าไม่เจอว่าเคยผูกบัญชี FB หรือ Login FB เข้ามาครั้งแรก
                    $ckData = User::where('email',$user->email)->first();	//ส่ง email ของ FB ($user->email) ไปหาใน table user

                    if(!empty($ckData)){
						# เจอว่ามีอีเมล FB กับ user ในระบบตรงกัน ให้ผูกบัญชี save facebook_id และ Login
                        $user2 = User::findOrFail($ckData->id);
                        $user2->facebook_id  = $user->id;
                        $user2->save();

                        Auth::login($user2);

                        //return redirect()->route('fronend.account');
						return redirect()->intended();

                    }else{
						# User ใหม่ ให้ Register ใหม่เลย
                        $user_code = $this->generateRandomString();

                        /** Get Avatar */
						/*
                        $image = $user->id.".jpeg";
                        $imagePath = Storage::disk('public')->path('storage/avatar/'. $image);
                        file_put_contents($imagePath, file_get_contents($user->avatar_original));
						*/
						
						if(strpos($user->name,' ') !== FALSE){
							$facebook_name = str_replace('  ',' ',$user->name);
							$arr_name = explode(' ',$facebook_name);
							$fname = $arr_name[0];
							unset($arr_name[0]);
							$lname = '';
							foreach($arr_name as $data_lname){
								$lname .= ' '.$data_lname;
							}
							$lname = substr($lname,1);
						}else{
							$fname = $user->name;
							$lname = '';
						}
						
                        $newUser = User::create([
                            'user_code' => $user_code,
                            'displayname' =>  $user->name,
                            'name' => $fname,
                            'lastname' => $lname,
                            'email' => $user->email,
                            'sex' => '3',
                            'user_type' => '1',
                            'facebook_id' => $user->id,
							//'img' => $image,
							'level' => '6',
                            'password' => encrypt('123456dummy'),
                        ] );
						
                        $extension = TbExtension::first();
                        if(!empty($extension)){
                            if($extension->ext_lineNotify_status == 1){
                                if(!empty($extension->ext_lineNotify)){

                                    $Token = 'Bearer '.$extension->ext_lineNotify;
                                    $Message = "\n----------------------------------\nสมาชิกใหม่!!\nรหัสผู้ใช้ $user_code\nชื่อ - นามสกุล : $user->name\n\n----------------------------------\nกรุณาตรวจสอบข้อมูล\nเพื่อดำเนินการต่อไป\n----------------------------------\nคลิกดูรายละเอียด ".route('user.edit',['id'=>$user_code]);
                                    $this->notify_message($Message, $Token);
                                }
                            }

                        }
						
                        Auth::login($newUser);

                        //return redirect()->route('fronend.account');
						return redirect()->intended();
                    }
                }

            } catch (Exception $e) {
                // dd($e->getMessage());

                return redirect()->route('login')->with('feedback-er', 'เข้าสู่ระบบด้วย Facebook ไม่สำเร็จ!!');
            }
        }
    }

    public function unconnect(Request $request){

        $user = User::findOrFail(Auth::user()->id);

        $user->facebook_id              = null;
        $user->update_by                = Auth::user()->name;
        $user->updated_at               = date('Y-m-d H:i:s');
        $user->save();

        return back()->with('feedback', 'อัพเดตข้อมูลเรียบร้อยแล้ว!!');
    }

    private function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    private function notify_message($Message, $Token) {

        $chOne = curl_init();
        curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
        curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt( $chOne, CURLOPT_POST, 1);
        curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=".$Message);
        $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: '.$Token.'', );
        curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
        curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec( $chOne );

        //Result error
        if(curl_error($chOne))
        {
            echo 'error:' . curl_error($chOne);
        }
        else {
            $result_ = json_decode($result, true);
            echo "status : ".$result_['status']; echo "message : ". $result_['message'];
        }
        curl_close( $chOne );

        return $chOne;
    }

}

