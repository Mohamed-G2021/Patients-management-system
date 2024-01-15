<?php

use App\Http\Controllers\api\AdminController;
use App\Http\Controllers\api\DoctorController;
use App\Http\Controllers\api\GeneralExaminationController;
use App\Http\Controllers\api\GynaecologicalHistoryTestController;
use App\Http\Controllers\api\ObstetricHistoryTestController;
use App\Http\Controllers\api\PatientController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('admins',[AdminController::class, 'index']);
Route::post('admins',[AdminController::class, 'store']);
Route::post('admins/{id}',[AdminController::class, 'update']);
Route::delete('admins/{id}',[AdminController::class, 'destroy']);

Route::get('doctors',[DoctorController::class, 'index']);
Route::get('doctors/{id}',[DoctorController::class, 'show']);
Route::post('doctors',[DoctorController::class, 'store']);
Route::post('doctors/{id}',[DoctorController::class, 'update']);
Route::delete('doctors/{id}',[DoctorController::class, 'destroy']);

Route::get('patients',[PatientController::class, 'index']);
Route::get('patients/{id}',[PatientController::class, 'show']);
Route::post('patients',[PatientController::class, 'store']);
Route::post('patients/search',[PatientController::class,'search']);
Route::post('patients/{id}',[PatientController::class, 'update']);
Route::delete('patients/{id}',[PatientController::class, 'destroy']);

Route::get('examinations',[GeneralExaminationController::class, 'index']);
Route::get('examinations/{id}',[GeneralExaminationController::class, 'show']);
Route::post('examinations',[GeneralExaminationController::class, 'store']);
Route::post('examinations/{id}',[GeneralExaminationController::class, 'update']);

Route::get('obstetrics',[ObstetricHistoryTestController::class, 'index']);
Route::get('obstetrics/{id}',[ObstetricHistoryTestController::class, 'show']);
Route::post('obstetrics',[ObstetricHistoryTestController::class, 'store']);
Route::post('obstetrics/{id}',[ObstetricHistoryTestController::class, 'update']);

Route::get('gynaecologicalhistory',[GynaecologicalHistoryTestController::class, 'index']);
Route::get('gynaecologicalhistory/{id}',[GynaecologicalHistoryTestController::class, 'show']);
Route::post('gynaecologicalhistory',[GynaecologicalHistoryTestController::class, 'store']);
Route::post('gynaecologicalhistory/{id}',[GynaecologicalHistoryTestController::class, 'update']);
