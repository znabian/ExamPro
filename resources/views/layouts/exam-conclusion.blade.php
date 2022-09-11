<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('font/font-awesome/css/font-awesome.min.css')}}">
    <title>@yield('title')-سامانه رشد عرفان خوش نظر</title>
    <style>
        #MobileExamQuizeHeader{
            text-align: center;
        }
        #MobileExamQuizeHeader figure{
            text-align: center;
        }
        #MobileExamQuizeHeader img{
            width: 20%;
        }
        #MobileExamQuizeHeader figcaption{
            color: #F9FAFC;
            font-size:4vw;
            font-family: "PeydaRegular";
        }
        @media (max-width:576px) 
        {
            #MobileExamQuizeQuestionsContainer{
            max-width: 100%;
            background-color:#fff;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
            position:fixed;
            bottom:0;
            top:30vh;
            left:5%;
            right:5%;
            padding:4%;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
            overflow: hidden;
            overflow-y: scroll;
            }
        }
        @media (min-width:576px) 
        { 
            #MobileConclusionShow {
            display: block;
            }
            #MobileConclusionShowScore {
            display: block;
            }
            #MobileConclusionShowDescription {
            display: block;
            }
            #MobileConclusionShowGoBackButton {
            display: block;
            }
        #MobileExamQuizeQuestionsContainer{
            /* max-width: 100%; */
              max-width: 50%;
            background-color:#fff;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
            /* position:fixed;
            bottom:0;
            top:51vh;
            left:5%;
            right:5%; */
            padding:4%;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
            /* overflow: hidden;
            overflow-y: scroll; */
            overflow: auto;
            height: 13rem;
            margin: 0 auto;
            position: fixed;
            bottom: 0px;
            left: 5%;
            right: 5%;
        }
    }
    </style>
</head>
<body>
    <div id="MobileComponents">
        <x-mobile-menu />
        <div id="MobileExamQuizeHeader">
            <figure>
                <img src="{{asset("images/khoshNazar.png")}}">
                <figcaption>{{auth()->user()->phone}}</figcaption>
            </figure>
        </div>
        <div id="MobileExamQuizeQuestionsContainer" onscroll=" if(this.offsetHeight + this.scrollTop >= this.scrollHeight){mygift();}">
            @yield('content')
        </div>
    </div>
    <div id="DesktopComponents">
        <div id="MobileExamQuizeHeader">
            <figure>
                <img src="{{asset("images/khoshNazar.png")}}">
                <figcaption>{{auth()->user()->phone}}</figcaption>
            </figure>
        </div>
        <div id="MobileExamQuizeQuestionsContainer" onscroll=" if(this.offsetHeight + this.scrollTop >= this.scrollHeight){mygift();}">
            @yield('DesktopContent')
        </div>
    </div>
    @yield('mobileScript')
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
    </script>
</body>
</html>