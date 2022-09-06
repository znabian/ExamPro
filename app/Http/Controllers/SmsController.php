<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSmsRequest;
use App\Http\Requests\UpdateSmsRequest;
use App\Models\Sms;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SmsController extends Controller
{
    protected $apiKey ='1F7ACF9B-67B5-4E02-A270-A3C377554AD2';
    protected $apiMainurl ='http://sms.parsgreen.ir';
    public function send(Request $request)
    {
        $code = rand(1000,9999);
        
        if(Str::length($request->phone)<5 ||(
        (Str::startsWith($request->phone, '09') && Str::length($request->phone)!=11)
         || (Str::startsWith($request->phone, '+98') && Str::length($request->phone)!=13) 
         ||(Str::startsWith($request->phone, '0098') && Str::length($request->phone)!=14) 
         ) )
        {
            return back()->withErrors(['phone']);
        }
       
        /*$this->validate($request,[
            "phone"=>['required','regex:/^(\+|09)\d{9,}$/u']#'regex:/^(\+98|0)?9\d{9}$/u'
        ]);*/
        $sms = Sms::create([
            "phone"=>$request->phone,
            "code"=>$code
        ]);
        if(Str::startsWith($request->phone, '+98') || Str::startsWith($request->phone, '09') || Str::startsWith($request->phone, '0098'))
        {


          /*  $this->apiMainurl =  $this->apiMainurl . '/Apiv2/' . "Message/SendSms";
        $ch = curl_init($this->apiMainurl);
        $SmsBody = "کد ورود به پنل:". $code . "\n سامانه رشد عرفان خوش نظر";
        $Mobiles = array($request->phone);
        $SmsNumber = null;
        $myjson = ["SmsBody"=>$SmsBody, "Mobiles"=>$Mobiles,"SmsNumber"=>$SmsNumber];*/

        
        // $apiMainurl =  $this->apiMainurl . '/Apiv2/' . "Message/SendOtp";
        // $ch = curl_init($apiMainurl);
        // $SmsBody = "کد ورود به پنل:". $code . "\n سامانه رشد عرفان خوش نظر";
        // $Mobiles = $request->phone;
        // $SmsNumber = null;
        // $myjson = ["TemplateID"=>2, "Mobile"=>$Mobiles,"AddName"=>"True","SmsCode"=>$code];
      
        // $jsonDataEncoded = json_encode($myjson);
        // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        // $header =array('authorization: BASIC APIKEY:'. $this->apiKey,'Content-Type: application/json;charset=utf-8');
        // curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
        // $result = curl_exec($ch);
        // $res = json_decode($result);
        // curl_close($ch);
        return view('auth.confirm',["sms"=>$sms]);
        }
        else       
        {
            $user=User::where("phone",$request->phone);
            if($user->count())
            {
                $user=$user->first();
                if($user->active){
                    Auth::login(User::find($user->id));
                    // $mySms->update([
                    //     "active"=>true
                    // ]);
                    DB::table('sms')->where('id','=',$sms)->update(["active"=>true]);
                    return redirect()->route('dashboard');
                }
                else{
                    return redirect()->back();
                }
                
            }
            else{
                
                $result = User::create([
                    "phone"=>$request->phone
                ]);
                Auth::login($result);
                // $mySms->update([
                //     "active"=>true
                // ]);
                DB::table('sms')->where('id','=',$sms)->update(["active"=>true]);
                return redirect()->route('dashboard');
            }
        }
    }
}
