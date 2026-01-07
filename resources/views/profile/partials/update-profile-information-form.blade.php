<section>
    <form method="post" action="{{ route('profile.update') }}" class="mt-6">
        @csrf
        @method('patch')

        <div class="mb-4">
            <label for="name" class="form-label fw-bold small text-uppercase text-muted">{{ __('Full Name') }}</label>
            <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            @if($errors->has('name'))
                <div class="text-danger small mt-1">{{ $errors->first('name') }}</div>
            @endif
        </div>

        <div class="mb-4">
            <label for="email" class="form-label fw-bold small text-uppercase text-muted">{{ __('Work Email') }}</label>
            <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required autocomplete="username" />
            @if($errors->has('email'))
                <div class="text-danger small mt-1">{{ $errors->first('email') }}</div>
            @endif

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-sm text-danger">
                        {{ __('Your email address is unverified.') }}
                        <button form="send-verification" class="btn btn-link p-0 text-sm align-baseline">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-success small">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-navy px-4">{{ __('Update Profile') }}</button>

            @if (session('status') === 'profile-updated')
                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-success small"
                >
                    <i class="bi bi-check-circle me-1"></i>{{ __('Changes saved.') }}
                </div>
            @endif
        </div>
    </form>
</section>
