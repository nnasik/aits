<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\CompanyController;

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {
    // Jobs
    Route::get('/jobs', [JobsController::class, 'index'])->name('job.index');
    Route::post('/jobs', [JobsController::class, 'store'])->name('job.store');
    Route::post('/jobs/edit/{id}', [JobsController::class, 'index'])->name('job.edit');
    //Route::get('/job/{id}', [JobsController::class, 'show(id)'])->name('job.show');

    // Company
    Route::get('/companies', [CompanyController::class, 'index'])->name('company.index');
    Route::post('/companies', [CompanyController::class, 'store'])->name('company.store');

});