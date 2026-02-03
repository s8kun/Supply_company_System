<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    /**
     * Upload an image to the specified folder.
     *
     * @param UploadedFile $file
     * @param string $folder
     * @param string $disk
     * @return string
     */
    public function upload(UploadedFile $file, string $folder, string $disk = 'public'): string
    {
        return $file->store($folder, $disk);
    }

    /**
     * Delete an image from storage.
     *
     * @param string|null $path
     * @param string $disk
     * @return void
     */
    public function delete(?string $path, string $disk = 'public'): void
    {
        if ($path && Storage::disk($disk)->exists($path)) {
            Storage::disk($disk)->delete($path);
        }
    }
}
