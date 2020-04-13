<?php

namespace OneThirtyOne\S3Migration;

use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{
    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([

            ]);
        }

        $this->mergeConfigFrom(
            __DIR__ . '/s3-migrate.php', 's3-migrate'
        );

        $this->app->bind('file-collector', function ($app) {
            return new FileCollector(
                new FilesystemManager($app)
            );
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/s3-migrate.php.php' => config_path('s3-migrate.php'),
        ]);
    }
}
