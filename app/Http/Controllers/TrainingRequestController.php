<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrainingRequest;
use App\Models\JobRequest;
use Auth;

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

    
}