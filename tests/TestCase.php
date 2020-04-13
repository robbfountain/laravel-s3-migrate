<?php

namespace OneThirtyOne\S3Migration\Tests;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use OneThirtyOne\S3Migration\ServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('filesystems.disks.local.root', __DIR__ . '/Fakes');
    }
}
