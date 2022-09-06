@extends('layouts.admin')
@section('title', 'ویرایش آزمون')
@section('content')
<div class="container mt-5" style="text-align: center;">
     
    <div id="alert" style="position: fixed;z-index: 1000;" class="alert alert-{{(!is_null(session('msg')))?"success":"danger"}} alert-dismissible fade {{(!is_null(session('msg')) || !is_null(session('err')))?'show':''}}" role="alert">
        <strong id="msg">{{session('msg')??session('err')}}</strong> 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

    <div class="card">
        <h5 class="card-header" style="cursor: pointer;" onclick="setformularicon.classList.toggle('fa-plus');setformularicon.classList.toggle('fa-minus');setformular.classList.toggle('collapse')" >
           @if($show=='edit')
           ویرایش فرمول {{$formul->label}}
           @else
           فرمول نویسی  سوالات آزمون {{$exam->name}}
           @endif
           <i class="fa {{($show=='set' || $show=='edit' )?'fa-minus':'fa-plus'}} pull-left" id="setformularicon" ></i>
        </h5>
        @if($show=='edit')
        <div class="card-body " id="setformular">
            @include('exams.formular.edit')
        </div>
        @else
        <div class="card-body {{($show=='set')?'':'collapse'}}" id="setformular">
            @include('exams.formular.create')
        </div>
        @endif
    </div>
    <div class="card mt-3">
        <h5 class="card-header" style="cursor: pointer;" onclick="defaulttxticon.classList.toggle('fa-plus');defaulttxticon.classList.toggle('fa-minus');defaulttxt.classList.toggle('collapse')" >
            اطلاعات ابتدای نتیجه           
           <i class="fa {{($show=='defaulttxt' )?'fa-minus':'fa-plus'}} pull-left" id="defaulttxticon" ></i>
        </h5>
        
        <div class="card-body {{($show=='defaulttxt')?'':'collapse'}}" id="defaulttxt">
            @include('exams.formular.default')
        </div>
        
    </div>
    <div class="card mt-3">
        <h5 class="card-header" style="cursor: pointer;" onclick="resformulartxticon.classList.toggle('fa-plus');resformulartxticon.classList.toggle('fa-minus');resformulartxt.classList.toggle('collapse')" >
            فرمول نویسی با نتایج          
           <i class="fa {{($show=='resformular' )?'fa-minus':'fa-plus'}} pull-left" id="resformulartxticon" ></i>
        </h5>
        
        <div class="card-body {{($show=='resformular')?'':'collapse'}}" id="resformulartxt">
            @include('exams.formular.result')
        </div>
        
    </div>
    <div class="card mt-3">
        <h5 class="card-header" style="cursor: pointer;" onclick="listformularicon.classList.toggle('fa-plus');listformularicon.classList.toggle('fa-minus');listformular.classList.toggle('collapse')" >لیست فرمول سوالات 
        
           <i class="fa {{($show=='list')?'fa-minus':'fa-plus'}} pull-left" id="listformularicon" ></i>
        </h5>
        <div class="card-body {{($show=='list')?'':'collapse'}}" id="listformular">
            @include('exams.formular.index')
        </div>
    </div>
</div>
<script>
  document.getElementById('exam').setAttribute('class', 'nav-item nav-link mx-3 active');
  function chk(txt)
  {
        window.axios.post('{{route("conditation.check")}}', {conditation:txt})
                    .then(function (response) {
                        if(response.data['success'])
                        swal({title:response.data['msg'],icon: "error",text:"لطفا عبارت را تصحیح  و مجدد تلاش کنید"});
                       
                    })
                    .catch(function (error) {
                        swal({title:error.response.data['msg'],icon: "error",text:"لطفا عبارت را تصحیح  و مجدد تلاش کنید"});
                    console.log(error);
                    });
  }
  

  function salert(msg,id,url)
    {
         swal(msg, {
                 buttons: {
                    cancel: "خیر",
                    defeat: "بله",
                },
                icon:'info'
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
    function setif()
    {
        if(conditation.value && then.value)
        {
            fc.value+=',{"if":"'+conditation.value+'","then":"'+then.value+'"}';
            ifelse.innerHTML+=' <label class="btn btn-info" onclick=\'removeif("'+conditation.value+'","'+then.value+'");this.remove();\'><i class="fa fa-close mr-2 pull-left"></i>if('+conditation.value+')<br> then<br>'+then.value+'</label>';
        }
        
    }
    function removeif(conditation,then)
    {
        fc.value=fc.value.replace('{"if":"'+conditation+'","then":"'+then+'"}','');
        
    }
    function setif2(num)
    {
        var con=document.getElementById('conditation'+num).value;
        var th=document.getElementById('then'+num).value;
        var eid=document.getElementById('eid'+num).value;
        var fid=document.getElementById('formulid').value;
        if( con && th)
        {
            if(eid)
            {
            window.axios.post('{{route("conditation.edit")}}', {num:num,conditation:con,then:th,id:eid})
            .then(function (response) {
                document.getElementById('ifelse'+num).innerHTML=response.data["out"];
                document.getElementById('conditation'+num).value='';
                document.getElementById('then'+num).value='';
                document.getElementById('eid'+num).value='';
                document.getElementById('editcon'+num).classList.toggle('d-none');
                document.getElementById('setcon'+num).classList.toggle('d-none');
            })
            .catch(function (error) {
                swal({title:error.response.data['msg'],icon: "error",text:"لطفا عبارت را تصحیح  و مجدد تلاش کنید"});
               console.log(error);
            });

            }
            else
            {
            window.axios.post('{{route("conditation.set")}}', {num:num,conditation:{conditation:con,then:th,formular_id:fid}})
            .then(function (response) {
                document.getElementById('ifelse'+num).innerHTML+=response.data["out"];
                document.getElementById('cid'+num).value+=','+response.data["id"];
                document.getElementById('conditation'+num).value='';
                document.getElementById('then'+num).value='';
            })
            .catch(function (error) {
                swal({title:error.response.data['msg'],icon: "error",text:"لطفا عبارت را تصحیح  و مجدد تلاش کنید"});
               console.log(error);
            });

            } 
           
        }
        
    }
    function editif2(num,id)
    {
        window.axios.post('{{route("conditation.get")}}', {id:id})
            .then(function (response) {
                document.getElementById('conditation'+num).value=response.data['if'];
                document.getElementById('then'+num).value=response.data['then'];
                document.getElementById('eid'+num).value=response.data["id"];
                document.getElementById('editcon'+num).classList.toggle('d-none');
                document.getElementById('setcon'+num).classList.toggle('d-none');
            })
            .catch(function (error) {
                swal({title:error.response.data['msg'],icon: "error",text:"لطفا عبارت را تصحیح  و مجدد تلاش کنید"});

               console.log(error);
            }); 
    }
    function removeif2(num,id)
    {
        swal("از حذف این شرط اطمینان دارید؟", {
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
                        window.axios.post('{{route("conditation.delete")}}', {num:num,id:id})
                            .then(function (response) {
                                document.getElementById('ifelse'+num).innerHTML=response.data["out"];
                               // document.getElementById('cid'+num).value=document.getElementById('cid'+num).value.replace(','+response.data["id"]+',',',');
                                
                            })
                            .catch(function (error) {
                            console.log(error);
                            }); 
                                        break;
                                    }
                    });

        
    }
    
</script>
@endsection
