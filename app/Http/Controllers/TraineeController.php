<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trainee;
use App\Models\Company;

class TraineeController extends Controller
{
    public function index(){
        $data['trainees'] = Trainee::all()->reverse();
        $data['companies'] = Company::all();
        return view('trainee.index')->with($data);
    }

    public function store(Request $request){
        // Validation
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'eid' => 'nullable|string|max:50|unique:trainees,eid_no',
            'passport_no' => 'nullable|string|max:50',
            'dob' => 'nullable|date',
            'nationality' => 'nullable|string|max:100',
            'company_id' => 'nullable|exists:companies,id',
            'designation' => 'nullable|string|max:100',
        ]);

        // Create trainee
        Trainee::create([
            'name' => $validated['name'],
            'eid_no' => $validated['eid'] ?? null,
            'passport' => $validated['passport_no'] ?? null,
            'dob' => $validated['dob'] ?? null,
            'nationality' => $validated['nationality'] ?? null,
            'company_id' => $validated['company_id'] ?? null,
            'designation' => $validated['designation'] ?? null,
        ]);

        return redirect()->back()->with('success', 'Trainee created successfully.');
    }

}
