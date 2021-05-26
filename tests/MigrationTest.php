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
        Config::set('filesystems.disks.s3.key', '');
        Config::set('filesystems.disks.s3.secret', '');
        Config::set('filesystems.disks.s3.region', '');
        Config::set('filesystems.disks.s3.bucket', '');

        $this->expectException(InvalidAwsCredentials::class);

        Artisan::call('onethirtyone:s3-migrate');
    }

    /** @test */
    public function It_returns_expected_output()
    {
        $storage = $this->mockStorageDisk('s3');

        $storage->shouldReceive('putFileAs')->times(3);

        $this->artisan('onethirtyone:s3-migrate')
            ->expectsConfirmation('You are about to migrate 3 files to S3.  Continue?', 'yes')
            ->expectsOutput('Migration completed')
            ->assertExitCode(0);
    }

    /** @test */
    public function It_fires_an_event_when_files_are_migrated()
    {
        Event::fake();

        $storage = $this->mockStorageDisk('s3');

        $storage->shouldReceive('putFileAs')->times(3);

        $this->artisan('onethirtyone:s3-migrate')
            ->expectsConfirmation('You are about to migrate 3 files to S3.  Continue?', 'yes')
            ->expectsOutput('Migration completed')
            ->assertExitCode(0);

        Event::assertDispatched(S3MigrationCompleted::class);
    }

    /** @test */
    public function It_excludes_unallowed_file_extensionst()
    {
        Config::set('s3migrate.extensions', ['jpg']);

        $storage = $this->mockStorageDisk('s3');

        $storage->shouldReceive('putFileAs')->times(2);

        $this->artisan('onethirtyone:s3-migrate')
            ->expectsConfirmation('You are about to migrate 2 files to S3.  Continue?', 'yes')
            ->expectsOutput('Migration completed')
            ->assertExitCode(0);
    }
}
