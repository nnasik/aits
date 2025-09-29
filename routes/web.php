<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\TraineeController;
use App\Http\Controllers\PublicTrainingController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\JobRequestController;
use App\Http\Controllers\TrainingRequestController;
use App\Http\Controllers\TraineeRequestController;
use App\Http\Controllers\UserController;

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Public training link (hash protected)
Route::get('/public/training/{hash}', [PublicTrainingController::class, 'showTraining'])
    ->name('public.training.show');

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
    Route::post('jobrequest/cancel/{id}',[JobRequestController::class,'cancel'])->name('jobrequest.cencel');
    Route::post('/job-request/{id}/request', [JobRequestController::class, 'markAsRequested'])
     ->name('job-request.markAsRequested');
    
    // Training Request
    Route::resource('trainingrequest', TrainingRequestController::class)->only(['index','store','show','edit','destroy']);

    // Trainee Request
    Route::post('/trainingrequest/update-eid', [TraineeRequestController::class, 'updateEid'])
    ->name('trainingrequest.updateEid');
    Route::post('/training-requests/update-name', [TraineeRequestController::class, 'updateName'])
    ->name('training-requests.updateName');
    Route::post('/training-requests/update-dl', [TraineeRequestController::class, 'updateDl'])
        ->name('training-requests.updateDl');
    Route::post('/training-requests/upload-eid-back', [TraineeRequestController::class, 'uploadEidBack'])
    ->name('training-requests.uploadEidBack');
    Route::post('/training-requests/upload-eid-front', [TraineeRequestController::class, 'uploadEidFront'])
    ->name('training-requests.uploadEidFront');
    Route::post('/training-requests/upload-passport', [TraineeRequestController::class, 'uploadPassport'])
    ->name('training-requests.uploadPassport');
    Route::post('/trainee-requests/update-profile-pic', [TraineeRequestController::class, 'updateProfilePic'])
    ->name('trainee-requests.updateProfilePic');
    Route::post('/trainee-requests/upload-visa', [TraineeRequestController::class, 'uploadVisa'])->name('trainee-requests.uploadVisa');
    Route::post('/trainee-requests/update-company-name', [TraineeRequestController::class, 'updateCompanyName'])->name('trainee-requests.updateCompanyName');
    Route::post('/trainee/update-certificate-title', [TraineeRequestController::class, 'updateCertificateTitle'])
    ->name('trainee.updateCertificateTitle');
    Route::post('/trainee/update-certificate-date', [TraineeRequestController::class, 'updateCertificateDate'])
     ->name('trainee.updateCertificateDate');
    Route::post('/trainee/update-switch', [TraineeRequestController::class, 'updateSwitch'])
    ->name('trainee.updateSwitch');


    // User Management Routes (Admin & Developer only)
    Route::prefix('users')->group(function () {
        // List all users
        Route::get('/', [UserController::class, 'index'])->name('users.index');

        // View single user
        Route::get('/{id}', [UserController::class, 'view'])->name('users.view');

        // Reset user password
        Route::post('/reset-password', [UserController::class, 'resetPassword'])->name('users.resetPassword');

        // Update display picture
        Route::post('/update-dp', [UserController::class, 'updateDP'])->name('users.updateDP');

        // Search users (for select inputs)
        Route::get('/search', [UserController::class, 'selectSearch'])->name('users.selectSearch');

        // Get all active users
        Route::get('/active', [UserController::class, 'activeUsersList'])->name('users.activeList');

        Route::post('/add-role', [UserController::class, 'addRole'])->name('user.addRole'); 
        
        Route::post('/remove-role', [UserController::class, 'removeRole'])->name('user.removeRole');

        Route::post('/users/update-status', [UserController::class, 'updateStatus']) ->name('users.updateStatus');
    });

});