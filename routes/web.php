<?php

use Illuminate\Support\Facades\Route;

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


Auth::routes();
Route::get('/producer', [App\Http\Controllers\ProducerController::class, 'create']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::patch('/fcm-token', [App\Http\Controllers\HomeController::class, 'updateToken'])->name('fcmToken');
Route::get('/send',[App\Http\Controllers\HomeController::class, 'notification'])->name('notification');
