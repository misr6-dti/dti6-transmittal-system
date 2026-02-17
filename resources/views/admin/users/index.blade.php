@extends('layouts.app')

@section('content')
<div class="mb-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 no-print">
        <div>
            <nav class="flex mb-2" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('dashboard') }}" class="text-navy hover:text-navy-light font-medium text-sm flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-slate-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="ml-1 text-sm font-medium text-slate-500 md:ml-2">User Management</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h2 class="text-2xl font-extrabold text-navy">User Management</h2>
            <p class="text-slate-500 text-sm">Manage system users and their access privileges.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="inline-flex items-center px-5 py-2.5 bg-navy text-white text-sm font-medium rounded-xl hover:bg-navy-light shadow-lg shadow-navy/20 transition-all transform hover:-translate-y-0.5">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
            New User
        </a>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 mb-6 p-6 no-print">
    <form action="{{ route('admin.users.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4">
        <div class="md:col-span-5">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="search" class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-navy/20 focus:border-navy text-sm transition-all" placeholder="Search by name or email..." value="{{ request('search') }}">
            </div>
        </div>
        <div class="md:col-span-5">
            <select name="office_id" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-navy/20 focus:border-navy text-sm transition-all appearance-none" onchange="this.form.submit()">
                <option value="">All Offices</option>
                @foreach($offices as $office)
                    <option value="{{ $office->id }}" {{ request('office_id') == $office->id ? 'selected' : '' }}>{{ $office->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="md:col-span-2">
            <a href="{{ route('admin.users.index') }}" class="flex items-center justify-center w-full px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl font-medium text-sm transition-colors">
                Clear
            </a>
        </div>
    </form>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-600">
            <thead class="bg-slate-50 text-xs font-bold uppercase text-slate-500 tracking-wider">
                <tr>
                    <th class="px-6 py-4 cursor-pointer hover:bg-slate-100 transition-colors">
                        <a href="{{ route('admin.users.index', array_merge(request()->input(), ['sort_by' => 'name', 'sort_order' => ($sort['by'] === 'name' && $sort['order'] === 'asc') ? 'desc' : 'asc'])) }}" class="flex items-center group">
                            User Details
                            <span class="ml-2 text-navy">
                                @if($sort['by'] === 'name')
                                    @if($sort['order'] === 'asc')
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                    @else
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    @endif
                                @else
                                    <svg class="w-3 h-3 text-slate-300 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path></svg>
                                @endif
                            </span>
                        </a>
                    </th>
                    <th class="px-6 py-4">Role</th>
                    <th class="px-6 py-4 cursor-pointer hover:bg-slate-100 transition-colors">
                        <a href="{{ route('admin.users.index', array_merge(request()->input(), ['sort_by' => 'office_id', 'sort_order' => ($sort['by'] === 'office_id' && $sort['order'] === 'asc') ? 'desc' : 'asc'])) }}" class="flex items-center group">
                            Office
                            <span class="ml-2 text-navy">
                                @if($sort['by'] === 'office_id')
                                    @if($sort['order'] === 'asc')
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                    @else
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    @endif
                                @else
                                    <svg class="w-3 h-3 text-slate-300 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path></svg>
                                @endif
                            </span>
                        </a>
                    </th>
                    <th class="px-6 py-4 cursor-pointer hover:bg-slate-100 transition-colors">
                        <a href="{{ route('admin.users.index', array_merge(request()->input(), ['sort_by' => 'email', 'sort_order' => ($sort['by'] === 'email' && $sort['order'] === 'asc') ? 'desc' : 'asc'])) }}" class="flex items-center group">
                            Email
                            <span class="ml-2 text-navy">
                                @if($sort['by'] === 'email')
                                    @if($sort['order'] === 'asc')
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                    @else
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    @endif
                                @else
                                    <svg class="w-3 h-3 text-slate-300 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path></svg>
                                @endif
                            </span>
                        </a>
                    </th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($users as $user)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-navy mr-3 flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <div>
                                <div class="font-bold text-slate-800">{{ $user->name }}</div>
                                <div class="text-xs text-slate-400">ID: #{{ $user->id }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                            {{ $user->getRoleNames()->first() ?? 'No Role' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-slate-700">{{ $user->office->name ?? 'N/A' }}</div>
                        <div class="text-xs text-slate-400">{{ $user->office->code ?? '' }}</div>
                    </td>
                    <td class="px-6 py-4 text-slate-500">
                        {{ $user->email }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="inline-flex rounded-lg shadow-sm">
                            <a href="{{ route('admin.users.edit', $user) }}" class="px-3 py-2 bg-white border border-slate-200 rounded-l-lg hover:bg-slate-50 text-amber-500 transition-colors" title="Edit User">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </a>
                            <button type="button" 
                                class="px-3 py-2 bg-white border-t border-b border-r border-slate-200 rounded-r-lg hover:bg-red-50 text-red-500 transition-colors"
                                title="Delete User"
                                data-bs-toggle="modal" 
                                data-bs-target="#confirmationModal"
                                data-action="{{ route('admin.users.destroy', $user) }}"
                                data-method="DELETE"
                                data-title="Delete User"
                                data-message="Are you sure you want to delete user '{{ $user->name }}'?"
                                data-btn-class="btn-danger"
                                data-btn-text="Delete">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="text-slate-300 mb-3 block mx-auto w-16 h-16">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <h5 class="text-slate-500 font-medium">No users found.</h5>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="text-slate-500 text-sm">
                Showing <strong>{{ $users->firstItem() ?? 0 }}</strong> to <strong>{{ $users->lastItem() ?? 0 }}</strong> 
                of <strong>{{ $users->total() }}</strong> user{{ $users->total() !== 1 ? 's' : '' }}
            </div>
            <div class="w-full md:w-auto">
                {{ $users->appends(request()->input())->links() }}
            </div>
        </div>
    </div>
    @else
    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
        <div class="text-slate-500 text-sm">
            Showing <strong>{{ $users->count() }}</strong> user{{ $users->count() !== 1 ? 's' : '' }}
        </div>
    </div>
    @endif
</div>
@endsection
