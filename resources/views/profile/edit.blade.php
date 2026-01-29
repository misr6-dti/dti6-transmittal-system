@extends('layouts.app')

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-1">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-navy">Dashboard</a></li>
            <li class="breadcrumb-item active">Account Settings</li>
        </ol>
    </nav>
    <h2 class="fw-extrabold mb-0">My Profile</h2>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <!-- Profile Information -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0">Profile Information</h5>
                <p class="small text-muted mb-0">Update your account's profile information and email address.</p>
            </div>
            <div class="card-body p-4 p-md-5">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <!-- Update Password -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0">Update Password</h5>
                <p class="small text-muted mb-0">Ensure your account is using a long, random password to stay secure.</p>
            </div>
            <div class="card-body p-4 p-md-5">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <!-- Delete Account -->
        @if(Auth::user()->role && Auth::user()->role->slug !== 'admin')
        <div class="card shadow-sm border-0 border-top border-danger border-4 mb-4">
            <div class="card-header bg-white py-3 text-danger">
                <h5 class="fw-bold mb-0">Extreme Action</h5>
                <p class="small text-muted mb-0">Once your account is deleted, all of its resources and data will be permanently deleted.</p>
            </div>
            <div class="card-body p-4 p-md-5">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
        @endif
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <div class="text-center py-3">
                    <div class="bi bi-person-circle display-1 text-primary mb-3"></div>
                    <h4 class="fw-bold mb-1 text-dark">{{ Auth::user()->name }}</h4>
                    <span class="badge bg-primary text-white px-3 rounded-pill fw-bold" style="font-size: 0.7rem;">
                        {{ Auth::user()->getRoleNames()->first() ?? 'User' }}
                    </span>
                </div>
                <hr class="opacity-25">
                <div class="small text-dark">
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Email:</span>
                        <span class="fw-bold text-truncate" title="{{ Auth::user()->email }}">{{ Auth::user()->email }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Office:</span>
                        <span class="fw-bold">{{ Auth::user()->office->code ?? 'N/A' }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Office Type:</span>
                        <span class="fw-bold text-uppercase">{{ Auth::user()->office->type ?? 'N/A' }}</span>
                    </div>
                    <div class="border-top border-opacity-25 my-3"></div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Total Logins:</span>
                        <span class="fw-bold badge bg-primary text-white">{{ Auth::user()->login_count ?? 0 }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Last Login:</span>
                        <span class="fw-bold text-dark">{{ Auth::user()->last_login_at ? Auth::user()->last_login_at->format('M d, Y') : 'Never' }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Member Since:</span>
                        <span class="fw-bold text-dark">{{ Auth::user()->created_at ? Auth::user()->created_at->format('M Y') : 'N/A' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Styling for Breeze partials to match Bootstrap */
    .mt-6 { margin-top: 1.5rem; }
    .space-y-6 > * + * { margin-top: 1.5rem; }
    input[type="text"], input[type="email"], input[type="password"] {
        display: block;
        width: 100%;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #212529;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        appearance: none;
        border-radius: 0.75rem;
        transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    }
    input:focus {
        border-color: var(--dti-navy);
        outline: 0;
        box-shadow: 0 0 0 0.25rem rgba(0, 31, 63, 0.25);
    }
    .text-sm { font-size: 0.875rem; }
    .text-gray-600 { color: #6c757d; }
    .font-medium { font-weight: 500; }
    .text-green-600 { color: #198754; }
</style>
@endsection
