<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\WorkOrderRow;

class WorkOrder extends Model
{
    public function rows(){
        return $this->hasMany(WorkOrderRow::class);
    }

    public function company(){
        return $this->belongsTo(Company::class,'company_id');
    }
}
