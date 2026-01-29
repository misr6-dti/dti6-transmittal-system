<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if($gaId = config('services.google.analytics_id'))
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $gaId }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag() { dataLayer.push(arguments); }
            gtag('js', new Date());
            gtag('config', '{{ $gaId }}');
        </script>
    @endif

    <title>DTI Region VI - Transmittal System</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- CSS Dependencies (Local) -->
    <link rel="stylesheet" href="{{ asset('css/vendor.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('css/app.css')) }}">

    <!-- Custom Navy Theme -->
    <style>
        :root {
            --dti-navy: #001f3f;
            --dti-dark: #001226;
            --dti-light: #f8fafc;
            --dti-gray: #64748b;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--dti-light);
            color: #1e293b;
        }

        .navbar-custom {
            background-color: var(--dti-navy);
            padding: 1.25rem 0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1030;
        }

        .navbar-brand {
            font-weight: 800;
            letter-spacing: -0.5px;
            color: #fff !important;
            font-size: 1.5rem;
        }

        .navbar-nav {
            display: none !important;
        }

        .navbar-toggler {
            display: none !important;
        }

        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
            overflow: hidden;
            background: #fff;
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid #f1f5f9;
            padding: 1.5rem;
            font-weight: 700;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background: white;
            }

            .card {
                box-shadow: none;
                border: 1px solid #eee;
            }
        }
    </style>

    <!-- Alpine.js -->
    <!-- JS Dependencies (Local) -->
    <script src="{{ asset(mix('js/app.js')) }}" defer></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom no-print sticky-top shadow-sm">
        <div class="container px-4">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('dashboard') }}">
                <i class="bi bi-shield-check me-2"></i>
                DTI-R6 TMS
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                </ul>
            </div>
        </div>
    </nav>
    <main>
        @yield('content')
    </main>
    <div class="container text-center py-4 no-print">
        <p class="small mb-0" style="color: #94a3b8;">&copy; 2026 DTI Region VI - Transmittal Management System. All rights reserved. | Developed by DTI Region VI MIS</p>
    </div>
</body>

</html>
