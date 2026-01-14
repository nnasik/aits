<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\TraineeController;
use App\Http\Controllers\PublicTrainingController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\CertificateBGController;
use App\Http\Controllers\JobRequestController;
use App\Http\Controllers\TrainingRequestController;
use App\Http\Controllers\TraineeRequestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\SettingsController;



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Public training link (hash protected)
Route::get('/public/training/{hash}', [PublicTrainingController::class, 'showTraining'])
    ->name('public.training.show');

// Save signature (pivot ID)
Route::post('/trainee/signature', [PublicTrainingController::class, 'saveSignature'])
    ->name('public.trainee.signature');

// Upload photo (Pivot ID)
Route::post('/trainee/photo', [PublicTrainingController::class, 'uploadPhoto'])->name('public.trainee.photo');

// Certificate Verification
Route::get('/verify/{hash}', [PublicController::class, 'verify'])->name('certificate.verify');

// Image Generation
Route::get('/certficate/{hash}/preview/png/v1',[CertificateController::class,'certificate_preview_v_1_1'])->name('certificate.preview.v1');

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
    Route::post('/job/files/upload', [JobController::class, 'uploadFile'])->name('job.file.upload');
    Route::post('/jobs/update-job-status', [JobController::class, 'updateJobStatus'])->name('job.updateJobStatus');


    // Trainings
    Route::resource('training', TrainingController::class)->only(['index','store','show','edit','destroy']);
    
    Route::get('/trainings/withnojob', [TrainingController::class, 'trainingsWithoutJob'])->name('training.nojob');
    Route::post('/trainings/linkjob', [TrainingController::class, 'linkJob'])->name('training.linkjob');
    Route::post('/trainings/unlink', [TrainingController::class, 'unlinkJob'])->name('training.unlink');

    Route::get('/training/{id}/pdf', [TrainingController::class, 'attendancePDF'])->name('attendance.pdf');
    
    // ================================== TRAINEE ============================================================ //
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
    Route::post('/import-signature', [TraineeController::class, 'importSignature'])->name('trainee.signature.import');

    // Certificate 
    Route::resource('certificate', CertificateController::class)->only(['index','store','show','edit']);
    Route::get('/certificates/waiting',[CertificateController::class,'waiting'])->name('certificate.waiting');
    // Certificate PDF
    Route::get('/certficate/{id}/pdf/',[CertificateController::class,'certificate'])->name('certificate.pdf');
    // Card PDF
    Route::get('/card/{id}/pdf/',[CertificateController::class,'card'])->name('card.pdf');
    // Client Copy
    Route::get('/scan/{id}/pdf/',[CertificateController::class,'scan'])->name('scan.pdf');
    
    
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

    // settings Controller

    Route::post('/user/settings/change', [SettingsController::class, 'change_user_settings'])->name('change.user.settings');


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

    // Reports
    Route::get('/report/jobs-by-sale', [ReportController::class, 'jobs_by_sale'])->name('report.jobsBySale');
    Route::get('/report/jobs-accounts', [ReportController::class, 'jobs_accounts'])->name('report.jobsAccounts');


    // Quotations
    Route::get('/quotation/', [QuotationController::class, 'index'])->name('quotation.index');
    Route::post('/quotation/store', [QuotationController::class, 'store'])->name('quotation.store');
    Route::post('/quotation/finalize', [QuotationController::class, 'finalize'])->name('quotation.finalize');
    Route::get('/quotations/pdf/{id}', [QuotationController::class, 'generatePdf'])->name('quotation.pdf.00');
    // Show quotation with rows
    Route::get('/quotation/{id}/show', [QuotationController::class, 'show'])->name('quotation.show');
    Route::post('/quotation_row/store', [QuotationController::class, 'storeRow'])->name('quotation_rows.store');
   


    Route::get('/documents/', [QuotationController::class, 'index'])->name('quotation.index');


    Route::get('/logout', function () {
        Auth::logout();                         // Logs out user
        request()->session()->invalidate();     // Invalidate session
        request()->session()->regenerateToken();// Regenerate CSRF token

        return redirect('/login');              // Redirect to login
    })->name('logout');

    

});