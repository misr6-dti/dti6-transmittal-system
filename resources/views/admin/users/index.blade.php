@extends('layouts.app')

@section('content')
<div class="mb-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-2">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-navy">Dashboard</a></li>
            <li class="breadcrumb-item active">User Management</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-start no-print">
        <div>
            <h2 class="fw-extrabold mb-1">User Management</h2>
            <p class="text-muted mb-0 small">Manage system users and their access privileges.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-navy d-flex align-items-center">
            <i class="bi bi-person-plus me-2"></i>New User
        </a>
    </div>
</div>

<div class="card shadow-sm mb-4 no-print">
    <div class="card-body">
        <form action="{{ route('admin.users.index') }}" method="GET" class="row g-2">
            <div class="col-lg-4 col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control border-start-0" placeholder="Search by name or email..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-lg-2 col-md-6">
                <select name="office_id" class="form-select" onchange="this.form.submit()">
                    <option value="">All Offices</option>
                    @foreach($offices as $office)
                        <option value="{{ $office->id }}" {{ request('office_id') == $office->id ? 'selected' : '' }}>{{ $office->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-2 col-md-6 d-grid">
                <a href="{{ route('admin.users.index') }}" class="btn btn-light text-muted d-flex align-items-center justify-content-center" title="Reset Filters">Clear</a>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm border-0 rounded-4 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3" style="cursor: pointer;">
                            <a href="{{ route('admin.users.index', array_merge(request()->input(), ['sort_by' => 'name', 'sort_order' => ($sort['by'] === 'name' && $sort['order'] === 'asc') ? 'desc' : 'asc'])) }}" class="text-decoration-none text-dark fw-bold d-flex align-items-center">
                                User Details
                                @if($sort['by'] === 'name')
                                    <i class="bi bi-arrow-{{ $sort['order'] === 'asc' ? 'up' : 'down' }} ms-2 small"></i>
                                @else
                                    <i class="bi bi-arrow-down-up ms-2 small text-muted" style="opacity: 0.3;"></i>
                                @endif
                            </a>
                        </th>
                        <th class="py-3">Role</th>
                        <th class="py-3" style="cursor: pointer;">
                            <a href="{{ route('admin.users.index', array_merge(request()->input(), ['sort_by' => 'office_id', 'sort_order' => ($sort['by'] === 'office_id' && $sort['order'] === 'asc') ? 'desc' : 'asc'])) }}" class="text-decoration-none text-dark fw-bold d-flex align-items-center">
                                Office
                                @if($sort['by'] === 'office_id')
                                    <i class="bi bi-arrow-{{ $sort['order'] === 'asc' ? 'up' : 'down' }} ms-2 small"></i>
                                @else
                                    <i class="bi bi-arrow-down-up ms-2 small text-muted" style="opacity: 0.3;"></i>
                                @endif
                            </a>
                        </th>
                        <th class="py-3" style="cursor: pointer;">
                            <a href="{{ route('admin.users.index', array_merge(request()->input(), ['sort_by' => 'email', 'sort_order' => ($sort['by'] === 'email' && $sort['order'] === 'asc') ? 'desc' : 'asc'])) }}" class="text-decoration-none text-dark fw-bold d-flex align-items-center">
                                Email
                                @if($sort['by'] === 'email')
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
                    @foreach($users as $user)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-light rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="bi bi-person text-navy"></i>
                                </div>
                                <div>
                                    <div class="fw-bold">{{ $user->name }}</div>
                                    <div class="small text-muted">ID: #{{ $user->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="fw-medium text-dark">{{ $user->getRoleNames()->first() ?? 'No Role' }}</div>
                        </td>
                        <td>
                            <div class="fw-medium text-dark">{{ $user->office->name ?? 'N/A' }}</div>
                            <div class="small text-muted">{{ $user->office->code ?? '' }}</div>
                        </td>
                        <td class="text-muted">{{ $user->email }}</td>
                        <td class="text-end pe-4">
                            <div class="btn-group shadow-sm" style="border-radius: 0.5rem; overflow: hidden;">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning text-white d-flex align-items-center justify-content-center px-2" title="Edit User" style="width: 32px; height: 32px;">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button" 
                                    class="btn btn-sm btn-danger text-white d-flex align-items-center justify-content-center px-2" 
                                    title="Delete User"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#confirmationModal"
                                    data-action="{{ route('admin.users.destroy', $user) }}"
                                    data-method="DELETE"
                                    data-title="Delete User"
                                    data-message="Are you sure you want to delete user '{{ $user->name }}'?"
                                    data-btn-class="btn-danger"
                                    data-btn-text="Delete"
                                    style="width: 32px; height: 32px;">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @if($users->hasPages())
    <div class="card-footer bg-white py-3 px-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="text-muted small">
                Showing <strong>{{ $users->firstItem() ?? 0 }}</strong> to <strong>{{ $users->lastItem() ?? 0 }}</strong> 
                of <strong>{{ $users->total() }}</strong> user{{ $users->total() !== 1 ? 's' : '' }}
            </div>
            <div>
                {{ $users->appends(request()->input())->links() }}
            </div>
        </div>
    </div>
    @else
    <div class="card-footer bg-white py-3 px-4">
        <div class="text-muted small">
            Showing <strong>{{ $users->count() }}</strong> user{{ $users->count() !== 1 ? 's' : '' }}
        </div>
    </div>
    @endif
</div>
@endsection
