<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobsController;

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth','check.status']], function () {
    //Route::get('/', [ProfileController::class,'profile'])->name('Profile');
    Route::get('/jobs', [JobsController::class, 'index'])->name('job.index');
    Route::get('/job/{id}', [JobsController::class, 'show(id)'])->name('job.show');
});