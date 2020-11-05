<?php

namespace ORIATEC\InseeLocalisation\Providers;

use Illuminate\Console\Application as Artisan;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use ORIATEC\InseeLocalisation\Console\Commands\ImportInseeLocalisation;

/**
 * Service provider
 */
class ServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        //$this->loadRoutesFrom(__DIR__.'/../../routes/routes.php');
        //$this->loadViewsFrom(__DIR__.'/../views', 'packagename');
        /*$this->publishes([
            __DIR__.'/../views', resource_path('views/vendor/packagename')
        ]);*/

        $this->app->singleton('oriatec.commands.insee-import', function () {
            return new ImportInseeLocalisation();
        });

        Artisan::starting(function ($artisan) {
            $artisan->resolveCommands(['oriatec.commands.insee-import']);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
