<nav class="navbar navbar-expand-lg navbar-light bg-light" style="direction:rtl;">
    <a class="navbar-brand mx-5" href="{{route('adminDashboard')}}">سامانه رشد خوش نظر</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-item nav-link mx-3" id="user" href="{{route('users')}}">کاربران <span class="sr-only">(current)</span></a>
        <a class="nav-item nav-link mx-3" id="exam" href="{{route('exam.index')}}">آزمون ها</a>
        <a class="nav-item nav-link mx-3" id="group" href="{{route('group.index')}}">گروه بندی سوالات</a>
        <a class="nav-item nav-link mx-3" id="question" href="{{route('question.index')}}">سوالات</a>
        <a class="nav-item nav-link mx-3" id="answer" href="{{route('answer.index')}}">پاسخ ها</a>
        <a class="nav-item nav-link mx-3" id="conclusion" href="{{route('conclusion.index')}}">نتایج</a>
        <a class="nav-item nav-link mx-3" id="tag" href="{{route('tag.index')}}">شناسه ها</a>
        <a class="nav-item btn btn-outline-danger mx-3" href="{{route('adminLogout')}}">خروج</a>
      </div>
    </div>
</nav>