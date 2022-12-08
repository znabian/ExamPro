<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('font/font-awesome/css/font-awesome.min.css')}}">
    <title>@yield('title')-سامانه رشد عرفان خوش نظر</title>
    <style>
        
    </style>
   @yield('style')
</head>
<body>
    <div class="app">
        <div class="container">

            <div class="row">
                <div class="col-12 d-flex align-items-center justify-content-end mt-2">
                    <a href="{{route('dashboard')}}" class="bg-red-1 shadow-red-1 prevbtn rounded-circle mx-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="19" viewBox="0 0 8.52 14.212">
                            <g transform="translate(1.414 1.414)">
                                <line x1="5.692" y2="5.692" fill="none" stroke="#fff" stroke-linecap="round"
                                    stroke-width="2" />
                                <line x2="5.692" y2="5.692" transform="translate(0 5.692)" fill="none" stroke="#fff"
                                    stroke-linecap="round" stroke-width="2" />
                            </g>
                        </svg>
                    </a>
                    <a href="{{route('logout')}}" class="bg-white shadow-red-1 prevbtn rounded-circle mx-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 12.382 12.382">
                            <path
                                d="M17.35,18.382a1.058,1.058,0,0,0,1.032-1.032V7.032A1.058,1.058,0,0,0,17.35,6h-5V7.032h5V17.35h-5v1.032ZM8.992,15.2l.74-.739L7.978,12.707H14V11.675H8.012L9.766,9.921l-.739-.739L6,12.208Z"
                                transform="translate(-6 -6)" fill="#db152b" />
                        </svg>
                    </a>
                </div>
            </div>

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
            @yield('content')

        </div>
    </div>

<!-- Sweetalert2 -->
{{-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
    <script src="{{asset('js/jquery-3.6.1.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('js/popper.min.js')}}"></script>
    <script src="{{asset('js/app.js')}}"></script>
    @yield('mobileScript')  
    <script>
       
    $(document).ready(function(){
        $('.icon-video').click(function () {
            if(videoRes.paused){
                videoRes.play();
                videoRes.classList.remove('blurEffect');
                $('.icon-video').hide();
            }
        });
    
        $('#videoRes').on('ended',function(){
            $(this).addClass('blurEffect');
          $('.icon-video').show();
        });
        $('#videoRes').on('play',function(){
                videoRes.classList.remove('blurEffect');
                $('.icon-video').hide();
        });
         videoRes.addEventListener("pause", pausePlaying);
    })
    function pausePlaying() {
        $('.icon-video').show();
                videoRes.classList.add('blurEffect');
        }
    </script> 
</body>
</html>