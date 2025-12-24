<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Qutotation;
use App\Models\TrainingCourse;


class QuotationRow extends Model
{
    protected $fillable = [
        'quotation_id',   // <-- must be here
        'training_course_id',
        'training_name',
        'duration',
        'delivery_mode',
        'qty',
        'unit_price',
        'discount',
        'total'
    ];
    
    //
    public function quotation(){
        return $this->belongsTo(Qutotation::class);
    }

    public function training_course(){
        return $this->belongsTo(TrainingCourse::class);
    }
}