@extends('layouts.app')

@section('content')
<div class="mb-4 no-print">
    <nav aria-label="breadcrumb">
        <ol class="flex items-center space-x-2 text-sm">
            <li class="text-navy hover:text-navy-light"><a href="{{ route('admin.offices.index') }}" class="text-navy">Office Management</a></li>
            <li class="text-slate-500">{{ $office->name }}</li>
        </ol>
    </nav>
    <h2 class="text-2xl font-extrabold text-navy">{{ $office->name }}</h2>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 mb-4">
            <div class="p-6 md:p-10">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Office Name</label>
                        <p class="text-lg font-medium text-slate-800">{{ $office->name }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Office Code</label>
                        <p class="text-lg font-medium text-slate-800">
                            <span class="badge bg-slate-50 text-dark">{{ $office->code }}</span>
                        </p>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Office Type</label>
                        <p class="text-lg font-medium text-slate-800">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-navy text-white">{{ $office->type }}</span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Parent Office</label>
                        <p class="text-lg font-medium text-slate-800">
                            @if ($office->parent)
                                <a href="{{ route('admin.offices.show', $office->parent) }}" class="text-navy">
                                    {{ $office->parent->name }}
                                </a>
                            @else
                                <span class="text-slate-500">No Parent (Root Office)</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="flex justify-start gap-2 mt-5">
                    <a href="{{ route('admin.offices.edit', $office) }}" class="inline-flex items-center px-4 py-2.5 bg-navy text-white text-sm font-medium rounded-xl hover:bg-navy-light shadow-lg shadow-navy/20 transition-all transform hover:-translate-y-0.5">
                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>Edit Office
                    </a>
                    <a href="{{ route('admin.offices.index') }}" class="inline-flex items-center px-4 py-2.5 bg-white border border-slate-200 text-slate-600 text-sm font-medium rounded-xl hover:bg-slate-50 transition-colors">
                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>Back
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 border-start border-navy border-4 mb-4">
            <div class="p-6">
                <div class="flex items-center mb-3">
                    <div class="bg-slate-50 rounded p-2 mr-3">
                        <svg class="w-4 h-4 text-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h6 class="font-bold mb-0">Office Information</h6>
                </div>
                <div class="small text-slate-500">
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
