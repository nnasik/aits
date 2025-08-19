<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Model\WorkOrder;
use App\Model\Company;

class WorkOrderRow extends Model
{
    public function workOrder(){
        return $this->belongsTo(WorkOrder::class);
    }

    
}
