@extends('layouts.app')

@section('content')
<div class="mb-4 no-print">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-1">
            <li class="breadcrumb-item"><a href="{{ route('admin.offices.index') }}" class="text-navy">Office Management</a></li>
            <li class="breadcrumb-item active">{{ $office->name }}</li>
        </ol>
    </nav>
    <h2 class="fw-extrabold mb-0">{{ $office->name }}</h2>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4 p-md-5">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-uppercase text-muted">Office Name</label>
                        <p class="fw-500 fs-5">{{ $office->name }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-uppercase text-muted">Office Code</label>
                        <p class="fw-500 fs-5">
                            <span class="badge bg-light text-dark">{{ $office->code }}</span>
                        </p>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-uppercase text-muted">Office Type</label>
                        <p class="fw-500 fs-5">
                            <span class="badge bg-navy">{{ $office->type }}</span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-uppercase text-muted">Parent Office</label>
                        <p class="fw-500 fs-5">
                            @if ($office->parent)
                                <a href="{{ route('admin.offices.show', $office->parent) }}" class="text-navy">
                                    {{ $office->parent->name }}
                                </a>
                            @else
                                <span class="text-muted">No Parent (Root Office)</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="d-flex justify-content-start gap-2 mt-5">
                    <a href="{{ route('admin.offices.edit', $office) }}" class="btn btn-navy px-4">
                        <i class="bi bi-pencil-square me-2"></i>Edit Office
                    </a>
                    <a href="{{ route('admin.offices.index') }}" class="btn btn-light px-4">
                        <i class="bi bi-arrow-left me-2"></i>Back
                    </a>
                </div>
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
                    <h6 class="fw-bold mb-0">Office Information</h6>
                </div>
                <div class="small text-muted">
                    <div class="mb-3">
                        <strong>Total Users:</strong> {{ $office->users()->count() }}
                    </div>
                    <div class="mb-3">
                        <strong>Child Offices:</strong> {{ $office->children()->count() }}
                    </div>
                    <div class="mb-3">
                        <strong>Divisions:</strong> {{ $office->divisions()->count() }}
                    </div>
                    <hr class="my-3 border-light">
                    <div class="mb-2">
                        <strong>Created:</strong><br>
                        {{ $office->created_at->format('F d, Y') }}
                    </div>
                    <div>
                        <strong>Updated:</strong><br>
                        {{ $office->updated_at->format('F d, Y') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
