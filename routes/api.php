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
Route::post('/history',[ApiController::class,'getAllExamUserHistory']);
Route::post('/All',[ApiController::class,'getAllExamUserHistory_New']);
Route::post('/setRead',[ApiController::class,'setExamRead']);
Route::post('/ExamCount',[ApiController::class,'getCountExam']);
Route::post('/ExamAnalyisis',[ApiController::class,'ExamAnalyisis']);
Route::get('/UserPhoneCheck',[ApiController::class,'CheckNumber']);
Route::post('/TalentExam',[ApiController::class,'getTalentExamUserHistory']);