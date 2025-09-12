<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\WorkOrder;
use App\Models\Company;
use App\Models\TrainingCourse;

class Training extends Model
{
    protected $fillable=[
        'work_order_id',
        'training_course_id',
        'quantity',
        'scheduled_date',
        'scheduled_time',
        'training_mode',
        'training_link',
        'remarks',
        'hash'
    ];

    public function workOrder(){
        return $this->belongsTo(WorkOrder::class,'work_order_id');
    }

    public function course(){
        return $this->belongsTo(TrainingCourse::class,'training_course_id');
    }

     public function trainees(){
        return $this->belongsToMany(Trainee::class, 'training_trainee','training_id', 'trainee_id')
                ->withPivot(['id', 'photo', 'signature']) // include extra pivot columns
                ->withTimestamps();
    }

    public function job(){
         return $this->belongsTo(WorkOrder::class,'work_order_id');
    }
}
