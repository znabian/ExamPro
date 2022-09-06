@extends('layouts.admin')
@section('title', 'ویرایش نتیجه')
@section('content')
<div class="container mt-5" style="text-align: center;">
    <form action="{{route('conclusion.update',$conclusion->id)}}" method="post">
        @csrf
        @method('put')
        <div class="form-row">
            <div class="form-group col-12">
                <textarea id="mytextarea" class="form-control" name="description">{{$conclusion->description}}</textarea>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
              <label for="low">حداقل ارزش</label>
              <input type="number" class="form-control" id="low" name="low" required autocomplete="off" style="text-align: center;" value="{{$conclusion->low}}">
            </div>
            <div class="form-group col-md-6">
              <label for="high">حداکثر ارزش</label>
              <input type="number" class="form-control" id="high" name="high" required autocomplete="off" style="text-align: center;" value="{{$conclusion->high}}">
            </div>
        </div>
        <button type="submit" class="btn btn-success" onclick="return confirm('آیا صحت اطلاعات را تایید می کنید؟')">ثبت</button>
    </form>
</div>
<script>
  document.getElementById('conclusion').setAttribute('class', 'nav-item nav-link mx-3 active');
</script>
@endsection