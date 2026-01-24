<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Training;
use Illuminate\Support\Facades\Storage;


class PublicTrainingController extends Controller
{
    /**
     * Show training with trainee list (public link, hash protected)
     */
    public function showTraining($trainingHash){
        // Eager load trainees using Eloquent relationship
        $training = Training::with('trainees')->where('hash', $trainingHash)->firstOrFail();
        return view('public.training', compact('training'));
    }

    public function showTraining2($trainingHash){
        // Eager load trainees using Eloquent relationship
        $training = Training::with('trainees')->where('hash', $trainingHash)->firstOrFail();
        return view('public.training2', compact('training'));
    }

    /**
     * Save trainee signature using trainee ID
     */
    public function saveSignature(Request $request){
    $request->validate([
        'training_hash' => 'required|exists:trainings,hash',
        'trainee_id'    => 'required|integer',
        'signature'     => 'required|string',
    ]);

    // Find training by hash
    $training = Training::where('hash', $request->training_hash)->firstOrFail();

    // Find trainee that belongs to this training
    $trainee = $training->trainees()->where('id', $request->trainee_id)->firstOrFail();

    // Convert Base64 to PNG
    $data = $request->input('signature');
    $data = preg_replace('/^data:image\/\w+;base64,/', '', $data);
    $data = str_replace(' ', '+', $data);
    $decoded = base64_decode($data);

    if ($decoded === false) {
        return redirect()->back()->with('error', 'Invalid signature data.');
    }

    // Save file in storage/app/public/signatures
    $fileName = 'signatures/' . uniqid('sig_') . '.png';
    $stored = Storage::disk('public')->put($fileName, $decoded);

    if (!$stored) {
        return redirect()->back()->with('error', 'Failed to save signature file.');
    }

    // Save signature in database
    $trainee->signature = $fileName;
    $trainee->save(); // ✅ force save

    return redirect()->back()->with('success', 'Signature saved successfully.');
}



    /**
     * Upload trainee photo using trainee ID
     */
    public function uploadPhoto(Request $request){
    $request->validate([
        'training_hash' => 'required|exists:trainings,hash',
        'trainee_id'    => 'required|integer',
        'photo'         => 'required|image|max:2048',
    ]);

    // Find training by hash
    $training = \App\Models\Training::where('hash', $request->training_hash)->firstOrFail();

    // Find trainee that belongs to this training
    $trainee = $training->trainees()->where('id', $request->trainee_id)->firstOrFail();

    if ($request->hasFile('photo')) {
        $path = $request->file('photo')->store('trainee_photos', 'public');

        // Update live_photo via Eloquent
        $trainee->update(['live_photo' => $path]);

        return redirect()->back()->with('success', 'Photo uploaded successfully.');
    }

    return redirect()->back()->with('error', 'No photo uploaded.');
}

}
