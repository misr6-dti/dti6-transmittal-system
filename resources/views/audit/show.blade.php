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
                        <a href="{{ route('audit.index') }}" class="ml-1 text-sm font-medium text-navy hover:text-navy-light md:ml-2">Audit History</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-slate-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="ml-1 text-sm font-medium text-slate-500 md:ml-2">Audit Detail</span>
                    </div>
                </li>
            </ol>
        </nav>
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="text-2xl font-extrabold text-navy">Audit Log Details</h2>
                <p class="text-slate-500 text-sm">Comprehensive breakdown of the recorded system action.</p>
            </div>
            
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
    <!-- Left Column: Action Details -->
    <div class="lg:col-span-2 space-y-8">
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-navy text-white rounded-xl flex items-center justify-center mr-4 shadow-lg shadow-navy/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-navy">Action Overview</h3>
                        <p class="text-xs text-slate-500 font-medium">Recorded System Log #{{ $log->id }}</p>
                    </div>
                </div>
                <span class="px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider {{ 
                    $log->action === 'Submitted' ? 'bg-blue-100 text-blue-700' : 
                    ($log->action === 'Received' ? 'bg-emerald-100 text-emerald-700' : 
                    ($log->action === 'Edited' ? 'bg-amber-100 text-amber-700' :
                    'bg-slate-100 text-slate-700')) 
                }}">
                    {{ $log->action }}
                </span>
            </div>
            
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-[0.1em] text-slate-400 mb-2">Performed By</label>
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-navy font-bold mr-3 border border-slate-200">
                                {{ substr($log->user->name, 0, 1) }}
                            </div>
                            <div>
                                <div class="text-sm font-bold text-slate-700">{{ $log->user->name }}</div>
                                <div class="text-xs text-slate-500">{{ $log->user->email }}</div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-[0.1em] text-slate-400 mb-2">Office Branch</label>
                        <div class="inline-flex items-center px-3 py-1 bg-slate-50 border border-slate-200 rounded-lg">
                            <svg class="w-3.5 h-3.5 text-navy mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-7h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            <span class="text-xs font-bold text-navy">{{ $log->user->office ? $log->user->office->name : 'System' }}</span>
                        </div>
                    </div>
                </div>

                <div class="p-5 bg-slate-50 rounded-2xl border border-slate-100">
                    <label class="block text-[10px] font-bold uppercase tracking-[0.1em] text-slate-400 mb-3">Action Description</label>
                    <p class="text-sm text-slate-600 leading-relaxed font-medium">
                        {{ $log->description }}
                    </p>
                </div>
            </div>
        </div>

        @if($log->transmittal)
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-8 py-5 border-b border-slate-100 flex justify-between items-center">
                <span class="text-sm font-bold text-navy flex items-center uppercase tracking-wider">
                    <svg class="w-5 h-5 mr-3 text-navy opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Transmittal Reference
                </span>
                <a href="{{ route('transmittals.show', $log->transmittal) }}" class="text-navy hover:text-navy-light text-xs font-bold flex items-center group">
                    View Full Details
                    <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                </a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 text-[10px] font-bold uppercase text-slate-400 tracking-[0.1em]">
                        <tr>
                            <th class="px-8 py-4">Reference #</th>
                            <th class="px-8 py-4">Routing</th>
                            <th class="px-8 py-4">Date</th>
                            <th class="px-8 py-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <tr>
                            <td class="px-8 py-5 font-bold text-navy">{{ $log->transmittal->reference_number }}</td>
                            <td class="px-8 py-5">
                                <div class="flex items-center space-x-2">
                                    <span class="text-xs font-bold text-slate-500 uppercase">{{ $log->transmittal->senderOffice ? $log->transmittal->senderOffice->code : '???' }}</span>
                                    <svg class="w-3 h-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    <span class="text-xs font-bold text-navy uppercase">{{ $log->transmittal->receiverOffice ? $log->transmittal->receiverOffice->code : '???' }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-5 text-slate-500 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($log->transmittal->transmittal_date)->format('M d, Y') }}
                            </td>
                            <td class="px-8 py-5">
                                <span class="px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider {{ 
                                    $log->transmittal->status === 'Draft' ? 'bg-slate-100 text-slate-500' : 
                                    ($log->transmittal->status === 'Submitted' ? 'bg-blue-50 text-blue-600' :
                                    'bg-emerald-50 text-emerald-600')
                                }}">
                                    {{ $log->transmittal->status }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            @if($log->transmittal->items->count() > 0)
            <div class="px-8 py-6 bg-slate-50/30">
                <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-4">Enclosure Items</h4>
                <div class="overflow-hidden bg-white border border-slate-100 rounded-2xl shadow-sm">
                    <table class="w-full text-left text-xs text-slate-600">
                        <thead class="bg-slate-50 border-b border-slate-100 text-[10px] font-bold uppercase text-slate-400 tracking-wider">
                            <tr>
                                <th class="px-6 py-3 w-20">Qty</th>
                                <th class="px-6 py-3">Description</th>
                                <th class="px-6 py-3">Remarks</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($log->transmittal->items as $item)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-navy/5 text-navy">
                                            {{ $item->quantity }} {{ $item->unit ?? 'pcs' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 font-bold text-slate-700">{{ $item->description }}</td>
                                    <td class="px-6 py-4 text-slate-400 italic">
                                        {{ $item->remarks ?? '—' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-wrap items-center gap-4 py-4 mt-4">
            @if($log->transmittal && Auth::user()->hasRole('Admin'))
                <a href="{{ route('transmittals.show', $log->transmittal) }}" class="px-6 py-3 bg-navy text-white rounded-xl font-bold hover:bg-navy-light transition-all flex items-center shadow-lg shadow-navy/20">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    View Transmittal
                </a>
            @endif
            <a href="{{ route('audit.index') }}" class="px-6 py-3 bg-white border border-slate-200 text-slate-600 rounded-xl font-bold hover:bg-slate-50 transition-all flex items-center shadow-sm">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to History
            </a>
        </div>
        @endif
    </div>

    <!-- Right Column: Meta Info -->
    <div class="space-y-6">
        <div class="bg-navy rounded-3xl p-8 text-white shadow-xl shadow-navy/20 relative overflow-hidden">
            <div class="absolute -top-12 -right-12 w-32 h-32 bg-white/5 rounded-full blur-2xl"></div>
            
            <label class="block text-[10px] font-bold uppercase tracking-[0.2em] text-white/40 mb-1">Time of Record</label>
            <div class="text-3xl font-black mb-1">{{ $log->created_at->format('h:i A') }}</div>
            <div class="text-navy-lighter opacity-70 text-sm font-bold border-b border-white/10 pb-4 mb-4">
                {{ $log->created_at->format('l') }}, {{ $log->created_at->format('F d, Y') }}
            </div>

            <div class="space-y-4">
                <div class="flex items-start">
                    <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center mr-3 mt-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm5 3a2 2 0 100-4 2 2 0 000 4z"></path></svg>
                    </div>
                    <div>
                        <div class="text-[10px] font-bold uppercase tracking-wider text-white/40">Log ID</div>
                        <div class="font-mono text-sm">#{{ str_pad($log->id, 8, '0', STR_PAD_LEFT) }}</div>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center mr-3 mt-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11V7a4 4 0 118 0v4c0 1.107.29 2.146.806 3.046l.054.09A13.917 13.917 0 0115 11V7a4 4 0 00-4-4 4 4 0 00-4 4v4c0 3.517 1.009 6.799 2.753 9.571"></path></svg>
                    </div>
                    <div>
                        <div class="text-[10px] font-bold uppercase tracking-wider text-white/40">Integrity Check</div>
                        <div class="text-emerald-400 text-sm font-bold flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            Verified Log
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm">
            <h4 class="text-sm font-bold text-navy mb-4">Security Note</h4>
            <p class="text-xs text-slate-500 leading-relaxed italic">
                This log is an immutable record. Any modifications to the system state are permanently recorded with a timestamp and the user ID of the performer.
            </p>
        </div>
    </div>
</div>
@endsection
