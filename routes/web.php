<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\TraineeController;
use App\Http\Controllers\PublicTrainingController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\JobRequestController;
use App\Http\Controllers\TrainingRequestController;
use App\Http\Controllers\TraineeRequestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Public training link (hash protected)
Route::get('/public/training/{hash}', [PublicTrainingController::class, 'showTraining'])
    ->name('public.training.show');

// Save signature (pivot ID)
Route::post('/trainee/signature', [PublicTrainingController::class, 'saveSignature'])
    ->name('public.trainee.signature');
    

// Upload photo (pivot ID)
Route::post('/trainee/photo', [PublicTrainingController::class, 'uploadPhoto'])
    ->name('public.trainee.photo');

// Certificate Verification
Route::get('/verify/{certificate_no}/{job_no}', [PublicController::class, 'verify'])->name('certificate.verify');

// PDF of certificate Generation
Route::get('/certficate/preview/{id}/png/v1',[CertificateController::class,'certificatePNG'])->name('certificate.preview');


Route::group(['middleware' => ['auth']], function () {

    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    // Dashboard
    Route::get('/dashbaord', [DashboardController::class, 'index'])->name('dashbaord.index');

    // Job
    Route::resource('job', JobController::class)->only(['index','store','show','edit']);
    // Additional Job Routes
    Route::get('/job/training/{id}', [JobController::class, 'training'])->name('job.traning.show');
    Route::get('/job/workpermit/{id}/pdf', [JobController::class, 'workOrderPDF'])->name('job.pdf');
    Route::post('/job/update-status', [JobController::class, 'updateStatus'])
    ->name('job.update-status');                     
    Route::get('/job-acc', [JobController::class, 'index_acc'])->name('job-acc.index');
    Route::post('/job-acc/change-status',[JobController::class, 'change_status_acc'])
    ->name('job.change_status_acc');
    Route::post('/jobs/update-job-status', [App\Http\Controllers\JobController::class, 'updateJobStatus'])->name('job.updateJobStatus');


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
    Route::put('/trainee/update', [TraineeController::class, 'update'])->name('trainee.update');
    Route::post('/trainees/delete-signature', [TraineeController::class, 'deleteSignature'])->name('trainee.signature.delete');




    // Certificate
    Route::resource('certificate', CertificateController::class)->only(['index','store','show','edit']);
    Route::get('/certficate/{id}/pdf/v1',[CertificateController::class,'certificatePDF_V1'])->name('certificate.pdf.v1');
    Route::get('/certficate/{id}/pdf/v2',[CertificateController::class,'certificatePDF_V_1_2'])->name('certificate.pdf.v2');
    Route::get('/id/{id}/pdf/v1',[CertificateController::class,'cardPDF_V1'])->name('id.pdf.v1');
    Route::get('/id/{id}/pdf/v2',[CertificateController::class,'cardPDF_V2'])->name('id.pdf.v2');
    Route::post('/certificates/store', [CertificateController::class, 'store'])->name('certificate.store');

    // Job Request
    Route::resource('jobrequest', JobRequestController::class)->only(['index','store','show','edit']);
    Route::post('jobrequest/cancel/{id}',[JobRequestController::class,'cancel'])->name('jobrequest.cencel');
    Route::post('/job-request/{id}/request', [JobRequestController::class, 'markAsRequested'])
     ->name('job-request.markAsRequested');
    Route::post('/job-request/accept/', [JobRequestController::class, 'acceptJobRequest'])->name('job-request.accept');
    Route::post('/job-request/duplicate', [JobRequestController::class, 'duplicateJobRequest'])->name('job-request.duplicate');

    // Training Request
    Route::resource('trainingrequest', TrainingRequestController::class)->only(['index','store','show','edit','destroy']);
    Route::post('/trainingrequests/duplicate', [TrainingRequestController::class, 'duplicate'])->name('trainingrequests.duplicate');
    Route::post('/training-requests/bulk-upload', [TrainingRequestController::class, 'bulkUploadDocuments'])
    ->name('training-requests.bulkUpload');



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

    Route::get('/logout', function () {
        Auth::logout();                         // Logs out user
        request()->session()->invalidate();     // Invalidate session
        request()->session()->regenerateToken();// Regenerate CSRF token

        return redirect('/login');              // Redirect to login
    })->name('logout');
});