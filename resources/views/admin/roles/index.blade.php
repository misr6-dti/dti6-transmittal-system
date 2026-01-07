@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-end mb-4 no-print">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-1">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-navy">Dashboard</a></li>
                <li class="breadcrumb-item active">User Roles</li>
            </ol>
        </nav>
        <h2 class="fw-extrabold mb-0">User Roles</h2>
    </div>
    <a href="{{ route('admin.roles.create') }}" class="btn btn-navy d-flex align-items-center">
        <i class="bi bi-shield-plus me-2"></i>New Role
    </a>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">Role Name</th>
                                <th>Permissions</th>
                                <th>Assigned Users</th>
                                <th class="text-end pe-4">Actions</th>
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
                                    <div class="btn-group">
                                        <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-sm btn-white border shadow-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        @if($role->users_count == 0)
                                        <button type="button" 
                                            class="btn btn-sm btn-white border shadow-sm text-danger" 
                                            title="Delete Role"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#confirmationModal"
                                            data-action="{{ route('admin.roles.destroy', $role) }}"
                                            data-method="DELETE"
                                            data-title="Delete Role"
                                            data-message="Are you sure you want to delete the '{{ $role->name }}' role?"
                                            data-btn-class="btn-danger"
                                            data-btn-text="Delete">
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
        </div>
    </div>
</div>

<style>
.bg-navy-subtle { background-color: rgba(0, 31, 63, 0.1) !important; }
.text-navy { color: #001f3f !important; }
.border-navy { border-color: #001f3f !important; }
</style>
@endsection
