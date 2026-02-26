@extends('layouts.app')

@section('content')
<div class="mb-8 print:hidden">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <nav class="flex mb-2" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('dashboard') }}" class="text-sm font-medium text-navy hover:text-navy-light">
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-slate-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <span class="ml-1 text-sm font-medium text-slate-500 md:ml-2">Document Logs</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h2 class="text-2xl font-extrabold text-navy">Document Logs</h2>
            <p class="text-sm text-slate-600 mt-1">Track documents between divisions within your office.</p>
        </div>
        <div>
            <a href="{{ route('document-logs.create') }}" class="inline-flex items-center px-4 py-2 bg-navy text-white text-sm font-medium rounded-lg hover:bg-navy-light shadow-sm transition-all">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                New Document Log
            </a>
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-600">
            <thead class="bg-slate-50 text-xs font-bold uppercase text-slate-500 tracking-wider">
                <tr>
                    <th class="px-6 py-4">Ref No.</th>
                    <th class="px-6 py-4">Date</th>
                    <th class="px-6 py-4">Route</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($documentLogs as $log)
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="px-6 py-4">
                            <a href="{{ route('document-logs.show', $log) }}" class="text-navy hover:text-navy-light font-bold hover:underline transition-colors">
                                {{ $log->reference_number }}
                            </a>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-700">{{ $log->log_date ? $log->log_date->format('M d, Y') : '---' }}</div>
                            <div class="text-xs text-slate-400">{{ $log->created_at->format('h:i A') }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-mono font-medium bg-slate-50 text-navy border border-slate-200">
                                    {{ $log->senderDivision->code }}
                                </span>
                                <svg class="w-3 h-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-mono font-medium bg-slate-50 text-slate-500 border border-slate-200">
                                    {{ $log->receiverDivision->code }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $status = $log->status;
                                $badgeClass = strtolower($status);
                                $displayStatus = $status;
                                
                                // Dynamic badge for incoming
                                if ($status === 'Submitted' && auth()->user()->division_id === $log->receiver_division_id) {
                                    $displayStatus = 'To Receive';
                                    $badgeClass = 'pending-arrival';
                                } elseif ($status === 'Submitted' && auth()->user()->division_id === $log->sender_division_id) {
                                     $badgeClass = 'submitted';
                                }
                            @endphp
                            <span class="status-badge status-{{ $badgeClass }}">
                                {{ $displayStatus }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                             <a href="{{ route('document-logs.show', $log) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-full text-slate-400 hover:text-navy hover:bg-slate-100 transition-colors" title="View Details">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400 italic">
                            No document logs found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
        {{ $documentLogs->links('pagination::tailwind') }}
    </div>
</div>
@endsection
