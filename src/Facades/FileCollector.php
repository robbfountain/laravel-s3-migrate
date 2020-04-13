<?php

namespace OneThirtyOne\S3Migration\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class FileCollector.
 */
class FileCollector extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'file-collector';
    }
}
