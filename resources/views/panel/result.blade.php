@extends('layouts.exam-Result')
@section('title', 'داشبورد')
@section('content')
<div class="justify-content-center m-auto mb-3 mt-6 px-3 row w-auto gap-1">
    <div class=" col-12 bg-light d-inline-flex btn rounded @if(!in_array(2,explode(',',auth()->user()->status))) opacity-50 noclcik @endif" @if(!in_array(2,explode(',',auth()->user()->status))) onclick="swal('{{__('messages.خطا')}}','{{__('messages.noTest',['exam'=>__('messages.استعدادیابی دانش آموز')])}}','error')" @else  onclick="location.href='{{route('result.exam',4)}}';" @endif  >
        <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" class="mt-md-4" style="width: 5%; ">
             <circle fill="#ec1e50" cx="20" cy="20" r="20" style=""></circle>
            </svg>
            <div class="categoryDataText text-center d-grid" >
                <span class="categoryDataExamTitle">{{__('messages.استعدادیابی دانش آموز')}}</span>
                <span class="text-secondary small"> {{__('messages.مشاهده نتیجه')}}</span>
            </div>
            <img src="{{asset('images/redArrow.png')}}" alt="red" class="mt-md-4" style="height: 2rem;">

    </div>
    <div class=" col-12 bg-light d-inline-flex btn rounded @if(!in_array(3,explode(',',auth()->user()->status))) opacity-50 noclcik @endif" @if(!in_array(3,explode(',',auth()->user()->status))) onclick="swal('{{__('messages.خطا')}}','{{__('messages.noTest',['exam'=>__('messages.استعدادیابی نوجوان')])}}','error')" @else  onclick="location.href='{{route('result.exam',6)}}';" @endif  >
        <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" class="mt-md-4" style="width: 5%; ">
             <circle fill="#ec1e50" cx="20" cy="20" r="20" style=""></circle>
            </svg>
            <div class="categoryDataText text-center d-grid" >
                <span class="categoryDataExamTitle">{{__('messages.استعدادیابی نوجوان')}}</span>
                <span class="text-secondary small"> {{__('messages.مشاهده نتیجه')}}</span>
            </div>
            <img src="{{asset('images/redArrow.png')}}" alt="red" class="mt-md-4" style="height: 2rem;">

    </div>
    <div class=" col-12 bg-light d-inline-flex btn rounded @if(!in_array(7,explode(',',auth()->user()->status))) opacity-50 noclcik @endif" @if(!in_array(7,explode(',',auth()->user()->status))) onclick="swal('{{__('messages.خطا')}}','{{__('messages.noTest',['exam'=>__('messages.آزمون هالند')])}}','error')" @else  onclick="location.href='{{route('result.exam',9)}}';" @endif  >
        <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" class="mt-md-4" style="width: 5%; ">
             <circle fill="#ec1e50" cx="20" cy="20" r="20" style=""></circle>
            </svg>
            <div class="categoryDataText text-center d-grid" >
                <span class="categoryDataExamTitle">{{__('messages.آزمون هالند')}}</span>
                <span class="text-secondary small"> {{__('messages.مشاهده نتیجه')}}</span>
            </div>
            <img src="{{asset('images/redArrow.png')}}" alt="red" class="mt-md-4" style="height: 2rem;">

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
        
        <div @if(!in_array(2,explode(',',auth()->user()->status)))  class="DesktopCategoryContainer disabled" onclick="swal('{{__('messages.خطا')}}','{{__('messages.noTest',['exam'=>__('messages.استعدادیابی دانش آموز')])}}','error')" @else   class="DesktopCategoryContainer" onclick="location.href='{{route('result.exam',4)}}';" @endif>
            <img src="{{asset('images/redArrow.png')}}" alt="red" style="max-width:3%;">
            <div class="categoryData">
                <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" class="" style="width: 10%; margin: 13px 10px 0 0;">
                 <circle fill="#ec1e50" cx="20" cy="20" r="20" style=""></circle>
                </svg>
                <div class="categoryDataText">
                    <span class="categoryDataExamTitle">{{__('messages.استعدادیابی دانش آموز')}}</span>
                    <span class="categoryDataExamDescription">{{__('messages.مشاهده نتیجه')}}</span>
                </div>
            </div>
        </div>
        <div @if(!in_array(3,explode(',',auth()->user()->status)))  class="DesktopCategoryContainer disabled" onclick="swal('{{__('messages.خطا')}}','{{__('messages.noTest',['exam'=>__('messages.استعدادیابی نوجوان')])}}','error')" @else   class="DesktopCategoryContainer" onclick="location.href='{{route('result.exam',6)}}';" @endif>
            <img src="{{asset('images/redArrow.png')}}" alt="red" style="max-width:3%;">
            <div class="categoryData">
                <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" class="" style="width: 10%; margin: 13px 10px 0 0;">
                 <circle fill="#ec1e50" cx="20" cy="20" r="20" style=""></circle>
                </svg>
                <div class="categoryDataText">
                    <span class="categoryDataExamTitle">{{__('messages.استعدادیابی نوجوان')}}</span>
                    <span class="categoryDataExamDescription">{{__('messages.مشاهده نتیجه')}}</span>
                </div>
            </div>
        </div>
        <div @if(!in_array(7,explode(',',auth()->user()->status)))  class="DesktopCategoryContainer disabled" onclick="swal('{{__('messages.خطا')}}','{{__('messages.noTest',['exam'=>__('messages.آزمون هالند')])}}','error')" @else   class="DesktopCategoryContainer" onclick="location.href='{{route('result.exam',9)}}';" @endif>
            <img src="{{asset('images/redArrow.png')}}" alt="red" style="max-width:3%;">
            <div class="categoryData">
                <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" class="" style="width: 10%; margin: 13px 10px 0 0;">
                 <circle fill="#ec1e50" cx="20" cy="20" r="20" style=""></circle>
                </svg>
                <div class="categoryDataText">
                    <span class="categoryDataExamTitle">{{__('messages.آزمون هالند')}}</span>
                    <span class="categoryDataExamDescription">{{__('messages.مشاهده نتیجه')}}</span>
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
       swal('{{__('messages.توجه')}}',"{{session('error')}}",'error');
    @endif
    @if(session('success'))
    swal('{{__('messages.عملیات موفقیت آمیز')}}',"{{session('success')}}",'success');
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