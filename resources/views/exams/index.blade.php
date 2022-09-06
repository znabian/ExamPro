@extends('layouts.admin')
@section('title', 'آزمون ها')
@section('content')
<div class="container mt-5" style="text-align: center;">
    <div style="display:flex;justify-content:flex-start;align-items:center;">
      <a class="btn btn-success mb-2" href="{{route('exam.create')}}">افزودن آزمون</a>
    </div>
      <table class="table">
          <thead class="thead-dark">
            <tr>
              <th scope="col">شناسه</th>
              <th scope="col">عنوان</th>
              <th scope="col">عنوان انگلیسی</th>
              {{--<th scope="col">توضیحات</th>--}}
              <th scope="col"></th>
              <th scope="col"></th>
              <th scope="col"></th>
              <th scope="col"></th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            @foreach($exams as $exam)
            <tr>
              <th scope="row">{{$exam->id}}</th>
              <td>{{$exam->name}}</td>
              <td>{{$exam->englishName}}</td>
              {{--<td>{{illuminate\Support\Str::words($exam->description,12)}}</td>--}}
              <td><a class="btn btn-info" href="{{route('exam.edit',$exam->id)}}">ویرایش</a></td>
              <td><a class="btn btn-warning" href="{{route('question.create',$exam->id)}}">افزودن سوال</a></td>
              <td><a class="btn btn-outline-danger" href="{{route('formular.index',$exam->id)}}">لیست فرمول</a></td>
              <td><a class="btn btn-success" href="{{route('conclusion.create',$exam->id)}}">افزودن نتیجه</a></td>
              <td><a class="btn btn-danger" href="{{route('exams.export',$exam->id)}}">اکسل شرکت کنندگان(نفر {{Illuminate\Support\Facades\DB::table('exam_user')->where("exam_id","=",$exam->id)->distinct()->count()}})</a></td>
            </tr>
            @endforeach
          </tbody>
        </table>
        <div class="d-flex justify-content-center">
          {!! $exams->links() !!}
        </div>
  </div>
  <script>
    document.getElementById('exam').setAttribute('class', 'nav-item nav-link mx-3 active');
  </script>
@endsection