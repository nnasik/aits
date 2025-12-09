<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Certificate;
use App\Models\WorkOrder;

class PublicController extends Controller
{
    public function verify($hash){
        // Retrieve the certificate and job using the provided numbers
        $certificate = Certificate::where('hash', $hash)->first();
        $data['hash'] = $hash;

        // Check if both the certificate and job exist
        if (!$certificate) {
            return view('public.verification_not_found');
        }

        $data['certificate'] = $certificate;
        // Return the certificate details to the view
        return view('public.verification')->with($data);
    }    
}
