<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('font/font-awesome/css/font-awesome.min.css')}}">
    <style>
        #MobileExamDescriptionHeader{
            display:flex;
            justify-content: center;
            flex-direction:row;
        }
        #MobileExamDescriptionHeader figure{
            text-align: center;
            color: #fff;
        }
        #MobileExamDescriptionHeader img{
            width:20%;
        }
        #MobileExamDescriptionTitle{
            display:flex;
            flex-direction: row;
            justify-content: center;
            margin-top: 1%;
            align-items: center;
        }
        .MobileExamDescriptionTitleHr{
            background-color: #F9FAFC;
            margin-right: 2%;
            margin-left: 2%;
            width: 100%;
            height: 1px;
            max-width: 20%;
        }
        #MobileExamDescriptionTitle span{
            color:#F9FAFC;
            font-family: "PeydaMedium";
            font-size:20px;
            text-align: center;
        }
        #MobileExamDescriptionIcons{
            display:flex;
            justify-content: center;
            align-items: flex-end;
        }
        #MobileExamDescriptionIcons figure{
            text-align: center;
            color:#F9FAFC;
            margin-bottom: -2%;
        }
        #MobileExamDescriptionIcons img{
            width: 55%;
        }
        #MobileExamDescriptionIcons figcaption{
            font-size:3vw;
            font-family: "PeydaMedium";
        }
        .MobileExamDescriptionIconsHr{
            width:1px;
            height: 25px;
            background-color: #c11445;
            align-self:flex-end;
        }
        #MobileDescriptionContainer{
        max-width: 100%;
        background-color:#fff;
        border-top-left-radius: 20px;
        border-top-right-radius: 20px;
        position:fixed;
        bottom:0;
        /* top:42vh; */
        top:265px;
        left:5%;
        right:5%;
        padding-top:2%;
        padding-left:2%;
        padding-right:2%;
        padding-bottom:4%;
        box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        overflow: hidden;
        overflow-y: scroll;
    }
   

    </style>
    <title>@yield('title')-سامانه رشد عرفان خوش نظر</title>
</head>
@php
 if(is_null(session('chk')) && $exam->id==6)
 {
    $exam->name="مرحله دوم آزمون";
     $exam->ageRange="خودشناسی";
 }
    
 if(is_null(session('chk')) && $exam->id==4)
    $exam->name="مرحله اول آزمون";
@endphp
<body style="height: auto;">
    <div id="MobileComponents">
        <x-mobile-menu />
        <div id="MobileExamDescriptionHeader">
            <figure>
                <img src="{{asset('images/avatar.png')}}">
                <figcaption>{{auth()->user()->phone}}</figcaption>
            </figure>
        </div>
        <div id="MobileExamDescriptionTitle">
            <div class="MobileExamDescriptionTitleHr"></div>
            <span>{{$exam->name}}</span>
            <div class="MobileExamDescriptionTitleHr"></div>
        </div>
        <div id="MobileExamDescriptionIcons" dir="rtl">
            <figure>
                <figcaption>{{$exam->ageRange}} </figcaption>
            </figure>
            {{-- <figure>
                <img src="{{asset('images/usersComments.png')}}">
                <figcaption>نظرات</figcaption>
            </figure>
            <div class="MobileExamDescriptionIconsHr"></div>
            <figure>
                <img src="{{asset('images/examDescription.png')}}">
                <figcaption>توضیحات</figcaption>
            </figure>
            <div class="MobileExamDescriptionIconsHr"></div>
            <figure>
                <img src="{{asset('images/examIntroduce.png')}}">
                <figcaption>معرفی</figcaption>
            </figure> --}}
        </div> 
        <div id="MobileDescriptionContainer">
            @yield('content')
        </div>
    </div>
    <div id="DesktopComponents">
        <div id="MobileExamDescriptionHeader">
            <figure>
                <img src="{{asset('images/avatar.png')}}">
                <figcaption>{{auth()->user()->phone}}</figcaption>
            </figure>
        </div>
        <div id="MobileExamDescriptionTitle">
            <div class="MobileExamDescriptionTitleHr"></div>
            <span>{{$exam->name}}</span>
            <div class="MobileExamDescriptionTitleHr"></div>
        </div>
        <div id="MobileExamDescriptionIcons" dir="rtl">
            <figure>
                <figcaption style="font-size:11pt!important">{{$exam->ageRange}} </figcaption>
            </figure>
          {{--   <figure>
                <img src="{{asset('images/usersComments.png')}}">
                <figcaption>نظرات</figcaption>
            </figure>
            <div class="MobileExamDescriptionIconsHr"></div>
            <figure>
                <img src="{{asset('images/examDescription.png')}}">
                <figcaption>توضیحات</figcaption>
            </figure>
            <div class="MobileExamDescriptionIconsHr"></div>
            <figure>
                <img src="{{asset('images/examIntroduce.png')}}">
                <figcaption>معرفی</figcaption>
            </figure> --}}
        </div>
        <div id="MobileDescriptionContainer" style="">
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