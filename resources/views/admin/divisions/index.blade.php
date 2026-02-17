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
                            <span class="ml-1 text-sm font-medium text-slate-500 md:ml-2">Division Management</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h2 class="text-2xl font-extrabold text-navy">Division Management</h2>
            <p class="text-slate-500 text-sm">Manage organizational divisions within offices.</p>
        </div>
        <a href="{{ route('admin.divisions.create') }}" class="bg-navy text-white hover:bg-navy-light transition-colors px-5 py-2.5 rounded-xl font-bold flex items-center shadow-lg shadow-navy/20">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            New Division
        </a>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 mb-6 p-6 no-print">
    <form action="{{ route('admin.divisions.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4">
        <div class="md:col-span-10">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="search" class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-navy/20 focus:border-navy text-sm transition-all" placeholder="Search by name or code..." value="{{ request('search') }}">
            </div>
        </div>
        <div class="md:col-span-2">
            <a href="{{ route('admin.divisions.index') }}" class="w-full h-full flex items-center justify-center px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl font-medium text-sm transition-colors">
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
                        <a href="{{ route('admin.divisions.index', array_merge(request()->input(), ['sort_by' => 'name', 'sort_order' => ($sort['by'] === 'name' && $sort['order'] === 'asc') ? 'desc' : 'asc'])) }}" class="flex items-center group">
                            Division Name
                            @if($sort['by'] === 'name')
                                <span class="ml-2 text-navy">
                                    @if($sort['order'] === 'asc')
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                    @else
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    @endif
                                </span>
                            @else
                                <svg class="w-3 h-3 ml-2 text-slate-300 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path></svg>
                            @endif
                        </a>
                    </th>
                    <th class="px-6 py-4 cursor-pointer hover:bg-slate-100 transition-colors">
                        <a href="{{ route('admin.divisions.index', array_merge(request()->input(), ['sort_by' => 'code', 'sort_order' => ($sort['by'] === 'code' && $sort['order'] === 'asc') ? 'desc' : 'asc'])) }}" class="flex items-center group">
                            Code
                            @if($sort['by'] === 'code')
                                <span class="ml-2 text-navy">
                                    @if($sort['order'] === 'asc')
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                    @else
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    @endif
                                </span>
                            @else
                                <svg class="w-3 h-3 ml-2 text-slate-300 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path></svg>
                            @endif
                        </a>
                    </th>
                    <th class="px-6 py-4 cursor-pointer hover:bg-slate-100 transition-colors">
                        <a href="{{ route('admin.divisions.index', array_merge(request()->input(), ['sort_by' => 'office_id', 'sort_order' => ($sort['by'] === 'office_id' && $sort['order'] === 'asc') ? 'desc' : 'asc'])) }}" class="flex items-center group">
                            Office
                            @if($sort['by'] === 'office_id')
                                <span class="ml-2 text-navy">
                                    @if($sort['order'] === 'asc')
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                    @else
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    @endif
                                </span>
                            @else
                                <svg class="w-3 h-3 ml-2 text-slate-300 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path></svg>
                            @endif
                        </a>
                    </th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($divisions as $division)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4 font-bold text-slate-700">{{ $division->name }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-700 border border-slate-200">
                            {{ $division->code }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-slate-600">{{ $division->office->name }}</td>
                    <td class="px-6 py-4 text-right">
                        <div class="inline-flex rounded-lg shadow-sm">
                            <a href="{{ route('admin.divisions.edit', $division) }}" class="px-3 py-2 bg-white border border-slate-200 rounded-l-lg hover:bg-slate-50 text-amber-500 transition-colors" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </a>
                            <button type="button" 
                                class="px-3 py-2 bg-white border-t border-b border-r border-slate-200 rounded-r-lg hover:bg-red-50 text-red-500 transition-colors"
                                title="Delete Division"
                                data-bs-toggle="modal" 
                                data-bs-target="#confirmationModal"
                                data-action="{{ route('admin.divisions.destroy', $division) }}"
                                data-method="DELETE"
                                data-title="Delete Division"
                                data-message="Are you sure you want to delete the '{{ $division->name }}' division?"
                                data-btn-class="btn-danger"
                                data-btn-text="Delete">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center">
                        <div class="text-slate-300 mb-3 block mx-auto w-16 h-16">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </div>
                        <h5 class="text-slate-500 font-medium">No divisions found.</h5>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($divisions->hasPages())
    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="text-slate-500 text-sm">
                Showing <strong>{{ $divisions->firstItem() ?? 0 }}</strong> to <strong>{{ $divisions->lastItem() ?? 0 }}</strong> 
                of <strong>{{ $divisions->total() }}</strong> division{{ $divisions->total() !== 1 ? 's' : '' }}
            </div>
            <div class="w-full md:w-auto">
                {{ $divisions->appends(request()->input())->links() }}
            </div>
        </div>
    </div>
    @else
    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
        <div class="text-slate-500 text-sm">
            Showing <strong>{{ $divisions->count() }}</strong> division{{ $divisions->count() !== 1 ? 's' : '' }}
        </div>
    </div>
    @endif
</div>
@endsection
