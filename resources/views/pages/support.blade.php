<x-guest-layout>
    <x-slot name="info">
        <h1 class="info-title">MIS Help & Support</h1>
        <p class="info-text">
            For account recovery, system assistance, or report disputes, our team is ready to help.
        </p>
        <div class="mt-5">
            <div class="flex items-center mb-4 text-white/50">
                <svg class="w-6 h-6 mr-3 text-white flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                <div>
                    <div class="text-xs font-bold uppercase text-white">Regional Office</div>
                    <div class="text-sm">DTI Region VI, Iloilo City</div>
                </div>
            </div>
            <div class="flex items-center mb-4 text-white/50">
                <svg class="w-6 h-6 mr-3 text-white flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                <div>
                    <div class="text-xs font-bold uppercase text-white">Email Support</div>
                    <div class="text-sm">r06.mis@dti.gov.ph</div>
                </div>
            </div>
             <div class="flex items-center text-white/50">
                <svg class="w-6 h-6 mr-3 text-white flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                <div>
                    <div class="text-xs font-bold uppercase text-white">Internal VoIP</div>
                    <div class="text-sm">Local: 204 or 205</div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="text-center mb-5">
        <h3 class="font-extrabold text-white mb-1">Support Desk</h3>
        <p class="text-sm mb-0" style="color: rgba(255,255,255,0.4) !important;">Troubleshooting & Contact Information</p>
    </div>

    <div class="space-y-4">
        <div class="bg-white/5 rounded-xl p-4 border border-white/10">
            <h6 class="font-bold text-white mb-2 text-sm flex items-center">
                <svg class="w-4 h-4 mr-2 text-cyan-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                Account Lockout?
            </h6>
            <p class="text-sm text-white/50">If you have tried the password reset and haven't received an email, your account might be deactivated or the mail server is under maintenance.</p>
        </div>

        <div class="bg-white/5 rounded-xl p-4 border border-white/10">
            <h6 class="font-bold text-white mb-2 text-sm flex items-center">
                <svg class="w-4 h-4 mr-2 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                Office Re-assignment?
            </h6>
            <p class="text-sm text-white/50">Officers changing their provincial assignment must contact the Regional MIS to update their account's "Office Node" to see the correct ledger.</p>
        </div>

        <div class="flex flex-col gap-2">
            <a href="mailto:r06.mis@dti.gov.ph" class="inline-flex items-center justify-center px-5 py-2.5 bg-white text-navy text-sm font-bold rounded-xl hover:bg-gray-50 shadow-lg transition-all transform hover:-translate-y-0.5">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                Send Support Ticket
            </a>
            <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-4 py-2 bg-transparent border border-white/25 text-white text-sm rounded-xl hover:bg-white/10 transition-colors">
                Back to Login
            </a>
        </div>
    </div>
</x-guest-layout>
