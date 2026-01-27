<?php

namespace App\Http\Controllers;

use App\Models\TransmittalLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = TransmittalLog::with(['user.office', 'transmittal.senderOffice', 'transmittal.receiverOffice'])
            ->latest();

        // Standard Office Isolation for non-admins
        if (!$user->hasAnyRole(['Super Admin', 'Regional MIS'])) {
            $userOfficeId = $user->office_id;
            $query->whereHas('transmittal', function ($q) use ($userOfficeId) {
                $q->where('sender_office_id', $userOfficeId)
                  ->orWhere('receiver_office_id', $userOfficeId);
            });
        } else {
            // Admin Filters
            if ($request->filled('office_id')) {
                $officeId = $request->office_id;
                $query->whereHas('transmittal', function ($q) use ($officeId) {
                    $q->where('sender_office_id', $officeId)
                      ->orWhere('receiver_office_id', $officeId);
                });
            }

            if ($request->filled('action')) {
                $query->where('action', $request->action);
            }

            if ($request->filled('search')) {
                $search = $request->search;
                $query->whereHas('transmittal', function ($q) use ($search) {
                    $q->where('reference_number', 'like', "%{$search}%");
                })->orWhere('description', 'like', "%{$search}%");
            }
        }

        $logs = $query->paginate(5);
        $offices = \App\Models\Office::all();

        return view('audit.index', compact('logs', 'offices'));
    }

    public function show(TransmittalLog $transmittalLog)
    {
        $user = Auth::user();
        
        // Authorization check - ensure user has access to this log
        if (!$user->hasAnyRole(['Super Admin', 'Regional MIS'])) {
            $transmittal = $transmittalLog->transmittal;
            if ($transmittal->sender_office_id !== $user->office_id && 
                $transmittal->receiver_office_id !== $user->office_id) {
                abort(403, 'Unauthorized access to this audit log.');
            }
        }

        $log = $transmittalLog->load(['user.office', 'transmittal.senderOffice', 'transmittal.receiverOffice', 'transmittal.items']);

        return view('audit.show', compact('log'));
    }
}
