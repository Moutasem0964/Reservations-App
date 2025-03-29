<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class StorageHelper
{
    public static function storeFile(?UploadedFile $file, string $folder): ?string
    {
        if (!$file?->isValid()) {
            return null;
        }

        return Storage::disk('public')->putFile(
            $folder,
            $file
        );
    }
}