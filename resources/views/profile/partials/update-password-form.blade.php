<section>
    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div class="space-y-2">
            <label for="current_password" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">{{ __('Current Password') }}</label>
            <input id="current_password" name="current_password" type="password" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-navy/20 focus:border-navy text-sm transition-all @if($errors->updatePassword->has('current_password')) border-red-500 focus:border-red-500 focus:ring-red-200 @endif" autocomplete="current-password" />
            @if($errors->updatePassword->has('current_password'))
                <p class="text-red-500 text-xs mt-1">{{ $errors->updatePassword->first('current_password') }}</p>
            @endif
        </div>

        <div class="space-y-2">
            <label for="password" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">{{ __('New Password') }}</label>
            <input id="password" name="password" type="password" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-navy/20 focus:border-navy text-sm transition-all @if($errors->updatePassword->has('password')) border-red-500 focus:border-red-500 focus:ring-red-200 @endif" autocomplete="new-password" />
            @if($errors->updatePassword->has('password'))
                <p class="text-red-500 text-xs mt-1">{{ $errors->updatePassword->first('password') }}</p>
            @endif
        </div>

        <div class="space-y-2">
            <label for="password_confirmation" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">{{ __('Confirm New Password') }}</label>
            <input id="password_confirmation" name="password_confirmation" type="password" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-navy/20 focus:border-navy text-sm transition-all @if($errors->updatePassword->has('password_confirmation')) border-red-500 focus:border-red-500 focus:ring-red-200 @endif" autocomplete="new-password" />
            @if($errors->updatePassword->has('password_confirmation'))
                <p class="text-red-500 text-xs mt-1">{{ $errors->updatePassword->first('password_confirmation') }}</p>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-navy text-white text-sm font-medium rounded-xl hover:bg-navy-light shadow-lg shadow-navy/20 transition-all transform hover:-translate-y-0.5">
                {{ __('Update Password') }}
            </button>
        </div>
    </form>
</section>
