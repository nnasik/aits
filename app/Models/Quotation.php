<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\QuotationRow;
use App\Models\User;
use App\Models\Company;
use App\Models\Document;

class Quotation extends Model
{
    protected $fillable = [
        'reference',
        'revision',
        'date',
        'valid_until',
        'company_id',
        'company_name',
        'company_phone',
        'company_email',
        'company_address',
        'quote_for',
        'prepared_by_name',
        'prepared_by_email',
        'prepared_by_contact',
        'note',
        'terms_and_conditions_id',
        'sub_total',
        'discount',
        'vat',
        'grand_total'

    ];
    
    //
    public function rows(){
        return $this->hasMany(QuotationRow::class);
    }

    public function prepared_by(){
        return $this->belongsTo(User::class);
    }

    public function company(){
        return $this->belongsTo(Company::class);
    }

    public function terms_and_conditions(){
        return $this->belongsTo(Document::class,'terms_and_conditions_id');
    }
}
