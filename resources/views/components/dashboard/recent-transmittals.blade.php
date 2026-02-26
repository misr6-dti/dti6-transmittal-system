<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="p-6 border-b border-slate-100 flex justify-between items-center">
        <div class="flex flex-col">
            <h3 class="font-bold text-navy text-lg">Recent Transmittals</h3>
            <p class="text-slate-500 text-sm">Latest transmittal records and updates.</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('audit.index') }}" class="text-xs font-bold uppercase tracking-wider text-slate-500 hover:text-navy transition-colors bg-slate-50 px-3 py-2 rounded-lg border border-transparent hover:border-slate-200">
                Audit Trail
            </a>
            <a href="{{ route('transmittals.index') }}" class="text-xs font-bold uppercase tracking-wider text-white bg-navy hover:bg-navy-dark transition-colors px-3 py-2 rounded-lg shadow-sm">
                View All
            </a>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-600">
            <thead class="bg-slate-50 text-xs font-bold uppercase text-slate-500 tracking-wider">
                <tr>
                    <th class="px-6 py-4">Date</th>
                    <th class="px-6 py-4">Ref #</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Origin</th>
                    <th class="px-6 py-4">Recipient</th>
                    <th class="px-6 py-4">By</th>
                    <th class="px-6 py-4 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($transmittals as $t)
                <tr class="hover:bg-slate-50 transition-colors group">
                    <td class="px-6 py-4">
                        <div class="font-bold text-slate-700">{{ $t->transmittal_date->format('M d, Y') }}</div>
                        <div class="text-xs text-slate-400">{{ $t->created_at->format('h:i A') }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('transmittals.show', $t) }}" class="text-navy hover:text-navy-light font-bold hover:underline transition-colors">
                            {{ $t->reference_number }}
                        </a>
                    </td>
                    <td class="px-6 py-4">
                        @php
                            $statusData = $t->getStatusDisplay();
                        @endphp
                        <span class="status-badge status-{{ $statusData['class'] }}">
                            {{ $statusData['label'] }}
                        </span>
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
                    <td class="px-6 py-4">
                        <div class="font-medium text-slate-600">{{ $t->sender->name }}</div>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('transmittals.show', $t) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-full text-slate-400 hover:text-navy hover:bg-slate-100 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-slate-400 italic">No recent transmittals found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($transmittals->hasPages())
    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
        {{ $transmittals->appends(request()->query())->links('pagination::tailwind') }}
    </div>
    @endif
</div>
