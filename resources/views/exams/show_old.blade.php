@extends('layouts.exam-quize')
@section('title', 'آزمون')
@section('content')
@foreach($exam->questions()->get() as $Qkey=>$question)
    <div class="MobileShowExamQuestionContainer">
        <span class="MobileQuestionTitle" style="text-align:right;">
            {!!$question->name!!}
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
                    <span>{{$answer->name}}</span>
                </div>
                <div>
                    <input type="radio" id='Mb{{$answer->id}}'  name="{{$answer->question_id}}" onclick="saveExamQuestionAnswerRecord({{$Qkey+1}},{{$ExamUserid}},{{$answer->question_id}},{{$answer->id}},{{Auth::id()}})" />
                </div>
            </div>
        @endforeach
    </div>
@endforeach
    <div id="MobileShowExamQuizeEndButton">
        {{-- <a id="MobileShowExamQuizeEndButtonDisableA" href="#" onclick="disable()">اتمام آزمون</a> --}}
        {{-- <a id="MobileShowExamQuizeEndButtonA" href="{{route('showConclusion',$ExamUserid)}}">اتمام آزمون</a> --}}
        @if(DB::table("exam_user")->find($ExamUserid)->exam_id==4)
        <a id="MobileShowExamQuizeEndButtonA" onclick="endexam('{{route('continue',[6,$ExamUserid])}}')" >ادامه آزمون</a>
        <a id="ExamCancelbtn" onclick="document.location.href='{{route('exam.cancel',$ExamUserid)}}'" >لغو</a>
        @else
        @if(!is_null(session('chk')))
        <a id="MobileShowExamQuizeEndButtonA" onclick="endexam('{{route('showConclusion',$ExamUserid)}}')" >اتمام آزمون</a>
        @else
        <a id="MobileShowExamQuizeEndButtonA" onclick="endexam('{{route('showConclusion.new',$ExamUserid)}}')" >اتمام آزمون</a>
        @endif
        @endif

    </div>
@endsection
@section('DesktopContent')
@foreach($exam->questions()->get() as $Qkey=>$question)
    <div class="MobileShowExamQuestionContainer">
        <span class="MobileQuestionTitle" style="text-align:right;">
            {!!$question->name!!}
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
                    <span>{{$answer->name}}</span>
                </div>
                <div>
                    <input type="radio" id='Db{{$answer->id}}' name="{{$answer->question_id}}" onclick="saveDExamQuestionAnswerRecord({{$Qkey+1}},{{$ExamUserid}},{{$answer->question_id}},{{$answer->id}},{{Auth::id()}})" />
                </div>
            </div>
        @endforeach
    </div>
@endforeach
    <div id="MobileShowExamQuizeEndButton">
        {{-- <a id="MobileShowExamQuizeEndButtonDisableA" href="#" onclick="disable()">اتمام آزمون</a> --}}
       
        @if(DB::table("exam_user")->find($ExamUserid)->exam_id==4)
        <a id="MobileShowExamQuizeEndButtonA" onclick="endexam('{{route('continue',[6,$ExamUserid])}}')" >ادامه آزمون</a>
        <a id="ExamCancelbtn" onclick="document.location.href='{{route('exam.cancel',$ExamUserid)}}'" >لغو</a>
        @else
        @if(!is_null(session('chk')))
        <a id="MobileShowExamQuizeEndButtonA" onclick="endexam('{{route('showConclusion',$ExamUserid)}}')" >اتمام آزمون</a>
        @else
        <a id="MobileShowExamQuizeEndButtonA" onclick="endexam('{{route('showConclusion.new',$ExamUserid)}}')" >اتمام آزمون</a>
        @endif
        @endif

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
                        endexam('{{route('showConclusion',$ExamUserid)}}');
                    }
                   
                }*/
            })
            .catch(error => {
                document.getElementById("Mb"+answerId).checked=false;
                swal("توجه",'در ذخیره پاسخ سوال '+q+' مشکلی پیش آمد',"error");
            });
    }
    function saveDExamQuestionAnswerRecord(q,exam_user_id,questionId,answerId,userId){
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
                swal("توجه",'در ذخیره پاسخ سوال '+q+' مشکلی پیش آمد',"error");
            });
    }
    function endexam(url){
        swal('لطفا صبر کنید',"درحال بررسی و ذخیره اطلاعات",'warning');
        axios.get("{{route('countMyAnswer',$ExamUserid)}}")
        .then(function ({data}) {
                if(data == {{$exam->questions()->count()}}){
                    // document.getElementById("MobileShowExamQuizeEndButtonDisableA").style.display="none";
                    document.location.href=url;
                }
                else
                {
                    if(data.ans >0)
                    {
                        quizz=(data.emt)?"\n"+"سوالات \n"+data.emt+"\n":'';
                        swal("شما به "+data.ans+"سوال پاسخ داده اید","به تمامی سوالات پاسخ داده نشده است. آیا ادامه می دهید؟ ", {
                            icon: 'info',
                            showDenyButton: true,
                            buttons: {
                                cancel: "خیر", 
                                    defeat: "بله",  
                                    conf: "سوالات بدون پاسخ",                  
                                },
                                })
                            .then((value) => {
                                    switch (value) {  

                                        case "conf":
                                        swal("توجه",quizz+' پاسخ داده نشده است',"info");
                                            break;
                                        case "defeat":
                                            document.location.href=url;
                                            break;
                                        }
                                    });

                       /* if(confirm(' به تمامی سوالات پاسخ داده نشده است. آیا ادامه می دهید؟'))
                        {
                            document.location.href=url;
                        }*/
                    }
                    else
                    swal("توجه",'به تمامی سوالات پاسخ داده نشده است',"error");
                }
            })
            .catch(error => {
                swal("توجه",'مشکلی پیش آمده اتصال به اینترنت خود را بررسی نمایید',"error");
                console.log(error);
            });
    }
    function disable(){
        swal("توجه",'لطفا به تمامی سوالات پاسخ دهید',"error");
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
    .swal-text {
    text-align: right;
    direction: rtl;
}
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