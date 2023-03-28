@extends('layouts.exam-quize')
@section('title', 'آزمون')
@section('content')
@foreach($exam->questions()->get() as $Qkey=>$question)
    <div class="MobileShowExamQuestionContainer">
        <span class="MobileQuestionTitle" style="text-align:right;">
            @if(App::isLocale('fa'))
            {!!$question->name!!}
            @else
            {!!$question->lang(App::getLocale())->first()->translate??$question->name!!}
            @endif
        </span>
        <span class="MobileQuestionNumber">
            {{$Qkey+1}}
        </span>
    </div>
    <div class="MobileShowExamAnswer">
        @foreach($question->answers()->get() as $key=>$answer)
            <div class="MobileShowExamAnswerRows">
                <div>
                    <span class="MobileShowExamAnswerDot"></span> 
                    <span>
                        @if(App::isLocale('fa'))
                        {!!$answer->name!!}
                        @else
                        {!!$answer->lang(App::getLocale())->first()->translate??$answer->name!!}
                        @endif
                    </span>
                </div>
                <div>
                    <input type="radio" class='inputans' id='Mb{{$answer->id}}'  name="{{$answer->question_id}}" onclick="saveExamQuestionAnswerRecord({{$Qkey+1}},{{$ExamUserid}},{{$answer->question_id}},{{$answer->id}},{{Auth::id()}})" />
                </div>
            </div>
        @endforeach
    </div>
@endforeach
    <div id="MobileShowExamQuizeEndButton">
        {{-- <a id="MobileShowExamQuizeEndButtonDisableA" href="#" onclick="disable()">{{__('messages.اتمام آزمون')}}</a> --}}
        {{-- <a id="MobileShowExamQuizeEndButtonA" href="{{route('showConclusion.new',$ExamUserid)}}">{{__('messages.اتمام آزمون')}}</a> --}}
        {{-- @if(DB::table("exam_user")->find($ExamUserid)->exam_id==4)
        <a id="MobileShowExamQuizeEndButtonA" onclick="endexam('{{route('continue',[6,$ExamUserid])}}','Mb')" >ادامه آزمون</a>
        <a id="ExamCancelbtn" onclick="document.location.href='{{route('exam.cancel',$ExamUserid)}}'" >{{__('messages.لغو')}}</a>
        @else
            @if(!is_null(session('chk')))
            <a id="MobileShowExamQuizeEndButtonA" onclick="endexam('{{route('showConclusion.new',$ExamUserid)}}','Mb')" >{{__('messages.اتمام آزمون')}}</a>
            <a id="ExamCancelbtn" onclick="document.location.href='{{route('exam.cancel',$ExamUserid)}}'" >{{__('messages.لغو')}}</a>
            @else
            <a id="MobileShowExamQuizeEndButtonA" onclick="endexam('{{route('showConclusion.new',$ExamUserid)}}','Mb')" >{{__('messages.اتمام آزمون')}}</a>
            @endif
        @endif --}}
            <a id="MobileShowExamQuizeEndButtonA" onclick="endexam('{{route('showConclusion.new',$ExamUserid)}}','Mb')" >{{__('messages.اتمام آزمون')}}</a>
            <a id="ExamCancelbtn" onclick="document.location.href='{{route('exam.cancel',$ExamUserid)}}'" >{{__('messages.لغو')}}</a>
           

    </div>
@endsection
@section('DesktopContent')
@foreach($exam->questions()->get() as $Qkey=>$question)
    <div class="MobileShowExamQuestionContainer">
        <span class="MobileQuestionTitle" style="text-align:right;">
            @if(App::isLocale('fa'))
            {!!$question->name!!}
            @else
            {!!$question->lang(App::getLocale())->first()->translate??$question->name!!}
            @endif
        </span>
        <span class="MobileQuestionNumber">
            {{$Qkey+1}}
        </span>
    </div>
    <div class="MobileShowExamAnswer">
        @foreach($question->answers()->get() as $key=>$answer)
            <div class="MobileShowExamAnswerRows">
                <div>
                    <span class="MobileShowExamAnswerDot"></span> 
                    <span>
                        @if(App::isLocale('fa'))
                        {!!$answer->name!!}
                        @else
                        {!!$answer->lang(App::getLocale())->first()->translate??$answer->name!!}
                        @endif
                    </span>
                </div>
                <div>
                    <input type="radio" class='inputans' id='Db{{$answer->id}}' name="{{$answer->question_id}}" onclick="saveDExamQuestionAnswerRecord({{$Qkey+1}},{{$ExamUserid}},{{$answer->question_id}},{{$answer->id}},{{Auth::id()}})" />
                </div>
            </div>
        @endforeach
    </div>
@endforeach
    <div id="MobileShowExamQuizeEndButton">
        {{-- <a id="MobileShowExamQuizeEndButtonDisableA" href="#" onclick="disable()">{{__('messages.اتمام آزمون')}}</a> --}}
       
        {{-- @if(DB::table("exam_user")->find($ExamUserid)->exam_id==4)
        <a id="MobileShowExamQuizeEndButtonA" onclick="endexam('{{route('continue',[6,$ExamUserid])}}','Db')" >ادامه آزمون</a>
        <a id="ExamCancelbtn" onclick="document.location.href='{{route('exam.cancel',$ExamUserid)}}'" >{{__('messages.لغو')}}</a>
        @else
            @if(!is_null(session('chk')))
            <a id="MobileShowExamQuizeEndButtonA" onclick="endexam('{{route('showConclusion.new',$ExamUserid)}}','Db')" >{{__('messages.اتمام آزمون')}}</a>
            <a id="ExamCancelbtn" onclick="document.location.href='{{route('exam.cancel',$ExamUserid)}}'" >{{__('messages.لغو')}}</a>
            @else
            <a id="MobileShowExamQuizeEndButtonA" onclick="endexam('{{route('showConclusion.new',$ExamUserid)}}','Db')" >{{__('messages.اتمام آزمون')}}</a>
            @endif
        @endif --}}
            <a id="MobileShowExamQuizeEndButtonA" onclick="endexam('{{route('showConclusion.new',$ExamUserid)}}','Db')" >{{__('messages.اتمام آزمون')}}</a>
            <a id="ExamCancelbtn" onclick="document.location.href='{{route('exam.cancel',$ExamUserid)}}'" >{{__('messages.لغو')}}</a>
           

    </div>
@endsection
@section('mobileScript')


<script>
    function saveExamQuestionAnswerRecord(q,exam_user_id,questionId,answerId,userId){
        var data2 = { "exam_user_id" : exam_user_id,"question_id":questionId,"answer_id":answerId };
        axios.post("{{route('save')}}",data2)
        .then(function ({data}) {
               /* if(data.status && data.num == {{$exam->questions()->count()}}){
                    if(confirm(' به تمامی سوالات پاسخ داده شد. آیا به آزمون پایان می دهید؟'))
                    {
                        endexam('{{route('showConclusion.new',$ExamUserid)}}');
                    }
                   
                }*/
            })
            .catch(error => {
                document.getElementById("Mb"+answerId).checked=false;
                swal("{{__('messages.توجه')}}",'{{__('messages.ثبت نشد')}} '+q,"error");
            });
    }
    function saveDExamQuestionAnswerRecord(q,exam_user_id,questionId,answerId,userId){
        var data2 = { "exam_user_id" : exam_user_id,"question_id":questionId,"answer_id":answerId };
        axios.post("{{route('save')}}",data2)
        .then(function ({data}) {
                if(data.status && data.num == {{$exam->questions()->count()}}){
                    //endexam('{{route('showConclusion.new',$ExamUserid)}}');
                }
                else
                {
                   // document.getElementById("Mb"+answerId).checked=true;
                }
                
            })
            .catch(error => {
                document.getElementById("Db"+answerId).checked=false;
                swal("{{__('messages.توجه')}}",'{{__('messages.ثبت نشد')}} '+q,"error");
            });
    }
    function endexam(url,pl){
        swal('{{__('messages.alert_wait.title')}}',"{{__('messages.alert_wait.body')}}",'warning');
        axios.get("{{route('countMyAnswer',$ExamUserid)}}")
        .then(function ({data}) {
                if(data.ans == {{$exam->questions()->count()}}){
                    // document.getElementById("MobileShowExamQuizeEndButtonDisableA").style.display="none";
                    @if(auth()->user()->source!='survey')
                        //{-- @if($exam->id==4)
                        // swal('{{__('messages.alert_wait.title')}}',"شما درحال انتقال به صفحه مرحله دوم آزمون هستید",'info');
                        // @elseif(is_null(session('chk')) && $exam->id==6)
                        // swal('{{__('messages.alert_exam.defeat.title')}}',"{{__('messages.alert_exam.defeat.body')}}",'info');
                        // @endif--}
                         swal('{{__('messages.alert_exam.defeat.title')}}',"{{__('messages.alert_exam.defeat.body')}}",'info');
                        document.location.href=url;
                    @else
                        document.location.href="{{route('end.survey',$ExamUserid)}}";
                    @endif
                    
                }
                else
                {
                    @if(auth()->user()->source!='survey')
                    if(data.ans >0)
                    {
                        /* @if($exam->id==6)
                         yes='آزمون پایان یابد ';
                         @elseif($exam->id==4)
                         yes=' برو به مرحله دوم آزمون ';
                         @endif*/
                        quizz=(data.emt)?"{{__('messages.alert_exam.conf.body')}}\n"+data.emt+"\n":'';
                        uncheckd(data.qid);
                        checkd(data.aid,pl);
                        swal("{{__('messages.alert_exam.title')}}"+data.ans,"{{__('messages.alert_exam.body')}} ", {
                            icon: 'info',
                            showDenyButton: true,
                            buttons: {
                                cancel: "{{__('messages.alert_exam.cancel')}}",
                                    defeat: "{{__('messages.alert_exam.defeat.btn')}}",
                                    conf: "{{__('messages.alert_exam.conf.btn')}}",
                                },
                                })
                            .then((value) => {
                                    switch (value) {  

                                        case "conf":
                                        swal("{{__('messages.توجه')}}",quizz,"info");
                                            break;
                                        case "defeat":
                                        /* @if($exam->id==4)
                                             swal('{{__('messages.alert_wait.title')}}',"شما درحال انتقال به صفحه مرحله دوم آزمون هستید",'info');
                                         @elseif(is_null(session('chk')) && $exam->id==6)
                                             swal('{{__('messages.alert_exam.defeat.title')}}',"{{__('messages.alert_exam.defeat.body')}}",'info');
                                             @endif*/
                                        swal('{{__('messages.alert_exam.defeat.title')}}',"{{__('messages.alert_exam.defeat.body')}}",'info');
                                            document.location.href=url;
                                            break;
                                        }
                                    });

                       /* if(confirm(' {{__('messages.alert_exam.body')}}'))
                        {
                            document.location.href=url;
                        }*/
                    }
                    else
                    {
                        a=document.getElementsByClassName('inputans');
                        for(var i = 0; i < a.length; i++)
                            a[i].checked = false;
                    swal("{{__('messages.توجه')}}",'{{__('messages.alert_exam.err')}}',"error");
                    }
                    @else
                    swal("{{__('messages.توجه')}}",'{{__('messages.alert_exam.err')}}',"error");
                    @endif
                }
            })
            .catch(error => {
                swal("{{__('messages.توجه')}}",'{{__('messages.noInternet')}}',"error");
                console.log(error);
            });
    }
    function uncheckd(ids)
    {
        for (const [key, value] of Object.entries(ids)) {
            document.getElementsByName(value).forEach(function(item){item.checked=false;});
           // document.getElementById("Db"+value).checked=false;
            }
    }
    function checkd(ids,pl)
    {
        for (const [key, value] of Object.entries(ids)) {
           
            document.getElementById(pl+value).checked=true;
            }
    }
    function disable(){
        swal("{{__('messages.توجه')}}",'{{__('messages.alert_exam.answerAll')}}',"error");
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
<style>
     @if(App::isLocale('fa'))
    .swal-text {
    text-align: right;
    direction: rtl;
        }
    @else
    .swal-text {
    text-align: left;
    direction: ltr;
    }
    @endif
    button.swal-button {
    color: #fff;
    font-weight: bold;
    background-color: #fe004b;
    border-color: #fe004b;
    font-family: 'Peyda';
    box-shadow:none;
    
} 
 button.swal-button--cancel {
    
    background-color: #7cd1f9;
    border-color: #7cd1f9;
    
}
 button.swal-button--conf {
    
    background-color:#01c98a!important;
    border-color: #01c98a;
    
}
button.swal-button:focus {
    color: #fff;
    font-weight: bold;
    background-color: #fe004b;
    border-color: #fe004b;
    font-family: 'Peyda';
    box-shadow:none;    
}
button.swal-button:hover
{
     background-color: #fff!important;
      color: #fe004b;
    border:2px solid #fe004b;
}
</style>