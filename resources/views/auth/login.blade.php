<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <title>ورود به سامانه</title>
</head>
<body id="loginBody">
    @include('sweet::alert')
    <div id="loginHeader">
        <figure>
            <img id="logoImage" src="{{asset('/images/logo.png')}}" alt="سامانه رشد خوش نظر">
            <figcaption id="logoCaption">سامانه رشد خوش نظر</figcaption>
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
                    <figcaption id="loginContainerHeaderFigureCaption" >سامانه رشد خوش نظر</figcaption>
                </figure>
                <hr/>
            </div>
            <div id="loginContainerBody">
                <form method="post" action="{{route('sendSms')}}">
                    @csrf
                    <label for="phoneNumberInput">شماره موبایل خود را وارد کنید</label>
                    <br>
                    <input type="tel" id="phoneNumberInput" autocomplete="off" required name="phone">
                    <br>
                    <button type="submit" id="sendConfirmCodeButton">دریافت کد</button>
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
                    <img id="loginContainerHeaderFigureLogo" src="{{asset('/images/loginPerson.png')}}" alt="person">
                    <figcaption id="loginContainerHeaderFigureCaption">ثبت نام|ورود</figcaption>
                </figure>
                <hr/>
            </div>
            <div id="loginContainerBody">
                <form method="post" action="{{route('sendSms')}}">
                    @csrf
                <label for="phoneNumberInputMobile">شماره موبایل خود را وارد کنید</label>
                <br>
                <input type="tel" id="phoneNumberInputMobile" autocomplete="off" required name="phone">
                <br>
                <button id="sendConfirmCodeButtonMobile">دریافت کد</button>
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
            title: "خطا",
            text:  "شماره موبایل وارد شده صحیح نمی باشد",
            icon: "error",
            button: "دوباره سعی کن",
        });
        @endif
    </script>
</body>
</html>