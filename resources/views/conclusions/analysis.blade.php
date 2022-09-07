@extends('layouts.exam-conclusion')
@section('title', 'نتیجه آزمون')
@section('content')
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
    color: #fff;
    font-weight: bold;
    background-color: #fe004b;
    border-color: #fe004b;
}
.btn:active {
    -webkit-box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
    -moz-box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
    box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
}

    /* The animation code */
    @keyframes wiggle {
  0%, 7% {
    transform: rotateZ(0);
  }
  15% {
    transform: rotateZ(-15deg);
  }
  20% {
    transform: rotateZ(10deg);
  }
  25% {
    transform: rotateZ(-10deg);
  }
  30% {
    transform: rotateZ(6deg);
  }
  35% {
    transform: rotateZ(-4deg);
  }
  40%, 100% {
    transform: rotateZ(0);
  }
}


/* The element to apply the animation to */
.giftbtn {
    animation: wiggle 2s linear infinite;
}
.giftbtn:hover {
    animation:none;
    box-shadow:0px 0px 20px 10px #fe004b;
}
</style>
@if($is6)
<div style="position: fixed">
    <button class="btn btn-success giftbtn" onclick="mygift()">
        <i class="fa fa-gift"></i>
        دریافت هدیه
    </button>
</div>
@endif
<div id="MobileConclusionShow">
    <img src="{{asset('images/result.png')}}">
</div>
<div id="MobileConclusionShowDescription">
   
        {!!$output!!}
  
</div>
<div id="MobileConclusionShowGoBackButton">
    <a href="{{route('dashboard')}}">بازگشت به صفحه اصلی</a>
</div>
@endsection
@section('DesktopContent')
@if($is6)
<div style="position: fixed">
    <button class="btn btn-success giftbtn" onclick="mygift()">
        <i class="fa fa-gift"></i>
        دریافت هدیه
    </button>
</div>
@endif

<div id="MobileConclusionShow">
    <img src="{{asset('images/result.png')}}">
</div>
<div id="MobileConclusionShowDescription">
    
       {!!$output!!}
   
</div>
<div id="MobileConclusionShowGoBackButton">
    <a href="{{route('dashboard')}}">بازگشت به صفحه اصلی</a>
</div>
@endsection
@section('mobileScript')
<script>
       function mygift()
    {
        @if($is6)
        swal("کدام هدیه را انتخاب می کنید؟", {
            icon: 'info',
            showDenyButton: true,
            buttons: {
                    
                    conf: "دریافت مشاوره رایگان",
                    defeat: "دریافت رایگان فصل اول کاخ نوجوان",                   
                },
                })
               .then((value) => {
                    switch (value) {                    
                        case "conf":
                        window.axios.post('{{route("exam.gift")}}', {euid:{{$exam_user_id}},gift:"دریافت مشاوره رایگان"})
                            .then(function (response) {
                                swal({
                                    title:'هدیه شما ثبت شد',
                                    text:'برای ارسال هدیه با شما تماس گرفته خواهد شد',
                                    icon: 'success',
                                    showDenyButton: true,
                                    buttons: {
                                            
                                            conf: "باشه",                  
                                        },
                                        })
                                    .then((value) => {
                                        if(value=='conf')
                                        {
                                            const collection = document.getElementsByClassName("giftbtn");
                                            for (let i = 0; i < collection.length; i++) {
                                            collection[i].style.visibility = "hidden";
                                            }
                                        }
                                        
                                        else
                                        {
                                            const collection = document.getElementsByClassName("giftbtn");
                                            for (let i = 0; i < collection.length; i++) {
                                            collection[i].style.visibility = "hidden";
                                            }
                                        }
                                
                                     })
                                
                            })
                            .catch(function (error) {
                            console.log(error);
                            }); 
                        break;

                        case "defeat":
                        window.axios.post('{{route("exam.gift")}}', {euid:{{$exam_user_id}},gift:"دریافت رایگان فصل اول کاخ نوجوان"})
                            .then(function (response) {
                                 swal({
                                    title:'هدیه شما ثبت شد',
                                    text:'برای ارسال هدیه با شما تماس گرفته خواهد شد',
                                    icon: 'success',
                                    showDenyButton: true,
                                    buttons: {
                                            
                                            conf: "باشه",                  
                                        },
                                        })
                                    .then((value) => {
                                        if(value=='conf')
                                        {
                                            const collection = document.getElementsByClassName("giftbtn");
                                            for (let i = 0; i < collection.length; i++) {
                                            collection[i].style.visibility = "hidden";
                                            }
                                        }
                                        
                                        else
                                        {
                                            const collection = document.getElementsByClassName("giftbtn");
                                            for (let i = 0; i < collection.length; i++) {
                                            collection[i].style.visibility = "hidden";
                                            }
                                        }
                                
                                     })
                                
                            })
                            .catch(function (error) {
                            console.log(error);
                            }); 
                                        break;
                        }
                    });
        @endif
    }
   
</script>
@endsection