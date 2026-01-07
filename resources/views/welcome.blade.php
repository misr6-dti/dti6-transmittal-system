<x-guest-layout>
    <x-slot name="info">
        <h1 class="info-title">DTI Region VI - Transmittal Management System</h1>
        <p class="info-text">
            The <span class="text-white fw-bold">DTI6-TMS</span> is an upgraded, web-based platform that replaces the previous Microsoft Access–based system, modernizing the creation, routing, tracking, and archiving of official transmittal documents across all DTI Region VI offices.
        </p>
        <p class="info-text mt-4">
            It offers an <span class="text-white fw-bold">Excel-like, single-reference transmittal form</span>, real-time status tracking, comprehensive audit logs, and printable outputs. This upgrade significantly enhances efficiency, accountability, collaboration, and records management while providing a scalable and accessible solution across multiple offices.
        </p>
        <div class="mt-5">
            <div class="d-flex align-items-center mb-4 text-white-50">
                <i class="bi bi-shield-check fs-4 me-3 text-white"></i>
                <div>
                    <div class="small fw-bold text-uppercase">Secure Tracking</div>
                    <div class="small">End-to-end document transparency</div>
                </div>
            </div>
            <div class="d-flex align-items-center mb-4 text-white-50">
                <i class="bi bi-speedometer2 fs-4 me-3 text-white"></i>
                <div>
                    <div class="small fw-bold text-uppercase">Efficient Workflow</div>
                    <div class="small">Reduced processing time for transmittals</div>
                </div>
            </div>
             <div class="d-flex align-items-center text-white-50">
                <i class="bi bi-graph-up-arrow fs-4 me-3 text-white"></i>
                <div>
                    <div class="small fw-bold text-uppercase">Real-time Analytics</div>
                    <div class="small">Monitor office performance and load</div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="text-center mb-5">
        <h3 class="fw-extrabold mb-1 text-white">Welcome</h3>
        <p class="small text-muted mb-0" style="color: rgba(255,255,255,0.4) !important;">DTI Region VI Official Platform</p>
    </div>

    <div class="d-grid gap-3">
        @auth
            <a href="{{ url('/dashboard') }}" class="btn btn-premium">
                <i class="bi bi-speedometer2 me-2"></i>Go to Dashboard
            </a>
        @else
            <a href="{{ route('login') }}" class="btn btn-premium">
                <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
            </a>

            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="btn btn-outline-light rounded-4 py-2 border-opacity-25 small">
                    Create New Account
                </a>
            @endif
        @endauth
        
        <hr class="border-white border-opacity-10 my-2">
        
        <a href="{{ route('support') }}" class="btn btn-link text-white-50 small">
            <i class="bi bi-question-circle me-1"></i>Need help? Contact Support
        </a>
    </div>
</x-guest-layout>
