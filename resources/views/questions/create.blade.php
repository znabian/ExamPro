@extends('layouts.admin')
@section('title', 'افزودن سوال')
@section('content')
      @if($errors->any())
            <div class="alert alert-danger alert-dismissible text-right fade show" role="alert" style="position: fixed;top: 10%;z-index:1000;">
             @if($errors->has('question'))
              <strong>- لطفا متن سوال رو وارد کنید یا یک فایل انتخاب نمایید</strong><br>
             @endif
             @if($errors->has('groupid'))
              <strong>- لطفا یک گروه بندی انتخاب کنید یا یک گروه ایجاد نمایید</strong>
             @endif
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
        @endif
    <div class="row m-5 text-center">

        <div class="col-sm-3">
          <div class="card">
            <h5 class="card-header">گروه بندی سوال</h5>
            <div class="card-body">
                  @php
                      $groups=DB::table('groups')->where('status',1)
                      ->where('exam_id',$azmonId)->get();
                  @endphp
                  <div class="fade show" id="selectgroup">
                        <select  id="groupid" required class="form-control" onchange="gid.value=this.value;">
                            @if ($groups->count())
                                    <option value="">یک گروه انتخاب کنید </option>
                                        @foreach ($groups as $group)
                                    <option value="{{$group->id}}" {{(old('groupid')==$group->id)?'selected':''}}>{{$group->name}}</option>                        
                                        @endforeach                     
                            @else
                            <option value="" selected disabled>گروهی برای این آزمون وجود ندارد </option>
                            @endif
                        </select> 
                        <button type="button" class="mt-2 btn btn-primary" onclick="selectgroup.setAttribute('class','fade d-none');creategroup.setAttribute('class','fade show');">ساخت گروه جدید</button>
                  </div>
                  <div class="fade d-none" id="creategroup" >
                        <div class="modal-body">
                            <form action="" method="POST" id="frmGroup">
                                @csrf
                            <div class="form-group">
                                <label for="">نام گروه</label>
                                <input type="text" class="form-control" id="gname" name="gname">
                            </div>
                            <div class="invisible">
                                <div class="form-group {{($groups->count())?'':'d-none'}}">
                                    <label for="">نمایش گروه پس از انتخاب :</label>
                                    <select  id="gparent" class="form-control">
                                        <option value="">یک گروه انتخاب کنید </option>
                                            @foreach ($groups as $group)
                                        <option value="{{$group->id}}">{{$group->name}}</option>                        
                                            @endforeach
                                    </select>                                
                                </div> 
                            </div>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="creategroup.setAttribute('class','fade d-none');selectgroup.setAttribute('class','fade show');">لغو</button>
                        <button type="button" onclick="createGroup()" class="btn btn-primary">ثبت  گروه</button>
                        </form>
                        </div>
                </div>
            </div>
          </div>
        </div>
        <div class="col-sm-9">
          <div class="card">
            <h5 class="card-header">افزودن سوال</h5>
            <div class="card-body">
                <form action="{{route('question.store')}}" method="post" enctype="multipart/form-data" id="frm">
                    @csrf
                    <input type="hidden" name="azmonId" value="{{$azmonId}}">
                    <input type="hidden" name="groupid" id="gid" value="{{old('groupid')}}">
                      <div class="form-row">
                        <div class="form-group col-10">
                          <label for="question">سوال</label>
                          <input type="text" class="form-control" id="question" name="question" placeholder="سوال"  autocomplete="off" style="text-align: right;" value="{{old('question')}}">
                        </div>
                        <div class="form-check">
                          <label class="form-check-label" for="is_char">ارزشگذاری کاراکتر</label>
                          <br>
                          <input type="checkbox" class="form-check-input p-2" id="is_char" name="is_char">
                        </div>
                        <div class="form-row col-md-12">
                          <div class="form-group col-md-2">
                              <label for="value">نوع سوال</label>
                              <select name="type" class="form-control" id="antyp" style="text-align: center;" onchange="changetype(this.value)">
                                 <option value="text">انتخاب کنید</option> 
                                  <option value="audio">صوت</option>
                                  <option value="video">فیلم</option>
                                  <option value="image">تصویر</option>
                              </select>
                          </div>
                              
                              <div class="form-group col-md-10 "  id="file">
                                <label for="">فایل مورد نظر را انتخاب نمایید</label>
                                <input type="file" class="form-control" id="AnswerAnalysisF" disabled name="AnswerAnalysis" placeholder="فایل مورد نظر را انتخاب نمایید"  autocomplete="off" required
                                style="text-align: center;" >                        
                            
                            </div>
                        </div>
                      </div>
                      <h5 class="mt-2">گزینه های سوال</h5>
                      @php
                          $num=['first','second','third','forth','fifth','sixth','seventh'];
                          $name=['اول','دوم','سوم','چهارم','پنجم','ششم','هفتم'];
                      @endphp
                      @for($i=0;$i<7;$i++)
              
                      <div class="form-row border p-5 mb-3">
                          <div class="form-group col-md-8">
                            <label for="{{$num[$i]}}Answer">پاسخ {{$name[$i]}}</label>
                            <input type="text" class="form-control" id="{{$num[$i]}}Answer" name="{{$num[$i].'Answer'}}" placeholder="پاسخ {{$name[$i]}}"  autocomplete="off" style="text-align: right;" value="{{old($num[$i].'Answer')}}">
                          </div>
                          <div class="form-group col-md-2">
                            <label for="{{$num[$i]}}AnswerValue">ارزش</label>
                            <input type="number" class="form-control" id="{{$num[$i]}}AnswerValue" name="{{$num[$i].'AnswerValue'}}" placeholder="ارزش"  autocomplete="off" style="text-align: center;" value="{{old($num[$i].'AnswerValue')}}">
                          </div>
                          <div class="form-group col-md-2">
                            <label for="{{$num[$i]}}AnswerChar">کاراکتر</label>
                            <select class="form-control" id="{{$num[$i]}}AnswerChar" name="{{$num[$i].'AnswerChar'}}">
                              <option value="I">I</option>
                              <option value="C">C</option>
                              <option value="N">N</option>
                              <option value="D">D</option>
                              <option value="S">S</option>
                            </select>
                          </div>
              
                          <div class="form-row col-md-12">
                            <div class="form-group col-md-2">
                                <label for="value">نوع پاسخ</label>
                                <select name="{{$num[$i]}}type" class="form-control" id="{{$num[$i]}}antyp" style="text-align: center;" onchange="changetype(this.value,'{{$num[$i]}}')">
                                   <option value="text">انتخاب کنید</option> 
                                    <option value="audio">صوت</option>
                                    <option value="video">فیلم</option>
                                    <option value="image">تصویر</option>
                                </select>
                            </div>
                                
                                <div class="form-group col-md-10 "  id="{{$num[$i]}}file">
                                  <label for="">فایل مورد نظر را انتخاب نمایید</label>
                                  <input type="file" class="form-control" required id="{{$num[$i]}}AnswerAnalysisF" disabled name="{{$num[$i]}}AnswerAnalysis" placeholder="فایل مورد نظر را انتخاب نمایید"  autocomplete="off" 
                                  style="text-align: center;" >                        
                              
                              </div>
                          </div>
              
                      </div>
              
                      @endfor
                      
                      <button type="submit" class="btn btn-success" style="float:left" onclick="return confirm('آیا صحت اطلاعات را تایید می کنید؟')">افزودن</button>
                    </form>
            </div>
          </div>
        </div>
      </div>

<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<script>
    document.getElementById('question').setAttribute('class', 'nav-item nav-link mx-3 active');
  </script>
<script>
  
    
      function changetype(type,num='')
    {
        if(type!="text")
        {
            //document.getElementById(num+'file').setAttribute('class', 'form-group col-md-10 ');
            document.getElementById(num+'AnswerAnalysisF').disabled=false;
            if(type=="audio")
            {
                document.getElementById(num+'AnswerAnalysisF').setAttribute('accept', 'audio/*'); 
            }
            else if(type=="image")
            {
                document.getElementById(num+'AnswerAnalysisF').setAttribute('accept', 'image/*'); 
            }
            else
            {
                document.getElementById(num+'AnswerAnalysisF').setAttribute('accept', 'video/*'); 
            }
        }
        else
        {
            document.getElementById(num+'AnswerAnalysisF').disabled=true;
            //document.getElementById(num+'file').setAttribute('class', 'form-group col-md-10 d-none');
            
        }
    }
    function createGroup()
    {
        if(gparent.value)
            parent=gparent.value;
        else
            parent=null;
       window.axios.post('{{route("group.save")}}', {
            name: gname.value,
            parent:parent,
            exam_id:{{$azmonId}},
            ajax:1
        })
        .then(function (response) {
            creategroup.setAttribute('class','fade d-none');
            selectgroup.setAttribute('class','fade show');
            groupid.innerHTML+=response.data['data'];
            gid.value=response.data['id'];
        })
        .catch(function (error) {
            console.log(error);
        })
        .then(function () {
            // always executed
        });  
    }
</script>
@endsection