<?php

use Illuminate\Support\Facades\Route;

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/',[App\Http\Controllers\DataController::class,'show'])->name("index");
Route::get('delete/{id?}',[App\Http\Controllers\DataController::class,'delete']);
Route::post('update',[App\Http\Controllers\DataController::class,'update']);
