<?php
require __DIR__ . '/vendor/autoload.php';

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

$data = 'test';
$options = new QROptions([
    'outputType' => QRCode::OUTPUT_MARKUP_SVG,
]);
try {
    $out = (new QRCode($options))->render($data);
    echo "SVG Generated Length: " . strlen($out) . "\n";
    echo "First 50 chars: " . substr($out, 0, 50) . "\n";
} catch (\Throwable $e) {
    echo "SVG Gen Error: " . $e->getMessage() . "\n";
}
