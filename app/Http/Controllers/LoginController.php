<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt; //加密解密
use Illuminate\Contracts\Encryption\DecryptException; //加密解密 try catch

use DB;

class LoginController extends Controller
{
    public function Login(Request $request){
        if (request()->isMethod('GET')) {
            return view('Login.Login',[

            ]);
        }elseif (request()->isMethod('POST')) {
            $s_acc = $request->s_acc;
            $s_pass = $request->s_pass;

            $staff_information = DB::table('staff_information')->where(['s_acc'=>$s_acc, 's_pass'=>$s_pass])->first();
            $DB_web_access = DB::select("SELECT 
                GROUP_CONCAT(DISTINCT w2.wp_name SEPARATOR ',') AS wp_name_group 
                FROM web_access AS w1 
                LEFT JOIN web_page AS w2 ON w1.web_page_id = w2.id
                WHERE s_acc = '$s_acc' 
            ");
            if($staff_information && $DB_web_access){ //需要有登入帳號 與 網頁使用權限
                //檢查是否有頁面權限
                $WebAccess = explode(',',$DB_web_access[0]->wp_name_group); //網頁使用權限
                $WebAccess[] = 'MemberWorkOrder'; //預設權限，之後要刪除
                session(['LoginAcc' => $staff_information->s_acc]);
                session(['LoginName' => $staff_information->s_name]);
                session(['LoginRole' => 'Member']);
                session(['WebAccess' => $WebAccess]);
                return redirect()->route('MemberWorkOrderList');
            }
            session()->flash('message', '登入失敗');
            return redirect()->back();
            // try {
            //     $data = json_decode(Crypt::decryptString($request->data));
            // } catch (DecryptException $e) {
            //     return 'error';
            // }
        }
    }
    public function Logout(Request $request){ //登出
        $request->session()->flush();
        return redirect()->back();
    }

    
    #example
    // public function example(Request $request){
    //     if (request()->isMethod('GET')) {
    //         return view('Member.MemberWorkOrder',[
    //         ]);
    //     }elseif (request()->isMethod('POST')) {
    //         return $request->all();

    //     }
    // }
}
