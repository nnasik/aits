<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trainee;
use App\Models\Company;

class TraineeController extends Controller
{
    public function index(){
        $data['trainees'] = Trainee::all()->reverse();
        $data['companies'] = Company::all();
        return view('trainee.index')->with($data);
    }

    public function update(Request $request){
        // validate fields
        $request->validate([
            'trainee_id' => 'required|exists:trainees,id',
            'candidate_name_in_certificate' => 'required|string|max:255',
            'live_photo' => 'file|mimes:jpg,jpeg,png,pdf|max:2048', 
            // only image or pdf, max 2MB
            'eid_no'      => 'nullable|string|max:255',
            'passport_no' => 'nullable|string|max:255',
            'dl_no'       => 'nullable|string|max:255',
            'dl_issued'   => 'nullable|date',
            'dl_expiry'   => 'nullable|date|after_or_equal:dl_issued',
        ]);

        // find the record
        $trainee = Trainee::findOrFail($request->trainee_id);

        // handle file upload if new file is provided
        $livePhotoPath = $trainee->live_photo; // keep old path if no new upload
        if ($request->hasFile('live_photo')) {
            $livePhotoPath = $request->file('live_photo')->store('trainee_photos', 'public');
        }

        // update with request data
        $trainee->update([
            'candidate_name_in_certificate' => $request->candidate_name_in_certificate,
            'live_photo'                    => $livePhotoPath,
            'eid_no'                        => $request->eid_no,
            'date'                          => $request->date,
            'passport_no'                   => $request->passport_no,
            'dl_no'                         => $request->dl_no,
            'dl_issued'                     => $request->dl_issued,
            'dl_expiry'                     => $request->dl_expiry,
        ]);

        return redirect()->back()->with('success', 'Trainee record updated successfully.');
    }

    

}
