<?php

use App\Http\Controllers\api\AdminController;
use App\Http\Controllers\api\UserController;
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

Route::get('doctors',[UserController::class, 'index']);
Route::get('doctors/{id}',[UserController::class, 'show']);
Route::post('doctors',[UserController::class, 'store']);
Route::post('doctors/{id}',[UserController::class, 'update']);
Route::delete('doctors/{id}',[UserController::class, 'destroy']);

Route::get('patients',[PatientController::class, 'index']);
Route::get('patients/{id}',[PatientController::class, 'show']);
Route::post('patients',[PatientController::class, 'store']);
Route::post('patients/search',[PatientController::class,'search']);
Route::post('patients/{id}',[PatientController::class, 'update']);
Route::delete('patients/{id}',[PatientController::class, 'destroy']);

Route::resource('general-examination', GeneralExaminationController::class);
Route::resource('obstetrics',ObstetricHistoryTestController::class);
Route::resource('gynaecological',GynaecologicalHistoryTestController::class);
