<?php

namespace OneThirtyOne\S3Migration\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class FileCollector.
 */
class S3Migrator extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 's3-migrator';
    }
}
