@extends('layouts.public')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-200 flex items-center justify-center p-4 print:p-0 print:bg-white">
    <div class="w-full max-w-lg">
        @if ($transmittal)
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-slate-100 transition-all duration-300 hover:shadow-2xl print:shadow-none print:border-none">
                <!-- Card Header -->
                <div class="p-8 bg-gradient-to-r from-navy to-blue-900 text-white flex justify-between items-start gap-4">
                    <div>
                        <h2 class="text-3xl font-bold tracking-tight mb-1">{{ $transmittal->reference_number }}</h2>
                        <p class="text-blue-200 text-sm font-medium">Transmittal Tracking</p>
                    </div>
                    @php
                        $statusColors = [
                            'Draft' => 'bg-slate-500/20 text-slate-100 border-slate-400/30',
                            'Submitted' => 'bg-amber-500/20 text-amber-100 border-amber-400/30',
                            'Received' => 'bg-emerald-500/20 text-emerald-100 border-emerald-400/30',
                            'Returned' => 'bg-rose-500/20 text-rose-100 border-rose-400/30'
                        ];
                        $statusClass = $statusColors[$transmittal->status] ?? 'bg-slate-500/20 text-slate-100 border-slate-400/30';
                    @endphp
                    <span class="px-3 py-1 rounded-lg text-xs font-bold uppercase tracking-wider border backdrop-blur-sm {{ $statusClass }}">
                        {{ $transmittal->status }}
                    </span>
                </div>

                <!-- Card Body -->
                <div class="p-8">
                    <!-- Date Information -->
                    <div class="space-y-4 mb-8">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Execution Date</label>
                            <p class="text-lg font-bold text-navy">{{ \Carbon\Carbon::parse($transmittal->transmittal_date)->format('F d, Y') }}</p>
                        </div>
                        @if ($transmittal->received_at)
                            <div>
                                <label class="block text-xs font-bold text-emerald-600 uppercase tracking-wider mb-1">
                                    <svg class="w-3 h-3 inline mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                    Received Date
                                </label>
                                <p class="text-lg font-bold text-navy">{{ \Carbon\Carbon::parse($transmittal->received_at)->format('F d, Y h:i A') }}</p>
                            </div>
                        @endif
                    </div>

                    <div class="h-px bg-slate-100 w-full mb-8"></div>

                    <!-- Location Information -->
                    <div class="relative">
                        <!-- Connecting Line -->
                        <div class="absolute top-1/2 left-0 right-0 h-0.5 bg-slate-100 -translate-y-1/2 md:block hidden"></div>
                        
                        <div class="flex flex-col md:flex-row justify-between items-center gap-8 md:gap-4 relative z-10">
                            <!-- From -->
                            <div class="text-center bg-white p-2">
                                <div class="w-14 h-14 mx-auto bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-blue-500/30 mb-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">From</label>
                                <p class="text-lg font-bold text-navy leading-none mb-1">{{ $transmittal->senderOffice->code }}</p>
                                <p class="text-xs text-slate-500 font-medium max-w-[120px] mx-auto leading-tight">{{ $transmittal->senderOffice->name }}</p>
                            </div>

                            <!-- Arrow (Mobile: Down, Desktop: Right) -->
                            <div class="text-slate-300 md:rotate-0 rotate-90 bg-white p-2 rounded-full">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </div>

                            <!-- To -->
                            <div class="text-center bg-white p-2">
                                <div class="w-14 h-14 mx-auto bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-purple-500/30 mb-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-8a2 2 0 012-2h14a2 2 0 012 2v8"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                </div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">To</label>
                                <p class="text-lg font-bold text-navy leading-none mb-1">{{ $transmittal->receiverOffice->code }}</p>
                                <p class="text-xs text-slate-500 font-medium max-w-[120px] mx-auto leading-tight">{{ $transmittal->receiverOffice->name }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Footer -->
                <div class="px-8 py-6 bg-slate-50 border-t border-slate-100">
                    <p class="text-xs text-slate-500 flex items-center justify-center text-center">
                        <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        This page is publicly accessible. Do not share this link with unauthorized persons.
                    </p>
                </div>

                <!-- Receive Action for Authorized Users -->
                @auth
                    @if(Auth::user()->can('receive', $transmittal) && $transmittal->status === 'Submitted')
                        <div class="p-8 border-t border-slate-100 bg-slate-50/50">
                            <form action="{{ route('transmittals.receive', $transmittal) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="w-full py-4 bg-navy hover:bg-navy-light text-white rounded-xl font-bold uppercase tracking-wider shadow-lg shadow-navy/20 transition-all transform hover:-translate-y-0.5 flex items-center justify-center" onclick="return confirm('Are you sure you want to mark this transmittal as RECEIVED?')">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                    Mark as Received
                                </button>
                            </form>
                            <p class="text-center text-xs text-navy/60 font-medium mt-3">You are authorized to receive this document.</p>
                        </div>
                    @endif
                @endauth
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-red-100">
                <div class="p-12 text-center">
                    <div class="w-20 h-20 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-6 text-red-500">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Transmittal Not Found</h3>
                    <p class="text-slate-500 max-w-xs mx-auto text-sm leading-relaxed">{{ $error ?? 'The transmittal reference number could not be found in the system. Please check the QR code or reference number and try again.' }}</p>
                </div>
                <div class="px-8 py-4 bg-slate-50 border-t border-slate-100 text-center">
                   <a href="{{ route('transmittals.index') }}" class="text-navy font-bold text-sm hover:underline">Return to Home</a> 
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
