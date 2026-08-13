<?php

namespace App\Providers;

use App\Listeners\CacheStatisticsListener;
use Illuminate\Cache\Events\CacheHit;
use Illuminate\Cache\Events\CacheMissed;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

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
        // Event::listen(CacheHit::class, CacheStatisticsListener::class);
        // Event::listen(CacheMissed::class, CacheStatisticsListener::class);
    }
}
