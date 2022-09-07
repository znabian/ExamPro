<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('font/font-awesome/css/font-awesome.min.css')}}">
    <title>سامانه رشد عرفان خوش نظر</title>
    <style>
        @media screen and (min-width: 577px)
        {
            #loginDesktopContainer {
            margin-top: -20%!important;
            }
        }
    </style>
</head>
<body id="loginBody">
    <div id="MobileComponents">
        <x-mobile-menu />
    </div>
    <div id="DesktopComponents">
        <div id="KhoshNazarText">
            سامانه رشد خوش نظر
        </div>
    <div id="DesktopExamsExitButton">
        <img src="{{asset('images/arrow.png')}}" alt="back">
        <a href="{{route('dashboard')}}">بازگشت</a>
    </div>
    <div id="DesktopExamsExitButton">
        <img src="{{asset('images/exitIcon.png')}}" alt="exit">
        <a href="{{route('logout')}}">خروج</a>
        </div>
    </div>
    @include('sweet::alert')
    
    <div id="loginDesktopHeader">
        <img src="{{asset('/images/desktopHeader.png')}}" alt="header">
    </div>
    <div id="loginDesktopContainer">
        <div id="loginContainer">
            <div id="loginContainerHeader">
                <figure>
                    <img id="loginContainerHeaderFigureLogoDesktop" style="width: 34%;" src="{{asset('/images/avatar.png')}}" alt="person">
                    <figcaption id="loginContainerHeaderFigureCaption">تکمیل اطلاعات</figcaption>
                </figure>
                <hr/>
            </div>
            <div id="loginContainerBody">
                <form method="post" action="{{route('CompleteInformation',$id)}}">
                    @csrf
                    <label for="name">نام و نام خانوادگی </label>
                    <br>
                    <input type="text" id="name" autocomplete="off"  name="name" placeholder="{{auth()->user()->firstName.' '.auth()->user()->lastName}}">
                    <br>
                    <label for="">سن </label>
                    <br>
                    <input type="number" max="99" min="5" minlength="1" maxlength="2" autocomplete="off" required  name="age" value="{{auth()->user()->age}}">
                    <br>
                    <button type="submit" id="sendConfirmCodeButton">شروع آزمون</button>
                </form>
                {{-- <label for="phoneNumberInput">شماره موبایل خود را وارد کنید</label>
                <input type="tel" id="phoneNumberInput" autocomplete="off" required>
                <button id="sendConfirmCodeButton">دریافت کد</button> --}}
            </div>
        </div>
        <div id="boyIcon">
            <img src="{{asset('/images/boyImage.png')}}" alt="boy">
        </div>
    </div>
    <div id="loginContainerMobile">
        <div id="loginContainer">
            <div id="loginContainerHeader">
                <figure>
                    <img id="loginContainerHeaderFigureLogo" style="width: 34%;" src="{{asset('/images/avatar.png')}}" alt="person">
                    <figcaption id="loginContainerHeaderFigureCaption">تکمیل اطلاعات</figcaption>
                </figure>
                <hr/>
            </div>
            <div id="loginContainerBody">
                <form method="post" action="{{route('CompleteInformation',$id)}}">
                    @csrf
                    <label for="phoneNumberInputMobile">نام و نام خانوادگی </label>
                    <br>
                    <input type="text" id="phoneNumberInputMobile" autocomplete="off"  name="name" placeholder="{{auth()->user()->firstName.' '.auth()->user()->lastName}}">
                    <br>
                    <label for="phoneNumberInputMobile">سن </label>
                    <br>
                    <input type="number" max="99" min="5" minlength="1" maxlength="2" id="phoneNumberInputMobile" autocomplete="off" required name="age" value="{{auth()->user()->age}}">
                    <br>
                    <button type="submit" id="sendConfirmCodeButton">شروع آزمون</button>
                </form>
                {{-- <label for="phoneNumberInput">شماره موبایل خود را وارد کنید</label>
                <input type="tel" id="phoneNumberInput" autocomplete="off" required>
                <button id="sendConfirmCodeButton">دریافت کد</button> --}}
            </div>
            
        </div>
    </div>
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