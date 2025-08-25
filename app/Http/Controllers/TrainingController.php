<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Training;
use App\Services\ZoomService;

class TrainingController extends Controller
{
    // 
    public function store(Request $request){

        $validated = $request->validate([
            'work_order_id'   => 'required|exists:work_orders,id',
            'course_id'       => 'required|exists:training_courses,id',
            'qty'             => 'required|integer|min:1',
            'scheduled_date'  => 'nullable|date',
            'training_mode'   => 'nullable|string|max:255',
            'scheduled_time'  => 'nullable|date_format:H:i',
            'remark'          => 'nullable|string|max:255',
        ]);

        $training = new Training([
            'work_order_id'      => $validated['work_order_id'],
            'training_course_id' => $validated['course_id'],
            'quantity'           => $validated['qty'],
            'scheduled_date'     => $validated['scheduled_date'] ?? null,
            'training_mode'     => $validated['training_mode'] ?? null,
            'scheduled_time'     => $validated['scheduled_time'] ?? null,
            'remarks'            => $validated['remark'] ?? null,
        ]);

        $training->save();

        if($request->zoom==True && $request->training_mode=='Online'){
            $zoom = app(\App\Services\ZoomService::class);

            $startTime = date('c', strtotime($request->scheduled_date . ' ' . $request->scheduled_time));

            $meeting = $zoom->createMeeting(
                $training->course->name . ' Training',
                $startTime,
                60
            );
            
            $training->training_link = $meeting['join_url'];
            $training->save();
            return redirect()->back()->with('error', 'Failed to create Zoom meeting: ' . json_encode($meeting));
    
        }
        
        return back()->with('success', 'Training added successfully.');
    }

    public function destroy(Training $training){
        $training->delete();
        return redirect()->back()->with('success', 'Training deleted successfully.');
    }

    public function show($id){
       
    }
}
