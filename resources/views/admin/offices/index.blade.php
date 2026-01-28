@extends('layouts.app')

@section('content')
<div class="mb-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-2">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-navy">Dashboard</a></li>
            <li class="breadcrumb-item active">Office Management</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-start no-print">
        <div>
            <h2 class="fw-extrabold mb-1">Office Management</h2>
            <p class="text-muted mb-0 small">Manage DTI regional offices and their information.</p>
        </div>
        <a href="{{ route('admin.offices.create') }}" class="btn btn-navy d-flex align-items-center">
            <i class="bi bi-building-plus me-2"></i>New Office
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0 data-table">
                        <thead>
                            <tr class="border-bottom">
                                <th class="ps-4" style="width: 35%;">Office Name</th>
                                <th style="width: 12%;">Code</th>
                                <th style="width: 18%;">Type</th>
                                <th style="width: 18%;">Parent Office</th>
                                <th class="text-end pe-4" style="width: 17%;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($offices as $office)
                                <tr>
                                    <td class="ps-4">{{ $office->name }}</td>
                                    <td>{{ $office->code }}</td>
                                    <td>
                                        <span class="badge bg-primary">{{ $office->type }}</span>
                                    </td>
                                    <td>
                                        @if($office->parent)
                                            <small class="text-muted">{{ $office->parent->name }}</small>
                                        @else
                                            <small class="text-muted text-secondary">—</small>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="{{ route('admin.offices.edit', $office) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="{{ route('admin.offices.destroy', $office) }}" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-5">
                                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                        No offices found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
