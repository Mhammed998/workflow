<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class PageController extends Controller
{
    // full page cache
    // public function index()
    // {
    //     return Cache::remember('page:index:all', 120, function () {
    //         return $this->buildIndex();
    //     });
    // }

    // public function buildIndex()
    // {
    //     $excludedIds = [];

    //     // Breaking News
    //     $breakingArticles = Article::with('category')->where('is_breaking', true)
    //         ->latest()
    //         ->take(5)
    //         ->get();

    //     $excludedIds = array_merge($excludedIds, $breakingArticles->pluck('id')->all());

    //     // Show on Hero Articles
    //     $ShowOnHeroArticles = Article::with('category')->where('show_on_hero', true)
    //         ->whereNotIn('id', $excludedIds)
    //         ->latest()
    //         ->take(7)
    //         ->get();

    //     $excludedIds = array_merge($excludedIds, $ShowOnHeroArticles->pluck('id')->all());

    //     // Featured Articles
    //     $featuredArticles = Article::with('category')->where('is_featured', true)
    //         ->whereNotIn('id', $excludedIds)
    //         ->latest()
    //         ->take(4)
    //         ->get();

    //     $excludedIds = array_merge($excludedIds, $featuredArticles->pluck('id')->all());

    //     // Featured Articles
    //     $trendingArticles = Article::with('category')->whereNotIn('id', $excludedIds)
    //         ->latest('views')
    //         ->take(5)
    //         ->get();

    //     $excludedIds = array_merge($excludedIds, $trendingArticles->pluck('id')->all());

    //     // Latest Articles
    //     $latestArticles = Article::with('category')->whereNotIn('id', $excludedIds)
    //         ->latest()
    //         ->take(12)
    //         ->get();

    //     // Settings
    //     $settings = Setting::first();

    //     return view('index', get_defined_vars())->render();
    // }





    // Flexible Caching
    public function index()
    {
        $excludedIds = [];

        // Breaking News
        // $breakingArticles = Article::with('category')->where('is_breaking', true)
        //     ->latest()
        //     ->take(5)
        //     ->get();
        $breakingArticles = Cache::remember('articles:breaking', 120, function () {
            return Article::with('category')->where('is_breaking', true)
            ->latest()
            ->take(5)
            ->get();
        });

        $excludedIds = array_merge($excludedIds, $breakingArticles->pluck('id')->all());

        // Show on Hero Articles
        // $ShowOnHeroArticles = Article::with('category')->where('show_on_hero', true)
        //     ->whereNotIn('id', $excludedIds)
        //     ->latest()
        //     ->take(7)
        //     ->get();
        $ShowOnHeroArticles = Cache::remember('articles:ShowOnHero', 300, function () use ($excludedIds) {
            return Article::with('category')->where('show_on_hero', true)
            ->whereNotIn('id', $excludedIds)
            ->latest()
            ->take(7)
            ->get();
        });

        $excludedIds = array_merge($excludedIds, $ShowOnHeroArticles->pluck('id')->all());

        // Featured Articles
        // $featuredArticles = Article::with('category')->where('is_featured', true)
        //     ->whereNotIn('id', $excludedIds)
        //     ->latest()
        //     ->take(4)
        //     ->get();
        $featuredArticles = Cache::remember('articles:featured', 300, function () use ($excludedIds) {
            return Article::with('category')->where('is_featured', true)
            ->whereNotIn('id', $excludedIds)
            ->latest()
            ->take(4)
            ->get();
        });

        $excludedIds = array_merge($excludedIds, $featuredArticles->pluck('id')->all());

        // Trending Articles
        // $trendingArticles = Article::with('category')->whereNotIn('id', $excludedIds)
        //     ->latest('views')
        //     ->take(5)
        //     ->get();
        $trendingArticles = Cache::remember('articles:trending', 300, function () use ($excludedIds) {
            return Article::with('category')->whereNotIn('id', $excludedIds)
            ->latest('views')
            ->take(5)
            ->get();
        });

        $excludedIds = array_merge($excludedIds, $trendingArticles->pluck('id')->all());

        // Latest Articles
        // $latestArticles = Article::with('category')->whereNotIn('id', $excludedIds)
        //     ->latest()
        //     ->take(12)
        //     ->get();
        $latestArticles = Cache::remember('articles:latest', 300, function () use ($excludedIds) {
            return Article::with('category')->whereNotIn('id', $excludedIds)
            ->latest()
            ->take(12)
            ->get();
        });


        // Settings
        // $settings = Setting::first();
        $settings = Cache::memo()->rememberForever('settings', function () {
            return Setting::first();
        });

        return view('index', get_defined_vars());
    }

//
//
//
//     public function index()
//     {
//         $excludedIds = [];
//
//         // Breaking News
//         $breakingArticles = Article::with('category')->where('is_breaking', true)
//             ->latest()
//             ->take(5)
//             ->get();
//
//         $excludedIds = array_merge($excludedIds, $breakingArticles->pluck('id')->all());
//
//         // Show on Hero Articles
//         $ShowOnHeroArticles = Article::with('category')->where('show_on_hero', true)
//             ->whereNotIn('id', $excludedIds)
//             ->latest()
//             ->take(7)
//             ->get();
//
//         $excludedIds = array_merge($excludedIds, $ShowOnHeroArticles->pluck('id')->all());
//
//         // Featured Articles
//         $featuredArticles = Article::with('category')->where('is_featured', true)
//             ->whereNotIn('id', $excludedIds)
//             ->latest()
//             ->take(4)
//             ->get();
//
//         $excludedIds = array_merge($excludedIds, $featuredArticles->pluck('id')->all());
//
//         // Featured Articles
//         $trendingArticles = Article::with('category')->whereNotIn('id', $excludedIds)
//             ->latest('views')
//             ->take(5)
//             ->get();
//
//         $excludedIds = array_merge($excludedIds, $trendingArticles->pluck('id')->all());
//
//         // Latest Articles
//         $latestArticles = Article::with('category')->whereNotIn('id', $excludedIds)
//             ->latest()
//             ->take(12)
//             ->get();
//
//         // Settings
//         $settings = Setting::first();
//
//         return view('index', get_defined_vars());
//     }


    // public function show(Article $article)
    // {
    //     $lock = Cache::lock("articles:{$article->id}:lock", 10);

    //     // if ($lock->get()) {
    //     //     $views = $article->views;

    //     //     $article->update(['views' => $views + 1]);

    //     //     $lock->release();
    //     // }

    //     try {
    //         $lock->block(5);

    //         $views = $article->views;

    //         $article->update(['views' => $views + 1]);
    //     } catch (LockTimeoutException $e) {
    //         // Unable to acquire lock...
    //     } finally {
    //         $lock->release();
    //     }

    //     return "You are looking at article: " . $article->title;
    // }

    public function show(Article $article)
    {
        // $views = $article->views;

        // $article->update(['views' => $views + 1]);

        // Redis::select(2);
        // Redis::incr("article:{$article->id}:views");

        Redis::connection('views')->incr("article:{$article->id}:views");

        return "You are looking at article: " . $article->title;
    }
}
