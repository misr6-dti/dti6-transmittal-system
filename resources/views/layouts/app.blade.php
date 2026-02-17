<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app-url" content="{{ url('/') }}">

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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset(mix('css/app.css')) }}">

    <!-- Scripts -->
    <script src="{{ asset(mix('js/app.js')) }}" defer></script>
    <style>
        [x-cloak] { display: none !important; }
        @media print {
            .no-print { display: none !important; }
            body { background: white; }
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-50 text-slate-800">
    <!-- Navbar -->
    <nav class="bg-navy sticky top-0 z-50 shadow-lg no-print" x-data="{ mobileOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center text-white font-extrabold text-xl tracking-tight">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        DTI-R6 TMS
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'text-white bg-navy-light' : 'text-gray-300 hover:bg-navy-dark hover:text-white' }} px-3 py-2 rounded-md text-sm font-medium transition-colors flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            Dashboard
                        </a>
                        <a href="{{ route('transmittals.index') }}" class="{{ request()->routeIs('transmittals.*') ? 'text-white bg-navy-light' : 'text-gray-300 hover:bg-navy-dark hover:text-white' }} px-3 py-2 rounded-md text-sm font-medium transition-colors flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            Transmittals
                        </a>
                        <a href="{{ route('audit.index') }}" class="{{ request()->routeIs('audit.index') ? 'text-white bg-navy-light' : 'text-gray-300 hover:bg-navy-dark hover:text-white' }} px-3 py-2 rounded-md text-sm font-medium transition-colors flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Audit
                        </a>
                        <a href="{{ route('faqs') }}" class="{{ request()->routeIs('faqs') ? 'text-white bg-navy-light' : 'text-gray-300 hover:bg-navy-dark hover:text-white' }} px-3 py-2 rounded-md text-sm font-medium transition-colors flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            FAQs
                        </a>

                        @hasanyrole('Super Admin|Regional MIS')
                        <div class="relative" x-data="{ open: false }" @click.away="open = false">
                            <button @click="open = !open" class="text-gray-300 hover:bg-navy-dark hover:text-white px-3 py-2 rounded-md text-sm font-medium flex items-center focus:outline-none">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                Settings
                                <svg class="ml-1 w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div x-show="open" x-cloak class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 z-50">
                                <a href="{{ route('admin.users.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">User Management</a>
                                <a href="{{ route('admin.roles.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">User Roles</a>
                                <a href="{{ route('admin.offices.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Offices</a>
                                <a href="{{ route('admin.divisions.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Divisions</a>
                            </div>
                        </div>
                        @endhasanyrole
                    </div>
                </div>

                <!-- Right Side (Notifications & Profile) -->
                @auth
                <div class="hidden md:flex items-center ml-4 space-x-4">
                    <!-- Notifications -->
                    <div class="relative" x-data="notifications" @click.away="open = false">
                        <button @click="fetchList()" class="bg-navy p-1 rounded-full text-gray-300 hover:text-white focus:outline-none relative">
                            <span class="sr-only">View notifications</span>
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            <span x-show="count > 0" x-text="count" class="absolute top-0 right-0 block h-4 w-4 transform -translate-y-1/2 translate-x-1/2 rounded-full ring-2 ring-navy bg-red-500 text-white text-[10px] font-bold flex items-center justify-center"></span>
                        </button>

                        <div x-show="open" x-cloak class="origin-top-right absolute right-0 mt-2 w-80 rounded-2xl shadow-xl py-1 bg-white ring-1 ring-black ring-opacity-5 overflow-hidden z-50">
                            <div class="px-4 py-3 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                                <h3 class="text-sm font-bold text-navy">Notifications</h3>
                                <span class="bg-navy/10 text-navy text-xs font-bold px-2 py-0.5 rounded-full" x-text="count + ' New'"></span>
                            </div>
                            <ul class="max-h-96 overflow-y-auto">
                                <template x-for="item in unread" :key="item.id">
                                    <li @click="markRead(item.id, item.link)" class="px-4 py-3 hover:bg-gray-50 cursor-pointer border-b border-gray-50 last:border-0 transition-colors">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0 bg-navy text-white rounded-full p-1.5 mr-3">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-semibold text-gray-900" x-text="item.title"></p>
                                                <p class="text-xs text-gray-500 truncate" x-text="item.message"></p>
                                                <p class="text-[10px] text-gray-400 mt-1" x-text="new Date(item.created_at).toLocaleString()"></p>
                                            </div>
                                        </div>
                                    </li>
                                </template>
                                <li x-show="unread.length === 0" class="px-4 py-6 text-center text-sm text-gray-500 italic">No new notifications</li>
                            </ul>
                            <div class="border-t border-gray-100 bg-gray-50">
                                <a href="{{ route('notifications.index') }}" class="block w-full text-center px-4 py-2 text-xs font-bold text-navy hover:text-navy-light transition-colors">View All</a>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Dropdown -->
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <button @click="open = !open" class="flex items-center text-gray-300 hover:text-white focus:outline-none">
                            <svg class="h-8 w-8 rounded-full bg-navy-light p-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            <span class="ml-2 text-sm font-medium">{{ Auth::user()->name }}</span>
                            <svg class="ml-1 w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="open" x-cloak class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 z-50">
                            <div class="px-4 py-2 border-b border-gray-100">
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Account</p>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">Sign Out</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endauth

                <!-- Mobile menu button -->
                <div class="-mr-2 flex md:hidden">
                    <button @click="mobileOpen = !mobileOpen" type="button" class="bg-navy inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-navy-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-navy focus:ring-white">
                        <span class="sr-only">Open main menu</span>
                        <svg class="h-6 w-6" :class="{'hidden': mobileOpen, 'block': !mobileOpen }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        <svg class="h-6 w-6" :class="{'hidden': !mobileOpen, 'block': mobileOpen }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileOpen" x-cloak class="md:hidden bg-navy-dark">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="{{ route('dashboard') }}" class="text-white block px-3 py-2 rounded-md text-base font-medium hover:bg-navy-light">Dashboard</a>
                <a href="{{ route('transmittals.index') }}" class="text-gray-300 hover:text-white block px-3 py-2 rounded-md text-base font-medium hover:bg-navy-light">Transmittals</a>
                <a href="{{ route('audit.index') }}" class="text-gray-300 hover:text-white block px-3 py-2 rounded-md text-base font-medium hover:bg-navy-light">Audit History</a>
                <a href="{{ route('faqs') }}" class="text-gray-300 hover:text-white block px-3 py-2 rounded-md text-base font-medium hover:bg-navy-light">FAQs</a>
            </div>
            @auth
            <div class="pt-4 pb-3 border-t border-navy-light">
                <div class="flex items-center px-5">
                    <div class="flex-shrink-0">
                        <svg class="h-10 w-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium leading-none text-white">{{ Auth::user()->name }}</div>
                        <div class="text-sm font-medium leading-none text-gray-400 mt-1">{{ Auth::user()->email }}</div>
                    </div>
                </div>
                <div class="mt-3 px-2 space-y-1">
                    <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-navy-light">Your Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-navy-light">Sign Out</button>
                    </form>
                </div>
            </div>
            @endauth
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 min-h-[80vh]">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-100 mt-auto no-print">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <p class="text-center text-gray-400 text-sm">
                &copy; 2026 DTI Region VI - Transmittal Management System. All rights reserved. | Developed by DTI Region VI MIS
            </p>
        </div>
    </footer>

    <!-- Global Confirmation Modal -->
    <div x-data="$store.confirm" x-show="open" x-cloak class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-navy-light sm:mx-0 sm:h-10 sm:w-10 text-white">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title" x-text="title"></h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500" x-text="message"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <form :action="action" method="POST" class="w-full sm:w-auto">
                        @csrf
                        <input type="hidden" name="_method" :value="method">
                        <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 text-base font-medium text-white hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm transition-colors" :class="btnClass" x-text="btnText"></button>
                    </form>
                    <button @click="close()" type="button" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-navy sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancel</button>
                </div>
            </div>
        </div>
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