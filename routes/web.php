<?php

use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\Post\ResizeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SendEmailController;

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

Route::get('/', function(){
    return view('welcome');
});

Route::controller(LoginRegisterController::class)->group(function() {
    Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::post('/logout', 'logout')->name('logout');
  
});

// Di routes/web.php
Route::controller(ResizeController::class)->group(function() {
    Route::get('/users', 'index')->name('users');
    Route::get('edit/{id}', 'edit')->name('edit');
    Route::post('update/{id}', 'update')->name('update');
    Route::delete('delete/{id}', 'destroy')->name('destroy'); 
    Route::get('/users/{user}/resize', 'resizeForm')->name('resizeForm');
    Route::post('/users/{users}/resize', 'resizeImage')->name('resizeImage');
});

