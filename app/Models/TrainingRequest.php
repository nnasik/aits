<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\JobRequest;
use App\Models\TrainingCourse;
use App\Models\TraineeRequest;

class TrainingRequest extends Model{
    protected $fillable = [
        'job_request_id',
        'training_course_id',
        'course_title_in_certificate',
        'company_name_in_certificate',
        'quantity',
        'training_mode',
        'requesting_date',
        'requesting_time',
        'is_zoom_link_required',
        'zoom_link',
        'remarks',
        'user_id',
        'status',
    ];

    public function job_request(){
        return $this->belongsTo(JobRequest::class);
    }

    public function trainee_requests(){
        return $this->hasMany(TraineeRequest::class,'training_request_id');
    }

    public function course(){
        return $this->belongsTo(TrainingCourse::class,'training_course_id');
    }

    public function histories(){
        return $this->morphMany(History::class, 'subject');
    }

    public function requested_by(){
        return $this->belongsTo(User::class, 'user_id');
    }

}
