<?php

namespace App\View\Components;

use App\Models\Setting;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class Topbar extends Component
{
    public $settings;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        // $this->settings = Setting::first();
        $this->settings = Cache::memo()->rememberForever('settings', function () {
            return Setting::first();
        }); 
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.topbar', ['settings' => $this->settings]);
    }
}
