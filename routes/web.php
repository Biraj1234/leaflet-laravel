<?php

use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('frontend.room.form');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('rooms', RoomController::class);
