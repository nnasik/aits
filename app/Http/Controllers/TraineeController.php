<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trainee;
use App\Models\Training;
use App\Models\Company;
use Illuminate\Support\Facades\Storage;


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

    public function deleteSignature(Request $request){
        $request->validate([
            'trainee_id' => 'required|exists:trainees,id',
        ]);

        $trainee = Trainee::findOrFail($request->trainee_id);
        $trainee->signature = null; // clear signature field
        $trainee->save();

        return redirect()->back()->with('success', 'Signature removed successfully.');
    }

    public function store(Request $request){

        // validate fields
        $request->validate([
            'training_id' => 'required|exists:trainings,id',
            'candidate_name_in_certificate' => 'required|string|max:255',
            'company_name_in_certificate'   => 'nullable|string|max:255',
            'course_name_in_certificate'    => 'nullable|string|max:255',
            'live_photo'                    => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'eid_no'                        => 'nullable|string|max:255',
            'date'                          => 'nullable|date',
            'passport_no'                   => 'nullable|string|max:255',
            'dl_no'                         => 'nullable|string|max:255',
            'dl_issued'                     => 'nullable|date',
            'dl_expiry'                     => 'nullable|date|after_or_equal:dl_issued',
        ]);

        // handle file upload
        $livePhotoPath = null;

        if ($request->hasFile('live_photo')) {
            $livePhotoPath = $request->file('live_photo')->store('trainee_photos', 'public');
        }

        // create trainee
        Trainee::create([
            'training_id' => $request->training_id,
            'candidate_name_in_certificate' => $request->candidate_name_in_certificate,
            'company_name_in_certificate'   => $request->company_name_in_certificate,
            'course_name_in_certificate'    => $request->course_name_in_certificate,
            'live_photo'                    => $livePhotoPath,
            'eid_no'                        => $request->eid_no,
            'date'                          => $request->date,
            'passport_no'                   => $request->passport_no,
            'dl_no'                         => $request->dl_no,
            'dl_issued'                     => $request->dl_issued,
            'dl_expiry'                     => $request->dl_expiry,
        ]);

        $training = Training::findOrFail($request->training_id);
        $training->quantity = $training->trainees()->count();
        $training->save();

        return redirect()->back()->with('success', 'Trainee record created successfully.');

    }

    public function importSignature(Request $request){
    // Validate input
    $request->validate([
        'training_id' => 'required|exists:trainings,id',
        'trainee_id'  => 'required|integer',
        'signature'   => 'required|string', // Base64 string
    ]);

    // Find the training
    $training = Training::findOrFail($request->training_id);

    // Find the trainee linked to this training
    $trainee = $training->trainees()->where('id', $request->trainee_id)->firstOrFail();

    // Get the Base64 string and clean it
    $base64 = $request->input('signature');
    $base64 = preg_replace('/^data:image\/\w+;base64,/', '', $base64);
    $base64 = str_replace(' ', '+', $base64);

    // Decode Base64 to raw image bytes
    $decoded = base64_decode($base64);
    if ($decoded === false) {
        return redirect()->back()->with('error', 'Invalid signature data.');
    }

    // Generate a unique filename
    $fileName = 'signatures/' . uniqid('sig_') . '.png';

    // Save the PNG file in public storage
    $saved = Storage::disk('public')->put($fileName, $decoded);
    if (!$saved) {
        return redirect()->back()->with('error', 'Failed to save signature file.');
    }

    // Update trainee record
    $trainee->signature = $fileName;
    $trainee->save();

    return redirect()->back()->with('success', 'Signature imported successfully.');
}

}
