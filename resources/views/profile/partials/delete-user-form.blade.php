<section class="space-y-6">
    <button
        class="btn btn-danger px-4"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Delete Account') }}</button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-5">
            @csrf
            @method('delete')

            <h2 class="h5 fw-bold text-dark">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-2 text-sm text-muted">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-4">
                <label for="password" class="form-label visually-hidden">{{ __('Password') }}</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    class="form-control"
                    placeholder="{{ __('Password') }}"
                />
                @if($errors->userDeletion->has('password'))
                    <div class="text-danger small mt-1">{{ $errors->userDeletion->first('password') }}</div>
                @endif
            </div>

            <div class="mt-5 d-flex justify-content-end gap-2">
                <button type="button" class="btn btn-light px-4" x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </button>

                <button type="submit" class="btn btn-danger px-4">
                    {{ __('Delete Account') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
