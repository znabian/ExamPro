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
                    <img id="loginContainerHeaderFigureLogoDesktop" src="{{asset('/images/loginPersonRed.png')}}" alt="person">
                    <figcaption id="loginContainerHeaderFigureCaption">کد تایید را وارد نمایید</figcaption>
                </figure>
                <hr/>
            </div>
            <div id="loginContainerBody">
                <form action="{{route("loginConfirmation",$sms)}}" method="post">
                    @csrf
                    <label for="codeInput"><small id="codeLable">کد تایید برای شماره موبایل {{$sms->phone}} ارسال گردید</small></label>
                    <br>
                    <input type="tel" id="codeInput" name="code" autocomplete="off" required placeholder="----">
                    <br>
                    <div id="timer"></div>
                    <div id="timerLink">ارسال مجدد کد</div>
                    <button type="submit" id="loginButton">ورود</button>
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
                    <figcaption id="loginContainerHeaderFigureCaption">کد تایید را وارد نمایید</figcaption>
                </figure>
                <hr/>
            </div>
            <div id="loginContainerBody">
                <form action="{{route("loginConfirmation",$sms)}}" method="post">
                    @csrf
                    <label for="codeInputMobile"><small id="codeLableMobile">کد تایید برای شماره موبایل {{$sms->phone}} ارسال گردید</small>
                       
                    </label>
                    <br>
                    <input type="tel" id="codeInputMobile" autocomplete="off" name="code" required placeholder="----">
                    <br>
                    <div id="timerMobile"></div>
                    <div id="timerMobileLink">ارسال مجدد کد</div>
                    <button type="submit" id="loginButtonMobile">ورود</button>
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
            document.getElementById('timer').innerHTML =  "ارسال مجدد کد تا"+ --seconds_left +"ثانیه";
            document.getElementById('timerMobile').innerHTML = "ارسال مجدد کد تا"+ --seconds_left_mobile +"ثانیه";
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
            title: "خطا",
            text:  "لطفا کد ورود را به درستی وارد نمایید",
            icon: "error",
            button: "دوباره سعی کن",
        });
        @endif
    </script>
</body>
</html>