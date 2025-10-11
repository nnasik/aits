<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrainingRequest;
use App\Models\JobRequest;
use Auth;
use Illuminate\Support\Facades\DB;

class TrainingRequestController extends Controller
{
    public function store(Request $request){
        // ✅ Validate inputs
        $validated = $request->validate([
            'work_order_id'              => 'required|exists:job_requests,id',
            'course_id'                  => 'required|exists:training_courses,id',
            'course_title_in_certificate'=> 'nullable|string|max:255',
            'company_name_in_certificate'=> 'nullable|string|max:255',
            'quantity'                   => 'required|integer|min:1',
            'training_mode'              => 'required|string|in:Certification,In-Class,Online,On-Site',
            'requesting_date'            => 'nullable|date',
            'requesting_time'            => 'nullable|date_format:H:i',
            'remarks'                    => 'nullable|string|max:500',
        ]);

        // ✅ Create record according to migration
        $trainingRequest = TrainingRequest::create([
            'job_request_id'             => $validated['work_order_id'],
            'training_course_id'         => $validated['course_id'],
            'course_title_in_certificate'=> $validated['course_title_in_certificate'] ?? null,
            'company_name_in_certificate'=> $validated['company_name_in_certificate'] ?? null,
            'quantity'                   => $validated['quantity'],
            'training_mode'              => $validated['training_mode'],
            'requesting_date'            => $validated['requesting_date'] ?? null,
            'requesting_time'            => $validated['requesting_time'] ?? null,
            'is_zoom_link_required'      => $request->has('zoom') ? true : false,
            'zoom_link'                  => null, // you can update later when Zoom link is generated
            'remarks'                    => $validated['remarks'] ?? null,
            'user_id'                    => Auth::id(), // logged-in user
            'status'                     => 'Created',
        ]);

        for ($i=0; $i < $trainingRequest->quantity; $i++) { 
            $trainingRequest->trainee_requests()->create([
                'company_name_in_certificate' => $trainingRequest->company_name_in_certificate,
                'course_title_in_certificate' => $trainingRequest->course_title_in_certificate,
                'certificate_date' => $trainingRequest->requesting_date,
            ]);
        }

        $jobRequest = JobRequest::findOrFail($trainingRequest->job_request_id);

        $jobRequest->histories()->create([
            'user_id' => auth()->id(),
            'event' => 'created training request.',
            'changes' => [
                'Training Request ID'        => $trainingRequest->id,
                'Training Course'            => $trainingRequest->course->name,
                'Course Title in Certificate'=> $trainingRequest->course_title_in_certificate,
                'Company Name in Certificate'=> $trainingRequest->company_name_in_certificate,
                'No. of Trainees'            => $trainingRequest->quantity,
                'Training Mode'              => $trainingRequest->training_mode,
                'Requesting Date'            => $trainingRequest->requesting_date,
                'Requesting Time'            => $trainingRequest->requesting_time,
                'Zoom Link'                  => $trainingRequest->is_zoom_link_required ? 'Required' : 'Not Required',
                'Remarks'                    => $trainingRequest->remarks ?? null,
                'Status'                     => 'Created',
            ],
        ]);

        $trainingRequest->histories()->create([
            'user_id' => auth()->id(),
            'event' => 'created training request.',
            'changes' => [
                'Training Request ID'        => $trainingRequest->id,
                'Training Course'            => $trainingRequest->course->name,
                'Course Title in Certificate'=> $trainingRequest->course_title_in_certificate,
                'Company Name in Certificate'=> $trainingRequest->company_name_in_certificate,
                'No. of Trainees'            => $trainingRequest->quantity,
                'Training Mode'              => $trainingRequest->training_mode,
                'Requesting Date'            => $trainingRequest->requesting_date,
                'Requesting Time'            => $trainingRequest->requesting_time,
                'Zoom Link'                  => $trainingRequest->is_zoom_link_required ? 'Required' : 'Not Required',
                'Remarks'                    => $trainingRequest->remarks ?? null,
                'Status'                     => 'Created',
            ],
        ]);
        
        // ✅ Redirect back with success
        return redirect()->back()->with('success', 'Training request created successfully.');
    }

    public function destroy($id){
        // 🔎 Find the training request or fail with 404
        $trainingRequest = TrainingRequest::findOrFail($id);

        $trainingRequest->job_request->histories()->create([
            'user_id' => auth()->id(),
            'event' => 'deleted training request.',
            'changes' => [
                'Training Request ID'        => $trainingRequest->id,
                'Training Course'            => $trainingRequest->course->name,
                'No. of Trainees'            => $trainingRequest->quantity,
                'Training Mode'              => $trainingRequest->training_mode,
                'Requesting Date'            => $trainingRequest->requesting_date,
            ],
        ]);

        // 🗑️ Delete the record
        $trainingRequest->delete();

        // ✅ Redirect back with success message
        return redirect()->back()->with('success', 'Training request deleted successfully.');
    }

    public function show($id){
        $trainingRequest = TrainingRequest::findOrFail($id);
        $data['training_request'] = $trainingRequest;
        return view('training_request.view')->with($data);
    }



    public function duplicate(Request $request){
        // ✅ Step 1: Validate request
        $validated = $request->validate([
            'training_request_id'          => 'required|exists:training_requests,id',
            'training_mode'                => 'required|string|in:Certification,In-Class,Online,On-Site',
            'course_title_in_certificate'  => 'required|string|max:255',
            'course_id'                  => 'required|exists:training_courses,id',
            'company_name_in_certificate'  => 'required|string|max:255',
            'remarks'                      => 'nullable|string|max:500',
            'requesting_date'            => 'nullable|date',
            'requesting_time'            => 'nullable|date_format:H:i',
        ]);

        DB::beginTransaction();

        try {
            // ✅ Step 2: Find the old training request with relations
            $oldRequest = TrainingRequest::findOrFail($validated['training_request_id']);

            // ✅ Step 3: Create new duplicated training request
            $newTrainingRequest = TrainingRequest::create([
                'job_request_id'             => $oldRequest->job_request_id, // keep same job request
                'training_course_id'         => $validated['course_id'] ?? $oldRequest->training_course_id,
                'course_title_in_certificate'=> $validated['course_title_in_certificate'] ?? $oldRequest->course_title_in_certificate,
                'company_name_in_certificate'=> $validated['company_name_in_certificate'] ?? $oldRequest->company_name_in_certificate,
                'quantity'                   => $oldRequest->quantity,
                'training_mode'              => $validated['training_mode'],
                'requesting_date'            => $oldRequest->requesting_date,
                'requesting_time'            => $oldRequest->requesting_time,
                'is_zoom_link_required'      => $oldRequest->is_zoom_link_required,
                'zoom_link'                  => null,
                'remarks'                    => $validated['remarks'] ?? null,
                'user_id'                    => Auth::id(),
                'status'                     => 'Created',
            ]);

            // ✅ Step 4: Duplicate trainee requests
            foreach ($oldRequest->trainee_requests as $trainee) {
                $newTrainingRequest->trainee_requests()->create([
                    'trainee_name'                     => $trainee->trainee_name,
                    'eid_no'                           => $trainee->eid_no,
                    'profile_pic'                      => $trainee->profile_pic,
                    'is_certificate_hard_copy_needed'  => $trainee->is_certificate_hard_copy_needed,
                    'is_id_card_needed'                => $trainee->is_id_card_needed,
                    'eid_front_pic'                    => $trainee->eid_front_pic,
                    'eid_back_pic'                     => $trainee->eid_back_pic,
                    'visa_pic'                         => $trainee->visa_pic,
                    'passport_pic'                     => $trainee->passport_pic,
                    'dl_pic'                           => $trainee->dl_pic,
                    'company_name_in_certificate'      => $validated['company_name_in_certificate'],
                    'course_title_in_certificate'      => $validated['course_title_in_certificate'],
                    'certificate_date'      => $validated['requesting_date'],
                ]);
            }

            // ✅ Step 6: Create history for training request
            $newTrainingRequest->histories()->create([
                'user_id' => auth()->id(),
                'event' => 'duplicated from training request ID ' . $oldRequest->id,
                'changes' => [
                    'Old Training Request ID'          => $oldRequest->id,
                    'Training Course'                  => $oldRequest->course->name,
                    'Course Title in Certificate'      => $newTrainingRequest->course_title_in_certificate,
                    'Company Name in Certificate'      => $newTrainingRequest->company_name_in_certificate,
                    'No. of Trainees'                  => $newTrainingRequest->quantity,
                    'Training Mode'                    => $newTrainingRequest->training_mode,
                    'Remarks'                          => $newTrainingRequest->remarks ?? null,
                    'Status'                           => 'Created',
                ],
            ]);

            DB::commit();

            // ✅ Step 7: Redirect back with success
            return redirect()->back()->with('success', 'Training request duplicated successfully.');
        } 
        catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to duplicate training request: ' . $e->getMessage());
        }
    }

    public function bulkUploadDocuments(Request $request){
    $request->validate([
        'training_request_id' => 'required|exists:training_requests,id',
        'document_type'       => 'required|string|in:Emirates ID Front Page,Emirates ID Back Page,Visa Document,Passport Pic,Driving License Pic',
        'files'               => 'required|array|min:1',
        'files.*'             => 'file|mimes:jpg,jpeg,png,pdf|max:5120', // max 5MB each
    ]);

    $trainingRequest = TrainingRequest::findOrFail($request->training_request_id);
    $limit = $trainingRequest->quantity;
    $trainees = $trainingRequest->trainee_requests;

    // Validate count
    $newUploads = count($request->file('files'));
    if ($newUploads > $limit) {
        return redirect()->back()->with('error', "You can upload only {$limit} files for this training request.");
    }

    // Folder mapping
    $folderMap = [
        'Emirates ID Front Page'          => 'uploads/eid_front',
        'Emirates ID Back Page'           => 'uploads/eid_back',
        'Visa Document'      => 'uploads/visa',
        'Passport Pic'       => 'uploads/passports',
        'Driving License Pic'=> 'uploads/license',
    ];

    $uploadPath = $folderMap[$request->document_type] ?? 'uploads/other';
    $files = $request->file('files');

    foreach ($files as $index => $file) {
        // Stop if there are more files than trainees
        if (!isset($trainees[$index])) break;

        $trainee = $trainees[$index];
        $path = $file->store($uploadPath, 'public');

        // Assign to appropriate column
        switch ($request->document_type) {
            case 'Emirates ID Front Page':
                $trainee->eid_front_pic = $path;
                break;
            case 'Emirates ID Back Page':
                $trainee->eid_back_pic = $path;
                break;
            case 'Visa Document':
                $trainee->visa_pic = $path;
                break;
            case 'Passport Pic':
                $trainee->passport_pic = $path;
                break;
            case 'Driving License Pic':
                $trainee->dl_pic = $path;
                break;
        }

        $trainee->save();

        // Log upload
        $trainingRequest->histories()->create([
            'user_id' => auth()->id(),
            'event'   => "Uploaded {$request->document_type} (Bulk)",
            'changes' => [
                'Trainee ID' => $trainee->id,
                'File Path'  => $path,
            ],
        ]);
    }

    return redirect()->back()->with('success', 'Files uploaded successfully.');
}


   
}