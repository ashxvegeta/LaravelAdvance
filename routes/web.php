<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
});
Route::post('/loginsubmit', [UserController::class, 'loginsubmit'])->name('loginsubmit');
Route::get('/admin/dashboard', function () {
    return 'Welcome to admin Dashboard';
})->middleware(['auth', 'admin']);

Route::get('/dashboard', function () {
    return view('user');
})->middleware('auth');

Route::post('/register', [UserController::class, 'register'])->name('register');