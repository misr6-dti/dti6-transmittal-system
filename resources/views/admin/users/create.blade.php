@extends('layouts.app')

@section('content')
<div class="mb-4 no-print">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-1">
            <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}" class="text-navy">User Management</a></li>
            <li class="breadcrumb-item active">New User</li>
        </ol>
    </nav>
    <h2 class="fw-extrabold mb-0">Create New User</h2>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase">Full Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Enter full name" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase">Email Address</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="email@dti6.gov.ph" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase">Role</label>
                            <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                                <option value="">Select Role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                            @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase">Office Assignment</label>
                            <select name="office_id" class="form-select @error('office_id') is-invalid @enderror" required>
                                <option value="">Select Office</option>
                                @foreach($offices as $office)
                                    <option value="{{ $office->id }}" {{ old('office_id') == $office->id ? 'selected' : '' }}>{{ $office->name }} ({{ $office->code }})</option>
                                @endforeach
                            </select>
                            @error('office_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase">Password</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="••••••••" required>
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••" required>
                        </div>
                    </div>

                    <hr class="my-5 border-light">

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-light px-4">Cancel</a>
                        <button type="submit" class="btn btn-navy px-5">
                            <i class="bi bi-check-circle me-2"></i>Create User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card bg-navy text-white border-0 shadow-sm mb-4">
            <div class="card-body p-4 text-center">
                <i class="bi bi-shield-lock-fill fs-1 mb-3 opacity-50"></i>
                <h5 class="fw-bold">Security Notice</h5>
                <p class="small mb-0 opacity-75">Ensure that the user's role and office assignment reflect their official designation and physical workstation.</p>
            </div>
        </div>
    </div>
</div>
@endsection
