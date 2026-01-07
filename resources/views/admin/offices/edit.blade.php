@extends('layouts.app')

@section('content')
<div class="mb-4 no-print">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-1">
            <li class="breadcrumb-item"><a href="{{ route('admin.offices.index') }}" class="text-navy">Office Management</a></li>
            <li class="breadcrumb-item active">Edit Office</li>
        </ol>
    </nav>
    <h2 class="fw-extrabold mb-0">Edit Office Details</h2>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('admin.offices.update', $office) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase">Office Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $office->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase">Office Code</label>
                            <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code', $office->code) }}" required>
                            @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase">Office Type</label>
                            <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                                <option value="Regional" {{ $office->type == 'Regional' ? 'selected' : '' }}>Regional Office</option>
                                <option value="Provincial" {{ $office->type == 'Provincial' ? 'selected' : '' }}>Provincial Office</option>
                                <option value="Satellite" {{ $office->type == 'Satellite' ? 'selected' : '' }}>Satellite Office</option>
                                <option value="Unit" {{ $office->type == 'Unit' ? 'selected' : '' }}>Specific Unit</option>
                            </select>
                            @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-5">
                        <a href="{{ route('admin.offices.index') }}" class="btn btn-light px-4">Cancel</a>
                        <button type="submit" class="btn btn-navy px-5">
                            <i class="bi bi-check-circle me-2"></i>Update Office
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
