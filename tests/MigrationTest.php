<?php

namespace OneThirtyOne\S3Migration\Tests;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use OneThirtyOne\S3Migration\Exceptions\InvalidAwsCredentials;
use OneThirtyOne\S3Migration\Facades\FileCollector;

class MigrationTest extends TestCase
{
    /** @test */
    public function It_retrieves_files_from_local_storage()
    {
        $this->assertInstanceOf(Collection::class, FileCollector::fromLocalStorage());

        $this->assertEquals(3, FileCollector::fromLocalStorage()->count());
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

        Config::set('filesystems.s3.key', 'testkey');
        Config::set('filesystems.s3.secret', 'testsecret');
        Config::set('filesystems.s3.region', 'us-east-1');
        Config::set('filesystems.s3.bucket', 'test-bucket');

        Artisan::call('onethirtyone:s3-migrate');
    }
}
