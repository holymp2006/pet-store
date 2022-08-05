<?php

namespace App\Providers;

use App\Http\Resources\OrderResource;
use App\Http\Resources\ProductResource;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();
        $this->addBindings();

        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->namespace('App\\Http\\Controllers\\Api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?? $request->ip());
        });
    }
    protected function addBindings(): void
    {
        $this->app->bind(ProductResource::class, function () {
            return new ProductResource(JsonResource::class);
        });
        $this->app->bind(OrderResource::class, function () {
            return new OrderResource(JsonResource::class);
        });
    }
}
