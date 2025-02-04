<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

Route::post('requests', [RequestController::class, 'store']);

Route::post('forgot-password', [PasswordController::class, 'sendResetCode']);
Route::post('reset-password', [PasswordController::class, 'resetPassword']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [UserController::class, 'logout']);
    Route::get('profile', [UserController::class, 'profile']);
    Route::post('profile', [UserController::class, 'editProfile']);

    Route::post('change-password', [PasswordController::class, 'update']);

    Route::middleware('role:admin')->group(function () {
        Route::get('requests/', [RequestController::class, 'index']);
        Route::post('requests/{request}/change-status', [RequestController::class, 'changeStatus']);
    });

    Route::apiResource('courses', CourseController::class);
    Route::apiResource('lessons', LessonController::class)->except('index');

    Route::post('files',[FileController::class,'store']);
    Route::delete('files/{file}',[FileController::class,'destroy']);

    Route::post('/accounts/charge',[\App\Http\Controllers\AccountController::class,"chargeAccount"]);
    Route::post('/payment-course/{course}',[UserController::class,'paymentCourse']);


});

