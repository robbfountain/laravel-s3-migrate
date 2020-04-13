<?php

namespace OneThirtyOne\S3Migration\Tests;

use Illuminate\Support\Collection;
use OneThirtyOne\S3Migration\Facades\FileCollector;

class MigrationTest extends TestCase
{
    /** @test */
    public function It_retrieves_files_from_local_storage()
    {
        $this->assertInstanceOf(Collection::class, FileCollector::fromLocalStorage());

        $this->assertEquals(3, FileCollector::fromLocalStorage()->count());
    }
}
