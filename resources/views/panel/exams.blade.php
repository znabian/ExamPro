@extends('layouts.app')
@section('title', 'آزمون ها')
@section('content')

    <div id="MobileExamsHeader">
        <span>{{auth()->user()->phone}}</span>
        <img src="{{asset('images/avatar.png')}}">
    </div>
    <div id="MobileExamsBody">
        @foreach($exams as $exam)
            @php
                if($exam->groups()->where('status',1)->count())
                $quizcount=DB::table('group_questions')->whereIn('group_id',$exam->groups()->where('status',1)->pluck('id'))->count();
                else
                $quizcount=$exam->questions()->where('status',1)->count();
            @endphp
            <div id="MobileExamsContainer">
                <div id="MobileExamsContainerHeader">
                    <img src="{{asset('images/examTest.png')}}">
                    <br>
                    <span>{{__('messages.'.$exam->name)}}</span>
                </div>
                <img src="{{asset('images/khoshNazar.png')}}" id="MobileExamsCardKhoshNazarAvatar" style="z-index:1;">
                <div id="MobileExamsContainerMiddle">
                    <div class="MobileExamsContainerSeprator"></div>
                    <div id="MobileExamsContainerStars">
                        <img src="{{asset('images/yellowStar.png')}}">
                        <img src="{{asset('images/yellowStar.png')}}">
                        <img src="{{asset('images/yellowStar.png')}}">
                        <img src="{{asset('images/yellowStar.png')}}">
                        <img src="{{asset('images/yellowStar.png')}}">
                    </div>
                    <div class="MobileExamsContainerSeprator"></div>
                </div>
                <div id="MobileExamsBodyContainer">
                  
                    <span>
                        {{__('messages.تعداد سوالات')}}{{$quizcount}} | {{__('messages.زمان تقریبی')}} {{$exam->time}} {{__('messages.دقیقه')}} | تعداد شرکت کنندگان {{Illuminate\Support\Facades\DB::table('exam_user')->where("exam_id","=",$exam->id)->count()}} نفر
                    </span>
                   
                </div>
                <div id="MobileExamsFooterContainer">
                    <a href="{{route('myinfo',$exam->id)}}">{{__('messages.شروع آزمون')}}</a>
                </div>
            </div>
        @endforeach
    </div>
    {{-- <div id="MobileExamsBottomArrow">
        <img src="{{asset('images/bottomArrow.png')}}">
    </div>
    <div id="MobileExamsExitButton">
        <img src="{{asset('images/exitIcon.png')}}" alt="exit">
        <a href="{{route('logout')}}">{{__('messages.خروج')}}</a>
    </div> --}}
@endsection
@section('DesktopContent')
    <div id="DesktopDashboardExamCategoryHeader">
        <span>{{auth()->user()->phone}}</span>
    </div>
    <div id="DesktopExamsBody">
        @foreach($exams as $exam)
        @php
            if($exam->groups()->where('status',1)->count())
            $quizcount=DB::table('group_questions')->whereIn('group_id',$exam->groups()->where('status',1)->pluck('id'))->count();
            else
            $quizcount=$exam->questions()->where('status',1)->count();
        @endphp
            <div id="DesktopExamsContainer">
                <div id="DesktopExamsContainerHeader">
                    <img src="{{asset('images/examTest.png')}}">
                    <br>
                    <span>{{__('messages.'.$exam->name)}}</span>
                </div>
                <img src="{{asset('images/khoshNazar.png')}}" id="DesktopExamsCardKhoshNazarAvatar" style="z-index:1;">
                <div id="DesktopExamsContainerMiddle">
                    <div class="DesktopExamsContainerSeprator"></div>
                    <div id="DesktopExamsContainerStars">
                        <img src="{{asset('images/yellowStar.png')}}">
                        <img src="{{asset('images/yellowStar.png')}}">
                        <img src="{{asset('images/yellowStar.png')}}">
                        <img src="{{asset('images/yellowStar.png')}}">
                        <img src="{{asset('images/yellowStar.png')}}">
                    </div>
                    <div class="DesktopExamsContainerSeprator"></div>
                </div>
                <div id="DesktopExamsBodyContainer">
                   
                    <span>
                        {{__('messages.تعداد سوالات')}}{{$quizcount}} | {{__('messages.زمان تقریبی')}} {{$exam->time}} {{__('messages.دقیقه')}} | تعداد شرکت کنندگان {{Illuminate\Support\Facades\DB::table('exam_user')->where("exam_id","=",$exam->id)->count()}} نفر
                    </span>
                </div>
                <div id="DesktopExamsFooterContainer">
                    <a href="{{route('myinfo',$exam->id)}}">{{__('messages.شروع آزمون')}}</a>
                </div>
            </div>
        @endforeach
    </div>
    
   
@endsection