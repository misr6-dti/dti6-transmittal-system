@extends('layouts.app')

@section('content')
<div class="mb-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-2">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-navy">Dashboard</a></li>
            <li class="breadcrumb-item active">User Roles</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-start no-print">
        <div>
            <h2 class="fw-extrabold mb-1">User Roles</h2>
            <p class="text-muted mb-0 small">Manage system roles and their permissions.</p>
        </div>
        <a href="{{ route('admin.roles.create') }}" class="btn btn-navy d-flex align-items-center">
            <i class="bi bi-shield-plus me-2"></i>New Role
        </a>
    </div>
</div>

<div class="card shadow-sm mb-4 no-print">
    <div class="card-body">
        <form action="{{ route('admin.roles.index') }}" method="GET" class="row g-2">
            <div class="col-lg-4 col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control border-start-0" placeholder="Search by role name..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-lg-2 col-md-6 d-grid">
                <a href="{{ route('admin.roles.index') }}" class="btn btn-light text-muted d-flex align-items-center justify-content-center" title="Reset Filters">Clear</a>
            </div>
        </form>
    </div>
</div>
    <div class="col-lg-12">
        <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3" style="cursor: pointer;">
                                    <a href="{{ route('admin.roles.index', array_merge(request()->input(), ['sort_by' => 'name', 'sort_order' => ($sort['by'] === 'name' && $sort['order'] === 'asc') ? 'desc' : 'asc'])) }}" class="text-decoration-none text-dark fw-bold d-flex align-items-center">
                                        Role Name
                                        @if($sort['by'] === 'name')
                                            <i class="bi bi-arrow-{{ $sort['order'] === 'asc' ? 'up' : 'down' }} ms-2 small"></i>
                                        @else
                                            <i class="bi bi-arrow-down-up ms-2 small text-muted" style="opacity: 0.3;"></i>
                                        @endif
                                    </a>
                                </th>
                                <th class="py-3">Permissions</th>
                                <th class="py-3">Assigned Users</th>
                                <th class="pe-4 text-end py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $role)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-light rounded p-2 me-3">
                                            <i class="bi bi-shield-check text-navy"></i>
                                        </div>
                                        <div class="fw-bold">{{ $role->name }}</div>
                                    </div>
                                </td>
                                <td>
                                    @foreach($role->permissions as $perm)
                                        <span class="badge border border-navy text-navy me-1 small" style="font-size: 0.65rem; background: rgba(0, 31, 63, 0.05);">{{ $perm->name }}</span>
                                    @endforeach
                                    @if($role->permissions->isEmpty())
                                        <span class="text-muted small">No permissions</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-navy-subtle text-navy border">
                                        {{ $role->users_count }} Users
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group shadow-sm" style="border-radius: 0.5rem; overflow: hidden;">
                                        <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-sm btn-warning text-white d-flex align-items-center justify-content-center px-2" title="Edit Role" style="width: 32px; height: 32px;">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        @if($role->users_count == 0)
                                        <button type="button" 
                                            class="btn btn-sm btn-danger text-white d-flex align-items-center justify-content-center px-2" 
                                            title="Delete Role"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#confirmationModal"
                                            data-action="{{ route('admin.roles.destroy', $role) }}"
                                            data-method="DELETE"
                                            data-title="Delete Role"
                                            data-message="Are you sure you want to delete the '{{ $role->name }}' role?"
                                            data-btn-class="btn-danger"
                                            data-btn-text="Delete"
                                            style="width: 32px; height: 32px;">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @if($roles->hasPages())
            <div class="card-footer bg-white py-3 px-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div class="text-muted small">
                        Showing <strong>{{ $roles->firstItem() ?? 0 }}</strong> to <strong>{{ $roles->lastItem() ?? 0 }}</strong> 
                        of <strong>{{ $roles->total() }}</strong> role{{ $roles->total() !== 1 ? 's' : '' }}
                    </div>
                    <div>
                        {{ $roles->appends(request()->input())->links() }}
                    </div>
                </div>
            </div>
            @else
            <div class="card-footer bg-white py-3 px-4">
                <div class="text-muted small">
                    Showing <strong>{{ $roles->count() }}</strong> role{{ $roles->count() !== 1 ? 's' : '' }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
.bg-navy-subtle { background-color: rgba(0, 31, 63, 0.1) !important; }
.text-navy { color: #001f3f !important; }
.border-navy { border-color: #001f3f !important; }
</style>
@endsection
