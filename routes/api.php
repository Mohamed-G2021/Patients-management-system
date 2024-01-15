<?php

use App\Http\Controllers\api\AdminController;
use App\Http\Controllers\api\DoctorController;
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

Route::get('doctors',[DoctorController::class, 'index']);
Route::post('doctors',[DoctorController::class, 'store']);
Route::post('doctors/{id}',[DoctorController::class, 'update']);
Route::delete('doctors/{id}',[DoctorController::class, 'destroy']);

Route::get('patients',[PatientController::class, 'index']);
Route::post('patients',[PatientController::class, 'store']);
Route::post('patients/{id}',[PatientController::class, 'update']);
Route::delete('patients/{id}',[PatientController::class, 'destroy']);

