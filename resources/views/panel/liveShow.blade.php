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
            case 'ai':
                $url='https://dl.erfankhoshnazar.com/camps/ai.mp4';
               $txt="هوش مصنوعی";$nodownload="nodownload";
                break;
            case 'mohajerat':
                $url='https://dl.erfankhoshnazar.com/camps/mohajerat.mp4';
               $txt="مهاجرت";$nodownload="nodownload";
                break;
            case 'live':
                $url='https://dl.erfankhoshnazar.com/camps/live.mp4';
               $txt="کارمندان دلاری";$nodownload="nodownload";
                break;
            case 'youtube':
                $url='https://dl.erfankhoshnazar.com/camps/youtube.mp4';
               $txt="یوتوب";$nodownload="nodownload";
                break;
            case 'bigari':
                $url='https://dl.erfankhoshnazar.com/camps/bigari.mp4';
               $txt="بیگاری دانش آموز";$nodownload="nodownload";
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
        <p style="color:white;text-align: center;">برای شرکت در آزمون استعدادیابی حتما ویدیو را تا انتها مشاهده کنید</p>
                <button id="errorbtn" onclick="okchstatus()" class="btn btn-outline-warning m-auto w-auto d-none">در مشاهده ویدیو مشکلی است؟</button>
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
    </script>
@endsection