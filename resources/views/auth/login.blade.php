<x-guest-layout>
    {{-- No info slot here, making it a simple centered login --}}
    
    <div class="text-center mb-8">
        <h3 class="font-extrabold text-2xl mb-1">Authorization</h3>
        <p class="text-sm text-white/40">Access the R6 Transmittal Management System</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-6">
            <label class="block text-xs font-bold uppercase tracking-widest text-white/60 mb-2" for="email">Email</label>
            <input type="email" id="email" name="email" class="w-full bg-white/10 border border-white/10 text-white rounded-xl px-4 py-3 placeholder-white/40 focus:bg-white/15 focus:border-white/30 focus:ring-0 transition-colors" value="{{ old('email') }}" placeholder="user@dti6.gov.ph" required autofocus>
        </div>

        <!-- Password -->
        <div class="mb-6">
            <div class="flex justify-between items-center mb-2">
                <label class="block text-xs font-bold uppercase tracking-widest text-white/60" for="password">Password</label>
            </div>
            <input type="password" id="password" name="password" class="w-full bg-white/10 border border-white/10 text-white rounded-xl px-4 py-3 placeholder-white/40 focus:bg-white/15 focus:border-white/30 focus:ring-0 transition-colors" placeholder="••••••••" required autocomplete="current-password">
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex justify-between items-center mb-8 text-sm">
            <div class="flex items-center">
                <input class="rounded bg-white/10 border-white/20 text-navy focus:ring-0" type="checkbox" name="remember" id="remember_me">
                <label class="ml-2 text-white/50 cursor-pointer hover:text-white transition-colors" for="remember_me">Remember Me</label>
            </div>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-white/50 hover:text-white transition-colors">Forgot Password?</a>
            @endif
        </div>

        <div class="grid">
            <button type="submit" class="w-full bg-white text-navy font-extrabold uppercase tracking-widest py-4 rounded-xl hover:bg-gray-50 hover:-translate-y-0.5 shadow-lg transition-all duration-200 flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                Sign In
            </button>
        </div>

        <div class="text-center mt-8">
            <p class="text-xs text-white/40">
                New User? <a href="{{ route('register') }}" class="font-bold text-white hover:text-white/80 transition-colors ml-1">Request Account</a>
                <span class="mx-2 opacity-50">•</span>
                <a href="{{ route('support') }}" class="text-white/50 hover:text-white transition-colors">Get Help</a>
            </p>
        </div>
    </form>
</x-guest-layout>
