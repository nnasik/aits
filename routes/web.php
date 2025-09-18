<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\TraineeController;
use App\Http\Controllers\PublicTrainingController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\JobRequestController;

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Public training link (hash protected)
Route::get('/public/training/{hash}', [PublicTrainingController::class, 'showTraining'])->name('public.training.show');

// Save signature (pivot ID)
Route::post('/public/training/signature/{training}/{traineePivotId}', [PublicTrainingController::class, 'saveSignature'])
    ->name('training.signature');

// Upload photo (pivot ID)
Route::post('training/{training}/trainee/{trainee}/photo', [PublicTrainingController::class, 'uploadPhoto'])
    ->name('training.trainee.photo');


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
    // Add Trainee to Training
    Route::post('/training/add/trainee', [TrainingController::class, 'addTrainee'])->name('training.add-trainee');
    // Remove Trainee from Training
    Route::post('/training/remove/trainee', [TrainingController::class, 'removeTrainee'])->name('training.remove-trainee');

    // Company
    Route::get('/company', [CompanyController::class, 'index'])->name('company.index');
    Route::post('/company', [CompanyController::class, 'store'])->name('company.store');

    // Trainee
    Route::resource('trainee', TraineeController::class)->only(['index','store','show','edit']);

    // Certificate
    Route::resource('certificate', CertificateController::class)->only(['index','store','show','edit']);
    Route::get('/certficate/{id}/pdf',[CertificateController::class,'certificatePDF'])->name('certificate.pdf');

    // Job Request
    Route::resource('jobrequest', JobRequestController::class)->only(['index','store','show','edit']);
    // Training Request
    Route::resource('trainingrequest', TrainingRequestController::class)->only(['index','store','show','edit']);
});