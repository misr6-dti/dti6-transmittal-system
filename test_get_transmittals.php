<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Get transmittals
$transmittals = \App\Models\Transmittal::select('id', 'reference_number', 'status', 'qr_token')->limit(5)->get();

echo "=== TRANSMITTALS FOR TESTING ===\n\n";
foreach ($transmittals as $t) {
    echo "ID: " . $t->id . "\n";
    echo "Reference: " . $t->reference_number . "\n";
    echo "Status: " . $t->status . "\n";
    echo "QR Token: " . $t->qr_token . "\n";
    echo "Public URL: http://localhost/dts/track/" . $t->qr_token . "\n";
    echo "---\n\n";
}

if ($transmittals->isEmpty()) {
    echo "No transmittals found. Please create test data first.\n";
}
