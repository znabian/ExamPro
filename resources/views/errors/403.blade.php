<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <meta name="yn-tag" id="2fd2bba1-bc29-4b11-aa83-a176672cd88b">
    <title> سامانه رشد خوش نظر </title>
    <style>
     @import url("https://fonts.googleapis.com/css?family=Lato");
     @font-face {
    font-family: "PeydaMedium";
    src: url("/../font/Peyda-Medium.ttf");
}
* {
  position: relative;
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Lato", "PeydaMedium";
}

body {
  height: 100vh;
  display: flex;
  text-align: center;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  /*background: linear-gradient(to bottom right, #EEE, #AAA);*/
  background-image: linear-gradient(to right, #F64162, #ff5865);
  /* color:white;*/
} 

h1 {
  margin: 40px 0 20px;
}

.lock {
  border-radius: 5px;
  width: 55px;
  height: 45px;
  background-color: #fff;
  animation: dip 1s;
  animation-delay: 1.5s;
}
.lock::before, .lock::after {
  content: "";
  position: absolute;
  border-left: 5px solid #fff;
  height: 20px;
  width: 15px;
  left: calc(50% - 12.5px);
}
.lock::before {
  top: -30px;
  border: 5px solid #fff;
  border-bottom-color: transparent;
  border-radius: 15px 15px 0 0;
  height: 30px;
  animation: lock 2s, spin 2s;
}
.lock::after {
  top: -10px;
  border-right: 5px solid transparent;
  animation: spin 2s;
}

@keyframes lock {
  0% {
    top: -45px;
  }
  65% {
    top: -45px;
  }
  100% {
    top: -30px;
  }
}
@keyframes spin {
  0% {
    transform: scaleX(-1);
    left: calc(50% - 30px);
  }
  65% {
    transform: scaleX(1);
    left: calc(50% - 12.5px);
  }
}
@keyframes dip {
  0% {
    transform: translateY(0px);
  }
  50% {
    transform: translateY(10px);
  }
  100% {
    transform: translateY(0px);
  }
}
    </style>
</head>
<body>
    <!-- partial:index.partial.html -->
    {{-- <div class="lock"></div> --}}
    <img src="{{asset('images/sad404.svg')}}" alt="404" style="max-height: 17rem;">
    <div class="message">
        @if(session('error'))
        <h2>{{session('error')}}</h2>
        @else
        <h2>شما مجوز دسترسی به این صفحه را ندارید</h2>
         @endif
      <p>لطفا با پشتیبان خود تماس بگیرید</p>
     
    </div>
    
</body>
</html>