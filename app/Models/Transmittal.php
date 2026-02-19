<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Office;
use App\Models\TransmittalItem;
use Illuminate\Support\Facades\Auth;
use App\Models\TransmittalLog;

class Transmittal extends Model
{
    use HasFactory;

    /**
     * Get the status display data for the transmittal based on the viewer.
     */
    public function getStatusDisplay(User $user = null): array
    {
        $user = $user ?? Auth::user();
        
        // Default fallback if no user context
        if (!$user) {
            return [
                'label' => $this->status,
                'class' => strtolower($this->status),
            ];
        }

        $userOfficeId = $user->office_id;
        $isAdmin = $user->hasRole('Admin');
        
        $status = $this->status;
        $badgeClass = strtolower($status);
        $displayStatus = $status;

        if (!$isAdmin && $status === 'Submitted') {
            if ($this->receiver_office_id == $userOfficeId) {
                $displayStatus = 'To Receive';
                $badgeClass = 'pending-arrival';
            } elseif ($this->sender_office_id == $userOfficeId) {
                $displayStatus = 'Pending Receipt';
                $badgeClass = 'submitted';
            }
        }

        return [
            'label' => $displayStatus,
            'class' => $badgeClass,
        ];
    }

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
        'qr_token',
    ];

    protected static function booted()
    {
        static::creating(function ($transmittal) {
            if (empty($transmittal->verification_token)) {
                $transmittal->verification_token = \Illuminate\Support\Str::random(32);
            }
            if (empty($transmittal->qr_token)) {
                $transmittal->qr_token = $transmittal->generateUniqueQrToken();
            }
        });
    }

    protected $casts = [
        'transmittal_date' => 'date',
        'received_at' => 'datetime',
    ];

    public function generateUniqueQrToken()
    {
        do {
            $token = strtoupper(\Illuminate\Support\Str::random(12));
        } while (self::where('qr_token', $token)->exists());
        
        return $token;
    }

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
