@if(isset($edit))
<div class="card col-md-6 mb-2 p-0 invisible">
    <h5 class="card-header" >لیست قوانین </h5>
    <div class="card-body">

        <form action="" method="post" enctype="multipart/form-data" >
             @csrf
            @php
               
            @endphp
            <div class="form-row border p-3 mb-3">
                <label>گزینه ها</label>
                <div class="form-group col-md-12 overflow-auto border" style=" max-height: 20rem;">
                    <fieldset>      
                        <legend> </legend> 
                                <p>مجموعه سوالات خالیست</p>                            
                          
                    </fieldset>
                
                </div>
                <hr>
                
                <div class="form-group col-md-12">
                    <label>قوانین انتخابی</label>
                    <label class="text-danger p-2">{{($errors->has('Aids'))?'(الزامی)':''}}</label>
                    <div class="form-control text-right overflow-auto" name="answers"  id="listAid" style="height:5rem" >
                   
                        لیست خالی است ...                                   
                   
                     </div>
                </div>
                
                    <div class="form-group col-md-3 mt-2">
                        <label for="value">نوع تحلیل</label>
                        <select name="type" class="form-control" id="AnswerType" style="text-align: center;" onchange="changetype(this.value)">
                            <option value="text" {{(old('type')=="text")?'selected':''}} >متن</option>
                            <option value="audio" {{(old('type')=="audio")?'selected':''}}>صوت</option>
                            <option value="video" {{(old('type')=="video")?'selected':''}}>فیلم</option>
                            <option value="image" {{(old('type')=="image")?'selected':''}}>تصویر</option>
                            {{-- <option value="formular" {{(old('type')=="formular")?'selected':''}}>فرمول</option> --}}
                        </select>
                    </div>
                    <div class="form-group col-md-9 " id="txt">
                        <label for="AnswerAnalysis">  تحلیل</label>
                        <label class="text-danger p-2">{{($errors->has('AnswerAnalysis'))?'(الزامی)':''}}</label>
                        <input type="text" class="form-control"  id="AnswerAnalysis" name="AnswerAnalysis" placeholder="متن مورد نظر را وارد نمایید"  autocomplete="off" style="text-align: center;" value="{{(isset($law))?$law->result:old('AnswerAnalysis')}}">
                    </div>
                        
                    <div class="form-group col-md-9 d-none"  id="file">
                        <label for="AnswerAnalysisF">  تحلیل</label>
                        <label class="text-danger p-2">{{($errors->has('AnswerAnalysis'))?'(الزامی)':''}}</label>
                        <input type="file" class="form-control" id="AnswerAnalysisF" name="AnswerAnalysis" placeholder="فایل مورد نظر را انتخاب نمایید"  autocomplete="off" 
                        style="text-align: center;" >                        
                    
                    </div>

                    <div class="form-group col-md-9 d-none"  id="formul">
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
        </form>
    </div>
</div>
@else
<div class="card">
    <h5 class="card-header" >ویرایش قوانین  :{{$group->name}}{{(isset($law))?'- دسته '.$law->id:''}}</h5>
    <div class="card-body">

        <form action="{{(isset($law))?route('group.law.update',[$group->id,$law->id]):route('group.update',[$group->id])}}" method="post" enctype="multipart/form-data" id="Lfrm">
             @csrf
            @php
                $quiz=json_decode($group->questions)??[];
                    $lbl=(isset($law))?$law->label:[];
            @endphp
            <div class="form-row border p-3 mb-3">
                <label> گزینه ها</label>
               
                <div class="form-group col-md-12 overflow-auto border" style=" max-height: 20rem;">
                    <fieldset>      
                        <legend> </legend>  
                        
                        @if($group->questions()->count())
                            @foreach ($group->questions()->get() as $question)
                            @php
                            $albha = 'a';
                            $char=1; $char < 'z';
                            $answers=$question->question->answers()->get();
                            @endphp
                                
                                @foreach ($answers as $answer)
                                <div class="list-group" style=" direction: ltr; ">
                                    <label class="list-group-item ">
                                    <input class="form-check-input me-1" {{(in_array($question->question->id.$albha,$lbl))?"checked":''}} onchange="chlistAid('{{$question->question->id.$albha}}','{{$answer->id}}',this.checked);" type="checkbox"value="{{$answer->id}}" id="{{$question->question->id.$albha}}" name="Aids[]">
                                   
                                    @php
                                        $img=($answer->type=="text")?"":"<img src='".$answer->link."' style='width: 5rem;height: 5rem;'/>";
                                    @endphp
                                     {{$question->question->id}}{{$albha++.' )'}}{{($answer->type=="video")?'فیلم':(($answer->type=="image")?'تصویر':(($answer->type=="audio")?'صوت':$answer->name))}}
                                    </label>
                                
                                </div>
                                            
                                @endforeach
                                @if (!$loop->last)
                                <p></p>
                                @endif
                                @endforeach
                            @else
                                <p>مجموعه سوالات خالیست</p>                            
                            @endif
                            
                    </fieldset>
                
                </div>
                <hr>
                
                <div class="form-group col-md-12">
                    <label>قوانین انتخابی</label>
                    <label class="text-danger p-2">{{($errors->has('Aids'))?'(الزامی)':''}}</label>
                    <div class="form-control text-right overflow-auto" name="answers"  id="listAid" style="height:5rem" >
                    @if (isset($law))
                    @foreach($law->label as $item)
                        <span onclick="rmlist('{{$item}}')"  class="btn btn-info btn-sm m-2">{{$item}}<b class="p-2 fa fa-close">*</b></span>
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
                            {{-- <option value="formular" {{((old('type')??$law->type)=="formular")?'selected':''}}>فرمول</option> --}}
                        </select>
                    </div>
                    <div class="form-group col-md-9 {{($law->type=='text')?'':'d-none'}} " id="txt">
                        <label for="AnswerAnalysis">  تحلیل</label>
                        <label class="text-danger p-2">{{($errors->has('AnswerAnalysis'))?'(الزامی)':''}}</label>
                        <input type="text" class="form-control"  id="AnswerAnalysis" name="AnswerAnalysis" placeholder="متن مورد نظر را وارد نمایید"  autocomplete="off" style="text-align: center;" value="{{($law->type=='text')?$law->result:old('AnswerAnalysis')}}">
                    </div>
                        
                    <div class="form-group col-md-9 {{($law->type!='text')?'':'d-none'}} "  id="file">
                        <label for="AnswerAnalysisF">  تحلیل</label>
                        <label class="text-danger p-2">{{($errors->has('AnswerAnalysis'))?'(الزامی)':''}}</label>
                        <input type="file" class="form-control" id="AnswerAnalysisF" name="AnswerAnalysis" placeholder="فایل مورد نظر را انتخاب نمایید"  autocomplete="off" 
                        style="text-align: center;" >                        
                    
                    </div>

                    <div class="form-group col-md-9 d-none"  id="formul">
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

                        @if($law->type!='text' && $law->type!='image')
                            <div class='col-12 justify-content-center'>
                                <{{$law->type}}  controls style='width:100%;height: 10rem;'>
                                <source src='{{$law->result}}'>
                                Your browser does not support the {{$law->type}} player.</{{$law->type}}>
                            </div> 
                        @else                        
                            <div class='col-12 justify-content-center'>
                                <img  src='{{$law->result}}' style='width:100%'>
                                
                            </div>                                  
                        @endif
                @else
                    <div class="form-group col-md-3 mt-2">
                        <label for="value">نوع تحلیل</label>
                        <select name="type" class="form-control" id="AnswerType" style="text-align: center;" onchange="changetype(this.value)">
                            <option value="text" {{(old('type')=="text")?'selected':''}} >متن</option>
                            <option value="audio" {{(old('type')=="audio")?'selected':''}}>صوت</option>
                            <option value="video" {{(old('type')=="video")?'selected':''}}>فیلم</option>
                            <option value="image" {{(old('type')=="image")?'selected':''}}>تصویر</option>
                            <option value="formular" {{(old('type')=="formular")?'selected':''}}>فرمول</option>
                        </select>
                    </div>
                    <div class="form-group col-md-9 " id="txt">
                        <label for="AnswerAnalysis">  تحلیل</label>
                        <label class="text-danger p-2">{{($errors->has('AnswerAnalysis'))?'(الزامی)':''}}</label>
                        <input type="text" class="form-control"  id="AnswerAnalysis" name="AnswerAnalysis" placeholder="متن مورد نظر را وارد نمایید"  autocomplete="off" style="text-align: center;" value="{{(isset($law))?$law->result:old('AnswerAnalysis')}}">
                    </div>
                        
                    <div class="form-group col-md-9 d-none"  id="file">
                        <label for="AnswerAnalysisF">  تحلیل</label>
                        <label class="text-danger p-2">{{($errors->has('AnswerAnalysis'))?'(الزامی)':''}}</label>
                        <input type="file" class="form-control" id="AnswerAnalysisF" name="AnswerAnalysis" placeholder="فایل مورد نظر را انتخاب نمایید"  autocomplete="off" 
                        style="text-align: center;" >                        
                    
                    </div>

                    <div class="form-group col-md-9 d-none"  id="formul">
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
                    
                @endif
            
                <div class="form-group col-md-12" >
                    <button type="button" class="btn btn-{{(isset($law))?'warning':'success'}}" style="float:left" onclick="salert('آیا صحت اطلاعات را تایید می کنید؟','Lfrm','');">{{(isset($law))?"ویرایش":"افزودن"}}</button>
                    
                </div>
                <input type="hidden" name="lbls" id="Aids" value="{{(isset($law))?implode(',',$law->label):''}}">
            </div>
        </form>
    </div>
</div>
@endif