@extends('layouts.app')

@section('content')
<div class="mb-4 no-print">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-1">
            <li class="breadcrumb-item"><a href="{{ route('admin.divisions.index') }}" class="text-navy">Division Management</a></li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-center">
        <h2 class="fw-extrabold mb-0">Divisions</h2>
        <a href="{{ route('admin.divisions.create') }}" class="btn btn-navy d-flex align-items-center">
            <i class="bi bi-plus-circle me-2"></i>New Division
        </a>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        @if ($divisions->count())
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="fw-bold">Division Name</th>
                            <th class="fw-bold">Code</th>
                            <th class="fw-bold">Office</th>
                            <th class="fw-bold text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($divisions as $division)
                            <tr>
                                <td class="fw-500">{{ $division->name }}</td>
                                <td>
                                    <span class="badge bg-light text-dark">{{ $division->code }}</span>
                                </td>
                                <td>{{ $division->office->name }}</td>
                                <td class="text-end">
                                    <a href="{{ route('admin.divisions.edit', $division) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('admin.divisions.destroy', $division) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-5 text-center">
                <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                <p class="text-muted mt-3">No divisions found. <a href="{{ route('admin.divisions.create') }}">Create one now</a></p>
            </div>
        @endif
    </div>
</div>
@endsection
