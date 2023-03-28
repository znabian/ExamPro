<!DOCTYPE html>
<html lang="{{App::getLocale()}}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <title>{{__('messages.ورود به سامانه')}}</title>
    <style>
        
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
<body id="loginBody">
    
<form id="chlang" action="{{route('chLang')}}" method="post">
    @csrf
    <select name="language" onchange="chlang.submit();" id='langselect'>
        <option value="en" @if(App::isLocale('en')) selected @endif>English</option>
        <option value="fa" @if(App::isLocale('fa')) selected @endif>فارسی</option>
        <option value="ar" @if(App::isLocale('ar')) selected @endif>العربی</option>
        <option value="es" @if(App::isLocale('es')) selected @endif>español</option>
    </select>
</form>
    <div id="loginHeader">
        <figure>
            <img id="logoImage" src="{{asset('/images/logo.png')}}" alt="{{__('messages.سامانه رشد خوش نظر')}}">
            <figcaption id="logoCaption">{{__('messages.سامانه رشد خوش نظر')}}</figcaption>
        </figure>
    </div>
    <div id="loginDesktopHeader">
        <img src="{{asset('/images/desktopHeader.png')}}" alt="header">
    </div>
    <div id="loginDesktopContainer">
        <div id="loginContainer">
            <div id="loginContainerHeader">
                <figure>
                    <img id="loginContainerHeaderFigureLogoDesktop" src="{{asset('/images/loginPersonRed.png')}}" alt="person">
                    <figcaption id="loginContainerHeaderFigureCaption">{{__('messages.کد تایید را وارد نمایید')}}</figcaption>
                </figure>
                <hr/>
            </div>
            <div id="loginContainerBody">
                <form action="{{route("loginConfirmation",$sms)}}" method="post">
                    @csrf
                    <label for="codeInput"><small id="codeLable">{{__('messages.کد تایید برای شماره موبایل ارسال گردید',['mobile'=>$sms->phone])}}</small></label>
                    <br>
                    <input type="tel" id="codeInput" name="code" autocomplete="off" required placeholder="----">
                    <br>
                    <div id="timer"></div>
                    <div id="timerLink">{{__('messages.ارسال مجدد کد')}}</div>
                    <button type="submit" id="loginButton">{{__('messages.ورود')}}</button>
                </form>
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
                    <img id="loginContainerHeaderFigureLogo" src="{{asset('/images/loginPerson.png')}}" alt="person">
                    <figcaption id="loginContainerHeaderFigureCaption">{{__('messages.کد تایید را وارد نمایید')}}</figcaption>
                </figure>
                <hr/>
            </div>
            <div id="loginContainerBody">
                <form action="{{route("loginConfirmation",$sms)}}" method="post">
                    @csrf
                    <label for="codeInputMobile"><small id="codeLableMobile">{{__('messages.کد تایید برای شماره موبایل ارسال گردید',['mobile'=>$sms->phone])}}</small>
                       
                    </label>
                    <br>
                    <input type="tel" id="codeInputMobile" autocomplete="off" name="code" required placeholder="----">
                    <br>
                    <div id="timerMobile"></div>
                    <div id="timerMobileLink">{{__('messages.ارسال مجدد کد')}}</div>
                    <button type="submit" id="loginButtonMobile">{{__('messages.ورود')}}</button>
                </form>
            </div>
        </div>
    </div>
    @if(isset($error))
    {{-- <div id="error" style="opacity: unset">
        <span>لطفا کد ورود را به درستی وارد نمایید</span>
    </div> --}}
    @endif
    <script src="{{asset('js/app.js')}}"></script>
    <script>
        var seconds_left = 120;
        var seconds_left_mobile = 120;
        var interval = setInterval(function() {
            document.getElementById('timer').innerHTML =  "{{__('messages.ارسال مجدد کد تا')}} "+ --seconds_left +" {{__('messages.ثانیه')}}";
            document.getElementById('timerMobile').innerHTML = "{{__('messages.ارسال مجدد کد تا')}} "+ --seconds_left_mobile +" {{__('messages.ثانیه')}}";
            if (seconds_left <= 0)
            {
                document.getElementById('timer').style.display = "none";
                document.getElementById('timerMobile').style.display = "none";
                document.getElementById('timerLink').style.display = "block";
                document.getElementById('timerMobileLink').style.display = "block";
                clearInterval(interval);
            }
        }, 1000);
        document.getElementById('timerLink').addEventListener('click', function(){
            window.location.reload();
        })
        document.getElementById('timerMobileLink').addEventListener('click', function(){
            window.location.reload();
        })
    </script>
    <script>
        @if(isset($error))
        swal({
            title: "{{__('messages.خطا')}}",
            text:  "{{__('messages.لطفا کد ورود را به درستی وارد نمایید')}}",
            icon: "error",
            button: "{{__('messages.دوباره سعی کن')}}",
        });
        @endif
    </script>
</body>
</html>