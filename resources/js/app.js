import './bootstrap';
// bootstrap and datatables removed

import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';

Alpine.plugin(collapse);

window.Alpine = Alpine;

Alpine.store('confirm', {
    open: false,
    action: '',
    method: 'POST',
    title: 'Confirm Action',
    message: 'Are you sure you want to proceed?',
    btnClass: 'bg-navy hover:bg-navy-light',
    btnText: 'Confirm',

    show(options) {
        this.action = options.action || '';
        this.method = options.method || 'POST';
        this.title = options.title || 'Confirm Action';
        this.message = options.message || 'Are you sure you want to proceed?';
        this.btnClass = options.btnClass || 'btn-navy';
        this.btnText = options.btnText || 'Confirm';
        this.open = true;
    },

    close() {
        this.open = false;
    }
});

Alpine.data('notifications', () => ({
    count: 0,
    unread: [],
    open: false,

    init() {
        this.appUrl = document.querySelector('meta[name="app-url"]').getAttribute('content');
        this.fetchCount();
        setInterval(() => this.fetchCount(), 30000);
    },

    fetchCount() {
        fetch(`${this.appUrl}/notifications/unread-count`)
            .then(res => {
                if (!res.ok) throw new Error(res.status);
                return res.json();
            })
            .then(data => {
                this.count = data.count;
            })
            .catch(() => { });
    },

    fetchList() {
        this.open = !this.open;
        if (this.open) {
            fetch(`${this.appUrl}/notifications`)
                .then(res => {
                    if (!res.ok) throw new Error(res.status);
                    return res.json();
                })
                .then(data => {
                    this.unread = data;
                })
                .catch(() => { });
        }
    },

    markRead(id, link) {
        fetch(`${this.appUrl}/notifications/${id}/read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        }).then(res => {
            if (!res.ok) throw new Error(res.status);
            if (link) window.location.href = link;
            else {
                this.fetchCount();
                this.fetchList();
            }
        }).catch(() => { });
    }
}));

Alpine.store('toast', {
    items: [],
    _counter: 0,

    show({ type = 'success', message = '', duration = 5000 }) {
        const id = ++this._counter;
        this.items.push({ id, type, message, visible: true });
        if (duration > 0) {
            setTimeout(() => this.dismiss(id), duration);
        }
    },

    dismiss(id) {
        const item = this.items.find(i => i.id === id);
        if (item) item.visible = false;
        setTimeout(() => {
            this.items = this.items.filter(i => i.id !== id);
        }, 400);
    }
});

Alpine.start();

// Bridge: Bootstrap-style data-bs-toggle="modal" buttons → Alpine $store.confirm
document.addEventListener('click', function (e) {
    var btn = e.target.closest('[data-bs-toggle="modal"][data-bs-target="#confirmationModal"]');
    if (!btn) return;
    e.preventDefault();

    // Map legacy Bootstrap class names to Tailwind equivalents
    var classMap = {
        'btn-danger': 'bg-red-600 hover:bg-red-700',
        'btn-success': 'bg-emerald-600 hover:bg-emerald-700',
        'btn-navy': 'bg-navy hover:bg-navy-light'
    };
    var rawClass = btn.getAttribute('data-btn-class') || 'btn-navy';
    var twClass = classMap[rawClass] || rawClass;

    Alpine.store('confirm').show({
        action: btn.getAttribute('data-action') || '',
        method: btn.getAttribute('data-method') || 'POST',
        title: btn.getAttribute('data-title') || 'Confirm Action',
        message: btn.getAttribute('data-message') || 'Are you sure you want to proceed?',
        btnClass: twClass,
        btnText: btn.getAttribute('data-btn-text') || 'Confirm'
    });
});
