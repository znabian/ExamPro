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
use App\Http\Controllers\Panel\PanelController;
use App\Models\exam_formular;
use App\Models\group;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
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
        $a=new PanelController();
        switch ($ExamUsers->exam_id)
         {
            case '4':
                $b=new Request(['sts'=>2]);
                break;
            case '6':
                $b=new Request(['sts'=>3]);
                break;
            case '9':
                $b=new Request(['sts'=>7]);
                break;
        }
        $a->changeStatus($b);
        if($exam->groups()->where('status',1)->count())
        return view("exams.show",["exam"=>$exam,'ExamUserid'=>$ExamUsers->id]);
        return view("exams.show_old",["exam"=>$exam,'ExamUserid'=>$ExamUsers->id]);
    }

    public function countMyAnswer($euid)
    {$keys=$a=[];
        $exam = DB::table('histories')->where('exam_user_id',$euid)->where('active',1)->count();
        //return $exam;
        if($exam>0)
        {
            $quiz=Exam::find(DB::table('exam_user')->find($euid)->exam_id)->questions()->pluck('id')->toArray();
            $a=array_diff($quiz,DB::table('histories')->where('exam_user_id',$euid)->where('active',1)->pluck('question_id')->toArray());
            foreach($a as $index)
            {
            $key=array_search($index,$quiz);
            if($key>=0)
                $keys[]=$key+1;
            }
        }
        return ['ans'=>$exam,'emt'=>implode(' و ',$keys),'qid'=>$a,'aid'=>DB::table('histories')->where('exam_user_id',$euid)->where('active',1)->pluck('answer_id')->toArray()];
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
        DB::table("histories")->where('exam_user_id',$id)->delete();
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
    public function showConclusion_New($id){
        $EUtbl=DB::table("exam_user")->find($id);
      
        DB::table("exam_user")->where('exam_id',$EUtbl->exam_id)
        ->where('user_id',$EUtbl->user_id)
        ->where('name',$EUtbl->name)->where('enable',1)
        ->update(['active'=>0]);
        DB::table("exam_user")->where('id',$id)->update(['active'=>1,'lang'=>App::getLocale()]);
        $a=new PanelController();
        switch ($EUtbl->exam_id)
        {
           case '4':
               $b=new Request(['sts'=>2]);
               break;
           case '6':
               $b=new Request(['sts'=>3]);
               break;
           case '9':
               $b=new Request(['sts'=>7]);
               break;
       }
        $a->changeStatus($b);
        return redirect(route('dashboard'));
    }
    public function showConclusion($id){
        $EUtbl=DB::table("exam_user")->find($id);
        $response = Http::post("http://185.116.161.39:8012/RedCastlePanel/public/api/Exam/addRequest",['Phone'=>auth()->user()->phone,"Description"=>"شرکت در استعدادیابی","Platform"=>26]);
        /*$count=$this->countMyAnswer($id);
        $ecount=Question::where('exam_id',$EUtbl->exam_id)->count();
        if($count==$ecount)
        DB::table("exam_user")->where('id',$id)->update(['active'=>1]);*/
        $is6=($EUtbl->exam_id==6 );//&& is_null(auth()->user()->gift)
        DB::table("exam_user")->where('exam_id',$EUtbl->exam_id)
        ->where('user_id',$EUtbl->user_id)
        ->where('name',$EUtbl->name)->where('enable',1)
        ->update(['active'=>0]);
        DB::table("exam_user")->where('id',$id)->update(['active'=>1]);

        $Fail=$Show=0;
        $historyResult = DB::table('histories')->where("exam_user_id","=",$id)->where('active',1)->pluck("answer_id")->toArray();
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
        ->where('name',$EUtbl->name)->where('enable',1)
        ->update(['active'=>0]);
        DB::table("exam_user")->where('id',$id)->update(['active'=>1]);

        $Fail=$Show=0;
        $historyResult = DB::table('histories')->where("exam_user_id","=",$id)->where('active',1)->pluck("answer_id")->toArray();
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
        ->where('name',$EUtbl->name)->where('enable',1)
        ->update(['active'=>0]);
        DB::table("exam_user")->where('id',$id)->update(['active'=>1]);

        $examtbl=Exam::find($EUtbl->exam_id);
        $out='';
        if($examtbl->formuls()->count())
        {
            $historyResult = DB::table('histories')->where("exam_user_id","=",$id)->where('active',1)->pluck("answer_id")->toArray();
            
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

            $historyResult = DB::table('histories')->where("exam_user_id","=",$id)->where('active',1)->get();
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
    public function showConclusion_Formular($id){
        $EUtbl=DB::table("exam_user")->find($id);

       DB::table("exam_user")->where('exam_id',$EUtbl->exam_id)
        ->where('user_id',$EUtbl->user_id)
        ->where('name',$EUtbl->name)->where('enable',1)
        ->update(['active'=>0]);
        DB::table("exam_user")->where('id',$id)->update(['active'=>1]);

        $examtbl=Exam::find($EUtbl->exam_id);
        $out='';
        if($examtbl->formuls()->count())
        {
            $historyResult = DB::table('histories')->where("exam_user_id","=",$id)->where('active',1)->pluck("answer_id")->toArray();
            
            foreach($examtbl->formuls()->where('type','1')->get() as $formul)
            {
                $ids=[];
                foreach(json_decode($formul->questions) as $quiz)
                    $ids[":$quiz"]=0;

                $answers=Answer::whereIn('question_id',(Array)json_decode($formul->questions))->whereIn('id',$historyResult)->get(); 
                foreach($answers as $ans)
                    $ids[":$ans->question_id"]=$ans->value;
                $formul->label=$formul->lang(App::getLocale())->first()->label??$formul->label;

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
                        $formul->label=strtr($formul->label,["\r\n"=>'<br>',"</b>"=>'',"<b>"=>'']);
                        $title=['tit'=>$formul->label.' : ','num'=>$res];
                    }
                    else
                    {
                         $formul->default=$formul->lang(App::getLocale())->first()->translate??$formul->default;
 
                        $formul->default=strtr($formul->default,["\r\n"=>'<br>',"</b>"=>'',"<b>"=>'']);
                        $title=explode(':',$formul->default);
                        $title=['tit'=>$title[0].' : ','num'=>$title[1]];
                    }
                    
                 foreach($conditation as $con)
                    {
                        $conditation_if=strtr($con->conditation,['{:RESULT}'=>$res]);
                        
                        if(!is_null($conditation_if))
                        {
                            $res2=eval("return $conditation_if;");
                            if($res2)
                            {
                                $con->then= $con->lang(App::getLocale())->first()->translate??$con->then;

                                $out=strtr($con->then,['{:RESULT}'=>$res,'{:LABEL}'=>$formul->label,"\r\n"=>'<br/>',"</b>"=>'</b><br/>']);
                                $descripts[]=["title"=>$title,"body"=>strtr($out,["\r\n"=>'<br>',"</b>"=>'',"<b>"=>''])];

                            }
                        }                         
                        
                    } 
                
            }
            
            $oprator=[":count"=>count($ids),":mode"=>"%",":%"=>"/100"];
            foreach($examtbl->formuls()->where('type','1')->get() as $fid)
            {
                $fid->label=$fid->lang(App::getLocale())->first()->label??$fid->label;

                $furmulids["{:RESULT-$fid->id}"]=$defaultResult[$fid->id];
                $furmulids["{:LABEL-$fid->id}"]=$fid->label;
                $furmulids2["RESULT"][]=$defaultResult[$fid->id];
                $furmulids2["LABEL"][]=$fid->label;
            }
            $default=$examtbl->conditation()->where('default',1)->first();  
            if($default) 
            {
                $default->body=$default->lang(App::getLocale())->first()->translate??$default->body;
                $default->body=strtr($default->body,$furmulids);
                $default->body=strtr($default->body,$oprator);
                //$item->body=strtr($item->body,["\r\n"=>'']); 
                $default=explode("\r\n",$default->body) ;
                foreach($default as $index=>$item)
                $data[]=['title'=>strtr(strtr(trim(explode(":",$item)[0]),['( از 100 )'=>'']),['(100)'=>'']),'num'=>trim(explode(":",$item)[1]),'img'=>'images/img'.($index+1).'.png'] ;        
           }
            foreach( $examtbl->formuls()->where('type','2')->get() as $formul)
            {
                $rep=strtr($formul->formul,$furmulids);
                $rep=strtr($rep,$oprator); 
                
                
                $rep=strtr($rep,$furmulids);

                $res=eval("return number_format($rep,2);");
                $conditation=exam_formular::find($formul->id)->conditations()->get();
               
                foreach($conditation as $con)
                {
                    $conditation_if=strtr($con->conditation,['{:RESULT}'=>$res,"\r\n"=>'<br/>']);
                    $conditation_if=strtr($conditation_if,$furmulids);
                    
                    if(!is_null($conditation_if))
                    {
                        $res2=eval("return $conditation_if;");
                        if($res2)
                        {
                            $con->then= $con->lang(App::getLocale())->first()->translate??$con->then;
                            
                            list($tit,$bod)=explode('</b>',$con->then);
                             $descripts[]=["title"=>['tit'=>strtr($tit,["\r\n"=>'<br>',"</b>"=>'',"<b>"=>'']),'num'=>''],"body"=>strtr($bod,["\r\n"=>'<br>',"</b>"=>'',"<b>"=>''])];
                           
                            
                        }
                    } 
                }  
                       
            }
            return ["descripts"=>json_encode($descripts),'data'=>json_encode($data),'work'=>json_encode($work??[])];
        }
        return ["descripts"=>[],'data'=>[],'work'=>[]];
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
   public function GetExamResult_1()
   {
    $talnet=DB::table("exam_user")->where('user_id',auth()->user()->id)->where('exam_id',4)->where('enable',1)->latest()->first();
    $exam=DB::table("exam_user")->where('user_id',auth()->user()->id)->where('exam_id',6)->where('enable',1)->latest()->first();
    if(!$talnet)
    return back()->with('error',__('messages.alert_wait.err'));
        
            $out='';$flag=false;$score='';
             if(!$talnet->score)
             {
             $historyResult = DB::table('histories')->where("exam_user_id","=",$talnet->id)->where('active',1)->get();
             foreach($historyResult as $value){
                 if(Answer::find($value->answer_id)->is_char){
                     $flag=true;
                 }
                 break;
             }
             $disc=['D'=>0,'I'=>0,'S'=>0,'C'=>0];
             if($flag){
                 foreach($historyResult as $value){
                     $char = Answer::find($value->answer_id)->char_value;
                     $char_value = Answer::find($value->answer_id)->value;
                     if($char=="I"){
                        $disc['I'] += $char_value;
                     }
                     if($char=="C"){
                        $disc['C']+=$char_value;
                     }
                     if($char=="S"){
                        $disc['S']+=$char_value;
                     }
                     if($char=="D"){
                        $disc['D']+=$char_value;
                     }
                 }
                    foreach($disc as $index=>$item)
                    {
                        $num=DB::table('talents')->where('type',$index)->where('number',$item)->first()->index;
                        if($num>=13 )
                        {
                        $scores[]=$num;  
                        $indexs[]=$index;  
                        }          
                        $all[$index]=$num;            
                    }
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
                DB::table("exam_user")->where('id',$talnet->id)->update(['score'=>json_encode(['disc'=>$disc,'score'=>$score])]);

            }
            }
            else
            {
                $score=json_decode($talnet->score);
                $score=$score->score;
            }
                $data=$this->showConclusion_Formular($exam->id);
               // return view('conclusions.show',["score"=>$data['score'],"exam"=>$data['exam'],"conclusion"=>$data['conclusion']]);
               if($score)
               $out=$data;
               else
               $out=[];

               $a=new PanelController();
               $b=new Request(['sts'=>4]);
               $a->changeStatus($b);
        return view('conclusions.result',compact("score",'out'));
   }
   public function GetExamResult($Eid)
   {
    
    $ExamUser=DB::table("exam_user")->where('user_id',auth()->user()->id)->where('exam_id',$Eid)->where('enable',1)->latest()->first();
    if(!$ExamUser)
    return back()->with('error',__('messages.alert_wait.err'));
    if(DB::table('histories')->where("exam_user_id","=",$ExamUser->id)->where('active',1)->count()<=5)
    return back()->with('error',__('messages.alert_wait.err'));
    switch ($ExamUser->exam_id) {
        case '4'://talent
            $flag=false;$score='';
            if(!$ExamUser->score)
            {
            $historyResult = DB::table('histories')->where("exam_user_id","=",$ExamUser->id)->where('active',1)->get();
            foreach($historyResult as $value){
                if(Answer::find($value->answer_id)->is_char){
                    $flag=true;
                }
                break;
            }
            $disc=['D'=>0,'I'=>0,'S'=>0,'C'=>0];
            if($flag){
                foreach($historyResult as $value){
                    $char = Answer::find($value->answer_id)->char_value;
                    $char_value = Answer::find($value->answer_id)->value;
                    if($char=="I"){
                       $disc['I'] += $char_value;
                    }
                    if($char=="C"){
                       $disc['C']+=$char_value;
                    }
                    if($char=="S"){
                       $disc['S']+=$char_value;
                    }
                    if($char=="D"){
                       $disc['D']+=$char_value;
                    }
                }
                   foreach($disc as $index=>$item)
                   {
                       $num=DB::table('talents')->where('type',$index)->where('number',$item)->first()->index;
                       if($num>=13 )
                       {
                       $scores[]=$num;  
                       $indexs[]=$index;  
                       }          
                       $all[$index]=$num;            
                   }
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
               DB::table("exam_user")->where('id',$ExamUser->id)->update(['score'=>json_encode(['disc'=>$disc,'score'=>$score])]);

           }
           }
           else
           {
               $score=json_decode($ExamUser->score);
               $score=$score->score;
           }
              
              $a=new PanelController();
              $b=new Request(['sts'=>4]);
              $a->changeStatus($b);
              return view('conclusions.result',compact("score"));
            break;
        case '6'://theen
            $out='';
            
               $data=$this->showConclusion_Formular($ExamUser->id);
              $out=$data;

              $a=new PanelController();
              $b=new Request(['sts'=>4]);
              $a->changeStatus($b);
       return view('conclusions.result',compact('out'));
            break;
        case '9'://holand
            $examtbl=Exam::find($ExamUser->exam_id);
            if($examtbl->formuls()->count())
            {
                $historyResult = DB::table('histories')->where("exam_user_id",$ExamUser->id)->where('active',1)->pluck("answer_id")->toArray();
               
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
                    $res=eval("return number_format($rep);");
                    $defaultResult[$formul->id]=$res;

                  $formul->label=$formul->lang(App::getLocale())->first()->label??$formul->label;
                  $formul->default=$formul->lang(App::getLocale())->first()->translate??$formul->default;

                    $conditation=exam_formular::find($formul->id)->conditations()->get();
                    //$conditation=(Array)json_decode($formul->conditation);
                    $formul->default=strtr($formul->default,['{:RESULT}'=>$res,'{:LABEL}'=>$formul->label]);
                    $out=strtr($formul->default,['{:RESULT}'=>$res,'{:LABEL}'=>$formul->label,"\r\n"=>'<br/>',"</b>"=>'</b><br/>']);
                    list($title,$body)=explode('{:BREAK}',$out);
                    $descripts[]=['num'=>$res,"title"=>$title,"body"=>strtr($body,["\r\n"=>'<br>',"</b>"=>'',"<b>"=>''])];

                        if(!$formul->default)
                        {
                            $formul->label=strtr($formul->label,["\r\n"=>'<br>',"</b>"=>'',"<b>"=>'']);
                            $title=['tit'=>$formul->label.' : ','num'=>$res];
                        }
                        else
                        {
                            $formul->default=strtr($formul->default,["\r\n"=>'<br>',"</b>"=>'',"<b>"=>'']);
                            $title=explode(':',$formul->default);
                            $title=['tit'=>$title[0].' : ','num'=>$title[1]];
                        }
                        
                     foreach($conditation as $con)
                        {
                            $conditation_if=strtr($con->conditation,['{:RESULT}'=>$res]);
                            
                            if(!is_null($conditation_if))
                            {
                                $res2=eval("return $conditation_if;");
                                if($res2)
                                {
                                    $con->then=$con->lang(App::getLocale())->first()->translate??$con->then;
                                    $out=strtr($con->then,['{:RESULT}'=>$res,'{:LABEL}'=>$formul->label,"\r\n"=>'<br/>',"</b>"=>'</b><br/>']);
                                    $descripts[]=["title"=>$title,"body"=>strtr($out,["\r\n"=>'<br>',"</b>"=>'',"<b>"=>''])];
    
                                }
                            }                         
                            
                        } 
                    
                }
                $oprator=[":count"=>count($ids),":mode"=>"%",":%"=>"/100"];
                foreach($examtbl->formuls()->where('type','1')->get() as $fid)
                {
                    $fid->label= $fid->lang(App::getLocale())->first()->label??$fid->label;

                    $furmulids["{:RESULT-$fid->id}"]=$defaultResult[$fid->id];
                    $furmulids["{:LABEL-$fid->id}"]=$fid->label;
                    $furmulids2["RESULT"][]=$defaultResult[$fid->id];
                    $furmulids2["LABEL"][]=$fid->label;
                }
                $labels=array_map(function($item){return strtr($item,['تیپ شخصیتی'=>'']);},$furmulids2["LABEL"]);
             //asort($furmulids2["RESULT"]);
                $sum=array_sum($furmulids2["RESULT"]);
                
             
                $default=$examtbl->conditation()->where('default',1)->first(); 
                if($default)  
                {
                    $default->body=$default->lang(App::getLocale())->first()->translate??$default->body;

                    $default->body=strtr($default->body,$furmulids);
                    $default->body=strtr($default->body,$oprator);
                    //$item->body=strtr($item->body,["\r\n"=>'']); 
                    $default=explode("\r\n",$default->body) ;
                    foreach($default as $index=>$item)
                    $data[]=['title'=>strtr(strtr(trim(explode(":",$item)[0]),['( از 100 )'=>'']),['(100)'=>'']),'num'=>trim(explode(":",$item)[1]),'img'=>'images/img'.($index+1).'.png'] ;        
                }
                foreach( $examtbl->formuls()->where('type','2')->get() as $formul)
                {
                    $rep=strtr($formul->formul,$furmulids);
                    $rep=strtr($rep,$oprator); 
                    
                    
                    $rep=strtr($rep,$furmulids);
    
                    $res=eval("return number_format($rep,2);");
                    $conditation=exam_formular::find($formul->id)->conditations()->get();
                   
                    foreach($conditation as $con)
                    {
                        $conditation_if=strtr($con->conditation,['{:RESULT}'=>$res,"\r\n"=>'<br/>']);
                        $conditation_if=strtr($conditation_if,$furmulids);
                        
                        if(!is_null($conditation_if))
                        {
                            $res2=eval("return $conditation_if;");
                            if($res2)
                            {
                                $con->then=$con->lang(App::getLocale())->first()->translate??$con->then;
                                list($tit,$bod)=explode('</b>',$con->then);
                                 $descripts[]=["title"=>['tit'=>strtr($tit,["\r\n"=>'<br>',"</b>"=>'',"<b>"=>'']),'num'=>''],"body"=>strtr($bod,["\r\n"=>'<br>',"</b>"=>'',"<b>"=>''])];
                               
                                
                            }
                        } 
                    }  
                           
                }
                usort($descripts, function($a, $b)use($sum){
                    $a = intdiv($a['num']*100,$sum);
                    $b = intdiv($b['num']*100,$sum);
                
                    if ($a == $b) {
                        return 0;
                    }
                    return ($a > $b) ? -1 : 1;
                });
                $a=new PanelController();
                $b=new Request(['sts'=>4]);
                $a->changeStatus($b);
               return view('conclusions.analysis_Holand',compact('descripts','sum','labels','furmulids2'));
                
            }
            break;
        
        default:
            # code...
            break;
    }
        
            
   }
   public function GetLastExamResult()
   {
    
    $ExamUser=DB::table("exam_user")->where('user_id',auth()->user()->id)->where('active',1)->where('enable',1)->latest()->first();
    if(!$ExamUser)
    return back()->with('error',__('messages.alert_wait.err'));
    if(DB::table('histories')->where("exam_user_id","=",$ExamUser->id)->where('active',1)->count()<=5)
    return back()->with('error',__('messages.alert_wait.err'));
    
    switch ($ExamUser->exam_id) {
        case '4'://talent
            $flag=false;$score='';
            if(!$ExamUser->score)
            {
            $historyResult = DB::table('histories')->where("exam_user_id","=",$ExamUser->id)->where('active',1)->get();
            foreach($historyResult as $value){
                if(Answer::find($value->answer_id)->is_char){
                    $flag=true;
                }
                break;
            }
            $disc=['D'=>0,'I'=>0,'S'=>0,'C'=>0];
            if($flag){
                foreach($historyResult as $value){
                    $char = Answer::find($value->answer_id)->char_value;
                    $char_value = Answer::find($value->answer_id)->value;
                    if($char=="I"){
                       $disc['I'] += $char_value;
                    }
                    if($char=="C"){
                       $disc['C']+=$char_value;
                    }
                    if($char=="S"){
                       $disc['S']+=$char_value;
                    }
                    if($char=="D"){
                       $disc['D']+=$char_value;
                    }
                }
                   foreach($disc as $index=>$item)
                   {
                       $num=DB::table('talents')->where('type',$index)->where('number',$item)->first()->index;
                       if($num>=13 )
                       {
                       $scores[]=$num;  
                       $indexs[]=$index;  
                       }          
                       $all[$index]=$num;            
                   }
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
               DB::table("exam_user")->where('id',$ExamUser->id)->update(['score'=>json_encode(['disc'=>$disc,'score'=>$score])]);

           }
           }
           else
           {
               $score=json_decode($ExamUser->score);
               $score=$score->score;
           }
              
              $a=new PanelController();
              $b=new Request(['sts'=>4]);
              $a->changeStatus($b);
              return view('conclusions.result',compact("score"));
            break;
        case '6'://theen
            $out='';
            
               $data=$this->showConclusion_Formular($ExamUser->id);
              $out=$data;

              $a=new PanelController();
              $b=new Request(['sts'=>4]);
              $a->changeStatus($b);
       return view('conclusions.result',compact('out'));
            break;
        case '9'://holand
            $examtbl=Exam::find($ExamUser->exam_id);
            if($examtbl->formuls()->count())
            {
                $historyResult = DB::table('histories')->where("exam_user_id",$ExamUser->id)->where('active',1)->pluck("answer_id")->toArray();
               
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
                    $res=eval("return number_format($rep);");
                    $defaultResult[$formul->id]=$res;

                  $formul->label=$formul->lang(App::getLocale())->first()->label??$formul->label;
                  $formul->default=$formul->lang(App::getLocale())->first()->translate??$formul->default;

                    $conditation=exam_formular::find($formul->id)->conditations()->get();
                    //$conditation=(Array)json_decode($formul->conditation);
                    $formul->default=strtr($formul->default,['{:RESULT}'=>$res,'{:LABEL}'=>$formul->label]);
                    $out=strtr($formul->default,['{:RESULT}'=>$res,'{:LABEL}'=>$formul->label,"\r\n"=>'<br/>',"</b>"=>'</b><br/>']);
                    list($title,$body)=explode('{:BREAK}',$out);
                    $descripts[]=['num'=>$res,"title"=>$title,"body"=>strtr($body,["\r\n"=>'<br>',"</b>"=>'',"<b>"=>''])];

                        if(!$formul->default)
                        {
                            $formul->label=strtr($formul->label,["\r\n"=>'<br>',"</b>"=>'',"<b>"=>'']);
                            $title=['tit'=>$formul->label.' : ','num'=>$res];
                        }
                        else
                        {
                            $formul->default=strtr($formul->default,["\r\n"=>'<br>',"</b>"=>'',"<b>"=>'']);
                            $title=explode(':',$formul->default);
                            $title=['tit'=>$title[0].' : ','num'=>$title[1]];
                        }
                        
                     foreach($conditation as $con)
                        {
                            $conditation_if=strtr($con->conditation,['{:RESULT}'=>$res]);
                            
                            if(!is_null($conditation_if))
                            {
                                $res2=eval("return $conditation_if;");
                                if($res2)
                                {
                                    $con->then=$con->lang(App::getLocale())->first()->translate??$con->then;
                                    $out=strtr($con->then,['{:RESULT}'=>$res,'{:LABEL}'=>$formul->label,"\r\n"=>'<br/>',"</b>"=>'</b><br/>']);
                                    $descripts[]=["title"=>$title,"body"=>strtr($out,["\r\n"=>'<br>',"</b>"=>'',"<b>"=>''])];
    
                                }
                            }                         
                            
                        } 
                    
                }
                $oprator=[":count"=>count($ids),":mode"=>"%",":%"=>"/100"];
                foreach($examtbl->formuls()->where('type','1')->get() as $fid)
                {
                    $fid->label= $fid->lang(App::getLocale())->first()->label??$fid->label;

                    $furmulids["{:RESULT-$fid->id}"]=$defaultResult[$fid->id];
                    $furmulids["{:LABEL-$fid->id}"]=$fid->label;
                    $furmulids2["RESULT"][]=$defaultResult[$fid->id];
                    $furmulids2["LABEL"][]=$fid->label;
                }
                $labels=array_map(function($item){return strtr($item,['تیپ شخصیتی'=>'']);},$furmulids2["LABEL"]);
             //asort($furmulids2["RESULT"]);
                $sum=array_sum($furmulids2["RESULT"]);
                
             
                $default=$examtbl->conditation()->where('default',1)->first(); 
                if($default)  
                {
                    $default->body=$default->lang(App::getLocale())->first()->translate??$default->body;

                    $default->body=strtr($default->body,$furmulids);
                    $default->body=strtr($default->body,$oprator);
                    //$item->body=strtr($item->body,["\r\n"=>'']); 
                    $default=explode("\r\n",$default->body) ;
                    foreach($default as $index=>$item)
                    $data[]=['title'=>strtr(strtr(trim(explode(":",$item)[0]),['( از 100 )'=>'']),['(100)'=>'']),'num'=>trim(explode(":",$item)[1]),'img'=>'images/img'.($index+1).'.png'] ;        
                }
                foreach( $examtbl->formuls()->where('type','2')->get() as $formul)
                {
                    $rep=strtr($formul->formul,$furmulids);
                    $rep=strtr($rep,$oprator); 
                    
                    
                    $rep=strtr($rep,$furmulids);
    
                    $res=eval("return number_format($rep,2);");
                    $conditation=exam_formular::find($formul->id)->conditations()->get();
                   
                    foreach($conditation as $con)
                    {
                        $conditation_if=strtr($con->conditation,['{:RESULT}'=>$res,"\r\n"=>'<br/>']);
                        $conditation_if=strtr($conditation_if,$furmulids);
                        
                        if(!is_null($conditation_if))
                        {
                            $res2=eval("return $conditation_if;");
                            if($res2)
                            {
                                $con->then=$con->lang(App::getLocale())->first()->translate??$con->then;
                                list($tit,$bod)=explode('</b>',$con->then);
                                 $descripts[]=["title"=>['tit'=>strtr($tit,["\r\n"=>'<br>',"</b>"=>'',"<b>"=>'']),'num'=>''],"body"=>strtr($bod,["\r\n"=>'<br>',"</b>"=>'',"<b>"=>''])];
                               
                                
                            }
                        } 
                    }  
                           
                }
                usort($descripts, function($a, $b)use($sum){
                    $a = intdiv($a['num']*100,$sum);
                    $b = intdiv($b['num']*100,$sum);
                
                    if ($a == $b) {
                        return 0;
                    }
                    return ($a > $b) ? -1 : 1;
                });
                $a=new PanelController();
                $b=new Request(['sts'=>4]);
                $a->changeStatus($b);
               return view('conclusions.analysis_Holand',compact('descripts','sum','labels','furmulids2'));
                
            }
            break;
        
        default:
            # code...
            break;
    }
        
            
   }
}
