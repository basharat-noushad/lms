<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class FileUploadService
{
    /**
     * Upload an image with optional resizing
     */
    public function uploadImage(UploadedFile $file, string $directory = 'images', ?int $width = null, ?int $height = null): string
    {
        $filename = $this->generateFilename($file);
        $path = $directory . '/' . $filename;

        // Store original file
        $file->storeAs($directory, $filename, 'public');

        // If resizing is needed and Intervention Image is available, resize
        if ($width || $height) {
            try {
                $fullPath = storage_path('app/public/' . $path);
                $image = Image::make($fullPath);
                
                if ($width && $height) {
                    $image->fit($width, $height);
                } elseif ($width) {
                    $image->resize($width, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                } else {
                    $image->resize(null, $height, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }
                
                $image->save($fullPath);
            } catch (\Exception $e) {
                // If Image intervention fails, just use original
            }
        }

        return $path;
    }

    /**
     * Upload a document file
     */
    public function uploadDocument(UploadedFile $file, string $directory = 'documents'): string
    {
        $filename = $this->generateFilename($file);
        $path = $file->storeAs($directory, $filename, 'public');
        
        return $path;
    }

    /**
     * Upload a video file (or return URL if it's a link)
     */
    public function uploadVideo(UploadedFile $file, string $directory = 'videos'): string
    {
        $filename = $this->generateFilename($file);
        $path = $file->storeAs($directory, $filename, 'public');
        
        return $path;
    }

    /**
     * Delete a file from storage
     */
    public function deleteFile(?string $path): bool
    {
        if (!$path) {
            return false;
        }

        return Storage::disk('public')->delete($path);
    }

    /**
     * Generate unique filename
     */
    private function generateFilename(UploadedFile $file): string
    {
        $extension = $file->getClientOriginalExtension();
        return Str::random(40) . '.' . $extension;
    }

    /**
     * Get file URL
     */
    public function getFileUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        return Storage::disk('public')->url($path);
    }

    /**
     * Validate image file
     */
    public function validateImage(UploadedFile $file, int $maxSize = 2048): bool
    {
        $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $fileSize = $file->getSize() / 1024; // Convert to KB

        return in_array($file->getMimeType(), $allowedMimes) && $fileSize <= $maxSize;
    }

    /**
     * Validate document file
     */
    public function validateDocument(UploadedFile $file, int $maxSize = 10240): bool
    {
        $allowedMimes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        $fileSize = $file->getSize() / 1024;

        return in_array($file->getMimeType(), $allowedMimes) && $fileSize <= $maxSize;
    }
}
