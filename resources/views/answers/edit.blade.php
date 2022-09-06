@extends('layouts.admin')
@section('title', 'ویرایش پاسخ')
@section('content')
<style>
    #wait {
    z-index: 1000;
    background:#77557778;
    position: fixed;
    width: 100%;
    /*height: 33%;
    left: 33%;*/
    text-align: center;
    padding: 3rem;
    top: 33%;
    border-radius: 10px;
    font-weight: bolder;
    }
    #wait>p
    {
        margin: 15% 0;
    }
    @media (min-width:576px) 
        {
    #wait {
     width: 33%!important;
    height: 33%;
    left: 33%;
    }
    }
</style>
<div class="container mt-5" style="text-align: center;">
    <form action="{{route('answer.update',$answer->id)}}" id="frm" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-row">
            <div class="form-group col-md-10">
            <label for="name">پاسخ به سوال: {{$answer->question->name}}</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="پاسخ "  autocomplete="off" style="text-align: right;" value="{{$answer->name}}">
            </div>
            <div class="form-group col-md-2">
            <label for="value">ارزش</label>
            <input type="number" class="form-control" id="value" name="value" placeholder="ارزش"  autocomplete="off" style="text-align: center;" value="{{$answer->value}}">
            </div>
            
            
            <div class="form-row col-md-12">
                <div class="form-group col-md-2">
                    <label for="value">نوع پاسخ</label>
                    <select name="type" class="form-control" id="antyp" style="text-align: center;" onchange="changetype(this.value)">
                       <option value="text" {{($answer->type=="text")?"selected":''}}>انتخاب کنید</option> 
                        <option value="audio" {{($answer->type=="audio")?"selected":''}}>صوت</option>
                        <option value="video" {{($answer->type=="video")?"selected":''}}>فیلم</option>
                        <option value="image" {{($answer->type=="image")?"selected":''}}>تصویر</option>
                    </select>
                </div>
                    
                <div class="form-group col-md-10 "  id="file">
                    <label for="">فایل مورد نظر را انتخاب نمایید</label>
                    <input type="file" class="form-control" id="AnswerAnalysisF" {{($answer->type=="text")?"disabled":""}} name="AnswerAnalysis" placeholder="فایل مورد نظر را انتخاب نمایید"  autocomplete="off" required
                    style="text-align: center;" accept="{{$answer->type}}/*" >                      
                
                </div>
            </div>
            <div class="form-group col-md-12 d-flex justify-content-center">
                @if ($answer->type=='audio' && $answer->link)
                    <audio controls class="col-md-12">
                        <source src="{{$answer->link}}" >
                        Your browser does not support the audio player.
                        </audio> 

                    @elseif($answer->type=='video' && $answer->link)

                    <video controls class="col-md-6">
                    <source src="{{$answer->link}}">
                    Your browser does not support the video player.
                    </video> 

                    @elseif($answer->type=='image' && $answer->link)
                    <img class="col-md-3" src="{{$answer->link}}"/>
                @endif
            </div>
        </div>
        <button type="button" id="btn" class="btn btn-success" style="float:left" onclick="submitdata();">افزودن</button>
    </form>
</div>
<div dir="rtl" id="wait" class="d-none">
   <p> لطفا صبر کنید ...<p>
</div>
<script>
      document.getElementById('answer').setAttribute('class', 'nav-item nav-link mx-3 active');
    function submitdata()
    {
       if(confirm('آیا صحت اطلاعات را تایید می کنید؟'))
       {
           document.getElementById('wait').setAttribute('class','d-block');
           document.getElementById('btn').setAttribute('class','btn btn-success disabled');
           this.disabled;
           document.getElementById('frm').submit();
       }
    }
    function changetype(type,num='')
    {
        if(type!="text")
        {
            //document.getElementById(num+'file').setAttribute('class', 'form-group col-md-10 ');
            document.getElementById(num+'AnswerAnalysisF').disabled=false;
            if(type=="audio")
            {
                document.getElementById(num+'AnswerAnalysisF').setAttribute('accept', 'audio/*'); 
            }
            else if(type=="image")
            {
                document.getElementById(num+'AnswerAnalysisF').setAttribute('accept', 'image/*'); 
            }
            else
            {
                document.getElementById(num+'AnswerAnalysisF').setAttribute('accept', 'video/*'); 
            }
        }
        else
        {
            document.getElementById(num+'AnswerAnalysisF').disabled=true;
            //document.getElementById(num+'file').setAttribute('class', 'form-group col-md-10 d-none');
            
        }
    }
</script>
@endsection