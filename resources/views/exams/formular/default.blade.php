<form action="{{route('formular.create',[$exam->id])}}" method="post" enctype="multipart/form-data" id="Dfrm">
  @csrf 
  <input type="hidden" value="def" name="type">
  <input type="hidden" value="1" name="top">
         <div class="form-row p-3"> 
               <label>یک فرمول انتخاب کنید: </label>
                     <select class="form-control"  onchange="deftxtFormular.value+=' {:RESULT-'+this.value+'}  {:LABEL-'+this.value+'} ';deftxtFormular.focus();">
                          @if ($exam->formuls->count())
                          <option value="">انتخاب کنید</option> 
                              @foreach ($exam->formuls as $formul)
                              <option value="{{$formul->id}}">{{$formul->id.') '.$formul->label}}</option>
                              @endforeach 
                          @else
                          <option value="">ابتدا یک آزمون انتخاب نمایید</option> 
                          @endif
                     </select>  
         </div>  
              @php
              $def=$exam->conditation()->where('default',1)->first();    
              @endphp

              <div class=" col-md-12 mb-5 border  p-3 " dir="ltr" >
                <div class="form-row">
                    <div class="col">
                        <textarea name="body" class="form-control " rows="10" id="deftxtFormular" >{{$def->body??''}}</textarea>
                    </div>
                    
                </div>
            </div>  
          <div class="form-group col-md-12" >
              <button type="button" class="btn btn-success" style="float:left" onclick="salert('آیا صحت اطلاعات را تایید می کنید؟','Dfrm','');">افزودن</button>
              
          </div>
</form>