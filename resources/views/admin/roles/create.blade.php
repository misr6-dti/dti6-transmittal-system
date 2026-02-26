@extends('layouts.app')

@section('content')
<div class="mb-4 no-print">
    <nav aria-label="breadcrumb">
        <ol class="flex items-center space-x-2 text-sm">
            <li class="text-navy hover:text-navy-light"><a href="{{ route('admin.roles.index') }}" class="text-navy">User Roles</a></li>
            <li class="text-slate-500">New Role</li>
        </ol>
    </nav>
    <h2 class="text-2xl font-extrabold text-navy">Create New Role</h2>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100">
            <div class="p-6 md:p-10">
                <form action="{{ route('admin.roles.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Role Name</label>
                        <input type="text" name="name" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-navy/20 focus:border-navy text-sm transition-all @error('name') border-red-500 focus:border-red-500 focus:ring-red-200 @enderror" value="{{ old('name') }}" placeholder="e.g. System Audit" required autofocus>
                    </div>

                    <div class="mb-4">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Assigned Permissions</label>
                        <div class="row g-3">
                            @foreach($permissions as $permission)
                            <div class="col-md-6">
                                <div class="flex items-center">
                                    <input class="rounded border-slate-300 text-navy focus:ring-navy/20" type="checkbox" name="permissions[]" value="{{ $permission->name }}" id="perm_{{ $permission->id }}">
                                    <label class="text-sm text-slate-600 ml-2" for="perm_{{ $permission->id }}">
                                        {{ $permission->name }}
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex justify-end gap-2 mt-5">
                        <a href="{{ route('admin.roles.index') }}" class="inline-flex items-center px-4 py-2.5 bg-white border border-slate-200 text-slate-600 text-sm font-medium rounded-xl hover:bg-slate-50 transition-colors">Cancel</a>
                        <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-navy text-white text-sm font-medium rounded-xl hover:bg-navy-light shadow-lg shadow-navy/20 transition-all transform hover:-translate-y-0.5">
                            <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>Create Role
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
