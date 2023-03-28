<!DOCTYPE html>
<html lang="{{App::getLocale()}}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('font/font-awesome/css/font-awesome.min.css')}}">
    <title>{{__('messages.سامانه رشد خوش نظر')}}</title>
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
    <div id="MobileComponents">
        <x-mobile-menu />
    </div>
    <div id="DesktopComponents">
        <div id="KhoshNazarText">
            {{__('messages.سامانه رشد خوش نظر')}}
        </div>
        <div id="DesktopExamsExitButton" >
            <a   href="{{route('logout')}}"><i class="fa fa-sign-out pull-left"></i>{{__('messages.خروج')}}</a>
            
        </div>
        @if(url()->full()!=route('dashboard'))
        <div id="DesktopExamsExitButton">           
            <a href="{{route('dashboard')}}"><i class="fa fa-home pull-left" ></i>{{__('messages.خانه')}}</a>
        </div>
        @endif
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
                    <figcaption id="loginContainerHeaderFigureCaption">{{__('messages.تکمیل اطلاعات')}}</figcaption>
                </figure>
                <hr/>
            </div>
            <div id="loginContainerBody">
                <form method="post" action="{{route('CompleteInformation',$id)}}">
                    @csrf
                    <label for="name">{{__('messages.نام و نام خانوادگی')}} </label>
                    <br>
                    <input type="text" id="name" autocomplete="off"  name="name" value="{{auth()->user()->firstName.' '.auth()->user()->lastName}}">
                    <br>
                    <label for="">{{__('messages.سن')}} </label>
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
                    <button type="submit" id="sendConfirmCodeButton">{{__('messages.شروع آزمون')}}</button>
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
                    <figcaption id="loginContainerHeaderFigureCaption">{{__('messages.تکمیل اطلاعات')}}</figcaption>
                </figure>
                <hr/>
            </div>
            <div id="loginContainerBody">
                <form method="post" action="{{route('CompleteInformation',$id)}}">
                    @csrf
                    <label for="phoneNumberInputMobile">{{__('messages.نام و نام خانوادگی')}} </label>
                    <br>
                    <input type="text" id="phoneNumberInputMobile" autocomplete="off"  name="name" value="{{auth()->user()->firstName.' '.auth()->user()->lastName}}">
                    <br>
                    <label for="phoneNumberInputMobile">{{__('messages.سن')}} </label>
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
                    <button type="submit" id="sendConfirmCodeButton">{{__('messages.شروع آزمون')}}</button>
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