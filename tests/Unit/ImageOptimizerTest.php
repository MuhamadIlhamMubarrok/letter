<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Core\Services\ImageOptimizer;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImageOptimizerTest extends TestCase
{
    public function test_image_is_converted_to_webp_and_compressed_under_100kb(): void
    {
        Storage::fake('public');

        // Create a large 2000x2000 image in memory to simulate high-res camera upload
        $gd = imagecreatetruecolor(2000, 2000);
        for ($i = 0; $i < 2000; $i += 20) {
            $color = imagecolorallocate($gd, ($i % 255), (($i * 3) % 255), (($i * 7) % 255));
            imagefilledrectangle($gd, $i, 0, $i + 15, 2000, $color);
        }

        $tempPath = tempnam(sys_get_temp_dir(), 'test_img_') . '.jpg';
        imagejpeg($gd, $tempPath, 100);
        imagedestroy($gd);

        $initialSize = filesize($tempPath);
        $this->assertGreaterThan(100 * 1024, $initialSize, 'Source test image must be > 100KB to verify compression');

        $uploadedFile = new UploadedFile($tempPath, 'sample-photo.jpg', 'image/jpeg', null, true);

        $optimizer = new ImageOptimizer();
        $storedPath = $optimizer->optimizeAndStore(
            file: $uploadedFile,
            directory: 'stories/media',
            customFilename: 'custom_wedding_photo'
        );

        // 1. Path must be in target directory and end with .webp
        $this->assertStringStartsWith('stories/media/', $storedPath);
        $this->assertStringEndsWith('.webp', $storedPath);

        // 2. Storage file must exist
        Storage::disk('public')->assertExists($storedPath);

        // 3. File size must strictly be below 100 KB (< 102,400 bytes)
        $storedBytes = strlen(Storage::disk('public')->get($storedPath));
        $this->assertLessThanOrEqual(100 * 1024, $storedBytes, 'Optimized WebP image must be <= 100 KB');

        // 4. Verify it is a valid WebP image readable by GD
        $verifyGd = @imagecreatefromstring(Storage::disk('public')->get($storedPath));
        $this->assertNotFalse($verifyGd, 'Stored WebP file must be valid and readable by GD');
        imagedestroy($verifyGd);

        @unlink($tempPath);
    }

    public function test_png_with_transparency_converted_to_webp_and_under_100kb(): void
    {
        Storage::fake('public');

        $gd = imagecreatetruecolor(800, 800);
        imagealphablending($gd, false);
        imagesavealpha($gd, true);
        $transparent = imagecolorallocatealpha($gd, 0, 0, 0, 127);
        imagefill($gd, 0, 0, $transparent);

        // Draw a colored shape in the center
        $pink = imagecolorallocate($gd, 230, 80, 120);
        imagefilledellipse($gd, 400, 400, 300, 300, $pink);

        $tempPath = tempnam(sys_get_temp_dir(), 'test_png_') . '.png';
        imagepng($gd, $tempPath);
        imagedestroy($gd);

        $uploadedFile = new UploadedFile($tempPath, 'transparent-flower.png', 'image/png', null, true);

        $optimizer = new ImageOptimizer();
        $storedPath = $optimizer->optimizeAndStore(
            file: $uploadedFile,
            directory: 'products'
        );

        $this->assertStringStartsWith('products/', $storedPath);
        $this->assertStringEndsWith('.webp', $storedPath);
        Storage::disk('public')->assertExists($storedPath);

        $storedBytes = strlen(Storage::disk('public')->get($storedPath));
        $this->assertLessThanOrEqual(100 * 1024, $storedBytes, 'PNG converted WebP must be <= 100 KB');

        // Check transparency preservation
        $verifyGd = @imagecreatefromstring(Storage::disk('public')->get($storedPath));
        $this->assertNotFalse($verifyGd);
        $cornerAlpha = imagecolorsforindex($verifyGd, imagecolorat($verifyGd, 10, 10))['alpha'];
        $this->assertEquals(127, $cornerAlpha, 'Corner pixel should remain transparent in WebP');
        imagedestroy($verifyGd);

        @unlink($tempPath);
    }

    public function test_extreme_high_entropy_noise_image_is_strictly_compressed_under_100kb(): void
    {
        Storage::fake('public');

        // Create high-entropy noise image (worst case for compression)
        $gd = imagecreatetruecolor(1200, 1200);
        for ($x = 0; $x < 1200; $x += 10) {
            for ($y = 0; $y < 1200; $y += 10) {
                $color = imagecolorallocate($gd, rand(0, 255), rand(0, 255), rand(0, 255));
                imagefilledrectangle($gd, $x, $y, $x + 9, $y + 9, $color);
            }
        }

        $tempPath = tempnam(sys_get_temp_dir(), 'test_noise_') . '.jpg';
        imagejpeg($gd, $tempPath, 100);
        imagedestroy($gd);

        $uploadedFile = new UploadedFile($tempPath, 'noisy-flower.jpg', 'image/jpeg', null, true);

        $optimizer = new ImageOptimizer();
        $storedPath = $optimizer->optimizeAndStore(
            file: $uploadedFile,
            directory: 'stories/media'
        );

        $this->assertStringEndsWith('.webp', $storedPath);
        Storage::disk('public')->assertExists($storedPath);

        $storedBytes = strlen(Storage::disk('public')->get($storedPath));
        $this->assertLessThanOrEqual(100 * 1024, $storedBytes, 'Extreme noise image must strictly be <= 100 KB');

        @unlink($tempPath);
    }

    public function test_webp_image_upload_is_processed_and_under_100kb(): void
    {
        Storage::fake('public');

        $gd = imagecreatetruecolor(1000, 1000);
        $pink = imagecolorallocate($gd, 255, 105, 180);
        imagefilledrectangle($gd, 0, 0, 1000, 1000, $pink);

        $tempPath = tempnam(sys_get_temp_dir(), 'test_webp_') . '.webp';
        imagewebp($gd, $tempPath, 90);
        imagedestroy($gd);

        $uploadedFile = new UploadedFile($tempPath, 'already-webp.webp', 'image/webp', null, true);

        $optimizer = new ImageOptimizer();
        $storedPath = $optimizer->optimizeAndStore(
            file: $uploadedFile,
            directory: 'fresh-flowers'
        );

        $this->assertStringStartsWith('fresh-flowers/', $storedPath);
        $this->assertStringEndsWith('.webp', $storedPath);
        Storage::disk('public')->assertExists($storedPath);

        $storedBytes = strlen(Storage::disk('public')->get($storedPath));
        $this->assertLessThanOrEqual(100 * 1024, $storedBytes, 'Processed WebP image must be <= 100 KB');

        @unlink($tempPath);
    }
}
