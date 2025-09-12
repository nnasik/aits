<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingTrainee extends Model
{
    protected $table = 'training_trainee';

    protected $fillable = [
        'training_id',
        'trainee_id',
        'signature'
        // add extra pivot fields if exist
    ];

    public function training(){
        return $this->belongsTo(Training::class);
    }

    public function trainee(){
        return $this->belongsTo(Trainee::class);
    }
}
