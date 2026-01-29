<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Get users
$users = \App\Models\User::select('id', 'name', 'email', 'office_id')->limit(5)->get();

echo "=== TEST USERS ===\n\n";
foreach ($users as $u) {
    echo "ID: " . $u->id . "\n";
    echo "Name: " . $u->name . "\n";
    echo "Email: " . $u->email . "\n";
    echo "Office ID: " . $u->office_id . "\n";
    echo "---\n\n";
}

// Get notifications
echo "=== NOTIFICATIONS ===\n\n";
$notifications = \App\Models\Notification::select('id', 'user_id', 'office_id', 'title', 'read_at', 'created_at')->limit(10)->get();
foreach ($notifications as $n) {
    echo "ID: " . $n->id . "\n";
    echo "Title: " . $n->title . "\n";
    echo "User ID: " . $n->user_id . "\n";
    echo "Office ID: " . $n->office_id . "\n";
    echo "Read: " . ($n->read_at ? "Yes" : "No") . "\n";
    echo "Created: " . $n->created_at . "\n";
    echo "---\n\n";
}

if ($notifications->isEmpty()) {
    echo "No notifications found.\n";
}
