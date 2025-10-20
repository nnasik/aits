<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Certificate;
use App\Models\Trainee;
use FPDF;

class CertificateController extends Controller
{
    public function index(){
        $data['trainees'] = Trainee::all();
        $data['certificates'] = Certificate::all();
        return view('certificate.index')->with($data);
    }

    public function store(Request $request){
        $request->validate([
            
        ]);
    }

    public function certificatePDF($id){
        $record = Trainee::findOrFail($id);

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

        $pdf->Cell(275,14, strtoupper("Certificate of Training"),0,1,'C');
        $pdf->SetFont('Times','',14);

        $pdf->Cell(10,10, "",0,0,'L');
        $pdf->Cell(35,10, "Certificate No. : ",0,0,'L');
        $pdf->SetFont('Times','B',14);
        $pdf->Cell(50,10, "AITS2025090063",0,0,'L');
        $pdf->SetFont('Times','',14);
        $pdf->Cell(105,10, "",0,0,'L');
        $pdf->Cell(30,10, "Job No. : ",0,0,'R');
        $pdf->SetFont('Times','B',14);
        $pdf->Cell(35,10, "AITS-0001368",0,0,'R');
        $pdf->SetFont('Times','',14);
        $pdf->Cell(10,10, "",0,1,'L');

        $pdf->Cell(275,10, "This is to certify that ",0,1,'C');

        $pdf->SetFont('Times','B',14);
        $pdf->Cell(10,9, "",0,0,'L');
        $pdf->Cell(170,9, strtoupper($record->trainee->name),0,0,'L');
        $pdf->Cell(85,9, "Emirates ID No : 784-1997-1161659-1",0,0,'R');
        $pdf->Cell(10,9, "",0,1,'L');

        $pdf->SetFont('Times','',14);
        $pdf->Cell(10,9, "",0,0,'L');
        $pdf->Cell(170,9, "an employee of",0,1,'L');

        $pdf->SetFont('Times','B',14);
        $pdf->Cell(10,9, "",0,0,'L');
        $pdf->Cell(170,9, strtoupper($record->trainee->company->name),0,1,'L');

        $pdf->SetFont('Times','',14);
        $pdf->Cell(10,9, "",0,0,'L');
        $pdf->Cell(170,9, "Dubai, United Arab Emirates.",0,1,'L');

        $pdf->SetFont('Times','',14);
        $pdf->Cell(10,9, "",0,0,'L');
        $pdf->Cell(170,9, "has successfully completed the Awareness Training on",0,1,'L');

        $pdf->SetFont('Times','B',16);
        $pdf->Cell(10,10, "",0,0,'L');
        $pdf->Cell(170,10, strtoupper("\"".$record->training->course->name."\""),0,1,'L');
        
        $pdf->SetFont('Times','',14);
        $pdf->Cell(10,8, "",0,0,'L');
        $pdf->Cell(255,8, "Date of Training : 10.09.2025",0,0,'R');
        $pdf->Cell(10,8, "",0,1,'L');

        $pdf->Cell(10,8, "",0,0,'L');
        $pdf->Cell(255,8, "Valid Until : 09.09.2026",0,0,'R');
        $pdf->Cell(10,8, "",0,1,'L');
        
        $pdf->SetFont('Times','',14);
        $pdf->Cell(10,20, "",0,0,'L');
        $pdf->Cell(255,20, "Trainer : _______________________   Authorized Signatory : _______________________",0,0,'C');
        $pdf->Cell(10,20, "",0,1,'L');

        $pdf->setXY(240,85);
        $pdf->Cell(35,40, "",1,1,'L');
        $pdf->Image(public_path('/storage/trainee_photos/place_holder.jpg'), 241, 86, 33);


        // Download as PDF
        return response($pdf->Output('S'))
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', 'inline; filename="Certificate_'.$record->id.'.pdf"');
    }
}
