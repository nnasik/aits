<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Certificate;
use App\Models\Trainee;
use FPDF;

class CertificateController extends Controller
{
    public function index(){
        // Get IDs of trainees who already have certificates
        $traineeIdsWithCertificates = Certificate::pluck('trainee_id')->toArray();
        // Only get trainees that don't have certificates yet
        $data['trainees'] = Trainee::whereNotIn('id', $traineeIdsWithCertificates)->get();
        // Get all certificates
        $data['certificates'] = Certificate::get();
        return view('certificate.index', $data);
    }

    public function store(Request $request){
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

    public function certificatePDF_V1($id){
        $record = Certificate::findOrFail($id);

        // Import FPDF (absolute path from vendor)
        require_once base_path('vendor/setasign/fpdf/fpdf.php');

        $pdf = new FPDF();
        $pdf->AliasNbPages();
        $pdf->SetMargins(10, 10);
        $pdf->SetAutoPageBreak(true, 30);

        $pdf->AddPage('L');
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
        $pdf->Cell(170,9, strtoupper($record->candidate_name_in_certificate),0,0,'L');
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

        // Download as PDF
        return response($pdf->Output('S'))
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', 'inline; filename="Certificate_'.$record->id.'.pdf"');
    }

    public function certificatePDF_V2($id){
        $record = Certificate::findOrFail($id);

        // Import FPDF (absolute path from vendor)
        require_once base_path('vendor/setasign/fpdf/fpdf.php');

        $pdf = new FPDF();
        $pdf->AliasNbPages();
        $pdf->SetMargins(10, 0);
        $pdf->SetAutoPageBreak(true, 20);

        $pdf->AddPage('L');
        // Some space
        $pdf->Ln(40);

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
        $pdf->Cell(170,9, strtoupper($record->candidate_name_in_certificate),0,0,'L');
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

        // The text or URL to encode
        $qrData = 'https://aitsacademy.com/verify/'.$record->id.'/'.$record->trainee->training->job->id;

        $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' . urlencode($qrData);

        $tempPath = storage_path('app/temp_qr.png');
        file_put_contents($tempPath, file_get_contents($qrUrl));

        $pdf->Image($tempPath, 10, 163, 20, 20);
        unlink($tempPath); // delete temporary file

        $pdf->SetFont('Times','',9);
        $pdf->setXY(30,175);
        $pdf->Cell(20,6, "Verify this certificate at",0,0,'L');
        
        $pdf->setXY(30,182);
        $pdf->Cell(20,0, $qrData,0,0,'L');
        

        // Download as PDF
        return response($pdf->Output('S'))
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', 'inline; filename="Certificate_'.$record->id.'.pdf"');
    }
}
