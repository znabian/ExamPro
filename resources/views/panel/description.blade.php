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
            <span>{{__('messages.زمان تقریبی')}} : {{$exam->time}} {{__('messages.دقیقه')}}</span>
            <img src="{{asset('images/examTime.png')}}">
        </div>
        <div id="MobileDiscriptionContainerInformationsSecond" class="MobileDiscriptionContainerInformationsElements">
            <span>{{__('messages.تعداد سوالات')}} :{{$quizcount}}</span>
            <img src="{{asset('images/questionsNumber.png')}}">
        </div>
        {{-- <div id="MobileDiscriptionContainerInformationsThird" class="MobileDiscriptionContainerInformationsElements">
            <span>بازه سنی : {{$exam->ageRange}}</span>
            <img src="{{asset('images/ageRange.png')}}">
        </div> --}}
    </div>
    <hr style="margin-left: 5%;margin-right:5%;">
    <div id="MobileDiscriptionContainerDescriptions">
        <ul>
           {!!__('messages.descriptions')!!}
        </ul>
    </div>
    <div id="MobileDescriptionStartExamButtonContainer">
        <a href="{{route("exam.show",$ExamUserid)}}">{{__('messages.شروع آزمون')}}</a>
        @if(!is_null(session('chk')))
        <a href="{{route("dashboard")}}">{{__('messages.بازگشت')}}</a>
        @endif
    </div>
@endsection
@section('DesktopContent')
    <div id="DesktopDiscriptionContainerHeader">
        <img src="{{asset('images/exam.png')}}">
    </div>
    <div id="DesktopDiscriptionContainerInformations">
        <div id="DesktopDiscriptionContainerInformationsFirst" class="DesktopDiscriptionContainerInformationsElements" style="margin-top:2%;">
            <span>{{__('messages.زمان تقریبی')}} : {{$exam->time}} {{__('messages.دقیقه')}}</span>
            <img src="{{asset('images/examTime.png')}}">
        </div>
        <div id="DesktopDiscriptionContainerInformationsSecond" class="DesktopDiscriptionContainerInformationsElements">
            <span>{{__('messages.تعداد سوالات')}} :{{$quizcount}}</span>
            <img src="{{asset('images/questionsNumber.png')}}">
        </div>
        {{-- <div id="DesktopDiscriptionContainerInformationsThird" class="DesktopDiscriptionContainerInformationsElements">
            <span>بازه سنی : {{$exam->ageRange}}</span>
            <img src="{{asset('images/ageRange.png')}}">
        </div> --}}
    </div>
    <hr style="margin-left: 5%;margin-right:5%;">
    <div id="DesktopDiscriptionContainerDescriptions">
        <ul>
            {!!__('messages.descriptions')!!}
        </ul>
    </div>
    <div id="DesktopDescriptionStartExamButtonContainer">
        <a href="{{route("exam.show",$ExamUserid)}}">{{__('messages.شروع آزمون')}}</a>
        @if(!is_null(session('chk')) || $exam->id==4)
        <a href="{{route("exam.cancel",$ExamUserid)}}">{{__('messages.بازگشت')}}</a>
        @endif
    </div>
@endsection
<style>
@if(!in_array(App::getLocale(),['ar','fa']))
     ul{
        direction:ltr;
     }
     @endif
    @media (max-width:576px) {

        #DesktopComponents
            {
                display: none;
            }
            
        }
</style>