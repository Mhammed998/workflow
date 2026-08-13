<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'index']);

Route::get('articles/{article}', [PageController::class, 'show'])->name('show-article');

Route::get('/cache/stats', function () {
    $hits = Cache::get('page:index:hits', 0);
    $misses = Cache::get('page:index:misses', 0);

    $total = $hits + $misses;

    $hitsRatio = ($hits / $total) * 100;
    $missesRatio = ($misses / $total) * 100;

    echo "Hits Ratio : " . $hitsRatio . "%<br>";
    echo "Misses Ratio : " . $missesRatio . "%<br>";
});

Route::get('/locks', function () {
    $lock = Cache::lock('lock', 10);
    $lock->get();
    $lock->release();
});

Route::get('/redis', function () {
    $result = Redis::get('new_age');
    dd($result);
});