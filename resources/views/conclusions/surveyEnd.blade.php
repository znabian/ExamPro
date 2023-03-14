<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('font/font-awesome/css/font-awesome.min.css')}}">
    <title>سامانه رشد عرفان خوش نظر</title>
    <style>
        
    </style>
<style>
    @media (min-width: 768px) {
    .cardd {
    width: 15rem;
    /* height: 6rem; */
    }
    .img-sh {
    top: -66px;
    right: 23px;
    width: 30%;
    }
    .app {
    background-image: url(../images/desktopHeader.png);
    background-repeat: no-repeat;
    background-size: contain;
    min-height: inherit;
    padding: 10px;
    background-attachment: fixed;
}
.noimg
{
    right: -8%;
    top: -21%;
}

.accordion-button
{
    font-size: 1rem!important;
}
}
.noimg
{
    position: absolute;
}

.accordion-button
{
    font-size: 10pt;
}
</style>
</head>
<body>
    <div class="app">
        <div class="container">
            <div class="row align-items-center justify-content-center my-5 px-3">
                <div
                    class="col-12 d-flex align-items-center justify-content-center bg-red-1 radius-12 shadow-dark-1 py-4 px-2">
                    <img src="{{asset('images/logo2.png')}}" width="75px" height="75px" class=" img-fluid" alt="">
                    <div class="d-flex flex-column align-items-center">
                        <h1 class="fs-6 text-white border-bottom border-white pb-2">سامانه رشد خوش نظر</h1>
                        <a href="#" class="fs-6 text-white d-flex">

                        {{auth()->user()->phone}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="me-1" width="17" height="17"
                                viewBox="0 0 9.212 14.475">
                                <path
                                    d="M10.987,16.475A1.012,1.012,0,0,1,10,15.488V2.987a.947.947,0,0,1,.3-.691.947.947,0,0,1,.691-.3h7.238a.947.947,0,0,1,.691.3.947.947,0,0,1,.3.691v12.5a1.012,1.012,0,0,1-.987.987Zm0-2.467v1.48h7.238v-1.48Zm3.619,1.234a.478.478,0,1,0-.354-.14A.479.479,0,0,0,14.606,15.242Zm-3.619-2.221h7.238V4.467H10.987Zm0-9.541h7.238V2.987H10.987Zm0,10.527v0Zm0-10.527v0Z"
                                    transform="translate(-10 -2)" fill="#fff" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

<div class="row mt-6 mb-3 px-3">
    <div class="col-12 w-100 h-100 p-5 position-relative card">
        <img src="{{asset('images/khoshNazar.png')}}" class="w-25 img-sh noimg" alt="">
            <h3 class=" text-center">برای شرکت در نظر سنجی از شما سپاس گزاریم</h3>
    <h5 class="col-md-8 m-auto text-center">برای اینکه در ارتقا محصولات ما را همراهی میکنید بسیار مفتخریم.
         نظرات شما ذخیره و توسط کارشناسان خبره ما بررسی می شوند  تا بهترین محصولات آموزشی رو برای شما و فرزندانتان به ارمغان بیاوریم</h5>
        
   
            
    </div>
    <button class="btn btn-dark" onclick="location.href='{{route('logout')}}'">خروج</button>
</div>
</div>
</div>

</body>
</html>