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
                            <span class="ml-1 text-sm font-medium text-slate-500 md:ml-2">Transmittals</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h2 class="text-2xl font-extrabold text-navy">Transmittal Ledger</h2>
            <p class="text-slate-500 text-sm">Track and manage all document movements across Region VI offices.</p>
        </div>
        @can('create', App\Models\Transmittal::class)
        <a href="{{ route('transmittals.create') }}" class="bg-navy text-white hover:bg-navy-light transition-colors px-5 py-2.5 rounded-xl font-bold flex items-center shadow-lg shadow-navy/20">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            New Entry
        </a>
        @endcan
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 mb-6 p-6 no-print">
    <form action="{{ route('transmittals.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-10 gap-4">
        <div class="lg:col-span-3">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="search" class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-navy/20 focus:border-navy text-sm transition-all" placeholder="Reference Number..." value="{{ request('search') }}">
            </div>
        </div>
        <div class="lg:col-span-2">
            <select name="status" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-navy/20 focus:border-navy text-sm transition-all appearance-none" onchange="this.form.submit()">
                <option value="">All Statuses</option>
                <option value="Draft" {{ request('status') == 'Draft' ? 'selected' : '' }}>Draft</option>
                <option value="Submitted" {{ request('status') == 'Submitted' ? 'selected' : '' }}>Submitted</option>
                <option value="Received" {{ request('status') == 'Received' ? 'selected' : '' }}>Received</option>
            </select>
        </div>
        <div class="lg:col-span-2">
            <select name="office_id" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-navy/20 focus:border-navy text-sm transition-all appearance-none" onchange="this.form.submit()">
                <option value="">All Offices</option>
                @foreach($offices as $office)
                    <option value="{{ $office->id }}" {{ request('office_id') == $office->id ? 'selected' : '' }}>{{ $office->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="lg:col-span-2">
            <div class="flex items-center space-x-2">
                <input type="date" name="date_from" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-navy/20 focus:border-navy text-sm transition-all text-slate-600" value="{{ request('date_from') }}" onchange="this.form.submit()" placeholder="From">
                <span class="text-slate-400">-</span>
                <input type="date" name="date_to" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-navy/20 focus:border-navy text-sm transition-all text-slate-600" value="{{ request('date_to') }}" onchange="this.form.submit()" placeholder="To">
            </div>
        </div>
        <div class="lg:col-span-1">
            <a href="{{ route('transmittals.index') }}" class="w-full h-full flex items-center justify-center px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl font-medium text-sm transition-colors">
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
                        <a href="{{ route('transmittals.index', array_merge(request()->input(), ['sort_by' => 'reference_number', 'sort_order' => ($sort['by'] === 'reference_number' && $sort['order'] === 'asc') ? 'desc' : 'asc'])) }}" class="flex items-center group">
                            Ref #
                            @if($sort['by'] === 'reference_number')
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
                        <a href="{{ route('transmittals.index', array_merge(request()->input(), ['sort_by' => 'transmittal_date', 'sort_order' => ($sort['by'] === 'transmittal_date' && $sort['order'] === 'asc') ? 'desc' : 'asc'])) }}" class="flex items-center group">
                            Date
                            @if($sort['by'] === 'transmittal_date')
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
                        <a href="{{ route('transmittals.index', array_merge(request()->input(), ['sort_by' => 'sender_office_id', 'sort_order' => ($sort['by'] === 'sender_office_id' && $sort['order'] === 'asc') ? 'desc' : 'asc'])) }}" class="flex items-center group">
                            Origin
                            @if($sort['by'] === 'sender_office_id')
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
                        <a href="{{ route('transmittals.index', array_merge(request()->input(), ['sort_by' => 'receiver_office_id', 'sort_order' => ($sort['by'] === 'receiver_office_id' && $sort['order'] === 'asc') ? 'desc' : 'asc'])) }}" class="flex items-center group">
                            Destination
                            @if($sort['by'] === 'receiver_office_id')
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
                    <th class="px-6 py-4">Description</th>
                    <th class="px-6 py-4 cursor-pointer hover:bg-slate-100 transition-colors">
                        <a href="{{ route('transmittals.index', array_merge(request()->input(), ['sort_by' => 'status', 'sort_order' => ($sort['by'] === 'status' && $sort['order'] === 'asc') ? 'desc' : 'asc'])) }}" class="flex items-center group">
                            Status
                            @if($sort['by'] === 'status')
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
                    <th class="px-6 py-4 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($transmittals as $t)
                <tr class="hover:bg-slate-50 transition-colors group">
                    <td class="px-6 py-4">
                        <a href="{{ route('transmittals.show', $t) }}" class="text-navy hover:text-navy-light font-bold hover:underline transition-colors">
                            {{ $t->reference_number }}
                        </a>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-slate-700">{{ $t->transmittal_date->format('M d, Y') }}</div>
                        <div class="text-xs text-slate-400">{{ $t->created_at->format('h:i A') }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-mono font-medium bg-slate-50 text-navy border border-slate-200">
                            {{ $t->senderOffice->code }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-mono font-medium bg-slate-50 text-slate-500 border border-slate-200">
                            {{ $t->receiverOffice->code }}
                        </span>
                    </td>
                    <td class="px-6 py-4 max-w-xs truncate text-slate-500" title="{{ $t->items->first()->description ?? 'No items' }}">
                        {{ $t->items->first()->description ?? '---' }}
                    </td>
                    <td class="px-6 py-4">
                        @php
                            $statusData = $t->getStatusDisplay();
                        @endphp
                        <span class="status-badge status-{{ $statusData['class'] }}">
                            {{ $statusData['label'] }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('transmittals.show', $t) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-full text-slate-400 hover:text-navy hover:bg-slate-100 transition-colors" title="View Details">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </a>
                            
                            @can('update', $t)
                                <a href="{{ route('transmittals.edit', $t) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-full text-slate-400 hover:text-amber-500 hover:bg-amber-50 transition-colors" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                            @endcan

                            @can('delete', $t)
                                <button type="button" 
                                    class="inline-flex items-center justify-center w-8 h-8 rounded-full text-slate-400 hover:text-red-500 hover:bg-red-50 transition-colors"
                                    title="Delete"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#confirmationModal"
                                    data-action="{{ route('transmittals.destroy', $t) }}"
                                    data-method="DELETE"
                                    data-title="Confirm Delete"
                                    data-message="Are you sure you want to permanently delete this transmittal record? This action cannot be undone."
                                    data-btn-class="btn-danger"
                                    data-btn-text="Delete">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            @endcan

                            @can('receive', $t)
                                <button type="button" 
                                    class="inline-flex items-center justify-center w-8 h-8 rounded-full text-slate-400 hover:text-green-600 hover:bg-green-50 transition-colors"
                                    title="Receive"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#confirmationModal"
                                    data-action="{{ route('transmittals.receive', $t) }}"
                                    data-method="PATCH"
                                    data-title="Acknowledge Receipt"
                                    data-message="By confirming, you officially acknowledge that you have physically received the hard copy documents for Transmittal #{{ $t->reference_number }}."
                                    data-btn-class="btn-success"
                                    data-btn-text="Confirm Receipt">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </button>
                            @endcan
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center">
                        <div class="text-slate-300 mb-3 block mx-auto w-16 h-16">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <h5 class="text-slate-500 font-medium">No records found matching those criteria.</h5>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($transmittals->hasPages())
    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
        {{ $transmittals->appends(request()->input())->links('pagination::tailwind') }}
    </div>
    @endif
</div>
@endsection
