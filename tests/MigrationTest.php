<?php

namespace OneThirtyOne\S3Migration\Tests;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use OneThirtyOne\S3Migration\Events\S3MigrationCompleted;
use OneThirtyOne\S3Migration\Exceptions\InvalidAwsCredentials;
use OneThirtyOne\S3Migration\Facades\FileCollector;

class MigrationTest extends TestCase
{
    /** @test */
    public function It_retrieves_files_from_local_storage()
    {
        $files = FileCollector::fromLocalStorage();

        $this->assertInstanceOf(Collection::class, $files);

        $this->assertEquals(3, $files->count());
    }

    /** @test * */
    public function It_requires_s3_credentials()
    {
        $this->expectException(InvalidAwsCredentials::class);

        Artisan::call('onethirtyone:s3-migrate');
    }

    /** @test * */
    public function It_migrates_files_to_s3()
    {
        $storage = $this->mockStorageDisk('s3');

        $storage->shouldReceive('putFileAs')->times(3);

        Config::set('filesystems.disks.s3.key', 'testkey');
        Config::set('filesystems.disks.s3.secret', 'testsecret');
        Config::set('filesystems.disks.s3.region', 'us-east-1');
        Config::set('filesystems.disks.s3.bucket', 'test-bucket');
        Config::set('s3migrate.storage_path', __DIR__.'/Fakes/');

        Artisan::call('onethirtyone:s3-migrate');
    }

    /** @test */
    public function It_fires_an_event_when_files_are_migrated()
    {
        Event::fake();

        $this->withoutExceptionHandling();

        $storage = $this->mockStorageDisk('s3');

        $storage->shouldReceive('putFileAs')->times(3);

        Config::set('filesystems.disks.s3.key', 'testkey');
        Config::set('filesystems.disks.s3.secret', 'testsecret');
        Config::set('filesystems.disks.s3.region', 'us-east-1');
        Config::set('filesystems.disks.s3.bucket', 'test-bucket');
        Config::set('s3migrate.storage_path', __DIR__ . '/Fakes/');

        Artisan::call('onethirtyone:s3-migrate');

        Event::assertDispatched(S3MigrationCompleted::class);

    }
}
