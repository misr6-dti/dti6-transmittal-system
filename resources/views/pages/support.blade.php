<x-guest-layout>
    <x-slot name="info">
        <h1 class="info-title">MIS Help & Support</h1>
        <p class="info-text">
            For account recovery, system assistance, or report disputes, our team is ready to help.
        </p>
        <div class="mt-5">
            <div class="d-flex align-items-center mb-4 text-white-50">
                <i class="bi bi-geo-alt fs-4 me-3 text-white"></i>
                <div>
                    <div class="small fw-bold text-uppercase">Regional Office</div>
                    <div class="small">DTI Region VI, Iloilo City</div>
                </div>
            </div>
            <div class="d-flex align-items-center mb-4 text-white-50">
                <i class="bi bi-envelope fs-4 me-3 text-white"></i>
                <div>
                    <div class="small fw-bold text-uppercase">Email Support</div>
                    <div class="small">r06.mis@dti.gov.ph</div>
                </div>
            </div>
             <div class="d-flex align-items-center text-white-50">
                <i class="bi bi-telephone fs-4 me-3 text-white"></i>
                <div>
                    <div class="small fw-bold text-uppercase">Internal VoIP</div>
                    <div class="small">Local: 204 or 205</div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="text-center mb-5">
        <h3 class="fw-extrabold mb-1 text-white">Support Desk</h3>
        <p class="small text-muted mb-0" style="color: rgba(255,255,255,0.4) !important;">Troubleshooting & Contact Information</p>
    </div>

    <div class="space-y-4">
        <div class="bg-white bg-opacity-5 rounded-4 p-4 border border-white border-opacity-10 mb-4">
            <h6 class="fw-bold text-white mb-2 small"><i class="bi bi-shield-lock me-2 text-info"></i>Account Lockout?</h6>
            <p class="small text-white-50 mb-0">If you have tried the password reset and haven't received an email, your account might be deactivated or the mail server is under maintenance.</p>
        </div>

        <div class="bg-white bg-opacity-5 rounded-4 p-4 border border-white border-opacity-10 mb-4">
            <h6 class="fw-bold text-white mb-2 small"><i class="bi bi-building me-2 text-info"></i>Office Re-assignment?</h6>
            <p class="small text-white-50 mb-0">Officers changing their provincial assignment must contact the Regional MIS to update their account's "Office Node" to see the correct ledger.</p>
        </div>

        <div class="d-grid gap-2">
            <a href="mailto:r06.mis@dti.gov.ph" class="btn btn-premium mb-2">
                <i class="bi bi-envelope-at me-2"></i>Send Support Ticket
            </a>
            <a href="{{ route('login') }}" class="btn btn-outline-light rounded-4 py-2 border-opacity-25 small">
                Back to Login
            </a>
        </div>
    </div>
</x-guest-layout>
