<?php

use App\Http\Controllers\Auth;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ThesisController;
use App\Http\Middleware\CheckRoles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post("/signin", [Auth::class, 'login']);
Route::post("/register", [Auth::class, 'register']);
Route::get("/logout", [Auth::class, 'logout']);
Route::get('/', function(){
    return "Welcome to the API";
});

Route::middleware(['role:SUPER_ADMIN'])->group(function () {
    Route::post('/institution/create', [InstitutionController::class, 'create']);
    Route::get('/institutions/get', [InstitutionController::class, 'index']);
    Route::get('/institutions/{id}/get', [InstitutionController::class, 'show']);
});

Route::middleware(['role:ADMIN'])->group(function () {
    Route::post('/staff/create', [StaffController::class,'create']);
    Route::get('/staffs/{institution_id}/{id}/get', [StaffController::class,'show']);
    Route::get('/staffs/{id}/get', [StaffController::class,'index']);
    Route::post('/thesis/create', [ThesisController::class,'create']);
    Route::get('/thesis/get', [ThesisController::class,'index']);
    Route::get('/thesis/{id}/get', [ThesisController::class,'show']);
    Route::put('/thesis/{id}/edit', [ThesisController::class,'edit']);
    Route::delete('/thesis/{id}/delete', [ThesisController::class,'destroy']);
});

Route::middleware(['role:HOD'])->group(function () {
    Route::post('/thesis/create', [ThesisController::class,'create']);
    Route::get('/thesis/get', [ThesisController::class,'index']);
    Route::get('/thesis/{id}/get', [ThesisController::class,'show']);
    Route::put('/thesis/{id}/edit', [ThesisController::class,'edit']);
    Route::delete('/thesis/{id}/delete', [ThesisController::class,'destroy']);
});


Route::middleware(['role:LIBRARIAN'])->group(function () {
    Route::post('/thesis/create', [ThesisController::class,'create']);
    Route::get('/thesis/get', [ThesisController::class,'index']);
    Route::get('/thesis/{id}/get', [ThesisController::class,'show']);
    Route::put('/thesis/{id}/edit', [ThesisController::class,'edit']);
});