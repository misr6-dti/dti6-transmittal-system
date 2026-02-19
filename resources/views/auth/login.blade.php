<x-guest-layout>
    <div class="text-center mb-8">
        <h3 class="font-extrabold text-2xl mb-1">Sign In</h3>
        <p class="text-sm text-white/40">Access your DTI-R6 Account</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-6">
            <label class="block text-xs font-bold uppercase tracking-widest text-white/60 mb-2">Email Address</label>
            <input type="email" name="email" class="w-full bg-white/10 border border-white/10 text-white rounded-xl px-4 py-3 placeholder-white/40 focus:bg-white/15 focus:border-white/30 focus:ring-0 transition-colors" value="{{ old('email') }}" placeholder="user@dti6.gov.ph" required autofocus autocomplete="username">
            <!-- <x-input-error :messages="$errors->get('email')" class="mt-2" /> -->
        </div>

        <!-- Password -->
        <div class="mb-6">
            <label class="block text-xs font-bold uppercase tracking-widest text-white/60 mb-2">Password</label>
            <input type="password" name="password" class="w-full bg-white/10 border border-white/10 text-white rounded-xl px-4 py-3 placeholder-white/40 focus:bg-white/15 focus:border-white/30 focus:ring-0 transition-colors" placeholder="••••••••" required autocomplete="current-password">
            <!-- <x-input-error :messages="$errors->get('password')" class="mt-2" /> -->
        </div>

        <!-- Remember Me -->
        <div class="block mb-6">
            <label for="remember_me" class="inline-flex items-center group cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded bg-white/10 border-white/10 text-navy focus:ring-navy shadow-sm focus:ring-offset-navy-dark h-5 w-5 transition-all duration-200 group-hover:bg-white/20" name="remember">
                <span class="ml-2 text-sm text-white/60 group-hover:text-white/80 transition-colors">Remember me</span>
            </label>
        </div>

        <div class="flex flex-col gap-4">
            <button type="submit" class="w-full bg-white text-navy font-extrabold uppercase tracking-widest py-4 rounded-xl hover:bg-gray-50 hover:-translate-y-0.5 shadow-lg transition-all duration-200 flex items-center justify-center group">
                <svg class="w-5 h-5 mr-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                Sign In
            </button>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-center text-sm text-white/50 hover:text-white transition-colors">
                    Forgot your password?
                </a>
            @endif
             
             <div class="text-center mt-4 border-t border-white/10 pt-4">
                <p class="text-xs text-white/40 mb-2">Don't have an account?</p>
                <a href="{{ route('register') }}" class="text-sm font-bold text-white hover:text-white/80 transition-colors uppercase tracking-wider inline-flex items-center">
                    Create Account <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>
