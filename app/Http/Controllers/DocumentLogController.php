<?php

namespace App\Http\Controllers;

use App\Models\DocumentLog;
use App\Models\DocumentLogItem;
use App\Models\Division;
use App\Http\Requests\DocumentLog\StoreDocumentLogRequest;
use App\Http\Requests\DocumentLog\UpdateDocumentLogRequest;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DocumentLogController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', DocumentLog::class);
        
        $user = Auth::user();
        if (!$user->division_id && !$user->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'You must be assigned to a division to access Document Logs.');
        }

        $query = DocumentLog::query()
            ->with(['senderDivision', 'receiverDivision', 'sender'])
            ->latest('log_date');

        // Filter by office (always scoped)
        $query->where('office_id', $user->office_id);

        // Filter for non-admins: only show logs involved with their division
        if (!$user->isAdmin()) {
            $query->where(function ($q) use ($user) {
                $q->where('sender_division_id', $user->division_id)
                  ->orWhere('receiver_division_id', $user->division_id);
            });
        }

        $documentLogs = $query->paginate(15);

        return view('document-logs.index', compact('documentLogs'));
    }

    public function create()
    {
        $this->authorize('create', DocumentLog::class);
        
        $user = Auth::user();
        
        // Get divisions in the SAME office, excluding self
        $divisions = Division::where('office_id', $user->office_id)
            ->where('id', '!=', $user->division_id)
            ->orderBy('name')
            ->get();

        // Generate Reference Number (DL-{OFFICE}-{YEAR}-{COUNT})
        $year = date('Y');
        $officeCode = $user->office->code;
        $count = DocumentLog::where('office_id', $user->office_id)
            ->whereYear('created_at', $year)
            ->count() + 1;
        $refNumber = sprintf("DL-%s-%s-%04d", $officeCode, $year, $count);

        return view('document-logs.create', compact('divisions', 'refNumber'));
    }

    public function store(StoreDocumentLogRequest $request)
    {
        // Items are already filtered/prepared by the FormRequest
        $filteredItems = $request->items ?? [];

        DB::beginTransaction();
        try {
            $user = Auth::user();
            $status = $request->status === 'Draft' ? 'Draft' : 'Submitted';

            $documentLog = DocumentLog::create([
                'reference_number' => $request->reference_number,
                'log_date' => $request->log_date,
                'office_id' => $user->office_id,
                'sender_division_id' => $user->division_id,
                'sender_user_id' => $user->id,
                'receiver_division_id' => $request->receiver_division_id,
                'remarks' => $request->remarks,
                'status' => $status,
            ]);

            foreach ($filteredItems as $item) {
                DocumentLogItem::create([
                    'document_log_id' => $documentLog->id,
                    'quantity' => $item['quantity'],
                    'unit' => $item['unit'] ?? 'pcs',
                    'description' => $item['description'],
                    'remarks' => $item['remarks'] ?? null,
                ]);
            }

            if ($status === 'Submitted') {
                NotificationService::notifyDocumentLogCreated($documentLog);
            }

            DB::commit();
            $msg = $status === 'Draft' ? 'Document log saved as draft.' : 'Document log submitted successfully.';
            return redirect()->route('document-logs.show', $documentLog)->with('success', $msg);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error saving document log: ' . $e->getMessage())->withInput();
        }
    }

    public function show(DocumentLog $documentLog)
    {
        $this->authorize('view', $documentLog);
        
        $documentLog->load(['items', 'entries.user', 'senderDivision', 'receiverDivision', 'sender', 'receiver']);
        
        return view('document-logs.show', compact('documentLog'));
    }

    public function edit(DocumentLog $documentLog)
    {
        $this->authorize('update', $documentLog);

        $divisions = Division::where('office_id', Auth::user()->office_id)
            ->where('id', '!=', Auth::user()->division_id)
            ->orderBy('name')
            ->get();

        return view('document-logs.edit', compact('documentLog', 'divisions'));
    }

    public function update(UpdateDocumentLogRequest $request, DocumentLog $documentLog)
    {
        $filteredItems = $request->items ?? [];

        DB::beginTransaction();
        try {
            $status = $request->status === 'Draft' ? 'Draft' : 'Submitted';
            $previousStatus = $documentLog->status;

            $documentLog->update([
                'reference_number' => $request->reference_number,
                'log_date' => $request->log_date,
                'receiver_division_id' => $request->receiver_division_id,
                'remarks' => $request->remarks,
                'status' => $status,
            ]);

            // Sync items (delete all and recreate for simplicity)
            $documentLog->items()->delete();
            foreach ($filteredItems as $item) {
                DocumentLogItem::create([
                    'document_log_id' => $documentLog->id,
                    'quantity' => $item['quantity'],
                    'unit' => $item['unit'] ?? 'pcs',
                    'description' => $item['description'],
                    'remarks' => $item['remarks'] ?? null,
                ]);
            }

            if ($status === 'Submitted' && $previousStatus === 'Draft') {
                NotificationService::notifyDocumentLogCreated($documentLog);
            }

            DB::commit();
             $msg = $status === 'Draft' ? 'Document log saved as draft.' : 'Document log submitted successfully.';
            return redirect()->route('document-logs.show', $documentLog)->with('success', $msg);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error updating document log: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(DocumentLog $documentLog)
    {
        $this->authorize('delete', $documentLog);

        $documentLog->delete();

        return redirect()->route('document-logs.index')->with('success', 'Document log deleted.');
    }

    public function receive(DocumentLog $documentLog)
    {
        $this->authorize('receive', $documentLog);

        if ($documentLog->status === 'Received') {
            return back()->with('error', 'Document log already received.');
        }

        DB::beginTransaction();
        try {
            $documentLog->update([
                'status' => 'Received',
                'receiver_user_id' => Auth::id(),
                'received_at' => now(),
            ]);

            NotificationService::notifyDocumentLogReceived($documentLog);

            DB::commit();
            return redirect()->route('document-logs.index')->with('success', 'Document log marked as received.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('document-logs.index')->with('error', 'Error processing receipt.');
        }
    }
}
