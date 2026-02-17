<?php

namespace App\Services;

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

class QrCodeService
{
    /**
     * Generate an SVG QR Code for the given string content.
     *
     * @param string $content
     * @return string
     */
    public static function generate(string $content)
    {
        $options = new QROptions([
            'imageTransparent' => false,
            'scale' => 5,
            'outputType' => QRCode::OUTPUT_MARKUP_SVG,
            'eccLevel' => QRCode::ECC_L,
        ]);

        return (new QRCode($options))->render($content);
    }
}
