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
        return $this->hasMany(User::class, 'division_id');
    }
}
