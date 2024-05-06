<?php

namespace Stepanenko3\NovaHealth;

use Illuminate\Http\Request;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\Tool;

class NovaHealth extends Tool
{
    public function boot(): void
    {
        Nova::script('nova-health', __DIR__ . '/../dist/js/tool.js');
    }

    public function menu(Request $request)
    {
        return MenuSection::make(__(config('nova-health.navigation_label', 'Health')))
            ->path('/health')
            ->icon('heart');
    }
}
