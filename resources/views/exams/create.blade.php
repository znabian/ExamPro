@extends('layouts.admin')
@section('title', 'ایجاد آزمون')
@section('content')
<div class="container mt-5" style="text-align: center;">
    <form action="{{route('exam.store')}}" method="post">
      @csrf
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="title">عنوان</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="عنوان" required autocomplete="off" style="text-align: center;" value="{{old('title')}}">
          </div>
          <div class="form-group col-md-6">
            <label for="englishTitle">عنوان انگلیسی</label>
            <input type="text" class="form-control" id="englishTitle" name="englishTitle" placeholder="عنوان انگلیسی" required autocomplete="off" style="text-align: center;" value="{{old('englishTitle')}}">
          </div>
        </div>
        <div class="form-row">
            <div class="form-group col-12">
              <textarea id="mytextarea" class="form-control" name="description">{{old('description')}}</textarea>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-3">
              <label for="examTime">زمان (دقیقه)</label>
              <input type="number" class="form-control" id="examTime" name="time" required autocomplete="off" style="text-align: center;" value="{{old('time')}}">
            </div>
            <div class="form-group col-md-3">
              <label for="ageRange">بازه زمانی</label>
              <input type="text" class="form-control" id="ageRange" name="ageRange" required autocomplete="off" style="text-align: center;" value="{{old('ageRange')}}">
            </div>
            <div class="form-group col-md-3">
              <label for="level">درجه سختی آزمون</label>
              <br>
              <select class="form-select p-1" aria-label="Default select example" name="level" id="level">
                <option value="1">یک ستاره</option>
                <option value="2">دو ستاره</option>
                <option value="3">سه ستاره</option>
                <option value="4">چهار ستاره</option>
                <option value="5">پنج ستاره</option>
              </select>
            </div>
            <div class="form-group col-md-3">
              <label for="tag">شناسه های آزمون</label>
              <br>
              <select class="form-select p-1" aria-label="Default select example" name="tag[]" id="tag" multiple>
                @foreach($tags as $tag)
                  <option value="{{$tag->id}}">{{$tag->name}}</option>
                @endforeach
              </select>
            </div>
        </div>
        <button type="submit" class="btn btn-success" onclick="return confirm('آیا صحت اطلاعات را تایید می کنید؟')">افزودن</button>
      </form>
</div>

<script>
  document.getElementById('exam').setAttribute('class', 'nav-item nav-link mx-3 active');
</script>
@endsection