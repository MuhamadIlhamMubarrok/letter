<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(\App\Core\Services\ImageOptimizer::class);

        // Register BaconQrCode & DASPRiD Enum autoloader if not present in composer classmap
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

        require_once app_path('helpers.php');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Dedicated CMS for Undangan & Surat (Digital Stories)
    }
}
