<?php

namespace Spatie\BackupTool;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Spatie\BackupTool\Http\Middleware\Authorize;

class BackupToolServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/spatie/nova-backup-tool'),
        ]);

        Nova::translations(
            resource_path('lang/vendor/spatie/nova-backup-tool/'.app()->getLocale().'.json')
        );

        $this->loadJSONTranslationsFrom(__DIR__.'/../resources/lang');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'BackupTool');

        $this->app->booted(function () {
            $this->routes();
        });
    }

    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::middleware(['nova', Authorize::class])
            ->prefix('/nova-vendor/spatie/backup-tool')
            ->group(
                __DIR__.'/../routes/api.php'
            );
    }
}
