<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SmsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Answer;
use App\Models\Exam;
use Illuminate\Support\Facades\Http;
use App\Models\exam_formular;
use GuzzleHttp\Client;
use PDO;
class ApiController extends Controller
{
    public function CheckNumber()
     {
        $count=0;
       $users= DB::table('users')->select('id','phone')->get();
       foreach($users as $user)
       {
        if(!is_numeric($user->phone))
        {
        $phone=$this->convertNumber($user->phone);
        DB::table('users')->where('id',$user->id)->update(['phone'=>$phone]);
        $count++;
        }
       }
       return $count;
    }
    public function convertNumber($string) {
            $newNumbers = range(0, 9);
            // 1. Persian HTML decimal
            $persianDecimal = array('&#1776;', '&#1777;', '&#1778;', '&#1779;', '&#1780;', '&#1781;', '&#1782;', '&#1783;', '&#1784;', '&#1785;');
            // 2. Arabic HTML decimal
            $arabicDecimal = array('&#1632;', '&#1633;', '&#1634;', '&#1635;', '&#1636;', '&#1637;', '&#1638;', '&#1639;', '&#1640;', '&#1641;');
            // 3. Arabic Numeric
            $arabic = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');
            // 4. Persian Numeric
            $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
    
            $string =  str_replace($persianDecimal, $newNumbers, $string);
            $string =  str_replace($arabicDecimal, $newNumbers, $string);
            $string =  str_replace($arabic, $newNumbers, $string);
            return str_replace($persian, $newNumbers, $string);
        
    }
    public function saveExamQuestionAnswerRecord(Request $request){
        $userExams = DB::table('exam_user')->find($request->exam_user_id);
       
       /*$old=DB::table('histories')->where("exam_user_id","=",$request->exam_user_id)->count();
       
        $result = DB::table('histories')
            ->updateOrInsert ( ['user_id'=>$userExams->user_id,'exam_id'=>$userExams->exam_id, "question_id"=>$request->question_id,"exam_user_id"=>$request->exam_user_id]
                                ,[ "answer_id"=>$request->answer_id ] );

       $new=DB::table('histories')->where("exam_user_id","=",$request->exam_user_id)->count();
        if($new>=$old)
        {
            return ['status'=>true,'num'=>$new];
        }
        return response()->json([],500);// ['status'=>false,'num'=>''];*/
        $result = DB::table('histories')
        ->updateOrInsert ( [ "question_id"=>$request->question_id,"exam_user_id"=>$request->exam_user_id,"active"=>1]
                            ,[ "answer_id"=>$request->answer_id ,'user_id'=>$userExams->user_id,'exam_id'=>$userExams->exam_id] );
                            
        $new=DB::table('histories')->where("active",1)->where("exam_user_id","=",$request->exam_user_id)->count();
               
        return ['status'=>true,'num'=>$new];
    }
    public function checkUser(Request $request){
       $existingUser = DB::table("users")->where("phone","=",$request->phone)->get()->first();
       if($existingUser){
            return ["result"=>true];
       }
       else{
            return ["result"=>false];
       }
    }
    public function getUserInfo(Request $request){
        $flag=false;
       $existingUser = DB::table("users")->where("phone","=",$request->Phone)->select('firstName','age','status')->get()->first();
       if($existingUser)
       $flag=true;
        else
        {
            $existingUser = DB::table("users")->where("phone","=",'0'.$request->Phone)->select('firstName','age','status')->get()->first();
            if($existingUser)
            $flag=true;
            else
                return  response()->json(["result"=>false],500);
        }
        if($flag)
        {
           $st='';
            $status=($existingUser->status)?explode(',',$existingUser->status):[];     
            if(in_array(1,$status)) $st.='- مشاهده فیلم پیش نیاز استعدادیابی<br>';
            
            if(in_array(2,$status) && in_array(3,$status))   $st.='- انجام آزمون استعدادیابی<br>'; 
            elseif(in_array(2,$status))   $st.='- انجام مرحله اول آزمون استعدادیابی<br>';   
            elseif(in_array(3,$status))   $st.='- انجام مرحله دوم آزمون استعدادیابی<br>';   

                        
             if(in_array(4,$status)) $st.='- مشاهده نتیجه استعدادیابی<br>';
             if(in_array(5,$status)) $st.='- مشاهده فیلم آموزش افزایش اعتماد به نفس<br>';
             if(in_array(6,$status)) $st.='- مشاهده فیلم آموزش علاقه مندی به یادگیری<br>';            
			 if(!($st))
			 {
				$st='× کاربر فعالیتی نداشته است ×';
			 }
        $existingUser->status=$st;
        return response()->json(["result"=>$existingUser]); 
        } 
        return  response()->json(["result"=>false],500);

    }
    public function userExams(Request $request){
        $user = DB::table('users')->where("phone","=",$request->phone)->get()->first();
        $userExams = DB::table('exam_user')->where([
            ["user_id","=",$user->id], ["active",1],["enable",1],
        ])->get();
        $result = [];
        foreach($userExams as $userExam){
            $exam = DB::table('exams')->where("id","=",$userExam->exam_id)->get()->first();
           // array_push($result,$exam);
             array_push($result,[
                 'name'=>$userExam->name,
                 'exam_user_id'=>$userExam->id,
                 'exam_name'=>$exam->name,
                 'exam_time'=>$exam->time,
                 'exam_id'=>$exam->id,
                ]);
        }
        return $result;
    }
    public function getAllExamUserHistory(Request $request){
        $result = [];
        //$date = $request->date;
        $first_date = $request->first_date;
        $last_date = $request->last_date;
        $perm = $request->perm??0;
        $phones = $request->phones;
        //if($date==null){
        if($first_date==null && $last_date==null){
            if($perm==3)
            {
                $uids=DB::table('users')->whereIn('phone',$phones)->pluck('id');
            $exam_users = DB::table('exam_user')->whereIn('user_id',$uids)
            //->where('active',1)
            ->where('enable',1)
            ->orderByDesc('created_at')->get();
            }
            elseif($perm==4)
            {
               $uids=DB::table('users')->where('phone','like',"%".$phones."%")->pluck('id');
            $exam_users = DB::table('exam_user')->whereIn('user_id',$uids)
            //->where('active',1)
            ->where('enable',1)
            ->orderByDesc('created_at')->get();
            }
            else
                $exam_users = DB::table('exam_user')->where('active',1)->where('enable',1)->orderByDesc('created_at')->get();
            foreach($exam_users as $exam_user){
               // array_push($result,["user"=>DB::table("users")->where('id',"=",$exam_user->user_id)->get(),"exam"=>DB::table('exams')->where('id','=',$exam_user->exam_id)->get(),"user_exam_created_at"=>$exam_user->created_at]);
                array_push($result,
                [
                    "user"=>DB::table("users")->where('id',"=",$exam_user->user_id)->get(),
                    "exam"=>DB::table('exams')->where('id','=',$exam_user->exam_id)->get(),
                    "user_exam_created_at"=>$exam_user->created_at,
                    'name'=>$exam_user->name,
                    'exam_user_id'=>$exam_user->id,
                ]);
            }
        }
        else{
            //$exam_users = DB::table('exam_user')->where('created_at','LIKE','%'.$date.'%')->get();
            //$exam_users = DB::table('exam_user')->whereBetween('created_at',[$first_date,$last_date])->get();
            $first_date = Carbon::parse($request->first_date)
                             ->toDateTimeString();
           $last_date = Carbon::parse($request->last_date)->addDay()
                              ->toDateTimeString();
            if($perm==3)
            {
                $uids=DB::table('users')->whereIn('phone',$phones)->pluck('id');
            $exam_users = DB::table('exam_user')->whereIn('user_id',$uids)
            //->where('active',1)
            ->where('enable',1)
            ->whereBetween('created_at', [
                $first_date, $last_date
            ])->orderByDesc('created_at')->get();
            }
            elseif($perm==4)
            {
                $uids=DB::table('users')->where('phone','like',"%".$phones."%")->pluck('id');
                $exam_users = DB::table('exam_user')->whereIn('user_id',$uids)
                //->where('active',1)
                ->where('enable',1)
                ->whereBetween('created_at', [
                    $first_date, $last_date
                ])->orderByDesc('created_at')->get();
            }
            else
            {
                $exam_users = DB::table('exam_user')
                //->where('active',1)
                ->where('enable',1)
                ->whereBetween('created_at', [
                    $first_date, $last_date
                ])->orderByDesc('created_at')->get();
            }
            foreach($exam_users as $exam_user){
                //array_push($result,["user"=>DB::table("users")->where('id',"=",$exam_user->user_id)->get(),"exam"=>DB::table('exams')->where('id','=',$exam_user->exam_id)->get(),"user_exam_created_at"=>$exam_user->created_at]);
                array_push($result,
                [
                    "user"=>DB::table("users")->where('id',"=",$exam_user->user_id)->get(),
                    "exam"=>DB::table('exams')->where('id','=',$exam_user->exam_id)->get(),
                    "user_exam_created_at"=>$exam_user->created_at,
                    'name'=>$exam_user->name,
                    'exam_user_id'=>$exam_user->id,
                ]);
            }
        }
        return $result;
    }
    public function getAllExamUserHistory_New(Request $request){
        $result = [];
        //$date = $request->date;
        $first_date = $request->first_date;
        $last_date = $request->last_date;
        $perm = $request->perm??0;
        $seen = $request->seen??0;
        $all = $request->all??0;
        $phones = $request->phones;
       
        //if($date==null){
        if(($first_date==null && $last_date==null) || $all){
            if($perm==3)
            {
                $uids=DB::table('users')->whereIn('phone',$phones)->pluck('id');
            $exam_users = DB::table('exam_user')->whereIn('user_id',$uids)
            //->where('active',1)
            ->where('enable',1)
            ->where('seen',$seen)->get();
            }
            elseif($perm==4)
            {
                $uids=DB::table('users')->where('phone','like',"%".$phones."%")->pluck('id');
            $exam_users = DB::table('exam_user')->whereIn('user_id',$uids)
            //->where('active',1)
            ->where('enable',1)
            ->where('seen',$seen)->orderByDesc('created_at')->get();
            }
            else
                $exam_users = DB::table('exam_user')
                //->where('active',1)
                ->where('enable',1)
                ->where('seen',$seen)->get();
            foreach($exam_users as $exam_user){
               // array_push($result,["user"=>DB::table("users")->where('id',"=",$exam_user->user_id)->get(),"exam"=>DB::table('exams')->where('id','=',$exam_user->exam_id)->get(),"user_exam_created_at"=>$exam_user->created_at]);
                $count=[DB::table('questions')->where('exam_id',$exam_user->exam_id)->count(),DB::table('histories')->where('exam_user_id',$exam_user->id)->where('active',1)->count()];
                if($count[0]-$count[1]!=$count[0])
                {
                array_push($result,
                [
                    "user"=>DB::table("users")->where('id',"=",$exam_user->user_id)->get(),
                    "exam"=>DB::table('exams')->where('id','=',$exam_user->exam_id)->get(),
                    "user_exam_created_at"=>$exam_user->created_at,
                    'name'=>$exam_user->name,
                    'exam_user_id'=>$exam_user->id,
                    'seen'=>$exam_user->seen,
                    'count'=>$count,
                    'active'=>$exam_user->active,
]);
                }
            }
        }
        else{
            //$exam_users = DB::table('exam_user')->where('created_at','LIKE','%'.$date.'%')->get();
            //$exam_users = DB::table('exam_user')->whereBetween('created_at',[$first_date,$last_date])->get();
            $first_date = Carbon::parse($request->first_date)
                             ->toDateTimeString();
           $last_date = Carbon::parse($request->last_date)->addDay()
                              ->toDateTimeString();
            if($perm==3)
            {
                $uids=DB::table('users')->whereIn('phone',$phones)->pluck('id');
            $exam_users = DB::table('exam_user')->whereIn('user_id',$uids)
            //->where('active',1)
            ->where('enable',1)
            ->where('seen',$seen)
            ->whereBetween('created_at', [
                $first_date, $last_date
            ])->orderByDesc('created_at')->get();
            }
            elseif($perm==4)
            {
                $uids=DB::table('users')->where('phone','like',"%".$phones."%")->pluck('id');
                $exam_users = DB::table('exam_user')->whereIn('user_id',$uids)
                //->where('active',1)
                ->where('enable',1)
                ->where('seen',$seen)
                ->whereBetween('created_at', [
                    $first_date, $last_date
                ])->orderByDesc('created_at')->get();
            }
            else
            {
                $exam_users = DB::table('exam_user')
                //->where('active',1)
                ->where('enable',1)
                ->where('seen',$seen)
                ->whereBetween('created_at', [
                    $first_date, $last_date
                ])->orderByDesc('created_at')->get();
            }
            foreach($exam_users as $exam_user){
                //array_push($result,["user"=>DB::table("users")->where('id',"=",$exam_user->user_id)->get(),"exam"=>DB::table('exams')->where('id','=',$exam_user->exam_id)->get(),"user_exam_created_at"=>$exam_user->created_at]);
                $count=[DB::table('questions')->where('exam_id',$exam_user->exam_id)->count(),DB::table('histories')->where('exam_user_id',$exam_user->id)->where('active',1)->count()];
                if($count[0]-$count[1]!=$count[0])
                {
                array_push($result,
                [
                    "user"=>DB::table("users")->where('id',"=",$exam_user->user_id)->get(),
                    "exam"=>DB::table('exams')->where('id','=',$exam_user->exam_id)->get(),
                    "user_exam_created_at"=>$exam_user->created_at,
                    'name'=>$exam_user->name,
                    'exam_user_id'=>$exam_user->id,
                    'seen'=>$exam_user->seen,
                  'count'=>$count,
                  'active'=>$exam_user->active,
]);
}
            }
        }
        return $result;
    }
    public function getCountExam(Request $request){
        $first_date = $request->first_date;
        $last_date = $request->last_date;
        $perm = $request->perm??0;
        $all = $request->all??0;
        $phones = $request->phones;
        
        for($seen=0;$seen<=1;$seen++)
        {
        if(($first_date==null && $last_date==null) || $all){
            if($perm==3)
            {
                $uids=DB::table('users')->whereIn('phone',$phones)->pluck('id');
            $exam_users = DB::table('exam_user')->whereIn('user_id',$uids)
            ->where('active',1)
            ->where('enable',1)
            ->where('seen',$seen)->get();
            }
            elseif($perm==4)
            {
                $uids=DB::table('users')->where('phone','like',"%".$phones."%")->pluck('id');
            $exam_users = DB::table('exam_user')->whereIn('user_id',$uids)
            ->where('active',1)
            ->where('enable',1)
            ->where('seen',$seen)->orderByDesc('created_at')->get();
            }
            else
            {
                $exam_users = DB::table('exam_user')
                ->where('active',1)
                ->where('enable',1)
                ->where('seen',$seen)->get();
            }
          if($seen)
            $seencount=$exam_users->count(); 
          else
           $unseencount=$exam_users->count(); 
        }
        else{
            $first_date = Carbon::parse($request->first_date)
                             ->toDateTimeString();
           $last_date = Carbon::parse($request->last_date)->addDay()
                              ->toDateTimeString();
            if($perm==3)
            {
                $uids=DB::table('users')->whereIn('phone',$phones)->pluck('id');
            $exam_users = DB::table('exam_user')->whereIn('user_id',$uids)
            ->where('active',1)
            ->where('enable',1)
            ->where('seen',$seen)
            ->whereBetween('created_at', [
                $first_date, $last_date
            ])->orderByDesc('created_at')->get();
            }
            elseif($perm==4)
            {
                $uids=DB::table('users')->where('phone','like',"%".$phones."%")->pluck('id');
                $exam_users = DB::table('exam_user')->whereIn('user_id',$uids)
                ->where('active',1)
                ->where('enable',1)
                ->where('seen',$seen)
                ->whereBetween('created_at', [
                    $first_date, $last_date
                ])->orderByDesc('created_at')->get();
            }
            else
            {
                $exam_users = DB::table('exam_user')
                ->where('active',1)
                ->where('enable',1)
                ->where('seen',$seen)
                ->whereBetween('created_at', [
                    $first_date, $last_date
                ])->orderByDesc('created_at')->get();
            }
            
              if($seen)
                $seencount=$exam_users->count(); 
              else
               $unseencount=$exam_users->count(); 
            }
        }
        return ['seen'=>$seencount,'unseen'=>$unseencount];
    }
    public function getCountTodayExams(Request $request){
        $perm = $request->perm??0;
        $phones = $request->phones;
            if($perm==3)
            {
                $uids=DB::table('users')->whereIn('phone',$phones)->pluck('id');
            $exam_users = DB::table('exam_user')->whereIn('user_id',$uids)
            ->where('active',1)
            ->where('enable',1)
            ->where('seen',0)
            ->whereDate('created_at','>=',today())
            ->orderByDesc('created_at')->get();
            }
            else
            {
                $exam_users = DB::table('exam_user')
                ->where('active',1)
                ->where('enable',1)
                ->where('seen',0)->whereDate('created_at','>=',today())
                ->orderByDesc('created_at')->get();
            }
            
        return $exam_users->count();
    }

    public function setExamRead(Request $request){
        $userExams = DB::table('exam_user')->where('Id',$request->exam_id)
        ->update(['seen'=>1]);
        return  true;
    }
    public function examResults(Request $request){
        $this->setExamRead($request);
        
        $EUtbl=DB::table("exam_user")->find($request->exam_id);
        $examtbl=Exam::find($EUtbl->exam_id);
        $score2=0;
        if($examtbl->formuls()->count())
           $type=2;
        else
            $type=1;
            
        $result = [];
        $flag = false;
        $score =DB::table("exam_user")->find($request->exam_id)->score??0;
        $C=0;
        $I=0;
        $S=0;
        $D=0;
        $inputFlag=false;
        
        $histories = DB::table('histories')->where('exam_user_id',$request->exam_id)->where('active',1)->get();
        foreach($histories as $value){
            $question = DB::table('questions')->find($value->question_id);
            $answer = DB::table('answers')->find($value->answer_id);
            array_push($result,["question"=>$question->name,"answer"=>$answer->name]);
            if($answer->is_char)
            {
                if(!$score)
                {
                    $flag=true;
                    $char = $answer->char_value;
                    $char_value = $answer->value;
                    if($char=="I"){
                        $I = $I + $char_value;
                    }
                    if($char=="C"){
                        $C = $C + $char_value;
                    }
                    if($char=="S"){
                        $S = $S + $char_value;
                    }
                    if($char=="D"){
                        $D = $D + $char_value;
                    }
                }
            }
            else
            $score2 += $answer->value;
        }
        if($flag)
        {
            $disc=["D"=>$D,"I"=>$I,"S"=>$S,"C"=>$C];
            foreach($disc as $index=>$item)
                    {
                        $num=DB::table('talents')->where('type',$index)->where('number',$item)->first()->index;
                        if($num>=13 )
                        {
                        $scores[]=$num;  
                        $indexs[]=$index;  
                        }                     
                    }  
                    $score=''; 
                    asort($scores);
                    $scores=array_reverse($scores,1);
                    $max=max($scores);
                    //$scores=array_unique($scores);

                    foreach($scores as $index=>$item)
                    {    if($max==$item)
                        $maxs[]=$index;
                    } 
                     asort($maxs);
                    if(count($maxs)==1)
                        foreach($scores as $index=>$item)
                        {
                            if(strlen($score)<2)                     
                            $score.=$indexs[$index];
                        } 
                    else
                        foreach($maxs as $index=>$item)
                        {
                            if(strlen($score)<2)                     
                            $score.=$indexs[$item];
                        } 
                    $inputFlag=true;
            
           /* $find = DB::table('talent_history')->where([
                ["i","=",$I],
                ["s","=",$S],
                ["c","=",$C],
                ["d","=",$D],
                ])->first();
            if($find){
                $score = $find->personal_type;
                $inputFlag=true;
            }
            else{
                $score = "D=>(".$D."),I=>(".$I."),S=>(".$S."),C=>(".$C.")";
            }*/
        }
        else{
            if($score)
            {
            $score=json_decode($score);
            if($EUtbl->exam_id==4)
            {
                $D=$score->disc->D;
                $I=$score->disc->I;
                $S=$score->disc->S;
                $C=$score->disc->C;
                    $inputFlag=true;
            }
                $score=$score->score;
            }
            else
            $score=$score2;
        }
        if($EUtbl->exam_id==6)
        {
            DB::table("exam_user")->where('id',$request->exam_id)->update(['score'=>json_encode(['disc'=>[],'score'=>$score])]);
        }
       // array_push($result,["name"=>$eu->name]);
        array_push($result,['type'=>$type,"score"=>$score,"i"=>$I,"s"=>$S,"c"=>$C,"d"=>$D,"UserName"=>$EUtbl->name,'ExamName'=>$examtbl->name]);
        array_push($result,["flag"=>$inputFlag]);
       return $result;
    } 
    public function examResults_1(Request $request){
        $this->setExamRead($request);
        
        $EUtbl=DB::table("exam_user")->find($request->exam_id);
        $examtbl=Exam::find($EUtbl->exam_id);
        $out='';
        if($examtbl->formuls()->count())
           $type=2;
        else
            $type=1;
            
        $user = DB::table('users')->where("phone","=",$request->phone)->get()->first();
        $result = [];
        $flag = false;
        $score = 0;
        $C=0;
        $I=0;
        $S=0;
        $D=0;
        $inputFlag=false;
        $histories = DB::table('histories')->where('exam_user_id',$request->exam_id)->where('active',1)->get();
        foreach($histories as $value){
            if(Answer::find($value->answer_id)->is_char){
                $flag=true;
            }
            break;
        }
        if($flag){
            foreach($histories as $value){
                $question = DB::table('questions')->where('id','=',$value->question_id)->get()->first();
                $answer = DB::table('answers')->where('id','=',$value->answer_id)->get()->first();
                array_push($result,["question"=>$question->name,"answer"=>$answer->name]);
                $char = Answer::find($value->answer_id)->char_value;
                $char_value = Answer::find($value->answer_id)->value;
                if($char=="I"){
                    $I = $I + $char_value;
                }
                if($char=="C"){
                    $C = $C + $char_value;
                }
                if($char=="S"){
                    $S = $S + $char_value;
                }
                if($char=="D"){
                    $D = $D + $char_value;
                }
            }
            $disc=["D"=>$D,"I"=>$I,"S"=>$S,"C"=>$C];
            foreach($disc as $index=>$item)
                    {
                        $num=DB::table('talents')->where('type',$index)->where('number',$item)->first()->index;
                        if($num>=13 )
                        {
                        $scores[]=$num;  
                        $indexs[]=$index;  
                        }                     
                    }  
                    $score=''; 
                    asort($scores);
                    $scores=array_reverse($scores,1);
                    $max=max($scores);
                    //$scores=array_unique($scores);

                    foreach($scores as $index=>$item)
                    {    if($max==$item)
                        $maxs[]=$index;
                    } 
                     asort($maxs);
                    if(count($maxs)==1)
                        foreach($scores as $index=>$item)
                        {
                            if(strlen($score)<2)                     
                            $score.=$indexs[$index];
                        } 
                    else
                        foreach($maxs as $index=>$item)
                        {
                            if(strlen($score)<2)                     
                            $score.=$indexs[$item];
                        } 
                    $inputFlag=true;
           /* $find = DB::table('talent_history')->where([
                ["i","=",$I],
                ["s","=",$S],
                ["c","=",$C],
                ["d","=",$D],
                ])->first();
            if($find){
                $score = $find->personal_type;
                $inputFlag=true;
            }
            else{
                $score = "D=>(".$D."),I=>(".$I."),S=>(".$S."),C=>(".$C.")";
            }*/
        }
        else{
            foreach($histories as $history){
                $question = DB::table('questions')->where('id','=',$history->question_id)->get()->first();
                $answer = DB::table('answers')->where('id','=',$history->answer_id)->get()->first();
                $score = $score + $answer->value;
                array_push($result,["question"=>$question->name,"answer"=>$answer->name]);
            }
        }
        $eu=DB::table('exam_user')->find($request->exam_id);
        $exam=DB::table('exams')->find($eu->exam_id);
       // array_push($result,["name"=>$eu->name]);
        array_push($result,['type'=>$type,"score"=>$score,"i"=>$I,"s"=>$S,"c"=>$C,"d"=>$D,"UserName"=>$eu->name,'ExamName'=>$exam->name]);
        array_push($result,["flag"=>$inputFlag]);
       return $result;
    } 
    public function addTalentScore(Request $request){
        $result = DB::table('talent_history')->updateOrInsert(
                ["i"=>$request->i,
                "s"=>$request->s,
                "c"=>$request->c,
                "d"=>$request->d],
                ["personal_type"=>$request->personal_type]
            );
        if($result){
            return ["result"=>true];
        }
        else{
            return ["result"=>false];
        }
    }
    public function ExamAnalyisis(Request $req)
    {
        $EUtbl=DB::table("exam_user")->find($req->exam_user_id);
        $examtbl=Exam::find($EUtbl->exam_id);
        $out='';
        if($examtbl->formuls()->count())
        {
            $historyResult = DB::table('histories')->where("exam_user_id","=",$req->exam_user_id)->where('active',1)->pluck("answer_id")->toArray();
            
            foreach($examtbl->formuls()->where('type','1')->get() as $formul)
            {
                $ids=[];
                foreach(json_decode($formul->questions) as $quiz)
                    $ids[":$quiz"]=0;

                $answers=Answer::whereIn('question_id',(Array)json_decode($formul->questions))->whereIn('id',$historyResult)->get(); 
                foreach($answers as $ans)
                    $ids[":$ans->question_id"]=$ans->value;

                $oprator=[":count"=>count($ids),":mode"=>"%",":%"=>"/100"];
                $formul->formul=strtr($formul->formul,['{'=>'','}'=>'']);
                $rep=strtr($formul->formul,$ids);
                $rep=strtr($rep,$oprator);
                $res=eval("return number_format($rep,2);");
                $defaultResult[$formul->id]=$res;

                $conditation=exam_formular::find($formul->id)->conditations()->get();
                //$conditation=(Array)json_decode($formul->conditation);
                $formul->default=strtr($formul->default,['{:RESULT}'=>$res,'{:LABEL}'=>$formul->label]);
                
                    if(!$formul->default)
                    {
                        $out.='<br/><b>'.$formul->label.': '.$res.'</b><br/>';
                    }
                    else
                    $out.='<br/><b>'.$formul->default.'</b><br/>';

                 foreach($conditation as $con)
                    {
                        $conditation_if=strtr($con->conditation,['{:RESULT}'=>$res]);
                        
                        if(!is_null($conditation_if))
                        {
                            $res2=eval("return $conditation_if;");
                            if($res2)
                            {
                                $out.=strtr($con->then,['{:RESULT}'=>$res,'{:LABEL}'=>$formul->label,"\r\n"=>'<br/>',"</b>"=>'</b><br/>']).'<br/>';
                            }
                        } 
                    }  
                
            }
            
            $defbodys=$examtbl->conditation()->where('default',1)->get();
            $oprator=[":count"=>count($ids),":mode"=>"%",":%"=>"/100"];
            foreach($examtbl->formuls()->where('type','1')->get() as $fid)
            {
                $furmulids["{:RESULT-$fid->id}"]=$defaultResult[$fid->id];
                $furmulids["{:LABEL-$fid->id}"]=$fid->label;
            }
            foreach( $defbodys as $defbody)
            {
                     $defbody->body=strtr($defbody->body,$furmulids);
                    $defbody->body=strtr($defbody->body,$oprator); 
                     $out=$defbody->body.'<p style="text-align: right;" dir="rtl">'.$out;               
            }
            foreach( $examtbl->formuls()->where('type','2')->get() as $formul)
            {
                $rep=strtr($formul->formul,$furmulids);
                $rep=strtr($rep,$oprator); 
                
                
                $rep=strtr($rep,$furmulids);

                $res=eval("return number_format($rep,2);");
                $conditation=exam_formular::find($formul->id)->conditations()->get();
               
                $out.="<br>";
                foreach($conditation as $con)
                {
                    $conditation_if=strtr($con->conditation,['{:RESULT}'=>$res,"\r\n"=>'<br/>']);
                    $conditation_if=strtr($conditation_if,$furmulids);
                    
                    if(!is_null($conditation_if))
                    {
                        $res2=eval("return $conditation_if;");
                        if($res2)
                        {
                            $out.=strtr($con->then,['{:RESULT}'=>$res,'{:LABEL}'=>$formul->label,"\r\n"=>'<br/>',"</b>"=>'</b><br/>']).'<br/>';
                        }
                    } 
                }          
            }

            $out.='</p>';
            return response()->json(['status'=>true,
            'output'=>['phone'=>User::find($EUtbl->user_id)->phone,"UserName"=>$EUtbl->name,'ExamName'=>$examtbl->name,'out'=>$out]
            ]);
        }
        return response()->json(['status'=>false,'output'=>$out],500);
    }
    
      public function getTalentExamUserHistory(Request $request){
        $first_date = $request->first_date;
        $last_date = $request->last_date;
         $phones = $request->phones;
        if($first_date==null && $last_date==null)
        {
            $uids=DB::table('users')->whereIn('phone',$phones)->pluck('id');
            $exam_users = DB::table('exam_user')->whereIn('user_id',$uids)
            ->whereIn('exam_id',[4,6])
            ->where('enable',1)
            //->where('active',1)
           ->distinct()->pluck('user_id')->toArray();
            
        }
        else
        {
            $first_date = Carbon::parse($request->first_date)
                             ->toDateTimeString();
           $last_date = Carbon::parse($request->last_date)->addDay()
                              ->toDateTimeString();
             $uids=DB::table('users')->whereIn('phone',$phones)->pluck('id');
            $exam_users = DB::table('exam_user')->whereIn('user_id',$uids)
            ->whereIn('exam_id',[4,6])
            ->where('enable',1)
            //->where('active',1)
            ->whereBetween('created_at', [
                $first_date, $last_date
            ])->distinct()->pluck('user_id')->toArray();
            
        }
        $users=DB::table('users')->whereIn('id',$exam_users)->distinct()->pluck('phone') ->toArray();
        
        return response()->json([count($exam_users),$users]);
    }
    
    public function savecronjobs(Request $req)//phone,time,done,cron,support
    {
        $pro=0;
        if($pro)
        {
            /* Exam PRO */
            if(User::where('phone',$req->phone)->exists())
            {
                $user=User::where('phone',$req->phone)->first();
            User::where('id',$user->id)->update([
                "support_id"=>$req->supportid,
                "seller_id"=>$req->sellerid,
                "panel_id"=>$req->userid
            ]);

            }
            else
            {
                $user = User::create([
                "phone"=>$req->phone,
                "support_id"=>$req->supportid,
                "seller_id"=>$req->sellerid,
                "panel_id"=>$req->userid
            ]);
            }
        DB::table('user_crons')->updateOrInsert(
                ['phone'=>$req->phone],
                ['done'=>$req->done,'user_id'=>$user->id,'time'=>$req->time,
                'cron'=>$req->cron,'support'=>$req->support,'date'=>date('Y-m-d H:i:s')]);
                return true;
        }
        else
        {
        $uid=(User::where('phone',$req->phone)->exists())?User::where('phone',$req->phone)->first()->id:null;
       DB::table('user_crons')->updateOrInsert(
            ['phone'=>$req->phone],
            ['done'=>$req->done,'user_id'=>$uid,'time'=>$req->time,
            'cron'=>$req->cron,'support'=>$req->support,'date'=>date('Y-m-d H:i:s')]);
            return true;
        }
    }
    public function runcronjob()
    {
        
       $crons = DB::table('user_crons')
       ->where('done',0)->get();
       if($crons->count())
       {
        $sms=new SmsController();
            foreach ($crons as $cron)
             {
                switch ($cron->cron) {
                    case '5':
                        $flag=false;
                       if($cron->user_id)
                       {
                            if(DB::table("exam_user")->where('user_id',$cron->user_id)->where('enable',1)->exists())
                            DB::table("user_crons")->where('id',$cron->id)->update(['done'=>1]);
                            else
                            $flag=true;
                        }
                        else                        
                        $flag=true;
                        if($flag)
                            if(now()>=date_create($cron->date)->modify($cron->time))
                            {
                                DB::table("user_crons")->where('id',$cron->id)->update(['done'=>1]);
                                $sms->cronsms($cron->cron,$cron->phone);
                            }                            
                        break;
                    
                    default:
                       
                    if(now()>=date_create($cron->date)->modify($cron->time))
                    {
                        DB::table("user_crons")->where('id',$cron->id)->update(['done'=>1]);
                       $sms->cronsms($cron->cron,$cron->phone);
                    }  
                        break;
                }
            }
       }
        return  true;

    }
    public function UserStatus(Request $req)
    {
        $existingUser=DB::table('users')
        ->whereDate('created_at','>=',$req->start)
        ->whereDate('created_at','<=',$req->end)
        ->where('active',1)
        ->select('status')->get();  
        
        $data=[$existingUser->count(),0,0,0,0,0,0,0,0];
        foreach ($existingUser as $index => $user) 
        {
            try {
                if(in_array(1,explode(',',$user->status)))   $data[1]+=1;
               // if(in_array(2,$status) && in_array(3,$status))   $data[2]+=1; 
                if(in_array(2,explode(',',$user->status)))   $data[2]+=1; 
                if(in_array(3,explode(',',$user->status)))   $data[3]+=1;     
                if(in_array(4,explode(',',$user->status))) $data[4]+=1; 
                if(in_array(5,explode(',',$user->status))) $data[5]+=1; 
                if(in_array(6,explode(',',$user->status))) $data[6]+=1; 
            } catch (\Throwable $th) {
                
                $data[0]+=1;
            } 
        }
        $data['data']=$data;
        $data['labels']=['ثبت نام','پیش نیاز استعدادیابی'
            ,'مرحله اول آزمون ',' مرحله دوم آزمون',
            'مشاهده نتیجه ','فیلم افزایش اعتماد به نفس','فیلم علاقه مندی به یادگیری'];        
            return response()->json($data);
    }
    
    
   public function UserPanel()
    {
        $d[]=DB::table('users')
        ->whereDate('created_at','>=',date('Y-m-d'))
        ->whereDate('created_at','<=',date('Y-m-d'))
        ->where('active',1)
        ->count();    
        
        $a=DB::table('sms')
        ->whereDate('created_at','>=',date('Y-m-d'))
        ->whereDate('created_at','<=',date('Y-m-d'))
        //->distinct('phone')
        ->pluck('phone')->toArray(); 
        $d[]=count($a);
        $a=array_unique($a);
        $d[]=count($a);
        var_dump($d);
            return response()->json($d);
    }
    public function getCountDateExams(Request $request){
        $first_date = $request->first_date;
        $last_date = $request->last_date??null;

                $exam_users = DB::table('exam_user')
                ->where('enable',1)
                ->where('active',1);
    		if($last_date)
            {
                $exam_users = $exam_users->whereDate('created_at','>=',$first_date)
                ->whereDate('created_at','<=',$last_date);
            }
            else
            {
                $exam_users = $exam_users->whereDate('created_at','=',$first_date);
            }

       $exam_users = $exam_users->orderByDesc('created_at')->pluck('user_id');
        return ["users"=>count(array_unique($exam_users->toArray())),"exams"=>count($exam_users->toArray())];
    }
    
    public function getPhoneExamUsers(Request $request)
    {        
        $result = DB::table('users')
        ->whereNotNull('firstName')
         ->whereDate('created_at','>=',$request->first_date)
        ->whereDate('created_at','<=',$request->last_date)
        ->whereRaw('exists( select id from exam_user where user_id=users.id and seen=0  and active=1 and enable=1 and exam_id=6 )')
        ->pluck('phone');          
         
        return response()->json($result->toArray());
    }
     function addRquestINPanel(Request $req)
   {
        $phone = 'phone='.$this->convertNumber($req->phone).'&platform=26&description='.$req->description;
       $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://erfankhoshnazar.com/exam-api/api.php',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>$phone,
         
         CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded'
          ),
        ));

    $response = curl_exec($curl);
    
    curl_close($curl);
    return ($response) ;
   }
   /* Exam PRO */
   
   public function getAllExamUserHistory_PRO(Request $request)
    {
        $result = [];
        //$date = $request->date;
        $first_date = $request->first_date;
        $last_date = $request->last_date;
        $perm = $request->perm??0;
        $seen=$unseen=[];
        $all = $request->all??0;
        $phones = $request->phones??null;
        $SID=$request->SID;
    
        //if($date==null){
        if(($first_date==null && $last_date==null) || $all){
            if($perm==3)
            {
                if($phones)
                $uids=DB::table('users')->where('phone',$phones)->pluck('id');
                else
                $uids=DB::table('users')->where('support_id',$SID)->orWhere('seller_id',$SID)->pluck('id');
                $exam_users = DB::table('exam_user')->whereIn('user_id',$uids)
                //->where('active',1)
                ->where('enable',1)
                ->get();
            }
            elseif($perm==4)
            {
                $uids=DB::table('users')->where('phone','like',"%".$phones."%")->pluck('id');
            $exam_users = DB::table('exam_user')->whereIn('user_id',$uids)
            //->where('active',1)
            ->where('enable',1)
        ->orderByDesc('created_at')->get();
            }
            else
                $exam_users = DB::table('exam_user')
                //->where('active',1)
                ->where('enable',1)
                ->get();
                
            foreach($exam_users as $exam_user){
            // array_push($result,["user"=>DB::table("users")->where('id',"=",$exam_user->user_id)->get(),"exam"=>DB::table('exams')->where('id','=',$exam_user->exam_id)->get(),"user_exam_created_at"=>$exam_user->created_at]);
                $count=[DB::table('questions')->where('exam_id',$exam_user->exam_id)->count(),DB::table('histories')->where('exam_user_id',$exam_user->id)->where('active',1)->count()];
                if($count[0]-$count[1]!=$count[0])
                {
                    if($exam_user->seen)
                    {
                        $seen[]=[
                            "user"=>DB::table("users")->find($exam_user->user_id),
                            "exam"=>DB::table('exams')->find($exam_user->exam_id),
                            "user_exam_created_at"=>$exam_user->created_at,
                            'name'=>$exam_user->name,
                            'exam_user_id'=>$exam_user->id,
                            'seen'=>$exam_user->seen,
                            'count'=>$count,
                            'active'=>$exam_user->active,
                            'lang'=>$exam_user->lang??'fa',
                            ];
                    }
                    else
                    {
                        $unseen[]=[
                            "user"=>DB::table("users")->find($exam_user->user_id),
                            "exam"=>DB::table('exams')->find($exam_user->exam_id),
                            "user_exam_created_at"=>$exam_user->created_at,
                            'name'=>$exam_user->name,
                            'exam_user_id'=>$exam_user->id,
                            'seen'=>$exam_user->seen,
                            'count'=>$count,
                            'active'=>$exam_user->active,
                            'lang'=>$exam_user->lang??'fa',
                            ];
                        
                    }
                
                }
            }
        }
        else{
            //$exam_users = DB::table('exam_user')->where('created_at','LIKE','%'.$date.'%')->get();
            //$exam_users = DB::table('exam_user')->whereBetween('created_at',[$first_date,$last_date])->get();
            /*$first_date = Carbon::parse($request->first_date)
                            ->toDateTimeString();
        $last_date = Carbon::parse($request->last_date)->addDay()
                            ->toDateTimeString();*/
            if($perm==3)
            {
                if($phones)
                $uids=DB::table('users')->where('phone',$phones)->pluck('id');
                else
                $uids=DB::table('users')->where('support_id',$SID)->orWhere('seller_id',$SID)->pluck('id');
                $exam_users = DB::table('exam_user')->whereIn('user_id',$uids)
                //->where('active',1)
                ->where('enable',1)
                ->whereDate('created_at',">=",$request->first_date)
                ->whereDate('created_at',"<=",$request->last_date)
                ->orderByDesc('created_at')->get();
            }
            elseif($perm==4)
            {
                $uids=DB::table('users')->where('phone','like',"%".$phones."%")->pluck('id');
                $exam_users = DB::table('exam_user')->whereIn('user_id',$uids)
                //->where('active',1)
                ->where('enable',1)
                ->whereDate('created_at',">=",$request->first_date)
                ->whereDate('created_at',"<=",$request->last_date)
                ->orderByDesc('created_at')->get();
            }
            else
            {
                $exam_users = DB::table('exam_user')
                //->where('active',1)
                ->where('enable',1)
                ->whereDate('created_at',">=",$request->first_date)
                ->whereDate('created_at',"<=",$request->last_date)
                ->orderByDesc('created_at')->get();
            }
            foreach($exam_users as $exam_user){
                //array_push($result,["user"=>DB::table("users")->where('id',"=",$exam_user->user_id)->get(),"exam"=>DB::table('exams')->where('id','=',$exam_user->exam_id)->get(),"user_exam_created_at"=>$exam_user->created_at]);
                $count=[DB::table('questions')->where('exam_id',$exam_user->exam_id)->count(),DB::table('histories')->where('exam_user_id',$exam_user->id)->where('active',1)->count()];
                if($count[0]-$count[1]!=$count[0])
                {
                    if($exam_user->seen)
                    {
                        $seen[]=[
                            "user"=>DB::table("users")->find($exam_user->user_id),
                            "exam"=>DB::table('exams')->find($exam_user->exam_id),
                            "user_exam_created_at"=>$exam_user->created_at,
                            'name'=>$exam_user->name,
                            'exam_user_id'=>$exam_user->id,
                            'seen'=>$exam_user->seen,
                            'count'=>$count,
                            'active'=>$exam_user->active,
                            'lang'=>$exam_user->lang??'fa',
                            ];
                    }
                    else
                    {
                        $unseen[]=[
                            "user"=>DB::table("users")->find($exam_user->user_id),
                            "exam"=>DB::table('exams')->find($exam_user->exam_id),
                            "user_exam_created_at"=>$exam_user->created_at,
                            'name'=>$exam_user->name,
                            'exam_user_id'=>$exam_user->id,
                            'seen'=>$exam_user->seen,
                            'count'=>$count,
                            'active'=>$exam_user->active,
                            'lang'=>$exam_user->lang??'fa',
                            ];
                        
                    }
                
                }
            }
        }
        return [$unseen,$seen];
    }
    public function getCountExam_PRO(Request $request){
        $first_date = $request->first_date;
        $last_date = $request->last_date;
        $perm = $request->perm??0;
        $all = $request->all??0;
        $phones = $request->phones??null;
        $SID=$request->SID;
        
        for($seen=0;$seen<=1;$seen++)
        {
        if(($first_date==null && $last_date==null) || $all){
            if($perm==3)
            {
                if($phones)
                $uids=DB::table('users')->where('phone',$phones)->pluck('id');
                else
                $uids=DB::table('users')->where('support_id',$SID)->orWhere('seller_id',$SID)->pluck('id');
            $exam_users = DB::table('exam_user')->whereIn('user_id',$uids)
            ->where('active',1)
            ->where('enable',1)
            ->where('seen',$seen)->count();
            }
            elseif($perm==4)
            {
                $uids=DB::table('users')->where('phone','like',"%".$phones."%")->pluck('id');
            $exam_users = DB::table('exam_user')->whereIn('user_id',$uids)
            ->where('active',1)
            ->where('enable',1)
            ->where('seen',$seen)->orderByDesc('created_at')->count();
            }
            else
            {
                $exam_users = DB::table('exam_user')
                ->where('active',1)
                ->where('enable',1)
                ->where('seen',$seen)->count();
            }
        if($seen)
            $seencount=$exam_users; 
        else
        $unseencount=$exam_users; 
        }
        else{
            /*$first_date = Carbon::parse($request->first_date)
                            ->toDateTimeString();
        $last_date = Carbon::parse($request->last_date)->addDay()
                            ->toDateTimeString();*/
            if($perm==3)
            {
            if($phones)
                $uids=DB::table('users')->whereIn('phone',$phones)->pluck('id');
                else
                $uids=DB::table('users')->where('support_id',$SID)->orWhere('seller_id',$SID)->pluck('id');
            $exam_users = DB::table('exam_user')->whereIn('user_id',$uids)
            ->where('active',1)
            ->where('enable',1)
            ->where('seen',$seen)            
            ->whereDate('created_at',">=",$request->first_date)
            ->whereDate('created_at',"<=",$request->last_date)
            ->orderByDesc('created_at')->count();
            }
            elseif($perm==4)
            {
                $uids=DB::table('users')->where('phone','like',"%".$phones."%")->pluck('id');
                $exam_users = DB::table('exam_user')->whereIn('user_id',$uids)
                ->where('active',1)
                ->where('enable',1)
                ->where('seen',$seen)
                ->whereDate('created_at',">=",$request->first_date)
                ->whereDate('created_at',"<=",$request->last_date)
                ->orderByDesc('created_at')->count();
            }
            else
            {
                $exam_users = DB::table('exam_user')
                ->where('active',1)
                ->where('enable',1)
                ->where('seen',$seen)
                ->whereDate('created_at',">=",$request->first_date)
                ->whereDate('created_at',"<=",$request->last_date)
                ->orderByDesc('created_at')->count();
            }
            
            if($seen)
                $seencount=$exam_users; 
            else
            $unseencount=$exam_users; 
            }
        }
        return ['seen'=>$seencount,'unseen'=>$unseencount];
    }
    public function getCountTodayExams_PRO(Request $request)
    {
        $perm = $request->perm??0;
        $SID = $request->SID;
            if($perm==3)
            {
                $uids=DB::table('users')->where('support_id',$SID)->orWhere('seller_id',$SID)->pluck('id');
            $exam_users = DB::table('exam_user')->whereIn('user_id',$uids)
            ->where('active',1)
            ->where('enable',1)
            ->where('seen',0)
            ->whereDate('created_at','>=',today())
            ->orderByDesc('created_at')->count();
            }
            else
            {
                $exam_users = DB::table('exam_user')
                ->where('active',1)
                ->where('enable',1)
                ->where('seen',0)->whereDate('created_at','>=',today())
                ->orderByDesc('created_at')->count();
            }
            
        return $exam_users;
    }
   public function updateuserinfo(Request $req)
   {
	   foreach($req->data as $data)
	   {
		   if(User::where('phone',$data['Phone'])->exists())
			{
			User::where('phone',$data['Phone'])->update([
				"support_id"=>$data['SupportId'],
				"seller_id"=>$data['SellerId'],
				"panel_id"=>$data['Id']
			]);

			}
	   }
		return true;
   }
}
