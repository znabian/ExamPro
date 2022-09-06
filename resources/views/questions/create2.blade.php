@extends('layouts.admin')
@section('title', 'افزودن سوال')
@section('content')
<div class="container mt-5" style="text-align: center;">
    <form action="{{route('question.store')}}" method="post" enctype="multipart/form-data" id="frm">
      @csrf
      <input type="hidden" name="azmonId" value="{{$azmonId}}">
        <div class="form-row">
          <div class="form-group col-10">
            <label for="question">سوال</label>
            <input type="text" class="form-control" id="question" name="question" placeholder="سوال" required autocomplete="off" style="text-align: right;" value="{{old('question')}}">
          </div>
          <div class="form-check">
            <label class="form-check-label" for="is_char">ارزشگذاری کاراکتر</label>
            <br>
            <input type="checkbox" class="form-check-input p-2" id="is_char" name="is_char">
          </div>
        </div>
        @php
            $num=['first','second','third','forth','fifth','sixth','seventh'];
            $name=['اول','دوم','سوم','چهارم','پنجم','ششم','هفتم'];
        @endphp
        @for($i=0;$i<7;$i++)

        <div class="form-row border p-5 mb-3">
            <div class="form-group col-md-8">
              <label for="{{$num[$i]}}Answer">پاسخ {{$name[$i]}}</label>
              <input type="text" class="form-control" id="{{$num[$i]}}Answer" name="{{$num[$i].'Answer'}}" placeholder="پاسخ {{$name[$i]}}"  autocomplete="off" style="text-align: right;" value="{{old($num[$i].'Answer')}}">
            </div>
            <div class="form-group col-md-2">
              <label for="{{$num[$i]}}AnswerValue">ارزش</label>
              <input type="number" class="form-control" id="{{$num[$i]}}AnswerValue" name="{{$num[$i].'AnswerValue'}}" placeholder="ارزش"  autocomplete="off" style="text-align: center;" value="{{old($num[$i].'AnswerValue')}}">
            </div>
            <div class="form-group col-md-2">
              <label for="{{$num[$i]}}AnswerChar">کاراکتر</label>
              <select class="form-control" id="{{$num[$i]}}AnswerChar" name="{{$num[$i].'AnswerChar'}}">
                <option value="I">I</option>
                <option value="C">C</option>
                <option value="N">N</option>
                <option value="D">D</option>
                <option value="S">S</option>
              </select>
            </div>

            <div class="form-group col-md-2">
              <label for="value">نوع تحلیل</label>
              <select name="{{$num[$i].'AnswerType'}}" class="form-control" id="{{$num[$i]}}AnswerType" style="text-align: center;" onchange="changetype(this.value,'{{$num[$i]}}')">
                  <option value="text" {{(old($num[$i].'AnswerType')=="text")?'selected':''}} >متن</option>
                  <option value="audio" {{(old($num[$i].'AnswerType')=="audio")?'selected':''}}>صوت</option>
                  <option value="video" {{(old($num[$i].'AnswerType')=="video")?'selected':''}}>فیلم</option>
                  <option value="image" {{(old($num[$i].'AnswerType')=="image")?'selected':''}}>تصویر</option>
              </select>
          </div>
          
          <div class="form-group col-md-10 " id="{{$num[$i]}}txt">
              <label for="{{$num[$i]}}AnswerAnalysis">  تحلیل</label>
              <input type="text" class="form-control"  id="{{$num[$i]}}AnswerAnalysis" name="{{$num[$i].'AnswerAnalysis'}}" placeholder="متن مورد نظر را وارد نمایید"  autocomplete="off" style="text-align: center;" value="{{old($num[$i].'AnswerAnalysis')}}">
          </div>
              
          <div class="form-group col-md-10 d-none"  id="{{$num[$i]}}file">
               <label for="{{$num[$i]}}AnswerAnalysisF">  تحلیل</label>
              <input type="file" class="form-control" id="{{$num[$i]}}AnswerAnalysisF" name="{{$num[$i].'AnswerAnalysis'}}" placeholder="فایل مورد نظر را انتخاب نمایید"  autocomplete="off" 
              style="text-align: center;" >
              
          </div class="form-group col-md-10" >
          <label class="label label-success d-none" id="{{$num[$i]}}Smsg">رسانه با موفقیت ذخیره شد</label>
          <label class="label label-danger d-none" id="{{$num[$i]}}Fmsg"> ذخیره رسانه با شکست مواجه شد</label>
          <div>
            <input type="hidden" name="{{$num[$i]}}tmpPath" id="{{$num[$i]}}tmpPath">
          </div>

        </div>

        @endfor
        
        <button type="submit" class="btn btn-success" style="float:left" onclick="return confirm('آیا صحت اطلاعات را تایید می کنید؟')">افزودن</button>
      </form>
</div>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<script>
  
    
      function changetype(type,num)
    {
        if(type!="text")
        {
            document.getElementById(num+'txt').setAttribute('class', 'form-group col-md-10 d-none');
            document.getElementById(num+'file').setAttribute('class', 'form-group col-md-10 ');
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
            document.getElementById(num+'file').setAttribute('class', 'form-group col-md-10 d-none');
            document.getElementById(num+'txt').setAttribute('class', 'form-group col-md-10 '); 
            
        }
    }
</script>
@endsection