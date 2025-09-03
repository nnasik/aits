<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Company;

class Trainee extends Model
{
    //

    protected $fillable = [
        'company_id',
        'name',
        'eid_no',
        'designation',
        'passport',
        'dob',
        'nationality',
    ];


    public function company(){
        return $this->belongsTo(Company::class,'company_id');
    }
}
