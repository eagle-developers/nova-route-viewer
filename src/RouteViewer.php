<?php

namespace EagleDevelopers\NovaRouteViewer;

use Laravel\Nova\Nova;
use Laravel\Nova\Tool;

class RouteViewer extends Tool
{
    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot()
    {
        Nova::script('route-viewer', __DIR__.'/../dist/js/tool.js');
    }

    /**
     * Build the view that renders the navigation links for the tool.
     *
     * @return \Illuminate\View\View
     */
    public function renderNavigation()
    {
        return view('route-viewer::navigation');
    }
}
