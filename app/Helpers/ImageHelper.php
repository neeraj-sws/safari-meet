<?php

namespace App\Helpers;

class ImageHelper
{
    public static function convertToAvif(string $sourcePath, string $targetFolder = 'uploads', int $quality = 60): string
    {
        $sourceFull = public_path($sourcePath);

        if (!file_exists($sourceFull)) {
            throw new \Exception("File not found: $sourceFull");
        }

        $mime = mime_content_type($sourceFull);

        $gd = match ($mime) {
            'image/jpeg' => imagecreatefromjpeg($sourceFull),
            'image/png' => imagecreatefrompng($sourceFull),
            'image/webp' => imagecreatefromwebp($sourceFull),
            'image/gif' => imagecreatefromgif($sourceFull),
            'image/bmp', 'image/x-ms-bmp' => imagecreatefrombmp($sourceFull),
            default => throw new \Exception("Unsupported image MIME type: $mime"),
        };

        // Convert to true color
        if (!imageistruecolor($gd)) {
            imagepalettetotruecolor($gd);
        }

        // Check AVIF support
        if (!function_exists('imageavif')) {
            throw new \Exception("PHP GD library does NOT support AVIF.");
        }

        // Create target folder
        $name = pathinfo($sourcePath, PATHINFO_FILENAME);
        $avifPath = "$targetFolder/{$name}.avif";
        $avifFull = public_path($avifPath);

        if (!file_exists(dirname($avifFull))) {
            mkdir(dirname($avifFull), 0755, true);
        }

        // Save AVIF
        imageavif($gd, $avifFull, $quality);

        // Free memory
        imagedestroy($gd);

        // Delete original
        unlink($sourceFull);

        return $avifPath;
    }

}
