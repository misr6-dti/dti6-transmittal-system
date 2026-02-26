<x-guest-layout>
    <x-slot name="info">
        <h1 class="text-4xl font-extrabold mb-6 bg-clip-text text-transparent bg-gradient-to-r from-white to-white/50">DTI Region VI - Transmittal Management System</h1>
        <p class="text-lg leading-relaxed text-white/70 text-justify">
            The <span class="text-white font-bold">DTI6-TMS</span> is an upgraded, web-based platform that replaces the previous Microsoft Access–based system, modernizing the creation, routing, tracking, and archiving of official transmittal documents across all DTI Region VI offices.
        </p>
        <p class="text-lg leading-relaxed text-white/70 text-justify mt-4">
            It offers an <span class="text-white font-bold">Excel-like, single-reference transmittal form</span>, real-time status tracking, comprehensive audit logs, and printable outputs. This upgrade significantly enhances efficiency, accountability, collaboration, and records management while providing a scalable and accessible solution across multiple offices.
        </p>
        <div class="mt-8 space-y-6">
            <div class="flex items-center text-white/50">
                <div class="bg-white/10 p-3 rounded-xl mr-4 text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <div class="text-xs font-bold uppercase tracking-wider text-white">Secure Tracking</div>
                    <div class="text-sm">End-to-end document transparency</div>
                </div>
            </div>
            <div class="flex items-center text-white/50">
                <div class="bg-white/10 p-3 rounded-xl mr-4 text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <div>
                    <div class="text-xs font-bold uppercase tracking-wider text-white">Efficient Workflow</div>
                    <div class="text-sm">Reduced processing time for transmittals</div>
                </div>
            </div>
             <div class="flex items-center text-white/50">
                <div class="bg-white/10 p-3 rounded-xl mr-4 text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                </div>
                <div>
                    <div class="text-xs font-bold uppercase tracking-wider text-white">Real-time Analytics</div>
                    <div class="text-sm">Monitor office performance and load</div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="text-center mb-8">
        <h3 class="font-extrabold text-2xl mb-1">Welcome</h3>
        <p class="text-sm text-white/40">DTI Region VI Official Platform</p>
    </div>

    <div class="flex flex-col gap-4">
        @auth
            <a href="{{ url('/dashboard') }}" class="w-full bg-white text-navy font-extrabold uppercase tracking-widest py-4 rounded-xl hover:bg-gray-50 hover:-translate-y-0.5 shadow-lg transition-all duration-200 flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                Go to Dashboard
            </a>
        @else
            <a href="{{ route('login') }}" class="w-full bg-white text-navy font-extrabold uppercase tracking-widest py-4 rounded-xl hover:bg-gray-50 hover:-translate-y-0.5 shadow-lg transition-all duration-200 flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                Sign In
            </a>

            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="w-full border border-white/20 text-white font-bold uppercase tracking-widest py-3 rounded-xl hover:bg-white/10 transition-colors text-center text-sm">
                    Create New Account
                </a>
            @endif
        @endauth
        
        <div class="h-px bg-white/10 my-2"></div>
        
        <a href="{{ route('support') }}" class="text-center text-sm text-white/50 hover:text-white transition-colors flex items-center justify-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Need help? Contact Support
        </a>
    </div>
</x-guest-layout>
