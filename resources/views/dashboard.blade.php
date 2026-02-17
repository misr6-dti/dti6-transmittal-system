@extends('layouts.app')

@section('content')
<div x-data="{
    refresh() {
        window.location.reload();
    }
}" x-init="setInterval(() => refresh(), 60000)">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Sent -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
            <div class="flex items-center mb-4">
                <div class="bg-blue-50 p-3 rounded-xl text-blue-600 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                </div>
                <div>
                    <div class="text-xs font-bold uppercase tracking-wider text-slate-500">Total Sent</div>
                    <div class="text-2xl font-extrabold text-navy" id="totalSentDash">{{ $stats['total_sent'] }}</div>
                </div>
            </div>
            <div class="text-xs text-slate-400">From {{ Auth::user()->office->name }}</div>
        </div>

        <!-- Total Received -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
            <div class="flex items-center mb-4">
                <div class="bg-green-50 p-3 rounded-xl text-green-600 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                </div>
                <div>
                    <div class="text-xs font-bold uppercase tracking-wider text-slate-500">Total Received</div>
                    <div class="text-2xl font-extrabold text-navy" id="totalReceivedDash">{{ $stats['total_received'] }}</div>
                </div>
            </div>
            <div class="text-xs text-slate-400">At {{ Auth::user()->office->name }}</div>
        </div>

        <!-- Pending Outgoing -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
            <div class="flex items-center mb-4">
                <div class="bg-amber-50 p-3 rounded-xl text-amber-600 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <div class="text-xs font-bold uppercase tracking-wider text-slate-500">Pending Outgoing</div>
                    <div class="text-2xl font-extrabold text-navy" id="pendingOutgoingDash">{{ $stats['pending_outgoing'] }}</div>
                </div>
            </div>
            <div class="text-xs text-amber-600 font-medium">Awaiting receipt</div>
        </div>

        <!-- Pending Incoming -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
            <div class="flex items-center mb-4">
                <div class="bg-cyan-50 p-3 rounded-xl text-cyan-600 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                </div>
                <div>
                    <div class="text-xs font-bold uppercase tracking-wider text-slate-500">Pending Incoming</div>
                    <div class="text-2xl font-extrabold text-navy" id="pendingIncomingDash">{{ $stats['pending_incoming'] }}</div>
                </div>
            </div>
            <div class="text-xs text-cyan-600 font-medium">To be claimed</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Transmittals -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 h-full flex flex-col">
                <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                    <h3 class="font-bold text-navy text-lg">Recent Office Transmittals</h3>
                    <a href="{{ route('transmittals.index') }}" class="text-xs font-bold uppercase tracking-wider text-slate-500 hover:text-navy transition-colors bg-slate-50 px-3 py-2 rounded-lg">View All</a>
                </div>
                <div class="flex-grow overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50 text-xs font-bold uppercase text-slate-500 tracking-wider">
                            <tr>
                                <th class="px-6 py-4">Ref #</th>
                                <th class="px-6 py-4">Date</th>
                                <th class="px-6 py-4">Origin</th>
                                <th class="px-6 py-4">Destination</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100" id="recentTransmittalsBody">
                            @forelse($recentTransmittals as $t)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 font-bold text-navy">{{ $t->reference_number }}</td>
                                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($t->transmittal_date)->format('M d, Y') }}</td>
                                <td class="px-6 py-4">{{ $t->senderOffice->name }}</td>
                                <td class="px-6 py-4">{{ $t->receiverOffice->name }}</td>
                                <td class="px-6 py-4">
                                    @php
                                        $userOfficeId = Auth::user()->office_id;
                                        $isAdmin = Auth::user()->hasAnyRole(['Super Admin', 'Regional MIS']);
                                        $displayStatus = $t->status;
                                        $badgeClass = strtolower($t->status);

                                        if (!$isAdmin && $t->status === 'Submitted') {
                                            if ($t->receiver_office_id == $userOfficeId) {
                                                $displayStatus = 'To Receive';
                                                $badgeClass = 'pending-arrival';
                                            } elseif ($t->sender_office_id == $userOfficeId) {
                                                $displayStatus = 'Pending Receipt';
                                                $badgeClass = 'submitted';
                                            }
                                        }
                                    @endphp
                                    <span class="status-badge status-{{ $badgeClass }}">
                                        {{ $displayStatus }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('transmittals.show', $t) }}" class="px-2.5 py-1.5 text-xs font-medium text-navy bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors">View</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-slate-400 italic">No recent transmittals found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($recentTransmittals->hasPages())
                <div class="p-4 border-t border-slate-100">
                    {{ $recentTransmittals->links() }}
                </div>
                @endif
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="lg:col-span-1">
            <div class="bg-navy rounded-2xl shadow-lg shadow-navy/20 text-white h-full p-6 flex flex-col relative overflow-hidden">
                <!-- Decorative background elements -->
                <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 rounded-full bg-white/5 blur-2xl"></div>
                <div class="absolute bottom-0 left-0 -ml-8 -mb-8 w-32 h-32 rounded-full bg-white/5 blur-2xl"></div>
                
                <div class="relative z-10">
                    <h3 class="font-extrabold text-2xl mb-2">Manage Your Documents</h3>
                    <p class="text-white/70 text-sm mb-8">Quickly create and track transmittals between Regional Office and Provincial Offices.</p>
                    
                    <div class="flex flex-col gap-3">
                        <a href="{{ route('transmittals.create') }}" class="w-full bg-white text-navy font-bold py-3 px-4 rounded-xl hover:bg-white/90 transition-colors flex items-center justify-center shadow-md">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            New Transmittal
                        </a>
                        <a href="{{ route('audit.index') }}" class="w-full bg-white/10 text-white font-bold py-3 px-4 rounded-xl hover:bg-white/20 transition-colors flex items-center justify-center border border-white/20">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Audit History
                        </a>
                    </div>
                </div>

                <div class="mt-8 pt-8 border-t border-white/10 relative z-10">
                    <div class="text-xs font-bold uppercase tracking-widest text-white/40 mb-4">Standard Protocol</div>
                    <ul class="space-y-3 text-sm text-white/70">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-2 text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>Prepare copies in triplicate</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-2 text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>Verify Ref # before printing</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-2 text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>Confirm receipt upon receiving the actual (hard) copy</span>
                        </li>
                    </ul>

                    <div class="mt-8 bg-white/10 rounded-xl p-4 text-center backdrop-blur-sm" 
                         x-data="{ 
                            time: '',
                            date: '',
                            updateTime() {
                                const now = new Date();
                                this.time = now.toLocaleTimeString('en-US', { hour12: true, hour: '2-digit', minute: '2-digit', second: '2-digit' });
                                this.date = now.toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric', year: 'numeric' });
                            }
                         }" 
                         x-init="updateTime(); setInterval(() => updateTime(), 1000)">
                        <div class="text-xs font-bold uppercase tracking-widest text-white/40 mb-1">Official PH Time</div>
                        <div class="text-2xl font-extrabold text-white tabular-nums leading-none mb-1" x-text="time"></div>
                        <div class="text-xs text-white/60" x-text="date"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
