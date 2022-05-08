<?php

namespace Stepanenko3\NovaHealth;

use Laravel\Nova\Nova;
use Laravel\Nova\Tool;
use Illuminate\Http\Request;
use Laravel\Nova\Menu\MenuSection;

class HealthTool extends Tool
{
    public function boot()
    {
        Nova::script('nova-health', __DIR__ . '/../dist/js/entry.js');
    }

    public function menu(Request $request)
    {
        return MenuSection::make(__(config('nova-health.navigation_label', 'Health')))
            ->path('/health');
    }
}
