<?php

use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('frontend.home');
});

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('rooms', RoomController::class);
