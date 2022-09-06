<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/wizard.css')}}">
    <link rel="stylesheet" href="{{asset('font/font-awesome/css/font-awesome.min.css')}}">
    <title>@yield('title')-سامانه رشد عرفان خوش نظر</title>
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
    </style>
</head>
<body>
    
@php
if($exam->groups()->where('status',1)->count())
$quizcount=DB::table('group_questions')->whereIn('group_id',$exam->groups()->where('status',1)->pluck('id'))->count();
else
$quizcount=$exam->questions()->where('status',1)->count();
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
           
            <span>تعداد سوالات {{$quizcount}}</span>
            <div id="MobileExamQuizeHr"></div>
            <span>{{$exam->name}}</span>
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
            <span>تعداد سوالات {{$quizcount}}</span>
            <div id="MobileExamQuizeHr"></div>
            <span>{{$exam->name}}</span>
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