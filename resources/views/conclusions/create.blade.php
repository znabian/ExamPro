@extends('layouts.admin')
@section('title', 'افزودن نتیجه')
@section('content')
<div class="container mt-5" style="text-align: center;">
    <form action="{{route('conclusion.store')}}" method="post">
        @csrf
        <input type="hidden" name="examId" value="{{$examId}}">
       
      

          <div class="form-row">
              <div class="form-group col-12">
                  <textarea id="mytextarea" class="form-control" name="description">{{old('description')}}</textarea>
              </div>
          </div>
          <div class="form-row">
              <div class="form-group col-md-6">
                <label for="low">حداقل ارزش</label>
                <input type="number" class="form-control" id="low" name="low" required autocomplete="off" style="text-align: center;" value="{{old('low')}}">
              </div>
              <div class="form-group col-md-6">
                <label for="high">حداکثر ارزش</label>
                <input type="number" class="form-control" id="high" name="high" required autocomplete="off" style="text-align: center;" value="{{old('high')}}">
              </div>
          </div>
          <button type="submit" class="btn btn-success" onclick="return confirm('آیا صحت اطلاعات را تایید می کنید؟')">افزودن</button>

       
    </form>
</div>
<script>
  document.getElementById('conclusion').setAttribute('class', 'nav-item nav-link mx-3 active');
</script>
@endsection