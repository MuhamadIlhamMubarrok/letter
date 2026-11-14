<?php

declare(strict_types=1);

namespace App\Domains\DigitalStory\Actions;

use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use DomainException;
use Illuminate\Support\Facades\Storage;
use Throwable;

class GenerateStoryQrCodeAction
{
    /**
     * Generate SVG QR code for the given target URL and store it in public disk.
     *
     * @param string $targetUrl The public story URL to encode
     * @param string $slug The unique identifier used for the filename
     * @return string Relative storage path (e.g. 'stories/qr/slug.svg')
     *
     * @throws DomainException
     */
    public function execute(string $targetUrl, string $slug): string
    {
        $this->ensureAutoloaded();

        try {
            $renderer = new ImageRenderer(
                new RendererStyle(360, 2),
                new SvgImageBackEnd()
            );

            $writer = new Writer($renderer);
            $svgContent = $writer->writeString($targetUrl);

            // Clean up SVG header if needed and ensure standard SVG attributes
            if (! str_contains($svgContent, '<svg')) {
                throw new DomainException('Gagal menghasilkan format SVG untuk QR Code.');
            }

            $relativePath = "stories/qr/{$slug}.svg";
            Storage::disk('public')->put($relativePath, $svgContent);

            return $relativePath;
        } catch (Throwable $e) {
            throw new DomainException("Gagal meng-generate QR Code untuk cerita [{$slug}]: {$e->getMessage()}", 0, $e);
        }
    }

    /**
     * Defensive autoloader for BaconQrCode if not in composer classmap.
     */
    private function ensureAutoloaded(): void
    {
        if (class_exists(Writer::class)) {
            return;
        }

        spl_autoload_register(function (string $class): void {
            if (str_starts_with($class, 'BaconQrCode\\')) {
                $file = base_path('vendor/bacon/bacon-qr-code/src/' . str_replace('\\', '/', substr($class, 12)) . '.php');
                if (file_exists($file)) {
                    require_once $file;
                }
            } elseif (str_starts_with($class, 'DASPRiD\\Enum\\')) {
                $file = base_path('vendor/dasprid/enum/src/' . str_replace('\\', '/', substr($class, 13)) . '.php');
                if (file_exists($file)) {
                    require_once $file;
                }
            }
        });
    }
}
