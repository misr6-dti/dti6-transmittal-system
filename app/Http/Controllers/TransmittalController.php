<?php

namespace App\Http\Controllers;

use App\Models\Transmittal;
use App\Models\TransmittalItem;
use App\Models\TransmittalLog;
use App\Models\Office;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TransmittalController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request)
    {
        // Set default dates to today if no filters are applied
        if (!$request->has('search') && !$request->has('status') && !$request->has('office_id') && !$request->has('date_from') && !$request->has('date_to')) {
            $request->merge([
                'date_from' => date('Y-m-d'),
                'date_to' => date('Y-m-d')
            ]);
        }

        $query = Transmittal::with(['senderOffice', 'receiverOffice', 'sender']);

        if ($request->search) {
            $query->where('reference_number', 'like', "%{$request->search}%");
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->office_id) {
            $query->where(function($q) use ($request) {
                $q->where('sender_office_id', $request->office_id)
                  ->orWhere('receiver_office_id', $request->office_id);
            });
        }

        if ($request->date_from) {
            $query->whereDate('transmittal_date', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $query->whereDate('transmittal_date', '<=', $request->date_to);
        }

        // Mandatory office filtering for non-admins
        if (!Auth::user()->hasAnyRole(['Super Admin', 'Regional MIS'])) {
            $userOfficeId = Auth::user()->office_id;
            $query->where(function($q) use ($userOfficeId) {
                $q->where('sender_office_id', $userOfficeId)
                  ->orWhere('receiver_office_id', $userOfficeId);
            });
        }

        // Handle sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        
        // Validate sort parameters to prevent injection
        $allowedSortFields = ['reference_number', 'transmittal_date', 'status', 'created_at', 'sender_office_id', 'receiver_office_id'];
        $allowedSortOrders = ['asc', 'desc'];
        
        if (!in_array($sortBy, $allowedSortFields)) {
            $sortBy = 'created_at';
        }
        if (!in_array($sortOrder, $allowedSortOrders)) {
            $sortOrder = 'desc';
        }
        
        $query->orderBy($sortBy, $sortOrder);

        $transmittals = $query->with(['items'])->paginate(10);
        $offices = Office::all();
        
        // Pass sort parameters to view
        $sort = [
            'by' => $sortBy,
            'order' => $sortOrder
        ];

        return view('transmittals.index', compact('transmittals', 'offices', 'sort'));
    }

    public function create()
    {
        $this->authorize('create', Transmittal::class);
        // Get ALL offices first for hierarchy building
        $allOffices = Office::all();
        // Format with hierarchy
        $formattedOffices = $this->formatOfficesHierarchy($allOffices);
        // Now exclude user's own office from the final list
        $offices = $formattedOffices->filter(function($office) {
            return $office->id != Auth::user()->office_id;
        })->values();
        
        $userOffice = Auth::user()->office;
        
        // Generate a reference number: T-OFFICE-YEAR-SEQUENCE_NUMBER
        $officeCode = $userOffice ? $userOffice->code : 'UNK';
        $year = date('Y');
        
        // Count transmittals from this office in the current year to determine sequence
        $count = Transmittal::where('sender_office_id', Auth::user()->office_id)
            ->whereYear('transmittal_date', $year)
            ->count();
            
        $sequence = str_pad($count + 1, 3, '0', STR_PAD_LEFT);
        $nextRef = "T-{$officeCode}-{$year}-{$sequence}";

        return view('transmittals.create', compact('offices', 'nextRef'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Transmittal::class);
        // Pre-filter items: remove rows that are completely empty
        if ($request->has('items')) {
            $items = array_values(array_filter($request->items, function ($item) {
                return !empty($item['quantity']) || !empty($item['description']) || !empty($item['remarks']);
            }));
            $request->merge(['items' => $items]);
        }

        $isDraft = $request->status === 'Draft';

        $rules = [
            'reference_number' => 'required|unique:transmittals',
            'transmittal_date' => 'required|date',
            'receiver_office_id' => 'required|exists:offices,id',
            'status' => 'required|in:Draft,Submitted',
        ];

        if (!$isDraft) {
            $rules['items'] = 'required|array|min:1';
            $rules['items.*.quantity'] = 'required|numeric|min:0.5';
            $rules['items.*.description'] = 'required|string';
        } else {
            $rules['items'] = 'nullable|array';
            $rules['items.*.quantity'] = 'nullable|numeric';
            $rules['items.*.description'] = 'nullable|string';
        }

        $request->validate($rules);

        $filteredItems = $request->items ?? [];

        DB::beginTransaction();
        try {
            $status = $request->status === 'Draft' ? 'Draft' : 'Submitted';

            $transmittal = Transmittal::create([
                'reference_number' => $request->reference_number,
                'transmittal_date' => $request->transmittal_date,
                'sender_user_id' => Auth::id(),
                'sender_office_id' => Auth::user()->office_id,
                'receiver_office_id' => $request->receiver_office_id,
                'remarks' => $request->remarks,
                'status' => $status,
            ]);

            foreach ($filteredItems as $item) {
                TransmittalItem::create([
                    'transmittal_id' => $transmittal->id,
                    'quantity' => $item['quantity'],
                    'unit' => $item['unit'] ?? 'pcs',
                    'description' => $item['description'],
                    'remarks' => $item['remarks'] ?? null,
                ]);
            }

            TransmittalLog::create([
                'transmittal_id' => $transmittal->id,
                'user_id' => Auth::id(),
                'action' => $status,
                'description' => "Transmittal #{$transmittal->reference_number} was {$status}.",
            ]);

            if ($status === 'Submitted') {
                // Use NotificationService for cleaner notification creation
                NotificationService::notifyTransmittalCreated($transmittal);
            }

            DB::commit();
            return redirect()->route('transmittals.show', $transmittal)->with('success', 'Transmittal submitted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error saving transmittal: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Transmittal $transmittal)
    {
        $this->authorize('view', $transmittal);
        $transmittal->load(['sender', 'senderOffice', 'receiverOffice', 'receiver', 'items', 'logs.user']);
        
        $qrcode = $this->generateQrCode($transmittal);
        
        return view('transmittals.show', compact('transmittal', 'qrcode'));
    }

    public function publicTrack($qr_token)
    {
        $transmittal = Transmittal::where('qr_token', $qr_token)->first();

        if (!$transmittal) {
            return view('transmittals.public-track', ['transmittal' => null, 'error' => 'Transmittal not found.']);
        }

        $transmittal->load(['senderOffice', 'receiverOffice']);

        return view('transmittals.public-track', compact('transmittal'));
    }

    public function edit(Transmittal $transmittal)
    {
        $this->authorize('update', $transmittal);
        if ($transmittal->status !== 'Draft' && !Auth::user()->hasAnyRole(['Super Admin', 'Regional MIS'])) {
            if ($transmittal->status === 'Received') {
                return redirect()->route('transmittals.show', $transmittal)->with('error', 'Received transmittals cannot be edited.');
            }
        }

        // Get ALL offices first for hierarchy building
        $allOffices = Office::all();
        // Format with hierarchy
        $formattedOffices = $this->formatOfficesHierarchy($allOffices);
        // Now exclude user's own office from the final list
        $offices = $formattedOffices->filter(function($office) {
            return $office->id != Auth::user()->office_id;
        })->values();
        
        return view('transmittals.edit', compact('transmittal', 'offices'));
    }

    public function update(Request $request, Transmittal $transmittal)
    {
        $this->authorize('update', $transmittal);
        $request->validate([
            'reference_number' => 'required|unique:transmittals,reference_number,' . $transmittal->id,
            'transmittal_date' => 'required|date',
            'receiver_office_id' => 'required|exists:offices,id',
            'items' => 'required|array|min:1',
            'items.*.quantity' => 'required|numeric|min:0.5',
            'items.*.description' => 'required|string',
        ]);

        $filteredItems = array_filter($request->items, function($item) {
            return !empty($item['quantity']) && !empty($item['description']);
        });

        DB::beginTransaction();
        try {
            $oldStatus = $transmittal->status;
            $newStatus = $request->status === 'Submitted' ? 'Submitted' : 'Draft';

            $transmittal->update([
                'reference_number' => $request->reference_number,
                'transmittal_date' => $request->transmittal_date,
                'receiver_office_id' => $request->receiver_office_id,
                'remarks' => $request->remarks,
                'status' => $newStatus,
            ]);

            $transmittal->items()->delete();
            foreach ($filteredItems as $item) {
                TransmittalItem::create([
                    'transmittal_id' => $transmittal->id,
                    'quantity' => $item['quantity'],
                    'unit' => $item['unit'] ?? 'pcs',
                    'description' => $item['description'],
                    'remarks' => $item['remarks'] ?? null,
                ]);
            }

            $logAction = ($oldStatus === 'Draft' && $newStatus === 'Submitted') ? 'Submitted' : 'Edited';
            
            TransmittalLog::create([
                'transmittal_id' => $transmittal->id,
                'user_id' => Auth::id(),
                'action' => $logAction,
                'description' => "Transmittal #{$transmittal->reference_number} was {$logAction}.",
            ]);

            DB::commit();
            return redirect()->route('transmittals.show', $transmittal)->with('success', 'Transmittal updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error updating transmittal.')->withInput();
        }
    }

    public function receive(Transmittal $transmittal)
    {
        $this->authorize('receive', $transmittal);
        if ($transmittal->status === 'Received') {
            return back()->with('error', 'Transmittal already received.');
        }

        DB::beginTransaction();
        try {
            $transmittal->update([
                'status' => 'Received',
                'receiver_user_id' => Auth::id(),
                'received_at' => now(),
            ]);

            TransmittalLog::create([
                'transmittal_id' => $transmittal->id,
                'user_id' => Auth::id(),
                'action' => 'Received',
                'description' => "Transmittal #{$transmittal->reference_number} marked as Received by " . Auth::user()->name,
            ]);

            // Use NotificationService for cleaner notification creation
            NotificationService::notifyTransmittalReceived($transmittal);

            DB::commit();
            return redirect()->route('transmittals.index')->with('success', 'Transmittal marked as received.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('transmittals.index')->with('error', 'Error processing receipt.');
        }
    }

    public function destroy(Transmittal $transmittal)
    {
        $this->authorize('delete', $transmittal);
        if ($transmittal->status === 'Received' && !Auth::user()->hasAnyRole(['Super Admin', 'Regional MIS'])) {
            return back()->with('error', 'Received transmittals cannot be deleted.');
        }

        $transmittal->delete();
        return redirect()->route('transmittals.index')->with('success', 'Transmittal deleted.');
    }

    public function downloadPdf(Transmittal $transmittal)
    {
        $this->authorize('view', $transmittal);
        $transmittal->load(['sender', 'senderOffice', 'receiverOffice', 'receiver', 'items']);
        
        $qrcode = $this->generateQrCode($transmittal);
        
        $pdf = Pdf::loadView('transmittals.pdf', compact('transmittal', 'qrcode'))
                  ->setPaper('a4', 'portrait');
        
        return $pdf->download("Transmittal-{$transmittal->reference_number}.pdf");
    }

    private function generateQrCode(Transmittal $transmittal)
    {
        // Ensure qr_token exists (for existing transmittals created before qr_token was added)
        if (!$transmittal->qr_token) {
            $transmittal->update(['qr_token' => $transmittal->generateUniqueQrToken()]);
        }

        // Generate QR code that points to public tracking page using short QR token
        $trackingUrl = route('transmittals.public-track', ['qr_token' => $transmittal->qr_token]);

        $options = new \chillerlan\QRCode\QROptions([
            'imageTransparent' => false,
            'scale' => 5,
            'outputType' => \chillerlan\QRCode\QRCode::OUTPUT_MARKUP_SVG,
            'eccLevel' => \chillerlan\QRCode\QRCode::ECC_L,
        ]);

        $out = (new \chillerlan\QRCode\QRCode($options))->render($trackingUrl);
        
        return $out;
    }

    public function updateItems(Request $request, Transmittal $transmittal)
    {
        $this->authorize('update', $transmittal);

        try {
            $items = $request->input('items', []);
            
            foreach ($items as $itemData) {
                $item = TransmittalItem::find($itemData['id']);
                if ($item && $item->transmittal_id == $transmittal->id) {
                    $item->update([
                        'quantity' => $itemData['quantity'] ?? $item->quantity,
                        'unit' => $itemData['unit'] ?? $item->unit,
                        'description' => $itemData['description'] ?? $item->description,
                        'remarks' => $itemData['remarks'] ?? null,
                    ]);
                }
            }

            // Log the update
            TransmittalLog::create([
                'transmittal_id' => $transmittal->id,
                'user_id' => Auth::id(),
                'action' => 'Items Updated',
                'description' => "Transmittal #{$transmittal->reference_number} items were updated by " . Auth::user()->name,
            ]);

            return response()->json(['success' => true, 'message' => 'Items updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error updating items'], 500);
        }
    }

    /**
     * Format offices with hierarchy for dropdown display
     * Returns collection with prefixed codes showing the office structure
     */
    private function formatOfficesHierarchy($offices, $parentId = null, $prefix = '')
    {
        $result = [];
        
        // Convert to array for easier iteration
        $officesArray = $offices->toArray();
        
        foreach ($officesArray as $office) {
            // Only show offices matching current parent level
            if (($office['parent_id'] === $parentId) || ($parentId === null && empty($office['parent_id']))) {
                // Create display name with hierarchy using code
                $displayName = $prefix . $office['code'] . ' (' . $office['type'] . ')';
                
                // Create a new object with display_name
                $officeObj = (object) $office;
                $officeObj->display_name = $displayName;
                $result[] = $officeObj;
                
                // Recursively add children with increased indentation
                $childResult = $this->formatOfficesHierarchy(
                    $offices, 
                    $office['id'], 
                    $prefix . '&nbsp;&nbsp;&nbsp;'
                );
                // Convert collection to array for merging
                $result = array_merge($result, $childResult->toArray());
            }
        }
        
        return collect($result);
    }
}
