@extends('layouts.exam-quize')
@section('title', 'آزمون')
@section('content')
@foreach($exam->questions()->get() as $key=>$question)
    <div class="MobileShowExamQuestionContainer">
        <span class="MobileQuestionTitle" style="text-align:right;">
            {!!$question->name!!}
        </span>
        <span class="MobileQuestionNumber">
            {{$key+1}}
        </span>
    </div>
    <div class="MobileShowExamAnswer">
        @foreach($question->answers()->get() as $key=>$answer)
            <div class="MobileShowExamAnswerRows">
                <div>
                    <span class="MobileShowExamAnswerDot"></span> 
                    <span>{{$answer->name}}</span>
                </div>
                <div>
                    <input type="radio" id='Mb{{$answer->id}}'  name="{{$answer->question_id}}" onclick="saveExamQuestionAnswerRecord({{$ExamUserid}},{{$answer->question_id}},{{$answer->id}},{{Auth::id()}})" />
                </div>
            </div>
        @endforeach
    </div>
@endforeach
    <div id="MobileShowExamQuizeEndButton">
        {{-- <a id="MobileShowExamQuizeEndButtonDisableA" href="#" onclick="disable()">{{__('messages.اتمام آزمون')}}</a> --}}
        {{-- <a id="MobileShowExamQuizeEndButtonA" href="{{route('showConclusion',$ExamUserid)}}">{{__('messages.اتمام آزمون')}}</a> --}}
        <a id="MobileShowExamQuizeEndButtonA" onclick="endexam('{{route('showConclusion',$ExamUserid)}}')" >{{__('messages.اتمام آزمون')}}</a>
        <a id="ExamCancelbtn" onclick="document.location.href='{{route('exam.cancel',$ExamUserid)}}'" >{{__('messages.لغو')}}</a>

    </div>
@endsection
@section('DesktopContent')
@foreach($exam->questions()->get() as $key=>$question)
    <div class="MobileShowExamQuestionContainer">
        <span class="MobileQuestionTitle" style="text-align:right;">
            {!!$question->name!!}
        </span>
        <span class="MobileQuestionNumber">
            {{$key+1}}
        </span>
    </div>
    <div class="MobileShowExamAnswer">
        @foreach($question->answers()->get() as $key=>$answer)
            <div class="MobileShowExamAnswerRows">
                <div>
                    <span class="MobileShowExamAnswerDot"></span> 
                    <span>{{$answer->name}}</span>
                </div>
                <div>
                    <input type="radio" id='Db{{$answer->id}}' name="{{$answer->question_id}}" onclick="saveDExamQuestionAnswerRecord({{$ExamUserid}},{{$answer->question_id}},{{$answer->id}},{{Auth::id()}})" />
                </div>
            </div>
        @endforeach
    </div>
@endforeach
    <div id="MobileShowExamQuizeEndButton">
        {{-- <a id="MobileShowExamQuizeEndButtonDisableA" href="#" onclick="disable()">{{__('messages.اتمام آزمون')}}</a> --}}
        <a id="MobileShowExamQuizeEndButtonA" onclick="endexam('{{route('showConclusion',$ExamUserid)}}')" >{{__('messages.اتمام آزمون')}}</a>
        <a id="ExamCancelbtn" onclick="document.location.href='{{route('exam.cancel',$ExamUserid)}}'" >{{__('messages.لغو')}}</a>

    </div>
@endsection
@section('mobileScript')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    function saveExamQuestionAnswerRecord(exam_user_id,questionId,answerId,userId){
        var data2 = { "exam_user_id" : exam_user_id,"question_id":questionId,"answer_id":answerId };
         axios.post("{{route('save')}}",data2)
        .then(function ({data}) {
               /* if(response['status'] && response['num'] == {{$exam->questions()->count()}}){
                    if(confirm(' به تمامی سوالات پاسخ داده شد. آیا به آزمون پایان می دهید؟'))
                    {
                        endexam('{{route('showConclusion',$ExamUserid)}}');
                    }
                   
                }*/
        })
            .catch(error => {
                document.getElementById("Mb"+answerId).checked=false;
            });
    }
    function saveDExamQuestionAnswerRecord(exam_user_id,questionId,answerId,userId){
        var data2 = { "exam_user_id" : exam_user_id,"question_id":questionId,"answer_id":answerId };
        axios.post("{{route('save')}}",data2)
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
                 if(data == {{$exam->questions()->count()}}){
                    // document.getElementById("MobileShowExamQuizeEndButtonDisableA").style.display="none";
                    document.location.href=url;
                }
                else
                {
                    if(confirm(' {{__('messages.alert_exam.body')}}'))
                    {
                        document.location.href=url;
                    }
                }
            })
            .catch(error => {
                console.log(error);
            });
    }
    function disable(){
        alert('{{__('messages.alert_exam.answerAll')}}')
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