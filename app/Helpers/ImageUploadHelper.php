<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Helpers\ImageHelper;
use Illuminate\Support\Facades\Log;

class ImageUploadHelper
{
    public static function upload($file, $folder)
    {
        $ext = $file->getClientOriginalExtension();
        $tempName = Str::uuid() . '.' . $ext;

        try {
            $file->storeAs('temp', $tempName);
        } catch (\Throwable $e) {

        }

        $storageTempPath = storage_path("app/temp/{$tempName}");
        $publicTempPath = public_path("temp/{$tempName}");

        if (!file_exists($storageTempPath)) {
            $real = $file->getRealPath();
            if ($real && file_exists($real)) {

                if (!file_exists(dirname($storageTempPath))) {
                    mkdir(dirname($storageTempPath), 0777, true);
                }
                copy($real, $storageTempPath);
            } else {

                try {
                    $stream = fopen($file->getStream()->getMetadata('uri'), 'r');
                } catch (\Throwable $e) {
                    $stream = null;
                }
                if ($stream) {
                    if (!file_exists(dirname($storageTempPath))) {
                        mkdir(dirname($storageTempPath), 0777, true);
                    }
                    file_put_contents($storageTempPath, stream_get_contents($stream));
                    if (is_resource($stream))
                        fclose($stream);
                }
            }
        }

        if (!file_exists(dirname($publicTempPath))) {
            mkdir(dirname($publicTempPath), 0755, true);
        }

        if (file_exists($storageTempPath)) {

            copy($storageTempPath, $publicTempPath);
        } elseif ($file->getRealPath() && file_exists($file->getRealPath())) {

            copy($file->getRealPath(), $publicTempPath);
        } else {

            Log::error("ImageUploadHelper: temp file missing for upload", ['tempName' => $tempName]);
            throw new \Exception("Temporary upload file not available.");
        }

        $publicAvifPath = ImageHelper::convertToAvif("temp/{$tempName}", $folder);

        $localAvifFullPath = public_path($publicAvifPath);
        if (!file_exists($localAvifFullPath)) {
            Log::error("ImageUploadHelper: avif file missing after convert", ['avif' => $localAvifFullPath]);
            throw new \Exception("Conversion to AVIF failed or produced no file.");
        }

        $s3Key = $publicAvifPath;
        Storage::disk('s3')->put($s3Key, file_get_contents($localAvifFullPath), 'public');

        @unlink($localAvifFullPath);
        @unlink($publicTempPath);
        @unlink($storageTempPath);

        return Storage::disk('s3')->url($s3Key);
    }

    public static function delete($fullUrl)
    {
        if (!is_string($fullUrl) || trim($fullUrl) === '') {
            return;
        }

        $disk = Storage::disk('s3');

        $bucket = config('filesystems.disks.s3.bucket');
        $region = config('filesystems.disks.s3.region');
        $baseUrl = "https://{$bucket}.s3.{$region}.amazonaws.com";


        if (str_starts_with($fullUrl, $baseUrl)) {

            $relative = str_replace($baseUrl . '/', '', $fullUrl);

            if (!is_string($relative) || trim($relative) === '') {
                return;
            }

            try {
                $disk->delete($relative);
            } catch (\Throwable $e) {
                \Log::warning("S3 delete failed: " . $e->getMessage());
            }

            return;
        }

        if (str_starts_with($fullUrl, 'uploads/') || str_starts_with($fullUrl, '/uploads/')) {

            $localPath = public_path(ltrim($fullUrl, '/'));
            if (file_exists($localPath)) {
                @unlink($localPath);
            }

            return;
        }

        return;
    }


}
