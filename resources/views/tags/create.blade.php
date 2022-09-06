@extends('layouts.admin')
@section('title', 'افزودن شناسه')
@section('content')
<div class="container mt-5" style="text-align: center;">
    <form action="{{route('tag.store')}}" method="post">
      @csrf
        <div class="form-row">
          <div class="form-group col-md-12">
            <label for="name">عنوان</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="عنوان" required autocomplete="off" style="text-align: right;" value="{{old('name')}}">
          </div>
        </div>
        <button type="submit" class="btn btn-success" onclick="return confirm('آیا صحت اطلاعات را تایید می کنید؟')">افزودن</button>
    </form>
</div>
<script>
    document.getElementById('tag').setAttribute('class', 'nav-item nav-link mx-3 active');
  </script>
@endsection