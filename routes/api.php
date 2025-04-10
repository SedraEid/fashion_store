<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PythonController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Controller;




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
Route::post('/analyze-skin', [PythonController::class, 'analyzeSkin']);
Route::post('/auth/register', [UserController::class, 'register']);
Route::post('/auth/login', [UserController::class, 'login']);
Route::post('/upload-image', [Controller::class, 'saveImage']);
Route::post('/upload-ana', [Controller::class, 'uploadAndAnalyze']);






Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
