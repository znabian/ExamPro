@extends('layouts.exam-Result')
@section('title', 'نتیجه آزمون')
@section('style')
<style>
    @media (min-width: 768px) {
    .cardd {
    width: 15rem;
    /* height: 6rem; */
    }
    .img-sh {
    top: -66px;
    right: 23px;
    width: 30%;
    }
    .app {
    background-image: url(../images/desktopHeader.png);
    background-repeat: no-repeat;
    background-size: contain;
    min-height: inherit;
    padding: 10px;
    background-attachment: fixed;
}
.noimg
{
    right: -8%;
    top: -21%;
}

.accordion-button
{
    font-size: 1rem!important;
}
}
.noimg
{
    position: absolute;
}

.accordion-button
{
    font-size: 10pt;
}
</style>
@endsection
@section('content')

@if(count($out))
<div class="row mt-6 mb-3 px-3">
    <div class="col-12 w-100 h-100 px-0 position-relative">
        <div class="check radius-12 bg-green-1 position-absolute">
            <img src="{{asset('images/check.png')}}" width="25px" class="img-fluid" alt="">
            <span class="text-white fw-bold">نتیجه تحلیل آزمون شما</span>
        </div>
        <div class="video position-relative radius-12">
            <video id="videoRes" class="blurEffect w-100" width="100%" controls>
                <source src="https://dl.erfankhoshnazar.com/disc/{{strtoupper($score)}}.mp4" type="video/mp4">
                Your browser does not support HTML video.
            </video>
            <span class="icon-video"></span>
        </div>
    </div>
</div>

<div class="row mb-5 px-3 justify-content-between">
    @foreach (json_decode($out["data"]) as $item)        
    <div class="col-6 px-0 d-flex justify-content-center mt-6">
        <div class="cardd position-relative bg-white radius-12 p-2 shadow-dark-2">
            <img src="{{asset($item->img??'images/img1')}}" class="img-fluid img-sh position-absolute" alt="">
            <span
                class="bg-red-2 numbers pt-1 ltr shadow-red-2 radius-12 text-white px-3 py-0 w-content ms-0 me-auto mb-1">{{$item->num}}%</span>
            <h6 class=" py-0 my-2 color-red-1">{{$item->title}}</h6>
        </div>
    </div>
    @endforeach
            
    {{-- <div class="col-12 px-0 d-flex justify-content-center mt-6">
        <div class="card2 position-relative bg-white radius-12 p-5 shadow-dark-2" >
            <img src="{{asset('images/img1.png')}}" class="img-fluid img-sh position-absolute" alt="">
            @foreach (json_decode($out["work"]) as $item)
            <div class="row">
            <span
                class=" bg-red-2 ltr mb-1 col-md-6 px-3 w-content py-0 radius-12 shadow-red-2 text-white">{{$item->num}}%</span>
            <span class=" py-0 my-2 color-red-1 col-md-6">{{$item->title}}</span>

            </div>
    @endforeach
        </div>
    </div> --}}
</div>

<div class="row my-5 px-3">
    @foreach(json_decode($out["descripts"]) as $item)
    <div class="col-12 px-0 mb-3">
        <div class="accordion acc-me " id="accordionExample{{$loop->index}}">
            <div class="accordion-item shadow-dark-1 radius-23">
                <h2 class="accordion-header radius-23" id="heading{{$loop->index}}">
                    <button class="accordion-button radius-23 collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapse{{$loop->index}}" aria-expanded="true" aria-controls="collapse{{$loop->index}}">
                        {{$item->title->tit}}<b class="ltr numbers">{{$item->title->num}} </b>
                    </button>
                </h2>
                <div id="collapse{{$loop->index}}" class="accordion-collapse collapse  asas"
                    aria-labelledby="heading{{$loop->index}}" data-bs-parent="#accordionExample{{$loop->index}}">
                    <div class="accordion-body text-white">
                        {!!$item->body!!}
                    </div>
                </div>
            </div>

        </div>
    </div>
    @endforeach
    <div class="col-12 mt-5">
        <div class="check radius-12 bg-green-1">
            <img src="{{asset('images/check.png')}}" width="25px" class="img-fluid" alt="">
            <span class="text-white fw-bold btn" onclick="senRequest()">مشاوره تکمیلی رایگان</span>
        </div>
    </div>
</div>
@else
<div class="row mt-6 mb-3 px-3">
    <div class="col-12 w-100 h-100 p-5 position-relative card">
        <img src="{{asset('images/khoshNazar.png')}}" class="w-25 img-sh noimg" alt="">
            <h3 class=" text-center">برای دریافت تحلیل آزمون خود روی دکمه زیر کلیک کنید</h3>
    
        <div class="check radius-12 bg-green-1" style="padding: 0px;">
            <img src="{{asset('images/check.png')}}" width="25px" class="img-fluid" alt="">
            <span class="text-white fw-bold btn" onclick="senRequest()">مشاوره تکمیلی رایگان</span>
        </div>
   
            
    </div>
    
</div>

@endif

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
                            // console.log(error);
                            //     swal('خطا',"مشکلی پیش آمده مجددا تلاش نمایید",'error');
                            location.href="https://erfankhoshnazar.com/b"; 
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