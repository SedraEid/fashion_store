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






Route::get('/login1', function () {
    return view('admin.login'); 
})->name('login');

Route::get('/register1', function () {
    return view('admin.registr'); 
})->name('registr');


Route::get('/home', function () {
    return view('admin.home'); 
})->name('home');

Route::post('/register', [SellerController::class, 'registerSeller'])->name('seller.register');
Route::post('/login', [SellerController::class, 'loginSeller'])->name('seller.login');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/seller/dashboard', function () {
        return view('admin.home');
    })->name('seller.dashboard');
});




