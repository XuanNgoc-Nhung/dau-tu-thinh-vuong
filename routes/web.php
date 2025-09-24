<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;

Route::group(['prefix' => 'admin'], function () {
    Route::get('/', [AdminController::class, 'index']);
});
Route::get('/', [HomeController::class, 'index']);
Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('/login', [UserController::class, 'postLogin'])->name('post-login');
Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/register', [UserController::class, 'postRegister'])->name('post-register');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
});