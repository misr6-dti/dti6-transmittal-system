@extends('layouts.app')

@section('content')
<div class="mb-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-2">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-navy">Dashboard</a></li>
            <li class="breadcrumb-item active">Office Management</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-start no-print">
        <div>
            <h2 class="fw-extrabold mb-1">Office Management</h2>
            <p class="text-muted mb-0 small">Manage DTI regional offices and their information.</p>
        </div>
        <a href="{{ route('admin.offices.create') }}" class="btn btn-navy d-flex align-items-center">
            <i class="bi bi-building-plus me-2"></i>New Office
        </a>
    </div>
</div>

<div class="card shadow-sm mb-4 no-print">
    <div class="card-body">
        <form action="{{ route('admin.offices.index') }}" method="GET" class="row g-2">
            <div class="col-lg-4 col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control border-start-0" placeholder="Search by name or code..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-lg-2 col-md-6 d-grid">
                <a href="{{ route('admin.offices.index') }}" class="btn btn-light text-muted d-flex align-items-center justify-content-center" title="Reset Filters">Clear</a>
            </div>
        </form>
    </div>
</div>
    <div class="col-lg-12">
        <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3" style="cursor: pointer;">
                                    <a href="{{ route('admin.offices.index', array_merge(request()->input(), ['sort_by' => 'name', 'sort_order' => ($sort['by'] === 'name' && $sort['order'] === 'asc') ? 'desc' : 'asc'])) }}" class="text-decoration-none text-dark fw-bold d-flex align-items-center">
                                        Office Name
                                        @if($sort['by'] === 'name')
                                            <i class="bi bi-arrow-{{ $sort['order'] === 'asc' ? 'up' : 'down' }} ms-2 small"></i>
                                        @else
                                            <i class="bi bi-arrow-down-up ms-2 small text-muted" style="opacity: 0.3;"></i>
                                        @endif
                                    </a>
                                </th>
                                <th class="py-3" style="cursor: pointer;">
                                    <a href="{{ route('admin.offices.index', array_merge(request()->input(), ['sort_by' => 'code', 'sort_order' => ($sort['by'] === 'code' && $sort['order'] === 'asc') ? 'desc' : 'asc'])) }}" class="text-decoration-none text-dark fw-bold d-flex align-items-center">
                                        Code
                                        @if($sort['by'] === 'code')
                                            <i class="bi bi-arrow-{{ $sort['order'] === 'asc' ? 'up' : 'down' }} ms-2 small"></i>
                                        @else
                                            <i class="bi bi-arrow-down-up ms-2 small text-muted" style="opacity: 0.3;"></i>
                                        @endif
                                    </a>
                                </th>
                                <th class="py-3" style="cursor: pointer;">
                                    <a href="{{ route('admin.offices.index', array_merge(request()->input(), ['sort_by' => 'type', 'sort_order' => ($sort['by'] === 'type' && $sort['order'] === 'asc') ? 'desc' : 'asc'])) }}" class="text-decoration-none text-dark fw-bold d-flex align-items-center">
                                        Type
                                        @if($sort['by'] === 'type')
                                            <i class="bi bi-arrow-{{ $sort['order'] === 'asc' ? 'up' : 'down' }} ms-2 small"></i>
                                        @else
                                            <i class="bi bi-arrow-down-up ms-2 small text-muted" style="opacity: 0.3;"></i>
                                        @endif
                                    </a>
                                </th>
                                <th class="py-3">Parent Office</th>
                                <th class="pe-4 text-end py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($offices as $office)
                                <tr>
                                    <td class="ps-4">{{ $office->name }}</td>
                                    <td>{{ $office->code }}</td>
                                    <td>
                                        <span class="badge bg-primary">{{ $office->type }}</span>
                                    </td>
                                    <td>
                                        @if($office->parent)
                                            <small class="text-muted">{{ $office->parent->name }}</small>
                                        @else
                                            <small class="text-muted text-secondary">—</small>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group shadow-sm" style="border-radius: 0.5rem; overflow: hidden;">
                                            <a href="{{ route('admin.offices.edit', $office) }}" class="btn btn-sm btn-warning text-white d-flex align-items-center justify-content-center px-2" title="Edit" style="width: 32px; height: 32px;">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" 
                                                class="btn btn-sm btn-danger text-white d-flex align-items-center justify-content-center px-2" 
                                                title="Delete Office"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#confirmationModal"
                                                data-action="{{ route('admin.offices.destroy', $office) }}"
                                                data-method="DELETE"
                                                data-title="Delete Office"
                                                data-message="Are you sure you want to delete '{{ $office->name }}'?"
                                                data-btn-class="btn-danger"
                                                data-btn-text="Delete"
                                                style="width: 32px; height: 32px;">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="text-muted mb-3"><i class="bi bi-folder2-open fs-1"></i></div>
                                        <h5 class="text-muted">No offices found.</h5>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($offices->hasPages())
            <div class="card-footer bg-white py-3 px-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div class="text-muted small">
                        Showing <strong>{{ $offices->firstItem() ?? 0 }}</strong> to <strong>{{ $offices->lastItem() ?? 0 }}</strong> 
                        of <strong>{{ $offices->total() }}</strong> office{{ $offices->total() !== 1 ? 's' : '' }}
                    </div>
                    <div>
                        {{ $offices->appends(request()->input())->links() }}
                    </div>
                </div>
            </div>
            @else
            <div class="card-footer bg-white py-3 px-4">
                <div class="text-muted small">
                    Showing <strong>{{ $offices->count() }}</strong> office{{ $offices->count() !== 1 ? 's' : '' }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
