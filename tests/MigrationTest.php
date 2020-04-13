<?php

namespace OneThirtyOne\S3Migration\Tests;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use OneThirtyOne\S3Migration\Facades\FileCollector;

class MigrationTest extends TestCase
{
    /** @test */
    public function It_gets_files_from_local_storage()
    {
        $this->withExceptionHandling();

        $this->assertInstanceOf(Collection::class, FileCollector::fromLocalStorage());
        $this->assertEquals(3, FileCollector::fromLocalStorage()->count());
    }
}
