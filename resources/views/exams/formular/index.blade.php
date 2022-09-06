
      <table class="table">
          <thead class="thead-dark">
            <tr>
              <th scope="col">شناسه</th>
              <th scope="col">عنوان</th>
              <th scope="col">آزمون</th>
              <th scope="col">سوالات</th>
              <th scope="col"></th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            @foreach($exam->formuls()->get() as $eformul)
            <tr>
              <th scope="row">{{$eformul->id}}</th>
              <td>{{$eformul->label}}</td>
              <td>{{$exam->name}}</td>
              {{--<td>{{illuminate\Support\Str::words($exam->description,12)}}</td>--}}
              <td>
                  <div style="overflow: auto;height: 5rem;text-align: right;">
                  @foreach((Array)json_decode($eformul->questions) as $id)  
                  @php
                      $quiz=\App\Models\Question::find($id);
                  @endphp           
                  <span class=" btn btn-outline-info mt-2" onclick="document.location.href='{{route('question.edit',$quiz->id)}}'">{{$quiz->name}}</span>
                 
                  @endforeach
                    @if($eformul->type==2)
                    <label class="btn btn-outline-info disabled">فرمول نویسی با نتایج</label>
                    @endif
                  </div>
              </td>
              <td><a class="btn btn-info" href="{{route('formular.show',['exam'=>$exam->id,'formul'=>$eformul->id])}}">ویرایش</a></td>
              <td><a class="btn btn-danger" href="{{route('formular.delete',[$eformul->id])}}">حذف</a></td>
            </tr>
            @endforeach
          </tbody>
        </table>