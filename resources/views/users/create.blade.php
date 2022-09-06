@extends('layouts.admin')
@section('title', 'ایجاد کاربر')
@section('content')
<div class="container mt-5" style="text-align: center;">
    <form action="{{route('storeUser')}}" method="post">
      @csrf
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="firstName">نام</label>
            <input type="text" class="form-control" id="firstName" name="firstName" placeholder="نام" required autocomplete="off" style="text-align: center;" value="{{old('firstName')}}">
          </div>
          <div class="form-group col-md-6">
            <label for="lastName">نام خانوادگی</label>
            <input type="text" class="form-control" id="lastName" name="lastName" placeholder="نام خانوادگی" required autocomplete="off" style="text-align: center;" value="{{old('lastName')}}">
          </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
              <label for="email">ایمیل</label>
              <input type="email" class="form-control" id="email" name="email" placeholder="Email" required autocomplete="off" style="text-align: center;" value="{{old('email')}}">
            </div>
            <div class="form-group col-md-6">
              <label for="phone">شماره موبایل</label>
              <input type="tel" class="form-control" id="phone" name="phone" placeholder="شماره موبایل" required autocomplete="off" style="text-align: center;" value="{{old('phone')}}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
              <label for="birthday">تاریخ تولد</label>
              <input type="date" class="form-control" id="birthday" name="birthday" placeholder="تاریخ تولد" required autocomplete="off" style="text-align: center;" value="{{old('birthday')}}">
            </div>
            <div class="form-group col-md-6">
              <label for="role">نقش کاربر</label>
              <br>
              <select class="form-select p-1" aria-label="Default select example" name="role" id="role">
                <option value="1">کاربر عادی</option>
                <option value="2">مدیر</option>
              </select>
            </div>
        </div>
        <button type="submit" class="btn btn-success" onclick="return confirm('آیا صحت اطلاعات را تایید می کنید؟')">افزودن</button>
      </form>
</div>
<script>
    document.getElementById('user').setAttribute('class', 'nav-item nav-link mx-3 active');
  </script>
@endsection