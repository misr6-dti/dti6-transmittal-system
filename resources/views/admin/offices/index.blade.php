@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-end mb-4 no-print">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-1">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-navy">Dashboard</a></li>
                <li class="breadcrumb-item active">Office Management</li>
            </ol>
        </nav>
        <h2 class="fw-extrabold mb-0">Office Management</h2>
    </div>
    <a href="{{ route('admin.offices.create') }}" class="btn btn-navy d-flex align-items-center">
        <i class="bi bi-building-plus me-2"></i>New Office
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
                                <th class="ps-4">Office Name</th>
                                <th>Code</th>
                                <th>Type</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($offices as $office)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold">{{ $office->name }}</div>
                                </td>
                                <td><code>{{ $office->code }}</code></td>
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        {{ $office->type }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.offices.edit', $office) }}" class="btn btn-sm btn-white border shadow-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" 
                                            class="btn btn-sm btn-white border shadow-sm text-danger" 
                                            title="Delete Office"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#confirmationModal"
                                            data-action="{{ route('admin.offices.destroy', $office) }}"
                                            data-method="DELETE"
                                            data-title="Delete Office"
                                            data-message="Are you sure you want to delete the '{{ $office->name }}' office?"
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
            @if($offices->hasPages())
            <div class="card-footer bg-white border-top-0 py-3">
                {{ $offices->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
