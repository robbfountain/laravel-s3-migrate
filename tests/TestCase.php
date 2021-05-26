<?php

namespace OneThirtyOne\S3Migration\Tests;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use OneThirtyOne\S3Migration\ServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

/**
 * Class TestCase.
 */
class TestCase extends Orchestra
{
    /**
     * Setup.
     */
    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('s3migrate.local_paths', [
            __DIR__ . '/Fakes'
        ]);
        $app['config']->set('filesystems.disks.s3.key', 'testkey');
        $app['config']->set('filesystems.disks.s3.secret', 'testsecret');
        $app['config']->set('filesystems.disks.s3.region', 'us-east-1');
        $app['config']->set('filesystems.disks.s3.bucket', 'test-bucket');
        $app['config']->set('s3migrate.extensions', [
            'jpg',
            'pdf',
        ]);
    }

    /**
     * Create a mock of a Storage disk.
     *
     * Usage:
     *     ```
     *     $storage = $this->mockStorageDisk('my-disk');
     *     $storage->shouldReceive('get')->once()->andReturn('test');
     *
     *     // test
     *     Storage::disk('my-disk')->get('file.txt');
     *     ```
     *
     * @param string $disk Optional
     * @return Filesystem
     */
    protected function mockStorageDisk($disk = 'mock')
    {
        Storage::extend('mock', function () {
            return \Mockery::mock(Filesystem::class);
        });

        Config::set('filesystems.disks.' . $disk, ['driver' => 'mock']);
        Config::set('filesystems.default', $disk);
        Config::set('filesystems.disks.' . $disk . '.key', 'testkey');
        Config::set('filesystems.disks.' . $disk . '.secret', 'testsecret');
        Config::set('filesystems.disks.' . $disk . '.region', 'us-east-1');
        Config::set('filesystems.disks.' . $disk . '.bucket', 'test-bucket');

        return Storage::disk($disk);
    }
}
