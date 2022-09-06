<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('font/font-awesome/css/font-awesome.min.css')}}">
    <title>@yield('title')-سامانه رشد عرفان خوش نظر</title>
</head>
<body>
    <div id="MobileComponents">
        <x-mobile-menu />
        @yield('content')
    </div>
    <div id="DesktopComponents" style="overflow: auto; height: inherit;">
        
        <div id="KhoshNazarText">
            سامانه رشد خوش نظر
        </div>
        <div id="DesktopExamsExitButton" >
            <img src="{{asset('images/arrow.png')}}" alt="back">
            <a href="{{route('dashboard')}}">بازگشت</a>
        </div>
        <div id="DesktopExamsExitButton">
            <img src="{{asset('images/exitIcon.png')}}" alt="exit">
            <a href="{{route('logout')}}">خروج</a>
            </div>
        @yield('DesktopContent')
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