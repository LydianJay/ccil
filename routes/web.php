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

    Route::get('/generate_id', [Census::class, 'id_card'])->name('generate_id');

    Route::post('/census/add_record', [Census::class, 'add_record'])->name('add_record');

});