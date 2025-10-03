<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\WorkOrder;
use App\Models\Company;
use App\Models\TrainingCourse;

class Training extends Model
{
    protected $fillable=[
        'training_course_id',
        'course_title_in_certificate',
        'company_name_in_certificate',
        'hash',
        'quantity',
        'training_mode',
        'scheduled_date',
        'scheduled_time',
        'is_zoom_link_required',
        'remarks',
        'status'
    ];

    public function workOrder(){
        return $this->belongsTo(WorkOrder::class,'work_order_id');
    }

    public function course(){
        return $this->belongsTo(TrainingCourse::class,'training_course_id');
    }

    public function trainees(){
        return $this->hasMany(Trainee::class);
    }

    public function job(){
         return $this->belongsTo(WorkOrder::class,'work_order_id');
    }
}
