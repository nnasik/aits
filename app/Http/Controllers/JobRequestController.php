<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobRequest;
use App\Models\Company;
use App\Models\TrainingCourse;

class JobRequestController extends Controller{
    //
    public function index(){
        $data['requests'] = JobRequest::orderBy('id', 'desc')->paginate(10);
        $data['companies'] = Company::all();
        return view('job_request.index')->with($data);
    }

    public function store(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'priority'                   => 'required|in:low,normal,urgent',
            'company_id'                 => 'required|integer|exists:companies,id',
            'company_name'               => 'required|string|max:255',
            'training_mode'              => 'required|string|in:Certification,In-Class,Online,On-Site',
            'training_expected_date'     => 'nullable|date',
            'training_expected_time'     => 'nullable|date_format:H:i',
        ]);

        // Create job request
        $jobRequest = JobRequest::create([
            'priority'                  => ucfirst($validated['priority']), // store with capitalized (Normal, Low, Urgent)
            'company_id'                => $validated['company_id'],
            'company_name_in_work_order'=> $validated['company_name'],
            'training_mode'             => $validated['training_mode'],
            'training_expected_date'    => $validated['training_expected_date'] ?? null,
            'training_expected_time'    => $validated['training_expected_time'] ?? null,
            'request_by'                => auth()->id(), // logged-in user
            'request_status'            => 'Created',
        ]);

        $jobRequest->histories()->create([
            'user_id' => auth()->id(),
            'event' => 'created job request.',
            'changes' => [
                'Job Request ID' => $jobRequest->id,
                'Priority' => $jobRequest->priority, // store with capitalized (Normal, Low, Urgent)
                'Company Name' => $jobRequest->company_name_in_work_order,
                'Training Mode' => $jobRequest->training_mode,
                // 'Expected Training Date' => $jobRequest->training_expected_date,
                // 'Expected Training Time' => $jobRequest->training_expected_time,
                'status' => $jobRequest->request_status,
            ],
        ]);

        return redirect()->back()->with('success', 'Job request created successfully!');


    }

    public function show($id){
        $data['courses'] = TrainingCourse::all();
        $job_request = JobRequest::findOrFail($id);
        $data['job_request'] = $job_request;
        $data['submit_error_message'] = "";
        $data['is_request_submittable'] = false;


        //dd(count($job_request->training_requests));
        if(count($job_request->training_requests)==0){
          $data['is_request_submittable'] = false;
          $data['submit_error_message'] = "The request cannot be sent because no training requests have been added.";
        }

        if ($job_request->request_status=='Created') {
            foreach($job_request->training_requests as $training_request){
                if($training_request->training_mode='Certification'){
                    foreach($training_request->trainee_requests as $trainee_request){
                        if(isset($trainee_request->eid_front_pic) 
                        || isset($trainee_request->eid_back_pic)
                        || isset($trainee_request->visa_pic)
                        || isset($trainee_request->passport_pic)
                        ){
                            $data['is_request_submittable'] = true;
                        }
                        else{
                            $data['is_request_submittable'] = false;
                            $data['submit_error_message'] = "One or more trainees doesn't have Emirates ID, Passport or Visa";
                            break 2;
                        }
                    }
                }
            }
        }
        elseif ($job_request->request_status=='Requested') {
            $data['is_request_submittable'] = false;
            $data['submit_error_message'] = "The request is already submitted";
        }
        else{
            $data['is_request_submittable'] = false;
            $data['submit_error_message'] = "The requested status is not supported";
        }
    
        return view('job_request.view')->with($data);
    }

    public function cancel($id, Request $request){

    $request->validate([
        'reason' => 'required|string|max:500',
    ]);
    
    $jobRequest = JobRequest::findOrFail($id);

    // Optional: check if request is cancelable
    if ($jobRequest->request_status === 'Cancelled') {
        return redirect()->back()->with('error', 'This job request is already cancelled.');
    }
    
    // Log in history
    $jobRequest->histories()->create([
        'user_id' => auth()->id(),
        'event'   => 'cancelled job request.',
        'changes' => [
            'Job Request ID' => $jobRequest->id,
            'Previous Status' => $jobRequest->getOriginal('request_status'),
            'New Status' => 'Cancelled',
            'Reason' => $request->reason,
        ],
    ]);

    // Update status
    $jobRequest->update([
        'request_status' => 'Cancelled',
    ]);

    foreach ($jobRequest->training_requests as $trainingRequest) {
        if ($trainingRequest->status !== 'Cancelled') {
            $trainingRequest->update([
                'status' => 'Cancelled',
            ]);
        }
    }


    return redirect()->back()->with('success', 'Job request cancelled successfully!');
}

public function markAsRequested($id)
{
    $jobRequest = JobRequest::findOrFail($id);

    // Only allow if not already requested
    if ($jobRequest->request_status === 'Requested') {
        return redirect()->back()->with('error', 'Job request is already requested.');
    }

    $oldStatus = $jobRequest->request_status;

    $jobRequest->update([
        'requested_on'   => now(),
        'request_by'     => auth()->id(),
        'request_status' => 'Requested',
    ]);

    // Add history
    $jobRequest->histories()->create([
        'user_id' => auth()->id(),
        'event'   => 'updated job request status to Requested',
        'changes' => [
            'Job Request ID' => $jobRequest->id,
            'Previous Status' => $oldStatus,
            'New Status' => 'Requested',
            'Requested On' => $jobRequest->requested_on,
            'Requested By' => $jobRequest->request_by,
        ],
    ]);

    return redirect()->back()->with('success', 'Job request marked as Requested successfully!');
}

public function acceptJobRequest($id)
{
    $jobRequest = JobRequest::with(['training_requests.trainee_requests'])->findOrFail($id);

    // Step 1: Create Work Order
    $workOrder = WorkOrder::create([
        'job_request_id'      => $jobRequest->id,
        'date'                => now(),
        'company_id'          => $jobRequest->company_id,
        'issued_by'           => auth()->id(), // can be null if needed
        'authorized_by'       => null, // set as needed
        'sales_by'            => $jobRequest->request_by,
        'training_mode'       => $jobRequest->training_mode,
        'qunatity'            => null,
        'notes'               => null,
        'status'              => 'Open',
    ]);

    // Step 2: Copy Training Requests to Trainings
    foreach ($jobRequest->training_requests as $trainingRequest) {
        $training = Training::create([
            'work_order_id'      => $workOrder->id,
            'training_course_id' => $trainingRequest->training_course_id,
            'hash'               => null,
            'quantity'           => $trainingRequest->quantity,
            'training_mode'      => $trainingRequest->training_mode,
            'scheduled_date'     => $trainingRequest->requesting_date,
            'scheduled_time'     => $trainingRequest->requesting_time,
            'remarks'            => $trainingRequest->remarks,
            'attendance'         => null,
            'training_link'      => $trainingRequest->zoom_link,
            'status'             => 'Created',
        ]);

        // Step 3: Copy Trainee Requests to Trainees
        foreach ($trainingRequest->trainee_requests as $traineeRequest) {
            Trainee::create([
                'work_order_id'                  => $workOrder->id, // optional reference if you want
                'training_id'                    => $training->id,
                'company_id'                     => $traineeRequest->company_id,
                'name'                           => $traineeRequest->trainee_name,
                'eid_no'                         => $traineeRequest->eid_no,
                'designation'                    => null, // no field mapping from trainee_request
                'passport_no'                    => null,
                'dl_no'                          => null,
                'dob'                            => null,
                'dl_issued'                      => null,
                'dl_expiry'                       => null,
                'photo'                           => $traineeRequest->profile_pic,
                'live_photo'                       => null,
                'dl'                               => $traineeRequest->dl_pic,
                'eid'                              => null,
                'nationality'                      => null,
            ]);
        }
    }

    // Step 4: Update Job Request Status
    $jobRequest->update([
        'request_status' => 'Accepted',
        'accepted_on'    => now(),
        'accepted_by'    => auth()->id(),
    ]);

    return redirect()->back()->with('success', 'Job request accepted and converted to work order successfully!');
}
    
}
