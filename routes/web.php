<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Public Tracking Route (no authentication required)
// Rate-limited to 60 requests/min per IP to prevent brute-force QR token enumeration (VAPT V-06)
Route::get('/track/{qr_token}', [App\Http\Controllers\TransmittalController::class, 'publicTrack'])->middleware('throttle:60,1')->name('transmittals.public-track');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/stats', [App\Http\Controllers\DashboardController::class, 'stats'])->name('dashboard.stats');
    
    Route::resource('transmittals', App\Http\Controllers\TransmittalController::class);
    Route::patch('transmittals/{transmittal}/receive', [App\Http\Controllers\TransmittalController::class, 'receive'])->name('transmittals.receive');
    Route::post('transmittals/{transmittal}/update-items', [App\Http\Controllers\TransmittalController::class, 'updateItems'])->name('transmittals.update-items');
    Route::get('transmittals/{transmittal}/pdf', [App\Http\Controllers\TransmittalController::class, 'downloadPdf'])->name('transmittals.pdf');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/audit-history', [\App\Http\Controllers\AuditLogController::class, 'index'])->name('audit.index');
    Route::get('/audit-history/{transmittalLog}', [\App\Http\Controllers\AuditLogController::class, 'show'])->name('audit.show');
    
    // Notification Routes
    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/unread', [\App\Http\Controllers\NotificationController::class, 'getUnread'])->name('notifications.unread');
    Route::get('/notifications/unread-count', [\App\Http\Controllers\NotificationController::class, 'unreadCount'])->name('notifications.unreadCount');
    Route::post('/notifications/{notification}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/{notification}/unread', [\App\Http\Controllers\NotificationController::class, 'markAsUnread'])->name('notifications.unread');
    Route::delete('/notifications/{notification}', [\App\Http\Controllers\NotificationController::class, 'delete'])->name('notifications.delete');
    Route::post('/notifications/mark-all-read', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.markAllRead');

    Route::view('/faqs', 'pages.faqs')->name('faqs');
    Route::get('/user-manual', function () { return view('pages.manual'); })->name('manual');
Route::get('/support', function () { return view('pages.support'); })->name('support');

    // Admin Routes
    Route::prefix('admin')->name('admin.')->middleware(['admin'])->group(function () {
        Route::resource('users', App\Http\Controllers\Admin\UserController::class);
        Route::resource('roles', App\Http\Controllers\Admin\RoleController::class);
        Route::resource('offices', App\Http\Controllers\Admin\OfficeController::class);
        Route::resource('divisions', App\Http\Controllers\Admin\DivisionController::class);
    });
});

require __DIR__.'/auth.php';
