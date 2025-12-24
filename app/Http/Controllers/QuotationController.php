<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quotation;
use App\Models\Company;
use App\Models\TrainingCourse;
use App\Models\Document;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
use Auth;

class QuotationController extends Controller{
    //
    public function index(){
        $user_id = Auth::user()->id;
        $data['quotations'] = Quotation::where('prepared_by',$user_id)->get()->reverse();
        
        $maxRef = Quotation::max('reference');
        $data['next_quotation_ref'] = $maxRef ? $maxRef + 1 : 100001;
        
        $data['companies'] = Company::all();
        $data['terms'] = [];

        //dd($data);
        return view('quotations.index')->with($data);
    }

    public function store(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'reference' => 'required|string|max:255',
            'revision' => 'required|integer',
            'date' => 'required|date',
            'valid_until' => 'required|date',
            'company_id' => 'required|integer|exists:companies,id',
            'company_name' => 'nullable|string|max:255',
            'company_phone' => 'nullable|string|max:50',
            'company_email' => 'nullable|email|max:255',
            'company_address' => 'nullable|string|max:1000',
            'quote_for' => 'nullable|string|max:255',
            'prepared_by_name' => 'nullable|string|max:255',
            'prepared_by_email' => 'nullable|email|max:255',
            'prepared_by_contact' => 'nullable|string|max:50',
            'note' => 'nullable|string|max:1000',
            'terms_and_conditions_id' => 'nullable|integer|exists:documents,id',
        ]);

        // Store in database
        $quotation = Quotation::create($validated);
        $quotation->prepared_by = Auth::user()->id;
        $quotation->save();
        
        return redirect()->back()->with('success', 'Quotation created successfully!');
    }

    public function show($id){
            $data['quotation'] = Quotation::with('rows')->findOrFail($id);
            $data['trainings'] = TrainingCourse::all();
            $data['TnCs'] = Document::all();
            return view('quotations.view')->with($data);
        }

        public function storeRow(Request $request){

            $request->validate([
                'quotation_id' => 'required|exists:quotations,id',
                'training_course_id.*' => 'required|exists:training_courses,id',
                'training_name.*' => 'required|string',
                'duration.*' => 'required|string',
                'delivery_mode.*' => 'required|string',
                'qty.*' => 'required|numeric|min:1',
                'unit_price.*' => 'required|numeric|min:0',
                'discount.*' => 'nullable|numeric|min:0',
                'total.*' => 'required|numeric|min:0',
                'overall_discount' => 'nullable|numeric|min:0',
            ]);

        $quotation = Quotation::findOrFail($request->quotation_id);

        if ($quotation->status!='Draft') {
            return redirect()->back();
        }

        // --- Delete all previous rows ---
        $quotation->rows()->delete();

        $count = count($request->training_course_id);
        $subTotal = 0;

        for ($i = 0; $i < $count; $i++) {
            $discount = $request->discount[$i] ?? 0;
            $total = ($request->qty[$i] * $request->unit_price[$i]) - $discount;

            $quotation->rows()->create([
                'training_course_id' => $request->training_course_id[$i],
                'training_name' => $request->training_name[$i],
                'duration' => $request->duration[$i],
                'delivery_mode' => $request->delivery_mode[$i],
                'qty' => $request->qty[$i],
                'unit_price' => $request->unit_price[$i],
                'discount' => $discount,
                'total' => $total,
            ]);

            $subTotal += $total;
        }

        // Get overall discount from user input
        $overallDiscount = $request->overall_discount ?? 0;
        $vat = ($subTotal - $overallDiscount) * 0.05;
        $grandTotal = ($subTotal - $overallDiscount) + $vat;

        $quotation->update([
            'sub_total' => $subTotal,
            'discount' => $overallDiscount,
            'vat' => $vat,
            'grand_total' => $grandTotal,
        ]);

        return redirect()->route('quotation.show', $quotation->id)
                        ->with('success', 'Quotation saved successfully.');
    }

    public function finalize(Request $request){
        $request->validate([
            'quotation_id' => 'required|exists:quotations,id',
            'tnc_id' => 'required|exists:documents,id',
        ]);

        $quotation = Quotation::findOrFail($request->quotation_id);
        $quotation->terms_and_conditions_id = $request->tnc_id;
        $quotation->status = 'finalized';
        $quotation->save();

        return redirect()->back()->with('success', 'Quotation finalized successfully.');
    }

    // public function generatePdf($id){
    //     $quotation = Quotation::with([
    //         'rows',
    //         'company',
    //         'prepared_by',
    //         'terms_and_conditions'
    //     ])->findOrFail($id);

    //     $fileName = 'Quotation ' . $quotation->reference . '-R' . str_pad($quotation->revision, 2, '0', STR_PAD_LEFT) . '.pdf';

    //     $pdf = Pdf::loadView('quotations.templates.00', [
    //         'quotation' => $quotation
    //     ])->setPaper('a4', 'portrait');

    //     // Stream inline with filename
    //     return $pdf->stream($fileName, ['Attachment' => false]);
    // }

    public function generatePdf($id){
    $quotation = Quotation::with([
        'rows',
        'company',
        'prepared_by',
        'terms_and_conditions'
    ])->findOrFail($id);

    $fileName = 'Quotation ' . $quotation->reference . '-R' . str_pad($quotation->revision, 2, '0', STR_PAD_LEFT) . '.pdf';

    $pdf = Pdf::loadView('quotations.templates.00', [
        'quotation' => $quotation
    ])->setPaper('a4', 'portrait');

    // Render first (required)
    $pdf->render();

    $dompdf = $pdf->getDomPDF();
    $canvas = $dompdf->getCanvas();

    // Use a UTF-8 font (DejaVu Sans) for page numbers
    $font = $dompdf->getFontMetrics()->getFont('Arial', 'normal');

    // Add page numbers at bottom right
    $canvas->page_text(
        520, // x position (adjust based on page width)
        805, // y position (adjust based on footer)
        "Page {PAGE_NUM} of {PAGE_COUNT}",
        $font,
        8,             // font size
        [0, 0, 0]       // black color
    );

    return $pdf->stream($fileName, ['Attachment' => false]);
}


}