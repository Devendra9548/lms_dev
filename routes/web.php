<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\frontendController;
use App\Http\Controllers\backendController;

use App\Livewire\Back\Dashboard;
use App\Livewire\Back\Maincourses;
use App\Livewire\Back\Editprofile;
use App\Livewire\Back\Editpassword;
use App\Livewire\Back\Deleteprofile;
use App\Livewire\Front\AccountDeactivate;

use App\Livewire\Front\Home;
use App\Livewire\Front\About;

Route::get('/', Home::class)->name('home');
Route::get('about', About::class);

Route::get('account-deleted', AccountDeactivate::class)->name('account-deleted')->middleware('auth.multiple');

Route::prefix('admin')->group(function(){
    Route::get('/', [backendController::class, 'login']);
    Route::get('login', [backendController::class, 'login'])->name('login');
    Route::get('signup', [backendController::class, 'signup'])->name('signup');
    Route::post('signing', [backendController::class, 'signing'])->name('signing');
    Route::post('logining', [backendController::class, 'logining'])->name('logining');
    Route::get('logout', [backendController::class, 'logout'])->name('logout');
    Route::get('dashboard', Dashboard::class)->name('dashboard')->middleware('auth.multiple');
    Route::get('courses', Maincourses::class)->name('courses')->middleware('auth.multiple');
    Route::get('editprofile/{id}', Editprofile::class)->name('editprofile')->middleware('auth.multiple');
    Route::post('editprofile/{id}', [backendController::class, 'updateprofile'])->name('updateprofile')->middleware('auth.multiple');
    Route::get('editpassword/{id}', Editpassword::class)->name('editpassword')->middleware('auth.multiple');
    Route::post('editpassword/{id}', [backendController::class, 'updatepassword'])->name('updatepassword')->middleware('auth.multiple');
    Route::get('deleteprofile/{id}', Deleteprofile::class)->name('deleteprofile')->middleware('auth.multiple');
    Route::post('deleteprofile/{id}', [backendController::class, 'updatepassword'])->name('updatepassword')->middleware('auth.multiple');
});

