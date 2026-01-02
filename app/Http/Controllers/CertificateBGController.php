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

class CertificateBGController extends Controller
{
    //
    // Certificate PDF V2.2
    // Sign : Yes
    // Stamp : Yes
    // QR : No
    // BG : Yes
    public function certificatePDF_V_2_1($id){
        $record = Certificate::findOrFail($id);

        // Import FPDF (absolute path from vendor)
        require_once base_path('vendor/setasign/fpdf/fpdf.php');

        $pdf = new FPDF();
        $pdf->AliasNbPages();
        $pdf->SetMargins(10, 10);
        $pdf->SetAutoPageBreak(true, 30);

        $pdf->AddPage('L');
        $pdf->Image(public_path('assets/images/digital/certificate_bg_v2_print.jpg'), 0,0, 297, 210);
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

        // Download as PDF
        return response($pdf->Output('S'))
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', 'inline; filename="Certificate_'.$record->id.'.pdf"');
    }

    
}
