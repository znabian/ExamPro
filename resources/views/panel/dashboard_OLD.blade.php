@extends('layouts.app')
@section('title', 'داشبورد')
@section('content')
    <div id="MobileDashboardExamCategoryHeader">
        <span>{{auth()->user()->phone}}</span>
    </div>
    <div id="MobileDashboardExamCategoryContainer">
        <div id="MobileDashboardExamCategoryImage">
            <img src="{{asset('images/khoshNazar.png')}}" alt="{{auth()->user()->id}}">
        </div>
        <div id="MobileDashboardExamCategorySlider">
            <div class="slideshow-container">
                <div class="mySlides fade">
                  <img src="{{asset('images/imageSlider.png')}}" style="width:100%">
                </div>  
                {{-- <div class="mySlides fade">
                  <img src="{{asset('images/imageFirstSlider.png')}}" style="width:100%">
                </div>
                <div class="mySlides fade">
                  <img src="{{asset('images/imageFirstSlider.png')}}" style="width:100%">
                </div> 
                <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                <a class="next" onclick="plusSlides(1)">&#10095;</a> --}}
                </div>
                <br>
                <div id="mobileDotSlider" style="text-align:center">
                  <span class="dot"  style="display: none" onclick="currentSlide(1)"></span> 
                  {{-- <span class="dot" onclick="currentSlide(2)"></span> 
                  <span class="dot" onclick="currentSlide(3)"></span>  --}}
                </div>
        </div>
        @if(is_null(session('chk')))
        <div class="MobileCategoryContainer" onclick="openIdentityExamsPage()">
            <img src="{{asset('images/redArrow.png')}}" alt="red" style="max-width:8%;">
            <div class="categoryData">
                <img class="categoryDataImages" src="{{asset('images/childrenExam.png')}}">
                <hr>
                <div class="categoryDataText">
                    <span class="categoryDataExamTitle">استعدادیابی کودک</span>
                    <span class="categoryDataExamDescription">{{__('messages.رده سنی',["min"=>"شش","max"=>"سیزده"])}}</span>
                </div>
            </div>
        </div>
        <div class="MobileCategoryContainer" onclick="openSuggestionExamsPage()">
            <img src="{{asset('images/redArrow.png')}}" alt="red" style="max-width:8%;">
            <div class="categoryData">
                <img class="categoryDataImages" src="{{asset('images/discussExams.png')}}">
                <hr>
                <div class="categoryDataText">
                    <span class="categoryDataExamTitle">آزمون های پیشنهادی</span>
                    <span class="categoryDataExamDescription">والدین</span>
                </div>
            </div>
        </div>
        @endif
        @php
            $ex=\App\Models\Exam::find(6);
        @endphp
        @if($ex)
        <div class="MobileCategoryContainer" onclick="location.href='{{route('myinfo',$ex->id)}}'">
            <img src="{{asset('images/redArrow.png')}}" alt="red" style="max-width:8%;">
            <div class="categoryData">
                <img class="categoryDataImages" src="{{asset('images/love.png')}}">
                <hr>
                <div class="categoryDataText">
                    <span class="categoryDataExamTitle">{{$ex->name}}</span>
                    <span class="categoryDataExamDescription">{{$ex->ageRange}}</span>
                  
                </div>
            </div>
        </div>
        @endif
        @if(is_null(session('chk')))
        <div class="MobileCategoryContainer" style="border:1px solid #707070;">
            <img src="{{asset('images/grayArrow.png')}}" alt="red" style="max-width:8%;">
            <div class="categoryData">
                <img class="categoryDataImages" src="{{asset('images/allExamsBlack.png')}}" style="max-width:24%;">
                <hr>
                <div class="categoryDataText">
                    <span class="categoryDataExamTitle">تمامی آزمون ها</span>
                    <span class="categoryDataExamDescription">والدین و کودکان</span>
                </div>
            </div>
        </div>
        @endif
    </div>
    <div id="MobileDashboardExamFooterButton">
        <div id="MobileDashboardExamFooterButtonText" style="font-size: 9pt;">
            {{-- دسترسی به پادکست ها ویدئوهای آموزشی --}}
            تمامی آزمون های این سامانه رایگان می باشد!
        </div>
        {{-- <div id="MobileDashboardExamFooterButtonIcon">
            <img src="{{asset('images/arrow.png')}}" alt="arrow">
        </div> --}}
    </div>
    {{-- <div id="MobileDashboardExamExitButton">
        <img src="{{asset('images/exitIcon.png')}}" alt="exit">
        <a href="{{route('logout')}}">{{__('messages.خروج')}}</a>
    </div> --}}
@endsection
@section('DesktopContent')
    <div id="DesktopDashboardExamCategoryHeader">
        <span>{{auth()->user()->phone}}</span>
    </div>
    <div id="DesktopDashboardExamCategoryContainer">
        <div id="DesktopDashboardExamCategoryImage">
            <img src="{{asset('images/khoshNazar.png')}}" alt="id">
        </div>
        @if(is_null(session('chk')))
        <div class="DesktopCategoryContainer" onclick="openIdentityExamsPage()">
            <img src="{{asset('images/redArrow.png')}}" alt="red" style="max-width:3%;">
            <div class="categoryData">
                <img class="categoryDataImages" src="{{asset('images/childrenExam.png')}}">
                <hr>
                <div class="categoryDataText">
                    <span class="categoryDataExamTitle">استعدادیابی کودک</span>
                    <span class="categoryDataExamDescription">{{__('messages.رده سنی',["min"=>"شش","max"=>"سیزده"])}}</span>
                </div>
            </div>
        </div>
        <div class="DesktopCategoryContainer" onclick="openSuggestionExamsPage()">
            <img src="{{asset('images/redArrow.png')}}" alt="red" style="max-width:3%;">
            <div class="categoryData">
                <img class="categoryDataImages" src="{{asset('images/discussExams.png')}}">
                <hr>
                <div class="categoryDataText">
                    <span class="categoryDataExamTitle">آزمون های پیشنهادی</span>
                    <span class="categoryDataExamDescription">والدین</span>
                </div>
            </div>
        </div>
        @endif
        @php
            $ex=\App\Models\Exam::find(6);
        @endphp
        @if($ex)
        <div class="DesktopCategoryContainer" onclick="location.href='{{route('myinfo',$ex->id)}}'">
            <img src="{{asset('images/redArrow.png')}}" alt="red" style="max-width:3%;">
            <div class="categoryData">
                <img class="categoryDataImages" src="{{asset('images/love.png')}}">
                <hr>
                <div class="categoryDataText">
                    <span class="categoryDataExamTitle">{{$ex->name}}</span>
                    <span class="categoryDataExamDescription">{{$ex->ageRange}}</span>
                  
                </div>
            </div>
        </div>
        @endif
        @if(is_null(session('chk')))
        <div class="DesktopCategoryContainer disabled"  style="border:1px solid #707070;">
            <img src="{{asset('images/grayArrow.png')}}" alt="red" style="max-width:3%;">
            <div class="categoryData">
                <img class="categoryDataImages" src="{{asset('images/allExamsBlack.png')}}" style="max-width:24%;">
                <hr>
                <div class="categoryDataText">
                    <span class="categoryDataExamTitle">تمامی آزمون ها</span>
                    <span class="categoryDataExamDescription">والدین و کودکان</span>
                </div>
            </div>
        </div>
        @endif
    </div>
    <div id="DesktopDashboardExamFooterButton">
        <div id="DesktopDashboardExamFooterButtonText">
            {{-- دسترسی به پادکست ها ویدئوهای آموزشی --}}
            تمامی آزمون های این سامانه رایگان می باشد!
        </div>
        {{-- <div id="DesktopDashboardExamFooterButtonIcon">
            <img src="{{asset('images/arrow.png')}}" alt="arrow">
        </div> --}}
    </div>
   
   
@endsection
@section('mobileScript')
<script>
    var slideIndex = 1;
    showSlides(slideIndex);
    
    function plusSlides(n) {
      showSlides(slideIndex += n);
    }
    
    function currentSlide(n) {
      showSlides(slideIndex = n);
    }
    
    function showSlides(n) {
      var i;
      var slides = document.getElementsByClassName("mySlides");
      var dots = document.getElementsByClassName("dot");
      if (n > slides.length) {slideIndex = 1}    
      if (n < 1) {slideIndex = slides.length}
      for (i = 0; i < slides.length; i++) {
          slides[i].style.display = "none";  
      }
      for (i = 0; i < dots.length; i++) {
          dots[i].className = dots[i].className.replace(" active", "");
      }
      slides[slideIndex-1].style.display = "block";  
      dots[slideIndex-1].className += " active";
    }
    function openIdentityExamsPage(){
        window.location.href = "/identify/exams";
    }
    function openSuggestionExamsPage(){
        window.location.href = "/suggest/exams";
    }
    </script>
@endsection
<style>
    @media (max-width:576px) {

        #DesktopComponents
            {
                display: none;
            }
        }
</style>