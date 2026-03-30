<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\frontendController;
use App\Http\Controllers\backendController;

use App\Livewire\Back\Dashboard;
use App\Livewire\Back\Maincourses;
use App\Livewire\Back\Editprofile;
use App\Livewire\Back\Editpassword;

use App\Livewire\Front\Home;
use App\Livewire\Front\About;

Route::get('/', Home::class);
Route::get('about', About::class);

Route::prefix('admin')->group(function(){
    Route::get('/', [backendController::class, 'login']);
    Route::get('login', [backendController::class, 'login'])->name('login');
    Route::get('signup', [backendController::class, 'signup'])->name('signup');
    Route::post('signing', [backendController::class, 'signing'])->name('signing');
    Route::post('logining', [backendController::class, 'logining'])->name('logining');
    Route::get('logout', [backendController::class, 'logout'])->name('logout');
    Route::get('dashboard', Dashboard::class)->name('dashboard')->middleware('auth:web,institute_users');
    Route::get('courses', Maincourses::class)->name('courses')->middleware('auth:web,institute_users');
    Route::get('editprofile/{id}', Editprofile::class)->name('editprofile')->middleware('auth:web,institute_users');
    Route::post('editprofile/{id}', [backendController::class, 'updateprofile'])->name('updateprofile')->middleware('auth:web,institute_users');
    Route::get('editpassword/{id}', Editpassword::class)->name('editpassword')->middleware('auth:web,institute_users');
    Route::post('editpassword/{id}', [backendController::class, 'updatepassword'])->name('updatepassword')->middleware('auth:web,institute_users');
});

