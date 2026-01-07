<section>
    <form method="post" action="{{ route('password.update') }}" class="mt-6">
        @csrf
        @method('put')

        <div class="mb-4">
            <label for="current_password" class="form-label fw-bold small text-uppercase text-muted">{{ __('Current Password') }}</label>
            <input id="current_password" name="current_password" type="password" class="form-control" autocomplete="current-password" />
            @if($errors->updatePassword->has('current_password'))
                <div class="text-danger small mt-1">{{ $errors->updatePassword->first('current_password') }}</div>
            @endif
        </div>

        <div class="mb-4">
            <label for="password" class="form-label fw-bold small text-uppercase text-muted">{{ __('New Password') }}</label>
            <input id="password" name="password" type="password" class="form-control" autocomplete="new-password" />
            @if($errors->updatePassword->has('password'))
                <div class="text-danger small mt-1">{{ $errors->updatePassword->first('password') }}</div>
            @endif
        </div>

        <div class="mb-5">
            <label for="password_confirmation" class="form-label fw-bold small text-uppercase text-muted">{{ __('Confirm New Password') }}</label>
            <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password" />
            @if($errors->updatePassword->has('password_confirmation'))
                <div class="text-danger small mt-1">{{ $errors->updatePassword->first('password_confirmation') }}</div>
            @endif
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-navy px-4">{{ __('Update Password') }}</button>

            @if (session('status') === 'password-updated')
                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-success small"
                >
                    <i class="bi bi-check-circle me-1"></i>{{ __('Password updated.') }}
                </div>
            @endif
        </div>
    </form>
</section>
