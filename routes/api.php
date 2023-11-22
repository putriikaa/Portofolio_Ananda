<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\GreetController;
use App\Http\Controllers\Gallery\APIGalleryController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/info', [InfoController::class, 'index'])->name('info');

Route::get('/greet', [GreetController::class,'greet'])->name('greet');

Route::get('/apigallery', [APIGalleryController::class, 'getGallery'])->name('resultGallery');
Route::post('/apigallery', [APIGalleryController::class, 'storeGallery'])->name('resultGallery');
Route::get('/gallery', [APIGalleryController::class, 'index'])->name('GalleryList');
Route::get('/creategallery', [APIGalleryController::class, 'create'])->name('PostGallery');
Route::post('/storeGallery', [APIGalleryController::class, 'storeGallery'])->name('SimpanGallery');
