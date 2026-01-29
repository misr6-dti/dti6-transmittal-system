@extends('layouts.app')

@section('content')
<div class="mb-4 no-print">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-1">
            <li class="breadcrumb-item"><a href="{{ route('admin.divisions.index') }}" class="text-navy">Division Management</a></li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-center">
        <h2 class="fw-extrabold mb-0">Divisions</h2>
        <a href="{{ route('admin.divisions.create') }}" class="btn btn-navy d-flex align-items-center">
            <i class="bi bi-plus-circle me-2"></i>New Division
        </a>
    </div>
</div>

<div class="card shadow-sm mb-4 no-print">
    <div class="card-body">
        <form action="{{ route('admin.divisions.index') }}" method="GET" class="row g-2">
            <div class="col-lg-4 col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control border-start-0" placeholder="Search by name or code..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-lg-2 col-md-6 d-grid">
                <a href="{{ route('admin.divisions.index') }}" class="btn btn-light text-muted d-flex align-items-center justify-content-center" title="Reset Filters">Clear</a>
            </div>
        </form>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card shadow-sm border-0 rounded-4 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3" style="cursor: pointer;">
                            <a href="{{ route('admin.divisions.index', array_merge(request()->input(), ['sort_by' => 'name', 'sort_order' => ($sort['by'] === 'name' && $sort['order'] === 'asc') ? 'desc' : 'asc'])) }}" class="text-decoration-none text-dark fw-bold d-flex align-items-center">
                                Division Name
                                @if($sort['by'] === 'name')
                                    <i class="bi bi-arrow-{{ $sort['order'] === 'asc' ? 'up' : 'down' }} ms-2 small"></i>
                                @else
                                    <i class="bi bi-arrow-down-up ms-2 small text-muted" style="opacity: 0.3;"></i>
                                @endif
                            </a>
                        </th>
                        <th class="py-3" style="cursor: pointer;">
                            <a href="{{ route('admin.divisions.index', array_merge(request()->input(), ['sort_by' => 'code', 'sort_order' => ($sort['by'] === 'code' && $sort['order'] === 'asc') ? 'desc' : 'asc'])) }}" class="text-decoration-none text-dark fw-bold d-flex align-items-center">
                                Code
                                @if($sort['by'] === 'code')
                                    <i class="bi bi-arrow-{{ $sort['order'] === 'asc' ? 'up' : 'down' }} ms-2 small"></i>
                                @else
                                    <i class="bi bi-arrow-down-up ms-2 small text-muted" style="opacity: 0.3;"></i>
                                @endif
                            </a>
                        </th>
                        <th class="py-3" style="cursor: pointer;">
                            <a href="{{ route('admin.divisions.index', array_merge(request()->input(), ['sort_by' => 'office_id', 'sort_order' => ($sort['by'] === 'office_id' && $sort['order'] === 'asc') ? 'desc' : 'asc'])) }}" class="text-decoration-none text-dark fw-bold d-flex align-items-center">
                                Office
                                @if($sort['by'] === 'office_id')
                                    <i class="bi bi-arrow-{{ $sort['order'] === 'asc' ? 'up' : 'down' }} ms-2 small"></i>
                                @else
                                    <i class="bi bi-arrow-down-up ms-2 small text-muted" style="opacity: 0.3;"></i>
                                @endif
                            </a>
                        </th>
                        <th class="pe-4 text-end py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($divisions as $division)
                        <tr>
                            <td class="ps-4 fw-500">{{ $division->name }}</td>
                            <td>
                                <span class="badge bg-light text-dark">{{ $division->code }}</span>
                            </td>
                            <td>{{ $division->office->name }}</td>
                            <td class="text-end pe-4">
                                <div class="btn-group shadow-sm" style="border-radius: 0.5rem; overflow: hidden;">
                                    <a href="{{ route('admin.divisions.edit', $division) }}" class="btn btn-sm btn-warning text-white d-flex align-items-center justify-content-center px-2" title="Edit" style="width: 32px; height: 32px;">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" 
                                        class="btn btn-sm btn-danger text-white d-flex align-items-center justify-content-center px-2" 
                                        title="Delete Division"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#confirmationModal"
                                        data-action="{{ route('admin.divisions.destroy', $division) }}"
                                        data-method="DELETE"
                                        data-title="Delete Division"
                                        data-message="Are you sure you want to delete the '{{ $division->name }}' division?"
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
                            <td colspan="4" class="text-center py-5">
                                <div class="text-muted mb-3"><i class="bi bi-folder2-open fs-1"></i></div>
                                <h5 class="text-muted">No divisions found.</h5>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($divisions->hasPages())
    <div class="card-footer bg-white py-3 px-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="text-muted small">
                Showing <strong>{{ $divisions->firstItem() ?? 0 }}</strong> to <strong>{{ $divisions->lastItem() ?? 0 }}</strong> 
                of <strong>{{ $divisions->total() }}</strong> division{{ $divisions->total() !== 1 ? 's' : '' }}
            </div>
            <div>
                {{ $divisions->appends(request()->input())->links() }}
            </div>
        </div>
    </div>
    @else
    <div class="card-footer bg-white py-3 px-4">
        <div class="text-muted small">
            Showing <strong>{{ $divisions->count() }}</strong> division{{ $divisions->count() !== 1 ? 's' : '' }}
        </div>
    </div>
    @endif
</div>
@endsection
