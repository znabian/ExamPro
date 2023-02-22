@extends('layouts.exam-conclusion')
@section('title', 'نتیجه آزمون')
@section('content')
<style>
   
   .none{
    font-size: 12pt;
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
.btn-success-2 {
    color: #fe004b;
    font-weight: bold;
    background-color: #fff;
    border-color: #fff;
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
{{-- @if($is6)
<div style="position: fixed">
    <button class="btn btn-success giftbtn" onclick="mygift()">
        <i class="fa fa-gift"></i>
        دریافت هدیه
    </button>
</div>
@endif --}}
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
{{-- @if($is6)
<div style="position: fixed">
    <button class="btn btn-success giftbtn" onclick="mygift()">
        <i class="fa fa-gift"></i>
        دریافت هدیه
    </button>
</div>
@endif --}}

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
                        window.axios.post('{{route("exam.gift")}}', {euid:{{$exam_user_id}},gift:"دریافت مشاوره رایگان"+'(link)'})
                            .then(function (response) {
                                const collection = document.getElementsByClassName("giftbtn");
                                for (let i = 0; i < collection.length; i++) 
                                collection[i].style.visibility = "hidden";
                                window.open("https://gift.erfankhoshnazar.com/", '_blank').focus();       
                                location.reload();
                                
                            })
                            .catch(function (error) {
                            console.log(error);
                            }); 
                        break;

                        case "defeat":
                        window.axios.post('{{route("exam.gift")}}', {euid:{{$exam_user_id}},gift:"دریافت رایگان فصل اول کاخ نوجوان"+'(link)'})
                            .then(function (response) {
                                const collection = document.getElementsByClassName("giftbtn");
                                for (let i = 0; i < collection.length; i++) 
                                collection[i].style.visibility = "hidden";
                                window.open("https://gift.erfankhoshnazar.com/", '_blank').focus();       
                                location.reload();
                                
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