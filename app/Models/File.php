<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'work_order_id',
        'name',
        'original_name',
        'description',
        'document_type',
        'path',
        'mime_type',
        'size',
        'storage_disk',
        'uploaded_by',
        'archived_at',
        'archived_by',
        'hash',
    ];

    public function workOrder()
    {
        return $this->belongsTo(WorkOrder::class);
    }
}
