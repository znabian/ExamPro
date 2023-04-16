<!DOCTYPE html>
<html lang="{{App::getLocale()}}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="icon" type="image/x-icon" href="{{asset('favicon.ico')}}">
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
.forgotbtn
 {
    margin-top: 3%;
    color: #fb4f63;
    background: transparent;
    width: 100%;
    border: none;
    font-size: 16px;
    border-radius: 12px;
    font-family: "PeydaLight","Peyda";
    /* font-weight: bold; */
    cursor: pointer;
}
.passfild
{
    width: 100%;
    /* margin-top: 2%; */
    border: 1px solid #747A82;
    height: 5vh;
    text-align: center;
    border-radius: 2vw;

}
@media screen and (min-width: 577px)
{
    #loginDesktopContainer {
        margin-top: -15%!important;
    }
}
    </style>
    <style>
      
      .langselect--move.is-active {
        -webkit-animation: moveing 5s ease-out ;
                animation: moveing 5s ease-out ;
      }
      @-webkit-keyframes moveing {
        0% {
          top:0;
        }
        50% {
          top:30%;
        }
        80% {
            top:0;
            transform: rotate(-3deg);
            box-shadow: 0 2px 2px rgba(0, 0, 0, 0.2);
        }
        85% {
            transform: rotate(20deg);
        }
       90% {
            transform: rotate(-15deg);
        }
        95% {
            transform: rotate(5deg);
        }
        98% {
            transform: rotate(-1deg);
        }
        100% {
            transform: rotate(0);
            box-shadow: 0 2px 2px rgba(0, 0, 0, 0.2);
        }
      }
      
      @keyframes moveing {
        0% {
          top:0;
        }
        50% {
          top:30%;
        }
        80% {
            top:0;
            transform: rotate(-3deg);
            box-shadow: 0 2px 2px rgba(0, 0, 0, 0.2);
        }
        85% {
            transform: rotate(20deg);
        }
       90% {
            transform: rotate(-15deg);
        }
        95% {
            transform: rotate(5deg);
        }
        98% {
            transform: rotate(-1deg);
        }
        100% {
            transform: rotate(0);
            box-shadow: 0 2px 2px rgba(0, 0, 0, 0.2);
        }
      }
      
      
    </style>
</head>
<body id="loginBody">
    
<form id="chlang" action="{{route('chLang')}}" method="post">
    @csrf
    <select class=" @if(App::isLocale('fa')) langselect--move is-active @endif" name="language" onchange="chlang.submit();"  id='langselect'>
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
                <form method="post" action="{{route('login.pro')}}">
                    @csrf
                    <label for="phoneNumberInput">{{__('messages.شماره موبایل خود را وارد کنید')}}</label>
                    <br>
                    <input type="tel" id="phoneNumberInput" autocomplete="off" required name="phone" value="{{old('phone')}}">
                    <br>
                    <label for="">{{__('messages.رمزعبور خود را وارد کنید')}}</label>
                    <br>
                    <input type="password" class="passfild" autocomplete="off" required name="password">
                    <br>
                    <button type="submit" id="sendConfirmCodeButton">{{__('messages.ورود')}}</button>
                    
                </form> 
                <button id="btnForgotD" onclick="sendPassviaSms(phoneNumberInput.value,this)" class="forgotbtn">{{__('messages.فراموشی رمزعبور')}}</button>
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
                <form method="post" action="{{route('login.pro')}}">
                    @csrf
                <label for="phoneNumberInputMobile">{{__('messages.شماره موبایل خود را وارد کنید')}}</label>
                <br>
                <input type="tel" id="phoneNumberInputMobile" autocomplete="off" required name="phone" value="{{old('phone')}}">
                <br>
                <label for="">{{__('messages.رمزعبور خود را وارد کنید')}}</label>
                <br>
                <input type="password" class="passfild" autocomplete="off" required name="password">
                <br>
                <button type="submit" id="sendConfirmCodeButton">{{__('messages.ورود')}}</button>
                </form>
                <button id="btnForgotM" onclick="sendPassviaSms(phoneNumberInputMobile.value,this)" class="forgotbtn">{{__('messages.فراموشی رمزعبور')}}</button>
                
            </div>
        </div>
    </div>
    
    <script src="{{asset('js/app.js')}}"></script>
    <script>
        function sendPassviaSms(phone,obj)
        {
            obj.disabled=true;
            swal({
                    title: "{{__('messages.alert_wait.title')}}",
                    text:  "{{__('messages.alert_wait.body')}}",
                    icon: "info"
                });
            if(!phone)
            {
                swal({
                    title: "{{__('messages.خطا')}}",
                    text:  "{{__('messages.شماره موبایل وارد شده صحیح نمی باشد')}}",
                    icon: "error",
                    button: "{{__('messages.دوباره سعی کن')}}",
                });
            obj.disabled=false;
                return false;
            }
         var bodyFormData = new FormData();
        bodyFormData.append("phone", phone); 
        axios({
          method: "POST",
          url: "{{route('sendSms.pro')}}",
          data: bodyFormData,
          headers: {
            "Content-Type": "application/x-www-form-urlencoded"
          }
        }).then(function (response) {
            if(response.data.status)
            {
                swal({
                    title: "{{__('messages.عملیات موفقیت آمیز')}}",
                    text: response.data.msg,
                    icon: "info",
                });
            }
            else
            {
                swal({
                    title: "{{__('messages.خطا')}}",
                    text: response.data.msg,
                    icon: "error",
                });
            }
        }).catch(function (error) {
                swal({
                    title: "{{__('messages.خطا')}}",
                    text: "{{__('messages.مشکلی پیش آمده مجددا تلاش نمایید')}}",
                    icon: "error",
                });
          console.log(error);
        });
            obj.disabled=false;
      
        }
        @if($errors->any())
        swal({
            title: "{{__('messages.خطا')}}",
            text:  "{{__('messages.شماره موبایل وارد شده صحیح نمی باشد')}}",
            icon: "error",
            button: "{{__('messages.دوباره سعی کن')}}",
        });
        @endif
        @if(session()->has('err'))
        swal({
            title: "{{__('messages.خطا')}}",
            text:  "{{session('err')}}",
            icon: "error",
            button: "{{__('messages.دوباره سعی کن')}}",
        });
        @endif
    </script>
    <script> !function (t, e, n) { t.yektanetAnalyticsObject = n, t[n] = t[n] || function () { t[n].q.push(arguments) }, t[n].q = t[n].q || []; var a = new Date, r = a.getFullYear().toString() + "0" + a.getMonth() + "0" + a.getDate() + "0" + a.getHours(), c = e.getElementsByTagName("script")[0], s = e.createElement("script"); s.id = "ua-script-7DaHwwsc"; s.dataset.analyticsobject = n; s.async = 1; s.type = "text/javascript"; s.src = "https://cdn.yektanet.com/rg_woebegone/scripts_v3/7DaHwwsc/rg.complete.js?v=" + r, c.parentNode.insertBefore(s, c) }(window, document, "yektanet"); </script>
</body>
</html>