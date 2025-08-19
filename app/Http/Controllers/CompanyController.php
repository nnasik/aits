<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use Redirect;

class CompanyController extends Controller
{
    //
    public function index(){
        $data['companies'] = Company::all();
        return view('company.index')->with($data);
    }

    public function store(Request $request){
        $request->validate([
            'name'=>'required'
        ]);

        $company = New Company;
        $company->name = $request->name;
        $company->save();

        return Redirect::back();
    }
}