@extends('layouts.exam-Result')
@section('title', 'رفیق شفیق')
@section('content')
@if(!session('RedFamily'))
@php
session()->flash('error',"این ویدیو فقط برای اعضای سرخ فامیلی قابل مشاهده است");
@endphp
 <script>   
   document.location.href='{{route("dashboard")}}';
 </script>
@endif       
<div class="justify-content-center m-auto mb-3 mt-6 px-3 row w-auto gap-1">
        @php
        $episode=[1551=>'قسمت اول',1552=>'قسمت دوم',1553=>'قسمت سوم',1554=>'قسمت چهارم',1555=>'قسمت پنجم',1556=>'قسمت ششم',1557=>'قسمت هفتم',1558=>'قسمت هشتم',1559=>'قسمت نهم',1560=>'قسمت دهم',1561=>'قسمت یازدهم',1562=>'قسمت دوازدهم'];
        @endphp
        @foreach($episode as $index=>$eps)
        <div class="col-12 bg-light d-inline-flex btn rounded"  onclick="showvideo({{$index}})">
            
                <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" class="mt-md-4" style="width: 5%; ">
                 <circle fill="#ec1e50" cx="20" cy="20" r="20" style=""></circle>
                </svg>
                <div class="categoryDataText text-center d-grid" >
                    <span class="categoryDataExamTitle">{{$eps}}</span>
                </div>
                <img src="{{asset('images/redArrow.png')}}" alt="red" class="mt-md-4" style="height: 2rem;">

        </div>
        @endforeach
        
        
       
        
    </div>
@endsection
@section('mobileScript')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    function showvideo(cid) {
        appid =1550;
        userid = {{auth()->user()->panel_id}};
        androidid = '{{auth()->user()->android_id}}';
        window.location.href = "http://185.116.161.39:8012/Web/player/index3.php?appid=" + appid + "&id=" + cid + "&userid=" + userid + "&androidid=" + androidid ;
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