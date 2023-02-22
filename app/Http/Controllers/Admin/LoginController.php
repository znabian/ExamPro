<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function index(){
        return view('admin.auth.login');
    }

    public function login(Request $request){
        $request->validate([
            "phone"=>['required','regex:/^(\+98|0)?9\d{9}$/u','exists:users'],
            "password"=>['required']
        ]);
        $user = DB::table('users')->where('phone',$request->phone)->first();
        if($user->active && $user->is_admin){
            Auth::login(User::find($user->id));
            return redirect()->route('users');
        }
        else{
            return redirect()->back();
        }
    }
    public function logout(){
        Auth::logout();
        return redirect()->route('adminLogin');
    }
}
