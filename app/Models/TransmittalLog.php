<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Transmittal;
use App\Models\User;

class TransmittalLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'transmittal_id',
        'user_id',
        'action',
        'description',
    ];

    public function transmittal()
    {
        return $this->belongsTo(Transmittal::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
