<x-guest-layout>
    <x-slot name="wide">true</x-slot>

    <div class="text-center mb-5">
        <h3 class="fw-extrabold mb-1">Account Request</h3>
        <p class="small text-muted mb-0" style="color: rgba(255,255,255,0.4) !important;">Enroll in DTI-R6 Transmittal Management System</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="row">
            <div class="col-md-6 mb-4">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="John Doe" required autofocus>
                @if($errors->has('name'))
                    <div class="text-danger mt-1 small">{{ $errors->first('name') }}</div>
                @endif
            </div>

            <div class="col-md-6 mb-4">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="user@dti6.gov.ph" required>
                @if($errors->has('email'))
                    <div class="text-danger mt-1 small">{{ $errors->first('email') }}</div>
                @endif
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label">Assigned Office</label>
            <select name="office_id" class="form-select form-control" required style="border-radius: 1rem;">
                <option value="">Select Station...</option>
                @foreach($offices as $office)
                    <option value="{{ $office->id }}" {{ old('office_id') == $office->id ? 'selected' : '' }}>{{ $office->name }}</option>
                @endforeach
            </select>
            @if($errors->has('office_id'))
                <div class="text-danger mt-1 small">{{ $errors->first('office_id') }}</div>
            @endif
        </div>

        <div class="row">
            <div class="col-md-6 mb-4">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required autocomplete="new-password">
                @if($errors->has('password'))
                    <div class="text-danger mt-1 small">{{ $errors->first('password') }}</div>
                @endif
            </div>

            <div class="col-md-6 mb-5">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••" required autocomplete="new-password">
            </div>
        </div>

        <div class="d-grid gap-3">
            <button type="submit" class="btn btn-premium">
                <i class="bi bi-person-plus me-2"></i>Send Request
            </button>
            <a href="{{ route('login') }}" class="btn btn-link text-white-50 small">
                Back to Sign In
            </a>
        </div>
    </form>
</x-guest-layout>
