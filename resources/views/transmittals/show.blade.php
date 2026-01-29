@extends('layouts.app')

@section('content')
<style>
    @media print {
        @page { size: A4 portrait; margin: 0.4in 0.5in; }
        .no-print { display: none !important; }
        .card { border: none !important; box-shadow: none !important; margin: 0 !important; page-break-inside: avoid; }
        .card-body { padding: 0 !important; }
        body { background: white !important; padding: 0 !important; color: #000 !important; }
        .container { max-width: 100% !important; width: 100% !important; margin: 0 !important; padding: 0 !important; }
        
        .header-block { 
            height: auto !important; 
            padding-bottom: 5mm !important;
            margin-bottom: 1mm !important;
            border-bottom: 1.5pt solid #000 !important;
            text-align: center !important;
            position: relative !important;
        }
        .header-block h5 { font-size: 10pt !important; margin-bottom: 0.5mm !important; line-height: 1.2 !important; }
        .header-block p { font-size: 8pt !important; margin-bottom: 0.3mm !important; line-height: 1.1 !important; }
        .qr-code-print {
            position: absolute !important;
            top: 0 !important;
            right: 0 !important;
            width: 25mm !important;
            height: 25mm !important;
        }
        
        .divider-line { 
            margin: 1mm 0 !important; 
            border-top: 0.5pt solid #999 !important;
            width: 100%;
        }

        
        .node-section { 
            height: auto !important;
            min-height: 28mm !important;
            margin-bottom: 1mm !important;
        }
        .node-section .row { line-height: 1.05 !important; margin-bottom: 0.5mm !important; }
        .node-section .h5 { font-size: 9pt !important; margin-bottom: 0.5mm !important; }
        .node-section .small { font-size: 7.5pt !important; margin-bottom: 0 !important; }
        
        .table { 
            border: 0.5pt solid #333 !important; 
            margin-top: 1mm !important;
            margin-bottom: 2mm !important;
            border-collapse: collapse !important;
        }
        .table th { 
            padding: 1mm 1.5mm !important; 
            border: 0.5pt solid #333 !important; 
            font-size: 7.5pt !important; 
            line-height: 1 !important;
            background-color: #f5f5f5 !important;
        }
        .table td { 
            padding: 1mm 1.5mm !important; 
            border: 0.5pt solid #333 !important; 
            height: auto !important;
            min-height: 5mm !important;
            font-size: 7.5pt !important;
            line-height: 1.1 !important;
            vertical-align: top !important;
        }
        
        .signature-section { margin-top: 2mm !important; }
        .signature-underline { 
            border-bottom: 0.75pt solid #000 !important; 
            min-height: 6mm !important; 
            margin-bottom: 1mm !important; 
        }
        .signature-section .small { font-size: 7pt !important; }
        .instructions-section { 
            font-size: 9pt !important; 
            margin-top: 3mm !important; 
            opacity: 0.8; 
            line-height: 1.2 !important;
        }
        
        .row { display: flex !important; flex-wrap: nowrap !important; }
        .col-6, .col-sm-6 { width: 50% !important; flex: 0 0 50% !important; max-width: 50% !important; }
        .text-sm-end { text-align: right !important; }
        
        /* Ensure single page */
        * { page-break-inside: avoid !important; }
        .table { page-break-inside: auto !important; }
        tr { page-break-inside: avoid !important; page-break-after: auto !important; }
    }

    /* Compact Table Styles */
    .table-compact {
        font-size: 0.875rem !important;
    }
    .table-compact th {
        padding: 0.4rem 0.6rem !important;
        font-weight: 700 !important;
        text-transform: uppercase;
        font-size: 0.75rem !important;
        letter-spacing: 0.025em;
    }
    .table-compact td {
        padding: 0.4rem 0.6rem !important;
        line-height: 1.3 !important;
    }
    .editable-cell {
        display: block;
        min-height: 1.2em;
    }
    .empty-row td {
        padding: 0.3rem !important;
        height: 1.5rem !important;
    }
    .signature-underline { 
        border-bottom: 2px solid #000; 
        min-height: 30px; 
        margin-bottom: 5px; 
    }
    
    .header-block-container {
        position: relative;
        padding-bottom: 1rem;
        border-bottom: 1.5pt solid #000;
        margin-bottom: 1.5rem;
    }
    
    .qr-code-display {
        position: absolute;
        top: 0;
        right: 0;
        width: 100px;
        height: 100px;
        background: white;
        padding: 4px;
        border: 1px solid #eee;
    }
</style>
<div class="d-flex justify-content-between align-items-end mb-4 no-print">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-1">
                <li class="breadcrumb-item"><a href="{{ route('transmittals.index') }}" class="text-navy">Ledger</a></li>
                <li class="breadcrumb-item active">View #{{ $transmittal->reference_number }}</li>
            </ol>
        </nav>
        <h2 class="fw-extrabold mb-0">Record Insights</h2>
    </div>
    <div class="btn-group shadow-sm" style="border-radius: 0.75rem; overflow: hidden;">
        @can('update', $transmittal)
            <button id="toggleEditBtn" onclick="toggleEditMode()" class="btn btn-white border d-flex align-items-center px-4">
                <i class="bi bi-pencil-square me-2"></i><span id="editBtnText">Edit Table</span>
            </button>
        @endcan
        <button onclick="window.print()" class="btn btn-navy d-flex align-items-center px-4">
            <i class="bi bi-printer me-2"></i>Print
        </button>
        <a href="{{ route('transmittals.pdf', $transmittal) }}" class="btn btn-white border border-start-0 px-3" title="Download PDF">
            <i class="bi bi-download"></i>
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card shadow-sm mb-4">
            <div class="card-body p-5">
                <!-- Government Style Header for Show and Print -->
                <div class="header-block-container text-center">
                    <div class="qr-code-display">
                        <img src="{{ $qrcode }}" alt="Verification QR" style="width: 100%; height: 100%;">
                    </div>
                    
                    <h5 class="fw-bold mb-1">
                        @php
                            $displayOffice = $transmittal->senderOffice->getDisplayOffice();
                        @endphp
                        @if($displayOffice->type === 'Regional')
                            DTI - Regional Office 6
                        @else
                            DTI - {{ str_ireplace('DTI ', '', $displayOffice->name) }}
                        @endif
                    </h5>
                    <p class="text-muted small mb-0">Region VI - Western Visayas</p>
                    <h4 class="fw-extrabold mt-2 text-uppercase mb-1" style="font-size: 1.4rem;">Transmittal Form</h4>
                    <p class="text-muted small mb-0">Ref: <span class="fw-bold text-navy">{{ $transmittal->reference_number }}</span></p>
                </div>

                <div class="node-section">
                    <div class="row g-0">
                        <div class="col-sm-6">
                            <div class="small fw-bold text-uppercase text-muted mb-2">Originating Office</div>
                            <div class="h5 fw-bold mb-1">{{ $transmittal->senderOffice->code }}</div>
                            <div class="small text-muted">Sent by: {{ $transmittal->sender->name }}</div>
                            <div class="small text-muted">Date: {{ \Carbon\Carbon::parse($transmittal->transmittal_date)->format('F d, Y') }}</div>
                        </div>
                        <div class="col-sm-6 text-sm-end">
                            <div class="small fw-bold text-uppercase text-muted mb-2">Destination Office</div>
                            <div class="h5 fw-bold mb-1">{{ $transmittal->receiverOffice->code }}</div>
                            <div class="mt-2 text-sm-end no-print">
                                <span class="status-badge bg-{{ strtolower($transmittal->status) }} fs-6">
                                    {{ $transmittal->status }}
                                </span>
                            </div>
                            <div class="small text-muted mt-1 print-only d-none d-print-block">
                                Status: <strong>{{ strtoupper($transmittal->status) }}</strong>
                            </div>
                        </div>
                    </div>
                    <div class="divider-line print-only d-none d-print-block"></div>
                </div>

                <div class="table-responsive mt-2">
                    <table class="table table-bordered table-sm table-compact align-middle">
                        <thead class="bg-light">
                            <tr class="small text-uppercase">
                                <th width="100" class="text-center">Qty</th>
                                <th width="100" class="text-center">Unit</th>
                                <th class="text-center">Description of Items / Particulars</th>
                                <th class="text-center">Item Remarks</th>
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
                                    <tr data-item-id="{{ $item->id }}">
                                        <td class="text-center fw-bold">
                                            <span class="editable-cell" contenteditable="false" data-field="quantity">{{ $item->quantity }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="editable-cell" contenteditable="false" data-field="unit">{{ $item->unit }}</span>
                                        </td>
                                        <td class="py-3">
                                            <div class="fw-medium">
                                                <span class="editable-cell" contenteditable="false" data-field="description">{{ $item->description }}</span>
                                            </div>
                                        </td>
                                        <td class="text-muted small italic">
                                            <span class="editable-cell" contenteditable="false" data-field="remarks">{{ $item->remarks ?? '' }}</span>
                                        </td>
                                    </tr>
                                @else
                                    <tr class="empty-row">
                                        <td class="text-center">&nbsp;</td>
                                        <td class="text-center">&nbsp;</td>
                                        <td class="py-3">&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                @endif
                            @endfor
                        </tbody>
                    </table>
                </div>

                @if($transmittal->remarks)
                <div class="mt-2 mb-1">
                    <span class="fw-bold text-uppercase text-muted" style="font-size: 0.8rem;">Executive Remarks:</span>
                    <span class="text-dark ms-2 fw-medium" style="font-size: 0.8rem;">{{ $transmittal->remarks }}</span>
                </div>
                @endif
                
                <div class="signature-section row mt-1 pt-1 g-5">
                    <div class="col-6">
                        <div class="fw-bold small text-uppercase mb-2">For Transmitting Office:</div>
                        <div class="small mb-2 invisible d-print-none" aria-hidden="true">&nbsp;</div>
                        <div class="small mb-2 d-none d-print-block opacity-0">&nbsp;</div>
                        <div class="signature-underline mb-2"></div>
                        <div class="text-center small fw-bold">Name / Signature</div>
                        <div class="mt-4">
                            <span class="small fw-bold">Date:</span>
                            <span class="border-bottom border-dark d-inline-block px-2 small" style="min-width: 150px;">
                                {{ \Carbon\Carbon::parse($transmittal->transmittal_date)->format('M d, Y') }}
                            </span>
                        </div>
                    </div>
                    <div class="col-6 border-start ps-5">
                        <div class="fw-bold small text-uppercase mb-2">For Receiving Office:</div>
                        <div class="small mb-2">Received by:</div>
                        <div class="signature-underline mb-2"></div>
                        <div class="text-center small fw-bold">Name / Signature</div>
                        <div class="mt-4">
                            <span class="small fw-bold">Date:</span>
                            <span class="border-bottom border-dark d-inline-block px-2 small" style="min-width: 150px;">
                                {{ $transmittal->received_at ? \Carbon\Carbon::parse($transmittal->received_at)->format('M d, Y') : '________________' }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="mt-5 pt-4 border-top instructions-section">
                    <div class="text-center fw-bold small text-uppercase mb-3">Instructions</div>
                    <ol class="small text-muted ps-3">
                        <li>Prepare the transmittal in triplicate. Retain the third copy for your records.</li>
                        <li>Send the original and duplicate together with the materials to the receiving office.</li>
                        <li>Request the receiving office to sign and return the duplicate.</li>
                        <li>Log the transmittal in the DTI6 Transmittal System immediately after sending, including reference number, date, sending office, and items.</li>
                        <li>Monitor the status in the system to track submission and receiving confirmation.</li>
                        <li>Once the receiving office returns the signed duplicate, update the transmittal in the system with received date, receiver name, and any remarks.</li>
                        <li>Mark the transmittal as “Received” in the system to complete the workflow, ensuring both digital and printed records are synchronized.</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 no-print">
        <div class="card shadow-sm border-0 bg-transparent mb-4">
            <div class="card-header bg-white rounded-top-4 border-0">
                <i class="bi bi-shield-lock me-2"></i>Status Protocol
            </div>
            <div class="card-body bg-white rounded-bottom-4">
                @if($transmittal->status != 'Received')
                    @can('receive', $transmittal)
                        <div class="d-grid mb-3">
                            <button type="button" 
                                class="btn btn-success py-3 fw-bold text-white shadow-sm"
                                data-bs-toggle="modal" 
                                data-bs-target="#confirmationModal"
                                data-action="{{ route('transmittals.receive', $transmittal) }}"
                                data-method="PATCH"
                                data-title="Acknowledge Receipt"
                                data-message="By confirming, you officially acknowledge that you have physically received the hard copy documents for Transmittal #{{ $transmittal->reference_number }}."
                                data-btn-class="btn-success"
                                data-btn-text="Confirm Receipt">
                                <i class="bi bi-check-circle-fill me-2"></i>Mark as Received
                            </button>
                        </div>
                    @endcan

                    @can('delete', $transmittal)
                        <div class="d-grid mb-4">
                            <button type="button" 
                                class="btn btn-outline-danger py-2 fw-bold"
                                data-bs-toggle="modal" 
                                data-bs-target="#confirmationModal"
                                data-action="{{ route('transmittals.destroy', $transmittal) }}"
                                data-method="DELETE"
                                data-title="Confirm Delete"
                                data-message="Are you sure you want to permanently delete this transmittal record? This action cannot be undone."
                                data-btn-class="btn-danger"
                                data-btn-text="Delete Record">
                                <i class="bi bi-trash-fill me-2"></i>Delete Record
                            </button>
                        </div>
                    @endcan

                    @if($transmittal->status != 'Received' && !Auth::user()->can('receive', $transmittal))
                        <div class="alert alert-info border-0 rounded-4 mb-4 small">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            Awaiting action from <strong>{{ $transmittal->receiverOffice->code }}</strong>.
                        </div>
                    @endif
                @else
                    <div class="text-center py-4 bg-success bg-opacity-10 rounded-4 text-success mb-4">
                        <i class="bi bi-patch-check-fill fs-1 mb-2"></i>
                        <h5 class="fw-bold mb-1">Receipt Confirmed</h5>
                        <p class="small mb-0 opacity-75">Processed on {{ \Carbon\Carbon::parse($transmittal->received_at)->format('M d, Y H:i') }}</p>
                    </div>
                @endif
                
                <div class="d-flex flex-column gap-2 text-center">
                    <a href="{{ route('transmittals.create') }}" class="btn btn-light rounded-pill small">Create New Entry</a>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-0">
                <i class="bi bi-clock-history me-2"></i>Audit Trail
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush small">
                    @foreach($transmittal->logs as $log)
                    <div class="list-group-item px-4 py-3 border-light">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="fw-bold text-navy">{{ $log->action }}</span>
                            <span class="text-muted" style="font-size: 0.7rem;">{{ $log->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="mb-1 text-muted">{{ $log->description }}</p>
                        <div class="small fw-medium opacity-50">- {{ $log->user->name }}</div>
                    </div>
                    @endforeach
                </div>
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
        if (isEditMode) {
            cell.style.backgroundColor = '#fef3c7';
            cell.style.padding = '4px 8px';
            cell.style.borderRadius = '4px';
            cell.style.minHeight = '30px';
            cell.style.display = 'inline-block';
            cell.style.minWidth = '50px';
        } else {
            cell.style.backgroundColor = '';
            cell.style.padding = '';
            cell.style.borderRadius = '';
            cell.style.minHeight = '';
            cell.style.display = '';
            cell.style.minWidth = '';
        }
    });
    
    if (isEditMode) {
        toggleBtn.classList.remove('btn-white');
        toggleBtn.classList.add('btn-success');
        btnText.textContent = 'Save Changes';
    } else {
        saveAllChanges();
        toggleBtn.classList.remove('btn-success');
        toggleBtn.classList.add('btn-white');
        btnText.textContent = 'Edit Table';
    }
}

function saveAllChanges() {
    const rows = document.querySelectorAll('#itemsTableBody tr');
    const updates = [];
    
    rows.forEach(row => {
        const itemId = row.getAttribute('data-item-id');
        if (!itemId) return; // Skip empty placeholder rows
        
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
    
    // Send AJAX request to save changes
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
            // Show success message
            showNotification('Changes saved successfully!', 'success');
        } else {
            showNotification('Error saving changes', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Error saving changes', 'error');
    });
}

function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type === 'success' ? 'success' : 'danger'} position-fixed top-0 start-50 translate-middle-x mt-3 shadow-lg`;
    notification.style.zIndex = '9999';
    notification.textContent = message;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}
</script>
@endsection
