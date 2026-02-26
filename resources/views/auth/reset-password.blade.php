<x-guest-layout>
    <div class="text-center mb-8">
        <h3 class="font-extrabold text-2xl mb-1">Set New Password</h3>
        <p class="text-sm text-white/40">Create a secure password for your account</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div class="mb-6">
            <label class="block text-xs font-bold uppercase tracking-widest text-white/60 mb-2" for="email">Email</label>
            <input type="email" id="email" name="email" class="w-full bg-white/10 border border-white/10 text-white rounded-xl px-4 py-3 placeholder-white/40 focus:bg-white/15 focus:border-white/30 focus:ring-0 transition-colors" value="{{ old('email', $request->email) }}" required autofocus>
        </div>

        <!-- Password -->
        <div class="mb-6">
            <label class="block text-xs font-bold uppercase tracking-widest text-white/60 mb-2" for="password">Password</label>
            <input type="password" id="password" name="password" class="w-full bg-white/10 border border-white/10 text-white rounded-xl px-4 py-3 placeholder-white/40 focus:bg-white/15 focus:border-white/30 focus:ring-0 transition-colors" required autocomplete="new-password">
        </div>

        <!-- Confirm Password -->
        <div class="mb-8">
            <label class="block text-xs font-bold uppercase tracking-widest text-white/60 mb-2" for="password_confirmation">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="w-full bg-white/10 border border-white/10 text-white rounded-xl px-4 py-3 placeholder-white/40 focus:bg-white/15 focus:border-white/30 focus:ring-0 transition-colors" required autocomplete="new-password">
        </div>

        <div class="grid">
            <button type="submit" class="w-full bg-white text-navy font-extrabold uppercase tracking-widest py-4 rounded-xl hover:bg-gray-50 hover:-translate-y-0.5 shadow-lg transition-all duration-200">
                {{ __('Reset Password') }}
            </button>
        </div>
    </form>
</x-guest-layout>
