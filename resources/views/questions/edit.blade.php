@extends('layouts.admin')
@section('title', 'ویرایش سوال')
@section('content')
<div class="container mt-5" style="text-align: center;">
    <form action="{{route('question.update',$question->id)}}" method="post" enctype="multipart/form-data">
      @csrf
      @method('put')
        <div class="form-row">
            @php
          $groups=App\Models\group::where('exam_id',$question->exam_id)->where('status',1)->get();
          @endphp
          <div class="form-group col-12">
                @if ($groups->count())
                    <select  id="groupid" name="gid" required class="form-control" >
                        <option value="">یک گروه انتخاب کنید </option>
                            @foreach ($groups as $group)
                        <option value="{{$group->id}}" {{($group->questions()->where('question_id',$question->id)->count())?'selected':''}}>{{$group->name}}</option>                        
                            @endforeach
                    </select>                      
                @endif
          </div>
          <div class="form-group col-12">
            <label for="question">سوال</label>
            <input type="text" class="form-control" id="question" name="question" placeholder="سوال" required autocomplete="off" style="text-align: right;" value="{{$question->name}}">
          </div>
          <div class="form-row col-md-12">
            <div class="form-group col-md-2">
                <label for="value">نوع سوال</label>
                <select name="type" class="form-control" id="antyp" style="text-align: center;" onchange="changetype(this.value)">
                   <option value="text" {{($question->type=="text")?"selected":''}}>انتخاب کنید</option> 
                    <option value="audio" {{($question->type=="audio")?"selected":''}}>صوت</option>
                    <option value="video" {{($question->type=="video")?"selected":''}}>فیلم</option>
                    <option value="image" {{($question->type=="image")?"selected":''}}>تصویر</option>
                </select>
            </div>
                
              <div class="form-group col-md-10 "  id="file">
                  <label for="">فایل مورد نظر را انتخاب نمایید</label>
                  <input type="file" class="form-control" id="AnswerAnalysisF" {{($question->type=="text" || is_null($question->type))?"disabled":""}} name="AnswerAnalysis" placeholder="فایل مورد نظر را انتخاب نمایید"  autocomplete="off" required
                  style="text-align: center;" accept="{{$question->type}}/*" >                      
              
              </div>
          </div>
          <div class="form-group col-md-12 d-flex justify-content-center">
              @if ($question->type=='audio' && $question->link)
                  <audio controls class="col-md-12">
                      <source src="{{$question->link}}" >
                      Your browser does not support the audio player.
                  </audio> 

              @elseif($question->type=='video' && $question->link)

                <video controls class="col-md-6">
                <source src="{{$question->link}}">
                Your browser does not support the video player.
                </video> 

              @elseif($question->type=='image' && $question->link)
                  <img class="col-md-3" src="{{$question->link}}"/>
              @endif
          </div>
        
        </div>
        <button type="submit" class="btn btn-success mb-3 float-left" onclick="return confirm('آیا صحت اطلاعات را تایید می کنید؟')">ثبت</button>
    </form>
    <table class="table">
        <thead class="thead-dark">
          <tr>
            <th scope="col">شناسه</th>
            <th scope="col">عنوان</th>
            <th scope="col">ارزش</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
          @foreach($answers as $answer)
          <tr>
            <th scope="row">{{$answer->id}}</th>
            <td>{{($answer->type=="video")?'فیلم':(($answer->type=="image")?'تصویر':(($answer->type=="audio")?'صوت':$answer->name))}}</td>
         
            <td>{{$answer->value}}</td>
            <td><a class="btn btn-info" href="{{route('answer.edit',$answer->id)}}">ویرایش</a></td>
          </tr>
          @endforeach
        </tbody>
    </table>
</div>
<script>
    document.getElementById('question').setAttribute('class', 'nav-item nav-link mx-3 active');
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