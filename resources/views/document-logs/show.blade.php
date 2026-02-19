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
                            <a href="{{ route('document-logs.index') }}" class="ml-1 text-sm font-medium text-navy hover:text-navy-light md:ml-2">
                                Document Logs
                            </a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-slate-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <span class="ml-1 text-sm font-medium text-slate-500 md:ml-2">{{ $documentLog->reference_number }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h2 class="text-2xl font-extrabold text-navy">Document Log Details</h2>
        </div>
        <div class="flex gap-2">
            @can('update', $documentLog)
                <a href="{{ route('document-logs.edit', $documentLog) }}" class="inline-flex items-center px-4 py-2 bg-white border border-slate-200 text-slate-600 text-sm font-medium rounded-lg hover:bg-slate-50 transition-all">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Edit
                </a>
            @endcan

            @can('receive', $documentLog)
                <form action="{{ route('document-logs.receive', $documentLog) }}" method="POST" onsubmit="return confirm('Confirm receipt of this document?')">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 shadow-sm transition-all">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Receive Document
                    </button>
                </form>
            @endcan
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Info -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Reference Number</h3>
                    <p class="text-lg font-bold text-navy font-mono">{{ $documentLog->reference_number }}</p>
                </div>
                <div>
                    <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Date</h3>
                    <p class="text-lg font-medium text-slate-800">{{ $documentLog->log_date->format('F d, Y') }}</p>
                </div>
                <div>
                    <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">From</h3>
                    <p class="font-medium text-slate-800">{{ $documentLog->senderDivision->name }} ({{ $documentLog->senderDivision->code }})</p>
                    <p class="text-sm text-slate-500">{{ $documentLog->sender->name }}</p>
                </div>
                <div>
                    <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">To</h3>
                    <p class="font-medium text-slate-800">{{ $documentLog->receiverDivision->name }} ({{ $documentLog->receiverDivision->code }})</p>
                    @if($documentLog->receiver)
                         <p class="text-sm text-slate-500">Received by: {{ $documentLog->receiver->name }}</p>
                    @endif
                </div>
                 <div class="md:col-span-2">
                    <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Items</h3>
                    <div class="overflow-x-auto border border-slate-100 rounded-lg">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-slate-50 text-xs text-slate-500 uppercase font-bold border-b border-slate-100">
                                <tr>
                                    <th class="px-4 py-2 w-20">Qty</th>
                                    <th class="px-4 py-2 w-24">Unit</th>
                                    <th class="px-4 py-2">Description</th>
                                    <th class="px-4 py-2">Remarks</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($documentLog->items as $item)
                                    <tr class="hover:bg-slate-50/50">
                                        <td class="px-4 py-2 font-medium">{{ $item->quantity + 0 }}</td> <!-- +0 removes trailing zeros -->
                                        <td class="px-4 py-2 text-slate-500">{{ $item->unit }}</td>
                                        <td class="px-4 py-2 text-slate-700">{{ $item->description }}</td>
                                        <td class="px-4 py-2 text-slate-500 italic">{{ $item->remarks }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($documentLog->remarks)
                <div class="md:col-span-2">
                    <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Remarks</h3>
                    <p class="text-slate-700 bg-slate-50 p-3 rounded-lg border border-slate-100">{{ $documentLog->remarks }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Sidebar: Status & Audit Trail -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Status Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
             <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-4">Current Status</h3>
             @php
                $statusClasses = [
                    'Draft' => 'bg-slate-100 text-slate-600 border-slate-200',
                    'Submitted' => 'bg-blue-50 text-blue-600 border-blue-200',
                    'Received' => 'bg-emerald-50 text-emerald-600 border-emerald-200',
                ];
                $statusClass = $statusClasses[$documentLog->status] ?? 'bg-slate-100 text-slate-600 border-slate-200';
             @endphp
             <div class="flex items-center justify-center p-4 rounded-xl border {{ $statusClass }}">
                 <span class="text-lg font-bold">{{ $documentLog->status }}</span>
             </div>
        </div>

        <!-- Audit Trail -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-4">Audit Trail</h3>
            <div class="relative pl-4 border-l-2 border-slate-100 space-y-6">
                @foreach($documentLog->entries->sortByDesc('created_at') as $entry)
                    <div class="relative">
                        <div class="absolute -left-[21px] top-1 w-3 h-3 rounded-full border-2 border-white 
                            {{ $entry->action === 'Received' ? 'bg-emerald-500' : ($entry->action === 'Submitted' ? 'bg-blue-500' : 'bg-slate-400') }}"></div>
                        
                        <p class="text-sm font-medium text-slate-800">{{ $entry->action }}</p>
                        <p class="text-xs text-slate-500 mb-1">{{ $entry->created_at->format('M d, Y h:i A') }}</p>
                        <p class="text-xs text-slate-600">{{ $entry->description }}</p>
                        <p class="text-[10px] text-slate-400 mt-0.5">by {{ $entry->user->name }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
