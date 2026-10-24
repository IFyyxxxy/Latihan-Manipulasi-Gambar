<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/upload', [ImageController::class, 'index']);
Route::post('/upload', [ImageController::class, 'upload'])->name('image.upload');