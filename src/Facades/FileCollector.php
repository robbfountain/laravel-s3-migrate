<?php

namespace OneThirtyOne\S3Migration\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class FileCollector
 * @package OneThirtyOne\S3Migration\Facades
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
