<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkOrder;
use App\Models\JobRequest;
use App\Models\Company;
use App\Models\User;
use App\Models\TrainingCourse;
use App\Models\Training;
use Carbon\Carbon;
use FPDF;
use Auth;
use Redirect;
use Str;

class JobController extends Controller
{
    public function index(Request $request){
        if (isset($request->search)) {
            $data['search'] = $request->search;
            $data['jobs'] = WorkOrder::where('company_name_in_work_order','LIKE',"%{$request->search}%")->orWhere('id','LIKE',"%{$request->search}%")->orderBy('id','desc')->paginate(1000);
        }
        else{
            $data['jobs'] = WorkOrder::orderBy('id','desc')->paginate(10);
        }
        return view('job.index')->with($data);
    }

    public function new_requests(){
        $data['next_job_no'] = WorkOrder::max('id') + 1;
        $data['job_requests'] = JobRequest::where('request_status','Requested')->get()->reverse();
        $data['users'] = User::all();
        return view('job.new_req')->with($data);
    }

    public function store(Request $request){

        $user_id = Auth::user()->id;
        $request->validate([
            'date'=>'required',
            'company_id'=>'required',
            'authorized_user_id'=>'required',
            'sales_user_id'=>'required'
        ]);

        $company_id = Company::findOrFail($request->company_id)->id;
        $authorized_user_id = User::findOrFail($request->authorized_user_id)->id;
        $sales_user_id = User::findOrFail($request->sales_user_id)->id;

        $job = New WorkOrder;
        $job->date = $request->date;
        $job->company_id = $company_id;
        $job->issued_by = $user_id;
        $job->authorized_by = $authorized_user_id;
        $job->sales_by = $sales_user_id;
        if($request->training_mode){
            $job->training_mode = $request->training_mode;
        }
        
        $job->save();

        return Redirect::back();
    }

    public function show($job){
        $data["job"] = WorkOrder::findOrFail($job);
        $data["courses"] = TrainingCourse::all();
        return view('job.view')->with($data);
    }

    public function edit($job){
    
    }

    public function workOrderPDF($id){
        // Import FPDF (absolute path from vendor)
        require_once base_path('vendor/setasign/fpdf/fpdf.php');

        $job = WorkOrder::with('trainings.course')->findOrFail($id);

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
        $pdf->Cell(180,10,strtoupper("Training Work Permit"),1,1,'C');

        // Job No & Date
        $pdf->SetFont('Times','',14);
        $pdf->SetFillColor(230,230,255);
        $pdf->Cell(20,10,"Job No:",1,0,'C',1);

        $pdf->SetFont('Times','B',14);
        $pdf->Cell(70,10,"AITS-".$job->id,1,0,'C');

        $pdf->SetFont('Times','',14);
        $pdf->SetFillColor(230,230,255);
        $pdf->Cell(20,10,"Date:",1,0,'C',1);

        // Date formating
        $date = Carbon::parse($job->date);
        $formattedDate = strtoupper($date->format('d F Y')); // 20 AUGUST 2025

        $pdf->SetFont('Times','B',14);
        $pdf->Cell(70,10,$formattedDate,1,1,'C');

        // Company Name
        // $pdf->SetFont('Times','',14);
        // $pdf->SetFillColor(230,230,255);
        // $pdf->Cell(60,20,"Client / Company Name :",1,0,'C',1);

        
        // $height = 20;
        // if(strlen($job->company_name_in_work_order)>50){
        //     $height = 10;
        // }
        // $pdf->SetFont('Times','B',14);
        // $pdf->MultiCell(120,$height,$job->company_name_in_work_order,1,'C',0);


        // Company Name label
        $pdf->SetFont('Times','',14);
        $pdf->SetFillColor(230,230,255);
        $pdf->Cell(60,20,"Client / Company Name :",1,0,'C',1);

        // Prepare company name text
        $companyName = trim($job->company_name_in_work_order);

        // Split into two lines of max 33 characters each
        $line1 = mb_substr($companyName, 0, 33);
        $line2 = mb_substr($companyName, 33, 33);

        // Trim any extra text beyond 66 chars
        $line2 = mb_substr($line2, 0, 33);

        $pdf->SetFont('Times','B',14);

        // First line cell (height = 10)
        $pdf->Cell(120,10,$line1, 'LTR', 2, 'C', 0);

        // Second line cell (height = 10)
        $pdf->Cell(120,10,$line2, 'LBR', 1, 'C', 0);

        // Contact Person & Contact No
        $pdf->SetFont('Times','',14);
        $pdf->SetFillColor(230,230,255);
        $pdf->Cell(40,10,"Contact Person:",1,0,'C',1);

        $pdf->SetFont('Times','B',14);
        $pdf->Cell(60,10,$job->company->contact_person,1,0,'C');

        $pdf->SetFont('Times','',14);
        $pdf->SetFillColor(230,230,255);
        $pdf->Cell(30,10,"Contact No.:",1,0,'C',1);

        $pdf->SetFont('Times','B',14);
        $pdf->Cell(50,10,$job->company->contact_no,1,1,'C');


        // Contact Person & Contact No
        $pdf->SetFont('Times','',14);
        $pdf->SetFillColor(230,230,255);
        $pdf->Cell(30,10,"Issued By:",1,0,'C',1);

        $pdf->SetFont('Times','B',14);
        $pdf->Cell(60,10,$job->issued->name,1,0,'C');

        $pdf->SetFont('Times','',14);
        $pdf->SetFillColor(230,230,255);
        $pdf->Cell(35,10,"Authorization:",1,0,'C',1);

        $pdf->SetFont('Times','B',14);
        $pdf->Cell(55,10,$job->authorized->name,1,1,'C');

        // Training Mode
        $pdf->SetFont('Times','',14);
        $pdf->SetFillColor(230,230,255);
        $pdf->Cell(35,10,"Training Mode:",1,0,'C',1);

        $pdf->SetFont('Times','B',14);
        $pdf->Cell(145,10,$job->training_mode,1,1,'L');

        // Space
        $pdf->SetFillColor(200,200,200);
        $pdf->Cell(180,3,"",1,1,'C',1);


        // Table header
        $pdf->SetFillColor(20,20,60);
        $pdf->SetTextColor(255,255,255);

        $pdf->SetFont('Times','B',14);
        $pdf->Cell(15,10,'S. No',1,0,'C',1);
        $pdf->Cell(110,10,'Training Course',1,0,'C',1);
        $pdf->Cell(15,10,'Qty',1,0,'C',1);
        $pdf->Cell(40,10,'Scheduled Date',1,1,'C',1);

        // Table rows
        $pdf->SetTextColor(0,0,0);
        $counter = 1;
        $pdf->SetFont('Times','',14);

        foreach($job->trainings as $training){
            $pdf->Cell(15,11, $counter,1,0,'C',0);
            $pdf->SetFont('Times','',12);
            $pdf->Cell(110,11,$training->course->name,1);
            $pdf->SetFont('Times','',14);
            $pdf->Cell(15,11,$training->quantity,1,0,'C');
            $pdf->Cell(40,11,$training->scheduled_date,1,1,'C');
            $counter++;
        }

        while($counter<=10){
            $pdf->Cell(15,11, $counter,1,0,'C',0);
            $pdf->Cell(110,11,'',1);
            $pdf->Cell(15,11,'',1,0,'C');
            $pdf->Cell(40,11,'',1);
            $counter++;
            $pdf->Ln();
        }

        $pdf->SetFont('Times','B',14);
        $pdf->Cell(125,10,"Total",1,0,'C',0);
        $pdf->Cell(15,10,$job->trainings->sum('quantity'),1,0,'C',0);
        $pdf->Cell(40,10,'',1,1);

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

    public function updateStatus(Request $request){
        $request->validate([
            'work_order_id'       => 'required|exists:work_orders,id',
            'training_status'     => 'required|in:Waiting,On Going,Completed',
            'certificate_status'  => 'required|in:Waiting,On Going,Completed',
        ]);

        $workOrder = WorkOrder::findOrFail($request->work_order_id);
        $workOrder->training_status    = $request->training_status;
        $workOrder->certificate_status    = $request->certificate_status;
        $workOrder->save();

        return redirect()->back()->with('success', 'Work order status updated successfully.');
    }

    public function index_acc(Request $request){
        if (isset($request->search)) {
            $data['search'] = $request->search;
            $data['jobs'] = WorkOrder::where('company_name_in_work_order','LIKE',"%{$request->search}%")->orWhere('id','LIKE',"%{$request->search}%")->orderBy('id','desc')->paginate(1000);
        }
        else{
            $data['jobs'] = WorkOrder::orderBy('id','desc')->paginate(10);
        }
        return view('job_acc.index')->with($data);
    }

    public function change_status_acc(Request $request){
        $request->validate([
            'work_order_id'        => 'required|exists:work_orders,id',
            'invoice_status'       => 'required|string',
            'delivery_note_status' => 'required|string',
            'invoice_no'           => 'nullable|string|max:255',
            'invoice_date'         => 'nullable|date',
            'invoice_amount'       => 'nullable|numeric',
            'invoice_due_date'     => 'nullable|date',
            'payment_status'       => 'required|string',
            'delivery_note_no'     => 'nullable|string|max:255',
        ]);

        $workOrder = WorkOrder::findOrFail($request->work_order_id);

        $workOrder->update([
            'invoice_status'       => $request->invoice_status,
            'delivery_note_status' => $request->delivery_note_status,
            'invoice_no'           => $request->invoice_no,
            'invoice_date'         => $request->invoice_date,
            'invoice_amount'       => $request->invoice_amount,
            'invoice_due_date'     => $request->invoice_due_date,
            'payment_status'       => $request->payment_status,
            'delivery_note_no'     => $request->delivery_note_no,
        ]);

        return redirect()->back()->with('success', 'Work order status updated successfully.');
    }

    public function updateJobStatus(Request $request){
        $request->validate([
            'job_id' => 'required|exists:work_orders,id',
            'status' => 'required|in:Open,Closed,Cancelled,On Hold',
        ]);

        $job = WorkOrder::findOrFail($request->job_id);
        $job->status = $request->status;
        $job->save();

        return redirect()->back()->with('success', 'Job status updated successfully.');
    }

    public function uploadFile(Request $request)
{
    // ---------------------------------------------------------
    // 1. VALIDATE REQUEST
    // ---------------------------------------------------------
    $validated = $request->validate([
        'file'          => 'required|file|max:10240', // 10MB
        'description'   => 'nullable|string|max:255',
        'document_type' => 'required|string|in:Invoice,Delivery Note,Certificates & Ids,Training Feedback,Other',
        'fileable_id'   => 'required|integer|exists:work_orders,id',
    ]);

    // ---------------------------------------------------------
    // 2. RETRIEVE WORKORDER
    // ---------------------------------------------------------
    $workOrder = WorkOrder::findOrFail($validated['fileable_id']);

    // ---------------------------------------------------------
    // 3. PROCESS FILE
    // ---------------------------------------------------------
    $file = $validated['file'];
    $systemName = Str::uuid() . '.' . $file->getClientOriginalExtension();

    // store file
    $path = $file->storeAs(
        'uploads/workorders/' . $workOrder->id,
        $systemName,
        'public'
    );

    // ---------------------------------------------------------
    // 4. SAVE FILE RECORD (POLYMORPHIC)
    // ---------------------------------------------------------
    $workOrder->files()->create([
        'fileable_id'   => $workOrder->id,
        'fileable_type' => App\Models\WorkOrder::class, // set programmatically

        'name'           => $systemName,
        'original_name'  => $file->getClientOriginalName(),
        'description'    => $validated['description'] ?? null,
        'document_type'  => $validated['document_type'],
        'path'           => $path,
        'mime_type'      => $file->getClientMimeType(),
        'size'           => $file->getSize(),
        'storage_disk'   => 'public',
        'hash'           => hash_file('sha256', $file->getRealPath()),
        'uploaded_by'    => auth()->id(),
        'archived_at'    => null,
        'archived_by'    => null,
    ]);

    // ---------------------------------------------------------
    // 5. DONE
    // ---------------------------------------------------------
    return back()->with('success', 'File uploaded successfully.');
}


}