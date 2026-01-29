<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use App\Models\Office;

class NotificationService
{
    /**
     * Create a notification for a specific user
     *
     * @param User $user
     * @param string $title
     * @param string $message
     * @param string|null $link
     * @return Notification
     */
    public static function notifyUser(User $user, $title, $message, $link = null)
    {
        return Notification::create([
            'user_id' => $user->id,
            'office_id' => $user->office_id,
            'title' => $title,
            'message' => $message,
            'link' => $link,
        ]);
    }

    /**
     * Create a notification for all users in an office
     *
     * @param Office $office
     * @param string $title
     * @param string $message
     * @param string|null $link
     * @return void
     */
    public static function notifyOffice(Office $office, $title, $message, $link = null)
    {
        $users = $office->users;
        foreach ($users as $user) {
            static::notifyUser($user, $title, $message, $link);
        }
    }

    /**
     * Create a notification for multiple users
     *
     * @param array $userIds
     * @param string $title
     * @param string $message
     * @param string|null $link
     * @return void
     */
    public static function notifyUsers($userIds, $title, $message, $link = null)
    {
        $users = User::whereIn('id', $userIds)->get();
        foreach ($users as $user) {
            static::notifyUser($user, $title, $message, $link);
        }
    }

    /**
     * Create notification for transmittal creation
     *
     * @param $transmittal
     * @return void
     */
    public static function notifyTransmittalCreated($transmittal)
    {
        $message = "A new transmittal {$transmittal->reference_number} has been created and is being sent from {$transmittal->senderOffice->code}.";
        $link = route('transmittals.show', $transmittal->id);
        
        static::notifyOffice(
            $transmittal->receiverOffice,
            "Incoming Transmittal",
            $message,
            $link
        );
    }

    /**
     * Create notification for transmittal received
     *
     * @param $transmittal
     * @return void
     */
    public static function notifyTransmittalReceived($transmittal)
    {
        $message = "Your transmittal {$transmittal->reference_number} has been received by {$transmittal->receiverOffice->code}.";
        $link = route('transmittals.show', $transmittal->id);
        
        static::notifyUser(
            $transmittal->sender,
            "Transmittal Received",
            $message,
            $link
        );
    }

    /**
     * Create notification for transmittal status change
     *
     * @param $transmittal
     * @param string $previousStatus
     * @return void
     */
    public static function notifyTransmittalStatusChanged($transmittal, $previousStatus)
    {
        $message = "Transmittal {$transmittal->reference_number} status has changed from {$previousStatus} to {$transmittal->status}.";
        $link = route('transmittals.show', $transmittal->id);
        
        static::notifyUser(
            $transmittal->sender,
            "Status Update",
            $message,
            $link
        );
    }
}
