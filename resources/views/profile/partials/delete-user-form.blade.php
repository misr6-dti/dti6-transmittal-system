<section class="space-y-6">
    <button
        class="inline-flex items-center px-5 py-2.5 bg-red-600 text-white text-sm font-medium rounded-xl hover:bg-red-700 shadow-lg shadow-red-500/30 transition-all transform hover:-translate-y-0.5"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Delete Account') }}</button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-bold text-slate-800">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-2 text-sm text-slate-600">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <label for="password" class="sr-only">{{ __('Password') }}</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-red-500/20 focus:border-red-500 text-sm transition-all @if($errors->userDeletion->has('password')) border-red-500 @endif"
                    placeholder="{{ __('Password') }}"
                />
                @if($errors->userDeletion->has('password'))
                    <p class="text-red-500 text-xs mt-1">{{ $errors->userDeletion->first('password') }}</p>
                @endif
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-50 font-medium transition-colors text-sm" x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </button>

                <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-red-600 text-white text-sm font-medium rounded-xl hover:bg-red-700 shadow-lg shadow-red-500/30 transition-all transform hover:-translate-y-0.5">
                    {{ __('Delete Account') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
