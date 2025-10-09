<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TrainingRequest;

class TraineeRequest extends Model
{
    //
    protected $fillable = [
        'trainee_name',
        'eid_no',
        'profile_pic',
        'is_certificate_hard_copy_needed',
        'is_id_card_needed',
        'eid_front_pic',
        'eid_back_pic',
        'visa_pic',
        'passport_pic',
        'dl_pic',
        'company_name_in_certificate',
        'course_title_in_certificate',
        'certificate_date',
    ];

    
    public function trainingRequest(){
        return $this->belongsTo(TrainingRequest::class);
    }
}
