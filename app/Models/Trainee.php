<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Company;
use App\Models\Training;
use App\Models\TrainingRequest;
use App\Models\TraineeRequest;

class Trainee extends Model
{
    //

    protected $fillable = [
        'trainee_request_id',
        'candidate_name_in_certificate',
        'company_name_in_certificate',
        'course_name_in_certificate',
        'date',
        'eid_no',
        'live_photo',
        'certificate_status',
        'id_card_status',
        'training_status'
    ];

    public function training(){
        return $this->belongsTo(Training::class);
    }

    public function trainingRequest(){
        return $this->belongsTo(TrainingRequest::class);
    }
    public function traineeRequest(){
        return $this->belongsTo(TraineeRequest::class);
    }
}
