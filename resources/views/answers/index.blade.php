@extends('layouts.admin')
@section('title', 'پاسخ ها')
@section('content')
<div class="container mt-5" style="text-align: center;">
    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col">شناسه</th>
            <th scope="col">عنوان</th>
            <th scope="col">ارزش</th>
            <th scope="col">آزمون</th>
            <th scope="col">سوال</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        @foreach($answers as $answer)
        <tr>
            <th scope="row">{{$answer->id}}</th>
            <td>{{($answer->type=="video")?'فیلم':(($answer->type=="image")?'تصویر':(($answer->type=="audio")?'صوت':$answer->name))}}</td>
            <td>{{$answer->value}}</td>
            <td>                
                @foreach($answer->question->exam()->get() as $quiz)             
                {{$quiz->name}}               
                @endforeach
              </td>
            <td>           
               {{$answer->question->name}}  
              </td>
            <td><a class="btn btn-info" href="{{route('answer.edit',$answer->id)}}">ویرایش</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
        {!! $answers->links() !!}
      </div>
</div>
<script>
     document.getElementById('answer').setAttribute('class', 'nav-item nav-link mx-3 active');
</script>
@endsection