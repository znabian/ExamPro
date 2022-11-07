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
      .wait {
    text-align: center;
    direction: rtl;
    margin: 8% 0;
    background-color: white;
    display: none;
    padding: 3%;
    border-radius: 10px;
    }
        @media screen and (min-width: 577px)
        {
            #loginDesktopContainer {
            margin-top: -20%!important;
            }
        .videoplayer {
            margin: 2% auto;
            width: 85%;
            /* background: #fff; */
            height: 71%;
            border-radius: 20px 20px 0 0;
            padding: 3%;
        }
        video {
            width: 70%;
             height: 5%;
            /* margin: 1% 20%; */
            margin: 1% 13%;
        }
        }
        @media screen and (max-width: 577px)
        {
        .videoplayer {
            margin: 50% auto;
            width: 85%;
            /* background: #fff; */
            height: 71%;
            border-radius: 20px 20px 0 0;
            /* padding: 38% 6%; */

        }
        video {
            width: 100%;
            height: 5%;
            /* margin: 1% 10% */
        }
        } 
        
       /* @media screen and (max-width: 877px)
        {
        .videoplayer {
            margin: 10% auto;
            width: 85%;
            background: #fff;
            height: 71%;
            border-radius: 20px 20px 0 0;

        }
        video {
            height: 80%;
            margin: 1% 9%;
        }
        }*/
    </style>
</head>
<body id="loginBody" oncontextmenu="return false;">
    
    <div id="MobileComponents">
        <div id="KhoshNazarText" style="color:white;text-align: center;">
            سامانه رشد خوش نظر
        </div>   
        <p style="color:white;text-align: center;">برای شرکت در آزمون استعدادیابی حتما ویدیو را تا انتها مشاهده کنید</p>
        <div class="videoplayer">
        <h2 id="waitM" class="wait">شما در حال انتقال به صفحه اصلی هستید. لطفا کمی صبر کنید ...</h2>
            <video  controls controlsList="nodownload" oncontextmenu="return false;" id="plyM">
                <source src='https://dl.erfankhoshnazar.com/disc/pish.mp4'>
                Your browser does not support the video player.</video>
        </div>
    </div>
    <div id="DesktopComponents">
        <div id="KhoshNazarText">
            سامانه رشد خوش نظر
        </div>   
        <p style="color:white;text-align: center;">برای شرکت در آزمون استعدادیابی حتما ویدیو را تا انتها مشاهده کنید</p>
        <div class="videoplayer">
                <h2 id="waitD" class="wait">شما در حال انتقال به صفحه اصلی هستید. لطفا کمی صبر کنید ...</h2>
            <video  controls controlsList="nodownload" oncontextmenu="return false;" id="plyD">
                <source src='https://dl.erfankhoshnazar.com/disc/pish.mp4'>
                Your browser does not support the video player.</video>
        </div>
        
    </div>
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
        document.getElementById('plyD').addEventListener('ended',myPlayer,false);
        document.getElementById('plyM').addEventListener('ended',myPlayer,false);
        function myPlayer(e) {
            if(!e) { e = window.event; }
            document.getElementById('plyD').style.visibility="hidden";
            document.getElementById('plyM').style.visibility="hidden";
            document.getElementById('waitD').style.display="block";
            document.getElementById('waitM').style.display="block";
            @if(!in_array(1,explode(',',auth()->user()->status)))  
            axios.post("{{route('pish.ok')}}",{sts:1})
            .then(function ({data}) {
                    if(data.status)
                    location.href='/';
                    else
                    swal('خطا',"ذخیره اطلاعات با خطا مواجه شد لطفا مجددا تلاش کنید","error");
                    
                })
                .catch(error => {
                    swal('خطا',"ذخیره اطلاعات با خطا مواجه شد لطفا مجددا تلاش کنید","error");
                    location.reload();
                });
            @else
            location.href='/';
            @endif
        }
    </script>
</body>
</html>