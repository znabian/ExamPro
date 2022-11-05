@extends('layouts.admin')
@section('title', 'سوالات')
@section('content')
<div class="container mt-5" style="text-align: center;">
    <div style="display:flex;justify-content:flex-start;align-items:center;">
      <a class="btn btn-success mb-2" href="{{route('exam.index')}}">افزودن سوال</a>
    </div>
      <table class="table">
          <thead class="thead-dark">
            <tr>
              <th scope="col">شناسه</th>
              @if(!is_null(request('exam')))
              <th scope="col">شماره سوال</th>
              @endif
              <th scope="col">عنوان</th>
              <th scope="col">آزمون</th>
              <th scope="col">گروهبندی</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            @foreach($questions as $question)
            @php  
            if(isset($index))
              $index++;
            else
              $index=($questions->currentPage()*10)-9;              
            @endphp
            
            <tr>
              <th scope="row">{{$question->id}}</th>
              @if(!is_null(request('exam')))
              <th scope="row">{{$index}}</th>
              @endif
            <td>{{($question->type=="video")?'فیلم':(($question->type=="image")?'تصویر':(($question->type=="audio")?'صوت':$question->name))}}</td>

              <td>{{$question->exam->name??'-'}}</td>
              <td>
                @if ($question->MyGroup()->count())
                @foreach($question->MyGroup()->get() as $myGroup)
                 <span class=" btn btn-outline-danger mt-2" onclick="document.location.href='{{route('group.edit',$myGroup->group_id)}}'">{{$myGroup->group->name}}</span>
                 @endforeach
                @endif
                </td>
              <td><a class="btn btn-info" href="{{route('question.edit',$question->id)}}">ویرایش</a></td>
            </tr>
            @endforeach
          </tbody>
        </table>
        <div class="d-flex justify-content-center">
          {!! $questions->links() !!}
        </div>
        {{-- <form method="post">
            <textarea id="mytextarea">Hello, World!</textarea>
        </form> --}}
  </div>
  <script>
      document.getElementById('question').setAttribute('class', 'nav-item nav-link mx-3 active');
    </script>
@endsection