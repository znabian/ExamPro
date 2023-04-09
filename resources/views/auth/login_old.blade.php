<!DOCTYPE html>
<html lang="{{App::getLocale()}}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <meta name="yn-tag" id="2fd2bba1-bc29-4b11-aa83-a176672cd88b">
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
    <select name="language" onchange="chlang.submit();"  id='langselect'>
        <option value="en" @if(App::isLocale('en')) selected @endif>English</option>
        <option value="fa" @if(App::isLocale('fa')) selected @endif>فارسی</option>
        <option value="ar" @if(App::isLocale('ar')) selected @endif>العربی</option>
        <option value="es" @if(App::isLocale('es')) selected @endif>español</option>
    </select>
</form>
    @include('sweet::alert')
    <div id="loginHeader">
        <figure>
            <img id="logoImage" src="{{asset('/images/logo.png')}}" alt="سامانه رشد خوش نظر">
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
                    <img id="loginContainerHeaderFigureLogoDesktop" src="{{asset('/images/logored.png')}}" alt="سامانه رشد خوش نظر">
                    <figcaption id="loginContainerHeaderFigureCaption" >{{__('messages.سامانه رشد خوش نظر')}}</figcaption>
                </figure>
                <hr/>
            </div>
            <div id="loginContainerBody">
                <form method="post" action="{{route('sendSms')}}">
                    @csrf
                    <label for="phoneNumberInput">{{__('messages.شماره موبایل خود را وارد کنید')}}</label>
                    <br>
                    <input type="tel" id="phoneNumberInput" autocomplete="off" required name="phone">
                    <br>
                    <button type="submit" id="sendConfirmCodeButton">{{__('messages.دریافت کد')}}</button>
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
                    <figcaption id="loginContainerHeaderFigureCaption">{{__('messages.ثبت نام یا ورود')}}</figcaption>
                </figure>
                <hr/>
            </div>
            <div id="loginContainerBody">
                <form method="post" action="{{route('sendSms')}}">
                    @csrf
                <label for="phoneNumberInputMobile">{{__('messages.شماره موبایل خود را وارد کنید')}}</label>
                <br>
                <input type="tel" id="phoneNumberInputMobile" autocomplete="off" required name="phone">
                <br>
                <button id="sendConfirmCodeButtonMobile">{{__('messages.دریافت کد')}}</button>
                <form>
            </div>
        </div>
    </div>
    <div id="error">
        <span>لطفا شماره موبایل را به درستی وارد نمایید</span>
    </div>
    <script src="{{asset('js/app.js')}}"></script>
    <script>
        @if($errors->any())
        swal({
            title: "{{__('messages.خطا')}}",
            text:  "{{__('messages.شماره موبایل وارد شده صحیح نمی باشد')}}",
            icon: "error",
            button: "{{__('messages.دوباره سعی کن')}}",
        });
        @endif
    </script>
    <script> !function (t, e, n) { t.yektanetAnalyticsObject = n, t[n] = t[n] || function () { t[n].q.push(arguments) }, t[n].q = t[n].q || []; var a = new Date, r = a.getFullYear().toString() + "0" + a.getMonth() + "0" + a.getDate() + "0" + a.getHours(), c = e.getElementsByTagName("script")[0], s = e.createElement("script"); s.id = "ua-script-7DaHwwsc"; s.dataset.analyticsobject = n; s.async = 1; s.type = "text/javascript"; s.src = "https://cdn.yektanet.com/rg_woebegone/scripts_v3/7DaHwwsc/rg.complete.js?v=" + r, c.parentNode.insertBefore(s, c) }(window, document, "yektanet"); </script>
</body>
</html>