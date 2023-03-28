<!DOCTYPE html>
<html lang="{{App::getLocale()}}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/wizard.css')}}">
    <link rel="stylesheet" href="{{asset('font/font-awesome/css/font-awesome.min.css')}}">
    <title>{{__('messages.سامانه رشد خوش نظر')}}</title>
    <style>
        #MobileExamQuizeHeader{
            text-align: center;
        }
        #MobileExamQuizeHeader figure{
            text-align: center;
        }
        #MobileExamQuizeHeader img{
            /* width: 20%; */
            width:15%;
        }
        #MobileExamQuizeHeader figcaption{
            color: #F9FAFC;
            font-size:4vw;
            font-family: "PeydaRegular";
        }
        #MobileExamQuizeDescription{
            display: flex;
            justify-content: flex-end;
            align-items: flex-end;
            flex-direction: row;
            color: #F9FAFC;
            gap:2%;
            margin-top: 10%;
            margin-right: 5%;
            font-family: "PeydaRegular";
        }
        #MobileExamQuizeHr{
            width:1px;
            height: 25px;
            background-color: #F9FAFC; 
        }
        #MobileExamQuizeQuestionsContainer{
            max-width: 100%;
            background-color:#fff;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
            position:fixed;
            bottom:0;
            top:35vh;
            left:5%;
            right:5%;
            padding:4%;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
            overflow: hidden;
            overflow-y: scroll;
        }
        @media (min-width: 577px) {
            #MobileExamQuizeHeader figcaption{
                font-size:2vw!important;
            }
            #MobileExamQuizeDescription
            {
                margin-top: 0!important;
            }
            #MobileExamQuizeQuestionsContainer
            {
                top:53vh;
            }
        }
        
#langselect {
    position: fixed;
    opacity: 0.75;
    top: 0;
    text-align: center;
    width: 5rem;
    border: 0;
    border-radius: 4px;
    font-family: 'Peyda'!important;
    left: 4px;
    direction: ltr;
    font-size: 13px;
    font-weight: normal;
}
    </style>
</head>
<body>
    
<form id="chlang" action="{{route('chLang')}}" method="post">
    @csrf
    <select name="language" onchange="chlang.submit();"  id='langselect'>
        <option value="en" @if(App::isLocale('en')) selected @endif>English</option>
        <option value="fa" @if(App::isLocale('fa')) selected @endif>فارسی</option>
        <option value="ar" @if(App::isLocale('ar')) selected @endif>العربی</option>
        <option value="es" @if(App::isLocale('es')) selected @endif>español</option>
    </select>
</form>
@php
if($exam->groups()->where('status',1)->count())
$quizcount=DB::table('group_questions')->whereIn('group_id',$exam->groups()->where('status',1)->pluck('id'))->count();
else
$quizcount=$exam->questions()->where('status',1)->count();
    
    if(is_null(session('chk')) && $exam->id==6)
    {
        //$exam->name="مرحله دوم آزمون";
        $exam->ageRange="خودشناسی";
    }
 //if(is_null(session('chk')) && $exam->id==4)
   // $exam->name="مرحله اول آزمون";

@endphp

    <div id="MobileComponents">
        <x-mobile-menu />
        <div id="MobileExamQuizeHeader">
            <figure>
                <img src="{{asset("images/khoshNazar.png")}}">
                <figcaption>{{auth()->user()->phone}}</figcaption>
            </figure>
        </div>
        <div id="MobileExamQuizeDescription">
           
            <span>{{__('messages.تعداد سوالات')}} {{$quizcount}}</span>
            <div id="MobileExamQuizeHr"></div>
            <span>{{__('messages.'.$exam->name)}}</span>
        </div>
        <div id="MobileExamQuizeQuestionsContainer">
            @yield('content')
        </div>
    </div>
    <div id="DesktopComponents">
        <div id="MobileExamQuizeHeader">
            <figure>
                <img src="{{asset("images/khoshNazar.png")}}">
                <figcaption>{{auth()->user()->phone}}</figcaption>
            </figure>
        </div>
        <div id="MobileExamQuizeDescription">
            <span>{{__('messages.تعداد سوالات')}} {{$quizcount}}</span>
            <div id="MobileExamQuizeHr"></div>
            <span>{{__('messages.'.$exam->name)}}</span>
        </div>
        <div id="MobileExamQuizeQuestionsContainer">
    @yield('DesktopContent')
        </div>
    </div>
    @yield('mobileScript')
    <script src="{{asset('js/app.js')}}"></script>
    <script>
        function openNav() {
            document.getElementById("mySidebar").style.width = "70%";
            document.getElementById("main").style.marginLeft = "70%";
        }
        function closeNav() {
            document.getElementById("mySidebar").style.width = "0";
            document.getElementById("main").style.marginLeft = "0";
        }
    </script>
</body>
</html>