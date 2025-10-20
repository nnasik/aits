<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkOrder;
use App\Models\Training;

class DashboardController extends Controller{
    //
    public function index(){
        $data['total_jobs_count']=WorkOrder::all()->count();
        $data['closed_jobs_count']=WorkOrder::where('status','Closed')->count();
        $data['invoice_queue_count']=WorkOrder::where('status','Open')->where('training_status','Completed')->
        where('certificate_status','Completed')->where('invoice_status','Waiting')->count();
        $data['trainings'] = WorkOrder::all()->count();
        $data['unpaid_count'] = WorkOrder::where('status','Closed')->where('invoice_status', 'Completed')->where('payment_status', 'Unpaid')->count();
        $data['unpaid_amount'] = WorkOrder::where('status','Closed')->where('invoice_status', 'Completed')->where('payment_status', 'Unpaid')->sum('invoice_amount');
        return view('dashboard.index')->with($data);
    }
}
