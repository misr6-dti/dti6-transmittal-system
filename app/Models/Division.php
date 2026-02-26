<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Office;
use App\Models\User;

class Division extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'office_id'];

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function sentDocumentLogs()
    {
        return $this->hasMany(DocumentLog::class, 'sender_division_id');
    }

    public function receivedDocumentLogs()
    {
        return $this->hasMany(DocumentLog::class, 'receiver_division_id');
    }
}
