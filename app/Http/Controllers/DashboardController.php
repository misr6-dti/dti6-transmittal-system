<?php

namespace App\Http\Controllers;

use App\Models\Transmittal;
use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $isAdmin = $user->hasAnyRole(['Super Admin', 'Regional MIS']);
        $userOfficeId = $user->office_id;

        if ($isAdmin) {
            $stats = [
                'total_sent' => Transmittal::count(),
                'total_received' => Transmittal::where('status', 'Received')->count(),
                'pending_outgoing' => Transmittal::where('sender_office_id', $userOfficeId)->where('status', 'Submitted')->count(),
                'pending_incoming' => Transmittal::where('receiver_office_id', $userOfficeId)->where('status', 'Submitted')->count(),
            ];

            $recentTransmittals = Transmittal::with(['senderOffice', 'receiverOffice', 'items'])
                ->latest()
                ->paginate(5);
        } else {
            $stats = [
                'total_sent' => Transmittal::where('sender_office_id', $userOfficeId)->count(),
                'total_received' => Transmittal::where('receiver_office_id', $userOfficeId)->count(),
                'pending_outgoing' => Transmittal::where('sender_office_id', $userOfficeId)->where('status', 'Submitted')->count(),
                'pending_incoming' => Transmittal::where('receiver_office_id', $userOfficeId)->where('status', 'Submitted')->count(),
            ];

            $recentTransmittals = Transmittal::where('sender_office_id', $userOfficeId)
                ->orWhere('receiver_office_id', $userOfficeId)
                ->with(['senderOffice', 'receiverOffice', 'items'])
                ->latest()
                ->paginate(5);
        }

        return view('dashboard', compact('stats', 'recentTransmittals'));
    }

    public function stats()
    {
        $user = Auth::user();
        $isAdmin = $user->hasAnyRole(['Super Admin', 'Regional MIS']);
        $userOfficeId = $user->office_id;

        if ($isAdmin) {
            $stats = [
                'total_sent' => \App\Models\Transmittal::count(),
                'total_received' => \App\Models\Transmittal::where('status', 'Received')->count(),
                'pending_outgoing' => \App\Models\Transmittal::where('sender_office_id', $userOfficeId)->where('status', 'Submitted')->count(),
                'pending_incoming' => \App\Models\Transmittal::where('receiver_office_id', $userOfficeId)->where('status', 'Submitted')->count(),
            ];

            $recent = \App\Models\Transmittal::with(['senderOffice', 'receiverOffice'])
                ->latest()
                ->take(5)
                ->get();
        } else {
            $stats = [
                'total_sent' => \App\Models\Transmittal::where('sender_office_id', $userOfficeId)->count(),
                'total_received' => \App\Models\Transmittal::where('receiver_office_id', $userOfficeId)->count(),
                'pending_outgoing' => \App\Models\Transmittal::where('sender_office_id', $userOfficeId)->where('status', 'Submitted')->count(),
                'pending_incoming' => \App\Models\Transmittal::where('receiver_office_id', $userOfficeId)->where('status', 'Submitted')->count(),
            ];

            $recent = \App\Models\Transmittal::where('sender_office_id', $userOfficeId)
                ->orWhere('receiver_office_id', $userOfficeId)
                ->with(['senderOffice', 'receiverOffice'])
                ->latest()
                ->take(5)
                ->get();
        }

        return response()->json([
            'stats' => $stats,
            'recent' => $recent->map(function ($t) use ($userOfficeId, $isAdmin) {
                $displayStatus = $t->status;
                $badgeClass = strtolower($t->status);

                if (!$isAdmin && $t->status === 'Submitted') {
                    if ($t->receiver_office_id == $userOfficeId) {
                        $displayStatus = 'To Receive';
                        $badgeClass = 'pending-arrival';
                    } elseif ($t->sender_office_id == $userOfficeId) {
                        $displayStatus = 'Pending Receipt';
                        $badgeClass = 'submitted';
                    }
                }

                return [
                    'id' => $t->id,
                    'reference_number' => $t->reference_number,
                    'transmittal_date' => $t->transmittal_date->format('M d, Y'),
                    'sender_office' => $t->senderOffice->name,
                    'receiver_office' => $t->receiverOffice->name,
                    'status' => $displayStatus,
                    'badge_class' => $badgeClass,
                    'show_url' => route('transmittals.show', $t),
                ];
            }),
        ]);
    }
}
