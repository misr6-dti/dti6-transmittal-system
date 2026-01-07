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
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', '{{ $gaId }}');
    </script>
    @endif
    <title>DTI Region VI - Authorization</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #001f3f 0%, #001226 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            color: #fff;
            padding: 0;
            margin: 0;
        }
        .main-wrapper {
            flex-grow: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            width: 100%;
        }
        .auth-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 2.5rem;
            width: 100%;
            padding: 3rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }
        @media (max-width: 576px) {
            .auth-card {
                padding: 2rem;
                border-radius: 1.5rem;
            }
        }
        .info-section {
            padding-right: 3rem;
        }
        .info-title {
            font-size: 2.5rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1.5rem;
            background: linear-gradient(to right, #fff, rgba(255,255,255,0.5));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .info-text {
            font-size: 1.1rem;
            line-height: 1.7;
            color: rgba(255, 255, 255, 0.7);
            text-align: justify;
        }
        .form-control {
            background: rgba(255, 255, 255, 0.08) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: #fff !important;
            padding: 0.8rem 1.25rem;
            border-radius: 1rem;
        }
        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.4);
        }
        .form-control:focus {
            background: rgba(255, 255, 255, 0.12) !important;
            border-color: rgba(255, 255, 255, 0.3) !important;
            box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.05);
        }
        .btn-premium {
            background: #fff;
            color: #001f3f;
            border: none;
            padding: 1rem;
            border-radius: 1rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s;
        }
        .btn-premium:hover {
            background: #f8fafc;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        .logo-box {
            width: 120px;
            height: auto;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
        }
        .logo-box img {
            width: 100%;
            height: auto;
        }
        .form-label {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 0.5rem;
            color: rgba(255, 255, 255, 0.6);
        }
        a { color: rgba(255, 255, 255, 0.8); text-decoration: none; font-size: 0.85rem; }
        a:hover { color: #fff; }
        .text-danger { color: #ff6b6b !important; font-size: 0.75rem; font-weight: 600; }
        select option { background: #001226; color: #fff; }
    </style>
</head>
<body>
    <div class="main-wrapper">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                @php
                    $isWide = isset($wide) && $wide;
                    if (isset($info)) {
                        $colClass = 'col-lg-6 col-xl-5';
                    } elseif ($isWide) {
                        $colClass = 'col-md-10 col-lg-8 col-xl-7';
                    } else {
                        $colClass = 'col-md-8 col-lg-5 col-xl-4';
                    }
                @endphp
                @if(isset($info))
                <div class="col-lg-6 d-none d-lg-block">
                    <div class="info-section animate-in fade-in slide-in-from-left duration-1000">
                        {{ $info }}
                    </div>
                </div>
                @endif
                <div class="{{ $colClass }}">
                    <div class="auth-card animate-in fade-in zoom-in duration-700">
                        <div class="logo-box">
                            <img src="{{ asset('images/dti-logo.png') }}" alt="DTI Logo">
                        </div>
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container text-center py-4 no-print">
        <p class="small mb-0 opacity-50" style="color: rgba(255,255,255,0.6);">Developed by R6 MIS Unit -> Bonjourz</p>
    </div>
</body>
</html>
