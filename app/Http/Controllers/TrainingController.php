<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Training;
use App\Services\ZoomService;

class TrainingController extends Controller
{
    // 
    public function store(Request $request){

        $validated = $request->validate([
            'work_order_id'   => 'required|exists:work_orders,id',
            'course_id'       => 'required|exists:training_courses,id',
            'qty'             => 'required|integer|min:1',
            'scheduled_date'  => 'nullable|date',
            'training_mode'   => 'nullable|string|max:255',
            'scheduled_time'  => 'nullable|date_format:H:i',
            'remark'          => 'nullable|string|max:255',
        ]);

        $training = new Training([
            'work_order_id'      => $validated['work_order_id'],
            'training_course_id' => $validated['course_id'],
            'quantity'           => $validated['qty'],
            'scheduled_date'     => $validated['scheduled_date'] ?? null,
            'training_mode'     => $validated['training_mode'] ?? null,
            'scheduled_time'     => $validated['scheduled_time'] ?? null,
            'remarks'            => $validated['remark'] ?? null,
        ]);

        if($validated['scheduled_date'] && $validated['scheduled_time']){
            $training->status = 'Scheduled';
        }

        $training->save();

        if($request->zoom==True && $request->training_mode=='Online'){
            $zoom = app(\App\Services\ZoomService::class);

            $startTime = date('c', strtotime($request->scheduled_date . ' ' . $request->scheduled_time));

            $meeting = $zoom->createMeeting(
                $training->course->name . ' Training',
                $startTime,
                60
            );
            
            $training->training_link = $meeting['join_url'];
            $training->save();
            return redirect()->back()->with('error', 'Failed to create Zoom meeting: ' . json_encode($meeting));
    
        }
        
        return back()->with('success', 'Training added successfully.');
    }

    public function destroy(Training $training){
        $training->delete();
        return redirect()->back()->with('success', 'Training deleted successfully.');
    }

    public function show($id){
       
    }

    public function attendancePDF($id){
        // Import FPDF (absolute path from vendor)
        require_once base_path('vendor/setasign/fpdf/fpdf.php');

        $training = Training::findOrFail($id);

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetMargins(20,10);
        // Some space
        $pdf->Ln(0);
        $logo = $pdf->Image(public_path('assets/images/logo.png'), 20, 10, 32);

        $pdf->SetFont('Times','B',15);

        $pdf->Cell(30,20,"",1,0);
        $pdf->Cell(150,20, strtoupper("American International Training Services LLC"),1,1,'C');
        $pdf->SetFont('Times','',14);
        $pdf->Cell(40,-8,"",0,0);
        $pdf->Cell(150,-8,'Abu Dhabi, United Arab Emirates',0,1,'C');

        // Some space
        $pdf->Ln(8);


        $pdf->SetFont('Times','B',16);
        $pdf->Cell(180,10,strtoupper("Training Attendance Sheet"),1,1,'C');

        // Job No & Date
        $pdf->SetFont('Times','',14);
        $pdf->SetFillColor(230,230,255);
        $pdf->Cell(20,10,"Job No:",1,0,'C',1);

        $pdf->SetFont('Times','B',14);
        $pdf->Cell(70,10,"AITS-",1,0,'C');

        $pdf->SetFont('Times','',14);
        $pdf->SetFillColor(230,230,255);
        $pdf->Cell(20,10,"Date:",1,0,'C',1);

        // Date formating
        // $date = Carbon::parse($job->date);
        // $formattedDate = strtoupper($date->format('d F Y')); // 20 AUGUST 2025

        // $pdf->SetFont('Times','B',14);
        // $pdf->Cell(70,10,$formattedDate,1,1,'C');

        // // Company Name
        // $pdf->SetFont('Times','',14);
        // $pdf->SetFillColor(230,230,255);
        // $pdf->Cell(60,20,"Client / Company Name :",1,0,'C',1);

        
        // $height = 20;
        // if(strlen($job->company->name)>50){
        //     $height = 10;
        // }
        // $pdf->SetFont('Times','B',14);
        // $pdf->MultiCell(120,$height,$job->company->name,1,'C',0);

        // // Contact Person & Contact No
        // $pdf->SetFont('Times','',14);
        // $pdf->SetFillColor(230,230,255);
        // $pdf->Cell(40,10,"Contact Person:",1,0,'C',1);

        // $pdf->SetFont('Times','B',14);
        // $pdf->Cell(60,10,$job->company->contact_person,1,0,'C');

        // $pdf->SetFont('Times','',14);
        // $pdf->SetFillColor(230,230,255);
        // $pdf->Cell(30,10,"Contact No.:",1,0,'C',1);

        // $pdf->SetFont('Times','B',14);
        // $pdf->Cell(50,10,$job->company->contact_no,1,1,'C');


        // // Contact Person & Contact No
        // $pdf->SetFont('Times','',14);
        // $pdf->SetFillColor(230,230,255);
        // $pdf->Cell(30,10,"Issued By:",1,0,'C',1);

        // $pdf->SetFont('Times','B',14);
        // $pdf->Cell(60,10,$job->issued->name,1,0,'C');

        // $pdf->SetFont('Times','',14);
        // $pdf->SetFillColor(230,230,255);
        // $pdf->Cell(35,10,"Authorization:",1,0,'C',1);

        // $pdf->SetFont('Times','B',14);
        // $pdf->Cell(55,10,$job->authorized->name,1,1,'C');

        // // Training Mode
        // $pdf->SetFont('Times','',14);
        // $pdf->SetFillColor(230,230,255);
        // $pdf->Cell(35,10,"Training Mode:",1,0,'C',1);

        // $pdf->SetFont('Times','B',14);
        // $pdf->Cell(145,10,$job->training_mode,1,1,'L');

        // // Space
        // $pdf->SetFillColor(200,200,200);
        // $pdf->Cell(180,3,"",1,1,'C',1);


        // // Table header
        // $pdf->SetFillColor(20,20,60);
        // $pdf->SetTextColor(255,255,255);

        // $pdf->SetFont('Times','B',14);
        // $pdf->Cell(20,10,'Item No',1,0,'C',1);
        // $pdf->Cell(90,10,'Training Course',1,0,'C',1);
        // $pdf->Cell(20,10,'Qty',1,0,'C',1);
        // $pdf->Cell(50,10,'Scheduled Date',1,1,'C',1);

        // Table rows
        $pdf->SetTextColor(0,0,0);
        $counter = 1;
        $pdf->SetFont('Times','',14);

        foreach($job->trainings as $training){
            $pdf->Cell(20,11, $counter,1,0,'C',0);
            $pdf->Cell(90,11,$training->course->name,1);
            $pdf->Cell(20,11,$training->quantity,1,0,'C');
            $pdf->Cell(50,11,$training->scheduled_date,1,1,'C');
            $counter++;
        }

        while($counter<=10){
            $pdf->Cell(20,11, $counter,1,0,'C',0);
            $pdf->Cell(90,11,'',1);
            $pdf->Cell(20,11,'',1,0,'C');
            $pdf->Cell(50,11,'',1);
            $counter++;
            $pdf->Ln();
        }

        $pdf->SetFont('Times','B',14);
        $pdf->Cell(110,10,"Total",1,0,'C',0);
        $pdf->Cell(20,10,$job->trainings->sum('quantity'),1,0,'C',0);
        $pdf->Cell(50,10,'',1,1);

        // --- Draw footer manually ---

        $pdf->SetY(235);
        $pdf->SetFont('Times','',14);
        $pdf->SetFillColor(230,230,255);
        $pdf->Cell(40,10,"Sales Person :",1,0,'C',1);
        $pdf->SetFont('Times','B',14);
        $pdf->Cell(140,10,$job->sales->name,1,1,'L');
        $pdf->SetFont('Times','',12);
        $pdf->MultiCell(180,5,"\nHead Office : Abu Dhabi, U.A.E\nTel : +971 55 914 7537\nEmail: sales@trainingsinusa.com | Website: www.trainingsinusa.com\n\nDoc. No QF-03/03 (A)           Rev:03          Date:01-01-2025",1,'C');

        //$pdf->Output();

        // Download as PDF
        return response($pdf->Output('S'))
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', 'inline; filename="workpermit_'.$job->id.'.pdf"');
    }
}
