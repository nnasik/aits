<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\TraineeController;

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {

    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // Job
    Route::resource('job', JobController::class)->only(['index','store','show','edit']);
    // Additional Job Routes
    Route::get('/job/training/{id}', [JobController::class, 'training'])->name('job.traning.show');
    Route::get('/job/workpermit/{id}/pdf', [JobController::class, 'workOrderPDF'])->name('job.pdf');

    // Trainings
    Route::resource('training', TrainingController::class)->only(['index','store','show','edit','destroy']);
    Route::get('/training/{id}/pdf', [TrainingController::class, 'attendancePDF'])->name('attendance.pdf');


    // Company
    Route::get('/company', [CompanyController::class, 'index'])->name('company.index');
    Route::post('/company', [CompanyController::class, 'store'])->name('company.store');

    // Trainee
    Route::resource('trainee', TraineeController::class)->only(['index','store','show','edit']);
});