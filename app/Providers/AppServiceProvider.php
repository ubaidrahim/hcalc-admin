<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Pagination\Paginator;
use App\Traits\ContentTrait;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
        
        Blade::directive('getHomeContent', function ($key) {
        return "<?php echo (new class {
            use \\App\\Traits\\ContentTrait;
            })->getHomeContent($key); ?>";
        });
        Blade::directive('getFooterContent', function ($key) {
        return "<?php echo (new class {
            use \\App\\Traits\\ContentTrait;
            })->getFooterContent($key); ?>";
        });
    }
}
