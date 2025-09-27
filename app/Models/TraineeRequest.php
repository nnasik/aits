<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TrainingRequest;

class TraineeRequest extends Model
{
    //
    protected $fillable = [
        'company_name_in_certificate',
        'course_title_in_certificate',
        'certificate_date'
    ];

    
    public function trainingRequest(){
        return $this->belongsTo(TrainingRequest::class);
    }
}
