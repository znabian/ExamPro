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
        select
        {
            width: 100%;
            margin-top: 2%;
            border: 1px solid #747A82;
            height: 5vh;
            text-align: center;
            border-radius: 12px;
            font-family: "PeydaLight","Peyda";
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
                    <select required name="age" id="">
                        <option value="">انتخاب کنید</option>
                        <option @if(auth()->user()->age==7) selected @endif value="7">7</option>
                        <option @if(auth()->user()->age==8) selected @endif  value="8">8</option>
                        <option @if(auth()->user()->age==9) selected @endif  value="9">9</option>
                        <option @if(auth()->user()->age==10) selected @endif  value="10">10</option>
                        <option @if(auth()->user()->age==11) selected @endif  value="11">11</option>
                        <option @if(auth()->user()->age==12) selected @endif  value="12">12</option>
                        <option @if(auth()->user()->age==13) selected @endif  value="13">13</option>
                        <option @if(auth()->user()->age==14) selected @endif  value="14">14</option>
                        <option @if(auth()->user()->age==15) selected @endif  value="15">15</option>
                        <option @if(auth()->user()->age==16) selected @endif  value="16">16</option>
                        <option @if(auth()->user()->age==17) selected @endif  value="17">17</option>
                        <option @if(auth()->user()->age==18) selected @endif  value="18">18</option>
                    </select>
                    {{-- <input type="number" max="99" min="5" minlength="1" maxlength="2" autocomplete="off" required  name="age" value="{{auth()->user()->age}}"> --}}
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
                    <select required name="age" id="phoneNumberInputMobile">
                        <option value="">انتخاب کنید</option>
                        <option @if(auth()->user()->age==7) selected @endif value="7">7</option>
                        <option @if(auth()->user()->age==8) selected @endif  value="8">8</option>
                        <option @if(auth()->user()->age==9) selected @endif  value="9">9</option>
                        <option @if(auth()->user()->age==10) selected @endif  value="10">10</option>
                        <option @if(auth()->user()->age==11) selected @endif  value="11">11</option>
                        <option @if(auth()->user()->age==12) selected @endif  value="12">12</option>
                        <option @if(auth()->user()->age==13) selected @endif  value="13">13</option>
                        <option @if(auth()->user()->age==14) selected @endif  value="14">14</option>
                        <option @if(auth()->user()->age==15) selected @endif  value="15">15</option>
                        <option @if(auth()->user()->age==16) selected @endif  value="16">16</option>
                        <option @if(auth()->user()->age==17) selected @endif  value="17">17</option>
                        <option @if(auth()->user()->age==18) selected @endif  value="18">18</option>
                    </select>
                    {{-- <input type="number" max="99" min="5" minlength="1" maxlength="2" id="phoneNumberInputMobile" autocomplete="off" required name="age" value="{{auth()->user()->age}}"> --}}
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