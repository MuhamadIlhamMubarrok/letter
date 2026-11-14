<?php

namespace App\Providers;

use App\Admin\Product\Repository\ProductRepository;
use App\Admin\Product\Repository\ProductRepositoryInterface;
use App\Admin\Product\Service\ProductService;
use App\Admin\Product\Service\ProductServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(\App\Core\Services\ImageOptimizer::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(ProductServiceInterface::class, ProductService::class);

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
        \Illuminate\Support\Facades\View::composer([
            'components.client.navbar',
            'client.catalog.index',
            'client.home.index',
            'components.layouts.client',
            'errors.404'
        ], function ($view) {
            try {
                if (\Illuminate\Support\Facades\Schema::hasTable('categories')) {
                    $categories = \App\Models\Category::withCount('products')->get();
                    $view->with('navbarCategories', $categories);
                }
            } catch (\Throwable $e) {
                // Ignore DB connection errors during early bootstrap
            }
        });
    }
}
