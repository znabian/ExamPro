@extends('layouts.admin')
@section('title', 'افزودن گروه')
@section('content')
<div class="row m-md-5 text-center">
    <form action="{{route('group.save')}}" method="post" enctype="multipart/form-data" id="Cfrm">
        @csrf
    <div class="col-sm-12 row">
            <div class="card col-md-6 mb-2 p-0">
                <h5 class="card-header">اطلاعات گروه</h5>
                <div class="card-body">
                    <div class="form-group ">
                        <label for="gname">  نام</label>
                        <label class="text-danger p-2">{{($errors->has('name'))?'(الزامی)':''}}</label>
                        <input type="text" class="form-control"  id="gname" name="name" placeholder="نام مورد نظر را وارد نمایید"  autocomplete="off" style="text-align: center;" value="">
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
                                    <option value="{{$exam->id}}">{{$exam->name}}</option>
                                @endforeach   
                           </select>                    
                   </div>

                    <div class="form-group invisible">
                        <label for="">نمایش گروه پس از انتخاب :</label>
                        <select  id="gparent" class="form-control" name="gparent">
                            <option value=''>ابتدا یک آزمون انتخاب نمایید</option>                            
                        </select>                                
                    </div>
                </div>
            </div>
            <div class="card col-md-6 mb-2 p-0">
                <h5 class="card-header">تحلیل پیش فرض</h5>
                <div class="card-body">
                       
                        <input type="hidden" name="res" value="default">
                            <div class=" form-row">
                                
                                    <div class="form-group col-md-3 mt-2">
                                        <label for="value">نوع تحلیل</label>
                                        <select name="type" class="form-control" id="AnswerType" style="text-align: center;" onchange="changetype(this.value,2)">
                                            <option value="text" >متن</option>
                                            <option value="audio">صوت</option>
                                            <option value="video">فیلم</option>
                                            <option value="image">تصویر</option>
                                            {{-- <option value="formular">فرمول</option> --}}
                                        </select>
                                    </div>
                                    <div class="form-group col-md-9" id="2txt">
                                        <label for="Analysis">  تحلیل</label>
                                        <label class="text-danger p-2">{{($errors->has('Analysis'))?'(الزامی)':''}}</label>
                                        <input type="text" class="form-control"  id="Analysis" name="Analysis" placeholder="متن مورد نظر را وارد نمایید"  autocomplete="off" style="text-align: center;" value="">
                                    </div>
                                        
                                    <div class="form-group col-md-9 d-none"  id="2file">
                                        <label for="AnalysisF">  تحلیل</label>
                                        <label class="text-danger p-2">{{($errors->has('Analysis'))?'(الزامی)':''}}</label>
                                        <input type="file" class="form-control" id="2AnalysisF" name="Analysis" placeholder="فایل مورد نظر را انتخاب نمایید"  autocomplete="off" 
                                        style="text-align: center;" >                        
                                    
                                    </div>
                                        
                                    <div class="form-group col-md-9 d-none"  id="2formul">
                                        <label for="AnalysisFo">  فرمول</label>
                                        <label class="text-danger p-2">{{($errors->has('Formular'))?'(الزامی)':''}}</label>
                                        <textarea class="form-control text-left" rows="3" id="2Formular" name="Analysis" placeholder=""  autocomplete="off" > </textarea> 
                                        <div class="form-group col-md-12 mt-3 text-left" dir="ltr">
                                             <a class="btn btn-primary" title="جمع"  onclick="formular('+');">+</a>
                                             <a class="btn btn-primary" title="تفریق"  onclick="formular('-');">-</a>
                                             <a class="btn btn-primary" title="ضرب" onclick="formular('*');">×</a>
                                             <a class="btn btn-primary" title="تقسیم" onclick="formular('/');">÷</a>
                                             <a class="btn btn-primary" title="توان" onclick="formular('^');">^</a>
                                             <a class="btn btn-primary" title="درصد" onclick="formular('%');">%</a>
                                             <a class="btn btn-primary" title="پرانتز " onclick="formular('()',0);">( )</a>
                                             <a class="btn btn-primary" title="باقی مانده" onclick="formular('mode');">mode</a>
                                        </div>                      
                                    </div>
                            </div>
                </div>
            </div>
            @include('groups.quizset')
    <div class="form-group col-md-12" >
        <button type="button" class="btn btn-success" style="float:left" onclick="salert('آیا صحت اطلاعات را تایید می کنید؟','Cfrm','');">افزودن</button>
        
    </div>
            @include('groups.lawset')
           
    </div>
    </form>
    
</div> 
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<script>
    document.getElementById('group').setAttribute('class', 'nav-item nav-link mx-3 active');  
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
                document.getElementById(num+'AnalysisF').setAttribute('accept', 'audio/*'); 
            }
            else if(type=="image")
            {
                document.getElementById(num+'AnalysisF').setAttribute('accept', 'image/*'); 
            }
            else if(type=="video")
            {
                document.getElementById(num+'AnalysisF').setAttribute('accept', 'video/*'); 
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