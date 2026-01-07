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

    <title>DTI Region VI - Transmittal System</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

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
        .nav-link {
            color: rgba(255,255,255,0.7) !important;
            font-weight: 500;
            font-size: 0.95rem;
            margin: 0 0.5rem;
            transition: all 0.2s;
        }
        .nav-link:hover, .nav-link.active {
            color: #fff !important;
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
        .btn-navy {
            background-color: var(--dti-navy);
            color: #fff;
            border: none;
            padding: 0.6rem 1.5rem;
            border-radius: 0.75rem;
            font-weight: 600;
            transition: all 0.2s;
        }
        .btn-navy:hover {
            background-color: var(--dti-dark);
            color: #fff;
            transform: translateY(-1px);
        }
        .table thead th {
            background-color: #f8fafc;
            text-transform: uppercase;
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--dti-gray);
            letter-spacing: 0.5px;
            border: none;
            padding: 1rem 1.5rem;
        }
        .table tbody td {
            padding: 1rem 1.5rem;
            vertical-align: middle;
            border-color: #f1f5f9;
        }
        .status-badge {
            display: inline-block;
            padding: 0.35rem 0.75rem;
            border-radius: 2rem;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            white-space: nowrap;
            line-height: 1.2;
        }
        @media (max-width: 768px) {
            .status-badge {
                font-size: 0.65rem;
                padding: 0.3rem 0.6rem;
            }
        }
        .bg-draft { background-color: #e2e8f0; color: #475569; }
        .bg-submitted { background-color: #dcfce7; color: #166534; }
        .bg-received { background-color: #dbeafe; color: #1e40af; }
        .bg-pending-arrival { background-color: #fef3c7; color: #92400e; }
        
        .form-control, .form-select {
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            border-color: #e2e8f0;
            font-size: 0.95rem;
        }
        .form-control:focus {
            border-color: var(--dti-navy);
            box-shadow: 0 0 0 4px rgba(0, 31, 63, 0.1);
        }
        #items-table input, #items-table textarea {
            border: none;
            background: transparent;
            width: 100%;
            outline: none;
        }
        #items-table td {
            padding: 0.5rem;
        }
        #items-table tr:hover td {
            background-color: #f8fafc;
        }
        
        /* Pagination Styling */
        .pagination {
            margin-bottom: 0;
            gap: 5px;
        }
        .page-link {
            border-radius: 0.5rem !important;
            border: 1px solid #e2e8f0;
            color: var(--dti-navy);
            padding: 0.5rem 0.85rem;
            font-size: 0.85rem;
            font-weight: 500;
        }
        .page-item.active .page-link {
            background-color: var(--dti-navy);
            border-color: var(--dti-navy);
        }
        .page-item.disabled .page-link {
            background-color: #f8fafc;
            color: #94a3b8;
        }
        @media (max-width: 576px) {
            .pagination {
                flex-wrap: wrap;
                justify-content: center;
            }
        }
        
        @media print {
            .no-print { display: none !important; }
            body { background: white; }
            .card { box-shadow: none; border: 1px solid #eee; }
        }
        .btn-outline-navy { color: var(--dti-navy); border-color: var(--dti-navy); }
        .btn-outline-navy:hover { background-color: var(--dti-navy); color: white; }
        section { scroll-margin-top: 6rem; }
        .list-group-item.active { background-color: var(--dti-navy); border-color: var(--dti-navy); }
        .lh-relaxed { line-height: 1.8; }
        .border-navy { border-color: var(--dti-navy) !important; }
        @media print {
            .col-lg-3 { display: none !important; }
            .col-lg-9 { width: 100% !important; flex: 0 0 100% !important; max-width: 100% !important; }
            .card { box-shadow: none !important; border: 1px solid #eee !important; }
        }
    </style>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('transmittals.*') ? 'active' : '' }}" href="{{ route('transmittals.index') }}">Transmittals</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('audit.index') ? 'active' : '' }}" href="{{ route('audit.index') }}">Audit History</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('faqs') ? 'active' : '' }}" href="{{ route('faqs') }}">FAQs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('manual') ? 'active' : '' }}" href="{{ route('manual') }}">User Manual</a>
                    </li>
                    @hasanyrole('Super Admin|Regional MIS')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->is('admin/*') ? 'active' : '' }}" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            System Settings
                        </a>
                        <ul class="dropdown-menu shadow border-0 mt-2" aria-labelledby="adminDropdown">
                            <li><a class="dropdown-item" href="{{ route('admin.users.index') }}"><i class="bi bi-people me-2"></i>User Management</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.roles.index') }}"><i class="bi bi-shield-lock me-2"></i>User Roles</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.offices.index') }}"><i class="bi bi-building me-2"></i>Office Management</a></li>
                        </ul>
                    </li>
                    @endhasanyrole
                </ul>
                <!-- Notification Bell -->
                <div class="dropdown me-3 no-print">
                    <button class="btn btn-link nav-link position-relative border-0" type="button" id="notificationBell" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-bell-fill fs-5"></i>
                        <span id="notificationBadge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger d-none" style="font-size: 0.6rem;">0</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3 p-0 overflow-hidden" id="notificationDropdown" aria-labelledby="notificationBell" style="width: 320px; border-radius: 1rem;">
                        <li class="p-3 border-bottom bg-light">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fw-bold">Notifications</h6>
                                <span class="badge bg-navy-subtle text-navy" id="unreadCountText">0 New</span>
                            </div>
                        </li>
                        <div id="notificationList" style="max-height: 400px; overflow-y: auto;">
                            <!-- Notifications will be injected here -->
                            <li class="p-4 text-center text-muted small">No notifications</li>
                        </div>
                    </ul>
                </div>
                <div class="dropdown">
                    <button class="btn btn-link nav-link dropdown-toggle d-flex align-items-center border-0" type="button" data-bs-toggle="dropdown">
                        <div class="bi bi-person-circle fs-5 me-2"></div>
                        <span>{{ Auth::user()->name }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3 p-2" style="border-radius: 1rem;">
                        <li class="px-3 py-2 text-muted small uppercase fw-bold" style="font-size: 0.7rem;">Account</li>
                        <li><a class="dropdown-item rounded-3" href="{{ route('profile.edit') }}">My Profile</a></li>
                        <li><hr class="dropdown-divider mx-2"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item rounded-3 text-danger">Sign Out</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <main class="container py-5 px-4" style="min-height: 80vh;">
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 no-print" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4 no-print" role="alert">
                {{ session('error') }}
            </div>
        @endif
        
        @yield('content')
    </main>

    <footer class="container text-center py-5 text-muted small border-top no-print">
        <p class="mb-1">&copy; {{ date('Y') }} DTI Region VI - Transmittal Management System. All rights reserved.</p>
        <p class="mb-0">Developed by R6 MIS Unit -> Bonjourz</p>
    </footer>

    <!-- Reusable Confirmation Modal -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="confirmationModalLabel">Confirm Action</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <p id="confirmationModalMessage" class="mb-0 text-muted">Are you sure you want to proceed with this action?</p>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-3 px-4" data-bs-dismiss="modal">Cancel</button>
                    <form id="confirmationModalForm" method="POST" class="d-inline">
                        @csrf
                        <div id="confirmationModalMethod"></div>
                        <button type="submit" id="confirmationModalButton" class="btn btn-navy rounded-3 px-4">Confirm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Confirmation Modal Logic
            const confirmationModal = document.getElementById('confirmationModal');
            if (confirmationModal) {
                confirmationModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const action = button.getAttribute('data-action');
                    const method = button.getAttribute('data-method') || 'POST';
                    const title = button.getAttribute('data-title') || 'Confirm Action';
                    const message = button.getAttribute('data-message') || 'Are you sure you want to proceed?';
                    const btnClass = button.getAttribute('data-btn-class') || 'btn-navy';
                    const btnText = button.getAttribute('data-btn-text') || 'Confirm';

                    const modalTitle = confirmationModal.querySelector('.modal-title');
                    const modalMessage = confirmationModal.querySelector('#confirmationModalMessage');
                    const modalForm = confirmationModal.querySelector('#confirmationModalForm');
                    const modalMethodDiv = confirmationModal.querySelector('#confirmationModalMethod');
                    const modalButton = confirmationModal.querySelector('#confirmationModalButton');

                    modalTitle.textContent = title;
                    modalMessage.textContent = message;
                    modalForm.setAttribute('action', action);
                    
                    modalMethodDiv.innerHTML = '';
                    if (method.toUpperCase() !== 'POST' && method.toUpperCase() !== 'GET') {
                        const methodInput = document.createElement('input');
                        methodInput.setAttribute('type', 'hidden');
                        methodInput.setAttribute('name', '_method');
                        methodInput.setAttribute('value', method.toUpperCase());
                        modalMethodDiv.appendChild(methodInput);
                    }

                    modalButton.className = `btn ${btnClass} rounded-3 px-4`;
                    modalButton.textContent = btnText;
                });
            }

            // Notification Polling Logic
            const notificationBadge = document.getElementById('notificationBadge');
            const unreadCountText = document.getElementById('unreadCountText');
            const notificationList = document.getElementById('notificationList');

            function fetchNotifications() {
                fetch('{{ route('notifications.unreadCount') }}')
                    .then(response => response.json())
                    .then(data => {
                        if (data.count > 0) {
                            notificationBadge.textContent = data.count;
                            notificationBadge.classList.remove('d-none');
                            unreadCountText.textContent = `${data.count} New`;
                        } else {
                            notificationBadge.classList.add('d-none');
                            unreadCountText.textContent = `0 New`;
                        }
                    });

                // Update Dashboard Stats and Table if present
                const pendingIncomingDash = document.getElementById('pendingIncomingDash');
                const recentTransmittalsBody = document.getElementById('recentTransmittalsBody');
                
                if (pendingIncomingDash || recentTransmittalsBody) {
                    fetch('{{ route('dashboard.stats') }}')
                        .then(response => response.json())
                        .then(data => {
                            if (pendingIncomingDash) {
                                const s = data.stats;
                                pendingIncomingDash.textContent = s.pending_incoming;
                                
                                const pendingOutgoingDash = document.getElementById('pendingOutgoingDash');
                                if (pendingOutgoingDash) pendingOutgoingDash.textContent = s.pending_outgoing;
                                
                                const totalSentDash = document.getElementById('totalSentDash');
                                if (totalSentDash) totalSentDash.textContent = s.total_sent;
                                
                                const totalReceivedDash = document.getElementById('totalReceivedDash');
                                if (totalReceivedDash) totalReceivedDash.textContent = s.total_received;
                            }

                            if (recentTransmittalsBody && data.recent) {
                                if (data.recent.length === 0) {
                                    recentTransmittalsBody.innerHTML = '<tr><td colspan="6" class="text-center py-5 text-muted italic">No recent transmittals found.</td></tr>';
                                } else {
                                    recentTransmittalsBody.innerHTML = '';
                                    data.recent.forEach(t => {
                                        const tr = document.createElement('tr');
                                        tr.innerHTML = `
                                            <td class="fw-bold">${t.reference_number}</td>
                                            <td>${t.transmittal_date}</td>
                                            <td>${t.sender_office}</td>
                                            <td>${t.receiver_office}</td>
                                            <td>
                                                <span class="status-badge bg-${t.badge_class}">
                                                    ${t.status}
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <a href="${t.show_url}" class="btn btn-sm btn-navy rounded-3">View</a>
                                            </td>
                                        `;
                                        recentTransmittalsBody.appendChild(tr);
                                    });
                                }
                            }
                        });
                }
            }

            function loadNotificationContent() {
                fetch('{{ route('notifications.index') }}')
                    .then(response => response.json())
                    .then(data => {
                        notificationList.innerHTML = '';
                        if (data.length === 0) {
                            notificationList.innerHTML = '<li class="p-4 text-center text-muted small">No notifications</li>';
                        } else {
                            data.forEach(item => {
                                const isRead = item.read_at !== null;
                                const li = document.createElement('li');
                                li.className = `p-3 border-bottom notification-item ${isRead ? '' : 'bg-light'}`;
                                li.style.cursor = 'pointer';
                                li.innerHTML = `
                                    <div class="d-flex align-items-start">
                                        <div class="bg-navy rounded-circle p-2 me-3 text-white">
                                            <i class="bi ${item.title.includes('Incoming') ? 'bi-box-arrow-in-down' : 'bi-check-circle'} small"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="fw-bold small text-dark">${item.title}</div>
                                            <div class="small text-muted mb-1" style="font-size: 0.75rem;">${item.message}</div>
                                            <div class="small text-muted" style="font-size: 0.65rem;">${new Date(item.created_at).toLocaleString()}</div>
                                        </div>
                                    </div>
                                `;
                                li.onclick = () => {
                                    if (!isRead) {
                                        fetch(`/notifications/${item.id}/read`, {
                                            method: 'POST',
                                            headers: {
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                'Content-Type': 'application/json'
                                            }
                                        }).then(() => {
                                            if (item.link) window.location.href = item.link;
                                            else loadNotificationContent();
                                        });
                                    } else {
                                        if (item.link) window.location.href = item.link;
                                    }
                                };
                                notificationList.appendChild(li);
                            });
                        }
                    });
            }

            if (notificationBadge) {
                fetchNotifications();
                setInterval(fetchNotifications, 30000); // Poll every 30 seconds

                document.getElementById('notificationBell').addEventListener('click', loadNotificationContent);
            }
        });
    </script>
</body>
</html>
