<?php

namespace OneThirtyOne\S3Migration;

use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use OneThirtyOne\S3Migration\Commands\MigrateCommand;

class ServiceProvider extends LaravelServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->bind('file-collector', function ($app) {
            return new FileCollector(
                new FilesystemManager($app)
            );
        });

        if ($this->app->runningInConsole()) {
            $this->commands([
                MigrateCommand::class,
            ]);
        }

        $this->mergeConfigFrom(
            __DIR__ . '/config/s3migrate.php', 's3migrate'
        );
    }

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/s3migrate.php.php' => config_path('s3migrate.php'),
        ]);
    }
}
