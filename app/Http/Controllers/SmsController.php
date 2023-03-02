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
use Illuminate\Support\Facades\Http;

class SmsController extends Controller
{
    protected $apiKey ='1F7ACF9B-67B5-4E02-A270-A3C377554AD2';
    protected $apiMainurl ='http://sms.parsgreen.ir';
    public function send(Request $request)
    {
         $this->validate($request,[
            "phone"=>['required','numeric','regex:/^(\+98|09|00)\d{9,16}$/u']
        ]);
        $code = rand(1000,9999);
      
        /*  if(Str::length($request->phone)<11 ||(
        (Str::startsWith($request->phone, '09') && Str::length($request->phone)!=11)
         || (Str::startsWith($request->phone, '+98') && Str::length($request->phone)!=13) 
         ||(Str::startsWith($request->phone, '0098') && Str::length($request->phone)!=14) 
         ) )
        {
            return back()->withErrors(['phone']);
        } */
       
     /*  else
       {
        if(Str::length($request->phone)<5 ||(
        (Str::startsWith($request->phone, '09') && Str::length($request->phone)!=11)
         || (Str::startsWith($request->phone, '+98') && Str::length($request->phone)!=13) 
         ||(Str::startsWith($request->phone, '0098') && Str::length($request->phone)!=14) 
         ) )
        {
            return back()->withErrors(['phone']);
        }
       }*/
       
        /*$this->validate($request,[
            "phone"=>['required','regex:/^(\+|09)\d{9,}$/u']#'regex:/^(\+98|0)?9\d{9}$/u'
        ]);*/
        $sms = Sms::create([
            "phone"=>$request->phone,
            "code"=>$code
        ]);
        if(Str::startsWith($request->phone, '+98') || Str::startsWith($request->phone, '09') || Str::startsWith($request->phone, '0098'))
        {
          /*   $this->apiMainurl =  $this->apiMainurl . '/Apiv2/' . "Message/SendSms";
        $ch = curl_init($this->apiMainurl);
        $SmsBody = "کد ورود به پنل:". $code . "\n سامانه رشد عرفان خوش نظر";
        $Mobiles = array($request->phone);
        $SmsNumber = null;
        $myjson = ["SmsBody"=>$SmsBody, "Mobiles"=>$Mobiles,"SmsNumber"=>$SmsNumber];
        $jsonDataEncoded = json_encode($myjson);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $header =array('authorization: BASIC APIKEY:'. $this->apiKey,'Content-Type: application/json;charset=utf-8');
        curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
        $result = curl_exec($ch);
        $res = json_decode($result);
        curl_close($ch);*/
        
         $apiMainurl =  $this->apiMainurl . '/Apiv2/' . "Message/SendOtp";
         $ch = curl_init($apiMainurl);
         $SmsBody = "کد ورود به پنل:". $code . "\n سامانه رشد عرفان خوش نظر";
         $Mobiles = $request->phone;
         $SmsNumber = null;
         $myjson = ["TemplateID"=>2, "Mobile"=>$Mobiles,"AddName"=>"True","SmsCode"=>$code];
      
         $jsonDataEncoded = json_encode($myjson);
         curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
         curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
         $header =array('authorization: BASIC APIKEY:'. $this->apiKey,'Content-Type: application/json;charset=utf-8');
         curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
         $result = curl_exec($ch);
         $res = json_decode($result);
         curl_close($ch);

        DB::table('logs')->insert([
            "phone"=>$request->phone,
            "body"=>$SmsBody,
            'date'=>date('Y-m-d H:i:s'),
            'user_id'=>(User::where('phone',$request->phone)->exists())?User::where('phone',$request->phone)->first()->id:null,
            'status'=>$res->R_Success??0//
        ]);
        return view('auth.confirm',["sms"=>$sms]);
        }
        else       
        {
            return view('auth.confirm',["sms"=>$sms]);
            /*$user=User::where("phone",$request->phone);
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
            }*/
        }
    }
    
     public function cronsms($code,$Mobiles)
    {
        $support=DB::table('user_crons')->where('phone',$Mobiles)->first()->support??"خوشنظر";

       switch ($code) {
        case '3':
            $SmsBody ="سلام عرض ادب جهت استعدادیابی و دریافت آموزشهای رایگان از لینک زیر استفاده کنید https://exam.erfankhoshnazar.com";
            break;
        case '5':
            $SmsBody = "سلام عرض ادب ".$support." هستم با توجه به اینکه تاکنون اقدام به تکمیل تست استعدادیابی نکرده اید مهلت استفاده رایگان برای شما تا 24 ساعت آینده تمدید شد https://exam.erfankhoshnazar.com";
            break;
        case '6':
            $SmsBody = "سلام عرض ادب ".$support." هستم نتیجه تست استعدادیابی شما آماده شد جهت مشاهده به قسمت نتیجه آزمون در لینک زیر مراجعه کنید https://exam.erfankhoshnazar.com";
            break;
        case '7':
            $SmsBody = "سلام عرض ادب با توجه به اینکه تاکنون نتیجه استعدایابی را بصورت کامل مشاهده نکرده اید مهلت مشاهده رایگان تا 24 ساعت آینده تمدید شد https://exam.erfankhoshnazar.com";
            break;
        case '8':
            $SmsBody = "سلام عرض ادب با توجه به اینکه تاکنون از هدیه رایگان فایل آموزشی افزایش اعتماد به نفس استفاده نکرده اید مهلت مشاهده رایگان تا 24 ساعت آینده تمدید شد https://exam.erfankhoshnazar.com";
            break;
        case '9':
            $SmsBody = "سلام عرض ادب با توجه به اینکه تاکنون از هدیه رایگان فایل آموزشی علاقه مند به یادگیری استفاده نکرده اید مهلت مشاهده رایگان تا 24 ساعت آینده تمدید شد https://exam.erfankhoshnazar.com";
            break;
        case '10':
            $SmsBody = "سلام عرض ادب با توجه به اینکه تاکنون از هدیه رایگان فایلهای آموزشی اعتماد به نفس و علاقه مند به یادگیری استفاده نکرده اید مهلت مشاهده رایگان تا 24 ساعت آینده تمدید شد https://exam.erfankhoshnazar.com";
            break;
        case '11':
            $SmsBody = "سلام عرض ادب ".$support." هستم جهت دریافت مشاوره رایگان دوره آموزشی کاخ سرخ و کاخ نوجوان از لینک زیر استفاده کنید https://erfankhoshnazar.com/b";
            break;
       }
        $this->apiMainurl =  $this->apiMainurl . '/Apiv2/' . "Message/SendSms";
        $ch = curl_init($this->apiMainurl);
        $Mobiles = array($Mobiles);
        $SmsNumber = null;
        $myjson = ["SmsBody"=>$SmsBody, "Mobiles"=>$Mobiles,"SmsNumber"=>$SmsNumber];
    
       $jsonDataEncoded = json_encode($myjson);
       curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
       curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
       $header =array('authorization: BASIC APIKEY:'. $this->apiKey,'Content-Type: application/json;charset=utf-8');
       curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
       $result = curl_exec($ch);
       $res = json_decode($result);
       curl_close($ch);
        return true;
    }
    
}
