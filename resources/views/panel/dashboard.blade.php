@extends('layouts.exam-Result')
@section('title', 'داشبورد')
@section('content')
        
<div class="justify-content-center m-auto mb-3 mt-6 px-3 row w-auto gap-1">
        @if(is_null(session('chk')))
        <div class="col-12 bg-light d-inline-flex btn rounded"  onclick="showvideo(1)">
            {{-- @if(in_array(1,explode(',',auth()->user()->status))) disabled @else " onclick="showvideo(1)@endif" --}}
            
                <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" class="mt-md-4" style="width: 5%; ">
                 <circle fill="#ec1e50" cx="20" cy="20" r="20" style=""></circle>
                </svg>
                <div class="categoryDataText text-center d-grid" >
                    <span class="categoryDataExamTitle">{{__('messages.پیش نیاز استعدادیابی')}}</span>
                </div>
                <img src="{{asset('images/redArrow.png')}}" alt="red" class="mt-md-4" style="height: 2rem;">

        </div>
        <div class=" col-12 bg-light d-inline-flex btn rounded @if(!in_array(1,explode(',',auth()->user()->status))) opacity-50 noclcik @endif" @if(!in_array(1,explode(',',auth()->user()->status))) onclick="swal('{{__('messages.خطا')}}','{{__('messages.alert_wait.seevideo')}}','error')" @else onclick="location.href='{{route('myinfo',4)}}';" @endif  >
            {{-- @if(in_array(1,explode(',',auth()->user()->status))) disabled @else " onclick="showvideo(1)@endif" --}}
            
                <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" class="mt-md-4" style="width: 5%; ">
                 <circle fill="#ec1e50" cx="20" cy="20" r="20" style=""></circle>
                </svg>
                <div class="categoryDataText text-center d-grid" >
                    <span class="categoryDataExamTitle">{{__('messages.استعدادیابی دانش آموز')}}</span>
                    <span class="text-secondary small"> {{__('messages.رده سنی',["min"=>7,"max"=>12])}}</span>
                </div>
                <img src="{{asset('images/redArrow.png')}}" alt="red" class="mt-md-4" style="height: 2rem;">

        </div>
        <div class=" col-12 bg-light d-inline-flex btn rounded @if(!in_array(1,explode(',',auth()->user()->status))) opacity-50 noclcik @endif" @if(!in_array(1,explode(',',auth()->user()->status))) onclick="swal('{{__('messages.خطا')}}','{{__('messages.alert_wait.seevideo')}}','error')" @else onclick="location.href='{{route('myinfo',6)}}';" @endif  >
            {{-- @if(in_array(1,explode(',',auth()->user()->status))) disabled @else " onclick="showvideo(1)@endif" --}}
            
                <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" class="mt-md-4" style="width: 5%; ">
                 <circle fill="#ec1e50" cx="20" cy="20" r="20" style=""></circle>
                </svg>
                <div class="categoryDataText text-center d-grid" >
                    <span class="categoryDataExamTitle">{{__('messages.استعدادیابی نوجوان')}}</span>
                    <span class="text-secondary small"> {{__('messages.رده سنی',["min"=>"13","max"=>"18"])}}</span>
                </div>
                <img src="{{asset('images/redArrow.png')}}" alt="red" class="mt-md-4" style="height: 2rem;">

        </div>
        <div class=" col-12 bg-light d-inline-flex btn rounded @if(!in_array(1,explode(',',auth()->user()->status))) opacity-50 noclcik @endif" @if(!in_array(1,explode(',',auth()->user()->status))) onclick="swal('{{__('messages.خطا')}}','{{__('messages.alert_wait.seevideo')}}','error')" @else onclick="location.href='{{route('myinfo',9)}}';" @endif  >
            {{-- @if(in_array(1,explode(',',auth()->user()->status))) disabled @else " onclick="showvideo(1)@endif" --}}
            
                <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" class="mt-md-4" style="width: 5%; ">
                 <circle fill="#ec1e50" cx="20" cy="20" r="20" style=""></circle>
                </svg>
                <div class="categoryDataText text-center d-grid" >
                    <span class="categoryDataExamTitle">{{__('messages.آزمون هالند')}}</span>
                    <span class="text-secondary small"> {{__('messages.رده سنی',["min"=>"12","max"=>"30"])}}</span>
                </div>
                <img src="{{asset('images/redArrow.png')}}" alt="red" class="mt-md-4" style="height: 2rem;">

        </div>
        <div class=" col-12 bg-light d-inline-flex btn rounded @if(!in_array(3,explode(',',auth()->user()->status))) opacity-50 noclcik @endif" @if(!in_array(3,explode(',',auth()->user()->status))) onclick="swal('{{__('messages.خطا')}}','{{__('messages.noTest',['exam'=>__('messages.استعدادیابی دانش آموز')])}}','error')" @else onclick="showResult();" @endif  >
            {{-- @if(in_array(1,explode(',',auth()->user()->status))) disabled @else " onclick="showvideo(1)@endif" --}}
            
                <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" class="mt-md-4" style="width: 5%; ">
                 <circle fill="#ec1e50" cx="20" cy="20" r="20" style=""></circle>
                </svg>
                <div class="categoryDataText text-center d-grid" >
                    <span class="categoryDataExamTitle">{{__('messages.مشاهده نتیجه')}}</span>
                    <span class="text-secondary small"> </span>
                </div>
                <img src="{{asset('images/redArrow.png')}}" alt="red" class="mt-md-4" style="height: 2rem;">

        </div>
        <div class=" col-12 bg-light d-inline-flex btn rounded " onclick="showvideo(2);"   >
           
                <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" class="mt-md-4" style="width: 5%; ">
                 <circle fill="#ec1e50" cx="20" cy="20" r="20" style=""></circle>
                </svg>
                <div class="categoryDataText text-center d-grid" >
                    <span class="categoryDataExamTitle">{{__('messages.افزایش اعتماد به نفس')}}</span>
                    <span class="text-secondary small"> </span>
                </div>
                <img src="{{asset('images/redArrow.png')}}" alt="red" class="mt-md-4" style="height: 2rem;">

        </div>
        <div class=" col-12 bg-light d-inline-flex btn rounded " onclick="showvideo(3);"   >
           
                <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" class="mt-md-4" style="width: 5%; ">
                 <circle fill="#ec1e50" cx="20" cy="20" r="20" style=""></circle>
                </svg>
                <div class="categoryDataText text-center d-grid" >
                    <span class="categoryDataExamTitle">{{__('messages.افزایش علاقه مندی به یادگیری')}}</span>
                    <span class="text-secondary small"> </span>
                </div>
                <img src="{{asset('images/redArrow.png')}}" alt="red" class="mt-md-4" style="height: 2rem;">

        </div>
        
        @else
        @php
            $ex=\App\Models\Exam::find(6);
        @endphp
        @if($ex)
        <div class=" col-12 bg-light d-inline-flex btn rounded " onclick="location.href='{{route('myinfo',$ex->id)}}'" >
           
                <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" class="mt-md-4" style="width: 5%; ">
                 <circle fill="#ec1e50" cx="20" cy="20" r="20" style=""></circle>
                </svg>
                <div class="categoryDataText text-center d-grid" >
                    <span class="categoryDataExamTitle">{{$ex->name}}</span>
                    <span class="text-secondary small"> {{$ex->ageRange}}</span>
                </div>
                <img src="{{asset('images/redArrow.png')}}" alt="red" class="mt-md-4" style="height: 2rem;">

        </div>
        @endif
        @endif
        
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
        <div class="DesktopCategoryContainer" onclick="showvideo(1)">
            <img src="{{asset('images/redArrow.png')}}" alt="red" style="max-width:3%;">
            <div class="categoryData">
                <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" class="" style="width: 10%; margin: 13px 10px 0 0;">
                 <circle fill="#ec1e50" cx="20" cy="20" r="20" style=""></circle>
                </svg>
                <div class="categoryDataText">
                    <span class="categoryDataExamTitle">{{__('messages.پیش نیاز استعدادیابی')}}</span>
                    <span class="categoryDataExamDescription"></span>
                </div>
            </div>
        </div>
        <div @if(!in_array(1,explode(',',auth()->user()->status))) class="DesktopCategoryContainer disabled " onclick="swal('{{__('messages.خطا')}}','{{__('messages.alert_wait.seevideo')}}','error')" @else class="DesktopCategoryContainer " onclick="location.href='{{route('myinfo',4)}}';" @endif>
            <img src="{{asset('images/redArrow.png')}}" alt="red" style="max-width:3%;">
            <div class="categoryData">
                <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" class="" style="width: 10%; margin: 13px 10px 0 0;">
                 <circle fill="#ec1e50" cx="20" cy="20" r="20" style=""></circle>
                </svg>
                <div class="categoryDataText">
                    <span class="categoryDataExamTitle">{{__('messages.استعدادیابی دانش آموز')}}</span>
                    <span class="categoryDataExamDescription">{{__('messages.رده سنی',["min"=>"7","max"=>"12"])}}</span>
                </div>
            </div>
        </div>
        <div @if(!in_array(1,explode(',',auth()->user()->status))) class="DesktopCategoryContainer disabled " onclick="swal('{{__('messages.خطا')}}','{{__('messages.alert_wait.seevideo')}}','error')" @else class="DesktopCategoryContainer " onclick="location.href='{{route('myinfo',6)}}';" @endif>
            <img src="{{asset('images/redArrow.png')}}" alt="red" style="max-width:3%;">
            <div class="categoryData">
                <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" class="" style="width: 10%; margin: 13px 10px 0 0;">
                 <circle fill="#ec1e50" cx="20" cy="20" r="20" style=""></circle>
                </svg>
                <div class="categoryDataText">
                    <span class="categoryDataExamTitle">{{__('messages.استعدادیابی نوجوان')}}</span>
                    <span class="categoryDataExamDescription">{{__('messages.رده سنی',["min"=>"13","max"=>"18"])}}</span>
                </div>
            </div>
        </div>
        <div @if(!in_array(1,explode(',',auth()->user()->status))) class="DesktopCategoryContainer disabled " onclick="swal('{{__('messages.خطا')}}','{{__('messages.alert_wait.seevideo')}}','error')" @else class="DesktopCategoryContainer " onclick="location.href='{{route('myinfo',9)}}';" @endif>
            <img src="{{asset('images/redArrow.png')}}" alt="red" style="max-width:3%;">
            <div class="categoryData">
                <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" class="" style="width: 10%; margin: 13px 10px 0 0;">
                 <circle fill="#ec1e50" cx="20" cy="20" r="20" style=""></circle>
                </svg>
                <div class="categoryDataText">
                    <span class="categoryDataExamTitle">{{__('messages.آزمون هالند')}}</span>
                    <span class="categoryDataExamDescription">{{__('messages.رده سنی',["min"=>"12","max"=>"30"])}}</span>
                </div>
            </div>
        </div>
        <div @if(!in_array(3,explode(',',auth()->user()->status))) class="DesktopCategoryContainer disabled "  onclick="swal('{{__('messages.خطا')}}','{{__('messages.noTest',['exam'=>__('messages.استعدادیابی دانش آموز')])}}','error')" @else class="DesktopCategoryContainer " onclick="showResult()" @endif>
            <img src="{{asset('images/redArrow.png')}}" alt="red" style="max-width:3%;">
            <div class="categoryData">
                <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" class="" style="width: 10%; margin: 13px 10px 0 0;">
                 <circle fill="#ec1e50" cx="20" cy="20" r="20" style=""></circle>
                </svg>
                <div class="categoryDataText">
                    <span class="categoryDataExamTitle">{{__('messages.مشاهده نتیجه')}}</span>
                    <span class="categoryDataExamDescription"></span>
                </div>
            </div>
        </div>
        
        <div class="DesktopCategoryContainer" onclick="showvideo(2)">
            <img src="{{asset('images/redArrow.png')}}" alt="red" style="max-width:3%;">
            <div class="categoryData">
                <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" class="" style="width: 10%; margin: 13px 10px 0 0;">
                 <circle fill="#ec1e50" cx="20" cy="20" r="20" style=""></circle>
                </svg>
                <div class="categoryDataText">
                    <span class="categoryDataExamTitle">{{__('messages.افزایش اعتماد به نفس')}}</span>
                    <span class="categoryDataExamDescription"></span>
                </div>
            </div>
        </div>
        
        <div class="DesktopCategoryContainer" onclick="showvideo(3)">
            <img src="{{asset('images/redArrow.png')}}" alt="red" style="max-width:3%;">
            <div class="categoryData">
                <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" class="" style="width: 10%; margin: 13px 10px 0 0;">
                 <circle fill="#ec1e50" cx="20" cy="20" r="20" style=""></circle>
                </svg>
                <div class="categoryDataText">
                    <span class="categoryDataExamTitle">{{__('messages.افزایش علاقه مندی به یادگیری')}}</span>
                    <span class="categoryDataExamDescription"></span>
                </div>
            </div>
        </div>
        @else
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
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
        window.location.href = "{{route('dashboard')}}/identify/exams";
    }
    function openSuggestionExamsPage(){
        window.location.href = "{{route('dashboard')}}/suggest/exams";
    }
    function showResult() {
        window.location.href = "{{route('dashboard')}}/Exams-Result/";
    }
    function showvideo(type) {
                url='{{route("pish.video")}}';
        switch (type) {
            case 1:
                st=1;
                location.href=url;
                break;
            case 2:
                //url='https://b2n.ir/w15949';
                location.href=url+'?status=5';
                break;
            case 3:
                //url='https://dl.erfankhoshnazar.com/2b/ab.mp4';
                location.href=url+'?status=6';
                break;
        }
        /*axios.post("{{route('pish.ok')}}",{sts:st})
        .then(function ({data}) {
                if(data.status)
                {
                    window.location.assign(url);
                   
                   // window.open(url);
                    window.focus();
                }                
                else
                 swal('{{__('messages.خطا')}}',"{{__('messages.errorSave')}} ","error");
            })
            .catch(error => {
               
                //location.reload();
            });*/
        
    }
    </script>
     <script>
       @if(session('error'))
       swal('{{__('messages.توجه')}}',"{{session('error')}}",'error');
    @endif
    @if(session('success'))
    swal('{{__('messages.عملیات موفقیت آمیز')}} ',"{{session('success')}}",'success');
    @endif
    </script>
@endsection
<style>
    @media (max-width:576px) {

        #DesktopComponents
            {
                display: none;
            }
        }
 @media (min-width: 576px)
 {
    .categoryDataImages {
        width: 20%!important;
        max-width: 13%!important;
        /*margin-right: auto!important;*/
    }
    .categoryData
    {
        width: 45%;
    }
    
 }
 .disabled {
    background: #18181812!important;
    cursor: not-allowed!important;
}
.categoryDataText{
    margin:auto;
}
.categoryData>hr{
    margin: 0px 7%;
}
</style>