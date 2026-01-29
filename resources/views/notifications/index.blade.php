@extends('layouts.app')

@section('content')
<div class="container px-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0" style="color: var(--dti-navy); font-weight: 700;">
                    <i class="bi bi-bell me-2"></i>Notifications
                </h1>
                @if($notifications->total() > 0)
                    <button class="btn btn-sm btn-outline-navy" id="markAllReadBtn">
                        <i class="bi bi-check2-all me-1"></i>Mark all as read
                    </button>
                @endif
            </div>

            @if($notifications->count() > 0)
                <!-- Notifications List -->
                <div class="notifications-container">
                    @foreach($notifications as $notification)
                        <div class="notification-item {{ $notification->isUnread() ? 'unread' : 'read' }}" data-notification-id="{{ $notification->id }}">
                            <div class="notification-content">
                                <div class="notification-header">
                                    <h5 class="notification-title">{{ $notification->title }}</h5>
                                    <small class="notification-time">{{ $notification->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="notification-message">{{ $notification->message }}</p>
                                @if($notification->link)
                                    <a href="{{ $notification->link }}" class="notification-link">
                                        View <i class="bi bi-arrow-right ms-1"></i>
                                    </a>
                                @endif
                            </div>

                            <div class="notification-actions">
                                @if($notification->isUnread())
                                    <button class="btn btn-sm btn-icon mark-read-btn" data-id="{{ $notification->id }}" title="Mark as read">
                                        <i class="bi bi-check-circle"></i>
                                    </button>
                                @else
                                    <button class="btn btn-sm btn-icon mark-unread-btn" data-id="{{ $notification->id }}" title="Mark as unread">
                                        <i class="bi bi-circle"></i>
                                    </button>
                                @endif
                                <button class="btn btn-sm btn-icon delete-btn" data-id="{{ $notification->id }}" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($notifications->hasPages())
                    <div class="mt-4">
                        {{ $notifications->links() }}
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="card border-0">
                    <div class="card-body text-center py-5">
                        <div class="mb-3" style="font-size: 3rem; color: #cbd5e1;">
                            <i class="bi bi-inbox"></i>
                        </div>
                        <h5 style="color: var(--dti-navy); font-weight: 600;">No Notifications</h5>
                        <p class="text-muted mb-0">You're all caught up! Check back later for new updates.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .notifications-container {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .notification-item {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 1.25rem;
        border-radius: 0.75rem;
        border: 1px solid #e5e7eb;
        background-color: white;
        transition: all 0.2s ease;
    }

    .notification-item.unread {
        background-color: #f0f9ff;
        border-color: #3b82f6;
        border-left: 4px solid #3b82f6;
    }

    .notification-item:hover {
        box-shadow: 0 4px 12px rgba(0, 31, 63, 0.08);
    }

    .notification-content {
        flex: 1;
        min-width: 0;
    }

    .notification-header {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        margin-bottom: 0.5rem;
        gap: 1rem;
    }

    .notification-title {
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--dti-navy);
        margin: 0;
    }

    .notification-time {
        font-size: 0.8rem;
        color: #9ca3af;
        white-space: nowrap;
    }

    .notification-message {
        font-size: 0.9rem;
        color: #4b5563;
        margin: 0.5rem 0;
        line-height: 1.5;
    }

    .notification-link {
        display: inline-block;
        font-size: 0.85rem;
        color: var(--dti-navy);
        text-decoration: none;
        font-weight: 600;
        margin-top: 0.5rem;
        transition: all 0.2s;
    }

    .notification-link:hover {
        color: var(--dti-dark);
        text-decoration: underline;
    }

    .notification-actions {
        display: flex;
        gap: 0.5rem;
        margin-left: 1rem;
    }

    .btn-icon {
        width: 2rem;
        height: 2rem;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.5rem;
        border: 1px solid #e5e7eb;
        background: white;
        color: var(--dti-navy);
        transition: all 0.2s;
    }

    .btn-icon:hover {
        background-color: #f3f4f6;
        border-color: var(--dti-navy);
        color: var(--dti-navy);
    }

    .btn-icon i {
        font-size: 1rem;
    }

    @media (max-width: 576px) {
        .notification-item {
            flex-direction: column;
            align-items: flex-start;
        }

        .notification-header {
            width: 100%;
            margin-bottom: 0.75rem;
        }

        .notification-actions {
            width: 100%;
            margin-left: 0;
            margin-top: 0.75rem;
            justify-content: flex-start;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mark as read button
        document.querySelectorAll('.mark-read-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                markNotificationAsRead(id);
            });
        });

        // Mark as unread button
        document.querySelectorAll('.mark-unread-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                markNotificationAsUnread(id);
            });
        });

        // Delete button
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                if (confirm('Are you sure you want to delete this notification?')) {
                    deleteNotification(id);
                }
            });
        });

        // Mark all as read button
        const markAllBtn = document.getElementById('markAllReadBtn');
        if (markAllBtn) {
            markAllBtn.addEventListener('click', function() {
                markAllNotificationsAsRead();
            });
        }
    });

    function markNotificationAsRead(id) {
        fetch(`/notifications/${id}/read`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const item = document.querySelector(`[data-notification-id="${id}"]`);
                item.classList.remove('unread');
                item.classList.add('read');
                // Reload notification count
                updateNotificationCount();
            }
        });
    }

    function markNotificationAsUnread(id) {
        fetch(`/notifications/${id}/unread`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const item = document.querySelector(`[data-notification-id="${id}"]`);
                item.classList.add('unread');
                item.classList.remove('read');
                // Reload notification count
                updateNotificationCount();
            }
        });
    }

    function deleteNotification(id) {
        fetch(`/notifications/${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const item = document.querySelector(`[data-notification-id="${id}"]`);
                item.remove();
                // Reload notification count
                updateNotificationCount();
                // Check if empty
                const container = document.querySelector('.notifications-container');
                if (container && container.children.length === 0) {
                    location.reload();
                }
            }
        });
    }

    function markAllNotificationsAsRead() {
        fetch('/notifications/mark-all-read', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.querySelectorAll('.notification-item.unread').forEach(item => {
                    item.classList.remove('unread');
                    item.classList.add('read');
                });
                updateNotificationCount();
            }
        });
    }

    function updateNotificationCount() {
        fetch('/notifications/unread-count')
            .then(response => response.json())
            .then(data => {
                const badge = document.querySelector('[data-notification-count]');
                if (badge) {
                    if (data.count > 0) {
                        badge.textContent = data.count;
                        badge.style.display = 'inline-block';
                    } else {
                        badge.style.display = 'none';
                    }
                }
            });
    }
</script>
@endsection
