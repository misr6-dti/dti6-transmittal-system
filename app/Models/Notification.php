<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'office_id',
        'user_id',
        'title',
        'message',
        'link',
        'read_at',
    ];

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
