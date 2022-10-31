@extends('layouts.exam-description')
@section('title', 'توضیحات آزمون')
@section('content')
@php

    if($exam->groups()->where('status',1)->count())
    $quizcount=DB::table('group_questions')->whereIn('group_id',$exam->groups()->where('status',1)->pluck('id'))->count();
    else
    $quizcount=$exam->questions()->where('status',1)->count();
@endphp
    <div id="MobileDiscriptionContainerHeader">
        <img src="{{asset('images/exam.png')}}">
    </div>
    <div id="MobileDiscriptionContainerInformations">
        <div id="MobileDiscriptionContainerInformationsFirst" class="MobileDiscriptionContainerInformationsElements" style="margin-top:2%;">
            <span>زمان تقریبی : {{$exam->time}} دقیقه</span>
            <img src="{{asset('images/examTime.png')}}">
        </div>
        <div id="MobileDiscriptionContainerInformationsSecond" class="MobileDiscriptionContainerInformationsElements">
            <span>تعداد سوالات :{{$quizcount}}</span>
            <img src="{{asset('images/questionsNumber.png')}}">
        </div>
        <div id="MobileDiscriptionContainerInformationsThird" class="MobileDiscriptionContainerInformationsElements">
            <span>بازه سنی : {{$exam->ageRange}}</span>
            <img src="{{asset('images/ageRange.png')}}">
        </div>
    </div>
    <hr style="margin-left: 5%;margin-right:5%;">
    <div id="MobileDiscriptionContainerDescriptions">
        <ul>
            <li>لطفا به سوالات همانگونه که وجود دارد پاسخ دهید نه به صورتی که دوست دارید باشد</li>
            <li>در پاسخگویی به سوالات صادق بوده و وقت زیادی را صرف یک عبارت نکنید</li>
            <li>جواب صحیح و غلط در این ابزار سنجش وجود ندارد</li>
        </ul>
    </div>
    <div id="MobileDescriptionStartExamButtonContainer">
        <a href="{{route("exam.show",$ExamUserid)}}">شروع آزمون</a>
        @if(!is_null(session('chk')))
        <a href="{{route("dashboard")}}">بازگشت</a>
        @endif
    </div>
@endsection
@section('DesktopContent')
    <div id="DesktopDiscriptionContainerHeader">
        <img src="{{asset('images/exam.png')}}">
    </div>
    <div id="DesktopDiscriptionContainerInformations">
        <div id="DesktopDiscriptionContainerInformationsFirst" class="DesktopDiscriptionContainerInformationsElements" style="margin-top:2%;">
            <span>زمان تقریبی : {{$exam->time}} دقیقه</span>
            <img src="{{asset('images/examTime.png')}}">
        </div>
        <div id="DesktopDiscriptionContainerInformationsSecond" class="DesktopDiscriptionContainerInformationsElements">
            <span>تعداد سوالات :{{$quizcount}}</span>
            <img src="{{asset('images/questionsNumber.png')}}">
        </div>
        <div id="DesktopDiscriptionContainerInformationsThird" class="DesktopDiscriptionContainerInformationsElements">
            <span>بازه سنی : {{$exam->ageRange}}</span>
            <img src="{{asset('images/ageRange.png')}}">
        </div>
    </div>
    <hr style="margin-left: 5%;margin-right:5%;">
    <div id="DesktopDiscriptionContainerDescriptions">
        <ul>
            <li>لطفا به سوالات همانگونه که وجود دارد پاسخ دهید نه به صورتی که دوست دارید باشد</li>
            <li>در پاسخگویی به سوالات صادق بوده و وقت زیادی را صرف یک عبارت نکنید</li>
            <li>جواب صحیح و غلط در این ابزار سنجش وجود ندارد</li>
        </ul>
    </div>
    <div id="DesktopDescriptionStartExamButtonContainer">
        <a href="{{route("exam.show",$ExamUserid)}}">شروع آزمون</a>
        @if(!is_null(session('chk')) || $exam->id==4)
        <a href="{{route("exam.cancel",$ExamUserid)}}">بازگشت</a>
        @endif
    </div>
@endsection
<style>
    @media (max-width:576px) {

        #DesktopComponents
            {
                display: none;
            }
            
        }
</style>