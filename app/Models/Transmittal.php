<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Office;
use App\Models\TransmittalItem;
use App\Models\TransmittalLog;

class Transmittal extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_number',
        'transmittal_date',
        'sender_user_id',
        'sender_office_id',
        'receiver_office_id',
        'receiver_user_id',
        'remarks',
        'status',
        'received_at',
        'verification_token',
    ];

    protected static function booted()
    {
        static::creating(function ($transmittal) {
            if (empty($transmittal->verification_token)) {
                $transmittal->verification_token = \Illuminate\Support\Str::random(32);
            }
        });
    }

    protected $casts = [
        'transmittal_date' => 'date',
        'received_at' => 'datetime',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_user_id');
    }

    public function senderOffice()
    {
        return $this->belongsTo(Office::class, 'sender_office_id');
    }

    public function receiverOffice()
    {
        return $this->belongsTo(Office::class, 'receiver_office_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_user_id');
    }

    public function items()
    {
        return $this->hasMany(TransmittalItem::class);
    }

    public function logs()
    {
        return $this->hasMany(TransmittalLog::class);
    }
}
