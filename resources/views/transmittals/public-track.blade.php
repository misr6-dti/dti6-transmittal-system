@extends('layouts.public')

@section('content')
<div class="tracking-container">
    <div class="tracking-wrapper">
        @if ($transmittal)
            <div class="tracking-card">
                <!-- Card Header -->
                <div class="tracking-header">
                    <div>
                        <h2 class="tracking-title">{{ $transmittal->reference_number }}</h2>
                        <p class="tracking-subtitle">Transmittal Tracking</p>
                    </div>
                    <span class="tracking-badge bg-{{ strtolower($transmittal->status) === 'received' ? 'success' : (strtolower($transmittal->status) === 'submitted' ? 'warning' : 'secondary') }}">
                        {{ strtoupper($transmittal->status) }}
                    </span>
                </div>

                <!-- Card Body -->
                <div class="tracking-body">
                    <!-- Date Information -->
                    <div class="tracking-section">
                        <div class="tracking-field">
                            <label class="tracking-label">Execution Date</label>
                            <p class="tracking-value">{{ \Carbon\Carbon::parse($transmittal->transmittal_date)->format('M d, Y') }}</p>
                        </div>
                        @if ($transmittal->received_at)
                            <div class="tracking-field">
                                <label class="tracking-label">Received Date</label>
                                <p class="tracking-value">{{ \Carbon\Carbon::parse($transmittal->received_at)->format('M d, Y H:i A') }}</p>
                            </div>
                        @endif
                    </div>

                    <div class="tracking-divider"></div>

                    <!-- Location Information -->
                    <div class="tracking-section">
                        <div class="tracking-location">
                            <div class="tracking-location-item">
                                <div class="tracking-location-icon from">
                                    <i class="bi bi-geo-alt"></i>
                                </div>
                                <label class="tracking-label">From</label>
                                <p class="tracking-location-code">{{ $transmittal->senderOffice->code }}</p>
                                <p class="tracking-location-name">{{ $transmittal->senderOffice->name }}</p>
                            </div>

                            <div class="tracking-arrow">
                                <i class="bi bi-arrow-right"></i>
                            </div>

                            <div class="tracking-location-item">
                                <div class="tracking-location-icon to">
                                    <i class="bi bi-flag"></i>
                                </div>
                                <label class="tracking-label">To</label>
                                <p class="tracking-location-code">{{ $transmittal->receiverOffice->code }}</p>
                                <p class="tracking-location-name">{{ $transmittal->receiverOffice->name }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Footer -->
                <div class="tracking-footer">
                    <p class="tracking-footer-text">
                        <i class="bi bi-shield-check me-2"></i>Secure tracking link - Do not share with unauthorized persons
                    </p>
                </div>
            </div>
        @else
            <div class="tracking-card error">
                <div class="tracking-body text-center">
                    <div class="error-icon">
                        <i class="bi bi-exclamation-circle"></i>
                    </div>
                    <h3>Transmittal Not Found</h3>
                    <p>{{ $error ?? 'The transmittal reference number could not be found in the system. Please check the QR code or reference number and try again.' }}</p>
                </div>
            </div>
        @endif
    </div>
</div>

<style>
    .tracking-container {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        padding: 1.5rem 1rem 1.5rem 1rem;
        min-height: 100vh;
        background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
    }

    .tracking-wrapper {
        width: 100%;
        max-width: 500px;
    }

    .tracking-card {
        background: white;
        border-radius: 1.5rem;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        border: 1px solid #e5e7eb;
        transition: all 0.3s ease;
    }

    .tracking-card:hover {
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
    }

    .tracking-card.error {
        border-color: #fee2e2;
        background: #fef2f2;
    }

    .tracking-header {
        padding: 2rem;
        background: linear-gradient(135deg, #001f3f 0%, #003366 100%);
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
    }

    .tracking-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
        letter-spacing: -0.5px;
    }

    .tracking-subtitle {
        font-size: 0.875rem;
        margin: 0.5rem 0 0 0;
        opacity: 0.8;
        font-weight: 500;
    }

    .tracking-badge {
        padding: 0.5rem 1rem;
        border-radius: 0.75rem;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .tracking-badge.bg-success {
        background: linear-gradient(135deg, #059669, #10b981) !important;
        color: white !important;
    }

    .tracking-badge.bg-warning {
        background: linear-gradient(135deg, #2563eb, #3b82f6) !important;
        color: white !important;
    }

    .tracking-badge.bg-secondary {
        background: linear-gradient(135deg, #6b7280, #9ca3af) !important;
        color: white !important;
    }

    .tracking-body {
        padding: 2rem;
    }

    .tracking-section {
        margin-bottom: 1.5rem;
    }

    .tracking-field {
        margin-bottom: 1.25rem;
    }

    .tracking-field:last-child {
        margin-bottom: 0;
    }

    .tracking-label {
        display: block;
        font-size: 0.8rem;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
    }

    .tracking-value {
        font-size: 1.1rem;
        font-weight: 600;
        color: #111827;
        margin: 0;
    }

    .tracking-divider {
        height: 1px;
        background: linear-gradient(90deg, transparent, #e5e7eb, transparent);
        margin: 1.5rem 0;
    }

    .tracking-location {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .tracking-location-item {
        flex: 1;
        text-align: center;
    }

    .tracking-location-icon {
        width: 3rem;
        height: 3rem;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 0.75rem;
        font-size: 1.5rem;
        color: white;
    }

    .tracking-location-icon.from {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
    }

    .tracking-location-icon.to {
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
    }

    .tracking-location-code {
        font-size: 0.95rem;
        font-weight: 700;
        color: #111827;
        margin: 0 0 0.25rem 0;
    }

    .tracking-location-name {
        font-size: 0.8rem;
        color: #6b7280;
        margin: 0;
        line-height: 1.4;
    }

    .tracking-arrow {
        display: flex;
        align-items: center;
        color: #d1d5db;
        font-size: 1.25rem;
    }

    .tracking-footer {
        padding: 1.5rem 2rem;
        background-color: #f9fafb;
        border-top: 1px solid #e5e7eb;
    }

    .tracking-footer-text {
        font-size: 0.8rem;
        color: #6b7280;
        margin: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Error State */
    .tracking-card.error .tracking-body {
        text-align: center;
        padding: 3rem 2rem;
    }

    .error-icon {
        font-size: 3rem;
        color: #ef4444;
        margin-bottom: 1rem;
    }

    .tracking-card.error h3 {
        color: #111827;
        font-size: 1.35rem;
        font-weight: 700;
        margin: 0 0 0.75rem 0;
    }

    .tracking-card.error p {
        color: #6b7280;
        font-size: 0.95rem;
        margin: 0;
        line-height: 1.6;
    }

    @media print {
        .tracking-container {
            background: white;
            padding: 0;
            min-height: auto;
        }

        .tracking-card {
            box-shadow: none;
            border: 1px solid #e5e7eb;
        }
    }

    @media (max-width: 480px) {
        .tracking-container {
            padding: 1.5rem 1rem;
        }

        .tracking-header {
            padding: 1.5rem;
            flex-direction: column;
        }

        .tracking-title {
            font-size: 1.25rem;
        }

        .tracking-body {
            padding: 1.5rem;
        }

        .tracking-location {
            gap: 1rem;
        }

        .tracking-location-icon {
            width: 2.5rem;
            height: 2.5rem;
            font-size: 1.25rem;
        }

        .tracking-arrow {
            font-size: 1rem;
        }
    }
</style>
@endsection
