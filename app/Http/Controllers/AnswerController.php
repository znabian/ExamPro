<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnswerRequest;
use App\Http\Requests\UpdateAnswerRequest;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $answers = Answer::paginate(10);
        return view('answers.index',["answers"=>$answers]);
    }
    /**
     * Display answers of the question.
     *
     * @return \Illuminate\Http\Response
     */
    public function getQuestionAsnwers()
    {
        $id=request('id');
        $answers = Answer::where('question_id',$id)->get();
        $out=' <option value="">یک پاسخ انتخاب کنید </option>';
        foreach ($answers as $answer)
            $out.='<option value="'.$answer->id.'">'.$answer->name.'</option>';
        return $out;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAnswerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAnswerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function show(Answer $answer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $answer = Answer::find($id);
        return view('answers.edit',["answer"=>$answer]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateAnswer(Request $request,$id)
    { 
        $qc=new QuestionController();
        $qid=Answer::find($id)->question_id;
         $link=$qc->uplaod($request,"AnswerAnalysis",$request->type,'Answers/'."q{$qid}","q{$qid}_a{$id}"); 
        DB::table("answers")->where("id","=",$id)->update([
            "name" => $request->name,
            "value" => $request->value,
            "type" =>$request->type,
            "link"=>$link
        ]);
        return redirect()->back();
    }
    /**
     * Uplaod files
     *
     * @param  \App\Models\Answer  $answer
     * @param  \Illuminate\Http\Request  $request
     * @return string $analysis
     */
    public function uplaod(Answer $answer,Request $request)
    {
        $path=public_path('uploads/answers');
        $oldtype=$answer->type;
        $oldfile=$answer->analysis??null;

       if($request->type!="text")
       {            
           if($request->hasFile('analysis'))
           { 
                $qid=$answer->question_id;
               $file=$request->file('analysis');

               if(!is_dir($path))
               {
                  Storage::makeDirectory($path);
               }
               else 
               {
                   if($oldtype!="text" && $oldfile && file_exists(public_path().$oldfile))
                       unlink(public_path().$oldfile);
               } 
                $ex=explode('.',$file->getClientOriginalName());
               $fileName='q'.$qid.'_a'.$answer->id.".{$file->extension()}"; //{$ex[count($ex)-1]}";//$file->getClientOriginalName();
               $file->move($path,$fileName);              
               $analysis='/uploads/answers/'.$fileName;
           }
           else
           $analysis=$request->analysis;
       }
       else
       {
            if(is_dir($path))
            {
                  /* $filesys = new Filesystem; 
                  $filesys->cleanDirectory($path); 
                   rmdir($path); 
                   rmdir(str_replace('/a'.$id,'',$path)); */
                   if($oldtype!="text" && $oldfile && file_exists(public_path().$oldfile))
                       unlink(public_path().$oldfile);
            }
            $analysis=$request->analysis;
       }
       return $analysis;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Answer $answer)
    {
        //
    }
}
