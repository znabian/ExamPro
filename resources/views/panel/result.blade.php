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
        </div>
        <div @if(!in_array(2,explode(',',auth()->user()->status)))  class="MobileCategoryContainer disabled" onclick="swal('خطا','ابتدا در آزمون استعدادیابی دانش آموز شرکت کنید','error')" @else   class="MobileCategoryContainer" onclick="location.href='{{route('result.exam',4)}}';" @endif>
            <img src="{{asset('images/redArrow.png')}}" alt="red" style="max-width:8%;">
            <div class="categoryData">
                <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" class="" style="width: 10%; margin: 13px 10px 0 0;">
                 <circle fill="#ec1e50" cx="20" cy="20" r="20" style=""></circle>
                </svg>
                <div class="categoryDataText">
                    <span class="categoryDataExamTitle">استعدادیابی دانش آموز</span>
                    <span class="categoryDataExamDescription">مشاهده نتیجه</span>
                </div>
            </div>
        </div>
        <div @if(!in_array(3,explode(',',auth()->user()->status)))  class="MobileCategoryContainer disabled" onclick="swal('خطا','ابتدا در آزمون استعدادیابی نوجوان شرکت کنید','error')" @else   class="MobileCategoryContainer" onclick="location.href='{{route('result.exam',6)}}';" @endif>
            <img src="{{asset('images/redArrow.png')}}" alt="red" style="max-width:8%;">
            <div class="categoryData">
                <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" class="" style="width: 10%; margin: 13px 10px 0 0;">
                 <circle fill="#ec1e50" cx="20" cy="20" r="20" style=""></circle>
                </svg>
                <div class="categoryDataText">
                    <span class="categoryDataExamTitle">استعدادیابی نوجوان</span>
                    <span class="categoryDataExamDescription">مشاهده نتیجه</span>
                </div>
            </div>
        </div>
        <div @if(!in_array(7,explode(',',auth()->user()->status)))  class="MobileCategoryContainer disabled" onclick="swal('خطا','ابتدا در آزمون هالند شرکت کنید','error')" @else   class="MobileCategoryContainer" onclick="location.href='{{route('result.exam',9)}}';" @endif>
            <img src="{{asset('images/redArrow.png')}}" alt="red" style="max-width:8%;">
            <div class="categoryData">
                <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" class="" style="width: 10%; margin: 13px 10px 0 0;">
                 <circle fill="#ec1e50" cx="20" cy="20" r="20" style=""></circle>
                </svg>
                <div class="categoryDataText">
                    <span class="categoryDataExamTitle">آزمون هالند</span>
                    <span class="categoryDataExamDescription">مشاهده نتیجه</span>
                </div>
            </div>
        </div>
        
    </div>
    <div id="MobileDashboardExamFooterButton">
        <div id="MobileDashboardExamFooterButtonText" style="font-size: 9pt;">
            {{-- دسترسی به پادکست ها ویدئوهای آموزشی --}}
            تمامی آزمون های این سامانه رایگان می باشد!
        </div>
    </div>
@endsection
@section('DesktopContent')
    <div id="DesktopDashboardExamCategoryHeader">
        <span>{{auth()->user()->phone}}</span>
    </div>
    <div id="DesktopDashboardExamCategoryContainer">
        <div id="DesktopDashboardExamCategoryImage">
            <img src="{{asset('images/khoshNazar.png')}}" alt="id">
        </div>
        
        <div @if(!in_array(2,explode(',',auth()->user()->status)))  class="DesktopCategoryContainer disabled" onclick="swal('خطا','ابتدا در آزمون استعدادیابی دانش آموز شرکت کنید','error')" @else   class="DesktopCategoryContainer" onclick="location.href='{{route('result.exam',4)}}';" @endif>
            <img src="{{asset('images/redArrow.png')}}" alt="red" style="max-width:3%;">
            <div class="categoryData">
                <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" class="" style="width: 10%; margin: 13px 10px 0 0;">
                 <circle fill="#ec1e50" cx="20" cy="20" r="20" style=""></circle>
                </svg>
                <div class="categoryDataText">
                    <span class="categoryDataExamTitle">استعدادیابی دانش آموز</span>
                    <span class="categoryDataExamDescription">مشاهده نتیجه</span>
                </div>
            </div>
        </div>
        <div @if(!in_array(3,explode(',',auth()->user()->status)))  class="DesktopCategoryContainer disabled" onclick="swal('خطا','ابتدا در آزمون استعدادیابی نوجوان شرکت کنید','error')" @else   class="DesktopCategoryContainer" onclick="location.href='{{route('result.exam',6)}}';" @endif>
            <img src="{{asset('images/redArrow.png')}}" alt="red" style="max-width:3%;">
            <div class="categoryData">
                <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" class="" style="width: 10%; margin: 13px 10px 0 0;">
                 <circle fill="#ec1e50" cx="20" cy="20" r="20" style=""></circle>
                </svg>
                <div class="categoryDataText">
                    <span class="categoryDataExamTitle">استعدادیابی نوجوان</span>
                    <span class="categoryDataExamDescription">مشاهده نتیجه</span>
                </div>
            </div>
        </div>
        <div @if(!in_array(7,explode(',',auth()->user()->status)))  class="DesktopCategoryContainer disabled" onclick="swal('خطا','ابتدا در آزمون هالند شرکت کنید','error')" @else   class="DesktopCategoryContainer" onclick="location.href='{{route('result.exam',9)}}';" @endif>
            <img src="{{asset('images/redArrow.png')}}" alt="red" style="max-width:3%;">
            <div class="categoryData">
                <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" class="" style="width: 10%; margin: 13px 10px 0 0;">
                 <circle fill="#ec1e50" cx="20" cy="20" r="20" style=""></circle>
                </svg>
                <div class="categoryDataText">
                    <span class="categoryDataExamTitle">آزمون هالند</span>
                    <span class="categoryDataExamDescription">مشاهده نتیجه</span>
                </div>
            </div>
        </div>
        
    </div>
    <div id="DesktopDashboardExamFooterButton">
        <div id="DesktopDashboardExamFooterButtonText">
            {{-- دسترسی به پادکست ها ویدئوهای آموزشی --}}
            تمامی آزمون های این سامانه رایگان می باشد!
        </div>
    </div>
   
   
@endsection
@section('mobileScript')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

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