<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\frontendController;
use App\Http\Controllers\backendController;


Route::get('/', [frontendController::class, 'home']);


Route::prefix('admin')->group(function(){
    Route::get('/', [backendController::class, 'login']);
    Route::get('login', [backendController::class, 'login'])->name('login');
    Route::get('signup', [backendController::class, 'signup'])->name('signup');
    Route::post('signing', [backendController::class, 'signing'])->name('signing');
});
