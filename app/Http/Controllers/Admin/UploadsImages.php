<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

trait UploadsImages
{
    /** Saves an uploaded image to public/uploads/{folder} and returns its public path. */
    protected function storeImage(UploadedFile $file, string $folder): string
    {
        $dir = 'uploads/'.$folder;
        if (! is_dir(public_path($dir))) {
            mkdir(public_path($dir), 0755, true);
        }

        $base = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) ?: 'image';
        $name = Str::limit($base, 60, '').'-'.Str::lower(Str::random(6)).'.'.strtolower($file->getClientOriginalExtension());
        $file->move(public_path($dir), $name);

        return $dir.'/'.$name;
    }

    /** Deletes a file only if it was uploaded through the admin (never the original site assets). */
    protected function deleteImage(?string $path): void
    {
        if ($path && Str::startsWith($path, 'uploads/') && is_file(public_path($path))) {
            @unlink(public_path($path));
        }
    }
}
