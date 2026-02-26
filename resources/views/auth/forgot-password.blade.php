<x-guest-layout>
    <x-slot name="info">
        <h1 class="text-4xl font-extrabold mb-6 bg-clip-text text-transparent bg-gradient-to-r from-white to-white/50">Account Recovery</h1>
        <p class="text-lg leading-relaxed text-white/70 text-justify">
            Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
        </p>
        <p class="text-lg leading-relaxed text-white/70 text-justify mt-4">
            If you still experience issues accessing your account after the reset, please contact the <span class="text-white font-bold">R6 MIS Unit</span> for technical assistance.
        </p>
    </x-slot>

    <div class="text-center mb-8">
        <h3 class="font-extrabold text-2xl mb-1">Reset Password</h3>
        <p class="text-sm text-white/40">Enter your email to receive recovery link</p>
    </div>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-8">
            <label class="block text-xs font-bold uppercase tracking-widest text-white/60 mb-2" for="email">Email Address</label>
            <input id="email" class="w-full bg-white/10 border border-white/10 text-white rounded-xl px-4 py-3 placeholder-white/40 focus:bg-white/15 focus:border-white/30 focus:ring-0 transition-colors" type="email" name="email" value="{{ old('email') }}" placeholder="user@dti6.gov.ph" required autofocus />
        </div>

        <div class="grid mb-6">
            <button type="submit" class="w-full bg-white text-navy font-extrabold uppercase tracking-widest py-4 rounded-xl hover:bg-gray-50 hover:-translate-y-0.5 shadow-lg transition-all duration-200">
                {{ __('Email Password Reset Link') }}
            </button>
        </div>

        <div class="text-center flex justify-center items-center text-sm">
            <a href="{{ route('login') }}" class="text-white/50 hover:text-white transition-colors">Back to Login</a>
            <span class="text-white/50 mx-2">•</span>
            <a href="{{ route('support') }}" class="text-white/50 hover:text-white transition-colors">Support Desk</a>
        </div>
    </form>
</x-guest-layout>
