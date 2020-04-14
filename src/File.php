<?php

namespace OneThirtyOne\S3Migration;

/**
 * Class File.
 */
class File
{
    /**
     * @var
     */
    protected $disk;

    /**
     * @var
     */
    protected $name;

    /**
     * File constructor.
     *
     * @param $name
     * @param $disk
     */
    public function __construct($name, $disk)
    {
        $this->name = $name;
        $this->disk = $disk;
    }

    /**
     * @param $disk
     * @param $file
     * @param $size
     *
     * @return static
     */
    public static function newFileFromStorage($disk, $file)
    {
        return new static($file, $disk);
    }

    /**
     * @param $property
     *
     * @return mixed
     */
    public function __get($property)
    {
        return $this->{$property};
    }

    /**
     * Migrate file to S3.
     */
    public function migrate()
    {
        return (new Migrator($this))->run();
    }
}
