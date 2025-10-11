<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TraineeRequest;

class TraineeRequestController extends Controller{

    public function updateEid(Request $request){
        // Validate input
        $request->validate([
            'trainee_request_id'=>'required',
            'eid_no' => 'required|string|max:255',
        ]);

        // Find the training request
        $trainee = TraineeRequest::findOrFail($request->trainee_request_id);

        // Update EID
        $trainee->eid_no  = $request->eid_no;
        $trainee->save();

        // Optional: Log history if you track changes
        $trainee->trainingRequest->histories()->create([
            'user_id' => auth()->id(),
            'event'   => 'updated EID number',
            'changes' => [
                'Trainee Request ID' => $trainee->id,
                'New EID'             => $request->eid_no,
            ],
        ]);

        return redirect()->back()->with('success', 'EID updated successfully.');
    }

    public function updateName(Request $request){
        // Validate input
        $request->validate([
            'trainee_request_id' => 'required',
            'trainee_name'       => 'required|string|max:255',
        ]);

        // Find the trainee request
        $trainee = TraineeRequest::findOrFail($request->trainee_request_id);

        // Update Name
        $trainee->trainee_name = $request->trainee_name;
        $trainee->save();

        // Optional: Log history if you track changes
        $trainee->trainingRequest->histories()->create([
            'user_id' => auth()->id(),
            'event'   => 'updated trainee name',
            'changes' => [
                'Trainee Request ID' => $trainee->id,
                'New Name'            => $request->trainee_name,
            ],
        ]);

        return redirect()->back()->with('success', 'Trainee name updated successfully.');
    }

    // Controller function in TraineeRequestController
    public function updateDl(Request $request){
        // Validate input
        $request->validate([
            'trainee_request_id' => 'required|exists:trainee_requests,id',
            'dl_pic'             => 'required|file|mimes:jpeg,jpg,png,pdf|max:2048',
        ]);

        // Find the trainee request
        $trainee = TraineeRequest::findOrFail($request->trainee_request_id);

        // Store file
        $path = $request->file('dl_pic')->store('driving_licenses', 'public');
        $trainee->dl_pic = $path;
        $trainee->save();

        // Log history
        $trainee->trainingRequest->histories()->create([
            'user_id' => auth()->id(),
            'event'   => 'updated driving license file',
            'changes' => [
                'Trainee Request ID' => $trainee->id,
                'File'                => $path,
            ],
        ]);

        return redirect()->back()->with('success', 'Driving license uploaded successfully.');
    }

    public function uploadEidBack(Request $request){
    $request->validate([
        'trainee_request_id' => 'required|exists:trainee_requests,id',
        'eid_back_pic'       => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120', // max 5MB
    ]);

    $trainee = TraineeRequest::findOrFail($request->trainee_request_id);

    // Store file
    $path = $request->file('eid_back_pic')->store('uploads/eid_back', 'public');

    // Save path to DB
    $trainee->eid_back_pic = $path;
    $trainee->save();

    // Optional: log history
    $trainee->trainingRequest->histories()->create([
        'user_id' => auth()->id(),
        'event'   => 'uploaded EID back',
        'changes' => [
            'Trainee Request ID' => $trainee->id,
            'EID Back File'       => $path,
        ],
    ]);

    return redirect()->back()->with('success', 'EID Back uploaded successfully.');
}

public function uploadEidFront(Request $request)
{
    $request->validate([
        'trainee_request_id' => 'required|exists:trainee_requests,id',
        'eid_front_pic'      => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120', // max 5MB
    ]);

    $trainee = TraineeRequest::findOrFail($request->trainee_request_id);

    // Store file
    $path = $request->file('eid_front_pic')->store('uploads/eid_front', 'public');

    // Save path to DB
    $trainee->eid_front_pic = $path;
    $trainee->save();

    // Optional: log history
    $trainee->trainingRequest->histories()->create([
        'user_id' => auth()->id(),
        'event'   => 'uploaded EID front',
        'changes' => [
            'Trainee Request ID' => $trainee->id,
            'EID Front File'      => $path,
        ],
    ]);

    return redirect()->back()->with('success', 'EID Front uploaded successfully.');
}

public function uploadPassport(Request $request)
{
    $request->validate([
        'trainee_request_id' => 'required|exists:trainee_requests,id',
        'passport_pic'       => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120', // max 5MB
    ]);

    $trainee = TraineeRequest::findOrFail($request->trainee_request_id);

    // Store file
    $path = $request->file('passport_pic')->store('uploads/passports', 'public');

    // Save path to DB
    $trainee->passport_pic = $path;
    $trainee->save();

    // Log history
    $trainee->trainingRequest->histories()->create([
        'user_id' => auth()->id(),
        'event'   => 'uploaded passport',
        'changes' => [
            'Trainee Request ID' => $trainee->id,
            'Passport File'      => $path,
        ],
    ]);

    return redirect()->back()->with('success', 'Passport uploaded successfully.');
}

public function updateProfilePic(Request $request){
    $request->validate([
        'trainee_request_id' => 'required|exists:trainee_requests,id',
        'profile_pic' => 'required|image|max:5120', // max 5MB
    ]);

    $trainee = TraineeRequest::findOrFail($request->trainee_request_id);

    // Store file
    $path = $request->file('profile_pic')->store('uploads/profile_pics', 'public');
    $trainee->profile_pic = $path;
    $trainee->save();

    // Log history
    $trainee->trainingRequest->histories()->create([
        'user_id' => auth()->id(),
        'event'   => 'updated trainee picture',
        'changes' => [
            'Trainee Request ID' => $trainee->id,
            'New Profile Pic' => $path,
        ],
    ]);

    return redirect()->back()->with('success', 'Profile picture updated successfully.');
}

public function uploadVisa(Request $request){
    $request->validate([
        'trainee_request_id' => 'required|exists:trainee_requests,id',
        'visa_pic' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120', // max 5MB
    ]);

    $trainee = TraineeRequest::findOrFail($request->trainee_request_id);

    if($request->hasFile('visa_pic')){
        $file = $request->file('visa_pic');
        $path = $file->store('trainee/visa', 'public');
        $trainee->visa_pic = $path;
        $trainee->save();

        // Log in trainingRequest histories
        $trainee->trainingRequest->histories()->create([
            'user_id' => auth()->id(),
            'event' => 'uploaded Visa',
            'changes' => [
                'Trainee Request ID' => $trainee->id,
                'Visa File' => $path,
            ],
        ]);
    }
    return redirect()->back()->with('success', 'Visa uploaded successfully.');
}

    public function updateCompanyName(Request $request){
        $request->validate([
            'trainee_request_id' => 'required|exists:trainee_requests,id',
            'company_name_in_certificate' => 'required|string|max:255',
        ]);

        $trainee = TraineeRequest::findOrFail($request->trainee_request_id);
        $oldName = $trainee->company_name_in_certificate;

        $trainee->company_name_in_certificate = $request->company_name_in_certificate;
        $trainee->save();

        // log history under trainingRequest
        $trainee->trainingRequest->histories()->create([
            'user_id' => auth()->id(),
            'event' => 'updated Company Name in Certificate',
            'changes' => [
                'Trainee Request ID' => $trainee->id,
                'Old Company Name' => $oldName,
                'New Company Name' => $request->company_name_in_certificate,
            ],
        ]);

        return redirect()->back()->with('success', 'Company Name updated successfully.');
    }

    public function updateCertificateTitle(Request $request){
        $request->validate([
            'trainee_request_id' => 'required|integer',
            'course_title_in_certificate' => 'required|string|max:255',
        ]);

        $trainee = TraineeRequest::findOrFail($request->trainee_request_id);
        $trainee->update([
            'course_title_in_certificate' => $request->course_title_in_certificate,
        ]);

        // keep history
        $trainee->trainingRequest->histories()->create([
            'user_id' => auth()->id(),
            'event' => 'updated certificate title',
            'changes' => [
            'Trainee Request ID' => $trainee->id,
            'Old Certificate Name' => $trainee->trainingRequest->getOriginal('course_title_in_certificate'),
            'New Certificate Name' => $request->course_title_in_certificate,
            ],
            
        ]);

        return back()->with('success', 'Certificate Title updated successfully.');
    }

    public function updateCertificateDate(Request $request){
        $request->validate([
            'trainee_id' => 'required|exists:trainee_requests,id',
            'certificate_date' => 'nullable|date',
        ]);

        $trainee = TraineeRequest::findOrFail($request->trainee_id);
        // keep history before updating
        $oldDate = $trainee->certificate_date;
        $trainee->certificate_date = $request->certificate_date;
        $trainee->save();



        // keep history
        $trainee->trainingRequest->histories()->create([
            'user_id' => auth()->id(),
            'event' => 'updated certificate date',
            'changes' => [
                'Trainee Request ID' => $trainee->id,
                'Old Certificate Date' => $oldDate,
                'New Certificate Date' => $request->certificate_date,
            ],
        ]);

        return back()->with('success', 'Certificate Date updated successfully.');
    }

    public function updateSwitch(Request $request)
{
    $request->validate([
        'trainee_id' => 'required|exists:trainee_requests,id',
        'field' => 'required|in:is_certificate_hard_copy_needed,is_id_card_needed',
        'value' => 'required|boolean',
    ]);

    $trainee = TraineeRequest::findOrFail($request->trainee_id);

    $oldValue = $trainee->{$request->field};

    $trainee->{$request->field} = $request->value;
    $trainee->save();

    // history log
    $trainee->trainingRequest->histories()->create([
        'user_id' => auth()->id(),
        'event' => 'updated ' . $request->field,
        'changes' => [
            'Trainee Request ID' => $trainee->id,
            'Field' => $request->field,
            'Old Value' => $oldValue,
            'New Value' => $request->value,
        ],
    ]);

    return response()->json(['success' => true]);
}




}