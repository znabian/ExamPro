@extends('layouts.exam-Result')
@section('style')
<style>
    @media (min-width: 768px) {
    .cardd {
    width: 15rem;
    height: 6rem;
    }
    .img-sh {
    top: -66px;
    right: 23px;
    width: 30%;
    }
}
</style>
@endsection
@section('content')
@php
$nodownload="download";
   switch ($st) {
            case 1:
               $url="https://dl.erfankhoshnazar.com/disc/".App::getLocale()."/pish.mp4";
               $txt=__('messages.پیش نیاز استعدادیابی');
                break;
            case 5:
                $url='http://dl.erfankhoshnazar.com/etemad%20be%20nafs/'.App::getLocale().'/Mvi%202648%201.mp4%20%DA%A9%D9%85%20%D8%AD%D8%AC%D9%85%20%D8%A7%D8%B9%D8%AA%D9%85%D8%A7%D8%AF%20%D8%A8%D9%87%20%D9%86%D9%81%D8%B3.mp4';
               $txt=__('messages.افزایش اعتماد به نفس');$nodownload="nodownload";
                break;
            case 6:
                $url='https://dl.erfankhoshnazar.com/2b/'.App::getLocale().'/ab.mp4';
               $txt=__('messages.افزایش علاقه مندی به یادگیری');$nodownload="nodownload";
                break;
        }
@endphp
<div class="row mt-6 mb-3 px-3">
    <div class="col-12 w-100 h-100 px-0 position-relative">
        <div class="check radius-12 bg-green-1 position-absolute">
            <img src="{{asset('images/check.png')}}" width="25px" class="img-fluid" alt="">
            <span class="text-white fw-bold">{{$txt}}</span>
        </div>
        <div class="video position-relative radius-12">
            <video id="videoRes" class="blurEffect w-100" width="100%" controls  controlsList="{{$nodownload}}" oncontextmenu="return false;">
                <source src="{{$url}}" type="video/mp4">
                Your browser does not support HTML video.
            </video>
            <span class="icon-video"></span>
        </div>
    </div>
        @if($st==1)   
        <p style="color:white;text-align: center;">{{__('messages.watchvideo')}}</p>
        <button id="errorbtn" onclick="okchstatus()" class="btn btn-outline-warning m-auto w-auto d-none">{{__('messages.watchvideoerr')}}</button>
        @endif
</div>
@endsection
@section('mobileScript')
    <script>
        function openNav() {
            document.getElementById("mySidebar").style.width = "70%";
            document.getElementById("main").style.marginLeft = "70%";
        }
        function closeNav() {
            document.getElementById("mySidebar").style.width = "0";
            document.getElementById("main").style.marginLeft = "0";
        }  

        let timerD = timer2=null;
        var totalTimeD = ctmer =0;
         
         var flag=false;

        videoRes.addEventListener("play", startPlaying);
        videoRes.addEventListener("pause", pausePlaying);

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
            @if(!in_array(1,explode(',',auth()->user()->status))) 
                 if(ctmer==0)
                 { 
                    ctmer=1;
                    axios.post("{{route('pish.ok')}}",{sts:"1"})
                        .then(function ({data}) {
                                if(data.status)
                                flag=true;
                                
                            })
                            .catch(error => {
                                ctmer=0;
                            });
                }
            @endif
            Duration=converttime(videoRes.duration);
        timerD = window.setInterval(function() {
            totalTimeD =converttime(videoRes.currentTime);
        }, 10);
        
        @if(!in_array($st,explode(',',auth()->user()->status))) 
            timer2 = window.setInterval(function() {
            if(totalTimeD[0]== Duration[0] && parseInt(totalTimeD[1])>= parseInt(Duration[1])-3)
            {
                 clearInterval(timer2);
                 if(ctmer==0)
                 {
                    ctmer=1;
                    axios.post("{{route('pish.ok')}}",{sts:{{$st}}})
                    .then(function ({data}) {
                            if(data.status)
                            {
                                flag=true;
                            }
                            
                        })
                        .catch(error => {
                            ctmer=0;
                        });
                }
            }            
           
        }, 10);
        @endif
        }

        function pausePlaying() {
        if (timerD) clearInterval(timerD);
        //if (timer) clearInterval(timer);
        }

        document.getElementById('videoRes').addEventListener('ended',myPlayer,false);

        function myPlayer(e) {
            if(!e) { e = window.event; }
            /*document.getElementById('videoRes').style.visibility="hidden";
            document.getElementById('waitD').style.display="block";*/
            swal('{{__('messages.alert_wait.title')}}',"{{__('messages.moveback')}} ",'warning');
            @if(!in_array($st,explode(',',auth()->user()->status)))  
            if(!flag)
                axios.post("{{route('pish.ok')}}",{sts:"{{$st}}"})
                .then(function ({data}) {
                        if(data.status)
                        @if(!in_array(4,explode(',',auth()->user()->status))) 
                        location.href='{{route("dashboard")}}';
                        @else
                        location.href='{{route("dashboard")}}/Exams-Result/';
                        @endif
                        else
                        swal('{{__('messages.خطا')}}',"{{__('messages.errorSave')}} ","error");
                        
                    })
                    .catch(error => {
                        swal('{{__('messages.خطا')}}',"{{__('messages.errorSave')}} ","error");
                        location.reload();
                    });
            else           
            @if(!in_array(4,explode(',',auth()->user()->status))) 
            location.href='{{route("dashboard")}}';
            @else
            location.href='{{route("dashboard")}}/Exams-Result/';
            @endif
            
            @else
            
                @if(!in_array(4,explode(',',auth()->user()->status))) 
                location.href='{{route("dashboard")}}';
                @else
                location.href='{{route("dashboard")}}/Exams-Result/';
                @endif
            @endif
        }
        @if(!in_array(1,explode(',',auth()->user()->status)))  
        var video = document.getElementById("videoRes");

        if ( video.readyState!= 4 ) {
           document.getElementById("errorbtn").classList.remove('d-none');
        }
        function okchstatus()
        {
            swal('{{__('messages.alert_wait.title')}}'," {{__('messages.alert_wait.body')}} ...",'warning');
            if(!flag)
            {
                axios.post("{{route('pish.ok')}}",{sts:"1"})
                .then(function ({data}) {
                        if(data.status)
                        @if(!in_array(4,explode(',',auth()->user()->status))) 
                        location.href='{{route("dashboard")}}';
                        @else
                        location.href='{{route("dashboard")}}/Exams-Result/';
                        @endif
                        else
                        swal('{{__('messages.خطا')}}',"{{__('messages.errorSave')}} ","error");
                        
                    })
                    .catch(error => {
                        swal('{{__('messages.خطا')}}',"{{__('messages.errorSave')}} ","error");
                        location.reload();
                    });
            }
            else
            {
                @if(!in_array(4,explode(',',auth()->user()->status))) 
                    location.href='{{route("dashboard")}}';
                @else
                    location.href='{{route("dashboard")}}/Exams-Result/';
                @endif
            }
        }
        @endif
        function okchstatus()
        {
            swal('{{__('messages.alert_wait.title')}}'," {{__('messages.alert_wait.body')}} ...",'warning');
            if(!flag)
            {
                axios.post("{{route('pish.ok')}}",{sts:"1"})
                .then(function ({data}) {
                        if(data.status)
                        @if(!in_array(4,explode(',',auth()->user()->status))) 
                        location.href='{{route("dashboard")}}';
                        @else
                        location.href='{{route("dashboard")}}/Exams-Result/';
                        @endif
                        else
                        swal('{{__('messages.خطا')}}',"{{__('messages.errorSave')}} ","error");
                        
                    })
                    .catch(error => {
                        swal('{{__('messages.خطا')}}',"{{__('messages.errorSave')}} ","error");
                        location.reload();
                    });
            }
            else
            {
                @if(!in_array(4,explode(',',auth()->user()->status))) 
                    location.href='{{route("dashboard")}}';
                @else
                    location.href='{{route("dashboard")}}/Exams-Result/';
                @endif
            }
        }
    </script>
     @if($st==1)  
    <script>
     var dnone= setTimeout(function(){
        document.getElementById("errorbtn").classList.remove('d-none');
        clearInterval(dnone);
    }
    ,10000);
    </script>
    @endif
@endsection