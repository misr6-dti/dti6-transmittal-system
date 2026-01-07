<?php

namespace App\Policies;

use App\Models\Transmittal;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TransmittalPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view transmittals');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Transmittal $transmittal): bool
    {
        // Super Admin and Regional MIS can view all
        if ($user->hasAnyRole(['Super Admin', 'Regional MIS'])) {
            return true;
        }

        // Others can only view if it's their office's transmittal
        return ($user->office_id == $transmittal->sender_office_id || 
               $user->office_id == $transmittal->receiver_office_id) && 
               $user->can('view transmittals');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create transmittals');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Transmittal $transmittal): bool
    {
        if ($user->hasAnyRole(['Super Admin', 'Regional MIS'])) {
            return true;
        }

        // Cannot edit if already received unless admin
        if ($transmittal->status === 'Received') {
            return false;
        }

        // Only creator can update
        return $user->id == $transmittal->sender_user_id && $user->can('edit transmittals');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Transmittal $transmittal): bool
    {
        if ($user->hasAnyRole(['Super Admin', 'Regional MIS'])) {
            return true;
        }

        if ($transmittal->status === 'Received') {
            return false;
        }

        return $user->id == $transmittal->sender_user_id && $user->can('delete transmittals');
    }

    /**
     * Determine whether the user can receive the model.
     */
    public function receive(User $user, Transmittal $transmittal): bool
    {
        // Only Submitted transmittals can be received
        if ($transmittal->status !== 'Submitted') {
            return false;
        }

        // Admins can receive anything
        if ($user->hasAnyRole(['Super Admin', 'Regional MIS'])) {
            return true;
        }

        // Only members of the receiving office can mark as received
        return ($user->office_id == $transmittal->receiver_office_id) && $user->can('receive transmittals');
    }
}
