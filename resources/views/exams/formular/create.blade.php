<form action="{{route('formular.create',[$exam->id])}}" method="post" enctype="multipart/form-data" id="Qfrm">
  @csrf
          {{-- <div class="form-group"> 
              <label>یک آزمون انتخاب کنید: </label>
                         <select class="form-control" name="exams" id="exams" onchange="changequiz(this.value)">
                          <option value="" disabled selected>انتخاب کنید</option>
                             @foreach ($exams as $exam)
                                <option value="{{$exam->id}}">{{$exam->name}}</option>
                             @endforeach   
                         </select>                    
         </div> --}}
         <input type="hidden" value="ins" name="type">
         <div class="form-row p-3"> 
               <label>یک سوال انتخاب کنید: </label>
                     <select class="form-control"  id="quiz" onchange="txtFormular.value+=' {:'+this.value+'} ';fids.value=fids.value+','+this.value;txtFormular.focus()">
                          @if ($exam->questions->count())
                          <option value="">انتخاب کنید</option> 
                              @foreach ($exam->questions as $quiz)
                              <option value="{{$quiz->id}}">{!!$quiz->id.') '.$quiz->name!!}</option>
                              @endforeach 
                          @else
                          <option value="">ابتدا یک آزمون انتخاب نمایید</option> 
                          @endif
                     </select>  
         </div>  
          <div class="form-row p-3 " >

              <input type="hidden" class="form-control" name="ids" id="fids" value="{{old('ids')}}">
              <label for=""> عنوان برای نمایش (LABEL)</label>
              <input type="text" class="form-control" name="lbl" id="lbl" value="{{old('lbl')}}">
              <label for="AnalysisFo">  فرمول</label>
              <input type="text" class="form-control text-left"  style="font-family: cursive;" dir="ltr" rows="3" id="txtFormular" name="Analysis" placeholder=""  autocomplete="off" value="{{old('Analysis')}}" onblur="chk(this.value)"> 
               
              <div class="form-group col-md-12 mt-3 text-left" dir="ltr">
                   <a class="btn btn-primary btn-sm" title="درصد" onclick="txtFormular.value+='/100';txtFormular.focus()">%</a>
                   {{-- <a class="btn btn-primary btn-sm" title="تعداد " onclick="formularset(':count');txtFormular.focus()">count</a> --}}
                   <a class="btn btn-primary btn-sm" title="باقی مانده" onclick="txtFormular.value+='{:mode}';txtFormular.focus()">mode</a>
                   

              </div> 

              <div class=" col-md-12 mb-5 border  p-3 " dir="ltr" >
                <div class="form-row">
                    <div class="">
                    <label class="">if</label>                                    
                    </div>
                    <div class="col-md-4">
                        <input name="conditation"  style="font-family: cursive;" class="form-control " id="conditation1"  />
                        <div class=" text-left">
                         <a class="btn btn-primary btn-sm " title="نتیجه نهایی" onclick="conditation1.value+=' {:RESULT} ';conditation1.focus()">RESULT</a>
                         <a class="btn btn-warning btn-sm " title="مساوی" onclick="conditation1.value+='==';conditation1.focus()">=</a>
                         <a class="btn btn-warning btn-sm " title="کوچکتر" onclick="conditation1.value+=' < ';conditation1.focus()"><</a>
                         <a class="btn btn-warning btn-sm " title="بزرگتر" onclick="conditation1.value+=' > ';conditation1.focus()">></a>
                         <a class="btn btn-warning btn-sm " title="کوچکتر مساوی" onclick="conditation1.value+=' <= ';conditation1.focus()"><=</a>
                         <a class="btn btn-warning btn-sm " title="بزرگتر مساوی" onclick="conditation1.value+=' >= ';conditation1.focus()">>=</a>
                         <a class="btn btn-warning btn-sm " title="و" onclick="conditation1.value+=' && ';conditation1.focus()">AND</a>
                         <a class="btn btn-warning btn-sm " title="یا" onclick="conditation1.value+=' || ';conditation1.focus()">OR</a>
                        </div>
                    </div>
                    <div class="col-2">
                        <label class="">then</label>                                    
                    </div>
                    <div class="col-md-4">
                        <textarea name="then" class="form-control " id="then1"  rows="3"></textarea>
                        <div class=" text-left">
                            
                                <a class="btn btn-primary btn-sm " title="نتیجه نهایی" onclick="then1.value+=' {:RESULT} ';then1.focus()">RESULT</a>
                                <a class="btn btn-primary btn-sm " title="عنوان نمایش" onclick="then1.value+=' {:LABEL} ';then1.focus()">LABEL</a>
                            
                        </div>
                     </div>
                    {{-- <div class="col-1">
                     <a class="btn btn-success" onclick="setif()">افزودن شرط</a>
                     <input type="hidden" name="FC" id="fc" value="">
                     <input type="hidden" name="type" value="ins">
                    </div>
                </div>

                <div id="ifelse" class="p-3 text-left border" style="overflow: auto;height: 5rem;">
                   
                </div> --}}
                    <div class="col-1">
                        <a class="btn btn-success" id="setcon1" onclick="setif2('1')">افزودن شرط</a>   
                        <a class="btn btn-warning d-none" id="editcon1" onclick="setif2('1')">ویرایش شرط</a> 
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
                       <tbody id="ifelse1">
                          
                       </tbody>
                  </table>
                <input type="hidden" name="eid" id="eid1" >
               </div>
            </div>
                        
              <div class=" col-md-12 mb-5" dir="ltr">
                  <div class="form-row mt-3">
                      <div class="col-2">
                      <label class="">default <i data-toggle="tooltip" data-placement="bottom" title="همیشه در ابتدای نتیجه نمایش داده می شود" class="text-primary fa fa-info-circle"></i></label>                              
                      </div>
                      <div class="col">
                          <textarea id="resultdefault" class="form-control " name="default" rows="2" >{{old('default')}}</textarea>
                      </div>
                      <div class="col-3 text-left">
                          <a class="btn btn-info btn-sm " title="نتیجه نهایی" onclick="resultdefault.value+='{:RESULT}';resultdefault.focus()">RESULT</a>
                          <a class="btn btn-info btn-sm " title="عنوان نمایش" onclick="resultdefault.value+='{:LABEL}';resultdefault.focus()">LABEL</a>
                      </div>
                  </div>
              </div>                 
          </div>
          <div class="form-group col-md-12" >
              <button type="button" class="btn btn-success" style="float:left" onclick="salert('آیا صحت اطلاعات را تایید می کنید؟','Qfrm','');">افزودن</button>
              <input type="hidden" name="formulset" value="1">
              <input type="hidden" name="cid" id="cid1" value="{{old('cid')}}">
          </div>
</form>