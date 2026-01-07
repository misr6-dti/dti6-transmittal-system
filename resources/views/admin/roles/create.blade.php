@extends('layouts.app')

@section('content')
<div class="mb-4 no-print">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-1">
            <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}" class="text-navy">User Roles</a></li>
            <li class="breadcrumb-item active">New Role</li>
        </ol>
    </nav>
    <h2 class="fw-extrabold mb-0">Create New Role</h2>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('admin.roles.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase">Role Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="e.g. System Audit" required autofocus>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase">Assigned Permissions</label>
                        <div class="row g-3">
                            @foreach($permissions as $permission)
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}" id="perm_{{ $permission->id }}">
                                    <label class="form-check-label small" for="perm_{{ $permission->id }}">
                                        {{ $permission->name }}
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-5">
                        <a href="{{ route('admin.roles.index') }}" class="btn btn-light px-4">Cancel</a>
                        <button type="submit" class="btn btn-navy px-5">
                            <i class="bi bi-shield-plus me-2"></i>Create Role
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
