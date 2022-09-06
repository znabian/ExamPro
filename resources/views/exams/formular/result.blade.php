<form action="{{(isset($formul))?route('formular.update',[$formul->id]):route('formular.create',[$exam->id])}}" method="post" enctype="multipart/form-data" id="Rfrm">
  @csrf
  <input type="hidden" value="res" name="type">
  <div class="form-group">
    <label for=""> عنوان برای نمایش (LABEL)</label>
    <input type="text" class="form-control" name="lbl" value="{{($show=='resformular')?$formul->label:old('lbl')}}">
  </div>
         <div class="form-row p-3"> 
               <label>یک فرمول انتخاب کنید: </label>
                     <select class="form-control"  onchange="resFormular.value+=' {:RESULT-'+this.value+'} ';resFormular.focus();">
                          @if ($exam->formuls->count())
                          <option value="">انتخاب کنید</option> 
                              @foreach ($exam->formuls as $formul2)
                              <option value="{{$formul2->id}}">{{$formul2->id.') '.$formul2->label}}</option>
                              @endforeach 
                          @else
                          <option value="">ابتدا یک آزمون انتخاب نمایید</option> 
                          @endif
                     </select>  
         </div>  
          <div class="form-row p-3 " >             
             
              <label>  فرمول</label>
              <input type="text" class="form-control text-left"  style="font-family: cursive;" dir="ltr" rows="3" id="resFormular" name="Analysis" placeholder=""  autocomplete="off" value="{{($show=='resformular')?$formul->formul:old('Analysis')}}"  onblur="chk(this.value)"> 
               
              <div class="form-group col-md-12 mt-3 text-left" dir="ltr">
                   <a class="btn btn-primary btn-sm" title="بزرگترین" onclick="resFormular.value+='max( , , , )';resFormular.focus()">Max</a>
                   <a class="btn btn-primary btn-sm" title="کوچکترین" onclick="resFormular.value+='min( , , , )';resFormular.focus()">Min</a>
                   <a class="btn btn-primary btn-sm" title="درصد" onclick="resFormular.value+='/100';resFormular.focus()">%</a>
                   {{-- <a class="btn btn-primary btn-sm" title="تعداد " onclick="resFormular(':count');resFormular.focus()">count</a> --}}
                   <a class="btn btn-primary btn-sm" title="باقی مانده" onclick="resFormular.value+='{:mode}';resFormular.focus()">mode</a>
                   

              </div> 

              
              <div class=" col-md-12 mb-5 border  p-3 " dir="ltr" >
                
                <div class="form-row p-3"  dir="rtl" > 
                    <label>یک فرمول انتخاب کنید: </label>
                        <select class="form-control"  onchange="conditation2.value+=' {:RESULT-'+this.value+'} ';conditation2.focus();">
                            @if ($exam->formuls->count())
                            <option value="">انتخاب کنید</option> 
                                @foreach ($exam->formuls as $formul2)
                                <option value="{{$formul2->id}}">{{$formul2->id.') '.$formul2->label}}</option>
                                @endforeach 
                            @else
                            <option value="">ابتدا یک آزمون انتخاب نمایید</option> 
                            @endif
                        </select>  
            </div> 
                <div class="form-row">
                    <div class="">
                    <label class="">if</label>                                    
                    </div>
                    <div class="col-md-4">
                        <input name="conditation" class="form-control " id="conditation2"  style="font-family: cursive;"/>
                        <div class=" text-left">
                         <a class="btn btn-primary btn-sm " title="نتیجه نهایی" onclick="conditation2.value+=' {:RESULT} ';conditation2.focus()">RESULT</a>
                         <a class="btn btn-warning btn-sm " title="مساوی" onclick="conditation2.value+='==';conditation2.focus()">=</a>
                         <a class="btn btn-warning btn-sm " title="کوچکتر" onclick="conditation2.value+=' < ';conditation2.focus()"><</a>
                         <a class="btn btn-warning btn-sm " title="بزرگتر" onclick="conditation2.value+=' > ';conditation2.focus()">></a>
                         <a class="btn btn-warning btn-sm " title="کوچکتر مساوی" onclick="conditation2.value+=' <= ';conditation2.focus()"><=</a>
                         <a class="btn btn-warning btn-sm " title="بزرگتر مساوی" onclick="conditation2.value+=' >= ';conditation2.focus()">>=</a>
                         <a class="btn btn-warning btn-sm " title="و" onclick="conditation2.value+=' && ';conditation2.focus()">AND</a>
                         <a class="btn btn-warning btn-sm " title="یا" onclick="conditation2.value+=' || ';conditation2.focus()">OR</a>
                        </div>
                    </div>
                    <div class="col-2">
                        <label class="">then</label>                                    
                    </div>
                    <div class="col-md-4">
                        <textarea name="then" class="form-control " id="then2"  rows="3"></textarea>
                        <div class=" text-left">
                            
                                <a class="btn btn-primary btn-sm " title="نتیجه نهایی" onclick="then2.value+=' {:RESULT} ';then2.focus()">RESULT</a>
                                <a class="btn btn-primary btn-sm " title="عنوان نمایش" onclick="then2.value+=' {:LABEL} ';then2.focus()">LABEL</a>
                            
                        </div>
                     </div>
                    <div class="col-1">
                     <a class="btn btn-success" id="setcon2" onclick="setif2('2')">افزودن شرط</a>   
                     <a class="btn btn-warning d-none" id="editcon2" onclick="setif2('2')">ویرایش شرط</a>                   
                        <input type="hidden" id="formulid" name="formulid" value="{{($show=='resformular')?$formul->id:''}}">
                    </div>
                </div>

                <div class="p-3 text-left border" style="overflow: auto;height:10rem;">
                   <table class="table border">
                        <thead>
                        <tr>
                            <th>if</th>
                            <th>then</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody id="ifelse2">
                            @if($show=='resformular' && isset($formul))
                                @foreach($formul->conditations()->get() as $con)
                                <tr>
                                    <td>{{$con->conditation}}</td>
                                    <td>{!!$con->then!!}</td>
                                    <td>
                                        <a class='btn btn-outline-danger' onclick='removeif2(2,{{$con->id}})'><i class='fa fa-trash'></i></a>
                                        <a class='btn btn-outline-warning' onclick='editif2(2,{{$con->id}})'><i class='fa fa-pencil'></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                   </table>
                 <input type="hidden" name="eid" id="eid2" >
                </div>
            </div>
          <div class="form-group col-md-12" >
              <button type="button" class="btn btn-success" style="float:left" onclick="salert('آیا صحت اطلاعات را تایید می کنید؟','Rfrm','');">
                @if(isset($formul))
                بروزرسانی
                 @else
                 افزودن
                @endif
                </button>
              <input type="hidden" name="cid" id="cid2" >
             
          </div>
</form>