@extends('layouts.app')

@section('content')
<style>
    @media print {
        @page { size: A4 portrait; margin: 0.4in 0.5in; }
        body { background: white !important; color: #000 !important; }
        .print-container { width: 100% !important; max-width: 100% !important; margin: 0 !important; padding: 0 !important; }
        
        .header-block { 
            border-bottom: 2px solid #000 !important;
            margin-bottom: 2mm !important;
        }
        
        .print-table { 
            border: 1px solid #333 !important; 
            border-collapse: collapse !important;
            width: 100%;
        }
        .print-table th, .print-table td { 
            border: 1px solid #333 !important; 
            padding: 1mm 2mm !important;
            font-size: 9pt !important;
        }
        
        .signature-line {
            border-bottom: 1px solid #000 !important;
        }
    }
    
    /* Screen-only styles for editable cells */
    .editable-cell[contenteditable="true"] {
        background-color: #fef3c7;
        padding: 4px 8px;
        border-radius: 4px;
        outline: 2px solid #f59e0b;
    }
</style>

<div class="mb-8 print:hidden">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
        <div>
            <nav class="flex mb-2" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('transmittals.index') }}" class="text-navy hover:text-navy-light font-medium text-sm flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                            Ledger
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-slate-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="ml-1 text-sm font-medium text-slate-500 md:ml-2">View #{{ $transmittal->reference_number }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h2 class="text-2xl font-extrabold text-navy">Record Insights</h2>
        </div>
        <div class="flex items-center gap-2">
            @can('update', $transmittal)
                <button id="toggleEditBtn" onclick="toggleEditMode()" class="px-4 py-2 bg-white border border-slate-200 text-slate-700 rounded-xl hover:bg-slate-50 font-medium transition-colors flex items-center shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    <span id="editBtnText">Edit Table</span>
                </button>
            @endcan
            <button onclick="window.print()" class="px-4 py-2 bg-navy text-white rounded-xl hover:bg-navy-light font-bold shadow-lg shadow-navy/20 transition-all flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Print
            </button>
            <a href="{{ route('transmittals.pdf', $transmittal) }}" class="px-3 py-2 bg-white border border-slate-200 text-slate-700 rounded-xl hover:bg-slate-50 transition-colors shadow-sm" title="Download PDF">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 mb-6 print:shadow-none print:border-none">
            <div class="p-8 print:p-0 print-container">
                <!-- Government Style Header -->
                <div class="relative border-b-2 border-slate-900 pb-4 mb-6 text-center header-block">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-white p-1 border border-slate-200 print:border-slate-300">
                        <img src="{{ $qrcode }}" alt="Verification QR" class="w-full h-full object-contain">
                    </div>
                    
                    <h5 class="font-bold text-lg mb-1 print:text-[10pt] print:mb-0">
                        @php $displayOffice = $transmittal->senderOffice->getDisplayOffice(); @endphp
                        @if($displayOffice->type === 'Regional')
                            DTI - Regional Office 6
                        @else
                            DTI - {{ str_ireplace('DTI ', '', $displayOffice->name) }}
                        @endif
                    </h5>
                    <p class="text-slate-500 text-sm mb-1 print:text-[8pt] print:mb-0">Region VI - Western Visayas</p>
                    <h4 class="font-extrabold text-2xl uppercase tracking-wide mt-2 mb-1 print:text-[14pt] print:mt-1">Transmittal Form</h4>
                    <p class="text-slate-500 text-sm print:text-[9pt]">Ref: <span class="font-bold text-navy print:text-black">{{ $transmittal->reference_number }}</span></p>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-6 print:gap-0 print:mb-2">
                    <div>
                        <div class="text-xs font-bold uppercase text-slate-500 mb-1 print:mb-0 print:text-[8pt]">Originating Office</div>
                        <div class="text-lg font-bold mb-1 print:text-[10pt]">{{ $transmittal->senderOffice->code }}</div>
                        <div class="text-xs text-slate-500 print:text-[8pt]">Sent by: {{ $transmittal->sender->name }}</div>
                        <div class="text-xs text-slate-500 print:text-[8pt]">Date: {{ \Carbon\Carbon::parse($transmittal->transmittal_date)->format('F d, Y') }}</div>
                    </div>
                    <div class="text-right">
                        <div class="text-xs font-bold uppercase text-slate-500 mb-1 print:mb-0 print:text-[8pt]">Destination Office</div>
                        <div class="text-lg font-bold mb-1 print:text-[10pt]">{{ $transmittal->receiverOffice->code }}</div>
                        <div class="mt-2 text-right print:hidden">
                            @php
                                $statusColors = [
                                    'Draft' => 'slate',
                                    'Submitted' => 'amber',
                                    'Received' => 'emerald',
                                    'Returned' => 'rose'
                                ];
                                $color = $statusColors[$transmittal->status] ?? 'slate';
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $color }}-100 text-{{ $color }}-800">
                                {{ $transmittal->status }}
                            </span>
                        </div>
                        <div class="hidden print:block text-[9pt] mt-1 text-slate-600">
                            Status: <strong>{{ strtoupper($transmittal->status) }}</strong>
                        </div>
                    </div>
                </div>

                <div class="w-full h-px bg-slate-300 mb-4 hidden print:block"></div>

                <div class="overflow-x-auto print:overflow-visible mb-4">
                    <table class="w-full text-left border-collapse print-table">
                        <thead>
                            <tr class="bg-slate-50 print:bg-slate-100 border border-slate-200">
                                <th class="px-4 py-2 border-b border-slate-200 text-xs font-bold uppercase text-slate-500 text-center w-24 print:w-[15%]">Qty</th>
                                <th class="px-4 py-2 border-b border-slate-200 text-xs font-bold uppercase text-slate-500 text-center w-24 print:w-[15%]">Unit</th>
                                <th class="px-4 py-2 border-b border-slate-200 text-xs font-bold uppercase text-slate-500 text-center print:w-[40%]">Description of Items / Particulars</th>
                                <th class="px-4 py-2 border-b border-slate-200 text-xs font-bold uppercase text-slate-500 text-center print:w-[30%]">Item Remarks</th>
                            </tr>
                        </thead>
                        <tbody id="itemsTableBody">
                            @php
                                $items = $transmittal->items->values();
                                $rowCount = max(10, count($items));
                            @endphp
                            @for($i = 0; $i < $rowCount; $i++)
                                @if(isset($items[$i]))
                                    @php $item = $items[$i]; @endphp
                                    <tr class="border-b border-slate-100 print:border-slate-300" data-item-id="{{ $item->id }}">
                                        <td class="px-4 py-2 text-center font-bold text-navy print:text-black">
                                            <span class="editable-cell" contenteditable="false" data-field="quantity">{{ $item->quantity }}</span>
                                        </td>
                                        <td class="px-4 py-2 text-center text-slate-600 print:text-black">
                                            <span class="editable-cell" contenteditable="false" data-field="unit">{{ $item->unit }}</span>
                                        </td>
                                        <td class="px-4 py-2 font-medium text-slate-700 print:text-black">
                                            <span class="editable-cell" contenteditable="false" data-field="description">{{ $item->description }}</span>
                                        </td>
                                        <td class="px-4 py-2 text-slate-500 italic text-sm print:text-black">
                                            <span class="editable-cell" contenteditable="false" data-field="remarks">{{ $item->remarks ?? '' }}</span>
                                        </td>
                                    </tr>
                                @else
                                    <tr class="border-b border-slate-100 print:border-slate-300 h-10">
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                @endif
                            @endfor
                        </tbody>
                    </table>
                </div>

                @if($transmittal->remarks)
                <div class="mb-4 text-sm print:text-[9pt]">
                    <span class="font-bold uppercase text-slate-500 mr-2">Executive Remarks:</span>
                    <span class="text-slate-800 font-medium">{{ $transmittal->remarks }}</span>
                </div>
                @endif
                
                <div class="grid grid-cols-2 gap-8 mt-8 pt-4">
                    <div>
                        <div class="text-xs font-bold uppercase text-slate-500 mb-6 print:mb-2 print:text-[8pt]">For Transmitting Office:</div>
                        <div class="mb-6 h-8 print:hidden"></div> <!-- Spacer for screen -->
                        <div class="border-b border-slate-900 mb-2 signature-line"></div>
                        <div class="text-center text-xs font-bold text-slate-600 print:text-[8pt]">Name / Signature</div>
                        <div class="mt-4 text-sm print:text-[9pt]">
                            <span class="font-bold mr-2">Date:</span>
                            <span class="inline-block border-b border-slate-800 px-2 min-w-[120px]">
                                {{ \Carbon\Carbon::parse($transmittal->transmittal_date)->format('M d, Y') }}
                            </span>
                        </div>
                    </div>
                    <div class="border-l border-slate-200 pl-8 print:border-slate-300">
                        <div class="text-xs font-bold uppercase text-slate-500 mb-6 print:mb-2 print:text-[8pt]">For Receiving Office:</div>
                        <div class="text-sm mb-6 print:mb-2 print:text-[9pt]">Received by:</div>
                        <div class="border-b border-slate-900 mb-2 signature-line"></div>
                        <div class="text-center text-xs font-bold text-slate-600 print:text-[8pt]">Name / Signature</div>
                        <div class="mt-4 text-sm print:text-[9pt]">
                            <span class="font-bold mr-2">Date:</span>
                            <span class="inline-block border-b border-slate-800 px-2 min-w-[120px]">
                                {{ $transmittal->received_at ? \Carbon\Carbon::parse($transmittal->received_at)->format('M d, Y') : '________________' }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-slate-200 text-xs text-slate-500 print:text-[8pt] print:mt-4 print:pt-2">
                    <div class="text-center font-bold uppercase mb-2">Instructions</div>
                    <ol class="list-decimal pl-4 space-y-1">
                        <li>Prepare the transmittal in triplicate. Retain the third copy for your records.</li>
                        <li>Send the original and duplicate together with the materials to the receiving office.</li>
                        <li>Request the receiving office to sign and return the duplicate.</li>
                        <li>Log the transmittal in the DTI6 Transmittal System immediately after sending.</li>
                        <li>Mark the transmittal as "Received" in the system to complete the workflow.</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar Actions -->
    <div class="lg:col-span-1 print:hidden">
        <div class="bg-gradient-to-br from-white to-slate-50 rounded-2xl shadow-sm border border-slate-100 p-6 mb-6">
            <div class="flex items-center text-navy font-bold mb-4">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                Status Protocol
            </div>
            
            <div class="space-y-3">
                @if($transmittal->status != 'Received')
                    @can('receive', $transmittal)
                        <button type="button" 
                            class="w-full py-3 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl font-bold shadow-lg shadow-emerald-500/20 transition-all transform hover:-translate-y-0.5 flex items-center justify-center"
                            data-bs-toggle="modal" 
                            data-bs-target="#confirmationModal"
                            data-action="{{ route('transmittals.receive', $transmittal) }}"
                            data-method="PATCH"
                            data-title="Acknowledge Receipt"
                            data-message="By confirming, you officially acknowledge that you have physically received the hard copy documents for Transmittal #{{ $transmittal->reference_number }}."
                            data-btn-class="btn-success"
                            data-btn-text="Confirm Receipt">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Mark as Received
                        </button>
                    @endcan

                    @can('delete', $transmittal)
                        <button type="button" 
                            class="w-full py-2 bg-white border border-red-200 text-red-500 hover:bg-red-50 rounded-xl font-bold transition-colors flex items-center justify-center"
                            data-bs-toggle="modal" 
                            data-bs-target="#confirmationModal"
                            data-action="{{ route('transmittals.destroy', $transmittal) }}"
                            data-method="DELETE"
                            data-title="Confirm Delete"
                            data-message="Are you sure you want to permanently delete this transmittal record? This action cannot be undone."
                            data-btn-class="btn-danger"
                            data-btn-text="Delete Record">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            Delete Record
                        </button>
                    @endcan

                    @if($transmittal->status != 'Received' && !Auth::user()->can('receive', $transmittal))
                        <div class="bg-blue-50 text-blue-700 p-4 rounded-xl text-sm flex items-start">
                            <svg class="w-5 h-5 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>Awaiting action from <strong>{{ $transmittal->receiverOffice->code }}</strong>.</span>
                        </div>
                    @endif
                @else
                    <div class="bg-emerald-50 text-emerald-700 p-6 rounded-xl text-center">
                        <svg class="w-12 h-12 mx-auto mb-2 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        <h5 class="font-bold text-lg mb-1">Receipt Confirmed</h5>
                        <p class="text-sm opacity-75">Processed on {{ \Carbon\Carbon::parse($transmittal->received_at)->format('M d, Y H:i') }}</p>
                    </div>
                @endif
                
                <div class="pt-4 mt-4 border-t border-slate-100">
                    <a href="{{ route('transmittals.create') }}" class="block w-full text-center py-2 text-slate-500 hover:text-navy font-medium text-sm transition-colors">
                        Create New Entry
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center text-slate-700 font-bold">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Audit Trail
            </div>
            <div class="divide-y divide-slate-50">
                @foreach($transmittal->logs as $log)
                <div class="p-4 hover:bg-slate-50 transition-colors">
                    <div class="flex justify-between items-start mb-1">
                        <span class="font-bold text-navy text-sm">{{ $log->action }}</span>
                        <span class="text-xs text-slate-400">{{ $log->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-sm text-slate-600 mb-1">{{ $log->description }}</p>
                    <div class="text-xs text-slate-400 font-medium">- {{ $log->user->name }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
let isEditMode = false;

function toggleEditMode() {
    isEditMode = !isEditMode;
    const editableCells = document.querySelectorAll('.editable-cell');
    const toggleBtn = document.getElementById('toggleEditBtn');
    const btnText = document.getElementById('editBtnText');
    
    editableCells.forEach(cell => {
        cell.contentEditable = isEditMode;
        // Styles are handled by CSS class and contenteditable attribute selector now
    });
    
    if (isEditMode) {
        toggleBtn.classList.remove('bg-white', 'text-slate-700', 'border-slate-200');
        toggleBtn.classList.add('bg-emerald-500', 'text-white', 'border-transparent', 'hover:bg-emerald-600');
        btnText.textContent = 'Save Changes';
    } else {
        saveAllChanges();
        toggleBtn.classList.remove('bg-emerald-500', 'text-white', 'border-transparent', 'hover:bg-emerald-600');
        toggleBtn.classList.add('bg-white', 'text-slate-700', 'border-slate-200');
        btnText.textContent = 'Edit Table';
    }
}

function saveAllChanges() {
    const rows = document.querySelectorAll('#itemsTableBody tr');
    const updates = [];
    
    rows.forEach(row => {
        const itemId = row.getAttribute('data-item-id');
        if (!itemId) return;
        
        const cells = row.querySelectorAll('.editable-cell');
        const itemData = { id: itemId };
        
        cells.forEach(cell => {
            const field = cell.getAttribute('data-field');
            let value = cell.textContent.trim();
            if (value === '') value = null;
            itemData[field] = value;
        });
        
        updates.push(itemData);
    });
    
    fetch('{{ route("transmittals.update-items", $transmittal) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ items: updates })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Alpine.store('toast').show({ type: 'success', message: 'Changes saved successfully!' });
        } else {
            Alpine.store('toast').show({ type: 'error', message: 'Error saving changes.' });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Alpine.store('toast').show({ type: 'error', message: 'Error saving changes.' });
    });
}
</script>
@endsection
