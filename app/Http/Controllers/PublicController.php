<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Certificate;
use App\Models\WorkOrder;

class PublicController extends Controller
{
    public function verify($certificate_no, $job_no){
        // Retrieve the certificate and job using the provided numbers
        $certificate = Certificate::where('id', $certificate_no)->first();

        // Check if both the certificate and job exist
        if (!$certificate) {
            return view('public.verification_not_found');
        }

        // Check if the job ID matches the certificate's job ID
        if ((string) $certificate->trainee->training->job->id !== (string) $job_no) {
            return view('public.verification_invalid');
        }
        $data['certificate'] = $certificate;
        // Return the certificate details to the view
        return view('public.verification')->with($data);
    }
}
