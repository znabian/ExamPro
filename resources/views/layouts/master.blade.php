<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('font/font-awesome/css/font-awesome.min.css')}}">

    <title>@yield('title')-سامانه رشد عرفان خوش نظر</title>
</head>
<body>
    <div id="MobileComponents">
        <x-mobile-menu />
        @yield('content')
    </div>
    <div id="DesktopComponents" class="container">
      <div class="row">
        <div class="col-md-11" dir="rtl">
          <img src="{{asset('images/khoshNazar.png')}}" style="width:6%" alt="id"> |
          <span>@yield('name')</span>
        </div>
        <div class="col-md-9 mt-3" >
          @yield('DesktopContent')
        </div>
        <div id="DescktopMenue" class="col-md-2 p-3 m-3 rounded-4 text-center">
          <div style="display: grid; columns: auto auto; justify-content: center;">
            <img src="{{asset('images/khoshNazar.png')}}" style="width:5rem" alt="id">
             <b>@yield('name')</b>
          </div>
          
              <ul class="navbar-nav mr-auto text-end">
                <li class="nav-item active">
                  <a  class="nav-link" href="{{route('dashboard')}}">
                    خانه
                  <i class="fa fa-home"></i> </a>
                </li>
                <li  class="nav-item ">
                  <a class="nav-link" href="{{route('logout')}}">                    
                  خروج
                  <i class="fa fa-sign-out"></i></a>
                </li>
              </ul>
          {{-- <img src="{{asset('images/khoshNazar.png')}}" alt="id"> | --}}
          
        </div>
      </div>
    </div>
        
        <div id="KhoshNazarText">
            سامانه رشد خوش نظر
        </div>
        <div id="DesktopExamsExitButton" >
            <img src="{{asset('images/arrow.png')}}" alt="back">
            <a href="{{route('dashboard')}}">بازگشت</a>
        </div>
        <div id="DesktopExamsExitButton">
            <img src="{{asset('images/exitIcon.png')}}" alt="exit">
            <a href="{{route('logout')}}">خروج</a>
            </div>
        
    
    @yield('mobileScript')
    <script src="{{asset('js/app.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>
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
</body>
</html>