<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkOrder;
use App\Models\Company;
use App\Models\User;
use Auth;
use Redirect;

class JobsController extends Controller
{
    public function index(){
        $data['jobs'] = WorkOrder::latest()->take(10)->get();
        $data['companies'] = Company::all();
        $data['users'] = User::all();
        return view('job.index')->with($data);
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
        $job->save();

        return Redirect::back();
    }
}
