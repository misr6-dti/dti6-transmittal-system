<x-guest-layout>
    <x-slot name="wide">true</x-slot>

    <div class="text-center mb-8">
        <h3 class="font-extrabold text-2xl mb-1">Account Request</h3>
        <p class="text-sm text-white/40">Enroll in DTI-R6 Transmittal Management System</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-xs font-bold uppercase tracking-widest text-white/60 mb-2">Full Name</label>
                <input type="text" name="name" class="w-full bg-white/10 border border-white/10 text-white rounded-xl px-4 py-3 placeholder-white/40 focus:bg-white/15 focus:border-white/30 focus:ring-0 transition-colors" value="{{ old('name') }}" placeholder="John Doe" required autofocus>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-widest text-white/60 mb-2">Email Address</label>
                <input type="email" name="email" class="w-full bg-white/10 border border-white/10 text-white rounded-xl px-4 py-3 placeholder-white/40 focus:bg-white/15 focus:border-white/30 focus:ring-0 transition-colors" value="{{ old('email') }}" placeholder="user@dti6.gov.ph" required>
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-xs font-bold uppercase tracking-widest text-white/60 mb-2">Assigned Office</label>
            <select name="office_id" class="w-full bg-navy-dark border border-white/10 text-white rounded-xl px-4 py-3 focus:bg-navy focus:border-white/30 focus:ring-0 transition-colors appearance-none" required>
                <option value="" class="text-gray-400">Select Station...</option>
                @foreach($offices as $office)
                    <option value="{{ $office->id }}" {{ old('office_id') == $office->id ? 'selected' : '' }}>{{ $office->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div>
                <label class="block text-xs font-bold uppercase tracking-widest text-white/60 mb-2">Password</label>
                <input type="password" name="password" class="w-full bg-white/10 border border-white/10 text-white rounded-xl px-4 py-3 placeholder-white/40 focus:bg-white/15 focus:border-white/30 focus:ring-0 transition-colors" placeholder="••••••••" required autocomplete="new-password">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-widest text-white/60 mb-2">Confirm Password</label>
                <input type="password" name="password_confirmation" class="w-full bg-white/10 border border-white/10 text-white rounded-xl px-4 py-3 placeholder-white/40 focus:bg-white/15 focus:border-white/30 focus:ring-0 transition-colors" placeholder="••••••••" required autocomplete="new-password">
            </div>
        </div>

        <div class="flex flex-col gap-4">
            <button type="submit" class="w-full bg-white text-navy font-extrabold uppercase tracking-widest py-4 rounded-xl hover:bg-gray-50 hover:-translate-y-0.5 shadow-lg transition-all duration-200 flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                Send Request
            </button>
            <a href="{{ route('login') }}" class="text-center text-sm text-white/50 hover:text-white transition-colors">
                Back to Sign In
            </a>
        </div>
    </form>
</x-guest-layout>

