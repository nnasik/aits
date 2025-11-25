<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use User;
use Auth;
use App\Models\WorkOrder;

class ReportController extends Controller
{
    //
    public function index(){

    }

    // All Jobs
    public function jobs_by_sale(){
        $user_id = Auth::user()->id;
        $data['workOrders']=WorkOrder::where('sales_by',$user_id)->get();
        return view('reports.job_sales')->with($data);
    }
}
