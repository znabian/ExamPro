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
        <div class="MobileCategoryContainer" onclick="showvideo(1)">
            {{-- @if(in_array(1,explode(',',auth()->user()->status))) disabled @else " onclick="showvideo(1)@endif" --}}
            <img src="{{asset('images/redArrow.png')}}" alt="red" style="max-width:8%;">
            <div class="categoryData">
                <img class="categoryDataImages" style="width: 10%;" src="{{asset('images/1.png')}}">
                <hr>
                <div class="categoryDataText">
                    <span class="categoryDataExamTitle">پیش نیاز استعدادیابی</span>
                </div>
            </div>
        </div>
        <div @if(!in_array(1,explode(',',auth()->user()->status)))  class="MobileCategoryContainer disabled" onclick="swal('خطا','ابتدا فیلم پیش نیاز را  تا انتها مشاهده نمایید','error')" @else   class="MobileCategoryContainer" onclick="location.href='{{route('myinfo',4)}}';" @endif>
            <img src="{{asset('images/redArrow.png')}}" alt="red" style="max-width:8%;">
            <div class="categoryData">
                <img class="categoryDataImages" style="width: 10%;" src="{{asset('images/2.png')}}">
                <hr>
                <div class="categoryDataText">
                    <span class="categoryDataExamTitle">استعدادیابی دانش آموز</span>
                    <span class="categoryDataExamDescription">هفت تا هجده سال</span>
                </div>
            </div>
        </div>
        <div @if(!in_array(3,explode(',',auth()->user()->status))) class="MobileCategoryContainer disabled "  onclick="swal('خطا','ابتدا در آزمون استعدادیابی شرکت نمایید','error')" @else class="MobileCategoryContainer " onclick="showResult();" @endif>
            <img src="{{asset('images/redArrow.png')}}" alt="red" style="max-width:8%;">
            <div class="categoryData">
                <img class="categoryDataImages" style="width: 10%;" src="{{asset('images/3.png')}}">
                <hr>
                <div class="categoryDataText">
                    <span class="categoryDataExamTitle">مشاهده نتیجه</span>
                    <span class="categoryDataExamDescription"></span>
                </div>
            </div>
        </div>
        
        <div class="MobileCategoryContainer @if(!session('RedFamily')) disabled @endif"  @if(!session('RedFamily')) onclick="RedFamilyAlert();" @else  onclick="showvideo(2)" @endif>
            <img src="{{asset('images/redArrow.png')}}" alt="red" style="max-width:8%;">
            <div class="categoryData">
                <img class="categoryDataImages" style="width: 10%;" src="{{asset('images/4.png')}}">
                <hr>
                <div class="categoryDataText">
                    <span class="categoryDataExamTitle">آموزش افزایش اعتماد به نفس</span>
                    <span class="categoryDataExamDescription"></span>
                </div>
            </div>
        </div>
        
        <div class="MobileCategoryContainer @if(!session('RedFamily')) disabled @endif"  @if(!session('RedFamily')) onclick="RedFamilyAlert();" @else  onclick="showvideo(3)" @endif>
            <img src="{{asset('images/redArrow.png')}}" alt="red" style="max-width:8%;">
            <div class="categoryData">
                <img class="categoryDataImages" style="width: 10%;" src="{{asset('images/5.png')}}">
                <hr>
                <div class="categoryDataText">
                    <span class="categoryDataExamTitle">آموزش افزایش علاقه مندی به یادگیری</span>
                    <span class="categoryDataExamDescription"></span>
                </div>
            </div>
        </div>
        <div class="MobileCategoryContainer @if(!session('RedFamily')) disabled @endif"  @if(!session('RedFamily')) onclick="RedFamilyAlert();" @else  onclick="RafiqShafiq()" @endif>
            <img src="{{asset('images/redArrow.png')}}" alt="red" style="max-width:8%;">
            <div class="categoryData">
                <img class="categoryDataImages" style="width: 10%;" src="https://dl.erfankhoshnazar.com/downloads/icon/1550.png">
                <hr>
                <div class="categoryDataText">
                    <span class="categoryDataExamTitle">رفیق شفیق</span>
                    <span class="categoryDataExamDescription"></span>
                </div>
            </div>
        </div>
        <div class="MobileCategoryContainer @if(!session('RedFamily')) disabled @endif"  @if(!session('RedFamily')) onclick="RedFamilyAlert();" @else  onclick="hamaiesh()" @endif>
            <img src="{{asset('images/redArrow.png')}}" alt="red" style="max-width:8%;">
            <div class="categoryData">
                <img class="categoryDataImages" style="width: 10%;" src="https://dl.erfankhoshnazar.com/downloads/icon/376.png">
                <hr>
                <div class="categoryDataText">
                    <span class="categoryDataExamTitle">همایش آنلاین</span>
                    <span class="categoryDataExamDescription"></span>
                </div>
            </div>
        </div>
        @else
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
                    <span class="categoryDataExamDescription">{{$ex->ageRange}} سال</span>
                  
                </div>
            </div>
        </div>
        @endif
        @endif
        
    </div>
    <div id="MobileDashboardExamFooterButton">
        <div id="MobileDashboardExamFooterButtonText" style="font-size: 9pt;">
            {{-- دسترسی به پادکست ها ویدئوهای آموزشی --}}
            
        </div>
        {{-- <div id="MobileDashboardExamFooterButtonIcon">
            <img src="{{asset('images/arrow.png')}}" alt="arrow">
        </div> --}}
    </div>
    {{-- <div id="MobileDashboardExamExitButton">
        <img src="{{asset('images/exitIcon.png')}}" alt="exit">
        <a href="{{route('logout')}}">خروج</a>
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
                <img class="categoryDataImages" src="{{asset('images/1.png')}}">
                <hr>
                <div class="categoryDataText">
                    <span class="categoryDataExamTitle">پیش نیاز استعدادیابی</span>
                    <span class="categoryDataExamDescription"></span>
                </div>
            </div>
        </div>
        <div @if(!in_array(1,explode(',',auth()->user()->status))) class="DesktopCategoryContainer disabled " onclick="swal('خطا','ابتدا فیلم پیش نیاز را  تا انتها مشاهده نمایید','error')" @else class="DesktopCategoryContainer " onclick="location.href='{{route('myinfo',4)}}';" @endif>
            <img src="{{asset('images/redArrow.png')}}" alt="red" style="max-width:3%;">
            <div class="categoryData">
                <img class="categoryDataImages" src="{{asset('images/2.png')}}">
                <hr>
                <div class="categoryDataText">
                    <span class="categoryDataExamTitle">استعدادیابی دانش آموز</span>
                    <span class="categoryDataExamDescription">هفت تا هجده سال</span>
                </div>
            </div>
        </div>
        <div @if(!in_array(3,explode(',',auth()->user()->status))) class="DesktopCategoryContainer disabled "  onclick="swal('خطا','ابتدا در آزمون استعدادیابی شرکت نمایید','error')" @else class="DesktopCategoryContainer " onclick="showResult()" @endif>
            <img src="{{asset('images/redArrow.png')}}" alt="red" style="max-width:3%;">
            <div class="categoryData">
                <img class="categoryDataImages" src="{{asset('images/3.png')}}">
                <hr>
                <div class="categoryDataText">
                    <span class="categoryDataExamTitle">مشاهده نتیجه</span>
                    <span class="categoryDataExamDescription"></span>
                </div>
            </div>
        </div>
        
        <div class="DesktopCategoryContainer @if(!session('RedFamily')) disabled @endif"  @if(!session('RedFamily')) onclick="RedFamilyAlert();" @else  onclick="showvideo(2)" @endif>
            <img src="{{asset('images/redArrow.png')}}" alt="red" style="max-width:3%;">
            <div class="categoryData">
                <img class="categoryDataImages" src="{{asset('images/4.png')}}">
                <hr>
                <div class="categoryDataText">
                    <span class="categoryDataExamTitle">آموزش افزایش اعتماد به نفس</span>
                    <span class="categoryDataExamDescription"></span>
                </div>
            </div>
        </div>
        
        <div class="DesktopCategoryContainer @if(!session('RedFamily')) disabled @endif"  @if(!session('RedFamily')) onclick="RedFamilyAlert();" @else  onclick="showvideo(3)" @endif>
            <img src="{{asset('images/redArrow.png')}}" alt="red" style="max-width:3%;">
            <div class="categoryData">
                <img class="categoryDataImages" src="{{asset('images/5.png')}}">
                <hr>
                <div class="categoryDataText">
                    <span class="categoryDataExamTitle">آموزش افزایش علاقه مندی به یادگیری</span>
                    <span class="categoryDataExamDescription"></span>
                </div>
            </div>
        </div>
        <div class="DesktopCategoryContainer @if(!session('RedFamily')) disabled @endif"  @if(!session('RedFamily')) onclick="RedFamilyAlert();" @else  onclick="RafiqShafiq()" @endif>
            <img src="{{asset('images/redArrow.png')}}" alt="red" style="max-width:3%;">
            <div class="categoryData">
                <img class="categoryDataImages" src="https://dl.erfankhoshnazar.com/downloads/icon/1550.png">
                <hr>
                <div class="categoryDataText">
                    <span class="categoryDataExamTitle">رفیق شفیق</span>
                    <span class="categoryDataExamDescription"></span>
                </div>
            </div>
        </div>
        <div class="DesktopCategoryContainer @if(!session('RedFamily')) disabled @endif"  @if(!session('RedFamily')) onclick="RedFamilyAlert();" @else  onclick="hamaiesh()" @endif>
            <img src="{{asset('images/redArrow.png')}}" alt="red" style="max-width:3%;">
            <div class="categoryData">
                <img class="categoryDataImages" src="https://dl.erfankhoshnazar.com/downloads/icon/376.png">
                <hr>
                <div class="categoryDataText">
                    <span class="categoryDataExamTitle">همایش آنلاین</span>
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
                    <span class="categoryDataExamDescription">{{$ex->ageRange}} سال</span>
                  
                </div>
            </div>
        </div>
        @endif
        
        @endif
    </div>
    <!--<div id="DesktopDashboardExamFooterButton">
        <div id="DesktopDashboardExamFooterButtonText">
            {{-- دسترسی به پادکست ها ویدئوهای آموزشی --}}
            
        </div>
        {{-- <div id="DesktopDashboardExamFooterButtonIcon">
            <img src="{{asset('images/arrow.png')}}" alt="arrow">
        </div> --}}
    </div>-->
   
   
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
                 swal('خطا',"ذخیره اطلاعات با خطا مواجه شد لطفا مجددا تلاش کنید","error");
            })
            .catch(error => {
               
                //location.reload();
            });*/
        
    }
    var showbtn=!(sessionStorage.getItem("RedFamilyReq")??0);
    function RedFamilyAlert()
    {
        swal({
            showDenyButton: true,
                    title: "خطا",
                    text:  "این ویدیو فقط برای اعضای سرخ فامیلی قابل مشاهده است",
                    icon: "error",
                        buttons:{
                        conf:"عضویت در سرخ فامیلی",
                        }
                    
                }).then((value) => {
                    if (value=="conf")
                    {
                        if(showbtn)
                        {
                        senRequestRedFamily();
                        }
                        else
                        {
                            swal('توجه',"درخواست شما قبلا ثبت شده است",'warning');
                        }
                        }
                    });
    }
     function senRequestRedFamily()
    {
        swal('لطفا صبر کنید',"درحال بررسی و ذخیره اطلاعات",'warning');
        window.axios.post('{{route('send.request')}}', {phone:"{{auth()->user()->phone}}",description:"شرکت در استعدادیابی و درخواست عضویت در سرخ فامیلی",platform:26})
                            .then(function (response) {
                                if(response.data.status)                        {        
                                swal('توجه','درخواست شما با موفقیت ثبت شد. کارشناسان ما در اسرع وقت با شما تماس خواهند گرفت','success');
                                sessionStorage.setItem("RedFamilyReq", "1");
                                showbtn=0;
                                }
                                else
                                swal('خطا',response.data.error,'error');
                                
                                

                            })
                            .catch(function (error) {
                            console.log(error);
                                swal('خطا',"مشکلی پیش آمده مجددا تلاش نمایید",'error');
                            }); 
    }
    function RafiqShafiq()
    {
        location.href="{{route('rafiq.shafiq')}}"
    }
    function hamaiesh()
    {
        location.href="{{route('hamaiesh.list')}}"
    }
    </script>
     <script>
       @if(session('error'))
       swal('توجه',"{{session('error')}}",'error');
    @endif
    @if(session('success'))
    swal('عملیات موفقیت آمیز',"{{session('success')}}",'success');
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