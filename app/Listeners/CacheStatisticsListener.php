<?php

namespace App\Listeners;

use Illuminate\Cache\Events\CacheHit;
use Illuminate\Cache\Events\CacheMissed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CacheStatisticsListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        if ($event instanceof CacheHit) {
            // Cache hit
            Cache::increment('page:index:hits');
        }  
        if ($event instanceof CacheMissed) {
            // Cache missed
            Cache::increment('page:index:misses');
            Log::info('Cache missed key : ' . $event->key);
        }
    }
}
