<?php

namespace App\Policies;

use App\Models\DocumentLog;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DocumentLogPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view document-logs');
    }

    public function view(User $user, DocumentLog $documentLog): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        // View if sender or receiver division matches AND user is in the same office
        // (Though document logs are office-scoped anyway)
        return ($user->division_id == $documentLog->sender_division_id || 
                $user->division_id == $documentLog->receiver_division_id) && 
               $user->can('view document-logs');
    }

    public function create(User $user): bool
    {
        if ($user->isAdmin()) {
            return true;
        }
        return $user->can('create document-logs') && !is_null($user->division_id);
    }

    public function update(User $user, DocumentLog $documentLog): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($documentLog->status === 'Received') {
            return false;
        }

        return $user->id == $documentLog->sender_user_id && $user->can('edit document-logs');
    }

    public function delete(User $user, DocumentLog $documentLog): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($documentLog->status === 'Received') {
            return false;
        }

        return $user->id == $documentLog->sender_user_id && $user->can('delete document-logs');
    }

    public function receive(User $user, DocumentLog $documentLog): bool
    {
        if ($documentLog->status !== 'Submitted') {
            return false;
        }

        if ($user->isAdmin()) {
            return true;
        }

        return ($user->division_id == $documentLog->receiver_division_id) && $user->can('receive document-logs');
    }
}
