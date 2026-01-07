<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Transmittal;

class Office extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'code'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function sentTransmittals()
    {
        return $this->hasMany(Transmittal::class, 'sender_office_id');
    }

    public function receivedTransmittals()
    {
        return $this->hasMany(Transmittal::class, 'receiver_office_id');
    }
}
