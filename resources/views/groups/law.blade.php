@extends('layouts.admin')
@section('title', 'ویرایش قوانین گروه')
@section('content')
<div class="row m-md-5 text-center">
    <div class="col-sm-12 row">
        
        <div class="col-md-6 mb-2" >
        <div class="card">
            <h5 class="card-header">اطلاعات گروه</h5>
            <div class="card-body">
                <form action="{{route('group.update',[$group->id])}}" method="post" enctype="multipart/form-data" id="Nfrm">
                    @csrf
                        <div class="form-group ">
                            <label for="gname">  نام</label>
                            <label class="text-danger p-2">{{($errors->has('name'))?'(الزامی)':''}}</label>
                            <input type="text" class="form-control"  id="gname" name="name" placeholder="نام مورد نظر را وارد نمایید"  autocomplete="off" style="text-align: center;" value="{{$group->name}}">
                        </div>
                        @php
                         $exams=DB::table('exams')->get();
                        @endphp
                        <div class="form-group"> 
                            <label>یک آزمون انتخاب کنید: </label>
                            <label class="text-danger p-2">{{($errors->has('exam_id'))?'(الزامی)':''}}</label>
                                <select class="form-control" name="exam_id" id="exams" onchange="changequiz(this.value)">
                                <option value="" disabled selected>انتخاب کنید</option>
                                    @foreach ($exams as $exam)
                                        <option value="{{$exam->id}}" {{($group->exam_id==$exam->id)?'selected':''}}>{{$exam->name}}</option>
                                    @endforeach   
                               </select>                    
                       </div>
                        <div class="form-group invisible">
                            <label for="">نمایش گروه پس از انتخاب :</label>
                            <select  id="gparent" class="form-control" name="gparent">
                                @if ($groups->count())
                                   <option value="">یک گروه انتخاب کنید </option>
                                    @foreach ($groups as $gup)
                                <option value="{{$gup->id}}" {{($group->parent==$gup->id)?'selected':''}}>{{$gup->name}}</option>                        
                                    @endforeach 
                                @else
                                 <option value="" selected disabled>گروهی برای این آزمون وجود ندارد </option>
                                @endif
                                
                            </select>                                
                        </div>
                        <div class="form-group" >
                            <input type="hidden" name="setname" value="1">
                            <button type="button" class="btn btn-success" style="float:left" onclick="salert('آیا صحت اطلاعات را تایید می کنید؟','Nfrm','');">ثبت</button>
                        </div>
                </form>
            </div>
        </div>
        </div>
         <div class="col-md-6 mb-2" >
                <div class="card">
                    <h5 class="card-header">تحلیل پیش فرض</h5>
                    <div class="card-body">
                            <form action="{{route('group.update',[$group->id])}}" method="post" enctype="multipart/form-data" id="Rfrm">
                            @csrf
                            <input type="hidden" name="res" value="default">
                                <div class=" form-row">
                                    @if (!is_null($group->default))
                                        @php
                                            $def=json_decode($group->default);
                                        @endphp
                                            <div class="form-group col-md-3 mt-2">
                                                <label for="value">نوع تحلیل</label>
                                                <select name="type" class="form-control" id="AnswerType" style="text-align: center;" onchange="changetype(this.value,2)">
                                                    <option value="text" {{($def->type=="text")?'selected':''}} >متن</option>
                                                    <option value="audio" {{($def->type=="audio")?'selected':''}}>صوت</option>
                                                    <option value="video" {{($def->type=="video")?'selected':''}}>فیلم</option>
                                                    <option value="image" {{($def->type=="image")?'selected':''}}>تصویر</option>
                                                    {{-- <option value="formular" {{($def->type=="formular")?'selected':''}}>فرمول</option> --}}
                                                </select>
                                            </div>
                                            <div class="form-group col-md-9  {{($def->type=='text')?'':'d-none'}}" id="2txt">
                                                <label for="AnswerAnalysis">  تحلیل</label>
                                                <label class="text-danger p-2">{{($errors->has('AnswerAnalysis'))?'(الزامی)':''}}</label>
                                                <input type="text" class="form-control"  id="AnswerAnalysis" name="AnswerAnalysis" placeholder="متن مورد نظر را وارد نمایید"  autocomplete="off" style="text-align: center;" value="{{($def->type!='text')?'':$def->result}}">
                                            </div>
                                                
                                            <div class="form-group col-md-9 {{($def->type!='text')?'':'d-none'}}"  id="2file">
                                                <label for="AnswerAnalysisF">  تحلیل</label>
                                                <label class="text-danger p-2">{{($errors->has('AnswerAnalysis'))?'(الزامی)':''}}</label>
                                                <input type="file" class="form-control" id="2AnswerAnalysisF" name="AnswerAnalysis" placeholder="فایل مورد نظر را انتخاب نمایید"  autocomplete="off" 
                                                style="text-align: center;" >                        
                                            
                                            </div>
                                            @if($def->type!='text')
                                                <div class='col-12 justify-content-center'>
                                                    @php
                                                        echo "<{$def->type} controls style='width:100%'>
                                                    <source src='{$def->result}'>
                                                    Your browser does not support the {$def->type} player.</{$def->type}>"
                                                    @endphp
                                                    
                                                </div>                                
                                            @endif
                                        @else
                                        <div class="form-group col-md-3 mt-2">
                                            <label for="value">نوع تحلیل</label>
                                            <select name="type" class="form-control" id="AnswerType" style="text-align: center;" onchange="changetype(this.value,2)">
                                                <option value="text" >متن</option>
                                                <option value="audio">صوت</option>
                                                <option value="video">فیلم</option>
                                                <option value="image">تصویر</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-9" id="2txt">
                                            <label for="AnswerAnalysis">  تحلیل</label>
                                            <label class="text-danger p-2">{{($errors->has('AnswerAnalysis'))?'(الزامی)':''}}</label>
                                            <input type="text" class="form-control"  id="AnswerAnalysis" name="AnswerAnalysis" placeholder="متن مورد نظر را وارد نمایید"  autocomplete="off" style="text-align: center;" value="">
                                        </div>
                                            
                                        <div class="form-group col-md-9 d-none"  id="2file">
                                            <label for="AnswerAnalysisF">  تحلیل</label>
                                            <label class="text-danger p-2">{{($errors->has('AnswerAnalysis'))?'(الزامی)':''}}</label>
                                            <input type="file" class="form-control" id="2AnswerAnalysisF" name="AnswerAnalysis" placeholder="فایل مورد نظر را انتخاب نمایید"  autocomplete="off" 
                                            style="text-align: center;" >                        
                                        
                                        </div>
                                        @endif
                                        
                                        
                                        <div class="form-group col-md-12" >
                                            <button type="button" class="btn btn-success" style="float:left" onclick="salert('آیا صحت اطلاعات را تایید می کنید؟','Rfrm','');">ثبت</button>
                                        </div>
                                </div>
                            </form>
                    </div>
                </div>
            
        </div>
        
        <div class="col-md-6 mb-2" >
             @include('groups.quizset')
        </div>
        <div class="col-md-6" >            
             @include('groups.lawset')
        </div>
        <div class="col-md-12 mb-2" >
        <div class="card mt-2">
            <h5 class="card-header">لیست قوانین</h5>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered" style="width: max-content;min-width: 100%; ">
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
                                            @foreach($item->label as $aid)
                                            <div class="form-group col-md-4">
                                                <span class="btn btn-info btn-sm p-1">{{$aid}}</span>  

                                            </div>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td>{{($item->type=="text")?$item->result:$item->type}}</td>
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
            <div class="alert alert-{{Session::get('type')}} alert-dismissible fade show" role="alert" style="position: fixed;top: 10%;">
            <strong>{{Session::get('msg')}}</strong> 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
        @endif
        </div>
    </div>


    
    
</div> 
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<script>
    document.getElementById('group').setAttribute('class', 'nav-item nav-link mx-3 active');
    function formularset(formul)
    {
            txtFormular.value+=formul;
    }
 </script>
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
    
      function changetype(type,num='')
    {
        if(type!="text" && type!="formular")
        {
            document.getElementById(num+'txt').setAttribute('class', 'form-group col-md-9 d-none');
            document.getElementById(num+'formul').setAttribute('class', 'form-group col-md-9 d-none');
            document.getElementById(num+'file').setAttribute('class', 'form-group col-md-9 ');
            if(type=="audio")
            {
                document.getElementById(num+'AnswerAnalysisF').setAttribute('accept', 'audio/*'); 
            }
            else if(type=="image")
            {
                document.getElementById(num+'AnswerAnalysisF').setAttribute('accept', 'image/*'); 
            }
            else if(type=="video")
            {
                document.getElementById(num+'AnswerAnalysisF').setAttribute('accept', 'video/*'); 
            }
        }
        else if(type=="formular")
        {
            document.getElementById(num+'txt').setAttribute('class', 'form-group col-md-9 d-none');
            document.getElementById(num+'formul').setAttribute('class', 'form-group col-md-9');
            document.getElementById(num+'file').setAttribute('class', 'form-group col-md-9 d-none ');
        }
        else
        {
            document.getElementById(num+'file').setAttribute('class', 'form-group col-md-9 d-none');
            document.getElementById(num+'formul').setAttribute('class', 'form-group col-md-9 d-none');
            document.getElementById(num+'txt').setAttribute('class', 'form-group col-md-9'); 
            
        }
        /* if(type!="text")
        {
            document.getElementById(num+'txt').setAttribute('class', 'form-group col-md-9 d-none');
            document.getElementById(num+'file').setAttribute('class', 'form-group col-md-9 ');
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
            document.getElementById(num+'file').setAttribute('class', 'form-group col-md-9 d-none');
            document.getElementById(num+'txt').setAttribute('class', 'form-group col-md-9'); 
            
        }*/
    }
    function changequiz(id)
    {
        if(id)
        {
            document.getElementById('quiz').innerHTML="<option value=''>کمی صبر کنید ...</option>"; 
            window.axios.get('{{route("quiz.get")}}', {
                params:{
                    examid:id}
        })
        .then(function (response) {
            document.getElementById('quiz').innerHTML=response.data['quiz'];
            document.getElementById('gparent').innerHTML=response.data['group'];
        })
        .catch(function (error) {
            document.getElementById('quiz').innerHTML="<option value=''>ابتدا یک آزمون انتخاب نمایید</option>";
            document.getElementById('gparent').innerHTML="<option value=''>ابتدا یک آزمون انتخاب نمایید</option>";
        })
        .then(function () {
            // always executed
        });  
        }
        else
        document.getElementById('quiz').innerHTML="<option value=''>ابتدا یک آزمون انتخاب نمایید</option>";
            document.getElementById('gparent').innerHTML="<option value=''>ابتدا یک آزمون انتخاب نمایید</option>";
    }
    function setquestion(id,del=0)
    {
        if(del)
        {
            if(id)
            {

                window.axios.get('{{route("quiz.get")}}', {
                    params:{
                qid:id,
                list:qids.value,del:1
                            }
            })
            .then(function (response) {
                listqid.innerHTML=response.data['data'];
                    qids.value=response.data['ids'];
               // document.getElementById('exams').value="";
               // document.getElementById('quiz').innerHTML="<option value=''></option>";
                document.getElementById('quiz').value="";
            })
            .catch(function (error) {
            
            })
            .then(function () {
                // always executed
            });  
            }

        }
        else
        {
            if(id)
            {

                window.axios.get('{{route("quiz.get")}}', {
                    params:{
                        qid:id,
                list:qids.value,
                            }
            })
            .then(function (response) {
                listqid.innerHTML=response.data['data'];
                    qids.value=response.data['ids'];
               // document.getElementById('exams').value="";
               // document.getElementById('quiz').innerHTML="<option value=''></option>";
                document.getElementById('quiz').value="";
            })
            .catch(function (error) {
            
            })
            .then(function () {
                // always executed
            });  
            }
            else
            setquestion(id,1);
        }
        
    }
    function chlistAid(lbl,aid,chk)
    {
        if(chk)
        { 
            window.axios.get('{{route("group.answer.show")}}', {
                params:{
            aid:aid,
            label:lbl,
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
               
                });  
                
        }
        else
        rmlist(lbl);
       
    }
    function rmlist(lbl)
    {
        if(lbl)
        {
            window.axios.get('{{route("group.answer.show")}}', {
                params:{
            list:Aids.value,
            label:lbl,
            del:1
        }
        })
        .then(function (response) {
            listAid.innerHTML=response.data['data'];
            Aids.value=response.data['ids'];
             document.getElementById(lbl).checked=false;
               
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