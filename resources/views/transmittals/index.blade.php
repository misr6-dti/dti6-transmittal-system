@extends('layouts.app')

@section('content')
<div class="mb-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-2">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-navy">Dashboard</a></li>
            <li class="breadcrumb-item active">Transmittals</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-start no-print">
        <div>
            <h2 class="fw-extrabold mb-1">Transmittal Ledger</h2>
            <p class="text-muted mb-0 small">Track and manage all document movements across Region VI offices.</p>
        </div>
        @can('create', App\Models\Transmittal::class)
        <a href="{{ route('transmittals.create') }}" class="btn btn-navy d-flex align-items-center">
            <i class="bi bi-plus-circle me-2"></i>New Entry
        </a>
        @endcan
    </div>
</div>

<div class="card shadow-sm mb-4 no-print">
    <div class="card-body">
        <form action="{{ route('transmittals.index') }}" method="GET" class="row g-2">
            <div class="col-lg-3 col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control border-start-0" placeholder="Reference Number..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-lg-2 col-md-6">
                <select name="status" class="form-select" onchange="this.form.submit()">
                    <option value="">All Statuses</option>
                    <option value="Draft" {{ request('status') == 'Draft' ? 'selected' : '' }}>Draft</option>
                    <option value="Submitted" {{ request('status') == 'Submitted' ? 'selected' : '' }}>Submitted</option>
                    <option value="Received" {{ request('status') == 'Received' ? 'selected' : '' }}>Received</option>
                </select>
            </div>
            <div class="col-lg-2 col-md-6">
                <select name="office_id" class="form-select" onchange="this.form.submit()">
                    <option value="">All Offices</option>
                    @foreach($offices as $office)
                        <option value="{{ $office->id }}" {{ request('office_id') == $office->id ? 'selected' : '' }}>{{ $office->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-2 col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-light small py-0 px-2" style="font-size: 0.7rem;">From</span>
                    <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}" onchange="this.form.submit()">
                </div>
            </div>
            <div class="col-lg-2 col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-light small py-0 px-2" style="font-size: 0.7rem;">To</span>
                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}" onchange="this.form.submit()">
                </div>
            </div>
            <div class="col-lg-1 col-md-6 d-grid">
                <a href="{{ route('transmittals.index') }}" class="btn btn-light text-muted d-flex align-items-center justify-content-center" title="Reset Filters">Clear</a>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm overflow-hidden">
    <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead>
                <tr>
                    <th class="ps-4" style="cursor: pointer;">
                        <a href="{{ route('transmittals.index', array_merge(request()->input(), ['sort_by' => 'reference_number', 'sort_order' => ($sort['by'] === 'reference_number' && $sort['order'] === 'asc') ? 'desc' : 'asc'])) }}" class="text-decoration-none text-dark fw-bold d-flex align-items-center">
                            Reference #
                            @if($sort['by'] === 'reference_number')
                                <i class="bi bi-arrow-{{ $sort['order'] === 'asc' ? 'up' : 'down' }} ms-2 small"></i>
                            @else
                                <i class="bi bi-arrow-down-up ms-2 small text-muted" style="opacity: 0.3;"></i>
                            @endif
                        </a>
                    </th>
                    <th style="cursor: pointer;">
                        <a href="{{ route('transmittals.index', array_merge(request()->input(), ['sort_by' => 'transmittal_date', 'sort_order' => ($sort['by'] === 'transmittal_date' && $sort['order'] === 'asc') ? 'desc' : 'asc'])) }}" class="text-decoration-none text-dark fw-bold d-flex align-items-center">
                            Execution Date
                            @if($sort['by'] === 'transmittal_date')
                                <i class="bi bi-arrow-{{ $sort['order'] === 'asc' ? 'up' : 'down' }} ms-2 small"></i>
                            @else
                                <i class="bi bi-arrow-down-up ms-2 small text-muted" style="opacity: 0.3;"></i>
                            @endif
                        </a>
                    </th>
                    <th style="cursor: pointer;">
                        <a href="{{ route('transmittals.index', array_merge(request()->input(), ['sort_by' => 'sender_office_id', 'sort_order' => ($sort['by'] === 'sender_office_id' && $sort['order'] === 'asc') ? 'desc' : 'asc'])) }}" class="text-decoration-none text-dark fw-bold d-flex align-items-center">
                            Origin
                            @if($sort['by'] === 'sender_office_id')
                                <i class="bi bi-arrow-{{ $sort['order'] === 'asc' ? 'up' : 'down' }} ms-2 small"></i>
                            @else
                                <i class="bi bi-arrow-down-up ms-2 small text-muted" style="opacity: 0.3;"></i>
                            @endif
                        </a>
                    </th>
                    <th style="cursor: pointer;">
                        <a href="{{ route('transmittals.index', array_merge(request()->input(), ['sort_by' => 'receiver_office_id', 'sort_order' => ($sort['by'] === 'receiver_office_id' && $sort['order'] === 'asc') ? 'desc' : 'asc'])) }}" class="text-decoration-none text-dark fw-bold d-flex align-items-center">
                            Destination
                            @if($sort['by'] === 'receiver_office_id')
                                <i class="bi bi-arrow-{{ $sort['order'] === 'asc' ? 'up' : 'down' }} ms-2 small"></i>
                            @else
                                <i class="bi bi-arrow-down-up ms-2 small text-muted" style="opacity: 0.3;"></i>
                            @endif
                        </a>
                    </th>
                    <th>Description</th>
                    <th style="cursor: pointer;">
                        <a href="{{ route('transmittals.index', array_merge(request()->input(), ['sort_by' => 'status', 'sort_order' => ($sort['by'] === 'status' && $sort['order'] === 'asc') ? 'desc' : 'asc'])) }}" class="text-decoration-none text-dark fw-bold d-flex align-items-center">
                            Status
                            @if($sort['by'] === 'status')
                                <i class="bi bi-arrow-{{ $sort['order'] === 'asc' ? 'up' : 'down' }} ms-2 small"></i>
                            @else
                                <i class="bi bi-arrow-down-up ms-2 small text-muted" style="opacity: 0.3;"></i>
                            @endif
                        </a>
                    </th>
                    <th class="pe-4 text-end">Actions</th>
                </tr>
            </thead>
            <tbody class="border-top-0">
                @forelse($transmittals as $t)
                <tr>
                    <td class="ps-4 fw-bold text-navy text-nowrap"><span style="font-size: 0.82rem;">{{ $t->reference_number }}</span></td>
                    <td>{{ \Carbon\Carbon::parse($t->transmittal_date)->format('M d, Y') }}</td>
                    <td><span class="small fw-medium">{{ $t->senderOffice->code }}</span></td>
                    <td><span class="small fw-medium">{{ $t->receiverOffice->code }}</span></td>
                    <td>
                        <span class="small text-muted" style="max-width: 200px; display: inline-block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $t->items->first()->description ?? 'No items' }}">
                            {{ $t->items->first()->description ?? '---' }}
                        </span>
                    </td>
                    <td>
                        @php
                            $status = $t->status;
                            $badgeClass = strtolower($status);
                            $displayText = $status;

                            if ($status === 'Submitted') {
                                if (Auth::user()->office_id == $t->receiver_office_id) {
                                    $displayText = 'To Receive';
                                    $badgeClass = 'pending-arrival';
                                } elseif (Auth::user()->office_id == $t->sender_office_id) {
                                    $displayText = 'Pending Receipt';
                                    $badgeClass = 'submitted';
                                }
                            }
                        @endphp
                        <span class="status-badge bg-{{ $badgeClass }}">
                            {{ $displayText }}
                        </span>
                    </td>
                    <td class="pe-4 text-end">
                        <div class="btn-group shadow-sm" style="border-radius: 0.5rem; overflow: hidden;">
                            <a href="{{ route('transmittals.show', $t) }}" class="btn btn-sm btn-info text-white d-flex align-items-center justify-content-center px-2" title="View" style="width: 32px; height: 32px;"><i class="bi bi-eye"></i></a>
                            
                            @can('update', $t)
                                <a href="{{ route('transmittals.edit', $t) }}" class="btn btn-sm btn-warning text-white d-flex align-items-center justify-content-center px-2" title="Edit" style="width: 32px; height: 32px;"><i class="bi bi-pencil"></i></a>
                            @endcan

                            @can('delete', $t)
                                <button type="button" 
                                    class="btn btn-sm btn-danger text-white d-flex align-items-center justify-content-center px-2" 
                                    title="Delete Record"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#confirmationModal"
                                    data-action="{{ route('transmittals.destroy', $t) }}"
                                    data-method="DELETE"
                                    data-title="Confirm Delete"
                                    data-message="Are you sure you want to permanently delete this transmittal record? This action cannot be undone."
                                    data-btn-class="btn-danger"
                                    data-btn-text="Delete"
                                    style="width: 32px; height: 32px;">
                                    <i class="bi bi-trash"></i>
                                </button>
                            @endcan

                            @can('receive', $t)
                                <button type="button" 
                                    class="btn btn-sm btn-success text-white d-flex align-items-center justify-content-center px-2" 
                                    title="Confirm Receipt"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#confirmationModal"
                                    data-action="{{ route('transmittals.receive', $t) }}"
                                    data-method="PATCH"
                                    data-title="Acknowledge Receipt"
                                    data-message="By confirming, you officially acknowledge that you have physically received the hard copy documents for Transmittal #{{ $t->reference_number }}."
                                    data-btn-class="btn-success"
                                    data-btn-text="Confirm Receipt"
                                    style="width: 32px; height: 32px; padding: 0.375rem !important;">
                                    <i class="bi bi-check2-circle"></i>
                                </button>
                            @endcan
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <div class="text-muted mb-3"><i class="bi bi-folder2-open fs-1"></i></div>
                        <h5 class="text-muted">No records found matching those criteria.</h5>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($transmittals->hasPages())
    <div class="card-footer bg-white py-3 px-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="text-muted small">
                Showing <strong>{{ $transmittals->firstItem() ?? 0 }}</strong> to <strong>{{ $transmittals->lastItem() ?? 0 }}</strong> 
                of <strong>{{ $transmittals->total() }}</strong> results
            </div>
            <div>
                {{ $transmittals->appends(request()->input())->links() }}
            </div>
        </div>
    </div>
    @else
    <div class="card-footer bg-white py-3 px-4">
        <div class="text-muted small">
            Showing <strong>{{ $transmittals->count() }}</strong> result{{ $transmittals->count() !== 1 ? 's' : '' }}
        </div>
    </div>
    @endif
</div>
@endsection
