@extends('layouts.admin')
@section('title', 'کاربران')
@section('content')
    <div class="container mt-5" style="text-align: center;">
      <div style="display:flex;justify-content:flex-start;align-items:center;">
        <a class="btn btn-success m-2" href="{{route('createUser')}}">افزودن کاربر</a>
        <a class="btn btn-danger m-2" href="{{route('users.export')}}">دریافت {{__('messages.خروج')}}ی اکسل</a>
      </div>
        <table class="table">
            <thead class="thead-dark">
              <tr>
                <th scope="col">شناسه</th>
                <th scope="col">{{__('messages.نام و نام خانوادگی')}}</th>
                <th scope="col">شماره موبایل</th>
                <th scope="col">وضعیت</th>
                <th scope="col">نقش</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody>
              @foreach($users as $user)
              <tr>
                <th scope="row">{{$user->id}}</th>
                <td>{{$user->firstName ." ". $user->lastName}}</td>
                <td>{{$user->phone}}</td>
                @if($user->active)
                  {{-- <td><span class="btn btn-success" id="userActivate">فعال</span></td> --}}
                  <td>
                    <form method="post" action="{{route('deActiveUser',$user->id)}}">
                      @method('put')
                      @csrf
                      <button class="btn btn-success" onclick="return confirm('آیا می خواهید این کاربر را غیرفعال کنید؟')">فعال</button>
                    </form>
                  </td>
                @else
                  {{-- <td><span class="btn btn-danger" id="userDeActivate">غیر فعال</span></td> --}}
                  <td>
                    <form method="post" action="{{route('activeUser',$user->id)}}">
                      @method('put')
                      @csrf
                      <button class="btn btn-danger" onclick="return confirm('آیا می خواهید این کاربر را فعال کنید؟')">غیر فعال</button>
                    </form>
                  </td>
                @endif
                @if($user->is_admin)
                  <td><span class="btn btn-outline-primary">مدیر</span></td>
                @else
                  <td><span class="btn btn-outline-secondary">کاربر عادی</span></td>
                @endif
                <td><a class="btn btn-info" href="{{route('editUser',$user->id)}}">ویرایش</a></td>
              </tr>
              @endforeach
            </tbody>
          </table>
          <div class="d-flex justify-content-center">
            {!! $users->links() !!}
          </div>
    </div>
    <script>
        document.getElementById('user').setAttribute('class', 'nav-item nav-link mx-3 active');
      </script>
@endsection