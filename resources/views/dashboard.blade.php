@extends('layouts.app')

@section('content')
<div x-data="{
    refresh() {
        window.location.reload();
    }
}" x-init="setInterval(() => refresh(), 60000)">
    
    <!-- Welcome Header -->
    <div class="mb-8 bg-gradient-to-r from-navy to-navy-light rounded-2xl p-6 text-white shadow-lg relative overflow-hidden">
        <!-- Background Decoration -->
        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-white/5 blur-3xl"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold mb-1">Good morning, {{ Auth::user()->name }}</h1>
                <div class="flex items-center text-blue-100 text-sm md:text-base">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    {{ Auth::user()->office->name }}
                </div>
            </div>

            <div class="flex items-center gap-4">
                <!-- Live Clock -->
                <div class="hidden md:block text-right mr-4"
                     x-data="{ 
                        time: '',
                        date: '',
                        updateTime() {
                            const now = new Date();
                            this.time = now.toLocaleTimeString('en-US', { hour12: true, hour: '2-digit', minute: '2-digit' });
                            this.date = now.toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric' });
                        }
                     }" 
                     x-init="updateTime(); setInterval(() => updateTime(), 1000)">
                    <div class="text-2xl font-bold leading-none" x-text="time"></div>
                    <div class="text-xs text-blue-200 font-medium uppercase tracking-wider" x-text="date"></div>
                </div>

                <a href="{{ route('transmittals.create') }}" class="bg-white text-navy font-bold py-3 px-6 rounded-xl hover:bg-blue-50 transition-all shadow-md flex items-center transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    New Transmittal
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        
        <!-- Office Overview (Stats) -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="font-bold text-navy text-lg flex items-center">
                    <svg class="w-5 h-5 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    Office Overview
                </h3>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <!-- Sent -->
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 group hover:border-blue-200 transition-colors">
                    <div class="flex items-center justify-between mb-2">
                        <div class="text-xs font-bold uppercase tracking-wider text-slate-500">Sent</div>
                        <div class="text-blue-600 bg-blue-100 p-1.5 rounded-lg group-hover:bg-blue-600 group-hover:text-white transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        </div>
                    </div>
                    <div class="text-2xl font-extrabold text-navy" id="totalSentDash">{{ $stats['total_sent'] }}</div>
                </div>

                <!-- Received -->
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 group hover:border-green-200 transition-colors">
                    <div class="flex items-center justify-between mb-2">
                        <div class="text-xs font-bold uppercase tracking-wider text-slate-500">Received</div>
                        <div class="text-green-600 bg-green-100 p-1.5 rounded-lg group-hover:bg-green-600 group-hover:text-white transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                        </div>
                    </div>
                    <div class="text-2xl font-extrabold text-navy" id="totalReceivedDash">{{ $stats['total_received'] }}</div>
                </div>

                <!-- Pending Out -->
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 group hover:border-amber-200 transition-colors">
                    <div class="flex items-center justify-between mb-2">
                        <div class="text-xs font-bold uppercase tracking-wider text-slate-500">Pending Out</div>
                        <div class="text-amber-600 bg-amber-100 p-1.5 rounded-lg group-hover:bg-amber-600 group-hover:text-white transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                    <div class="text-2xl font-extrabold text-navy" id="pendingOutgoingDash">{{ $stats['pending_outgoing'] }}</div>
                </div>

                <!-- Pending In -->
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 group hover:border-cyan-200 transition-colors">
                    <div class="flex items-center justify-between mb-2">
                        <div class="text-xs font-bold uppercase tracking-wider text-slate-500">Pending In</div>
                        <div class="text-cyan-600 bg-cyan-100 p-1.5 rounded-lg group-hover:bg-cyan-600 group-hover:text-white transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                        </div>
                    </div>
                    <div class="text-2xl font-extrabold text-navy" id="pendingIncomingDash">{{ $stats['pending_incoming'] }}</div>
                </div>
            </div>
        </div>

        <!-- Division Stats (Conditional) -->
        <div class="lg:col-span-1 bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex flex-col">
            @if(Auth::user()->division_id)
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-bold text-navy text-lg flex items-center">
                        <svg class="w-5 h-5 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        My Division
                    </h3>
                    <span class="px-2 py-1 rounded text-xs font-bold bg-navy text-white">{{ Auth::user()->division->code }}</span>
                </div>

                <div class="space-y-4 flex-grow">
                    <!-- Division Sent -->
                    <div class="flex items-center justify-between p-3 rounded-xl hover:bg-slate-50 transition-colors border border-transparent hover:border-slate-100">
                        <div class="flex items-center text-slate-600">
                            <span class="w-2 h-2 rounded-full bg-indigo-500 mr-3"></span>
                            <span class="text-sm font-medium">Documents Sent</span>
                        </div>
                        <span class="font-bold text-navy">{{ $stats['doc_logs_sent'] }}</span>
                    </div>

                    <!-- Division Received -->
                    <div class="flex items-center justify-between p-3 rounded-xl hover:bg-slate-50 transition-colors border border-transparent hover:border-slate-100">
                        <div class="flex items-center text-slate-600">
                            <span class="w-2 h-2 rounded-full bg-teal-500 mr-3"></span>
                            <span class="text-sm font-medium">Documents Received</span>
                        </div>
                        <span class="font-bold text-navy">{{ $stats['doc_logs_received'] }}</span>
                    </div>

                    <!-- Division Pending -->
                    <div class="flex items-center justify-between p-3 rounded-xl hover:bg-slate-50 transition-colors border border-transparent hover:border-slate-100">
                        <div class="flex items-center text-slate-600">
                            <span class="w-2 h-2 rounded-full bg-pink-500 mr-3"></span>
                            <span class="text-sm font-medium">Pending Receipt</span>
                        </div>
                        <span class="font-bold text-navy">{{ $stats['doc_logs_pending'] }}</span>
                    </div>
                </div>
                
                <div class="mt-6 pt-4 border-t border-slate-100">
                    <a href="{{ route('document-logs.index') }}" class="text-xs font-bold uppercase tracking-wider text-center block text-navy hover:text-navy-light transition-colors">
                        View Document Logs &rarr;
                    </a>
                </div>
            @else
                <div class="flex flex-col items-center justify-center h-full text-center text-slate-400 py-8">
                    <svg class="w-12 h-12 mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="text-sm">You are not assigned to a division.</p>
                </div>
            @endif
        </div>

    </div>

    <!-- Recent Transmittals Table -->
    <x-dashboard.recent-transmittals :transmittals="$recentTransmittals" />
</div>
@endsection
