<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Api\ApiController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login',[LoginController::class,'login']);
Route::post('/save',[ApiController::class,'saveExamQuestionAnswerRecord'])->name('save');
Route::post('/check',[ApiController::class,'checkUser']);
Route::post('/exams',[ApiController::class,'userExams']);
Route::post('/result',[ApiController::class,'examResults']);
Route::post('/talent',[ApiController::class,'addTalentScore']);
Route::post('/today',[ApiController::class,'getCountTodayExams']);
Route::post('/AllExamCount',[ApiController::class,'getCountDateExams']);
Route::post('/history',[ApiController::class,'getAllExamUserHistory']);
Route::post('/All',[ApiController::class,'getAllExamUserHistory_New']);
Route::post('/setRead',[ApiController::class,'setExamRead']);
Route::post('/ExamCount',[ApiController::class,'getCountExam']);
Route::post('/ExamAnalyisis',[ApiController::class,'ExamAnalyisis']);
Route::get('/UserPhoneCheck',[ApiController::class,'CheckNumber']);
Route::post('/TalentExam',[ApiController::class,'getTalentExamUserHistory']);
Route::post('/GetUser',[ApiController::class,'getUserInfo']);
Route::post('/SetCron',[ApiController::class,'savecronjobs']);
Route::get('/DeActiveUser',[ApiController::class,'runcronjob']);
Route::post('/UserStatus',[ApiController::class,'UserStatus']);
Route::get('/UserPanel',[ApiController::class,'UserPanel']);
Route::post('/addLogSMS',[ApiController::class,'addLogApi']);
Route::post('/PhoneUsers',[ApiController::class,'getPhoneExamUsers']);
Route::post('/Exam/addRequest',[ApiController::class,'addRquestINPanel']);

Route::post('/UpdateUserInfo',[ApiController::class,'updateuserinfo']);
Route::post('PRO/All',[ApiController::class,'getAllExamUserHistory_PRO']);
Route::post('PRO/ExamCount',[ApiController::class,'getCountExam_PRO']);
Route::post('PRO/today',[ApiController::class,'getCountTodayExams_PRO']);