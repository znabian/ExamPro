@extends('layouts.exam-Result')
@section('title', 'نتیجه آزمون')
@section('style')
<style>
    @media (min-width: 768px) {
    #myChart
    {
        width: 40rem!important;
        height: 40rem!important;
    }
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
.numbers
{
    padding-right: 0.26rem;
    @if(!in_array(App::getLocale(),['ar','fa']))
    font-family: "Peyda"!important;
    @endif
}
@if(!in_array(App::getLocale(),['ar','fa']))
    .accordion-body {
    direction: ltr;
    text-align: left;
    }
@endif
</style>
@endsection
@section('content')


<div class="row mt-6 mb-3 px-3">
    <div class="col-12 w-100 h-100 px-0 position-relative">
        <div class="check radius-12 bg-green-1 position-absolute">
            <img src="{{asset('images/check.png')}}" width="25px" class="img-fluid" alt="">
            <span class="text-white fw-bold">{{__('messages.analysisTest')}}</span>
        </div>
        <div id="videoRes" style="/*max-height:15rem!important;*/">
            <canvas id="myChart"></canvas>
          </div>
    </div>
</div>
@if(count($out??[]))
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
@endif
@if($descripts)
<div class="row my-5 px-3">
    @foreach($descripts as $item)
    <div class="col-12 px-0 mb-3">
        <div class="accordion acc-me " id="accordionExample{{$loop->index}}">
            <div class="accordion-item shadow-dark-1 radius-23">
                <h2 class="accordion-header radius-23" id="heading{{$loop->index}}">
                    <button class="accordion-button radius-23 collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapse{{$loop->index}}" aria-expanded="true" aria-controls="collapse{{$loop->index}}">
                      {{$item['title']}}
                        <b class="ltr numbers">{{'%'.intdiv($item['num']*100,$sum)}} </b>
                    </button>
                </h2>
                <div id="collapse{{$loop->index}}" class="accordion-collapse collapse  asas"
                    aria-labelledby="heading{{$loop->index}}" data-bs-parent="#accordionExample{{$loop->index}}">
                    <div class="accordion-body text-white">
                        {!!$item['body']!!}
                    </div>
                </div>
            </div>

        </div>
    </div>
    @endforeach
    @if(session('RedFamily'))
    <div class="col-12 mt-5">
        <div class="check radius-12 bg-green-1">
            <img src="{{asset('images/check.png')}}" width="25px" class="img-fluid" alt="">
            <span class="text-white fw-bold btn" onclick="senRequest()">{{__('messages.مشاوره تکمیلی رایگان')}}</span>
        </div>
    </div>
    @endif
</div>
@else
<div class="row mt-6 mb-3 px-3">
    <div class="col-12 w-100 h-100 p-5 position-relative card">
        <img src="{{asset('images/khoshNazar.png')}}" class="w-25 img-sh noimg" alt="">
            <h3 class=" text-center">{{__('messages.analysis')}}</h3>
    
        <div class="check radius-12 bg-green-1" style="padding: 0px;">
            <img src="{{asset('images/check.png')}}" width="25px" class="img-fluid" alt="">
            <span class="text-white fw-bold btn" onclick="senRequest()">{{__('messages.مشاوره تکمیلی رایگان')}}</span>
        </div>
   
            
    </div>
    
</div>

@endif

@endsection
@section('mobileScript')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('myChart');

    const labels = JSON.parse('{!!json_encode($labels)!!}');
    const data = {
    labels: labels,
    datasets: [
        {
        label: '',
       data: JSON.parse('{!!json_encode($furmulids2["RESULT"])!!}'),
        borderColor:'blue',
        backgroundColor:'rgba(54, 162, 235, 0.2)',
        fill:false,
        },
    ]
    };
    const config = {
    type: 'radar',
    data: data,
    options: {
        responsive: true,
        font:{
        family:"Peyda",
            size:6,
        },
        chartArea: { backgroundColor: 'red' },
       
      elements: {
        fontFamily:"Peyda",
        fontSize:56,
        line: {
            borderWidth: 3
        }
        },
        scales: {
            r:{
                suggestedMin: 0,
            suggestedMax: 100,
            grid:{
                    color:'white',
                    lineWidth:3,
                },
            angleLines:{
            color:'white',
            lineWidth: 3
            },
        pointLabels:{color:'white',
                font: {
                    family:'peyda',
                size:15,
                weight:"bold"
                }
        },
        ticks:{
            color:'red',fontFamily:'peyda',stepSize: 10,
        }
            },
          
        },
        plugins: {
        title: {
            display: false,
            text: '{{__("messages.gift2")}}'
        },
        customCanvasBackgroundColor: {
        //color: 'lightGreen',
      },
      legend: {
                        display:false,
                labels: {
                    // This more specific font property overrides the global property
                    font: {
                        size: 65,
                        family:"Peyda"
                    }
                }
            }
        }
    },
    };
    new Chart(ctx, config);
  </script>
<script>
       function mygift()
    {
        
    }
    function senRequest()
    {
        @if(in_array(5,explode(',',auth()->user()->status)) && in_array(6,explode(',',auth()->user()->status))) 
        swal('{{__('messages.alert_wait.title')}}',"{{__('messages.alert_wait.body')}}",'warning');
        window.axios.post('https://exam.erfankhoshnazar.com/api/Exam/addRequest', {Phone:"{{auth()->user()->phone}}",Description:"شرکت در استعدادیابی و درخواست مشاوره رایگان تلفنی",Platform:26})
                            .then(function (response) {                               
                                location.href="https://erfankhoshnazar.com/b";                                

                            })
                            .catch(function (error) {
                            // console.log(error);
                            //     swal('{{__('messages.خطا')}}',"مشکلی پیش آمده مجددا تلاش نمایید",'error');
                            location.href="https://erfankhoshnazar.com/b"; 
                            });    

        @else
            @if(in_array(5,explode(',',auth()->user()->status)) && !in_array(6,explode(',',auth()->user()->status))) 
            text="{{__('messages.gift',['file'=>__('messages.افزایش علاقه مندی به یادگیری')])}}";
            btn={ defeat: "{{__('messages.افزایش علاقه مندی به یادگیری')}}",   };
            @elseif(!in_array(5,explode(',',auth()->user()->status)) && in_array(6,explode(',',auth()->user()->status))) 
            text="{{__('messages.gift',['file'=>__('messages.افزایش اعتماد به نفس')])}} ";
            btn={ conf: "{{__('messages.افزایش اعتماد به نفس')}}",  };
            @else
            text="{{__('messages.gift',['file'=>__('messages.افزایش علاقه مندی به یادگیری').','.__('messages.افزایش اعتماد به نفس')])}} ";
            btn={ conf: "{{__('messages.افزایش اعتماد به نفس')}}",defeat: "{{__('messages.افزایش علاقه مندی به یادگیری')}}",  };
            @endif
        swal( {
            title:"{{__('messages.توجه')}}",
            text:text+". {{__('messages.gift2')}}",
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
        window.axios.post('http://185.116.161.39:8012/RedCastlePanel/public/api/manager/adduserFromEX', {Phone:"{{auth()->user()->phone}}",Description:"درخواست مشاوره رایگان تلفنی",Platform:26})
                            .then(function (response) {
                                if(response.data.status)                                
                                swal('{{__('messages.توجه')}}','{{__('messages.درخواست شما با موفقیت ثبت شد')}}','success');
                                else
                                swal('{{__('messages.خطا')}}',response.data.error,'error');
                                
                                btnreqM.style.display="none";
                                btnreqD.style.display="none";

                            })
                            .catch(function (error) {
                            console.log(error);
                                swal('{{__('messages.خطا')}}',"{{__('messages.مشکلی پیش آمده مجددا تلاش نمایید')}}",'error');
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