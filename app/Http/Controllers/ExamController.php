<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExamRequest;
use App\Http\Requests\UpdateExamRequest;
use App\Models\Exam;
use App\Models\Tag;
use App\Models\Answer;
use App\Models\Conclusion;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Exports\ExamUsers;
use App\Models\exam_formular;
use App\Models\group;
use App\Models\Question;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


/*use ProtoneMedia\LaravelFFMpeg\Filters\WatermarkFactory;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;*/

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $exams = Exam::paginate();
        return view('exams.index',["exams"=>$exams]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::all();
        return view('exams.create',["tags"=>$tags]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreExamRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreExamRequest $request)
    {
        $this->validate($request,[
            "title" => ["required", "min:3"],
            "englishTitle"=> ["required", "min:3"],
            "description"=>["required", "min:10"],
            "time"=>["required"],
            "ageRange"=> ["required"]
        ]);
        $slug = str_replace(" ","-",$request->title);
        $exam = Exam::create([
            "name"=>$request->title,
            "slug"=>$slug,
            "englishName"=> $request->englishTitle,
            "description"=>$request->description,
            "time"=>$request->time,
            "ageRange"=> $request->ageRange,
            "level"=>$request->level,
        ]);
        $tag = Tag::find($request->tag);
        $exam->tags()->attach($tag);
        return redirect()->route('exam.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ExamUsers= DB::table("exam_user")->find($id);
        $exam = Exam::find($ExamUsers->exam_id);
        if($exam->groups()->where('status',1)->count())
        return view("exams.show",["exam"=>$exam,'ExamUserid'=>$ExamUsers->id]);
        return view("exams.show_old",["exam"=>$exam,'ExamUserid'=>$ExamUsers->id]);
    }

    public function countMyAnswer($euid)
    {
        $exam = DB::table('histories')->where('exam_user_id',$euid)->count();
        return $exam;
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $exam = Exam::find($id);
        $conclusions = Exam::find($id)->conclusions;
        return view('exams.edit',["exam"=>$exam,"conclusions"=>$conclusions]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateExamRequest  $request
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateExamRequest $request,$id)
    {
        $this->validate($request,[
            "title" => ["required", "min:3"],
            "englishTitle"=> ["required", "min:3"],
            "description"=>["required", "min:10"],
            "time"=>["required"],
            "ageRange"=> ["required"]
        ]);
        $slug = str_replace(" ","-",$request->title);
        DB::table("exams")->where("id","=",$id)->update([
            "name"=>$request->title,
            "slug"=>$slug,
            "englishName"=> $request->englishTitle,
            "description"=>$request->description,
            "time"=>$request->time,
            "ageRange"=> $request->ageRange,
            "level"=>$request->level,
        ]);
        return redirect()->route('exam.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function destroy(Exam $exam)
    {
        //
    }
    public function cancelExam($id){        
        DB::table("exam_user")->delete($id);
        return redirect(route('dashboard'));
    }
    public function setexamgift(Request $req)
    {        
        $EUtbl=DB::table("users")->where('id',auth()->user()->id)->update(['gift'=>$req->gift,'updated_at'=>now()]);
        DB::table("exam_user")->where('id',$req->euid)->update(['gift'=>$req->gift,'updated_at'=>now()]);
        if($EUtbl)
        return true;
        return false;

    }
    public function showConclusion($id){
        $EUtbl=DB::table("exam_user")->find($id);

        /*$count=$this->countMyAnswer($id);
        $ecount=Question::where('exam_id',$EUtbl->exam_id)->count();
        if($count==$ecount)
        DB::table("exam_user")->where('id',$id)->update(['active'=>1]);*/
        $is6=($EUtbl->exam_id==6 );//&& is_null(auth()->user()->gift)
        DB::table("exam_user")->where('exam_id',$EUtbl->exam_id)
        ->where('user_id',$EUtbl->user_id)
        ->where('name',$EUtbl->name)
        ->update(['active'=>0]);
        DB::table("exam_user")->where('id',$id)->update(['active'=>1]);

        $Fail=$Show=0;
        $historyResult = DB::table('histories')->where("exam_user_id","=",$id)->pluck("answer_id")->toArray();
        $groups=group::where('exam_id',DB::table("exam_user")->find($id)->exam_id)->where('status',1)->orderBy('id')->get();
            $out='';
             $answers=implode(',',$historyResult);
             if($groups->count())
             {
                    foreach($groups as $group)
                    {
                        if($group->formul)
                        {
                            $formul=json_decode($group->formul);
                            //$ids='{'; 
                                $ids=[];
                            $frm=$formul->formul;                            
                             $answers=Answer::whereIn('question_id',(Array)json_decode($formul->ids))->whereIn('id',$historyResult)->get(); 
                            foreach($answers as $ans)
                            {
                           // $ids.='":'.$ans->question_id.'":'.$ans->value.',';
                            $ids[":$ans->question_id"]=$ans->value;
                            }
                           // $ids=trim($ids,',').'}';// $ids=(array)json_decode($ids);
                           
                            $oprator=[":count"=>count($ids),":mode"=>"%",":%"=>"/100"];
                            $frm=strtr($frm,['{'=>'','}'=>''],);
                            $rep=strtr($frm,$ids);
                            $rep=strtr($rep,$oprator);
                            $res=eval("return number_format($rep,2);");
                            $conditation=json_decode($formul->conditation);
                            $conditation->if=strtr($conditation->if,['{:RESULT}'=>$res]);
                            $res2=eval("return  $conditation->if;");
                            
                            if($res2)
                            {
                                $out.=strtr($conditation->then,['{:RESULT}'=>$res,"\r\n"=>'<br/>']).'<br/>';
                            }
                            else
                            {
                                $out.=strtr($conditation->else,['{:RESULT}'=>$res,"\r\n"=>'<br/>']).'<br/>';
                            }
                            // $res=$formul->label.':'.$res;
                            // $out.= '<label>'.$res .'</label>';
                        }
                        else
                        {
                            $result=json_decode($group->result);
                            foreach($result as $res)
                            {
                                $check=array_map(function($item)use($historyResult)
                                {
                                    return in_array($item,$historyResult);
                                },$res->aids);                    
                                if(array_sum($check)==count($check))
                                {

                                    if($res->type=="text")
                                    {
                                        $out.= '<span>'.$res->result.' </span>';
                                    }
                                    else {
                                        if($res->type=="video")
                                        /*  array_push($videos,str_replace('/uploads','uploads',$answer->analysis));*/
                                        
                                        $out.="<div class='col-12 justify-content-center'>
                                        <video  controls style='width:100%;height: 10rem;'>
                                        <source src='".$res->result."'>
                                        Your browser does not support the video player.</video></div>";

                                        if($res->type=="audio")
                                            /*array_push($audios,str_replace('/uploads','uploads',$answer->analysis));*/
                                        
                                            $out.="<div class='col-12 justify-content-center'>
                                        <audio  controls style='width:100%;height: 10rem;'>
                                            <source src='".$res->result."'>
                                            Your browser does not support the audio player.</audio></div>";

                                        if($res->type=="image")
                                            $out.="<div class='col-12 justify-content-center'>
                                        <img  class='img-thumbnail ' src='".$res->result."'/></div>";

                                    }
                                    
                                $Show=1;
                                }
                                else
                                $Fail=1;                    
                            }
                            if($Fail && !$Show)
                            {
                                $default=json_decode($group->default)??[];
                                if($default)
                                { 
                                    if($default->type=="text")
                                    {
                                        $out.= '<span>'.$default->result.' </span>';
                                    }
                                    else {
                                        if($default->type=="video")
                                        /*  array_push($videos,str_replace('/uploads','uploads',$answer->analysis));*/
                                        
                                        $out.="<div class='col-12 justify-content-center'>
                                        <video  controls style='width:100%;height: 10rem;'>
                                        <source src='".$default->result."'>
                                        Your browser does not support the video player.</video></div>";

                                        if($default->type=="audio")
                                            /*array_push($audios,str_replace('/uploads','uploads',$answer->analysis));*/
                                        
                                            $out.="<div class='col-12 justify-content-center'>
                                        <audio  controls style='width:100%;height: 10rem;'>
                                            <source src='".$default->result."'>
                                            Your browser does not support the audio player.</audio></div>";

                                        if($default->type=="image")
                                            $out.="<div class='col-12 justify-content-center'>
                                        <img  class='img-thumbnail ' src='".$default->result."'/></div>";

                                    }
                                }
                                        
                            }    
                        $Fail=$Show=0;
                        }
                    }

                        /** combine **/
                        {
                            /*
                                if(count($audios))
                                {
                                    $name=auth()->user()->phone.'_exam_'.$id. '.mp3';
                                    FFMpeg::fromDisk('Exam')
                                    ->open($audios)
                                    ->export()
                                    ->concatWithoutTranscoding()
                                    ->inFormat(new \FFMpeg\Format\Audio\Mp3)
                                    ->save('/uploads/answers/tmp/'.$name);

                                    $out.="<p style='text-align: right;direction:rtl'>نتیجه آزمون خود را می توانید در قالب یک فایل صوتی بشنوید: </p>
                                    <div class='col-12 justify-content-center'>
                                        <audio  controls style='width:100%'>
                                            <source src='/uploads/answers/tmp/".$name."'>
                                        Your browser does not support the audio player.</audio></div>";
                                }
                                if(count($videos))
                                {
                                    $name=auth()->user()->phone.'_exam_'.$id. '.mp4';
                                    FFMpeg::fromDisk('Exam')
                                    ->open($videos)
                                    ->export()
                                    ->concatWithoutTranscoding()
                                    ->inFormat(new \FFMpeg\Format\Video\X264)                
                                    ->save('/uploads/answers/tmp/'.$name);

                                    $out.="<p  style='text-align: right;direction:rtl;'>نتیجه آزمون خود را می توانید در قالب یک ویدیو مشاهده نمایید: </p>
                                    <div class='col-12 justify-content-center'>
                                    <video  controls style='width:100%'>
                                    <source src='/uploads/answers/tmp/".$name."'>
                                    Your browser does not support the video player.</video></div>";
                                }
                            */
                        }
            }
            else
            {
                $data=$this->showConclusion_OLD($id);
               // return view('conclusions.show',["score"=>$data['score'],"exam"=>$data['exam'],"conclusion"=>$data['conclusion']]);
               if(isset($data['out']) )
               return view('conclusions.analysis',["exam_user_id"=>$id,'output'=>$data['out'],'is6'=>$is6]);
               else
               return view('conclusions.show',$data);
            }
        return view('conclusions.analysis',["exam_user_id"=>$id,'output'=>$out,'is6'=>$is6]);
    }
    public function showConclusion_2($id){
        
        $EUtbl=DB::table("exam_user")->find($id);
        DB::table("exam_user")->where('exam_id',$EUtbl->exam_id)
        ->where('user_id',$EUtbl->user_id)
        ->where('name',$EUtbl->name)
        ->update(['active'=>0]);
        DB::table("exam_user")->where('id',$id)->update(['active'=>1]);

        $Fail=$Show=0;
        $historyResult = DB::table('histories')->where("exam_user_id","=",$id)->pluck("answer_id")->toArray();
        $groups=group::where('exam_id',DB::table("exam_user")->find($id)->exam_id)->where('status',1)->orderBy('id')->get();
            $out='';$videos=[];$audios=[];$images=[];
             $answers=implode(',',$historyResult);
           foreach($groups as $group)
           {
                $result=json_decode($group->result);
                foreach($result as $res)
                {
                    
                        $aidres=implode(',',$res->aids);
                        $tmp=explode($aidres,$answers);
                        if(count($tmp)>1)
                        {
                        $answers=str_replace($aidres,'',$answers);

                            if($res->type=="text")
                            {
                                $out.= '<span>'.$res->result.' </span>';
                            }
                            else {
                                if($res->type=="video")
                                /*  array_push($videos,str_replace('/uploads','uploads',$answer->analysis));*/
                                
                                $out.="<div class='col-12 justify-content-center'>
                                <video  controls style='width:100%;height: 10rem;'>
                                <source src='".$res->result."'>
                                Your browser does not support the video player.</video></div>";

                                if($res->type=="audio")
                                    /*array_push($audios,str_replace('/uploads','uploads',$answer->analysis));*/
                                
                                    $out.="<div class='col-12 justify-content-center'>
                                <audio  controls style='width:100%;height: 10rem;'>
                                    <source src='".$res->result."'>
                                    Your browser does not support the audio player.</audio></div>";

                                if($res->type=="image")
                                    $out.="<div class='col-12 justify-content-center'>
                                <img  class='img-thumbnail ' src='".$res->result."'/></div>";

                            }
                            
                        $Show=1;
                        }
                        else
                        $Fail=1;

                    
                }
                if($Fail && !$Show)
                {
                            $default=json_decode($group->default);
                            if($default->type=="text")
                            {
                                $out.= '<span>'.$default->result.' </span>';
                            }
                            else {
                                if($default->type=="video")
                                /*  array_push($videos,str_replace('/uploads','uploads',$answer->analysis));*/
                                
                                $out.="<div class='col-12 justify-content-center'>
                                <video  controls style='width:100%;height: 10rem;'>
                                <source src='".$default->result."'>
                                Your browser does not support the video player.</video></div>";

                                if($default->type=="audio")
                                    /*array_push($audios,str_replace('/uploads','uploads',$answer->analysis));*/
                                
                                    $out.="<div class='col-12 justify-content-center'>
                                <audio  controls style='width:100%;height: 10rem;'>
                                    <source src='".$default->result."'>
                                    Your browser does not support the audio player.</audio></div>";

                                if($default->type=="image")
                                    $out.="<div class='col-12 justify-content-center'>
                                <img  class='img-thumbnail ' src='".$default->result."'/></div>";

                            }
                            
                }    
               $Fail=$Show=0;
            }
            /*
            if(count($audios))
            {
                $name=auth()->user()->phone.'_exam_'.$id. '.mp3';
                FFMpeg::fromDisk('Exam')
                ->open($audios)
                ->export()
                ->concatWithoutTranscoding()
                ->inFormat(new \FFMpeg\Format\Audio\Mp3)
                ->save('/uploads/answers/tmp/'.$name);

             $out.="<p style='text-align: right;direction:rtl'>نتیجه آزمون خود را می توانید در قالب یک فایل صوتی بشنوید: </p>
             <div class='col-12 justify-content-center'>
                   <audio  controls style='width:100%'>
                    <source src='/uploads/answers/tmp/".$name."'>
                    Your browser does not support the audio player.</audio></div>";
            }
            if(count($videos))
            {
                $name=auth()->user()->phone.'_exam_'.$id. '.mp4';
                FFMpeg::fromDisk('Exam')
                ->open($videos)
                ->export()
                ->concatWithoutTranscoding()
                ->inFormat(new \FFMpeg\Format\Video\X264)                
                ->save('/uploads/answers/tmp/'.$name);

                $out.="<p  style='text-align: right;direction:rtl;'>نتیجه آزمون خود را می توانید در قالب یک ویدیو مشاهده نمایید: </p>
                <div class='col-12 justify-content-center'>
                <video  controls style='width:100%'>
                <source src='/uploads/answers/tmp/".$name."'>
                Your browser does not support the video player.</video></div>";
            }*/
        return view('conclusions.analysis',["exam_user_id"=>$id,'output'=>$out]);
    }
    public function showConclusion_OLD($id){
        $EUtbl=DB::table("exam_user")->find($id);

       DB::table("exam_user")->where('exam_id',$EUtbl->exam_id)
        ->where('user_id',$EUtbl->user_id)
        ->where('name',$EUtbl->name)
        ->update(['active'=>0]);
        DB::table("exam_user")->where('id',$id)->update(['active'=>1]);

        $examtbl=Exam::find($EUtbl->exam_id);
        $out='';
        if($examtbl->formuls()->count())
        {
            $historyResult = DB::table('histories')->where("exam_user_id","=",$id)->pluck("answer_id")->toArray();
            
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
                
                if($conditation->count())
                    $out.='<br/><b class="collapsible">';
                else
                $out.='<br/><b class="none">';
                    if(!$formul->default)
                    {
                        $out.=$formul->label.': '.$res.'</b>';
                    }
                    else
                    $out.=$formul->default.'</b>';
                
                 foreach($conditation as $con)
                    {
                        $conditation_if=strtr($con->conditation,['{:RESULT}'=>$res]);
                        
                        if(!is_null($conditation_if))
                        {
                            $res2=eval("return $conditation_if;");
                            if($res2)
                            {
                                $out.='<div class="content"><p>'.strtr($con->then,['{:RESULT}'=>$res,'{:LABEL}'=>$formul->label,"\r\n"=>'<br/>',"</b>"=>'</b><br/>']).'</p></div>';
                            }
                        } 
                    }  
                /*foreach($conditation as $con)
                {
                    $conditation_if=strtr($con->if,['{:RESULT}'=>$res]);
                    
                    if(!is_null($conditation_if))
                    {
                        $res2=eval("return  $conditation_if;");
                        
                        if($res2)
                        {
                            $out.=strtr($con->then,['{:RESULT}'=>$res,'{:LABEL}'=>$formul->label,"\r\n"=>'<br/>']).'<br/>';
                        }
                    }
                    
                }*/
                //$conditation->if=strtr($conditation->if,['{:RESULT}'=>$res]);
              
                
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
                     $out=$defbody->body.'<div style="text-align: right;" dir="rtl">'.$out;               
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
                            $out.='<p>'.strtr($con->then,['{:RESULT}'=>$res,'{:LABEL}'=>$formul->label,"\r\n"=>'<br/>',"</b>"=>'</b><br/>']).'</p>';
                        }
                    } 
                }          
            }

            $out.='</div>';
            return ["out"=>$out];
        }
        else
        {
            $score = 0;
            $conclusion=[];
            $flag = false;
            $C=0;
            $I=0;
            $S=0;
            $D=0;

            $historyResult = DB::table('histories')->where("exam_user_id","=",$id)->get();
            foreach($historyResult as $value){
                if(Answer::find($value->answer_id)->is_char){
                    $flag=true;
                }
                break;
            }
            $exam = Exam::find(DB::table("exam_user")->find($id)->exam_id);
        $examc = Conclusion::where('exam_id',$exam->id)->get();
            if($flag){
                foreach($historyResult as $value){
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
                //$exam = Exam::find(DB::table("exam_user")->find($id)->exam_id);
                foreach($examc as $value){
                    $conclusion = $value;
                    break;
                }
                $score = "نا معلوم";
            }
            else{
                foreach($historyResult as $value){
                    $score = $score + Answer::find($value->answer_id)->value;
                }
                //$exam = Exam::find(DB::table("exam_user")->find($id)->exam_id);
                foreach($examc as $value){
                    if($score>$value->low && $score<$value->high){
                        $conclusion = $value;
                    }
                }
            }
            try {
                if(count($conclusion)==0)
        $conclusion=json_decode(json_encode(['description'=>"<p> امتیاز شما به نمره حداقل آزمون نرسیده است</p> "]));

            } catch (\Throwable $th) {
                //throw $th;
            }

            return ["score"=>$score,"exam"=>$exam,"conclusion"=>$conclusion];

        }
        //return view('conclusions.show',["score"=>$score,"exam"=>$exam,"conclusion"=>$conclusion]);
    }
    public function export($id){
        $examUser = new ExamUsers;
        $examUser->id = $id;
        return Excel::download($examUser, 'users.xlsx');
    }
    public function export_campaign($id,$campaign,$uid){
        $examUser = new ExamUsers;
       $examUser->id = $id;
       $examUser->campaign = $campaign;
       $examUser->uid=$uid;
        $filename='campaign-users-'.now().'.xlsx';
       return Excel::download($examUser, $filename);
   }
}
