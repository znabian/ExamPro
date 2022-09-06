<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\group;
use App\Models\group_question;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class GroupController extends Controller
{
    /**
     * Show the list for groups.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups=group::where('status','1')->paginate(10);
       return view('groups.index',compact('groups'));
    }
    
    /**
     * Show the create group form.
     *
     * @return \Illuminate\Http\Response
     */
    public function createView()
    {
        $edit=1;
        $groups=group::where('status','1')->get();
       return view('groups.create',compact('edit','groups'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $req)
    {  
        $this->validate($req,[
            'name'=>'required',
            'exam_id'=>'required',
        ]);
        $id=group::insertGetId(['name'=>$req->name,'parent'=>$req->gparent,
                'result'=>json_encode([]),
                'exam_id'=>$req->exam_id]);//'questions'=>json_encode([]),
        if($req->ajax)
        {
        $out="<option selected value='{$id}'>{$req->name}</option>";
        return ['id'=>$id,'data'=>$out];            
        }
        else
        {
            $group=group::find($id);
            if($req->res)
            {
                $this->validate($req,[
                'Analysis'=>'required',
                ]);
                
                $qc=new QuestionController();
                $res=$qc->uplaod($req,"Analysis",$req->type,'Group/'."g{$group->id}","g{$group->id}_DEFAULT");
                $def=['type'=>$req->type,'result'=>$res];
                $group->update(['default'=>json_encode($def)]);
                $group->save();
                session()->flash('msg','تحلیل پیش فرض با موفقیت ثبت شد');
    
            }
            if($req->qidset)
            {
                $this->validate($req,[
                'qids'=>'required',
                ]);
                foreach(explode(',',$req->qids) as $quiz)
                {
                $group->questions()->updateOrInsert(['question_id'=>$quiz,'group_id'=>$group->id],['updated_at'=>now()]);
                $group->save();
                }
                $group->questions()->whereNotIn('question_id',explode(',',$req->qids))->delete();
                session()->flash('msg','مجموعه سوالات با موفقیت ثبت شد');
    
            }
            
            
           return redirect(route('group.edit',[$id]))->with('type','success');
        }
    }
    
    /**
     * Show the form for edit the group.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(group $group)
    {
        $qids=group_question::all()->pluck('question_id');
        $questions=Question::where('exam_id',$group->exam_id)
        ->whereNotIn('id',$qids)
        ->get();
        $groups=group::where('status','1')->where('exam_id',$group->exam_id)->where('id','<>',$group->id)->get();
        $laws=json_decode($group->result)??[];
            try {
                if(count($laws))
                $laws=json_decode($group->result)??[];
            } catch (\Throwable $th) {  
                $res=[]; 
                foreach((array)$laws as $law) 
                array_push($res,$law);                 
                $group->result=json_encode($res);
                $group->save();
            }
       return view('groups.law',compact('group','groups','questions'));
    }
    
    
    /**
     * delete the group.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
       group::where('parent',$id)->update(['parent'=>null]);
         group::destroy($id);
        session()->flash('msg',"گروهبندی با موفقیت حذف شد");
        return redirect()->back()->with('type',"success");
    }
    /**
     * delete law from the group.
     *
     * @return \Illuminate\Http\Response
     */
    public function law_delete(group $group,$law)
    {
      $res=json_decode( $group->result);
        $del=array_column($res,'id');
        $index=array_search($law,$del);
        if($res[$index]->type!='text')
         unlink(public_path().$res[$index]->result);
       unset($res[$index]);
       $group->update(['result'=>(count($res))?json_encode($res):null]);
       $group->save();
       session()->flash('msg',"قوانین با موفقیت حذف شدند");
      return redirect()->back()->with('type',"success");
    }
    
    /**
     * edit law from the group.
     *
     * @return \Illuminate\Http\Response
     */
    public function law_edit(group $group,$law)
    {
      $res=json_decode( $group->result);
        $del=array_column($res,'id');
       $law=$res[array_search($law,$del)];  
       $questions=Question::where('exam_id',$group->exam_id)->get();
        $groups=group::where('status','1')->where('exam_id',$group->exam_id)->where('id','<>',$group->id)->get();
    
       return view('groups.law',compact('group','law','groups','questions'));
    }
    /**
     * update law of the group.
     *
     * @return \Illuminate\Http\Response
     */
    public function law_update(group $group,$law,Request $req)
    {
        $this->validate($req,[
            'Aids'=>'required',
            'AnswerAnalysis'=>'required',
        ]);
        $res=json_decode( $group->result);//dd(array_column($res,'aids'));
        $edit=array_column($res,'id');
       $law=array_search($law,$edit);

         $qc=new QuestionController();
         $result=$qc->uplaod($req,"AnswerAnalysis",$req->type,'Group/'."g{$group->id}","g{$group->id}_a".str_replace(',','_',implode(',',$req->Aids)));
         $res[$law]->aids=$req->Aids; 
         $res[$law]->label=explode(',',$req->lbls); 
        $res[$law]->result=$result;
        $res[$law]->type=$req->type;
        
        $group->update(['result'=>json_encode($res)]);
        $group->save();
        session()->flash('msg',"قوانین با موفقیت بروزرسانی شدند");
        return redirect(route('group.edit',[$group->id]))->with('type',"success");
    }
    /**
     * Show the form for edit the group.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(group $group,Request $req)
    {   // dd($req); 
        if($req->res)
        {
            $this->validate($req,[
            'AnswerAnalysis'=>'required',
            ]);
            
            $qc=new QuestionController();
            $res=$qc->uplaod($req,"AnswerAnalysis",$req->type,'Group/'."g{$group->id}","g{$group->id}_DEFAULT");
            $def=['type'=>$req->type,'result'=>$res];
            $group->update(['default'=>json_encode($def)]);
            $group->save();
            session()->flash('msg','تحلیل پیش فرض با موفقیت ثبت شد');

        }
        elseif($req->qidset)
        {
            $this->validate($req,[
            'qids'=>'required',
            ]);
            /*$group->update(['questions'=>json_encode(explode(',',$req->qids))]);
            $group->save();*/
           
            foreach(explode(',',$req->qids) as $quiz)
            {
            $group->questions()->updateOrInsert(['question_id'=>$quiz,'group_id'=>$group->id],['updated_at'=>now()]);
            $group->save();            
            }
            if($req->formular==1)
            {//dd($req);
                $formul=$req->Analysis;
                $ids=explode(',',trim($req->ids,','));
                 $ids=array_unique($ids); 
                 $conditation=['if'=>$req->conditation,'then'=>$req->result,'else'=>$req->resultelse];
                $lbl=['label'=>$req->lbl,'ids'=>json_encode($ids),'formul'=>$formul,'conditation'=>json_encode($conditation)];
                group::where('id',$group->id)->update(["formul"=>json_encode($lbl)]);
            }
            elseif($req->formular==0)
            {
                group::where('id',$group->id)->update(["formul"=>null]);
            }
            $group->questions()->whereNotIn('question_id',explode(',',$req->qids))->delete();
            session()->flash('msg','مجموعه سوالات با موفقیت ثبت شد');

        }
        elseif($req->setname)
        {
            $this->validate($req,[
            'name'=>'required',
            'exam_id'=>'required',
            ]);
            $group->update(['name'=>$req->name,'parent'=>$req->gparent,'exam_id'=>$req->exam_id]);
            $group->save();
            session()->flash('msg','اطلاعات گروه با موفقیت ثبت شد');

        }
        else
        {
            $this->validate($req,[
            'Aids'=>'required',
            'AnswerAnalysis'=>'required',
            ]);
            $oldres=json_decode( $group->result)??[];
            $last=(count($oldres))?last($oldres)->id:0;
            
            $qc=new QuestionController();
            $res=$qc->uplaod($req,"AnswerAnalysis",$req->type,'Group/'."g{$group->id}","g{$group->id}_a".str_replace(',','_',implode(',',$req->Aids)));
            $result=['id'=>($last)+1,'aids'=>$req->Aids,'label'=>explode(',',$req->lbls),'result'=>$res,'type'=>$req->type];
            array_push($oldres,$result);
            $group->update(['result'=>json_encode($oldres)]);
            $group->save();
            session()->flash('msg','قوانین جدید با موفقیت ثبت شدند');
            
        }
        
       return redirect()->back()->with('type','success');
    }

    public function lawanswershow()
    {
            $anwers=explode(',',request('list'))??[];$out='';
            $aid=request('aid');$lbl=request('label');
        if(!request('del'))
        {
            if(request('list'))
            {
                if(!in_array($lbl,$anwers))
                    array_push( $anwers,$lbl);
               
                    foreach($anwers as $anwer)
                    {
                        $out.='<span onclick="rmlist(\''.$anwer.'\')"  class="btn btn-info btn-sm m-2">'.$anwer.'<b class="p-2 fa fa-close">×</b></span>';
                    }
            }
            else
            {
                $out.='<span onclick="rmlist(\''.$lbl.'\')"  class="btn btn-info btn-sm m-2">'.$lbl.'<b class="p-2 fa fa-close">×</b></span>';
                $anwers[0]=$lbl; 
            }  
        }
        else
        {
            unset($anwers[array_search($lbl,$anwers)]);
            foreach($anwers as $anwer)
            {
                $out.='<span onclick="rmlist(\''.$anwer.'\')"  class="btn btn-info btn-sm m-2">'.$anwer.'<b class="p-2 fa fa-close">×</b></span>';
            }
        }
        return ['ids'=>implode(',',$anwers),'data'=>$out];
    }
    public function OLD_lawanswershow()
    {
            $anwers=explode(',',request('list'))??[];$out='';
            $aid=request('aid');
        if(!request('del'))
        {
            if(request('list'))
            {
                if(!in_array($aid,$anwers))
                    array_push( $anwers,$aid);
               
                    foreach($anwers as $anwer)
                    {
                    $a=Answer::find($anwer);
                        $out.='<span onclick="rmlist('.$aid.')" id="'.$aid.'" class="btn btn-info btn-sm m-2">'.$a->name.'<b class="p-2 fa fa-close">×</b></span>';
                    }
            }
            else
            {
                $a=Answer::find($aid);
                $out.='<span onclick="rmlist('.$aid.')" id="'.$aid.'" class="btn btn-info btn-sm m-2">'.$a->name.'<b class="p-2 fa fa-close">×</b></span>';
                $anwers=request('aid'); 
            }  
        }
        else
        {
            unset($anwers[array_search($aid,$anwers)]);
            foreach($anwers as $anwer)
            {
            $a=Answer::find($anwer);
                $out.='<span onclick="rmlist('.$aid.')" id="'.$aid.'" class="btn btn-info btn-sm m-2">'.$a->name.'<b class="p-2 fa fa-close">×</b></span>';
            }
        }
        return ['ids'=>$anwers,'data'=>$out];
    }
}
