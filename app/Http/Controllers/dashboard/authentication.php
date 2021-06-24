<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth  ;
use App\Models\admins;
use Session as flash;
use Hash;

class authentication extends Controller
{
    public static function index(Request $request){
        if(Auth::guard('dashboard')->check())
            return redirect()->route('dashboard.users.index');
        return view('dashboard.auth.login');
    }
    public static function login(Request $request){
       
        $rules =[
            'email'       =>'required|email',
            'password'    =>"required|",
        ];
        $messages=[
            "email.required"=>"يجب إدخال البريد الإلكتروني",
            "email.regex"=>"يجب إدخال البريد الإلكتروني بشكل صحيح",
            "email.exists"=>"البريد الإلكتروني غير صحيح",
 
            "password.required"  =>"يجب إدخال الرقم السري",
        ];
        $request->validate($rules, $messages);

         $auth = admins::where('email',$request->email)->first();
         $guard= "dashboard";
         $redirect= "statistics";
        if(!$auth ){
            flash::flash('incorrectEmail',' بريد إلكتروني غير صحيح ');
            return back();
        }
        if($auth && !$auth->isActive){
                flash::flash('incorrectPassword','بريد إلكتروني غير مفعل , برجاء التواصل مع الادارة');
                return back();
            }
        
        if(Hash::check($request->password , $auth->password )){
            \Auth::guard($guard)->login( $auth); 
            return redirect()->route('dashboard.'.$redirect.'.index');
        }else{
            flash::flash('incorrectPassword','كلمة مرور خاطئة');
            return back();
        }
    }
    public static function logout(Request $request){
        
        if(Auth::guard('dashboard')->check()){
            \Auth::guard('dashboard')->logout();
        }
        return redirect()->route('dashboard.login.index');
    }

}
