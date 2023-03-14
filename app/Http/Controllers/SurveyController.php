<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Conclusion;
use App\Models\Exam;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class SurveyController extends Controller
{
  
    public function surveyLogin($castle,$payment,$panel_id)
     {
        $response = Http::withHeaders([
            'Content-Type' => 'application/x-www-form-urlencoded'
        ])->post("https://erfankhoshnazar.com/exam-api/api_Exam.php",["&castle=".$castle."&PID=".$payment."&UID=".$panel_id."&url=CastleDetailes&end=1"]);
                 if($response->ok())
                 {
                 $data=$response->json();
                 if($data['status']??0)
                  $result = Exam::where('name','like',"%".$data['data']['AppName']."%")->first();
                  else
                  {
                    session(['error'=>'لینک نظر سنجی معتبر نمی باشد']);
                     abort(403);
                  }
                 }
                  else
                  {
                    session(['error'=>'لینک نظر سنجی معتبر نمی باشد']);
                     abort(403);
                  }
                  if($result)
                  {
                    $panel_id=strtr($panel_id,['u2705'=>'']);
                    DB::table('users')->updateOrInsert(['phone'=>$data['data']['UserPhone']],['source'=>"survey","panel_id"=>$panel_id,'updated_at'=>now()]);
                    $uid=User::where('phone',$data['data']['UserPhone'])->first();
                    $euid=DB::table('exam_user')->insertGetId(['exam_id'=>$result->id,
                    'user_id'=>$uid->id]);
                    Auth::login($uid);
                    session(['survey' => ['payment'=>$payment,'uid'=>$panel_id]]);
                    return redirect(route('exam.show',$euid));
                  }
                  else
                  {
                    session(['error'=>'نظر سنجی مورد نظر یافت نشد']);
                     abort(403);
                  }
    }
    public function surveyEnd($ExamUserid)
     {
        $payment=session('survey')['payment'];
        $ExamUser=DB::table("exam_user")->find($ExamUserid);

        DB::table("exam_user")->where('exam_id',$ExamUser->exam_id)
         ->where('user_id',$ExamUser->user_id)->where('enable',1)
         ->update(['active'=>0,'enable'=>0]);
        
             $score = 0;
 
             $historyResult = DB::table('histories')->where("exam_user_id","=",$ExamUserid)->where('active',1)->get();
             foreach($historyResult as $value){
                $score += Answer::find($value->answer_id)->value;
             }
             $disc=['D'=>0,'I'=>0,'S'=>0,'C'=>0];
             DB::table("exam_user")->where('id',$ExamUserid)->update(['score'=>json_encode(['disc'=>$disc,'score'=>$score]),'active'=>1]);

             $examc = Conclusion::where('exam_id',$ExamUser->exam_id)->first();
             if($examc)
             $score=intdiv(($score*100),$examc->high);
        $response = Http::withHeaders([
            'Content-Type' => 'application/x-www-form-urlencoded'
        ])->post("https://erfankhoshnazar.com/exam-api/api_Exam.php",["&score=".$score."&PID=".$payment."&EID=".$ExamUserid."&url=UpdateSurveyCastle&end=1"]);
                 if($response->ok())
                 {
                 $data=$response->json();
                 if($data['status']??0)            
                 return view('conclusions.surveyEnd');
                else
                  {
                    session(['error'=>'لینک نظر سنجی معتبر نمی باشد']);
                     abort(403);
                  }
                 }
                  else
                  {
                    session(['error'=>'لینک نظر سنجی معتبر نمی باشد']);
                     abort(403);
                  }
    }
}
