@extends('layouts.master')
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
                 <span class="dot" style="display: none" onclick="currentSlide(1)"></span> 
                  {{--  <span class="dot" onclick="currentSlide(2)"></span> 
                  <span class="dot" onclick="currentSlide(3)"></span>  --}}
                </div>
        </div>
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
    </div>
    <div id="MobileDashboardExamFooterButton">
        <div id="MobileDashboardExamFooterButtonText">
            دسترسی به پادکست ها ویدئوهای آموزشی
        </div>
        <div id="MobileDashboardExamFooterButtonIcon">
            <img src="{{asset('images/arrow.png')}}" alt="arrow">
        </div>
    </div>
    {{-- <div id="MobileDashboardExamExitButton">
        <img src="{{asset('images/exitIcon.png')}}" alt="exit">
        <a href="{{route('logout')}}">{{__('messages.خروج')}}</a>
    </div> --}}
@endsection
@section('name')
{{auth()->user()->firstName??auth()->user()->phone}}
@endsection
@section('DesktopContent')
    {{-- <div id="DesktopDashboardExamCategoryHeader" style="color: #7070;">
        <img src="{{asset('images/khoshNazar.png')}}" alt="id"> |
         <span>{{auth()->user()->phone}}</span>
    </div>--}}
    <div>
        <img style="width:100%" src="{{asset('images/imageSlider.png')}}" >
    </div> 
    <div id="DesktopDashboardExamCategoryContainer">
        <div id="DesktopDashboardExamCategoryImage">
            <img src="{{asset('images/khoshNazar.png')}}" alt="id">
        </div>
     
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
    </div>
    <div id="DesktopDashboardExamFooterButton">
        <div id="DesktopDashboardExamFooterButtonText">
            دسترسی به پادکست ها ویدئوهای آموزشی
        </div>
        <div id="DesktopDashboardExamFooterButtonIcon">
            <img src="{{asset('images/arrow.png')}}" alt="arrow">
        </div>
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