<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function export() 
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
    public function index(){
        $users = User::paginate();
        return view('users.index',["users"=>$users]);
    }
    public function show(Request $request,$id){
        $user = User::find($id);
        return redirect()->back();
    }
    public function active(Request $request,$id){
        DB::table("users")->where("id","=",$id)->update(["active"=>true]);
        return redirect()->back();
    }
    public function deactive(Request $request,$id){
        DB::table("users")->where("id","=",$id)->update(["active"=>false]);
        return redirect()->back();
    }
    public function create(){
        return view('users.create');
    }
    public function store(Request $request){
        $this->validate($request,[
            "phone"=>['required','regex:/^(\+98|0)?9\d{9}$/u'],
            "firstName"=>['min:3'],
            "lastName"=>['min:3'],
            "email"=>['email'],
        ]);
        $manager = false;
        if($request->role=="2"){
            $manager = true;
        }
        User::create([
            "phone"=>$request->phone,
            "firstName"=>$request->firstName,
            "lastName"=>$request->lastName,
            "email"=>$request->email,
            "birthday"=>$request->birthday,
            "is_admin"=>$manager
        ]);
        return redirect()->route('users');
    }
    public function edit($id){
        $user  = User::find($id);
        return view('users.edit',["user"=>$user]);
    }
    public function update(Request $request,$id){
        $this->validate($request,[
            "phone"=>['required','regex:/^(\+98|0)?9\d{9}$/u'],
            "firstName"=>['min:3'],
            "lastName"=>['min:3'],
            "email"=>['email'],
        ]);
        $manager = false;
        if($request->role=="2"){
            $manager = true;
        }
        DB::table("users")->where("id","=",$id)->update([
            "phone"=>$request->phone,
            "firstName"=>$request->firstName,
            "lastName"=>$request->lastName,
            "email"=>$request->email,
            "birthday"=>$request->birthday,
            "is_admin"=>$manager
        ]);
        return redirect()->route('users');
    }
}
