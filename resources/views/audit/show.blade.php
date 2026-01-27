@extends('layouts.app')

@section('content')
<div class="mb-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-1">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-navy">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('audit.index') }}" class="text-navy">Audit History</a></li>
            <li class="breadcrumb-item active">Audit Details</li>
        </ol>
    </nav>
    <h2 class="fw-extrabold mb-0">Audit Log Details</h2>
    <p class="text-muted">Detailed information about this system action.</p>
</div>

<div class="row">
    <div class="col-lg-9 mx-auto">
        <!-- Main Audit Details Card -->
        <div class="card shadow-sm border-0 rounded-4 mb-4">
            <div class="card-body p-5">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-uppercase text-muted mb-2">Action Type</label>
                            <div>
                                <span class="badge rounded-pill px-3 py-2 {{ 
                                    $log->action === 'Submitted' ? 'bg-primary bg-opacity-10 text-primary' : 
                                    ($log->action === 'Received' ? 'bg-success bg-opacity-10 text-success' : 
                                    ($log->action === 'Edited' ? 'bg-warning bg-opacity-10 text-warning' :
                                    'bg-secondary bg-opacity-10 text-secondary')) 
                                }} fs-5">
                                    {{ $log->action }}
                                </span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-uppercase text-muted mb-2">Reference Number</label>
                            <div>
                                @if($log->transmittal)
                                <a href="{{ route('transmittals.show', $log->transmittal) }}" class="text-navy fw-bold text-decoration-none fs-5">
                                    {{ $log->transmittal->reference_number }}
                                </a>
                                @else
                                <span class="text-muted">N/A</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-uppercase text-muted mb-2">Timestamp</label>
                            <div>
                                <div class="fw-bold fs-5">{{ $log->created_at->format('F d, Y') }}</div>
                                <div class="text-muted">{{ $log->created_at->format('h:i A') }}</div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-uppercase text-muted mb-2">Performed By</label>
                            <div>
                                <div class="fw-bold fs-5">{{ $log->user->name }}</div>
                                <div class="text-muted small">{{ $log->user->email }}</div>
                                @if($log->user->office)
                                <div class="text-muted small">
                                    <span class="badge bg-light text-navy border font-monospace">{{ $log->user->office->code }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Transmittal Information -->
                @if($log->transmittal)
                <div class="mb-4">
                    <h5 class="fw-bold mb-3">Transmittal Information</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-uppercase text-muted mb-2">Origin Office</label>
                                <div>
                                    @if($log->transmittal->senderOffice)
                                    <div class="fw-bold">{{ $log->transmittal->senderOffice->name }}</div>
                                    <div class="text-muted small">
                                        <span class="badge bg-light text-navy border font-monospace">{{ $log->transmittal->senderOffice->code }}</span>
                                    </div>
                                    @else
                                    <span class="text-muted">N/A</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-uppercase text-muted mb-2">Destination Office</label>
                                <div>
                                    @if($log->transmittal->receiverOffice)
                                    <div class="fw-bold">{{ $log->transmittal->receiverOffice->name }}</div>
                                    <div class="text-muted small">
                                        <span class="badge bg-light text-secondary border font-monospace">{{ $log->transmittal->receiverOffice->code }}</span>
                                    </div>
                                    @else
                                    <span class="text-muted">N/A</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-uppercase text-muted mb-2">Transmittal Date</label>
                                <div>
                                    <span class="fw-bold">{{ \Carbon\Carbon::parse($log->transmittal->transmittal_date)->format('F d, Y') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-uppercase text-muted mb-2">Status</label>
                                <div>
                                    <span class="badge rounded-pill px-3 py-2 {{ 
                                        $log->transmittal->status === 'Draft' ? 'bg-secondary bg-opacity-10 text-secondary' : 
                                        ($log->transmittal->status === 'Submitted' ? 'bg-primary bg-opacity-10 text-primary' :
                                        'bg-success bg-opacity-10 text-success')
                                    }}">
                                        {{ $log->transmittal->status }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Items -->
                @if($log->transmittal->items->count() > 0)
                <div class="mb-4">
                    <h5 class="fw-bold mb-3">Items in Transmittal</h5>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Description</th>
                                    <th class="text-center">Qty</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($log->transmittal->items as $item)
                                <tr>
                                    <td class="fw-bold">{{ $item->description }}</td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td><span class="text-muted small">{{ $item->remarks ?? 'N/A' }}</span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <hr class="my-4">
                @endif
                @endif

                <!-- Description -->
                <div class="mb-4">
                    <label class="form-label small fw-bold text-uppercase text-muted mb-2">Action Description</label>
                    <div class="p-3 bg-light rounded border">
                        <p class="mb-0 text-dark">{{ $log->description }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="d-flex gap-2">
            @if($log->transmittal && Auth::user()->hasAnyRole(['Super Admin', 'Regional MIS']))
            <a href="{{ route('transmittals.show', $log->transmittal) }}" class="btn btn-navy rounded-pill px-4">
                <i class="bi bi-eye me-2"></i>View Transmittal
            </a>
            @endif
            <a href="{{ route('audit.index') }}" class="btn btn-outline-navy rounded-pill px-4">
                <i class="bi bi-arrow-left me-2"></i>Back to Audit History
            </a>
        </div>
    </div>
</div>

<style>
    .bg-navy { background-color: #001f3f !important; }
    .text-navy { color: #001f3f !important; }
    .btn-navy { background-color: #001f3f; border-color: #001f3f; }
    .btn-navy:hover { background-color: #001226; border-color: #001226; }
    .btn-outline-navy { color: #001f3f; border-color: #001f3f; }
    .btn-outline-navy:hover { background-color: #001f3f; border-color: #001f3f; color: white; }
</style>
@endsection
