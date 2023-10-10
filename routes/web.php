<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// normal users routes
Route::get('/cache-clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    dd('ok');
});
Route::post('/chLang',[App\Http\Controllers\LanguageController::class,'changeLanguage'] )->name('chLang');

Route::get('/survey/{castle}/{payment}/{panel_id}',[App\Http\Controllers\SurveyController::class,'surveyLogin'] );
Route::middleware('auth')->get('/survey-end/{ExamUserid}',[App\Http\Controllers\SurveyController::class,'surveyEnd'] )->name('end.survey');

/*Route::get('/te',function(){
    session(['chk' => "te"]);
    return redirect(route('login'));
    });*/
    Route::get('admin/exams-campaign/{id}/{campaign}/{uid}/export',[App\Http\Controllers\ExamController::class,"export_campaign"])->name('exams.campaign.export');
Route::get('test',[App\Http\Controllers\Panel\PanelController::class,'correctDB'])->name("wel");
Route::get('login',[App\Http\Controllers\Auth\LoginController::class,'index'])->name("login");
Route::get('confirm',[App\Http\Controllers\Auth\LoginController::class,'confirm']);
Route::post('generate',[App\Http\Controllers\SmsController::class,'send'])->name("sendSms");
Route::post('login/{sms}',[App\Http\Controllers\Auth\LoginController::class,'login'])->name("loginConfirmation");
Route::post('generatePassword',[App\Http\Controllers\SmsController::class,'send_PRO'])->name("sendSms.pro");
Route::post('loginUser',[App\Http\Controllers\Auth\LoginController::class,'login_PRO'])->name("login.pro");
Route::group([
        "middleware"=>"auth"
    ],function(){
    Route::get('/',function(){
        return view('panel.dashboard');
    })->name("dashboard");
    
    
    Route::get('/join',function(){
        return view('panel.dashboard_join');
    });
    Route::view('/reality-show','panel.reality-show')->name("rafiq.shafiq");
    
    Route::view('/archives','panel.lives')->name("hamaiesh.list");
    Route::get('/archives-show',function(){$st=request('status')??1;return view("panel.liveShow",compact("st"));})->name("hamaiesh.show");

    Route::get('/logout',[App\Http\Controllers\Auth\LoginController::class,'logout'])->name("logout");
    Route::get('/identify/exams/',[App\Http\Controllers\Panel\PanelController::class,'identifyExams'])->name("identify.exams");
    
    Route::get('/continue/{exam}/{id}',[App\Http\Controllers\Panel\PanelController::class,'continueExam'])->name("continue");
    Route::get('/ComplateInformation/{exam}',[App\Http\Controllers\Panel\PanelController::class,'showmyinfo'])->name("myinfo");
    Route::post('/ComplateInformation/{exam}',[App\Http\Controllers\Panel\PanelController::class,'CompleteInformation'])->name("CompleteInformation");
    Route::get('/answerCount/{exam}',[App\Http\Controllers\ExamController::class,"countMyAnswer"])->name("countMyAnswer");
    Route::get('/generate-exam',[App\Http\Controllers\Panel\PanelController::class,'show_Exam_on_Age'])->name("myExam");
    Route::post('/complate-my-info',[App\Http\Controllers\Panel\PanelController::class,'show_Exam_on_Age'])->name("myExamSetinfo");
   
    Route::get('/exam/cancel/{exam}',[App\Http\Controllers\ExamController::class,"cancelExam"])->name("exam.cancel");
   
    Route::get('/exam/{id}/description',[App\Http\Controllers\Panel\PanelController::class,'showDescription'])->name("showExamDescription");
    Route::get('/conclusion/{id}',[App\Http\Controllers\ExamController::class,"showConclusion"])->name("showConclusion");
    Route::get('/conclusion-new/{id}',[App\Http\Controllers\ExamController::class,"showConclusion_New"])->name("showConclusion.new");
    Route::post('/exam-gift',[App\Http\Controllers\ExamController::class,"setexamgift"])->name("exam.gift");

    Route::get('admin/exam/{id}',[App\Http\Controllers\ExamController::class,"show"])->name('exam.show');
    Route::get('/suggest/exams',[App\Http\Controllers\Panel\PanelController::class,'suggestExams'])->name('suggest.exams');

    Route::view('/Exams-Result',"panel.result")->name('result.exams');
    Route::get('/Exams-Result/{id}',[App\Http\Controllers\ExamController::class,"GetExamResult"])->name('result.exam');
    Route::get('/LastExams-Result',[App\Http\Controllers\ExamController::class,"GetLastExamResult"])->name('result.last.exam');
 Route::get('/Exams-PreRequisite',function(){$st=request('status')??1;return view("panel.showvideo",compact("st"));})->name('pish.video');
    Route::post('/Exams-PreRequisite-save',[App\Http\Controllers\Panel\PanelController::class,"changeStatus"])->name('pish.ok');

});

// admin routes
Route::get('/admin/login',[App\Http\Controllers\Admin\LoginController::class,'index'])->name("adminLogin");
Route::post('/admin/confirm',[App\Http\Controllers\Admin\LoginController::class,'login'])->name("adminConfirm");
Route::group([
    "middleware"=>"admin"
],function(){
    // Route::get('/admin/dashboard',function(){
    //     return view('admin.panel.dashboard');
    // })->name("adminDashboard");
    Route::get('/admin/dashboard',[App\Http\Controllers\UserController::class,'index'])->name("adminDashboard");
    // user routes
    Route::get('/admin/logout',[App\Http\Controllers\Admin\LoginController::class,'logout'])->name("adminLogout");
    Route::get('/admin/users',[App\Http\Controllers\UserController::class,'index'])->name("users");
    Route::get('/admin/user/{id}',[App\Http\Controllers\UserController::class,'show'])->name("showUser");
    Route::put('/admin/user/{id}/active',[App\Http\Controllers\UserController::class,'active'])->name("activeUser");
    Route::put('/admin/user/{id}/deactive',[App\Http\Controllers\UserController::class,'deactive'])->name("deActiveUser");
    Route::get('/admin/create/user',[App\Http\Controllers\UserController::class,'create'])->name("createUser");
    Route::post('/admin/store/user',[App\Http\Controllers\UserController::class,'store'])->name("storeUser");
    Route::get('/admin/user/{id}/edit',[App\Http\Controllers\UserController::class,'edit'])->name("editUser");
    Route::put('/admin/user/{id}/update',[App\Http\Controllers\UserController::class,'update'])->name("updateUser");
    Route::get('/admin/users/export', [App\Http\Controllers\UserController::class, 'export'])->name('users.export');
    // exam routes
    // Route::resource('/admin/exam',App\Http\Controllers\ExamController::class);
    Route::get('admin/exam',[App\Http\Controllers\ExamController::class,"index"])->name('exam.index');
    Route::post('admin/exam',[App\Http\Controllers\ExamController::class,"store"])->name('exam.store');
    Route::get('exam/create',[App\Http\Controllers\ExamController::class,"create"])->name('exam.create');
    Route::put('admin/exam/{id}',[App\Http\Controllers\ExamController::class,"update"])->name('exam.update');
    Route::get('admin/exam/{id}/edit',[App\Http\Controllers\ExamController::class,"edit"])->name('exam.edit');
    Route::get('admin/exams/{id}/export',[App\Http\Controllers\ExamController::class,"export"])->name('exams.export');
    // question routes
    Route::get('/admin/question',[App\Http\Controllers\QuestionController::class,'index'])->name("question.index");
    Route::get('/admin/question/{id}/create',[App\Http\Controllers\QuestionController::class,'create'])->name("question.create");
    Route::post('/admin/question/store',[App\Http\Controllers\QuestionController::class,'store'])->name("question.store");
    Route::get('/admin/question/{id}/edit',[App\Http\Controllers\QuestionController::class,'edit'])->name("question.edit");
    Route::put('/admin/question/{id}',[App\Http\Controllers\QuestionController::class,'update'])->name("question.update");
    Route::get('/admin/AjaxGetQuiz',[App\Http\Controllers\QuestionController::class,'getExamsQuestions'])->name('quiz.get');
    Route::get('/admin/{exam}/questions',[App\Http\Controllers\QuestionController::class,'ExamsQuestions'])->name('quiz.index');
   // answer routes
    Route::post('/admin/answer_update/{id}',[App\Http\Controllers\AnswerController::class,'updateAnswer'])->name('answer.update');
    Route::get('/admin/answer/{id}/edit',[App\Http\Controllers\AnswerController::class,'edit'])->name('answer.edit');
    Route::get('/admin/answers',[App\Http\Controllers\AnswerController::class,'index'])->name('answer.index');
    Route::get('/admin/AjaxGetAnswers',[App\Http\Controllers\AnswerController::class,'getQuestionAsnwers'])->name('answer.get');
   # Route::resource('/admin/answer',App\Http\Controllers\AnswerController::class);
   
   // formula routes
    Route::post('/admin/exams/{exam}/formular/create',[App\Http\Controllers\FormularController::class,'create'])->name('formular.create');
    Route::post('/admin/formular/{formul}/update',[App\Http\Controllers\FormularController::class,'update'])->name('formular.update');
    Route::post('/admin/exams/formular-conditation/check',[App\Http\Controllers\FormularConditationController::class,'check'])->name('conditation.check');
    Route::post('/admin/exams/formular-conditation/create',[App\Http\Controllers\FormularConditationController::class,'create'])->name('conditation.set');
    Route::post('/admin/exams/formular-conditation/update',[App\Http\Controllers\FormularConditationController::class,'update'])->name('conditation.edit');
    Route::post('/admin/exams/formular-conditation/get',[App\Http\Controllers\FormularConditationController::class,'get'])->name('conditation.get');
    Route::post('/admin/exams/formular-conditation/delete',[App\Http\Controllers\FormularConditationController::class,'delete'])->name('conditation.delete');
    Route::get('/admin/exam/{exam}/formular/show/{formul}',[App\Http\Controllers\FormularController::class,'show'])->name('formular.show');
    Route::get('/admin/exam/formular/delete/{formul}',[App\Http\Controllers\FormularController::class,'delete'])->name('formular.delete');
    Route::get('/admin/exams/{exam}/formulars/',[App\Http\Controllers\FormularController::class,'index'])->name('formular.index');
    Route::get('/admin/exams/{exam}/formular/new',[App\Http\Controllers\FormularController::class,'new'])->name('formular.new');
  
   //group route
    Route::get('/admin/group/create',[App\Http\Controllers\GroupController::class,'createView'])->name('group.create');
    Route::post('/admin/group_save',[App\Http\Controllers\GroupController::class,'create'])->name('group.save');
    Route::post('/admin/group_update/{group}',[App\Http\Controllers\GroupController::class,'update'])->name('group.update');
    Route::get('/admin/group/{group}/delete',[App\Http\Controllers\GroupController::class,'delete'])->name('group.delete');
    Route::get('/admin/group/{group}/edit',[App\Http\Controllers\GroupController::class,'edit'])->name('group.edit');
    Route::get('/admin/group/{group}/{law}/edit',[App\Http\Controllers\GroupController::class,'law_edit'])->name('group.law.edit');
    Route::post('/admin/group/{group}/{law}/update',[App\Http\Controllers\GroupController::class,'law_update'])->name('group.law.update');
    Route::get('/admin/group/{group}/{law}/delete',[App\Http\Controllers\GroupController::class,'law_delete'])->name('group.law.delete');
    Route::get('/admin/groups',[App\Http\Controllers\GroupController::class,'index'])->name('group.index');
    Route::get('/admin/answerLawgroup',[App\Http\Controllers\GroupController::class,'lawanswershow'])->name('group.answer.show');
   
    // conclusion routes
    Route::get('/admin/conclusion',[App\Http\Controllers\ConclusionController::class,'index'])->name('conclusion.index');
    Route::get('/admin/conclusion/{id}/create',[App\Http\Controllers\ConclusionController::class,'create'])->name('conclusion.create');
    Route::post('/admin/conclusion',[App\Http\Controllers\ConclusionController::class,'store'])->name('conclusion.store');
    Route::get('/admin/conclusion/{id}/edit',[App\Http\Controllers\ConclusionController::class,'edit'])->name('conclusion.edit');
    Route::put('/admin/conclusion/{id}',[App\Http\Controllers\ConclusionController::class,'update'])->name('conclusion.update');
    // tag routes
    Route::resource('/admin/tag',App\Http\Controllers\TagController::class);
});