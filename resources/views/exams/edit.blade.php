@extends('layouts.admin')
@section('title', 'ویرایش آزمون')
@section('content')
<div class="container mt-5" style="text-align: center;">
    <form action="{{route('exam.update',$exam->id)}}" method="post">
      @csrf
      @method('put')
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="title">عنوان</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="عنوان" required autocomplete="off" style="text-align: center;" value="{{$exam->name}}">
          </div>
          <div class="form-group col-md-6">
            <label for="englishTitle">عنوان انگلیسی</label>
            <input type="text" class="form-control" id="englishTitle" name="englishTitle" placeholder="عنوان انگلیسی" required autocomplete="off" style="text-align: center;" value="{{$exam->englishName}}">
          </div>
        </div>
        <div class="form-row">
            <div class="form-group col-12">
              <textarea id="mytextarea" class="form-control" name="description">{{$exam->description}}</textarea>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
              <label for="examTime">زمان (دقیقه)</label>
              <input type="number" class="form-control" id="examTime" name="time" required autocomplete="off" style="text-align: center;" value="{{$exam->time}}">
            </div>
            <div class="form-group col-md-4">
              <label for="ageRange">بازه زمانی</label>
              <input type="text" class="form-control" id="ageRange" name="ageRange" required autocomplete="off" style="text-align: center;" value="{{$exam->ageRange}}">
            </div>
            <div class="form-group col-md-4">
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
        </div>
        <button type="submit" class="btn mb-3 btn-success" onclick="return confirm('آیا صحت اطلاعات را تایید می کنید؟')">ویرایش</button>
      </form>
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
            <td>{!!illuminate\Support\Str::words($conclusion->description,12)!!}</td>
            <td>{{$conclusion->low}}</td>
            <td>{{$conclusion->high}}</td>
            <td><a class="btn btn-info" href="{{route('conclusion.edit',$conclusion->id)}}">ویرایش</a></td>
          </tr>
          @endforeach
        </tbody>
      </table>
</div>
<script>
  document.getElementById('exam').setAttribute('class', 'nav-item nav-link mx-3 active');
</script>
@endsection