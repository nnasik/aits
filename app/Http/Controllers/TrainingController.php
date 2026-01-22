<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Training;
use App\Models\TrainingCourse;
use App\Models\Trainee;
use App\Models\Company;
use App\Models\WorkOrder;
use App\Services\ZoomService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use FPDF;

// Extend FPDF with custom footer
class PDF extends FPDF
{
    function Footer()
    {
        // 15 mm from bottom
        $this->SetY(-15);
        $this->SetFont('Times', 'I', 10);
        // Centered text: width = 0 means full width
        $this->Cell(0, 10, 'Page '.$this->PageNo().' of {nb}', 0, 0, 'C');
    }
}


class TrainingController extends Controller
{

    public function index(){

    }

    public function trainingsWithoutJob(){
        $data['jobs'] = WorkOrder::where('status','open')->get()->reverse();
        $data['trainings'] = Training::where('work_order_id',NULL)->get()->reverse();
        $data['trainingCourses'] = TrainingCourse::where('status','active')->get();
        return view('trainings.withoutjob')->with($data);
    }

    // 
    public function store(Request $request){

        return DB::transaction(function () use ($request) {
        
            $validated = $request->validate([
                'course_id'=> 'required|exists:training_courses,id',
                'work_order_id'=> 'required|exists:work_orders,id',
                'company_name_in_certificate'=> 'required',
                'qty'             => 'required|integer|min:1',
                'scheduled_date'  => 'nullable|date',
                'training_mode'   => 'nullable|string|max:255',
                'course_title_in_certificate'   => 'required|string|max:255',
                'scheduled_time'  => 'nullable|date_format:H:i',
                'remarks'          => 'nullable|string|max:255',
            ]);

            $work_oder = WorkOrder::findOrFail($validated['work_order_id']);

            $training = new Training([
                'work_order_id' => $validated['work_order_id'],
                'training_course_id' => $validated['course_id'],
                'course_title_in_certificate' => $validated['course_title_in_certificate'],
                'company_name_in_certificate' => $validated['company_name_in_certificate'],
                'quantity'           => $validated['qty'],
                'scheduled_date'     => $validated['scheduled_date'] ?? null,
                'training_mode'      => $validated['training_mode'] ?? null,
                'scheduled_time'     => $validated['scheduled_time'] ?? null,
                'remarks'            => $validated['remarks'] ?? null,
                'hash'               => Str::uuid()->toString(),
            ]);

            if($validated['scheduled_date'] && $validated['scheduled_time']){
                $training->status = 'Scheduled';
            }

            $training->save();

            for ($i=0; $i < $training->quantity; $i++) { 
                $training->trainees()->create([
                    'company_name_in_certificate' => $training->company_name_in_certificate,
                    'course_name_in_certificate' => $training->course_title_in_certificate,
                    'date' => $training->scheduled_date,
                ]);
            }

            return back()->with('success', 'Training added successfully.');
        });
    }

    public function linkJob(Request $request){
        // Validate input
        $request->validate([
            'job_id' => 'required|exists:work_orders,id',
            'training_id' => 'required', // assuming this carries the training ID
        ]);

        // Get values
        $jobId = $request->input('job_id');
        $trainingId = $request->input('training_id');

        // Update the training with the selected job
        $training = Training::findOrFail($trainingId);
        if (!$training) {
            return back()->with('error', 'Training not found.');
        }

        $training->work_order_id = $jobId;
        $training->save();

        return back()->with('success', 'Training linked to job successfully.');
    }

    public function destroy(Training $training){
        $training->delete();
        return redirect()->back()->with('success', 'Training deleted successfully.');
    }

    public function unlinkJob(Request $request)
{
        // Validate input
        $request->validate([
            'training_id' => 'required|exists:trainings,id',
        ]);

        // Get value
        $trainingId = $request->input('training_id');

        // Fetch training
        $training = Training::findOrFail($trainingId);

        // Unlink job
        $training->work_order_id = null;
        $training->save();

        return back()->with('success', 'Training unlinked from job successfully.');
    }

    public function show($id){
        $training = Training::findOrFail($id);
        $data['trainees'] = Trainee::all();
        $data['companies'] = Company::all();
        $data['training'] = $training;
        $data['job'] = $training->job;
        return view('job.view_training')->with($data);
    }

    public function addTrainee(Request $request){
        $request->validate([
            'training'   => 'required|exists:trainings,id',
            'trainee_id' => 'required|exists:trainees,id',
        ]);

        $training = Training::findOrFail($request->training);

        // Attach trainee to training (avoid duplicates)
        if (!$training->trainees()->where('trainee_id', $request->trainee_id)->exists()) {
            $training->trainees()->attach($request->trainee_id);
        }

        return redirect()->back()->with('success', 'Trainee added successfully!');
    }


    public function removeTrainee(Request $request){
        $request->validate([
            'training_id' => 'required|exists:trainings,id',
            'trainee_id'  => 'required|exists:trainees,id',
        ]);

        $training=Training::findOrFail($request->training_id);

        // Detach the trainee from this training
        $training->trainees()->detach($request->trainee_id);

        return redirect()->back()->with('success', 'Trainee removed successfully!');
    }

    public function attendancePDF($id){
        // Import FPDF (absolute path from vendor)
        require_once base_path('vendor/setasign/fpdf/fpdf.php');

        $training = Training::findOrFail($id);

        $pdf = new PDF();
        $pdf->AliasNbPages();
        $pdf->SetMargins(20, 10);
        $pdf->SetAutoPageBreak(true, 30);

        $pdf->AddPage();
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
        $pdf->Ln(12);


        $pdf->SetFont('Times','BU',16);
        $pdf->Cell(180,10,strtoupper("Training Attendance Sheet"),0,1,'C');

        // Job No
        $pdf->SetFont('Times','',14);
        $pdf->Cell(20,10,"Job No : ",0,0,'L');
        $pdf->SetFont('Times','B',14);
        $pdf->Cell(100,10,$training->job->id,0,0,'L');

        // Date
        $pdf->SetFont('Times','B',12);
        $pdf->Cell(60,10,"Date : ".$training->scheduled_date,0,1,'R');

        // Some space
        $pdf->Ln(0);
        
        // Course Name
        $pdf->SetFont('Times','',14);
        $pdf->Cell(30,10,"Course Title : ",0,0,'L');
        $pdf->SetFont('Times','B',14);
        $pdf->Cell(150,10,$training->course->name,0,1,'L');

        // Company Name
        $pdf->SetFont('Times','',14);
        $pdf->Cell(40,10,"Company Name : ",0,0,'L');
        $pdf->SetFont('Times','B',14);
        $pdf->Cell(140,10,$training->job->company->name,0,1,'L');

        
        // Table rows
        $pdf->SetTextColor(0,0,0);
        $counter = 1;
        $pdf->SetFont('Times','B',14);

        $pdf->Cell(15,10, 'S.No',1,0,'C',0);
        $pdf->Cell(70,10,'Participant Name',1,0,'C');

        // Save current position
        $x = $pdf->GetX();
        $y = $pdf->GetY();

        $pdf->MultiCell(45,5,'Emirates ID / Passport No',1,'C');

        // Reset position to the right of the multicell
        $pdf->SetXY($x + 45, $y);
        $pdf->Cell(50,10,'Signature',1,0,'C');
        
        $pdf->SetFont('Times','',14);
        $pdf->Ln();
        foreach($training->trainees as $trainee){
            $pdf->Cell(15,15, $counter,1,0,'C');
            $pdf->Cell(70,15,$trainee->candidate_name_in_certificate,1);
            if ($trainee->eid_no) {
                $pdf->Cell(45,15,$trainee->eid_no,1);
            }
            elseif ($trainee->passport) {
                $pdf->Cell(45,15,$trainee->passport,1);
            }
            else{
                $pdf->Cell(45,15,'',1);
            }
            
            $pdf->Cell(50,15,'',1,0);

            // Save current position
            $x = $pdf->GetX();
            $y = $pdf->GetY();

            if ($trainee->signature){
                $pdf->Image(public_path('/storage/'.$trainee->signature), $x-40, $y, 16);
            }
            $counter++;
            $pdf->Ln();
        }

        while($counter<=10){
            $pdf->Cell(15,15, $counter,1,0,'C',0);
            $pdf->Cell(70,15,'',1);
            $pdf->Cell(45,15,'',1,0,'C');
            $pdf->Cell(50,15,'',1);
            $counter++;
            $pdf->Ln();
        }

        // --- Draw footer manually ---

        $pdf->SetY(235);
        $pdf->SetFont('Times','',14);
        //$pdf->Cell(140,10,$job->sales->name,1,1,'L');
        $pdf->SetFont('Times','',12);
        $pdf->MultiCell(180,5,"\nHead Office : Abu Dhabi, U.A.E\nTel : +971 55 914 7537\nEmail: sales@trainingsinusa.com | Website: www.trainingsinusa.com\n\nDoc. No : QF-01               Rev : 01          Date : 01-01-2025",1,'C');

        //$pdf->Output();

        // Download as PDF
        return response($pdf->Output('S'))
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', 'inline; filename="training_attendance_'.$training->id.'.pdf"');
    }

}