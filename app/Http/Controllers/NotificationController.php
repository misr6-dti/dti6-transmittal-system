<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display all notifications for the user
     */
    public function index()
    {
        $notifications = Notification::forUser(Auth::user())
            ->latest()
            ->paginate(10);

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Get unread notifications (JSON response)
     */
    public function getUnread()
    {
        $notifications = Notification::forUser(Auth::user())
            ->whereNull('read_at')
            ->latest()
            ->limit(5)
            ->get();

        return response()->json($notifications);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(Notification $notification)
    {
        // Check authorization
        if ($notification->office_id != Auth::user()->office_id && $notification->user_id != Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $notification->markAsRead();
        
        return response()->json(['success' => true, 'message' => 'Notification marked as read']);
    }

    /**
     * Mark notification as unread
     */
    public function markAsUnread(Notification $notification)
    {
        // Check authorization
        if ($notification->office_id != Auth::user()->office_id && $notification->user_id != Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $notification->markAsUnread();
        
        return response()->json(['success' => true, 'message' => 'Notification marked as unread']);
    }

    /**
     * Delete a notification
     */
    public function delete(Notification $notification)
    {
        // Check authorization
        if ($notification->office_id != Auth::user()->office_id && $notification->user_id != Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $notification->delete();
        
        return response()->json(['success' => true, 'message' => 'Notification deleted']);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        Notification::forUser(Auth::user())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['success' => true, 'message' => 'All notifications marked as read']);
    }

    /**
     * Get unread count
     */
    public function unreadCount()
    {
        $count = Notification::forUser(Auth::user())
            ->whereNull('read_at')
            ->count();

        return response()->json(['count' => $count]);
    }
}
