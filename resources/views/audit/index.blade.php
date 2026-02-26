@extends('layouts.app')

@section('content')
<div class="mb-8">
    <div class="no-print">
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
                        <span class="ml-1 text-sm font-medium text-slate-500 md:ml-2">Audit History</span>
                    </div>
                </li>
            </ol>
        </nav>
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="text-2xl font-extrabold text-navy">System Audit Trail</h2>
                <p class="text-slate-500 text-sm">Comprehensive record of all transmittal modifications and movements.</p>
            </div>
            <div class="inline-flex items-center px-3 py-1 rounded-full bg-navy text-white text-xs font-bold shadow-md shadow-navy/20">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                Secure Logs
            </div>
        </div>
    </div>
</div>

@if(Auth::user()->hasRole('admin'))
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 mb-6 p-6 no-print">
    <form action="{{ route('audit.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4">
        <div class="md:col-span-4">
            <label class="block text-xs font-bold uppercase text-slate-400 mb-1">Search Records</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="search" class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-navy/20 focus:border-navy text-sm transition-all" placeholder="Ref # or description..." value="{{ request('search') }}">
            </div>
        </div>
        <div class="md:col-span-3">
            <label class="block text-xs font-bold uppercase text-slate-400 mb-1">Office</label>
            <select name="office_id" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-navy/20 focus:border-navy text-sm transition-all appearance-none" onchange="this.form.submit()">
                <option value="">All Offices</option>
                @foreach($offices as $office)
                    <option value="{{ $office->id }}" {{ request('office_id') == $office->id ? 'selected' : '' }}>
                        {{ $office->code }} - {{ $office->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="md:col-span-3">
            <label class="block text-xs font-bold uppercase text-slate-400 mb-1">Action Protocol</label>
            <select name="action" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-navy/20 focus:border-navy text-sm transition-all appearance-none" onchange="this.form.submit()">
                <option value="">All Actions</option>
                <option value="Submitted" {{ request('action') == 'Submitted' ? 'selected' : '' }}>Submitted</option>
                <option value="Received" {{ request('action') == 'Received' ? 'selected' : '' }}>Received</option>
                <option value="Edited" {{ request('action') == 'Edited' ? 'selected' : '' }}>Edited</option>
                <option value="Draft" {{ request('action') == 'Draft' ? 'selected' : '' }}>Drafted</option>
            </select>
        </div>
        <div class="md:col-span-2 flex items-end">
            <div class="flex w-full gap-2">
                <button type="submit" class="flex-grow bg-navy text-white hover:bg-navy-light transition-colors px-4 py-2.5 rounded-xl font-bold text-sm shadow-lg shadow-navy/20">
                    Filter
                </button>
                <a href="{{ route('audit.index') }}" class="flex items-center justify-center px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl font-medium text-sm transition-colors" title="Clear Filters">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                </a>
            </div>
        </div>
    </form>
</div>
@endif

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-600">
            <thead class="bg-slate-50 text-xs font-bold uppercase text-slate-500 tracking-wider">
                <tr>
                    <th class="px-6 py-4 cursor-pointer hover:bg-slate-100 transition-colors">
                        <a href="{{ route('audit.index', array_merge(request()->input(), ['sort_by' => 'created_at', 'sort_order' => ($sort['by'] === 'created_at' && $sort['order'] === 'asc') ? 'desc' : 'asc'])) }}" class="flex items-center group">
                            Timestamp
                            @if($sort['by'] === 'created_at')
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
                        <a href="{{ route('audit.index', array_merge(request()->input(), ['sort_by' => 'transmittal_id', 'sort_order' => ($sort['by'] === 'transmittal_id' && $sort['order'] === 'asc') ? 'desc' : 'asc'])) }}" class="flex items-center group">
                            Ref #
                            @if($sort['by'] === 'transmittal_id')
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
                        <a href="{{ route('audit.index', array_merge(request()->input(), ['sort_by' => 'action', 'sort_order' => ($sort['by'] === 'action' && $sort['order'] === 'asc') ? 'desc' : 'asc'])) }}" class="flex items-center group">
                            Status
                            @if($sort['by'] === 'action')
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
                        <a href="{{ route('audit.index', array_merge(request()->input(), ['sort_by' => 'sender_office_id', 'sort_order' => ($sort['by'] === 'sender_office_id' && $sort['order'] === 'asc') ? 'desc' : 'asc'])) }}" class="flex items-center group">
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
                        <a href="{{ route('audit.index', array_merge(request()->input(), ['sort_by' => 'receiver_office_id', 'sort_order' => ($sort['by'] === 'receiver_office_id' && $sort['order'] === 'asc') ? 'desc' : 'asc'])) }}" class="flex items-center group">
                            Recipient Office
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
                    <th class="px-6 py-4 cursor-pointer hover:bg-slate-100 transition-colors">
                        <a href="{{ route('audit.index', array_merge(request()->input(), ['sort_by' => 'user_id', 'sort_order' => ($sort['by'] === 'user_id' && $sort['order'] === 'asc') ? 'desc' : 'asc'])) }}" class="flex items-center group">
                            By
                            @if($sort['by'] === 'user_id')
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
                @forelse($logs as $log)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="font-bold text-slate-700">{{ $log->created_at->format('M d, Y') }}</div>
                        <div class="text-xs text-slate-400">{{ $log->created_at->format('h:i A') }}</div>
                    </td>
                    <td class="px-6 py-4">
                        @if($log->transmittal)
                        <a href="{{ route('transmittals.show', $log->transmittal) }}" class="text-navy hover:text-navy-light font-bold hover:underline transition-colors">
                            {{ $log->transmittal->reference_number }}
                        </a>
                        @else
                        <span class="text-slate-400">N/A</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($log->action === 'Submitted')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">Submitted</span>
                        @elseif($log->action === 'Received')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">Received</span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600 border border-slate-200">{{ $log->action }}</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-mono font-medium bg-slate-50 text-navy border border-slate-200">
                            {{ $log->user->office->code ?? 'SYS' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-mono font-medium bg-slate-50 text-slate-500 border border-slate-200">
                            {{ $log->transmittal->receiverOffice->code ?? 'N/A' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-slate-600">{{ $log->user->name }}</div>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="inline-flex rounded-lg shadow-sm">
                            <a href="{{ route('audit.show', $log) }}" class="px-3 py-2 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 text-cyan-600 transition-colors" title="View Audit Details">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center">
                        <div class="text-slate-300 mb-3 block mx-auto w-16 h-16">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <h5 class="text-slate-500 font-medium">No audit records found.</h5>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($logs->hasPages())
    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="text-slate-500 text-sm">
                Showing <strong>{{ $logs->firstItem() ?? 0 }}</strong> to <strong>{{ $logs->lastItem() ?? 0 }}</strong> 
                of <strong>{{ $logs->total() }}</strong> records
            </div>
            <div class="w-full md:w-auto">
                {{ $logs->appends(request()->input())->links() }}
            </div>
        </div>
    </div>
    @else
    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
        <div class="text-slate-500 text-sm">
            Showing <strong>{{ $logs->count() }}</strong> record{{ $logs->count() !== 1 ? 's' : '' }}
        </div>
    </div>
    @endif
</div>
@endsection
