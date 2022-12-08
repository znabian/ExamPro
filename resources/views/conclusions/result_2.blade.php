@extends('layouts.exam-conclusion')
@section('title', 'نتیجه آزمون')
@section('content')
<style>
   
   .none{
    font-size: 12pt;
   }
    .swal-text {
    text-align: right;
    direction: rtl;
}
    .none::before {
        font-weight: bold;
        content: '\2022';/*025BE*/
    }
    /* .collapsible::before {
        font-weight: bold;
        content: '\025C2';
    } */
    .collapsible::after {
    font-weight: 100;
    content: " (مشاهده جزئیات) \025C2";
    font-size: 12pt;
    color: blue;
} 
.active::after {
    content: " (بستن جزئیات) \025BE";
    }
    .active::before {
       /* font-size: 15pt;color: #f6455d;*/
  /* content: "\025BE"; */
    }
    .collapsible {      
        color:#f6455d;
      cursor: pointer;
      /* padding: 18px; */
      width: 100%;
      border: none;
      text-align: left;
      outline: none;
      /* font-size: 15px; */
    }
    
    .active, .collapsible:hover {
     background: transparent;
    }
    
    .content {
      padding: 0 18px;
      display: none;
      overflow: hidden;
     
    }
    </style>
<style>
    .img-thumbnail {
    padding: .25rem;
    background-color: #fff;
  /*  border: 1px solid #dee2e6;
    border-radius: .25rem;*/
    width: 100%;
    height: auto;
}
p>b
    {
        color:#f6455d;
    }
.resulttabe {
    font-size: 12pt;
    direction: rtl;
    border-collapse: collapse;
    background: #fe004b;
    color: white;
    text-align: center;
    width: auto;
    border-radius:10px;
}
.resulttabe tr
{
    border: 1px solid;
    font-size: 9pt; 
    padding:2px; 
}

.resulttabe th
{
    border: 1px solid;
    font-size: 9pt; 
    padding:2px;
}
.table-responsive {
    display: block;
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    -ms-overflow-style: -ms-autohiding-scrollbar;
}
.fa
{
    padding-left:5px;
}
.btn {
    display: inline-block;
    padding: 6px 12px;
    margin-bottom: 0;
    font-size: 13px;
    font-weight: 400;
    line-height: 1.42857143;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -ms-touch-action: manipulation;
    touch-action: manipulation;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    border: 1px solid transparent;
    border-radius: 4px;
    direction: rtl;
    font-family: 'Peyda'
}
button.swal-button {
    color: #fff;
    font-weight: bold;
    background-color: #fe004b;
    border-color: #fe004b;
    font-family: 'Peyda';
    box-shadow:none;
    
}
button.swal-button:focus {
    color: #fff;
    font-weight: bold;
    background-color: #fe004b;
    border-color: #fe004b;
    font-family: 'Peyda';
    box-shadow:none;    
}
button.swal-button:hover
{
     background-color: #fff!important;
      color: #fe004b;
    border:2px solid #fe004b;
}
.btn-success {
    color: #fe004b;
    font-weight: bold;
    background-color: #fff;
    border-color: #fff;
}
.btn:active {
    -webkit-box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
    -moz-box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
    box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
}

    /* The animation code */
    @keyframes wiggle {
  0% {
    transform: rotateZ(10deg);
  }
  50% {
    transform: rotateZ(0deg);
  } 100% {
    transform: rotateZ(50deg);
  }

}


/* The element to apply the animation to */

.giftbtn {
    animation: wiggle 2s linear infinite;
    display: grid;
    font-size: 17pt;
}
.fa-gift
{
    font-size: 31pt;
    
}
.giftbtn:hover {
    animation:none;
    box-shadow:0px 0px 20px 10px #fff;
}
</style>

{{-- <div id="MobileConclusionShow">
    <img src="{{asset('images/result.png')}}">
</div> --}}
<div id="MobileConclusionShowDescription" onscroll=" if(this.scrollTop > 50){mygift();}">
   @if($score)
   <div class='col-12 justify-content-center' style="text-align: center;">
    <p dir="rtl">نتیجه تحلیل آزمون شما: </p>
        <video  controls style='width:100%;height: 10rem;'>
            <source src='https://dl.erfankhoshnazar.com/disc/{{strtoupper($score)}}.mp4'>
        Your browser does not support the video player.</video>
    </div>
   @endif
        {!!$out!!}
  
</div>
<div id="MobileConclusionShowGoBackButton"  style="margin-bottom: 5%;">        
    <a id="btnreqM" onclick="senRequest()" style="cursor: pointer;"> دریافت مشاوره رایگان دوره آموزشی </a>
</div>
<div id="MobileConclusionShowGoBackButton">
    <a href="{{route('dashboard')}}">بازگشت به صفحه اصلی</a>
</div>
@endsection
@section('DesktopContent')


{{-- <div id="MobileConclusionShow">
    <img src="{{asset('images/result.png')}}">
</div> --}}
<div id="MobileConclusionShowDescription" >
    @if($score)
    <div class='col-12 justify-content-center' style="text-align: center;">
        <p dir="rtl">نتیجه تحلیل آزمون شما: </p>
         <video  controls style='height: 100%;width:100%'>
         <source src='https://dl.erfankhoshnazar.com/disc/{{strtoupper($score)}}.mp4'>
         Your browser does not support the video player.</video>
     </div>
    @endif
       {!!$out!!}
   
</div>
<div id="MobileConclusionShowGoBackButton" style="margin-bottom: 5%;">   
    <a id="btnreqD" onclick="senRequest()" style="cursor: pointer;"> دریافت مشاوره رایگان دوره آموزشی </a>
</div>
<div id="MobileConclusionShowGoBackButton">
    <a href="{{route('dashboard')}}">بازگشت به صفحه اصلی</a>
</div>
@endsection
@section('mobileScript')
<script>
       function mygift()
    {
        
    }
    function senRequest()
    {
        @if(in_array(5,explode(',',auth()->user()->status)) && in_array(6,explode(',',auth()->user()->status))) 
        swal('لطفا صبر کنید',"درحال بررسی و ذخیره اطلاعات",'warning');
        window.axios.post('http://85.208.255.101:8012/RedCastlePanel/public/api/manager/adduserFromEX', {Phone:"{{auth()->user()->phone}}",Description:"درخواست مشاوره رایگان تلفنی",Platform:26})
                            .then(function (response) {                               
                                location.href="https://erfankhoshnazar.com/b";                                

                            })
                            .catch(function (error) {
                            console.log(error);
                                swal('خطا',"مشکلی پیش آمده مجددا تلاش نمایید",'error');
                            });    

        @else
            @if(in_array(5,explode(',',auth()->user()->status)) && !in_array(6,explode(',',auth()->user()->status))) 
            text="شما تاکنون از هدیه رایگان فایل آموزشی علاقه مندی به یادگیری استفاده نکرده اید ";
            btn={ defeat: "فایل آموزشی علاقه مندی به یادگیری",   };
            @elseif(!in_array(5,explode(',',auth()->user()->status)) && in_array(6,explode(',',auth()->user()->status))) 
            text="شما تاکنون از هدیه رایگان فایل آموزشی اعتماد به نفس استفاده نکرده اید ";
            btn={ conf: "فایل آموزشی اعتماد به نفس",  };
            @else
            text="شما تاکنون از هدیه رایگان فایلهای آموزشی اعتماد به نفس و علاقه مندی به یادگیری استفاده نکرده اید ";
            btn={ conf: "فایل آموزشی اعتماد به نفس",defeat: "فایل آموزشی علاقه مندی به یادگیری",  };
            @endif
        swal( {
            title:"توجه",
            text:text+". جهت تکمیل فرایند، هدایای زیر رو مشاهده نمایید",
            icon: 'info',
            showDenyButton: true,
            buttons: btn,
                })
               .then((value) => {
                url='{{route("pish.video")}}';
                    switch (value) {                    
                        case "conf":
                        location.href=url+'?status=5';
                        break;

                        case "defeat":
                        location.href=url+'?status=6';
                        break;
                        }
                    });
        
        @endif
    }
   /* function senRequest()
    {
        window.axios.post('http://85.208.255.101:8012/RedCastlePanel/public/api/manager/adduserFromEX', {Phone:"{{auth()->user()->phone}}",Description:"درخواست مشاوره رایگان تلفنی",Platform:26})
                            .then(function (response) {
                                if(response.data.status)                                
                                swal('توجه','درخواست شما با موفقیت ثبت شد','success');
                                else
                                swal('خطا',response.data.error,'error');
                                
                                btnreqM.style.display="none";
                                btnreqD.style.display="none";

                            })
                            .catch(function (error) {
                            console.log(error);
                                swal('خطا',"مشکلی پیش آمده مجددا تلاش نمایید",'error');
                            }); 
    }*/
   
</script>
<script>
    var coll = document.getElementsByClassName("collapsible");
    var i;
    
    for (i = 0; i < coll.length; i++) {
      coll[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var content = this.nextElementSibling;
        if (content.style.display === "block") {
          content.style.display = "none";
        } else {
          content.style.display = "block";
        }
      });
    }
    </script>
@endsection