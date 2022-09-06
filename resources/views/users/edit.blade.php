@extends('layouts.admin')
@section('title', 'ویرایش کاربر')
@section('content')
<div class="container mt-5" style="text-align: center;">
    <form action="{{route('updateUser',$user->id)}}" method="post">
      @csrf
      @method('put')
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="firstName">نام</label>
            <input type="text" class="form-control" id="firstName" name="firstName" placeholder="نام" required autocomplete="off" style="text-align: center;" value="{{$user->firstName}}">
          </div>
          <div class="form-group col-md-6">
            <label for="lastName">نام خانوادگی</label>
            <input type="text" class="form-control" id="lastName" name="lastName" placeholder="نام خانوادگی" required autocomplete="off" style="text-align: center;" value="{{$user->lastName}}">
          </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
              <label for="email">ایمیل</label>
              <input type="email" class="form-control" id="email" name="email" placeholder="Email" required autocomplete="off" style="text-align: center;" value="{{$user->email}}">
            </div>
            <div class="form-group col-md-6">
              <label for="phone">شماره موبایل</label>
              <input type="tel" class="form-control" id="phone" name="phone" placeholder="شماره موبایل" required autocomplete="off" style="text-align: center;" value="{{$user->phone}}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
              <label for="birthday">تاریخ تولد</label>
              <input type="date" class="form-control" id="birthday" name="birthday" placeholder="تاریخ تولد" required autocomplete="off" style="text-align: center;" value="{{$user->birthday}}">
            </div>
            <div class="form-group col-md-6">
              <label for="role">نقش کاربر</label>
              <br>
              <select class="form-select p-1" aria-label="Default select example" name="role" id="role">
                  @if($user->is_admin)
                    <option value="1">کاربر عادی</option>
                    <option value="2" selected>مدیر</option>
                  @else
                    <option value="1" selected>کاربر عادی</option>
                    <option value="2">مدیر</option>
                  @endif
              </select>
            </div>
        </div>
        <button type="submit" class="btn btn-success" onclick="return confirm('آیا صحت اطلاعات را تایید می کنید؟')">ویرایش</button>
      </form>
</div>
<script>
    document.getElementById('user').setAttribute('class', 'nav-item nav-link mx-3 active');
  </script>
@endsection