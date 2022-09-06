@extends('layouts.admin')
@section('title', 'لیست قوانین گروه')
@section('content')
<div class="container mt-5" style="text-align: center;">
    <div style="display:flex;justify-content:flex-start;align-items:center;">
      <a class="btn btn-success mb-2" href="{{route('group.create')}}">افزودن گروه</a>
    </div>
      <table class="table">
          <thead class="thead-dark">
            <tr>
              <th scope="col">شناسه</th>
              <th scope="col">عنوان</th>
              <th scope="col">آزمون</th>
              {{-- <th scope="col">نمایش گروه پس از</th> --}}
              <th scope="col">سوالات</th>
              <th scope="col"></th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            @foreach($groups as $group)
            <tr>
              <th scope="row">{{$group->id}}</th>
              <td>{{$group->name}}</td>
              <td>{{$group->exam->name}}</td>
              {{-- <td>
                <span class=" btn btn-outline-warning btn-sm" onclick="document.location.href='{{route('group.edit',$group->id)}}'">{{$group->MYparent->name??'نامشخص'}}</span>
              </td> --}}
              <td>
                <div style="overflow: auto;height: 5rem;text-align: right;">
                @foreach($group->questions()->get() as $quiz)             
                <span class=" btn btn-outline-info mt-2" onclick="document.location.href='{{route('question.edit',$quiz->question->id)}}'">{{$quiz->question->name}}</span>
               
                @endforeach

                </div>
              </td>
              <td><a class="btn btn-info" href="{{route('group.edit',$group->id)}}">ویرایش</a></td>
              <td><button class="btn btn-danger"  onclick="salert('آیا از حذف این گروه اطمینان دارید؟',0,'{{route('group.delete',$group->id)}}');">حذف</button></td>
            </tr>
            @endforeach
          </tbody>
        </table>
        <div class="d-flex justify-content-center">
          {!! $groups->links() !!}
        </div>
        {{-- <form method="post">
            <textarea id="mytextarea">Hello, World!</textarea>
        </form> --}}
  </div>
  <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
   document.getElementById('group').setAttribute('class', 'nav-item nav-link mx-3 active');
   function salert(msg,id,url)
    {
        swal(msg, {
                 buttons: {
                    cancel: "خیر",
                    defeat: "بله",
                },
                })
               .then((value) => {
                    switch (value) {                    
                        case "cancel":
                        return false;
                        break;

                        case "defeat":
                            if(id)
                            document.getElementById(id).submit();
                            else if(url)
                             document.location.href=url;
                        break;
                    }
                    });
    }
</script>
@endsection
