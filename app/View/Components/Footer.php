<?php

namespace App\View\Components;

use App\Models\Category;
use App\Models\Setting;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class Footer extends Component
{
    public $settings;
    public $categories;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        // $this->settings = Setting::first();
        $this->settings = Cache::memo()->rememberForever('settings', function () {
            return Setting::first();
        }); 
        $this->categories = Category::take(10)->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.footer', get_defined_vars());
    }
}
