<section>
    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="space-y-2">
            <label for="name" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">{{ __('Full Name') }}</label>
            <input id="name" name="name" type="text" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-navy/20 focus:border-navy text-sm transition-all @error('name') border-red-500 focus:border-red-500 focus:ring-red-200 @enderror" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
        </div>

        <div class="space-y-2">
            <label for="email" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">{{ __('Work Email') }}</label>
            <input id="email" name="email" type="email" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-navy/20 focus:border-navy text-sm transition-all @error('email') border-red-500 focus:border-red-500 focus:ring-red-200 @enderror" value="{{ old('email', $user->email) }}" required autocomplete="username" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-sm text-red-600">
                        {{ __('Your email address is unverified.') }}
                        <button form="send-verification" class="underline text-sm text-slate-600 hover:text-navy rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-navy">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-navy text-white text-sm font-medium rounded-xl hover:bg-navy-light shadow-lg shadow-navy/20 transition-all transform hover:-translate-y-0.5">
                {{ __('Update Profile') }}
            </button>
        </div>
    </form>
</section>
