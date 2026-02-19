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
    <title>DTI Region VI - Authorization</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">

    <!-- Assets -->
    <link rel="stylesheet" href="{{ asset(mix('css/app.css')) }}">
    <script src="{{ asset(mix('js/app.js')) }}" defer></script>

    <style>
        [x-cloak] { display: none !important; }
        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>

<body class="font-sans antialiased min-h-screen flex flex-col bg-gradient-to-br from-navy to-navy-dark text-white selection:bg-white selection:text-navy">
    <div class="flex-grow flex items-center justify-center p-8 w-full">
        <div class="container max-w-6xl mx-auto">
            <div class="flex flex-wrap items-center justify-center">
                
                @if(isset($info))
                    <div class="hidden lg:block lg:w-1/2 pr-12">
                        <div class="animate-in fade-in slide-in-from-left duration-1000">
                            {{ $info }}
                        </div>
                    </div>
                @endif

                <div class="{{ isset($info) ? 'w-full lg:w-5/12' : (isset($wide) && $wide ? 'w-full md:w-10/12 lg:w-8/12' : 'w-full md:w-8/12 lg:w-5/12 xl:w-4/12') }}">
                    <div class="glass-card rounded-[2.5rem] p-8 md:p-12 shadow-2xl relative overflow-hidden animate-in fade-in zoom-in duration-700">
                        <div class="flex justify-center">
                            <img src="{{ asset('images/dti-logo.png') }}" alt="DTI Logo" class="w-32 h-auto">
                        </div>
                        {{ $slot }}
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="text-center py-6 no-print">
        <p class="text-sm text-white/60">&copy; 2026 DTI Region VI - Transmittal Management System. All rights reserved. | Developed by DTI Region VI MIS</p>
    </div>

    {{-- Toast Notifications --}}
    @include('components.toast')

    {{-- Flash session messages to toast --}}
    @if(session('success') || session('error') || session('status') || $errors->any())
    <script>
        document.addEventListener('alpine:init', () => {
            @if(session('success'))
                Alpine.store('toast').show({ type: 'success', message: @json(session('success')) });
            @endif
            @if(session('error'))
                Alpine.store('toast').show({ type: 'error', message: @json(session('error')) });
            @endif
            @if(session('status'))
                (function() {
                    var statusMap = {
                        'profile-updated': 'Profile updated successfully.',
                        'password-updated': 'Password updated successfully.',
                        'verification-link-sent': 'A new verification link has been sent to your email.'
                    };
                    var raw = @json(session('status'));
                    var msg = statusMap[raw] || raw;
                    Alpine.store('toast').show({ type: 'success', message: msg });
                })();
            @endif
            @if($errors->any())
                @foreach($errors->all() as $error)
                    Alpine.store('toast').show({ type: 'error', message: @json($error) });
                @endforeach
            @endif
        });
    </script>
    @endif
</body>
</html>