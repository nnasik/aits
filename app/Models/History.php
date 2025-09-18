<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model{
    protected $fillable = [
        'subject_id',
        'subject_type',
        'user_id',
        'event',
        'changes',
    ];

    protected $casts = [
        'changes' => 'array',
    ];

    public function subject(){
        return $this->morphTo();
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
