<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard;


Route::get('/', [Dashboard::class, 'index'])->name('home');