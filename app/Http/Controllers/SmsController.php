<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSmsRequest;
use App\Http\Requests\UpdateSmsRequest;
use App\Models\Sms;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
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
       // $phone=(str_starts_with($request->phone,"+98"))?str_replace("+98",'0',$request->phone):((str_starts_with($request->phone,"0098"))?str_replace("0098",'0',$request->phone):$request->phone);
       $phone=(str_starts_with($request->phone,"+98"))?preg_replace('/[+]98/', "0", $request->phone, 1):((str_starts_with($request->phone,"0098"))?preg_replace('/0098/', "0", $request->phone, 1):$request->phone);
        $sms = Sms::create([
            "phone"=>$phone,
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
    
    public function send_PRO(Request $request)
    {
         $validation=validator($request->all(),[
            "phone"=>['required','numeric','regex:/^(\+98|09|00)\d{9,16}$/u']
         ]);
        if($validation->fails())
        return ['status'=>0,'msg'=>__('messages.شماره موبایل وارد شده صحیح نمی باشد')];

       // $phone=(str_starts_with($request->phone,"+98"))?str_replace("+98",'0',$request->phone):((str_starts_with($request->phone,"0098"))?str_replace("0098",'0',$request->phone):$request->phone);
       $phone=(str_starts_with($request->phone,"+98"))?preg_replace('/[+]98/', "0", $request->phone, 1):((str_starts_with($request->phone,"0098"))?preg_replace('/0098/', "0", $request->phone, 1):$request->phone);
        $r=new Request(['url'=>"http://85.208.255.101/API/ExamPassApi2_jwt.php",'data'=>$phone]);

        $response=$this->getDataUser($r);
        
        if(!$response)
        return ['status'=>0,'msg'=>__('messages.مشکلی پیش آمده مجددا تلاش نمایید')];
        if($response->status==200)
        {
            $pass=Collection::make($response->data);
                $LoginPass=$pass->map(function($q){
                    if(!is_numeric($q->Pass))
                    $q->Pass=null;
                    return $q;
                })->whereNotNull('Pass');            
                if(!$LoginPass->first())
                return ['status'=>0,'msg'=>__('messages.عدم دسترسی')]; 
                if($LoginPass->count()<=0) 
                return ['status'=>0,'msg'=>__('messages.عدم دسترسی')];

                $code=$LoginPass->first()->Pass;
                    
            /*$data=$response->data[0];
                if(is_numeric($data->Pass))
                $code=$data->Pass;
                else
                return ['status'=>0,'msg'=>__('messages.عدم دسترسی')];*/
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
            return ['status'=>0,'msg'=>$msg];
        }
       
        if(Str::startsWith($request->phone, '+98') || Str::startsWith($request->phone, '09') || Str::startsWith($request->phone, '0098'))
        {        
         $apiMainurl =  $this->apiMainurl . '/Apiv2/' . "Message/SendOtp";
         $ch = curl_init($apiMainurl);
         $Mobiles = $request->phone;
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
         //Sms::updateOrInsert(['phone'=>$phone],['created_at'=>now(),'code'=>$code]);
         $SmsBody = "کد ورود به پنل:". $code . "\n سامانه رشد عرفان خوش نظر";
        DB::table('logs')->insert([
            "phone"=>$request->phone,
            "body"=>$SmsBody,
            'date'=>date('Y-m-d H:i:s'),
            'user_id'=>(User::where('phone',$phone)->exists())?User::where('phone',$phone)->first()->id:null,
            'status'=>$res->R_Success??0
        ]);
        }
        return ['status'=>1,'msg'=>__('messages.کد تایید برای شماره موبایل ارسال گردید',['mobile'=>$request->phone])];
    }
    public function getDataUser(Request $request){
        $api_token="eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2NjI4NzYwNjYsImRhdGEiOnsidW5hbWUiOiIwOTEzMzA5MTQ3OCIsInVpZCI6IjIifX0.SVctk-awYZoyhgihLHvMgFHbA1Yq8y7tvXqJyrkvL1A2A6wQ1oms8qh9Fk-0B-3c30fIZamkfdzdLegj3EvAcXPI2kz-VJJp_WNiboYbbQ0DT5xAbMFMyZiOgKrFMlogvdJaQ_ruOOPPRZBy4qAf91bAj1Uh5OMlKD5FEDSfm_DLVQVOGsm_rgiTKZHmfrR3Zh_wt9g5fO8HflA9bRxRB7qGPkjMzMcIAnCcwCPw9R3mYZhKa2C4zKeP7ickhij1R4-xs26c_kh9u0oMzBLpCMcEDwucM1p2QwXirck0lTrOIOsF8LU3j-cn8CgWqCcDXSoxhdnnd9FdbrcMCDcVEe9aN556KpZhJURZC-k8VOM_bEa9_mygpcAyzEt5hxbcHHIRxrQA4XAPZDYawoJ7JuJLmAzrWLSA3IANwxV5RZD_cXB6JWn1e5xKIfo1Y5ON-KcPFtsnMfG10lDZgyqiVhROUbQ-R7eVog22AmDwN_hDt1OoFkeXZZZuxjLfg1vF";

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl,CURLOPT_HTTPHEADER,['api_token:'.$api_token]);
       
            curl_setopt($curl, CURLOPT_POSTFIELDS, array("data"=>($request->data)));
        
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, "username:password");
        curl_setopt($curl, CURLOPT_URL, $request->url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);

        curl_close($curl);

        return json_decode($result);
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
