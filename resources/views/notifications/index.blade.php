@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mb-8">
    <div class="no-print">
        <nav class="flex mb-2" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-navy hover:text-navy-light font-medium text-sm flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-slate-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="ml-1 text-sm font-medium text-slate-500 md:ml-2">Notifications</span>
                    </div>
                </li>
            </ol>
        </nav>
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-extrabold text-navy flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    Notifications
                </h1>
            </div>
            @if($notifications->total() > 0)
                <button id="markAllReadBtn" class="bg-white border border-navy text-navy hover:bg-navy hover:text-white transition-colors px-4 py-2 rounded-xl font-bold text-sm shadow-sm flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Mark all as read
                </button>
            @endif
        </div>
    </div>

    @if($notifications->count() > 0)
        <div class="space-y-4 notifications-container">
            @foreach($notifications as $notification)
                <div class="notification-item group relative bg-white rounded-2xl shadow-sm border p-5 transition-all w-full
                    {{ $notification->isUnread() ? 'border-primary/50 ring-1 ring-primary/10 bg-blue-50/30' : 'border-slate-100' }}" 
                    data-notification-id="{{ $notification->id }}">
                    
                    <div class="flex justify-between items-start gap-4">
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-baseline mb-1">
                                <h5 class="text-sm font-bold text-navy truncate pr-4">{{ $notification->title }}</h5>
                                <small class="text-xs text-slate-400 whitespace-nowrap">{{ $notification->created_at->diffForHumans() }}</small>
                            </div>
                            <p class="text-slate-600 text-sm leading-relaxed mb-2">{{ $notification->message }}</p>
                            @if($notification->link)
                                <a href="{{ $notification->link }}" class="inline-flex items-center text-xs font-bold text-navy hover:text-navy-light hover:underline mt-1">
                                    View Details <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </a>
                            @endif
                        </div>

                        <div class="flex flex-col gap-2 ml-4 opacity-100 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity">
                            @if($notification->isUnread())
                                <button class="mark-read-btn p-1.5 rounded-lg text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 transition-colors" data-id="{{ $notification->id }}" title="Mark as read">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </button>
                            @else
                                <button class="mark-unread-btn p-1.5 rounded-lg text-slate-400 hover:text-navy hover:bg-slate-100 transition-colors" data-id="{{ $notification->id }}" title="Mark as unread">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                                </button>
                            @endif
                            <button class="delete-btn p-1.5 rounded-lg text-slate-400 hover:text-red-500 hover:bg-red-50 transition-colors" data-id="{{ $notification->id }}" title="Delete">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($notifications->hasPages())
            <div class="mt-6">
                {{ $notifications->links() }}
            </div>
        @endif
    @else
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-12 text-center">
            <div class="text-slate-200 mb-4 flex justify-center">
                <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
            </div>
            <h5 class="text-xl font-bold text-navy mb-2">No Notifications</h5>
            <p class="text-slate-500">You're all caught up! Check back later for new updates.</p>
        </div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const appUrl = "{{ url('/') }}";
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

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

        function markNotificationAsRead(id) {
            fetch(`${appUrl}/notifications/${id}/read`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        }

        function markNotificationAsUnread(id) {
            fetch(`${appUrl}/notifications/${id}/unread`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        }

        function deleteNotification(id) {
            fetch(`${appUrl}/notifications/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const item = document.querySelector(`[data-notification-id="${id}"]`);
                    item.remove();
                    updateNotificationCount();
                    
                    const container = document.querySelector('.notifications-container');
                    if (container && container.children.length === 0) {
                        location.reload();
                    }
                }
            });
        }

        function markAllNotificationsAsRead() {
            fetch(`${appUrl}/notifications/mark-all-read`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        }

        function updateNotificationCount() {
            fetch(`${appUrl}/notifications/unread-count`)
                .then(response => response.json())
                .then(data => {
                    // This creates a custom event that app.js can listen to, or we can just let the polling handle it
                    // For now, removing the element from the DOM is enough visual feedback until reload
                });
        }
    });
</script>
@endsection
