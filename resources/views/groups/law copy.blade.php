@extends('layouts.admin')
@section('title', 'ویرایش قوانین گروه')
@section('content')
<div class="row m-5 text-center">
    <div class="col-sm-6">
        <div class="card">
            <h5 class="card-header">ویرایش قوانین  :{{$group->name}}{{(isset($law))?'- دسته '.$law->id:''}}</h5>
            <div class="card-body">

                <form action="{{(isset($law))?route('group.law.update',[$group->id,$law->id]):route('group.update',[$group->id])}}" method="post" enctype="multipart/form-data" id="frm">
                @csrf
                    @php
                        $quiz=json_decode($group->questions)??[];
                        $questions=DB::table('questions')->whereIn('id',$quiz)->get();
                    @endphp
                    <div class="form-row border p-3 mb-3">
                        <div class="form-group col-md-5">
                        <label>سوال</label>
                            <select class="form-control" name="qid" id="qid" onchange="answerchange(this.value)">
                                    <option value=""> یک سوال انتخاب نمایید</option> 
                            @foreach ($questions as $question)
                                    <option value="{{$question->id}}">{{$question->name}}</option>        
                            @endforeach
                        </select>
                        </div>
                        <div class="form-group col-md-5">
                        <label>گزینه</label>
                            <select class="form-control" name="aid" id="aid" onchange="chlistAid(aid.value)"  >
                                    <option value="">ابتدا یک سوال انتخاب نمایید</option>  
                        </select>
                        </div>
                        <div class="form-group col-md-2">
                        <label>عملگر</label>
                            <select class="form-control" name="operation" id="operation"   >
                                    <option value=""></option>   
                                    <option value="and">and</option>   
                                    <option value="or">or</option>  
                        </select>
                        </div>
                        
                        <div class="form-group col-md-12">
                            <label>گزینه های انتخابی</label>
                            <label class="text-danger p-2">{{($errors->has('Aids'))?'(الزامی)':''}}</label>
                            <div class="form-control text-right overflow-auto" name="answers"  id="listAid" style="height:5rem" >
                               @if (isset($law))
                               @foreach($law->aids as $item)
                               @php
                               $a=App\Models\Answer::find($item);                                   
                               @endphp
                                   <span onclick="rmlist('{{$a->id}}')"  class="btn btn-info btn-sm m-2">{{$a->name}}<b class="p-2 fa fa-close">*</b></span>
                               @endforeach
                               @else
                                لیست خالی است ...                                   
                               @endif
                        </div>
                        </div>
                       @if(isset($law))
                        <div class="form-group col-md-3 mt-2">
                            <label for="value">نوع تحلیل</label>
                            <select name="type" class="form-control" id="AnswerType" style="text-align: center;" onchange="changetype(this.value,'')">
                                <option value="text" {{((old('type')??$law->type)=="text")?'selected':''}} >متن</option>
                                <option value="audio" {{((old('type')??$law->type)=="audio")?'selected':''}}>صوت</option>
                                <option value="video" {{((old('type')??$law->type)=="video")?'selected':''}}>فیلم</option>
                                <option value="image" {{((old('type')??$law->type)=="image")?'selected':''}}>تصویر</option>
                            </select>
                        </div>
                       @else
                        <div class="form-group col-md-3 mt-2">
                            <label for="value">نوع تحلیل</label>
                            <select name="type" class="form-control" id="AnswerType" style="text-align: center;" onchange="changetype(this.value,'')">
                                <option value="text" {{(old('type')=="text")?'selected':''}} >متن</option>
                                <option value="audio" {{(old('type')=="audio")?'selected':''}}>صوت</option>
                                <option value="video" {{(old('type')=="video")?'selected':''}}>فیلم</option>
                                <option value="image" {{(old('type')=="image")?'selected':''}}>تصویر</option>
                            </select>
                        </div>
                        @endif
                    <div class="form-group col-md-9 " id="txt">
                        <label for="AnswerAnalysis">  تحلیل</label>
                        <label class="text-danger p-2">{{($errors->has('AnswerAnalysis'))?'(الزامی)':''}}</label>
                        <input type="text" class="form-control"  id="AnswerAnalysis" name="AnswerAnalysis" placeholder="متن مورد نظر را وارد نمایید"  autocomplete="off" style="text-align: center;" value="{{(isset($law))?$law->result:old('AnswerAnalysis')}}">
                    </div>
                        
                    <div class="form-group col-md-10 d-none"  id="file">
                        <label for="AnswerAnalysisF">  تحلیل</label>
                        <label class="text-danger p-2">{{($errors->has('AnswerAnalysis'))?'(الزامی)':''}}</label>
                        <input type="file" class="form-control" id="AnswerAnalysisF" name="AnswerAnalysis" placeholder="فایل مورد نظر را انتخاب نمایید"  autocomplete="off" 
                        style="text-align: center;" >
                        
                    </div class="form-group col-md-10" >
                    <label class="label label-success d-none" id="Smsg">رسانه با موفقیت ذخیره شد</label>
                    <label class="label label-danger d-none" id="Fmsg"> ذخیره رسانه با شکست مواجه شد</label>
                    <div>
                        <input type="hidden" name="tmpPath" id="tmpPath">
                    </div>

                    </div>
                    
                        <input type="hidden" name="Aids" id="Aids" value="{{(isset($law))?implode(',',$law->aids):''}}">
                <button type="button" class="btn btn-{{(isset($law))?'warning':'success'}}" style="float:left" onclick="salert('آیا صحت اطلاعات را تایید می کنید؟','frm','');">{{(isset($law))?"ویرایش":"افزودن"}}</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card">
            <h5 class="card-header">لیست قوانین</h5>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered" style="width: max-content; ">
                        <thead>
                        <tr>
                        <th>#</th>
                        <th>قوانین</th>
                        <th>تحلیل</th>
                        <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                            @php
                                $law=json_decode($group->result)??[];
                            @endphp
                            @if(count($law))
                                @foreach ($law as $item)
                                <tr>
                                    <td>{{$item->id}}</td>
                                    <td>
                                        <div class="form-row col-md-12">
                                            @foreach($item->aids as $aid)
                                            <div class="form-group col-md-6">
                                                <span class="btn btn-info btn-sm p-1">{{App\Models\Answer::find($aid)->name}}</span>  

                                            </div>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td>{{$item->result}}</td>
                                    <td>
                                        <button class="btn btn-warning m-2" onclick="document.location.href='{{route('group.law.edit',[$group,$item->id])}}'">ویرایش</button>
                                        <button class="btn btn-danger"  onclick="salert('آیا از حذف این سطر اطمینان دارید؟',0,'{{route('group.law.delete',[$group,$item->id])}}');">حذف</button>
                                    </td>
                                </tr>  
                                @endforeach
                            @else
                            <tr>
                                <th colspan="4">لیست خالی است</th>
                            </tr>
                            @endif
                        </tbody>
                    </table> 
                </div>
            </div>
        </div>
        @if(Session::get('msg'))
            <div class="alert alert-{{Session::get('type')}} alert-dismissible fade show" role="alert">
            <strong>{{Session::get('msg')}}</strong> 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
        @endif
    </div>
</div> 
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<script>
  
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
    
      function changetype(type,num)
    {
        if(type!="text")
        {
            document.getElementById(num+'txt').setAttribute('class', 'form-group col-md-10 d-none');
            document.getElementById(num+'file').setAttribute('class', 'form-group col-md-10 ');
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
            document.getElementById(num+'file').setAttribute('class', 'form-group col-md-10 d-none');
            document.getElementById(num+'txt').setAttribute('class', 'form-group col-md-10 '); 
            
        }
    }
    function answerchange(qid)
    {
        if(qid)
        {
            document.getElementById('aid').innerHTML="<option value=''>کمی صبر کنید ...</option>"; 
            window.axios.get('{{route("answer.get")}}', {
                params:{
            id:qid}
        })
        .then(function (response) {
            document.getElementById('aid').innerHTML=response.data;
        })
        .catch(function (error) {
            document.getElementById('aid').innerHTML="<option value=''>ابتدا یک سوال انتخاب نمایید</option>";
        })
        .then(function () {
            // always executed
        });  
        }
        else
        document.getElementById('aid').innerHTML="<option value=''>ابتدا یک سوال انتخاب نمایید</option>";
    }
    function chlistAid(aid)
    {
        if(aid)
        {
            window.axios.get('{{route("group.answer.show")}}', {
                params:{
            aid:aid,
            list:Aids.value,
            del:0
            }
            })
            .then(function (response) {
                listAid.innerHTML=response.data['data'];
                Aids.value=response.data['ids'];
            })
            .catch(function (error) {
                
            })
            .then(function () {
                qid.value='';
                document.getElementById('aid').innerHTML="<option value=''>ابتدا یک سوال انتخاب نمایید</option>"; 
            });  
        }
       
    }
    function rmlist(aid)
    {
        if(aid)
        {
            window.axios.get('{{route("group.answer.show")}}', {
                params:{
            aid:aid,
            list:Aids.value,
            del:1
        }
        })
        .then(function (response) {
            listAid.innerHTML=response.data['data'];
            Aids.value=response.data['ids'];
        })
        .catch(function (error) {
            
        })
        .then(function () {
            
            // always executed
        }); 
        
       
        }
       
    }
    
    
</script>
@endsection