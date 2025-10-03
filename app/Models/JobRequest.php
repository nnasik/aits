<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Company;
use App\Models\User;
use App\Models\TrainingRequest;

class JobRequest extends Model{
    //
    protected $fillable = [
        'priority',
        'company_id',
        'company_name_in_work_order',
        'training_mode',
        'is_zoom_link_required',
        'requested_on',
        'request_by',
        'accepted_on',
        'accepted_by',
        'request_status',
        'certificate_status',
        'invoice_status',
        'delivery_note_status'
    ];

    public function company(){
        return $this->belongsTo(Company::class,'company_id');
    }

    public function requester(){
        return $this->belongsTo(User::class,'request_by');
    }

    public function accepted(){
        return $this->belongsTo(User::class,'accepted_by');
    }

    public function training_requests(){
        return $this->hasMany(TrainingRequest::class, 'job_request_id', 'id');
    }

    public function job(){
        return $this->hasOne(WorkOrder::class,'job_request_id');
    }

    public function histories(){
        return $this->morphMany(History::class, 'subject');
    }
}
