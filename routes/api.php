<?php

use App\Http\Controllers\ApiController\ApiController;
use App\Http\Controllers\ApiController\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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


Route::fallback([AuthController::class, 'fallback']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/notifications', [ApiController::class, 'notifications']);

// Route::get('/doctor-by-cat/{id}', [ApiController::class, 'doc_by_cat']);
// Route::get('/doctors', [ApiController::class, 'doctors']);



Route::post('/change-password', [ApiController::class, 'change_password']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/doctor-categories', [ApiController::class, 'doc_cat']);
    Route::post('/cancel-appointment', [ApiController::class, 'cancel_appointment']);



    Route::get('/doctor-by-cat/{id}', [ApiController::class, 'doc_by_cat']);
    Route::get('/doctors', [ApiController::class, 'doctors']);
    Route::post('/fix-appointment', [ApiController::class, 'fix_appointment']);
    Route::get('/my-appointments', [ApiController::class, 'my_appointments']);
    Route::get('/tests', [ApiController::class, 'tests']);
    Route::get('/test-categories', [ApiController::class, 'test_category']);
    Route::get('/test-by-cat/{id}', [ApiController::class, 'test_by_cat']);
    Route::post('/patient-tests', [ApiController::class, 'patient_tests']);
    Route::get('/my-tests', [ApiController::class, 'my_tests']);
    Route::post('/update-profile', [ApiController::class, 'update_profile']);

});



Route::post('/agent/login', [AuthController::class, 'agent_login']);

Route::middleware('auth:sanctum')->prefix('agent')->group(function () {


    Route::post('/change-notification-id', [ApiController::class, 'change_notification_id']);

    Route::post('/withdraw', [ApiController::class, 'withdraw']);

    Route::get('/balance', [ApiController::class, 'balance']);

    Route::get('/doctor-categories', [ApiController::class, 'doc_cat']);
    Route::get('/doctor-by-cat/{id}', [ApiController::class, 'doc_by_cat']);
    Route::get('/doctors', [ApiController::class, 'doctors']);

    Route::post('/fix-appointment', [ApiController::class, 'agent_fix_appointment']);
    Route::get('/agent-appointments', [ApiController::class, 'agent_appointments']);

    Route::get('/tests', [ApiController::class, 'tests']);

    Route::get('/test-categories', [ApiController::class, 'test_category']);

    Route::get('/test-by-cat/{id}', [ApiController::class, 'test_by_cat']);

    Route::post('/patient-tests', [ApiController::class, 'agent_patient_tests']);
    Route::get('/agent-tests', [ApiController::class, 'agent_tests']);
    //Route::post('/update-profile', [ApiController::class, 'update_profile']);

    Route::post('/logout', [AuthController::class, 'logout']);

});

Route::get('/agent/{id}', [ApiController::class, 'agent']);


Route::post('/compounder/login', [AuthController::class, 'compounder_login']);

Route::middleware('auth:sanctum')->prefix('compounder')->group(function () {
    Route::post('/change-notification-id', [ApiController::class, 'change_notification_id_com']);
    Route::get('/doctors',[ApiController::class, 'compounder_doctors']);
    Route::get('/hospitals',[ApiController::class, 'compounder_hospitals']);
    Route::get('/appointments/{id}',[ApiController::class, 'compounder_appointments']);
    Route::get('/tests/{id}',[ApiController::class, 'compounder_tests']);


    Route::post('/update-appointment',[ApiController::class, 'compounder_appointment_update']);
    Route::post('/update-test',[ApiController::class, 'compounder_test_update']);


    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::get('/hospital-compounder/{id}', [ApiController::class, 'hospital_compounder']);
Route::get('/doctor-compounder/{id}', [ApiController::class, 'doctor_compounder']);

