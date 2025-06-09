<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Census;

use App\Http\Controllers\AuthCtrl;

Route::get('/', [AuthCtrl::class, 'login_view'])->name('login');

Route::post('/login_post', [AuthCtrl::class, 'login'])->name('login_post');



Route::middleware(['auth:web'])->group(function(){


    Route::get('/home', [Dashboard::class, 'index'])->name('home');
    Route::get('/census', [Census::class, 'index'])->name('census');

    
});