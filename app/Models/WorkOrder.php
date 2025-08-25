<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Training;
use App\Models\User;

class WorkOrder extends Model
{
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
}
