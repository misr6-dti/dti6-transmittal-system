<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where(function($query) {
                $query->where('office_id', Auth::user()->office_id)
                      ->orWhere('user_id', Auth::id());
            })
            ->whereNull('read_at')
            ->latest()
            ->get();

        return response()->json($notifications);
    }

    public function markAsRead(Notification $notification)
    {
        if ($notification->office_id != Auth::user()->office_id && $notification->user_id != Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $notification->update(['read_at' => now()]);
        return response()->json(['success' => true]);
    }

    public function unreadCount()
    {
        $count = Notification::where(function($query) {
                $query->where('office_id', Auth::user()->office_id)
                      ->orWhere('user_id', Auth::id());
            })
            ->whereNull('read_at')
            ->count();

        return response()->json(['count' => $count]);
    }
}
