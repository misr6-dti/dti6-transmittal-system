<x-guest-layout>
    <x-slot name="info">
        <h1 class="info-title">Account Recovery</h1>
        <p class="info-text">
            Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
        </p>
        <p class="info-text mt-4">
            If you still experience issues accessing your account after the reset, please contact the <span class="text-white fw-bold">R6 MIS Unit</span> for technical assistance.
        </p>
    </x-slot>

    <div class="text-center mb-5">
        <h3 class="fw-extrabold mb-1">Reset Password</h3>
        <p class="small text-muted mb-0" style="color: rgba(255,255,255,0.4) !important;">Enter your email to receive recovery link</p>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="alert alert-success small py-2 border-0 bg-success bg-opacity-10 text-success mb-4 text-center">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-5">
            <label class="form-label text-white-50" for="email">Email Address</label>
            <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" placeholder="user@dti6.gov.ph" required autofocus />
            @if($errors->has('email'))
                <div class="text-danger mt-1 small">{{ $errors->first('email') }}</div>
            @endif
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-premium mb-4">
                {{ __('Email Password Reset Link') }}
            </button>
        </div>

        <div class="text-center">
            <a href="{{ route('login') }}" class="small text-white-50">Back to Login</a>
            <span class="text-white-50 mx-2">•</span>
            <a href="{{ route('support') }}" class="small text-white-50">Support Desk</a>
        </div>
    </form>
</x-guest-layout>
