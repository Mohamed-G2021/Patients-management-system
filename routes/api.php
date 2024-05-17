<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\tests\OsteoporosisTestController;
use App\Http\Controllers\api\tests\OvarianCancerTestController;
use App\Http\Controllers\api\tests\PreEclampsiaTestController;
use App\Http\Controllers\api\tests\UterineCancerTestController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\tests\GeneralExaminationController;
use App\Http\Controllers\api\tests\GynaecologicalHistoryTestController;
use App\Http\Controllers\api\tests\ObstetricHistoryTestController;
use App\Http\Controllers\api\tests\CervixCancerTestController;
use App\Http\Controllers\api\PatientController;
use App\Http\Controllers\api\tests\BreastCancerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/auth/user', function (Request $request) {
    return Auth::guard('sanctum')->user();
});

Route::resource('doctors', UserController::class);

Route::resource('patients', PatientController::class);
Route::get('patients/search/{patient_code}',[PatientController::class,'search']);

Route::resource('general-examination', GeneralExaminationController::class);
Route::resource('obstetrics',ObstetricHistoryTestController::class);
Route::resource('cervix',CervixCancerTestController::class);
Route::resource('gynaecological',GynaecologicalHistoryTestController::class);
Route::resource('breast',BreastCancerController::class);
Route::resource('osteoporosis',OsteoporosisTestController::class);
Route::resource('ovarian',OvarianCancerTestController::class);
Route::resource('pre-eclampsia',PreEclampsiaTestController::class);
Route::resource('uterine',UterineCancerTestController::class);

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::delete('logout', [AuthController::class, 'logout'])
    ->middleware('auth:sanctum');
Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('reset-password', [AuthController::class, 'resetPassword']);

Route::get('patients/{id}/history', [PatientController::class, 'getPatientHistory']);
Route::get('doctors/{id}/history', [UserController::class, 'getDoctorHistory']);
Route::get('admins/{id}/history', [UserController::class, 'getAdminHistory']);

Route::get('patients/get-patient/{national_id}', [PatientController::class, 'getPatientByNationalId']);