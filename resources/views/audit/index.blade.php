@extends('layouts.app')

@section('content')
<div class="mb-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-1">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-navy">Dashboard</a></li>
            <li class="breadcrumb-item active">Audit History</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2 class="fw-extrabold mb-0">System Audit Trail</h2>
            <p class="text-muted">Comprehensive record of all transmittal modifications and movements.</p>
        </div>
        <div class="badge bg-navy px-3 py-2 rounded-pill">
            <i class="bi bi-shield-check me-1"></i> Secure Logs
        </div>
    </div>
</div>

@if(Auth::user()->hasRole('admin'))
<div class="card shadow-sm border-0 rounded-4 mb-4">
    <div class="card-body p-4">
        <form action="{{ route('audit.index') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <label class="form-label small fw-bold text-uppercase text-muted">Search Records</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control border-start-0" placeholder="Ref # or description..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-bold text-uppercase text-muted">Office</label>
                <select name="office_id" class="form-select">
                    <option value="">All Offices</option>
                    @foreach($offices as $office)
                        <option value="{{ $office->id }}" {{ request('office_id') == $office->id ? 'selected' : '' }}>
                            {{ $office->code }} - {{ $office->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-bold text-uppercase text-muted">Action Protocol</label>
                <select name="action" class="form-select">
                    <option value="">All Actions</option>
                    <option value="Submitted" {{ request('action') == 'Submitted' ? 'selected' : '' }}>Submitted</option>
                    <option value="Received" {{ request('action') == 'Received' ? 'selected' : '' }}>Received</option>
                    <option value="Edited" {{ request('action') == 'Edited' ? 'selected' : '' }}>Edited</option>
                    <option value="Draft" {{ request('action') == 'Draft' ? 'selected' : '' }}>Drafted</option>
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end gap-2">
                <button type="submit" class="btn btn-navy flex-grow-1">Filter</button>
                <a href="{{ route('audit.index') }}" class="btn btn-light" title="Clear Filters"><i class="bi bi-arrow-counterclockwise"></i></a>
            </div>
        </form>
    </div>
</div>
@endif

<div class="card shadow-sm border-0 rounded-4 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3">Timestamp</th>
                        <th class="py-3">Ref #</th>
                        <th class="py-3">Action</th>
                        <th class="py-3">Origin</th>
                        <th class="py-3">Recipient Office</th>
                        <th class="py-3">By</th>
                        <th class="py-3 text-end pe-4">Options</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr>
                        <td class="ps-4">
                            <div class="fw-bold">{{ $log->created_at->format('M d, Y') }}</div>
                            <div class="small text-muted">{{ $log->created_at->format('h:i A') }}</div>
                        </td>
                        <td>
                            @if($log->transmittal)
                            <a href="{{ route('transmittals.show', $log->transmittal) }}" class="text-navy fw-bold text-decoration-none">
                                {{ $log->transmittal->reference_number }}
                            </a>
                            @else
                            <span class="text-muted">N/A</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge rounded-pill px-3 py-2 {{ 
                                $log->action === 'Submitted' ? 'bg-primary bg-opacity-10 text-primary' : 
                                ($log->action === 'Received' ? 'bg-success bg-opacity-10 text-success' : 
                                'bg-secondary bg-opacity-10 text-secondary') 
                            }}">
                                {{ $log->action }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-light text-navy border font-monospace">
                                {{ $log->user->office->code ?? 'SYS' }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-light text-secondary border font-monospace">
                                {{ $log->transmittal->receiverOffice->code ?? 'N/A' }}
                            </span>
                        </td>
                        <td>
                            <div class="fw-medium small">{{ $log->user->name }}</div>
                        </td>
                        <td class="text-end pe-4">
                            <a href="{{ route('audit.show', $log) }}" class="btn btn-sm btn-navy rounded-pill px-3" title="View Audit Details">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <i class="bi bi-journal-x display-4 text-muted mb-3 d-block"></i>
                            <p class="text-muted">No audit records found.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($logs->hasPages())
    <div class="card-footer bg-white border-top-0 py-3">
        {{ $logs->appends(request()->input())->links() }}
    </div>
    @endif
</div>

<style>
    .bg-navy { background-color: #001f3f !important; }
    .text-navy { color: #001f3f !important; }
</style>
@endsection
