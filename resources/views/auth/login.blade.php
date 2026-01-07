<x-guest-layout>
    {{-- No info slot here, making it a simple centered login --}}
    
    <div class="text-center mb-5">
        <h3 class="fw-extrabold mb-1">Authorization</h3>
        <p class="small text-muted mb-0" style="color: rgba(255,255,255,0.4) !important;">Access the R6 Transmittal Management System</p>
    </div>

    @if (session('status'))
        <div class="alert alert-success small py-2 border-0 bg-success bg-opacity-10 text-success mb-4 text-center">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-4">
            <label class="form-label" for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="user@dti6.gov.ph" required autofocus>
            @if($errors->has('email'))
                <div class="text-danger mt-1 small">{{ $errors->first('email') }}</div>
            @endif
        </div>

        <!-- Password -->
        <div class="mb-4">
            <div class="d-flex justify-content-between">
                <label class="form-label" for="password">Password</label>
            </div>
            <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required autocomplete="current-password">
            @if($errors->has('password'))
                <div class="text-danger mt-1 small">{{ $errors->first('password') }}</div>
            @endif
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="d-flex justify-content-between align-items-center mb-5 small">
            <div class="form-check m-0">
                <input class="form-check-input bg-transparent border-secondary" type="checkbox" name="remember" id="remember_me">
                <label class="form-check-label text-white-50" for="remember_me">Remember Me</label>
            </div>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-white-50 hover-white transition-all">Forgot Password?</a>
            @endif
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-premium mb-4">
                <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
            </button>
        </div>

        <div class="text-center">
            <p class="small text-muted" style="color: rgba(255,255,255,0.4) !important;">
                New User? <a href="{{ route('register') }}" class="fw-bold text-white hover-glow transition-all">Request Account</a>
                <span class="mx-2 text-white-10">•</span>
                <a href="{{ route('support') }}" class="text-white-50 hover-white transition-all">Get Help</a>
            </p>
        </div>
    </form>
</x-guest-layout>
