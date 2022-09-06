@extends('layouts.admin')
@section('title', 'شناسه ها')
@section('content')
<div class="container mt-5" style="text-align: center;">
    <div style="display:flex;justify-content:flex-start;align-items:center;">
        <a class="btn btn-success mb-2" href="{{route('tag.create')}}">افزودن شناسه</a>
    </div>
    <table class="table">
        <thead class="thead-dark">
          <tr>
            <th scope="col">شناسه</th>
            <th scope="col">نام</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
          @foreach($tags as $tag)
          <tr>
            <th scope="row">{{$tag->id}}</th>
            <td>{{$tag->name}}</td>
            <td><a class="btn btn-info" href="{{route('tag.edit',$tag->id)}}">ویرایش</a></td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <div class="d-flex justify-content-center">
        {!! $tags->links() !!}
      </div>
</div>
<script>
    document.getElementById('tag').setAttribute('class', 'nav-item nav-link mx-3 active');
  </script>
@endsection