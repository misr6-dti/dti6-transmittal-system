@extends('layouts.app')

@section('content')
<div class="mb-4 no-print">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-1">
            <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}" class="text-navy">User Management</a></li>
            <li class="breadcrumb-item active">Edit User</li>
        </ol>
    </nav>
    <h2 class="fw-extrabold mb-0">Edit User Account</h2>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('admin.users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase">Full Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase">Email Address</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase">Role</label>
                            <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}" {{ old('role', $user->hasRole($role->name) ? $role->name : '') == $role->name ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                            @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase">Office Assignment</label>
                            <select name="office_id" class="form-select @error('office_id') is-invalid @enderror" required>
                                @foreach($offices as $office)
                                    <option value="{{ $office->id }}" {{ old('office_id', $user->office_id) == $office->id ? 'selected' : '' }}>{{ $office->name }} ({{ $office->code }})</option>
                                @endforeach
                            </select>
                            @error('office_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mt-5 pt-4 border-top">
                        <h6 class="fw-bold mb-3">Change Password (Leave blank if no change)</h6>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-uppercase">New Password</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="••••••••">
                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-uppercase">Confirm New Password</label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••">
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-light px-4">Cancel</a>
                        <button type="submit" class="btn btn-navy px-5">
                            <i class="bi bi-check-circle me-2"></i>Update Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm border-0 border-start border-navy border-4 mb-4">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-light rounded p-2 me-3">
                        <i class="bi bi-info-circle text-navy"></i>
                    </div>
                    <h6 class="fw-bold mb-0">System Log</h6>
                </div>
                <div class="small text-muted">
                    This account was created on <br><strong>{{ $user->created_at->format('F d, Y') }}</strong>
                    <hr class="my-2 border-light">
                    Last updated <br><strong>{{ $user->updated_at->diffForHumans() }}</strong>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
