@extends('layouts.exam-quize')
@section('title', 'آزمون')
@section('content')
@php
    $index=1;
    if($exam->groups()->where('status',1)->count())
    $quizcount=DB::table('group_questions')->whereIn('group_id',$exam->groups()->where('status',1)->pluck('id'))->count();
    else
    $quizcount=$exam->questions()->where('status',1)->count();
@endphp
@foreach($exam->groups()->where('status',1)->orderBy('id')->get() as $group)
    @foreach($group->questions()->get() as $key=>$question)
        <div class="MobileShowExamQuestionContainer">
            <span class="MobileQuestionTitle" style="text-align:right;">
                {!!$question->question->name!!}
            </span>
            @if ($question->question->type!="text" && $question->question->type!="image" && !is_null($question->question->type))
            @php
            $out="
            <{$question->question->type}  controls style='width:100%;height: 10rem;'>
                <source src='".$question->question->link."'>
                Your browser does not support the {$question->question->type} player.</{$question->question->type}> ";
                echo $out;            
            @endphp           
            @elseif ($question->question->type!="text" && $question->question->type=="image" && !is_null($question->question->type)) 
            <img src="{{$question->question->link}}" alt="" style="width: 7rem">
            @endif
            <span class="MobileQuestionNumber">
                {{$index++}}
            </span>
        </div>
        <div class="MobileShowExamAnswer">
            @foreach($question->question->answers()->get() as $key=>$answer)
                <div class="MobileShowExamAnswerRows">
                    <div>
                        <span class="MobileShowExamAnswerDot"></span> 
                        <span>{{$answer->name}}</span>
                        @if ($answer->type!="text" && $answer->type!="image" && !is_null($answer->type))
                        @php
                        $out="
                        <{$answer->type}  controls style='width:100%;height: 10rem;'>
                            <source src='".$answer->link."'>
                            Your browser does not support the {$answer->type} player.</{$answer->type}> ";
                            echo $out;            
                        @endphp           
                        @elseif ($answer->type!="text" && $answer->type=="image"  && !is_null($answer->type)) 
                        <img src="{{$answer->link}}" alt="" style="width: 7rem">
                        @endif
                    </div>
                    <div>
                        <input type="radio" id='Mb{{$answer->id}}'  name="{{$answer->question_id}}" onclick="saveExamQuestionAnswerRecord({{$ExamUserid}},{{$answer->question_id}},{{$answer->id}},{{Auth::id()}})" />
                    </div>
                </div>
            @endforeach
        </div>
        <hr>
    @endforeach
@endforeach
    <div id="MobileShowExamQuizeEndButton">
        {{-- <a id="MobileShowExamQuizeEndButtonDisableA" href="#" onclick="disable()">اتمام آزمون</a> --}}
        {{-- <a id="MobileShowExamQuizeEndButtonA" href="{{route('showConclusion',$ExamUserid)}}">اتمام آزمون</a> --}}
        <a id="MobileShowExamQuizeEndButtonA" onclick="endexam('{{route('myinfo',6)}}')" >اتمام آزمون</a>
        <a id="ExamCancelbtn" onclick="document.location.href='{{route('exam.cancel',$ExamUserid)}}'" >لغو</a>

    </div>
@endsection
@section('DesktopContent')
@php
    $index=1;
@endphp
@foreach($exam->groups()->where('status',1)->orderBy('id')->get() as $group)
@foreach($group->questions()->get() as $key=>$question)
    <div class="MobileShowExamQuestionContainer">
        <span class="MobileQuestionTitle" style="text-align:right;">
            {!!$question->question->name!!}
        </span>
        @if ($question->question->type!="text" && $question->question->type!="image" && !is_null($question->question->type))
            @php
            $out="
            <{$question->question->type}  controls style='width:100%;height: 10rem;'>
                <source src='".$question->link."'>
                Your browser does not support the {$question->question->type} player.</{$question->question->type}> ";
                echo $out;            
            @endphp           
        @elseif ($question->question->type!="text" && $question->question->type=="image" && !is_null($question->question->type)) 
        <img src="{{$question->question->link}}" alt="" style="width: 7rem">
        @endif
        <span class="MobileQuestionNumber">
            {{$index++}}
        </span>
    </div>
    <div class="MobileShowExamAnswer">
        @foreach($question->question->answers()->get() as $key=>$answer)
            <div class="MobileShowExamAnswerRows">
                <div>
                    <span class="MobileShowExamAnswerDot"></span> 
                    <span>{{$answer->name}}</span>
                    @if ($answer->type!="text" && $answer->type!="image" && !is_null($answer->type))
                    @php
                    $out="
                    <{$answer->type}  controls style='width:100%;height: 10rem;'>
                        <source src='".$answer->link."'>
                        Your browser does not support the {$answer->type} player.</{$answer->type}> ";
                        echo $out;            
                    @endphp           
                    @elseif ($answer->type!="text" && $answer->type=="image"  && !is_null($answer->type)) 
                    <img src="{{$answer->link}}" alt="" style="width: 7rem">
                    @endif
                </div>
                <div>
                    <input type="radio" id='Db{{$answer->id}}' name="{{$answer->question_id}}" onclick="saveDExamQuestionAnswerRecord({{$ExamUserid}},{{$answer->question_id}},{{$answer->id}},{{Auth::id()}})" />
                </div>
            </div>
        @endforeach
    </div>
    <hr>
@endforeach
@endforeach
    <div id="MobileShowExamQuizeEndButton">
        {{-- <a id="MobileShowExamQuizeEndButtonDisableA" href="#" onclick="disable();endexam('{{route('showConclusion',$ExamUserid)}}')">اتمام آزمون</a> --}}
        <a id="MobileShowExamQuizeEndButtonA" onclick="endexam('{{route('myinfo',6)}}')" >اتمام آزمون</a>
        <a id="ExamCancelbtn" onclick="document.location.href='{{route('exam.cancel',$ExamUserid)}}'" >لغو</a>

    </div>
@endsection
@section('mobileScript')

{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}
<script>
    function saveExamQuestionAnswerRecord(exam_user_id,questionId,answerId,userId){
        var data2 = { "exam_user_id" : exam_user_id,"question_id":questionId,"answer_id":answerId };
        axios.post("{{route('save')}}",{data2})
        .then(function ({data}) {
                /*if(response['status'] && response['num'] =={{$quizcount}}){
                    if(confirm(' به تمامی سوالات پاسخ داده شد. آیا به آزمون پایان می دهید؟'))
                    {
                        endexam('{{route('showConclusion',$ExamUserid)}}');
                    }
                   
                }*/
            })
            .catch(error => {
                document.getElementById("Mb"+answerId+plat).checked=false;
            });
    }
    function saveDExamQuestionAnswerRecord(exam_user_id,questionId,answerId,userId){
        var data = { "exam_user_id" : exam_user_id,"question_id":questionId,"answer_id":answerId };
        axios.post("{{route('save')}}",{data})
        .then(function ({data}) {
                if(data.status && data.num == {{$exam->questions()->count()}}){
                    //endexam('{{route('showConclusion',$ExamUserid)}}');
                }
                else
                {
                   // document.getElementById("Mb"+answerId).checked=true;
                }
                
            })
            .catch(error => {
                document.getElementById("Db"+answerId).checked=false;
            });
    }
    function endexam(url){
        axios.get("{{route('countMyAnswer',$ExamUserid)}}")
        .then(function ({data}) {
                if(data =={{$quizcount}}){
                    // document.getElementById("MobileShowExamQuizeEndButtonDisableA").style.display="none";
                    document.location.href=url;
                }
                else
                {
                    if(data >0)
                    {
                        if(confirm(' به تمامی سوالات پاسخ داده نشده است. آیا ادامه می دهید؟'))
                        {
                            document.location.href=url;
                        }
                    }
                    else
                    alert('به تمامی سوالات پاسخ داده نشده است');
                }
            })
            .catch(error => {
                console.log(error);
            });
    }
    function disable(){
        alert('لطفا به تمامی سوالات پاسخ دهید')
    }
</script>
@endsection
<style>
    @media (max-width:576px) {

        #DesktopComponents
            {
                display: none;
            }
            #ExamCancelbtn {
            background-color: #efff0a;
            color: #212224;
            font-size: 4vw;
            border-radius: 9px;
            padding-top: 1%;
            padding-bottom: 1%;
            padding-left: 5%;
            padding-right: 5%;
            font-family: "PeydaRegular";
            text-decoration: none;
            cursor: pointer;
        }
        }
        @media (min-width:576px) {
            #ExamCancelbtn {
            background-color: #efff0a;
            color: #212224;
            font-size: 2vw;
            border-radius: 9px;
            padding-top: 1%;
            padding-bottom: 1%;
            padding-left: 5%;
            padding-right: 5%;
            font-family: "PeydaRegular";
            text-decoration: none;
            cursor: pointer;
        }
    }
</style>