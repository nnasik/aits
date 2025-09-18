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
            'training_mode'              => 'required|in:certificate,online,in_class,on_site',
            'training_expected_date'     => 'nullable|date',
            'training_expected_time'     => 'nullable|date_format:H:i',
            'zoom_link'                  => 'nullable|boolean',
        ]);

        // Create job request
        $jobRequest = JobRequest::create([
            'priority'                  => ucfirst($validated['priority']), // store with capitalized (Normal, Low, Urgent)
            'company_id'                => $validated['company_id'],
            'company_name_in_work_order'=> $validated['company_name'],
            'training_mode'             => $validated['training_mode'],
            'training_expected_date'    => $validated['training_expected_date'] ?? null,
            'training_expected_time'    => $validated['training_expected_time'] ?? null,
            'is_zoom_link_required'     => $request->has('zoom_link') ? 1 : 0,
            'request_by'                => auth()->id(), // logged-in user
            'request_status'            => 'Created',
        ]);

        return redirect()->back()->with('success', 'Job request created successfully!');
    }

    public function show($id){
        $data['courses'] = TrainingCourse::all();
        $data['job_request'] = JobRequest::findOrFail($id);
        return view('job_request.view')->with($data);
    }

    
}
