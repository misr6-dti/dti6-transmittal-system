@extends('layouts.app')

@section('content')
<div class="mb-4 no-print">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-1">
            <li class="breadcrumb-item"><a href="{{ route('admin.divisions.index') }}" class="text-navy">Division Management</a></li>
            <li class="breadcrumb-item active">Edit Division</li>
        </ol>
    </nav>
    <h2 class="fw-extrabold mb-0">Edit Division Details</h2>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('admin.divisions.update', $division) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase">Division Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $division->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase">Division Code</label>
                        <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code', $division->code) }}" required>
                        @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase">Office</label>
                        <select name="office_id" class="form-select @error('office_id') is-invalid @enderror" required>
                            <option value="">Select Office</option>
                            @foreach ($offices as $office)
                                <option value="{{ $office->id }}" {{ old('office_id', $division->office_id) == $office->id ? 'selected' : '' }}>
                                    {{ $office->code }}
                                </option>
                            @endforeach
                        </select>
                        @error('office_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-5">
                        <a href="{{ route('admin.divisions.index') }}" class="btn btn-light px-4">Cancel</a>
                        <button type="submit" class="btn btn-navy px-5">
                            <i class="bi bi-check-circle me-2"></i>Update Division
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
