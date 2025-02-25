<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/index', [PersonController::class,'index'])->name('index');
Route::get('/show/{id}', [PersonController::class,'show'])->name('show');
Route::get('/create', [PersonController::class,'create'])->name('create');
Route::post('/store', [PersonController::class,'store'])->name('store');
Route::get('/parentytest', [PersonController::class,'testParentiy'])->name('testParentiy');