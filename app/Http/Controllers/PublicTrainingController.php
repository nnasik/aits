<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Training;
use App\Models\TrainingTrainee;
use Illuminate\Support\Facades\Storage;

class PublicTrainingController extends Controller
{
    /**
     * Show training with trainee list (public link, hash protected)
     */
    public function showTraining($hash){
        $training = Training::where('hash', $hash)
            ->with(['trainees' => function($q) {
                $q->withPivot('id','photo','signature');
            }])
            ->firstOrFail();

        return view('public.training', compact('training'));
    }

    /**
     * Save trainee signature
     */
    public function saveSignature(Request $request, $trainingId, $pivotId)
    {
        $request->validate([
            'signature' => 'required|string',
        ]);

        // Convert Base64 to PNG
        $data = $request->input('signature');
        $data = str_replace('data:image/png;base64,', '', $data);
        $data = str_replace(' ', '+', $data);
        $imageName = 'signatures/' . uniqid('sig_') . '.png';
        Storage::disk('public')->put($imageName, base64_decode($data));

        // Find pivot record & update
        $pivot = TrainingTrainee::where('training_id', $trainingId)
            ->where('id', $pivotId)
            ->firstOrFail();

        $pivot->update([
            'signature' => $imageName,
        ]);

        return redirect()->back()->with('success', 'Signature saved successfully.');
    }

    /**
     * Upload trainee photo
     */
    public function uploadPhoto(Request $request, $trainingId, $traineeId)
    {
        $request->validate([
            'photo' => 'required|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('trainee_photos', 'public');

            // Find pivot record & update
            $pivot = TrainingTrainee::where('training_id', $trainingId)
                ->where('trainee_id', $traineeId)
                ->firstOrFail();

            $pivot->update([
                'photo' => $path,
            ]);

            return redirect()->back()->with('success', 'Photo uploaded successfully.');
        }

        return redirect()->back()->with('error', 'No photo uploaded.');
    }
}