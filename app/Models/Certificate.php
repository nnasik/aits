<?php

namespace App\Models;
use App\Models\Trainee;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    //

    protected $fillable = [
        'id',
        'job_id',
        'trainee_id',
        'candidate_name_in_certificate',
        'company_name_in_certificate',
        'company_location',
        'course_name_in_certificate',
        'text_1',
        'text_2',
        'text_3',
        'eid_no',
        'passport_no',
        'date',
        'valid_unit',
        'live_photo',
        'hash'
    ];

    public function trainee(){
        return $this->belongsTo(Trainee::class);
    }

}
