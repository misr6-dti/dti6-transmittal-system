<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DTI-R6 TMS - Transmittal Tracking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --navy: #001f3f;
            --light-navy: #e8eef7;
        }

        body {
            background: linear-gradient(135deg, var(--navy) 0%, #003a7a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            max-width: 700px;
        }

        .header {
            text-align: center;
            color: white;
            margin-bottom: 3rem;
        }

        .header h1 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .header p {
            font-size: 1rem;
            opacity: 0.9;
        }

        .tracking-card {
            background: white;
            border-radius: 1.5rem;
            box-shadow: 0 20px 60px rgba(0, 31, 63, 0.3);
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(135deg, var(--navy) 0%, #003a7a 100%);
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .card-header h2 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .card-header p {
            font-size: 0.95rem;
            opacity: 0.95;
            margin-bottom: 0;
        }

        .card-body {
            padding: 2rem;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 1.5rem;
            border-bottom: 1px solid #f0f0f0;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: 700;
            color: var(--navy);
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            min-width: 150px;
        }

        .detail-value {
            font-size: 1.1rem;
            color: #333;
            text-align: right;
            flex: 1;
            margin-left: 1rem;
        }

        .status-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-submitted {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-received {
            background-color: #d4edda;
            color: #155724;
        }

        .status-draft {
            background-color: #e2e3e5;
            color: #383d41;
        }

        .office-info {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .office-code {
            font-weight: 700;
            color: var(--navy);
            font-size: 1.05rem;
        }

        .office-name {
            color: #666;
            font-size: 0.9rem;
        }

        .description-section {
            background-color: var(--light-navy);
            padding: 1.5rem;
            border-radius: 1rem;
            margin: 1.5rem 0;
        }

        .description-section h4 {
            color: var(--navy);
            font-weight: 700;
            margin-bottom: 1rem;
            font-size: 1rem;
        }

        .description-text {
            color: #333;
            line-height: 1.6;
        }

        .error-message {
            text-align: center;
            padding: 3rem 2rem;
        }

        .error-icon {
            font-size: 4rem;
            color: #dc3545;
            margin-bottom: 1rem;
        }

        .footer {
            text-align: center;
            margin-top: 2rem;
            color: white;
            opacity: 0.8;
            font-size: 0.9rem;
        }

        @media (max-width: 576px) {
            .header h1 {
                font-size: 1.8rem;
            }

            .detail-row {
                flex-direction: column;
                padding: 1rem;
            }

            .detail-label {
                margin-bottom: 0.5rem;
                min-width: auto;
            }

            .detail-value {
                text-align: left;
                margin-left: 0;
            }

            .card-body {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="bi bi-shield-check me-2"></i>DTI-R6 TMS</h1>
            <p>Transmittal Management System</p>
        </div>

        @if ($transmittal)
            <div class="tracking-card">
                <div class="card-header">
                    <h2>{{ $transmittal->reference_number }}</h2>
                    <p>Transmittal Tracking Information</p>
                </div>
                <div class="card-body">
                    <!-- Reference Number -->
                    <div class="detail-row">
                        <div class="detail-label"><i class="bi bi-file-earmark-text me-2"></i>Reference #</div>
                        <div class="detail-value fw-bold">{{ $transmittal->reference_number }}</div>
                    </div>

                    <!-- Execution Date -->
                    <div class="detail-row">
                        <div class="detail-label"><i class="bi bi-calendar-event me-2"></i>Execution Date</div>
                        <div class="detail-value">{{ \Carbon\Carbon::parse($transmittal->transmittal_date)->format('F d, Y') }}</div>
                    </div>

                    <!-- Origin -->
                    <div class="detail-row">
                        <div class="detail-label"><i class="bi bi-geo-alt me-2"></i>Origin</div>
                        <div class="detail-value">
                            <div class="office-info">
                                <span class="office-code">{{ $transmittal->senderOffice->code }}</span>
                                <span class="office-name">{{ $transmittal->senderOffice->name }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Destination -->
                    <div class="detail-row">
                        <div class="detail-label"><i class="bi bi-geo-alt-fill me-2"></i>Destination</div>
                        <div class="detail-value">
                            <div class="office-info">
                                <span class="office-code">{{ $transmittal->receiverOffice->code }}</span>
                                <span class="office-name">{{ $transmittal->receiverOffice->name }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="detail-row">
                        <div class="detail-label"><i class="bi bi-info-circle me-2"></i>Status</div>
                        <div class="detail-value">
                            @php
                                $statusClass = 'status-' . strtolower(str_replace(' ', '-', $transmittal->status));
                            @endphp
                            <span class="status-badge {{ $statusClass }}">
                                {{ $transmittal->status }}
                            </span>
                        </div>
                    </div>

                    @if ($transmittal->received_at)
                        <div class="detail-row">
                            <div class="detail-label"><i class="bi bi-check-circle me-2"></i>Received Date</div>
                            <div class="detail-value">{{ \Carbon\Carbon::parse($transmittal->received_at)->format('F d, Y \a\t h:i A') }}</div>
                        </div>
                    @endif
                </div>
            </div>
        @else
            <div class="tracking-card">
                <div class="card-body error-message">
                    <div class="error-icon">
                        <i class="bi bi-exclamation-circle"></i>
                    </div>
                    <h3 class="mb-2" style="color: var(--navy);">Transmittal Not Found</h3>
                    <p class="text-muted">
                        {{ $error ?? 'The transmittal reference number could not be found in the system. Please check the QR code or reference number and try again.' }}
                    </p>
                </div>
            </div>
        @endif

        <div class="footer">
            <p><i class="bi bi-shield-check me-2"></i>DTI Region VI - Transmittal Management System</p>
            <p style="font-size: 0.8rem; margin-top: 0.5rem;">This is a public information page. For detailed access, please contact your office administrator.</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
