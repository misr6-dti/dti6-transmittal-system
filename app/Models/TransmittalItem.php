<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Transmittal;

class TransmittalItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'transmittal_id',
        'quantity',
        'unit',
        'description',
        'remarks',
    ];

    public function transmittal()
    {
        return $this->belongsTo(Transmittal::class);
    }
}
