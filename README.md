# Laravel Nova Route Viewer

This [Nova](https://nova.laravel.com/) tool adds a route viewer section to the Nova sidebar.

It's like `php artisan route:list` for your browser. Supports sorting and filtering.

![screenshot of Laravel Nova Route Viewer tool](https://sarabine.com/i//Laravel-Nova-Route-Viewer-Tool.png)

## Installation

Install via [Composer](https://getcomposer.org/):
```
composer require eagle-developers/nova-route-viewer
```

Register the tool in `app/Providers/NovaServiceProvider.php`:

```php
public function tools()
{
    return [
        // ..,
        new \EagleDevelopers\NovaRouteViewer\RouteViewer,
    ];
}
```
