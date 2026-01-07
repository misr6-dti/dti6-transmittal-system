@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-end mb-4 no-print">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-1">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-navy">Dashboard</a></li>
                <li class="breadcrumb-item active">User Management</li>
            </ol>
        </nav>
        <h2 class="fw-extrabold mb-0">User Management</h2>
    </div>
    <a href="{{ route('admin.users.create') }}" class="btn btn-navy d-flex align-items-center">
        <i class="bi bi-person-plus me-2"></i>New User
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">User Details</th>
                        <th>Role</th>
                        <th>Office</th>
                        <th>Email</th>
                        <th class="text-end pe-4">Actions</th>
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
                            <div class="btn-group">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-white border shadow-sm">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button" 
                                    class="btn btn-sm btn-white border shadow-sm text-danger" 
                                    title="Delete User"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#confirmationModal"
                                    data-action="{{ route('admin.users.destroy', $user) }}"
                                    data-method="DELETE"
                                    data-title="Delete User"
                                    data-message="Are you sure you want to delete user '{{ $user->name }}'?"
                                    data-btn-class="btn-danger"
                                    data-btn-text="Delete">
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
    <div class="card-footer bg-white border-top-0 py-3">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection
