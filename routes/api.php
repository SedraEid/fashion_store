<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PythonController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ImageAnalysisController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\ResultController;









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
Route::post('/analyze-skin', [PythonController::class, 'analyzeSkin']);/////////





Route::post('/auth/register', [UserController::class, 'register']);
Route::post('/auth/login', [UserController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/customer', [UserController::class, 'store']);
    Route::get('/customer', [UserController::class, 'getProfile']);
});


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/profile', [ProfileController::class, 'store']);
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);  //update profile 
});




Route::middleware('auth:sanctum')->group(function () {
    Route::post('/image_analysis', [ImageAnalysisController::class, 'uploadAndAnalyze']);
});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/seller', [SellerController::class, 'show']);
   
});


Route::middleware('auth:sanctum')->put('/seller/update', [SellerController::class, 'updateSellerData']);



Route::middleware('auth:sanctum')->group(function () {
    Route::post('/customer/result', [ResultController::class, 'storeOrUpdateResult']);
});  //تبع الاسئلة

//////

Route::post('/seller/register', [SellerController::class, 'registerSeller']);//postman
Route::post('/seller/login', [SellerController::class, 'loginSeller']);//postman



Route::post('/register', [SellerController::class, 'registerSeller'])->name('seller.register');



Route::post('/category', [CategoryController::class, 'add']);
Route::get('/category/{id}', [CategoryController::class, 'show']);




Route::get('/products', [ProductController::class, 'index']);
Route::post('/products', [ProductController::class, 'store']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::put('/products/{id}', [ProductController::class, 'update']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);




Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
