
    @if(isset($edit))
    <div class="card col-md-12 mb-2 p-0">
        <h5 class="card-header" >مجموعه سوالات گروه جدید</h5>
        <div class="card-body">
           
                        {{-- <div class="form-group"> 
                            <label>یک آزمون انتخاب کنید: </label>
                                       <select class="form-control" name="exams" id="exams" onchange="changequiz(this.value)">
                                        <option value="" disabled selected>انتخاب کنید</option>
                                           @foreach ($exams as $exam)
                                              <option value="{{$exam->id}}">{{$exam->name}}</option>
                                           @endforeach   
                                       </select>                    
                       </div> --}}
                       <div class="form-group"> 
                             <label>یک سوال انتخاب کنید: </label>
                                   <select class="form-control" name="question" id="quiz" onchange="setquestion(this.value)">
                                        
                                   </select>  
                       </div>                     
                       <div class="form-group">
                            <label>مجموعه سوالات</label>
                            <label class="text-danger p-2">{{($errors->has('qids'))?'(الزامی)':''}}</label>
                            <div class="form-control text-right overflow-auto" name="questions"  id="listqid" style="height:5rem" >
                               
                                    لیست خالی است ...  
                               
                            </div>
                        </div>
                        <div class="form-group col-md-12" >
                            <input type="hidden" name="qids" id="qids" value="">
                            <input type="hidden" name="qidset" value="1">
                        </div>
                    
        </div>
    </div>
    @else
    <div class="card">
        <h5 class="card-header" >مجموعه سوالات:{{$group->name}}</h5>
        <div class="card-body">
            <form action="{{route('group.update',[$group->id])}}" method="post" enctype="multipart/form-data" id="Qfrm">
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
                       <div class="form-group"> 
                             <label>یک سوال انتخاب کنید: </label>
                                   <select class="form-control" name="question" id="quiz" onchange="setquestion(this.value)">
                                        @if ($questions->count())
                                        <option value="">انتخاب کنید</option> 
                                            @foreach ($questions as $quiz)
                                            <option value="{{$quiz->id}}">{{$quiz->name}}</option>
                                            @endforeach 
                                              
                                        @elseif($group->exam_id)
                                        <option value="">تمامی سوالات این آزمون گروه بندی شدند</option>                                       
                                        @else
                                        <option value="">ابتدا یک آزمون انتخاب نمایید</option> 
                                        @endif
                                   </select>  
                       </div>                     
                       <div class="form-group">
                            <label>مجموعه سوالات</label>
                            <label class="text-danger p-2">{{($errors->has('qids'))?'(الزامی)':''}}</label>
                            <div class="form-control text-right overflow-auto" name="questions"  id="listqid" style="height:5rem" >
                               
                                @if($group->questions()->count()==0)
                                    لیست خالی است ...  
                                @else
                                    @foreach ($group->questions()->get() as $index=>$item)
                                    
                                         <span onclick="setquestion('{{$item->question_id}}',1)"  class="btn btn-info btn-sm m-2">{{$item->question_id.'.'.$item->question->name}}<b class="p-2 fa fa-close">×</b></span>                                        
                                   
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        {{-- @if($group->questions()->count()>0)
                        <label class="d-block text-right">
                            <input type="checkbox" name="formular" {{ ($group->formul)?"checked":''}} value="1" onchange="document.getElementById('formul').classList.toggle('d-none');">
                            افزودن فرمول</label>
                        <div class="form-group col-md-12 {{($group->formul)?'':"d-none"}} border"  id="formul">
                            @php
                                if($group->formul)
                                {
                                    $formular=json_decode($group->formul);
                                    $ids=implode(',',(Array)json_decode($formular->ids));
                                    $conditation=json_decode($formular->conditation);
                                }
                                else 
                               { $formular=[];$ids=null;
                                $conditation=json_decode('{"if":"","then":"","else":""}');}
                            @endphp
                            <input type="hidden" class="form-control" name="ids" id="fids" value="{{$ids}}">
                            <label for=""> عنوان برای نمایش</label>
                            <input type="text" class="form-control" name="lbl" value="{{($formular)?$formular->label:''}}">
                            <label for="AnalysisFo">  فرمول</label>
                            <label class="text-danger p-2">{{($errors->has('Formular'))?'(الزامی)':''}}</label>
                            <input type="text" class="form-control text-left" dir="ltr" rows="3" id="txtFormular" name="Analysis" placeholder=""  autocomplete="off" value="{{($formular)?$formular->formul:''}}"> 
                            
                            <div class="form-group col-md-12 mt-3 text-left" dir="ltr">
                                    <div style="overflow: auto;height:10rem;text-align: right;" dir="rtl">
                                        @foreach ($group->questions()->get() as $index=>$item)
                                        
                                            <span onclick="txtFormular.value+='{{' {:'.$item->question_id.'} '}}';fids.value=fids.value+','+{{$item->question_id}};txtFormular.focus()"  class="btn btn-info btn-sm m-2">
                                                <b class="p-2 fa fa-close">+</b>
                                                {{$item->question_id.'.'.$item->question->name}}</span>                                        
                                    
                                        @endforeach
                                    </div>
                            </div>  
                            <div class="form-group col-md-12 mt-3 text-left" dir="ltr">
                                 <a class="btn btn-primary btn-sm" title="درصد" onclick="formularset(':%');txtFormular.focus()">%</a>
                                 <a class="btn btn-primary btn-sm" title="تعداد " onclick="formularset(':count');txtFormular.focus()">count</a>
                                 <a class="btn btn-primary btn-sm" title="باقی مانده" onclick="formularset(':mode');txtFormular.focus()">mode</a>
                            </div>    
                            <div class=" col-md-12 mb-5" dir="ltr">
                                <div class="form-row">
                                    <div class="col-2">
                                    <label class=""> if</label>                                    
                                    </div>
                                    <div class="col">
                                        <input type="text" id="conditation" class="form-control " name="conditation" value="{{$conditation->if}}">
                                    </div>
                                    <div class="col-3 text-left ">
                                        <a class="btn btn-danger btn-sm" title="نتیجه نهایی" onclick="conditation.value+='{:RESULT}';conditation.focus()">RESULT</a>
                                    </div>
                                </div>
                                <div class="form-row mt-3">
                                    <div class="col-2">
                                    <label class="">then</label>                                    
                                    </div>
                                    <div class="col">
                                        <textarea id="result" class="form-control " name="result" rows="2" >{{$conditation->then}}</textarea>
                                    </div>
                                    <div class="col-3 text-left">
                                        <a class="btn btn-warning btn-sm " title="نتیجه نهایی" onclick="result.value+='{:RESULT}';result.focus()">RESULT</a>
                                    </div>
                                </div>
                                <div class="form-row mt-3">
                                    <div class="col-2">
                                    <label class="">else</label>                                    
                                    </div>
                                    <div class="col">
                                        <textarea id="resultelse" class="form-control " name="resultelse" rows="2" >{{$conditation->else}}</textarea>
                                    </div>
                                    <div class="col-3 text-left">
                                        <a class="btn btn-info btn-sm " title="نتیجه نهایی" onclick="resultelse.value+='{:RESULT}';resultelse.focus()">RESULT</a>
                                    </div>
                                </div>
                            </div>                 
                        </div>
                        @endif --}}
                        <div class="form-group col-md-12" >
                            <button type="button" class="btn btn-{{($group->questions()->count())?'warning':'success'}}" style="float:left" onclick="salert('آیا صحت اطلاعات را تایید می کنید؟','Qfrm','');">{{($group->questions()->count())?"ویرایش":"افزودن"}}</button>
                            <input type="hidden" name="qids" id="qids" value="{{implode(',',json_decode($group->questions()->pluck('question_id')))}}">
                            <input type="hidden" name="qidset" value="1">
                        </div>
                    </form>
        </div>
    </div>
    @endif