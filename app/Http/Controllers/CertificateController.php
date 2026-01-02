<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Certificate;
use App\Models\Trainee;
use Spatie\PdfToImage\Pdf;
use FPDF;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Geometry\Factories\LineFactory;
use Illuminate\Support\Str;
use Auth;

class CertificateController extends Controller
{
    public function index(Request $request){

        // Get all certificates
        
        if(isset($request->search_1)){
            $data['search_1'] = $request->search_1;
            $data['certificates'] = Certificate::where('id','LIKE',"%{$request->search_1}%")->orWhere('candidate_name_in_certificate','LIKE',"%{$request->search_1}%")->orWhere('eid_no','LIKE',"%{$request->search_1}%")->orderBy('id','desc')->paginate(20);
        }
        elseif (!empty($request->search_2)) {
            $search = $request->search_2;
            $data['search_2'] = $search;

            $data['certificates'] = Certificate::where(function ($q) use ($search) {

                $q->where('company_name_in_certificate', 'LIKE', "%{$search}%")
                ->orWhereHas('trainee.training', function ($r) use ($search) {
                    $r->where('work_order_id', 'LIKE', "%{$search}%");
                });

            })
            ->orderBy('id', 'desc')
            ->paginate(20);
        }
        else {
            $data['certificates'] = Certificate::orderBy('id','desc')->paginate(20);
        }
        $user = Auth::user();
        $user_settings = $user->settings;
        $data['user_settings'] = $user_settings->pluck('value', 'key')->toArray();

        return view('certificate.index', $data);
    }

    public function waiting(){
        // Get IDs of trainees who already have certificates
        $traineeIdsWithCertificates = Certificate::pluck('trainee_id')->toArray();

        // Only get trainees that don't have certificates yet
        $data['trainees'] = Trainee::whereNotIn('id', $traineeIdsWithCertificates)
            ->whereNotNull('signature')
            ->whereHas('training', function ($q) {
                $q->whereNotNull('work_order_id');
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        // Safely get next certificate ID
        $data['certificate_next_id'] = Certificate::max('id') ? Certificate::max('id') + 1 : 1;

        return view('certificate.waiting', $data);
    }

    public function store(Request $request){

        // 
        $jobNo = $request->input('job_no');           
        $certNo = $request->input('certificate_no'); 
        $secret = env('CERT_HASH_SALT', 'default_secret');

        // Combine data for hash
        $data = $jobNo . '|' . $certNo . '|' . $secret;

        // Hash (SHA256)
        $hash = hash('sha256', $data);

        // Encode first 16 chars as base36 and take 10 chars
        $shortHash = substr(base_convert(substr($hash, 0, 16), 16, 36), 0, 10);

        // Ensure uniqueness in DB (collision handling)
        while (Certificate::where('hash', $shortHash)->exists()) {
            $data .= '|' . Str::random(4);  // slightly change input
            $hash = hash('sha256', $data);
            $shortHash = substr(base_convert(substr($hash, 0, 16), 16, 36), 0, 10);
        }

        $validated = $request->validate([
            'id' => 'required|numeric|unique:certificates,id',
            'job_id' => 'required|exists:work_orders,id',
            'trainee_id' => 'required|exists:trainees,id',
            'candidate_name_in_certificate' => 'required|string|max:255',
            'company_name_in_certificate' => 'required|string|max:255',
            'company_location' => 'required|string|max:255',
            'course_name_in_certificate' => 'required|string|max:255',
            'text_1' => 'nullable|string|max:255',
            'text_2' => 'nullable|string|max:255',
            'text_3' => 'nullable|string|max:255',
            'eid_no' => 'nullable|string|max:255',
            'passport_no' => 'nullable|string|max:255',
            'date' => 'required|date',
            'valid_unit' => 'required|date',
            'live_photo' => 'nullable|image|max:2048',
        ]);
        
        $validated['hash'] = $shortHash;

        // Fetch the trainee record
        $trainee = Trainee::findOrFail($request->trainee_id);

        // 🧩 Handle live photo
        if ($request->hasFile('live_photo')) {
            // User uploaded a new photo → store it
            $validated['live_photo'] = $request->file('live_photo')->store('certificates/photos', 'public');
        } else {
            // No new photo → use trainee’s existing photo if available
            $validated['live_photo'] = $trainee->live_photo ?? null;
        }

        // ✅ Create certificate (with manual id)
         Certificate::create($validated);

        return redirect()->back()->with('success', 'Certificate created successfully!');
    }

    public function certificate($id){
        $certificate_record = Certificate::findOrFail($id);
        $certificate_pdf = new FPDF();
        $certificate_pdf = $this->certificatePDF($certificate_pdf,$certificate_record);
        // Download as PDF
        return response($certificate_pdf->Output('S'))
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', 'inline; filename="Certificate_'.$id.'.pdf"');
    }

    public function card($id){
        

        $certificate_record = Certificate::findOrFail($id);
        $card_pdf = new FPDF();
        $card_pdf = $this->cardPDF($card_pdf, $certificate_record);

        // Download as PDF
        return response($card_pdf->Output('S'))
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', 'inline; filename="ID_Card_'.$id.'.pdf"');
    }

    public function scan($id){
        $certificate_record = Certificate::findOrFail($id);

        $scan_pdf = new FPDF();

        $scan_pdf = $this->certificatePDF($scan_pdf,$certificate_record);
        $scan_pdf = $this->cardPDF($scan_pdf,$certificate_record);

        // Download as PDF
        return response($scan_pdf->Output('S'))
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', 'inline; filename="AITS-'.$certificate_record->trainee->training->job->id."-".$certificate_record->id."-".substr($certificate_record->company_name_in_certificate, 0, 20)."-".substr($certificate_record->candidate_name_in_certificate, 4,20).'.pdf"');
    }

    private function certificatePDF($pdf, $record){

        $user = Auth::user();
        $user_settings = $user->settings;
        $user_settings = $user_settings->pluck('value', 'key')->toArray();

        
        // Import FPDF (absolute path from vendor)
        require_once base_path('vendor/setasign/fpdf/fpdf.php');

        $pdf->AliasNbPages();
        $pdf->SetMargins(10, 10);
        $pdf->SetAutoPageBreak(false);

        $pdf->AddPage('L');

        // BG Option
        if (isset($user_settings['certificate_bg']) && $user_settings['certificate_bg']!=0) {

            $file_name = '';
            if ($user_settings['certificate_bg']==1) {
                $file_name = 'certificate_bg_1';
            }
            elseif ($user_settings['certificate_bg']==2) {
                $file_name = 'certificate_bg_2';
            }
            elseif ($user_settings['certificate_bg']==3) {
                $file_name = 'certificate_bg_3';
            }
            if (isset($user_settings['certificate_quality_option']) && $user_settings['certificate_quality_option']==1) {
                $file_name = $file_name."_min";
            }
            $path = 'assets/images/digital/'. $file_name.".jpg";
            $pdf->Image(public_path($path), 0,0, 297, 210);
        }

        // Some space
        $pdf->Ln(30);

        $pdf->SetFont('Times','B',26);
        $pdf->SetTextColor(0, 0, 139); // Dark Blue = RGB(0,0,139)
        $pdf->Cell(275,14, strtoupper($record->text_1),0,1,'C');
        $pdf->SetFont('Times','',14);

        $pdf->SetTextColor(0, 0, 0); // Dark Blue = RGB(0,0,139)
        $pdf->Cell(05,10, "",0,0,'L');
        $pdf->Cell(35,10, "Certificate No. : ",0,0,'L');
        $pdf->SetFont('Times','B',14);
        $pdf->Cell(50,10, "AITS".$record->id,0,0,'L');
        $pdf->SetFont('Times','',14);
        $pdf->Cell(115,10, "",0,0,'L');
        $pdf->Cell(40,10, "Job No. : ",0,0,'R');
        $pdf->SetFont('Times','B',14);
        $pdf->Cell(25,10, "AITS-".$record->trainee->training->job->id,0,0,'R');
        $pdf->SetFont('Times','',14);
        $pdf->Cell(05,10, "",0,1,'L');

        $pdf->Cell(275,10, "This is to certify that ",0,1,'C');

        $pdf->SetFont('Times','B',14);
        $pdf->Cell(05,9, "",0,0,'L');
        $pdf->Cell(170,9, substr($record->candidate_name_in_certificate, 0, 3) . strtoupper(substr($record->candidate_name_in_certificate, 3)),0,0,'L');
        if($record->eid_no){
            $pdf->Cell(95,9, "Emirates ID No : ".$record->eid_no,0,0,'R');
        }
        elseif($record->passport_no){
            $pdf->Cell(95,9, "Passport No : ".$record->passport_no,0,0,'R');
        }
        $pdf->Cell(10,9, "",0,1,'L');


        $pdf->SetFont('Times','',14);
        $pdf->Cell(05,9, "",0,0,'L');
        $pdf->Cell(170,9, "an employee of",0,1,'L');

        $pdf->SetFont('Times','B',14);
        $pdf->Cell(05,9, "",0,0,'L');
        $pdf->Cell(170,9, strtoupper($record->company_name_in_certificate),0,1,'L');

        $pdf->SetFont('Times','',14);
        $pdf->Cell(05,9, "",0,0,'L');
        $pdf->Cell(170,9, $record->company_location,0,1,'L');

        $pdf->SetFont('Times','',14);
        $pdf->Cell(05,9, "",0,0,'L');
        $pdf->Cell(170,9, $record->text_2,0,1,'L');

        $pdf->SetFont('Times','B',16);
        $pdf->Cell(05,10, "",0,0,'L');
        $pdf->Cell(170,10, strtoupper("\"".$record->course_name_in_certificate."\""),0,1,'L');
        
        $pdf->SetFont('Times','',12);
        $pdf->Cell(05,8, "",0,0,'L');
        $pdf->Cell(265,8, "Date of Training : ".$record->date,0,0,'R');
        $pdf->Cell(05,8, "",0,1,'L');

        $pdf->SetFont('Times','',12);
        $pdf->Cell(05,8, "",0,0,'L');
        $pdf->Cell(265,8, "Valid Until : ".$record->valid_unit,0,0,'R');
        $pdf->Cell(05,8, "",0,1,'L');

        //$pdf->setXY(0,165);
        $pdf->SetFont('Times','',14);
        $pdf->Cell(05,20, "",0,0,'L');
        $pdf->Cell(255,10, "Trainer : _______________________",0,0,'C');
        $pdf->Cell(05,20, "",0,1,'L');

        // Picture Border
        $pdf->setXY(252,85);
        $pdf->Cell(27,32, "",1,1,'R');

        // Live Photo
        if ($record->live_photo) {
            $pdf->Image(public_path('storage/'.$record->live_photo), 253, 86, 25, 30);
        } else {
            $pdf->Image(public_path('assets/images/user_placeholder.jpg'), 253, 86, 25, 30);
        }

        // Signature Option
        if (isset($user_settings['certificate_signature_option']) && $user_settings['certificate_signature_option']==1) {
             $pdf->Image(public_path('assets/images/digital/digital_signature_1-min.png'), 140,135, 22, 18);
        }
        

        // Stamp
        if (isset($user_settings['certificate_stamp_option']) &&  $user_settings['certificate_stamp_option']==1) {
             $pdf->Image(public_path('assets/images/digital/digital_stamp-min.png'), 150,120, 35, 35);
        }
       
        // QR Code Option
        if (isset($user_settings['certificate_qr_option']) && $user_settings['certificate_qr_option']!=0 ) {
            // The text or URL to encode
            $qrData = 'https://auh.aitsacademy.com/verify/'.$record->hash.'/';

            $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' . urlencode($qrData);

            $tempPath = storage_path('app/temp_qr.png');
            file_put_contents($tempPath, file_get_contents($qrUrl));

            // Place Left
            if ($user_settings['certificate_qr_option']==1 ) {
                $pdf->Image($tempPath, 10, 163, 20, 20);
                $pdf->SetFont('Times','',9);
                $pdf->setXY(30,175);
                $pdf->Cell(20,6, "Verify this certificate at",0,0,'L');
                
            }

            // Right Left
            elseif ($user_settings['certificate_qr_option']==2 ) {
                $pdf->Image($tempPath, 258, 158, 20, 20);
                $pdf->SetFont('Times','',9);
                $pdf->setXY(258,179);
                $pdf->Cell(20,6, "Visit https://www.aitsacademy.com for certificate verification",0,0,'R');
            }
           
            unlink($tempPath); // delete temporary file
        }

        return $pdf;

    }


    public function cardPDF($pdf, $record){
        $user = Auth::user();
        $user_settings = $user->settings;
        $user_settings = $user_settings->pluck('value', 'key')->toArray();

        // Import FPDF (absolute path from vendor)
        require_once base_path('vendor/setasign/fpdf/fpdf.php');

        
        $pdf->AddPage('L', [86, 54]);
        $pdf->SetMargins(0,0);
        $pdf->SetAutoPageBreak(true, 0);
        // Some space
        

        $pdf->setXY(67.8,19.8);
        $pdf->Cell(15.4,19.5, "",1,1,'L');

        $pdf->Image(public_path('assets/images/logo.png'), 32, 0, 22, 12);
        if ($record->live_photo) {
            $pdf->Image(public_path('storage/'.$record->live_photo), 68, 20, 15, 19);
        } else {
            $pdf->Image(public_path('assets/images/user_placeholder.jpg'), 68, 20, 15, 19);
        }
        
        if (isset($user_settings['certificate_idcard_option']) &&  $user_settings['certificate_idcard_option']==1) {
            $pdf->setXY(2,0);
            $pdf->SetFont('Arial','B',4.6);
            $pdf->Cell(15,23, "AMERICAN INTERNATIONAL TRAINING SERVICES LLC - ABU DHABI, U.A.E | Contact : +971 55914 7537",0,1,'L');
            $pdf->setXY(3,13);
            $pdf->Cell(80,0, "",1,1,'L');
        }
        elseif (isset($user_settings['certificate_idcard_option']) &&  $user_settings['certificate_idcard_option']==2) {
            $pdf->setXY(0,0);
            $pdf->SetFont('Arial','B',4.8);
            $pdf->Cell(15,23, "AMERICAN INTERNATIONAL TRAINING SERVICES LLC - ABU DHABI, U.A.E | Contact : +971 55914 7537",0,1,'L');
            $pdf->setXY(0,13);
            $pdf->Cell(86,0, "",1,1,'L');
        }

        

        $pdf->SetTextColor(0, 0, 70); // Dark Blue = RGB(0,0,139)
        $pdf->setXY(2,15);
        $pdf->SetFont('Arial','B',6);
        $pdf->Cell(84,4, "Candidate Name : ",0,1,'L');
        $pdf->setXY(2,21);
        $pdf->Cell(64,4, "Job & Certificate No : ",0,1,'L');
        $pdf->setXY(2,27);
        $pdf->Cell(64,4, "Training Date : ",0,1,'L');
        $pdf->setXY(2,33);
        $pdf->Cell(64,4, "Valid Until : ",0,1,'L');
        $pdf->setXY(2,39);
        $pdf->Cell(82,4, "Company : ",0,1,'L');

        $pdf->SetTextColor(0, 0, 0);

        $pdf->setXY(21,15);
        $pdf->SetFont('Arial','B',6);
        $pdf->Cell(64,4,substr($record->candidate_name_in_certificate, 0, 3) . strtoupper(substr($record->candidate_name_in_certificate, 3)),0,1,'L');
        $pdf->setXY(25,21);
        $pdf->Cell(44,4, "AITS-".$record->trainee->training->job->id . " | AITS". $record->id,0,1,'L');
        $pdf->setXY(18,27);
        $pdf->Cell(44,4, $record->date,0,1,'L');
        $pdf->setXY(14,33);
        $pdf->Cell(44,4, $record->valid_unit,0,1,'L');
        $pdf->setXY(14,39);
        $pdf->Cell(44,4, $record->company_name_in_certificate,0,1,'L');

        if (isset($user_settings['certificate_idcard_option']) &&  $user_settings['certificate_idcard_option']==1) {
            $pdf->setXY(3,44);
            $pdf->SetFillColor(4,63,122);
            $pdf->SetTextColor(255, 255, 255);
            $pdf->SetFont('Arial','B',7);
            $pdf->Cell(80,5, "Has successfully completed safety training for the following",0,1,'C',1);
            
            $pdf->setXY(3,49);
            $pdf->SetFillColor(4,63,122);
            $pdf->SetTextColor(255, 255, 255);
            $pdf->SetFont('Arial','B',7);
            $pdf->Cell(80,5, "\"".$record->course_name_in_certificate."\"",0,1,'C',1);
        }
        elseif (isset($user_settings['certificate_idcard_option']) &&  $user_settings['certificate_idcard_option']==2) {
            $pdf->setXY(0,44);
            $pdf->SetFillColor(4,63,122);
            $pdf->SetTextColor(255, 255, 255);
            $pdf->SetFont('Arial','B',7);
            $pdf->Cell(86,5, "Has successfully completed safety training for the following",0,1,'C',1);
            
            $pdf->setXY(0,49);
            $pdf->SetFillColor(4,63,122);
            $pdf->SetTextColor(255, 255, 255);
            $pdf->SetFont('Arial','B',7);
            $pdf->Cell(86,5, "\"".$record->course_name_in_certificate."\"",0,1,'C',1);
            
        }
        
        return $pdf;

        
    }

    public function scan_v_1_1($id){

        $record = Certificate::findOrFail($id);

        require_once base_path('vendor/setasign/fpdf/fpdf.php');

        $pdf = new FPDF();

        $pdf->AddPage('L', [297, 210]); // same as original certificate size (A4 landscape)

        $pdf->AliasNbPages();
        $pdf->SetMargins(10, 10);
        $pdf->SetAutoPageBreak(true, 30);
        $pdf->Image(public_path('assets/images/digital/certificate_bg_min.png'), 0,0, 297, 210);
        // Some space
        $pdf->Ln(30);

        $pdf->SetFont('Times','B',26);
        $pdf->SetTextColor(0, 0, 139); // Dark Blue = RGB(0,0,139)
        $pdf->Cell(275,14, strtoupper($record->text_1),0,1,'C');
        $pdf->SetFont('Times','',14);

        $pdf->SetTextColor(0, 0, 0); // Dark Blue = RGB(0,0,139)
        $pdf->Cell(10,10, "",0,0,'L');
        $pdf->Cell(35,10, "Certificate No. : ",0,0,'L');
        $pdf->SetFont('Times','B',14);
        $pdf->Cell(50,10, "AITS".$record->id,0,0,'L');
        $pdf->SetFont('Times','',14);
        $pdf->Cell(105,10, "",0,0,'L');
        $pdf->Cell(30,10, "Job No. : ",0,0,'R');
        $pdf->SetFont('Times','B',14);
        $pdf->Cell(35,10, "AITS-".$record->trainee->training->job->id,0,0,'R');
        $pdf->SetFont('Times','',14);
        $pdf->Cell(10,10, "",0,1,'L');

        $pdf->Cell(275,10, "This is to certify that ",0,1,'C');

        $pdf->SetFont('Times','B',14);
        $pdf->Cell(10,9, "",0,0,'L');
        $pdf->Cell(170,9, substr($record->candidate_name_in_certificate, 0, 3) . strtoupper(substr($record->candidate_name_in_certificate, 3)),0,0,'L');
        if($record->eid_no){
            $pdf->Cell(85,9, "Emirates ID No : ".$record->eid_no,0,0,'R');
        }
        elseif($record->passport_no){
            $pdf->Cell(85,9, "Passport No : ".$record->passport_no,0,0,'R');
        }
        $pdf->Cell(10,9, "",0,1,'L');
        

        $pdf->SetFont('Times','',14);
        $pdf->Cell(10,9, "",0,0,'L');
        $pdf->Cell(170,9, "an employee of",0,1,'L');

        $pdf->SetFont('Times','B',14);
        $pdf->Cell(10,9, "",0,0,'L');
        $pdf->Cell(170,9, strtoupper($record->company_name_in_certificate),0,1,'L');

        $pdf->SetFont('Times','',14);
        $pdf->Cell(10,9, "",0,0,'L');
        $pdf->Cell(170,9, $record->company_location,0,1,'L');

        $pdf->SetFont('Times','',14);
        $pdf->Cell(10,9, "",0,0,'L');
        $pdf->Cell(170,9, $record->text_2,0,1,'L');

        $pdf->SetFont('Times','B',16);
        $pdf->Cell(10,10, "",0,0,'L');
        $pdf->Cell(170,10, strtoupper("\"".$record->course_name_in_certificate."\""),0,1,'L');
        
        $pdf->SetFont('Times','',12);
        $pdf->Cell(10,8, "",0,0,'L');
        $pdf->Cell(255,8, "Date of Training : ".$record->date,0,0,'R');
        $pdf->Cell(10,8, "",0,1,'L');

        $pdf->SetFont('Times','',12);
        $pdf->Cell(10,8, "",0,0,'L');
        $pdf->Cell(255,8, "Valid Until : ".$record->valid_unit,0,0,'R');
        $pdf->Cell(10,8, "",0,1,'L');

        $pdf->Image(public_path('assets/images/digital/digital_signature_1-min.png'), 140,135, 22, 18);
        $pdf->Image(public_path('assets/images/digital/digital_stamp-min.png'), 150,120, 35, 35);

        
        $pdf->SetFont('Times','',14);
        $pdf->Cell(10,20, "",0,0,'L');
        $pdf->Cell(255,10, "Trainer : _______________________",0,0,'C');
        $pdf->Cell(10,20, "",0,1,'L');

        $pdf->setXY(246,85);
        $pdf->Cell(27,32, "",1,1,'R');
        if ($record->live_photo) {
            $pdf->Image(public_path('storage/'.$record->live_photo), 247, 86, 25, 30);
        } else {
            $pdf->Image(public_path('assets/images/user_placeholder.jpg'), 247, 86, 25, 30);
        }




        $pdf->AddPage('L', [86, 54]); // same size as original ID card

        $pdf->SetMargins(0,0);
        $pdf->SetAutoPageBreak(true, 0);
        // Some space
        $pdf->Image(public_path('assets/images/logo.png'), 32, 0, 22, 12);
        if ($record->live_photo) {
            $pdf->Image(public_path('storage/'.$record->live_photo), 68, 20, 15, 19);
        } else {
            $pdf->Image(public_path('assets/images/user_placeholder.jpg'), 68, 20, 15, 19);
        }
        $pdf->setXY(0,0);
        $pdf->SetFont('Arial','B',4.8);
        $pdf->Cell(15,23, "AMERICAN INTERNATIONAL TRAINING SERVICES LLC - ABU DHABI, U.A.E | Contact : +971 55914 7537",0,1,'L');
        $pdf->setXY(0,13);
        $pdf->Cell(86,0, "",1,1,'L');

        $pdf->SetTextColor(0, 0, 70); // Dark Blue = RGB(0,0,139)
        $pdf->setXY(2,15);
        $pdf->SetFont('Arial','B',6);
        $pdf->Cell(84,4, "Candidate Name : ",0,1,'L');
        $pdf->setXY(2,21);
        $pdf->Cell(64,4, "Job & Certificate No : ",0,1,'L');
        $pdf->setXY(2,27);
        $pdf->Cell(64,4, "Training Date : ",0,1,'L');
        $pdf->setXY(2,33);
        $pdf->Cell(64,4, "Due Date : ",0,1,'L');
        $pdf->setXY(2,39);
        $pdf->Cell(82,4, "Company : ",0,1,'L');

        $pdf->SetTextColor(0, 0, 0);

        $pdf->setXY(21,15);
        $pdf->SetFont('Arial','B',6);
        $pdf->Cell(64,4,substr($record->candidate_name_in_certificate, 0, 3) . strtoupper(substr($record->candidate_name_in_certificate, 3)),0,1,'L');
        $pdf->setXY(25,21);
        $pdf->Cell(44,4, "AITS-".$record->trainee->training->job->id . " | AITS". $record->id,0,1,'L');
        $pdf->setXY(18,27);
        $pdf->Cell(44,4, $record->date,0,1,'L');
        $pdf->setXY(14,33);
        $pdf->Cell(44,4, $record->valid_unit,0,1,'L');
        $pdf->setXY(14,39);
        $pdf->Cell(44,4, $record->company_name_in_certificate,0,1,'L');

        $pdf->setXY(0,44);
        $pdf->SetFillColor(4,63,122);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('Arial','B',7);
        $pdf->Cell(86,5, "Has successfully completed safety training for the following",0,1,'C',1);
        
        $pdf->setXY(0,49);
        $pdf->SetFillColor(4,63,122);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('Arial','B',7);
        $pdf->Cell(86,5, "\"".$record->course_name_in_certificate."\"",0,1,'C',1);

        return response($pdf->Output('S'))
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="AITS-'.$record->trainee->training->job->id."-".$record->id."-".substr($record->company_name_in_certificate, 0, 20)."-".substr($record->candidate_name_in_certificate, 4,20).'.pdf"');
    }

    public function scan_v_1_2($id){

        $record = Certificate::findOrFail($id);

        require_once base_path('vendor/setasign/fpdf/fpdf.php');

        $pdf = new FPDF();

        $pdf->AddPage('L', [297, 210]); // same as original certificate size (A4 landscape)

        $pdf->AliasNbPages();
        $pdf->SetMargins(10, 10);
        $pdf->SetAutoPageBreak(true, 30);
        $pdf->Image(public_path('assets/images/digital/certificate_bg_2.jpg'), 0,0, 297, 210);
        // Some space
        $pdf->Ln(30);

        $pdf->SetFont('Times','B',26);
        $pdf->SetTextColor(0, 0, 139); // Dark Blue = RGB(0,0,139)
        $pdf->Cell(275,14, strtoupper($record->text_1),0,1,'C');
        $pdf->SetFont('Times','',14);

        $pdf->SetTextColor(0, 0, 0); // Dark Blue = RGB(0,0,139)
        $pdf->Cell(10,10, "",0,0,'L');
        $pdf->Cell(35,10, "Certificate No. : ",0,0,'L');
        $pdf->SetFont('Times','B',14);
        $pdf->Cell(50,10, "AITS".$record->id,0,0,'L');
        $pdf->SetFont('Times','',14);
        $pdf->Cell(105,10, "",0,0,'L');
        $pdf->Cell(30,10, "Job No. : ",0,0,'R');
        $pdf->SetFont('Times','B',14);
        $pdf->Cell(35,10, "AITS-".$record->trainee->training->job->id,0,0,'R');
        $pdf->SetFont('Times','',14);
        $pdf->Cell(10,10, "",0,1,'L');

        $pdf->Cell(275,10, "This is to certify that ",0,1,'C');

        $pdf->SetFont('Times','B',14);
        $pdf->Cell(10,9, "",0,0,'L');
        $pdf->Cell(170,9, substr($record->candidate_name_in_certificate, 0, 3) . strtoupper(substr($record->candidate_name_in_certificate, 3)),0,0,'L');
        if($record->eid_no){
            $pdf->Cell(85,9, "Emirates ID No : ".$record->eid_no,0,0,'R');
        }
        elseif($record->passport_no){
            $pdf->Cell(85,9, "Passport No : ".$record->passport_no,0,0,'R');
        }
        $pdf->Cell(10,9, "",0,1,'L');
        

        $pdf->SetFont('Times','',14);
        $pdf->Cell(10,9, "",0,0,'L');
        $pdf->Cell(170,9, "an employee of",0,1,'L');

        $pdf->SetFont('Times','B',14);
        $pdf->Cell(10,9, "",0,0,'L');
        $pdf->Cell(170,9, strtoupper($record->company_name_in_certificate),0,1,'L');

        $pdf->SetFont('Times','',14);
        $pdf->Cell(10,9, "",0,0,'L');
        $pdf->Cell(170,9, $record->company_location,0,1,'L');

        $pdf->SetFont('Times','',14);
        $pdf->Cell(10,9, "",0,0,'L');
        $pdf->Cell(170,9, $record->text_2,0,1,'L');

        $pdf->SetFont('Times','B',16);
        $pdf->Cell(10,10, "",0,0,'L');
        $pdf->Cell(170,10, strtoupper("\"".$record->course_name_in_certificate."\""),0,1,'L');
        
        $pdf->SetFont('Times','',12);
        $pdf->Cell(10,8, "",0,0,'L');
        $pdf->Cell(255,8, "Date of Training : ".$record->date,0,0,'R');
        $pdf->Cell(10,8, "",0,1,'L');

        $pdf->SetFont('Times','',12);
        $pdf->Cell(10,8, "",0,0,'L');
        $pdf->Cell(255,8, "Valid Until : ".$record->valid_unit,0,0,'R');
        $pdf->Cell(10,8, "",0,1,'L');

        $pdf->Image(public_path('assets/images/digital/digital_signature_1-min.png'), 140,135, 22, 18);
        $pdf->Image(public_path('assets/images/digital/digital_stamp-min.png'), 150,120, 35, 35);

        $pdf->SetFont('Times','',14);
        $pdf->Cell(10,20, "",0,0,'L');
        $pdf->Cell(255,10, "Trainer : _______________________",0,0,'C');
        $pdf->Cell(10,20, "",0,1,'L');

        $pdf->setXY(246,85);
        $pdf->Cell(27,32, "",1,1,'R');
        if ($record->live_photo) {
            $pdf->Image(public_path('storage/'.$record->live_photo), 247, 86, 25, 30);
        } else {
            $pdf->Image(public_path('assets/images/user_placeholder.jpg'), 247, 86, 25, 30);
        }




        $pdf->AddPage('L', [86, 54]); // same size as original ID card

        $pdf->SetMargins(0,0);
        $pdf->SetAutoPageBreak(true, 0);
        // Some space
        $pdf->Image(public_path('assets/images/logo.png'), 32, 0, 22, 12);
        if ($record->live_photo) {
            $pdf->Image(public_path('storage/'.$record->live_photo), 68, 20, 15, 19);
        } else {
            $pdf->Image(public_path('assets/images/user_placeholder.jpg'), 68, 20, 15, 19);
        }
        $pdf->setXY(0,0);
        $pdf->SetFont('Arial','B',4.8);
        $pdf->Cell(15,23, "AMERICAN INTERNATIONAL TRAINING SERVICES LLC - ABU DHABI, U.A.E | Contact : +971 55914 7537",0,1,'L');
        $pdf->setXY(0,13);
        $pdf->Cell(86,0, "",1,1,'L');

        $pdf->SetTextColor(0, 0, 70); // Dark Blue = RGB(0,0,139)
        $pdf->setXY(2,15);
        $pdf->SetFont('Arial','B',6);
        $pdf->Cell(84,4, "Candidate Name : ",0,1,'L');
        $pdf->setXY(2,21);
        $pdf->Cell(64,4, "Job & Certificate No : ",0,1,'L');
        $pdf->setXY(2,27);
        $pdf->Cell(64,4, "Training Date : ",0,1,'L');
        $pdf->setXY(2,33);
        $pdf->Cell(64,4, "Due Date : ",0,1,'L');
        $pdf->setXY(2,39);
        $pdf->Cell(82,4, "Company : ",0,1,'L');

        $pdf->SetTextColor(0, 0, 0);

        $pdf->setXY(21,15);
        $pdf->SetFont('Arial','B',6);
        $pdf->Cell(64,4,substr($record->candidate_name_in_certificate, 0, 3) . strtoupper(substr($record->candidate_name_in_certificate, 3)),0,1,'L');
        $pdf->setXY(25,21);
        $pdf->Cell(44,4, "AITS-".$record->trainee->training->job->id . " | AITS". $record->id,0,1,'L');
        $pdf->setXY(18,27);
        $pdf->Cell(44,4, $record->date,0,1,'L');
        $pdf->setXY(14,33);
        $pdf->Cell(44,4, $record->valid_unit,0,1,'L');
        $pdf->setXY(14,39);
        $pdf->Cell(44,4, $record->company_name_in_certificate,0,1,'L');

        $pdf->setXY(0,44);
        $pdf->SetFillColor(4,63,122);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('Arial','B',7);
        $pdf->Cell(86,5, "Has successfully completed safety training for the following",0,1,'C',1);
        
        $pdf->setXY(0,49);
        $pdf->SetFillColor(4,63,122);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('Arial','B',7);
        $pdf->Cell(86,5, "\"".$record->course_name_in_certificate."\"",0,1,'C',1);

        return response($pdf->Output('S'))
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="AITS-'.$record->trainee->training->job->id."-".$record->id."-".substr($record->company_name_in_certificate, 0, 20)."-".substr($record->candidate_name_in_certificate, 4,20).'.pdf"');
    }

    public function certificate_preview_v_1_1($hash){
        // Dynamic values from query 
        $certificate = Certificate::where('hash',$hash)->first();

        // Load template certificate background
        $manager = new ImageManager(new Driver());
        $image = $manager->read(storage_path('app/certificates/template_1.jpg'));

        // Path to Cambria font
        $cambriaFont = storage_path('app/fonts/cambria.ttc'); // Make sure the TTF file exists here
        $cambriaBoldFont = storage_path('app/fonts/cambriab.ttf'); // Make sure the TTF file exists here

        // Add Name
        $image->text($certificate->text_1, 420, 120, function ($font) use ($cambriaBoldFont) {
            $font->file($cambriaBoldFont);   // Set Cambria font
            $font->size(32);            // Bigger size
            $font->color('#000000');
            $font->align('center');
            $font->valign('top');
        });

        // Certificate No
        $image->text('Certificate No : '.$certificate->id, 40, 160, function ($font) use ($cambriaFont) {
            $font->file($cambriaFont);   // Set Cambria font
            $font->size(18);            // Bigger size
            $font->color('#000000');
            $font->align('left');
            $font->valign('top');
        });
        
        // Job No
        $image->text('Job No : '.$certificate->trainee->training->job->id, 800, 160, function ($font) use ($cambriaFont) {
            $font->file($cambriaFont);   // Set Cambria font
            $font->size(18);            // Bigger size
            $font->color('#000000');
            $font->align('right');
            $font->valign('top');
        });

        // 
        $image->text('This is to certify that', 420, 200, function ($font) use ($cambriaFont) {
            $font->file($cambriaFont);   // Set Cambria font
            $font->size(18);            // Bigger size
            $font->color('#000000');
            $font->align('center');
            $font->valign('top');
        });

        // Certificate No
        $image->text($certificate->candidate_name_in_certificate, 40, 240, function ($font) use ($cambriaBoldFont) {
            $font->file($cambriaBoldFont);   // Set Cambria font
            $font->size(22);            // Bigger size
            $font->color('#000000');
            $font->align('left');
            $font->valign('top');
        });

        // Emirates ID
        $image->text("Emirates ID No. : ". $certificate->eid_no, 810, 240, function ($font) use ($cambriaBoldFont) {
            $font->file($cambriaBoldFont);   // Set Cambria font
            $font->size(18);            // Bigger size
            $font->color('#000000');
            $font->align('right');
            $font->valign('top');
        });

        // Employee of
        $image->text("Employee of ", 40, 270, function ($font) use ($cambriaFont) {
            $font->file($cambriaFont);   // Set Cambria font
            $font->size(18);            // Bigger size
            $font->color('#000000');
            $font->align('left');
            $font->valign('top');
        });

        // Company Name
        $image->text($certificate->company_name_in_certificate, 40, 300, function ($font) use ($cambriaBoldFont) {
            $font->file($cambriaBoldFont);   // Set Cambria font
            $font->size(22);            // Bigger size
            $font->color('#000000');
            $font->align('left');
            $font->valign('top');
        });

        // Employee of
        $image->text($certificate->company_location, 40, 330, function ($font) use ($cambriaFont) {
            $font->file($cambriaFont);   // Set Cambria font
            $font->size(18);            // Bigger size
            $font->color('#000000');
            $font->align('left');
            $font->valign('top');
        });

        // Employee of
        $image->text($certificate->text_2, 40, 370, function ($font) use ($cambriaFont) {
            $font->file($cambriaFont);   // Set Cambria font
            $font->size(18);            // Bigger size
            $font->color('#000000');
            $font->align('left');
            $font->valign('top');
        });

        // Employee of
        $image->text($certificate->course_name_in_certificate, 40, 400, function ($font) use ($cambriaBoldFont) {
            $font->file($cambriaBoldFont);   // Set Cambria font
            $font->size(22);            // Bigger size
            $font->color('#000000');
            $font->align('left');
            $font->valign('top');
        });

        // 
        $image->text('Trainer', 420, 500, function ($font) use ($cambriaFont) {
            $font->file($cambriaFont);   // Set Cambria font
            $font->size(18);            // Bigger size
            $font->color('#000000');
            $font->align('center');
            $font->valign('top');
        });

        // draw a half transparent white line
        $image->drawLine(function (LineFactory $line) {
            $line->from(320, 490);
            $line->to(520, 490);
            $line->color('000000');
            $line->width(4);
        });



        if ($certificate->live_photo) {
            $photo = $manager->read(public_path('storage/' . $certificate->live_photo));
            $photo = $photo->scaleDown(100); // max width or height = 100px
            $image->place(
            $photo,
            'right', 
            30, 
            30,
            100
            );
            
        } else {

            $photo = $manager->read(public_path('assets/images/user_placeholder.jpg'));
            $photo = $photo->scaleDown(100); // max width or height = 100px
            $image->place(
            $photo,
            'right', 
            30, 
            30,
            100
            );
        }

        // Date of Training
        $image->text('Date of Training : '.$certificate->date , 810, 410, function ($font) use ($cambriaFont) {
            $font->file($cambriaFont);   // Set Cambria font
            $font->size(18);            // Bigger size
            $font->color('#000000');
            $font->align('right');
            $font->valign('top');
        });

        // Valid Until
        $image->text('Valid Until : '.$certificate->valid_unit , 810, 440, function ($font) use ($cambriaFont) {
            $font->file($cambriaFont);   // Set Cambria font
            $font->size(18);            // Bigger size
            $font->color('#000000');
            $font->align('right');
            $font->valign('top');
        });

        



        // Encode as JPEG (this returns EncodedImage)
        $jpeg = $image->toJpeg(90);

        // Encode to JPEG → returns EncodedImage
        $jpeg = $image->toJpeg(90);

        // FINAL CORRECT OUTPUT
        return response($jpeg->toString(), 200)
            ->header('Content-Type', 'image/jpeg');
    }
    
}