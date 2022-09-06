<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Models\Question;
use App\Models\Answer;
use App\Models\group;
use App\Models\group_question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::paginate();
        return view('questions.index',["questions"=>$questions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request,$id)
    {
        return view('questions.create',["azmonId"=>$id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreQuestionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'question'=>'required_if:type,==,text',
            'groupid'=>'required',
            ]);
        $is_char = false;
        if($request->is_char){
            $is_char = true;
        }
        $questionResult = Question::create([
            "name"=>$request->question,
            'exam_id'=>$request->azmonId
        ]);
        $group=group::find($request->groupid);
       /* $quiz=json_decode($group->questions)??[];
       if(!in_array($questionResult->id,$quiz))
       {
            array_push($quiz,$questionResult->id);
            $group->questions()->update(['questions'=>json_encode($quiz)]);
            $group->save();
       }*/
       
       $group->questions()->updateOrInsert(['question_id'=>$questionResult->id,'group_id'=>$group->id],['updated_at'=>now()]);
       $group->save();
       
        if($questionResult){
           
                $link=$this->uplaod($request,'AnswerAnalysis',$request->type,'Questions/'."q{$questionResult->id}","q{$questionResult->id}"); 
                $questionResult->update([
                    "type"=>$request->type,'link'=>$link
                ]);
           
            $num=['first','second','third','forth','fifth','sixth','seventh'];
            foreach($num as $fild)
            {
                if($request->get($fild.'Answer')!= null || $request->get($fild.'type')!="text"){
                  $answer=  Answer::create([
                        "name"=>$request->get($fild.'Answer'),
                        "value"=>$request->get($fild.'AnswerValue')??1,
                        "question_id"=>$questionResult->id,
                        "char_value"=>$request->get($fild.'AnswerChar'),
                        // "is_char"=>$request->is_char
                        "is_char"=>$is_char ]);
                       
                                $link=$this->uplaod($request,$fild.'AnswerAnalysis',$request->get($fild.'type'),'Answers/'."q{$questionResult->id}","q{$questionResult->id}_a{$answer->id}"); 
                                $answer->update([
                                    "type"=>$request->get($fild.'type'),'link'=>$link
                                ]);
                                $answer->save();
                            
                /* $analysis=$this->uplaod($request,$questionResult->id,$fild,$answer->id);       
                   $answer->update([ "type" =>$request->get($fild.'AnswerType'),
                        "analysis"=>$analysis
                    ]);
                    $answer->save();*/
                }

            }
           /* if($request->firstAnswer != null){
                
              $answer=  Answer::create([
                    "name"=>$request->firstAnswer,
                    "value"=>$request->firstAnswerValue,
                    "question_id"=>$questionResult->id,
                    "char_value"=>$request->firstAnswerChar,
                    // "is_char"=>$request->is_char
                    "is_char"=>$is_char ]);
             $analysis=$this->uplaod($request,$questionResult->id,'firstAnswerAnalysis',$answer->id);       
               $answer->update([ "type" =>$request->type,
                    "analysis"=>$analysis
                ]);
                $answer->save();
            }
            if($request->secondAnswer != null){
                Answer::create([
                    "name"=>$request->secondAnswer,
                    "value"=>$request->secondAnswerValue,
                    "question_id"=>$questionResult->id,
                    "char_value"=>$request->secondAnswerChar,
                    "is_char"=>$is_char
                ]);
            }
            if($request->thirdAnswer != null){
                Answer::create([
                    "name"=>$request->thirdAnswer,
                    "value"=>$request->thirdAnswerValue,
                    "question_id"=>$questionResult->id,
                    "char_value"=>$request->thirdAnswerChar,
                    "is_char"=>$is_char
                ]);
            }
            if($request->forthAnswer != null){
                Answer::create([
                    "name"=>$request->forthAnswer,
                    "value"=>$request->forthAnswerValue,
                    "question_id"=>$questionResult->id,
                    "char_value"=>$request->forthAnswerChar,
                    "is_char"=>$is_char
                ]);
            }
            if($request->fifthAnswer != null){
                Answer::create([
                    "name"=>$request->fifthAnswer,
                    "value"=>$request->fifthAnswerValue,
                    "question_id"=>$questionResult->id,
                    "char_value"=>$request->fifthAnswerChar,
                    "is_char"=>$is_char
                ]);
            }
            if($request->sixthAnswer != null){
                Answer::create([
                    "name"=>$request->sixthAnswer,
                    "value"=>$request->sixthAnswerValue,
                    "question_id"=>$questionResult->id,
                    "char_value"=>$request->sixthAnswerChar,
                    "is_char"=>$is_char
                ]);
            }
            if($request->seventhAnswer != null){
                Answer::create([
                    "name"=>$request->seventhAnswer,
                    "value"=>$request->seventhAnswerValue,
                    "question_id"=>$questionResult->id,
                    "char_value"=>$request->seventhAnswerChar,
                    "is_char"=>$is_char
                ]);
            }*/
        }
        return redirect(route('group.edit',[$request->groupid]));
    }

    public function OLD_uplaod(Request $request,$qid,$fname,$aid)
    {
        $path=public_path('uploads/answers');                 
       
       if($request->type!="text")
       {   
                if($request->hasFile($fname.'AnswerAnalysis'))
                { 
                    $file=$request->file($fname.'AnswerAnalysis');

                    if(!is_dir($path))
                    {
                        Storage::makeDirectory($path);
                    } 
                        $fileName='q'.$qid.'_a'.$aid.".{$file->extension()}"; //{$ex[count($ex)-1]}";//$file->getClientOriginalName();
                    $file->move($path,$fileName);              
                    $analysis='/uploads/answers/'.$fileName;
                }
                else
                $analysis=$request->get($fname.'AnswerAnalysis');

           
       }
       else
       {
            $analysis=$request->get($fname.'AnswerAnalysis');
       }
       return $analysis;
    }
    public function uplaod(Request $request,$fname,$type,$folder,$fileName)
    {
        $path=public_path('uploads/'.$folder);                 
       
       if($type!="text")
       {   
                if($request->hasFile($fname))
                { 
                    $file=$request->file($fname);

                    if(!is_dir($path))
                    {
                        Storage::makeDirectory($path);
                    } 
                        $fileName.=".".$file->extension(); //{$ex[count($ex)-1]}";//$file->getClientOriginalName();
                    $file->move($path,$fileName);              
                    $analysis="/uploads/{$folder}/".$fileName;
                }
                else
                $analysis=$request->get($fname);

           
       }
       else
       {
            $analysis=$request->get($fname);
       }
       return $analysis;
    }
    public function Ajaxuplaod(Request $request)
    {              
        dd($request);
        $path=public_path('uploads/answers');   
            $fname=$request->fname;
            $qid=(Question::all()->max('id'))+1;
            $aid='tmp_'.$fname;
            $file=$request->file($fname.'AnswerAnalysis');

            if(!is_dir($path))
            {
               Storage::makeDirectory($path);
            } 
             $fileName='q'.$qid.'_a'.$aid.".{$file->extension()}"; //{$ex[count($ex)-1]}";//$file->getClientOriginalName();
            $res=$file->move($path,$fileName);              
            $analysis='/uploads/answers/'.$fileName;
            return response()->json(['status'=>$res,'data'=>$analysis]);
        
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = Question::find($id);
        $answers = Question::find($id)->answers;
        return view("questions.edit",["question" => $question,"answers" => $answers]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateQuestionRequest  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {            
        $link=$this->uplaod($request,'AnswerAnalysis',$request->type,'Questions/'."q{$id}","q{$id}"); 

        DB::table("questions")->where("id","=",$id)->update([
            "name"=>$request->question, 
             "type"=>$request->type,'link'=>$link
        ]);
        $group=group::find($request->gid);
        $quiz=json_decode( $group->questions)??[];
           if(!in_array($id,$quiz))
           {
            array_push($quiz,$id);
            $group->update(['questions'=>json_encode($quiz)]);
            $group->save();
           }
            
        return redirect()->route('question.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        //
    }
    public function getExamsQuestions()
    {
        $id=request('examid');$qid=request('qid');
        if($id)
        {
        $qids=group_question::all()->pluck('question_id');
        $questions = Question::where('exam_id',$id)
        ->whereNotIn('id',$qids)
        ->get();

        $groups = group::where('exam_id',$id)->get();
        if($questions->count())
         $out=' <option value="" disabled selected >انتخاب کنید </option>';
        else
         $out=' <option value="" disabled selected >تمامی سوالات این آزمون گروه بندی شدند </option>';

        foreach ($questions as $quiz)
            $out.='<option value="'.$quiz->id.'">'.$quiz->name.'</option>';
            if($groups->count())
            $gp='<option value="">یک گروه انتخاب کنید </option>';
            else
            $gp='<option value="" selected disabled>گروهی برای این آزمون وجود ندارد </option>';
         foreach ($groups as $group)
            $gp.='<option value="'.$group->id.'">'.$group->name.'</option>' ;
         return ['quiz'=>$out,'group'=>$gp];
        }
        if($qid)
        {
            $list=explode(',',request('list'))??[];$out='';
            
        if(!request('del'))
        {
            if(request('list'))
            {
                if(!in_array($qid,$list))
                    array_push( $list,$qid);
               
                    foreach($list as $item)
                    {
                        $out.='<span onclick="setquestion(\''.$item.'\',1)"  class="btn btn-info btn-sm m-2">'.$item.'.'.Question::find($item)->name.'<b class="p-2 fa fa-close">×</b></span>';
                    }
            }
            else
            {
                $out.='<span onclick="setquestion(\''.$qid.'\',1)"  class="btn btn-info btn-sm m-2">'.$qid.'.'.Question::find($qid)->name.'<b class="p-2 fa fa-close">×</b></span>';
                $list[0]=$qid; 
            }  
        }
        else
        {
            $index=array_search($qid,$list);
            unset($list[$index]);
            foreach($list as $item)
            {
                $out.='<span onclick="setquestion(\''.$item.'\',1)"  class="btn btn-info btn-sm m-2">'.$item.'.'.Question::find($item)->name.'<b class="p-2 fa fa-close">×</b></span>';
            }
        }
        return ['ids'=>implode(',',$list),'data'=>$out];
        }
    }
}
