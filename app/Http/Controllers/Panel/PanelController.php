<?php

namespace App\Http\Controllers\Panel;

use App\Exports\ExamUsers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Exam;
use App\Models\Tag;
use Illuminate\Support\Facades\Http;

class PanelController extends Controller
{
    public function correctDB()
    {$hids=[];
         $examusers=DB::table('exam_user')
         //->where('active',1)
         ->groupBy('user_id','exam_id')
         ->select('user_id','exam_id')
         ->get();
          
        //$histories=DB::table('histories')->get();
            foreach($examusers as $examuser)
            {
                $examusers2=DB::table('exam_user')                    
                    ->where('exam_id',$examuser->exam_id)
                    ->where('user_id',$examuser->user_id)
                        ->select('id','created_at')
                        ->orderByDesc('created_at')
                        ->get();                       
                      
                            DB::table('histories')
                            ->where('exam_id',$examuser->exam_id)
                            ->where('user_id',$examuser->user_id)
                            ->update([ "exam_user_id"=>$examusers2->first()->id]);

                            DB::table('exam_user')                    
                            ->whereIn('id',$examusers2->pluck('id'))
                            //->where('user_id',$examuser->user_id)
                                ->update([ "active"=>0]); 
                           DB::table('exam_user')                    
                                ->where('id',$examusers2->first()->id)
                                    ->update([ "active"=>5]); 
                        
                        /*else
                            DB::table('histories')
                                ->where('exam_id',$history->exam_id)
                                ->where('user_id',$history->user_id)
                                ->delete();*/
                            
             }
        /*
        // DB::table('histories')->where(
        //     'exam_user_id',512 )->delete();
        $examusers=DB::table('exam_user')
       // ->where('id','>',511)
        ->select('id','exam_id','user_id')->get();
        foreach($examusers as $examuser)
        {
            $histories=DB::table('histories')
            ->where('exam_id',$examuser->exam_id)
            ->where('user_id',$examuser->user_id)
            ->get();
            foreach($histories as $history)
            {
            DB::table('histories')->insert([
                'exam_user_id'=>$examuser->id,
                "question_id"=>$history->question_id,
                 "answer_id"=>$history->answer_id,
                  "created_at"=>$history->created_at,
                   "updated_at"=>$history->updated_at                
            ]);
             }
            
        }*/
        /*DB::table('exam_user')                    
             ->where('active',5)
             ->update([ "active"=>1]);*/
        dd($hids);
    }
    public function showmyinfo($exam){
        return view('panel.info',["id"=>$exam]);
    }
    public function continueExam($exam,$id){
        $EUtbl=DB::table("exam_user")->find($id);
        DB::table("exam_user")->where('exam_id',$EUtbl->exam_id)
        ->where('user_id',$EUtbl->user_id)
        ->where('name',$EUtbl->name)
        ->update(['active'=>0]);
        DB::table("exam_user")->where('id',$id)->update(['active'=>1]);
        
        $exam_user_id=DB::table("exam_user")->insertGetId([
            "user_id"=>auth()->user()->id,
            "exam_id"=>$exam,
            'age'=>auth()->user()->age,
            'name'=> $EUtbl->name,
            "created_at"=>now(),
        ]);
        $b=new Request(['sts'=>2]);
        $this->changeStatus($b);
        return redirect(route('showExamDescription',$exam_user_id));
    }
    public function CompleteInformation(request $req,$exam){
        $exam_user_id=DB::table("exam_user")->insertGetId([
            "user_id"=>auth()->user()->id,
            "exam_id"=>$exam,
            'age'=>$req->age??auth()->user()->age,
            'name'=> $req->name??(auth()->user()->firstName.' '.auth()->user()->lastName),
            "created_at"=>now(),
        ]);
        DB::table('users')->where('id',auth()->user()->id)->update(['firstName'=>$req->name,'age'=>$req->age??auth()->user()->age]);
        //session(['exam_user_id'=>$exam_user_id]);
        return redirect(route('showExamDescription',$exam_user_id));
    }
    public function identifyExams(){
        $tag = DB::table("tags")->where("name","LIKE","%استعدادیابی ۶ تا ۱۳ سال%")->get()->first();
        $exams = Tag::find($tag->id)->exams;
        return view('panel.exams',["exams"=>$exams]);
    }
    public function showDescription($id){
        $ExamUsers= DB::table("exam_user")->find($id);
        $exam = Exam::find($ExamUsers->exam_id);
        return view('panel.description',["exam"=>$exam,'ExamUserid'=>$ExamUsers->id]);
    }
    public function suggestExams(){
        $tag = DB::table("tags")->where("name","LIKE","%پیشنهادی%")->get()->first();
        $exams = Tag::find($tag->id)->exams;
        return view('panel.exams',["exams"=>$exams]);
    }
    public function changeStatus(Request $req)
    {
        try 
        {   
            $status=(auth()->user()->status)?explode(',',auth()->user()->status):[];     
            switch ($req->sts) {
                case '1':
                    if(!in_array(1,$status))
                    {
                        $status[]=1;
                        $res= DB::table('users')->where('id',auth()->user()->id)->update(['status'=>implode(',',$status)]);
                    }
                    else
                    $res=1;
                    break;
                case '2':                    
                    if(!in_array(2,$status))
                    {
                        $status[]=2;
                        $res= DB::table('users')->where('id',auth()->user()->id)->update(['status'=>implode(',',$status)]);
                    }
                    else
                    $res=1;
                    break;
                case '3':                    
                    if(!in_array(3,$status))
                    {
                        $status[]=3;
                        $res= DB::table('users')->where('id',auth()->user()->id)->update(['status'=>implode(',',$status)]);
                    }
                    else
                    $res=1;
                    break;
                case '4':
                    if(!in_array(4,$status))
                    {
                        $status[]=4;
                        $res= DB::table('users')->where('id',auth()->user()->id)->update(['status'=>implode(',',$status)]);
                        $response = Http::post("http://85.208.255.101:8012/RedCastlePanel/public/api/Exam/addRequest",['Phone'=>auth()->user()->phone,"Description"=>"شرکت در استعدادیابی","Platform"=>26]);
                    }
                    else
                    $res=1;
                    break;
                case '5':
                    if(!in_array(5,$status))
                    {
                        $status[]=5;
                        $res= DB::table('users')->where('id',auth()->user()->id)->update(['status'=>implode(',',$status)]);
                    }
                    else
                    $res=1;
                    break;
                case '6':
                    if(!in_array(6,$status))
                    {
                        $status[]=6;
                        $res= DB::table('users')->where('id',auth()->user()->id)->update(['status'=>implode(',',$status)]);
                    }
                    else
                    $res=1;
                    break;
                
                default:
                return 0;
                    break;
            }
            if($res)
            return response()->json(['status'=>1]);
            return response()->json(['status'=>0]);
        } catch (\Throwable $th) {
            return response()->json(['status'=>0,'msg'=>$th]);
        }
    }
}
