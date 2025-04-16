<?php

use App\Http\Controllers\SellerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('/admin')->namespace('App\Http\Controllers\admin')->group(function(){
    Route::get('dashboard','AdminController@dashboard');
});




Route::get('/login', function () {
    return view('admin.login'); 
})->name('login');

Route::get('/register', function () {
    return view('admin.registr'); 
})->name('registr');

Route::post('/register', [SellerController::class, 'registerSeller'])->name('seller.register');
Route::post('/login', [SellerController::class, 'loginSeller'])->name('seller.login');

