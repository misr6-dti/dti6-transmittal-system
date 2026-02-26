<x-guest-layout>
    <div class="text-center mb-8">
        <h3 class="font-extrabold text-2xl mb-1">Confirm Access</h3>
        <p class="text-sm text-white/40">Secure area authorization required</p>
    </div>

    <div class="mb-6 text-sm text-white/70 text-center">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div class="mb-8">
            <label class="block text-xs font-bold uppercase tracking-widest text-white/60 mb-2" for="password">Password</label>
            <input type="password" id="password" name="password" class="w-full bg-white/10 border border-white/10 text-white rounded-xl px-4 py-3 placeholder-white/40 focus:bg-white/15 focus:border-white/30 focus:ring-0 transition-colors" placeholder="••••••••" required autocomplete="current-password">
        </div>

        <div class="grid">
            <button type="submit" class="w-full bg-white text-navy font-extrabold uppercase tracking-widest py-4 rounded-xl hover:bg-gray-50 hover:-translate-y-0.5 shadow-lg transition-all duration-200">
                {{ __('Confirm') }}
            </button>
        </div>
    </form>
</x-guest-layout>
