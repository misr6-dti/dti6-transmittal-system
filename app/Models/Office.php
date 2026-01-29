<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Transmittal;
use App\Models\Division;

class Office extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'code', 'parent_id'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function divisions()
    {
        return $this->hasMany(Division::class);
    }

    public function parent()
    {
        return $this->belongsTo(Office::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Office::class, 'parent_id')->with('children');
    }

    public function sentTransmittals()
    {
        return $this->hasMany(Transmittal::class, 'sender_office_id');
    }

    public function receivedTransmittals()
    {
        return $this->hasMany(Transmittal::class, 'receiver_office_id');
    }

    /**
     * Get the Regional or Provincial office if this is a Satellite or Division
     * Returns the office itself if it's already Regional or Provincial
     */
    public function getDisplayOffice()
    {
        // If this office is already Regional or Provincial, return it
        if (in_array($this->type, ['Regional', 'Provincial'])) {
            return $this;
        }

        // If this is a Satellite, traverse up to find Regional/Provincial parent
        $current = $this;
        while ($current->parent_id) {
            $current = $current->parent;
            if (in_array($current->type, ['Regional', 'Provincial'])) {
                return $current;
            }
        }

        // Fallback to self if no Regional/Provincial parent found
        return $this;
    }
}

