<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model{
    //
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'document_type',
        'path',
    ];

    public function fileable(){
        return $this->morphTo();
    }
}
