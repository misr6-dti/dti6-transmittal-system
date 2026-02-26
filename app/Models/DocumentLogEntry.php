<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentLogEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_log_id',
        'user_id',
        'action',
        'description',
    ];

    public function documentLog()
    {
        return $this->belongsTo(DocumentLog::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
