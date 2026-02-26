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
        $query = TransmittalLog::with(['user.office', 'transmittal.senderOffice', 'transmittal.receiverOffice']);

        // Standard Office Isolation for non-admins
        if ($user->isAdmin()) {
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

        // Handle sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        
        // Validate sort parameters to prevent injection
        $allowedSortFields = ['created_at', 'action', 'user_id', 'transmittal_id', 'sender_office_id', 'receiver_office_id'];
        $allowedSortOrders = ['asc', 'desc'];
        
        if (!in_array($sortBy, $allowedSortFields)) {
            $sortBy = 'created_at';
        }
        if (!in_array($sortOrder, $allowedSortOrders)) {
            $sortOrder = 'desc';
        }
        
        // Handle sorting through relationships
        if ($sortBy === 'transmittal_id') {
            $query->join('transmittals', 'transmittal_logs.transmittal_id', '=', 'transmittals.id')
                  ->select('transmittal_logs.*')
                  ->orderBy('transmittals.reference_number', $sortOrder);
        } elseif ($sortBy === 'sender_office_id') {
            $query->join('transmittals', 'transmittal_logs.transmittal_id', '=', 'transmittals.id')
                  ->select('transmittal_logs.*')
                  ->orderBy('transmittals.sender_office_id', $sortOrder);
        } elseif ($sortBy === 'receiver_office_id') {
            $query->join('transmittals', 'transmittal_logs.transmittal_id', '=', 'transmittals.id')
                  ->select('transmittal_logs.*')
                  ->orderBy('transmittals.receiver_office_id', $sortOrder);
        } else {
            $query->orderBy($sortBy, $sortOrder);
        }

        $logs = $query->paginate(10);
        $offices = \App\Models\Office::all();
        
        // Pass sort parameters to view
        $sort = [
            'by' => $sortBy,
            'order' => $sortOrder
        ];

        return view('audit.index', compact('logs', 'offices', 'sort'));
    }

    public function show(TransmittalLog $transmittalLog)
    {
        $user = Auth::user();
        
        // Authorization check - ensure user has access to this log
        if (!$user->isAdmin()) {
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
