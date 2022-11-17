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
@php
   switch ($st) {
            case 1:
               $url="https://dl.erfankhoshnazar.com/disc/pish.mp4";
                break;
            case 5:
                $url='http://dl.erfankhoshnazar.com/etemad%20be%20nafs/Mvi%202648%201.mp4%20%DA%A9%D9%85%20%D8%AD%D8%AC%D9%85%20%D8%A7%D8%B9%D8%AA%D9%85%D8%A7%D8%AF%20%D8%A8%D9%87%20%D9%86%D9%81%D8%B3.mp4';
                break;
            case 6:
                $url='https://dl.erfankhoshnazar.com/2b/ab.mp4';
                break;
        }
@endphp
<body id="loginBody" oncontextmenu="return false;">
    
    <div id="MobileComponents">
        <div id="KhoshNazarText" style="color:white;text-align: center;">
            سامانه رشد خوش نظر
        </div>
        @if($st==1)   
        <p style="color:white;text-align: center;">برای شرکت در آزمون استعدادیابی حتما ویدیو را تا انتها مشاهده کنید</p>
        @endif
        <div class="videoplayer">
        <h2 id="waitM" class="wait">شما در حال انتقال به صفحه قبلی هستید. لطفا کمی صبر کنید ...</h2>
            <video  controls controlsList="nodownload" oncontextmenu="return false;" id="plyM">
                <source src='{{$url}}'>
                Your browser does not support the video player.</video>
        </div>
    </div>
    <div id="DesktopComponents">
        <div id="KhoshNazarText">
            سامانه رشد خوش نظر
        </div>   
        @if($st==1)   
        <p style="color:white;text-align: center;">برای شرکت در آزمون استعدادیابی حتما ویدیو را تا انتها مشاهده کنید</p>
        @endif
        <div class="videoplayer">
                <h2 id="waitD" class="wait">شما در حال انتقال به صفحه قبلی هستید. لطفا کمی صبر کنید ...</h2>
            <video  controls controlsList="nodownload" oncontextmenu="return false;" id="plyD">
                <source src='{{$url}}'>
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

        let timerD = timerM=null;
        var totalTimeD = totalTimeM =0;
         
         var flag=false;

        plyD.addEventListener("play", startPlaying);
        plyD.addEventListener("pause", pausePlaying);
        plyM.addEventListener("play", startPlaying);
        plyM.addEventListener("pause", pausePlaying);

         function converttime(secend)
         {
            var sec_num = parseInt(secend, 10); 
            var hours   = Math.floor(sec_num / 3600);
            var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
            var seconds = sec_num - (hours * 3600) - (minutes * 60);

            // if (hours   < 10) {hours   = "0"+hours;}
            // if (minutes < 10) {minutes = "0"+minutes;}
            // if (seconds < 10) {seconds = "0"+seconds;}
            return [hours,minutes,seconds];
         }

        function startPlaying() {
            Duration=converttime(plyM.duration);
        timerD = window.setInterval(function() {
            totalTimeD =converttime(plyD.currentTime);
        }, 10);
        timerM = window.setInterval(function() {
            totalTimeM =converttime(plyM.currentTime); 
        }, 10);
        
            timer = window.setInterval(function() {
            if(totalTimeD[0]== Duration[0] && parseInt(totalTimeD[1])>= parseInt(Duration[1])-3)
            {
                            clearInterval(timer);
                axios.post("{{route('pish.ok')}}",{sts:{{$st}}})
                .then(function ({data}) {
                        if(data.status)
                        {
                            flag=true;
                        }
                        
                    })
                    .catch(error => {
                    });
            }            
           
        }, 10);
        }

        
            

        function pausePlaying() {
        if (timerD) clearInterval(timerD);
        if (timerD) clearInterval(timerD);
        //if (timer) clearInterval(timer);
        }

        document.getElementById('plyD').addEventListener('ended',myPlayer,false);
        document.getElementById('plyM').addEventListener('ended',myPlayer,false);

        function myPlayer(e) {
            if(!e) { e = window.event; }
            document.getElementById('plyD').style.visibility="hidden";
            document.getElementById('plyM').style.visibility="hidden";
            document.getElementById('waitD').style.display="block";
            document.getElementById('waitM').style.display="block";
            @if(!in_array($st,explode(',',auth()->user()->status)))  
            if(!flag)
                axios.post("{{route('pish.ok')}}",{sts:"{{$st}}"})
                .then(function ({data}) {
                        if(data.status)
                        @if(!in_array(4,explode(',',auth()->user()->status))) 
                        location.href='/';
                        @else
                        location.href='/Exams-Result/';
                        @endif
                        else
                        swal('خطا',"ذخیره اطلاعات با خطا مواجه شد لطفا مجددا تلاش کنید","error");
                        
                    })
                    .catch(error => {
                        swal('خطا',"ذخیره اطلاعات با خطا مواجه شد لطفا مجددا تلاش کنید","error");
                        location.reload();
                    });
            else           
            @if(!in_array(4,explode(',',auth()->user()->status))) 
            location.href='/';
            @else
            location.href='/Exams-Result/';
            @endif
            
            @else
            
                @if(!in_array(4,explode(',',auth()->user()->status))) 
                location.href='/';
                @else
                location.href='/Exams-Result/';
                @endif
            @endif
        }
    </script>
</body>
</html>