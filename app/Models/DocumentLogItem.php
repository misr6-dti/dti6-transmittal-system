<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentLogItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_log_id',
        'quantity',
        'unit',
        'description',
        'remarks',
    ];

    public function documentLog()
    {
        return $this->belongsTo(DocumentLog::class);
    }
}
