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

    protected $casts = [
        'read_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if notification is read
     */
    public function isRead()
    {
        return $this->read_at !== null;
    }

    /**
     * Check if notification is unread
     */
    public function isUnread()
    {
        return $this->read_at === null;
    }

    /**
     * Mark notification as read
     */
    public function markAsRead()
    {
        if ($this->isUnread()) {
            $this->update(['read_at' => now()]);
        }
        return $this;
    }

    /**
     * Mark notification as unread
     */
    public function markAsUnread()
    {
        if ($this->isRead()) {
            $this->update(['read_at' => null]);
        }
        return $this;
    }

    /**
     * Scope a query to only include notifications for a given user.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \App\Models\User  $user
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForUser($query, $user)
    {
        return $query->where(function ($q) use ($user) {
            $q->where('office_id', $user->office_id)
              ->orWhere('user_id', $user->id);
        });
    }
}
