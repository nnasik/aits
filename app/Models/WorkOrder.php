<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Training;
use App\Models\WorkOrder;
use App\Models\User;
use App\Models\JobRequest;

class WorkOrder extends Model{

    protected $fillable=[
        'id',
        'job_request_id',
        'company_name_in_work_order',
        'date',
        'company_id',
        'issued_by',
        'authorized_by',
        'sales_by',
        'training_mode',
        'priority',
        'is_zoom_link_required',
        'status',
        'invoice_status',
        'delivery_note_status',
        'invoice_amount',
        'invoice_no',
        'payment_status',
        'delivery_note_no',
        'invoice_date',
        'invoice_due_date',
    ];
    
    public function trainings(){
        return $this->hasMany(Training::class);
    }

    public function company(){
        return $this->belongsTo(Company::class,'company_id');
    }

    public function issued(){
        return $this->belongsTo(User::class,'issued_by');
    }

    public function authorized(){
        return $this->belongsTo(User::class,'authorized_by');
    }

    public function sales(){
        return $this->belongsTo(User::class,'sales_by');
    }

    public function request(){
        return $this->belongsTo(JobRequest::class,'job_request_id');
    }

    public function files(){
        return $this->morphMany(File::class, 'fileable');
    }
}
