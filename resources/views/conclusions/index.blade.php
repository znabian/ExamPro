@extends('layouts.admin')
@section('title', 'نتایج')
@section('content')
<div class="container mt-5" style="text-align: center;">
    <table class="table">
        <thead class="thead-dark">
          <tr>
            <th scope="col">شناسه</th>
            <th scope="col">آزمون</th>
            <th scope="col">توضیحات</th>
            <th scope="col">حداقل ارزش</th>
            <th scope="col">حداکثر ارزش</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
          @foreach($conclusions as $conclusion)
          <tr>
            <th scope="row">{{$conclusion->id}}</th>
            <td>{{$conclusion->exam->name}}</td>
            <td>{!!illuminate\Support\Str::words($conclusion->description,8)!!}</td>
            <td>{{$conclusion->low}}</td>
            <td>{{$conclusion->high}}</td>
            <td><a class="btn btn-info" href="{{route('conclusion.edit',$conclusion->id)}}">ویرایش</a></td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <div class="d-flex justify-content-center">
        {!! $conclusions->links() !!}
      </div>
</div>
<script>
  document.getElementById('conclusion').setAttribute('class', 'nav-item nav-link mx-3 active');
</script>
@endsection