<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Division;
use App\Models\User;
use App\Models\Office;

class DocumentLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_number',
        'log_date',
        'office_id',
        'sender_division_id',
        'sender_user_id',
        'receiver_division_id',
        'receiver_user_id',
        'remarks',
        'status',
        'received_at',
    ];

    protected $casts = [
        'log_date' => 'date',
        'received_at' => 'datetime',
    ];

    public function senderDivision()
    {
        return $this->belongsTo(Division::class, 'sender_division_id');
    }

    public function receiverDivision()
    {
        return $this->belongsTo(Division::class, 'receiver_division_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_user_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_user_id');
    }

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function items()
    {
        return $this->hasMany(DocumentLogItem::class);
    }

    public function entries()
    {
        return $this->hasMany(DocumentLogEntry::class);
    }
}
