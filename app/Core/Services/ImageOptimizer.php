<?php

declare(strict_types=1);

namespace App\Core\Services;

use GdImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use InvalidArgumentException;
use RuntimeException;

class ImageOptimizer
{
    /**
     * Target maximum size in kilobytes (strict user constraint: < 100 KB).
     */
    public const DEFAULT_MAX_KB = 100;

    /**
     * Maximum width or height for mobile/retina performance (1440px is ideal for mobile & web cards).
     */
    public const DEFAULT_MAX_DIMENSION = 1440;

    /**
     * Convert an uploaded file or existing image path to WebP and ensure file size is strictly under $maxKb.
     *
     * @param UploadedFile|string $file Uploaded file instance or absolute file path
     * @param string $directory Target directory on public storage disk (e.g. 'stories/media', 'products')
     * @param string|null $customFilename Optional custom filename (will always end in .webp)
     * @param int $maxKb Maximum size in kilobytes (default 100 KB)
     * @param string $disk Storage disk to save into (default 'public')
     * @return string Relative storage path of the stored WebP file (e.g. 'stories/media/uuid.webp')
     *
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function optimizeAndStore(
        UploadedFile|string $file,
        string $directory = 'uploads',
        ?string $customFilename = null,
        int $maxKb = self::DEFAULT_MAX_KB,
        string $disk = 'public'
    ): string {
        $realPath = $file instanceof UploadedFile ? $file->getRealPath() : $file;

        if (! is_string($realPath) || ! file_exists($realPath)) {
            throw new InvalidArgumentException("Berkas gambar tidak ditemukan di path: [{$realPath}].");
        }

        $rawContents = file_get_contents($realPath);
        if ($rawContents === false || $rawContents === '') {
            throw new RuntimeException("Gagal membaca konten berkas gambar: [{$realPath}].");
        }

        // 1. Decode image using GD (handles JPEG, PNG, WebP, GIF, BMP)
        $sourceImage = @imagecreatefromstring($rawContents);
        if (! $sourceImage instanceof GdImage) {
            throw new RuntimeException("Format berkas gambar tidak didukung atau berkas rusak.");
        }

        // 2. Fix EXIF orientation (prevent photos taken from smartphones from rotating)
        $sourceImage = $this->correctExifOrientation($sourceImage, $realPath);

        // 3. Proportional resize if image exceeds maximum dimension
        $sourceImage = $this->resizeIfLargerThan($sourceImage, self::DEFAULT_MAX_DIMENSION);

        // 4. Iteratively compress into WebP until size is strictly under $maxKb (e.g. < 100 KB)
        $maxBytes = $maxKb * 1024;
        $webpData = $this->compressUnderLimit($sourceImage, $maxBytes);

        // Free GD memory
        imagedestroy($sourceImage);

        // 5. Build final filename with .webp extension
        if ($customFilename !== null && trim($customFilename) !== '') {
            $baseName = pathinfo($customFilename, PATHINFO_FILENAME);
            $finalFilename = Str::slug($baseName) . '_' . Str::random(6) . '.webp';
        } else {
            $finalFilename = Str::uuid()->toString() . '.webp';
        }

        $cleanDir = trim($directory, '/\\');
        $targetPath = $cleanDir !== '' ? "{$cleanDir}/{$finalFilename}" : $finalFilename;

        // 6. Store to disk
        Storage::disk($disk)->put($targetPath, $webpData);

        return $targetPath;
    }

    /**
     * Auto-correct orientation from camera EXIF metadata.
     */
    private function correctExifOrientation(GdImage $image, string $realPath): GdImage
    {
        if (! function_exists('exif_read_data')) {
            return $image;
        }

        $exif = @exif_read_data($realPath);
        if (empty($exif['Orientation'])) {
            return $image;
        }

        $orientation = (int) $exif['Orientation'];
        $rotated = match ($orientation) {
            3 => imagerotate($image, 180, 0),
            6 => imagerotate($image, -90, 0),
            8 => imagerotate($image, 90, 0),
            default => null,
        };

        if ($rotated instanceof GdImage) {
            imagedestroy($image);
            return $rotated;
        }

        return $image;
    }

    /**
     * Resize image proportionally if its width or height exceeds $maxDimension.
     */
    private function resizeIfLargerThan(GdImage $image, int $maxDimension): GdImage
    {
        $width = imagesx($image);
        $height = imagesy($image);

        if ($width <= $maxDimension && $height <= $maxDimension) {
            return $image;
        }

        if ($width >= $height) {
            $newWidth = $maxDimension;
            $newHeight = (int) round(($height * $maxDimension) / $width);
        } else {
            $newHeight = $maxDimension;
            $newWidth = (int) round(($width * $maxDimension) / $height);
        }

        $canvas = imagecreatetruecolor($newWidth, $newHeight);
        $this->preserveTransparency($canvas);

        imagecopyresampled($canvas, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        imagedestroy($image);

        return $canvas;
    }

    /**
     * Compress the image to WebP with adaptive quality stepping and dimension scaling
     * to strictly guarantee that file size is below $maxBytes (< 100 KB).
     */
    private function compressUnderLimit(GdImage $image, int $maxBytes): string
    {
        // Strict upper limit: ensure file is strictly below 100 KB (<= 101,888 bytes)
        $strictLimit = min($maxBytes, (100 * 1024) - 512);

        $qualityLevels = [85, 78, 70, 62, 54, 46, 38, 30];

        $currentImage = $image;
        $isCanvasAllocated = false;

        // 1. Try stepped quality reduction on current dimensions
        foreach ($qualityLevels as $quality) {
            $data = $this->renderWebpBytes($currentImage, $quality);
            if (strlen($data) <= $strictLimit) {
                if ($isCanvasAllocated) {
                    imagedestroy($currentImage);
                }
                return $data;
            }
        }

        // 2. Iteratively downscale dimensions and test qualities until it strictly fits under limit
        $downscaleQualities = [72, 60, 48, 36, 25];
        while (true) {
            $curW = imagesx($currentImage);
            $curH = imagesy($currentImage);

            $scaleW = (int) round($curW * 0.80);
            $scaleH = (int) round($curH * 0.80);

            // Minimum boundary to prevent infinite loop or 0-pixel images
            if ($scaleW < 60 || $scaleH < 60) {
                break;
            }

            $scaledCanvas = imagecreatetruecolor($scaleW, $scaleH);
            $this->preserveTransparency($scaledCanvas);
            imagecopyresampled($scaledCanvas, $currentImage, 0, 0, 0, 0, $scaleW, $scaleH, $curW, $curH);

            if ($isCanvasAllocated) {
                imagedestroy($currentImage);
            }

            $currentImage = $scaledCanvas;
            $isCanvasAllocated = true;

            foreach ($downscaleQualities as $quality) {
                $data = $this->renderWebpBytes($currentImage, $quality);
                if (strlen($data) <= $strictLimit) {
                    imagedestroy($currentImage);
                    return $data;
                }
            }
        }

        // 3. Fallback: lowest possible quality on final scaled image
        $fallbackData = $this->renderWebpBytes($currentImage, 15);
        if ($isCanvasAllocated) {
            imagedestroy($currentImage);
        }

        return $fallbackData;
    }

    /**
     * Render GD image to raw WebP byte string.
     */
    private function renderWebpBytes(GdImage $image, int $quality): string
    {
        ob_start();
        imagewebp($image, null, $quality);
        $output = ob_get_clean();

        return is_string($output) ? $output : '';
    }

    /**
     * Preserve alpha transparency channel for PNG/WebP alpha layers.
     */
    private function preserveTransparency(GdImage $canvas): void
    {
        imagealphablending($canvas, false);
        imagesavealpha($canvas, true);
        $transparent = imagecolorallocatealpha($canvas, 0, 0, 0, 127);
        imagefill($canvas, 0, 0, $transparent);
    }
}
