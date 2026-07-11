<?php

use App\Http\Controllers\SelectController;
use App\Http\Controllers\TinymceController;
use App\Http\Controllers\UploaderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Global Routes
|--------------------------------------------------------------------------
|
| Here is where you can register global routes for your application. These
| routes available to both the website and dashboard.
|
*/

Route::post('tinymce/upload', [TinymceController::class, 'store'])->name('tinymce.upload');

Route::get('tomselect/search', [SelectController::class, 'index'])->name('select.search');
Route::get('tomselect/fetch', [SelectController::class, 'show'])->name('select.fetch');

Route::post('uploader/upload', [UploaderController::class, 'store'])->name('uploader.upload');
