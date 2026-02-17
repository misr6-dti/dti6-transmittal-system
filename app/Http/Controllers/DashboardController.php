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
        $userOfficeId = $user->office_id;

        $stats = $this->getStats($user, $userOfficeId);

        $recentTransmittals = $this->getTransmittalQuery($user)
            ->with(['items'])
            ->latest()
            ->paginate(5);

        return view('dashboard', compact('stats', 'recentTransmittals'));
    }

    public function stats()
    {
        $user = Auth::user();
        $isAdmin = $user->isAdmin();
        $userOfficeId = $user->office_id;

        $stats = $this->getStats($user, $userOfficeId);

        $recent = $this->getTransmittalQuery($user)
            ->latest()
            ->take(5)
            ->get();

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

    private function getStats($user, $userOfficeId)
    {
        $totalSent = Transmittal::where('sender_office_id', $userOfficeId)->count();
        $totalReceived = Transmittal::where('receiver_office_id', $userOfficeId)->where('status', 'Received')->count();
        $pendingOutgoing = Transmittal::where('sender_office_id', $userOfficeId)->where('status', 'Submitted')->count();
        $pendingIncoming = Transmittal::where('receiver_office_id', $userOfficeId)->where('status', 'Submitted')->count();

        return [
            'total_sent' => $totalSent,
            'total_received' => $totalReceived,
            'pending_outgoing' => $pendingOutgoing,
            'pending_incoming' => $pendingIncoming,
        ];
    }

    private function getTransmittalQuery($user)
    {
        $query = Transmittal::query();

        if (!$user->hasAnyRole(['Super Admin', 'Regional MIS'])) {
            $query->where(function ($q) use ($user) {
                $q->where('sender_office_id', $user->office_id)
                  ->orWhere('receiver_office_id', $user->office_id);
            });
        }

        return $query;
    }
}
