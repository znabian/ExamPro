<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\exam_formular;
use App\Models\FormularConditation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FormularController extends Controller
{
    public function index(Exam $exam)
    {
       /* foreach($exam->formuls()->whereNotNull('questions')->get() as $formul)
        {
            foreach((Array)json_decode($formul->conditation) as $con)
            DB::table('formular_conditations')->insert(['conditation'=>$con->if,'then'=>$con->then,'formular_id'=>$formul->id]);
        }*/
        $show='list';
        return view("exams.formular.formular",compact("exam","show"));
    }
    public function new(Exam $exam)
    {
        $show='set';
        return view("exams.formular.formular",compact("exam","show"));
    }
    public function show(exam $exam ,exam_formular $formul)
    {
        if($formul->type==1)
        $show='edit';
        else
        $show='resformular';
        return view("exams.formular.formular",compact("exam","formul","show"));
    }
    public function delete(exam_formular $formul)
    {
        exam_formular::destroy($formul->id);
        return back();
    }
    public function create(Exam $exam,Request $req)
    {
            try {
            $test=strtr($req->Analysis,['{:RESULT}'=>10,'{:RESULT-'=>'','{:mode}'=>'%','{:'=>'','}'=>'']);
                $a=eval("return $test ;");
        } catch (\Throwable $th) {
            session()->flash('err','فرمول  واردشده اشتباه است');
           return back()->withInput();
        }
        if($req->type=="ins")
        {                            
            $ids=explode(',',trim($req->ids,','));
                 $ids=array_unique($ids); 
                 
                 $conditation=explode(',',trim($req->cid,','));
                 $conditation=array_unique($conditation); 

                /* $conditation=explode('},',trim($req->FC,','));
                $conditation=array_unique($conditation); 
                foreach( $conditation as $index=>$con)
                $conditation[$index]=trim($con,',');
                $conditation='['.implode('},',$conditation).']';*/


                 $data['exam_id']=$exam->id;
                 $data['label']=$req->lbl;
                 $data['questions']=json_encode($ids);
                 $data['formul']=$req->Analysis;
                 //$data['conditation']=$conditation;
                 $data['default']=$req->default;
                $formul=DB::table('exam_formulars')->insertGetId($data);

                DB::table('formular_conditations')->whereIn('id',$conditation)->update(['formular_id'=>$formul]);
                session()->flash('msg','فرمول سوالات با موفقیت ثبت شد');
                return redirect(route('formular.index',[$exam->id]));
            
        }
        elseif($req->type=="def")
        {
                DB::table('formular_conditations')->updateOrInsert(
                    ['exam_id'=>$exam->id,'default'=>1],['body'=>$req->body]);
                session()->flash('msg','اطلاعات پیش فرض با موفقیت ثبت شد');
                return redirect(route('formular.index',[$exam->id]));
        }
        elseif($req->type=="res")
        {
            $ids=explode(',',trim($req->cid,','));
                 $ids=array_unique($ids); 

            
                 $data['exam_id']=$exam->id;
                 $data['label']=$req->lbl;
                 $data['type']=2;
                 $data['questions']=null;
                 $data['formul']=$req->Analysis;
                 //$data['conditation']=$conditation;
                 //$data['default']=$req->default;
                $formul=DB::table('exam_formulars')->insertGetId($data);
                DB::table('formular_conditations')->whereIn('id',$ids)->update(['formular_id'=>$formul]);
                
                session()->flash('msg','فرمول نتایج با موفقیت ثبت شد');
                return redirect(route('formular.index',[$exam->id]));
        }
                
           
    }
    public function update(exam_formular $formul,Request $req)
    {
        try {
            $test=strtr($req->Analysis,['{:RESULT}'=>10,'{:RESULT-'=>'','{:mode}'=>'%','{:'=>'','}'=>'']);
                $a=eval("return $test ;");
        } catch (\Throwable $th) {
            session()->flash('err','فرمول  واردشده اشتباه است');
           return back()->withInput();
        }
        if($req->type=="res")
        {
                 $data['label']=$req->lbl;
                 $data['formul']=$req->Analysis;
                 
                DB::table('exam_formulars')->where('id',$formul->id)->update($data);
                session()->flash('msg','فرمول نتایج با موفقیت ویرایش شد');
                return redirect(route('formular.index',[$formul->exam_id]));
        }
        else
        {
            $ids=explode(',',trim($req->ids,','));
            $ids=array_unique($ids); 
            
            $conditation=explode('},',trim($req->FC,','));
            $conditation=array_unique($conditation); 
            foreach( $conditation as $index=>$con)
            $conditation[$index]=trim($con,',');
            $conditation='['.implode('},',$conditation).']';
            
            //$conditation=['if'=>$req->conditation,'then'=>$req->result,'else'=>$req->resultelse];
        

            $data['label']=$req->lbl;
            $data['questions']=json_encode($ids);
            $data['formul']=$req->Analysis;
            $data['conditation']=$conditation;
            $data['default']=$req->default;
        DB::table('exam_formulars')->where('id',$formul->id)->update($data);
        session()->flash('msg','فرمول سوالات با موفقیت ویرایش شد');
        return redirect(route('formular.index',[$formul->exam_id]));
        }
    }
}
