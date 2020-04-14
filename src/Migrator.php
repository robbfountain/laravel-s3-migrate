<?php

namespace OneThirtyOne\S3Migration;

use Illuminate\Support\Facades\Storage;

/**
 * Class Migrator.
 */
class Migrator
{
    /**
     * @var \OneThirtyOne\S3Migration\File
     */
    protected $file;

    /**
     * Migrator constructor.
     *
     * @param \OneThirtyOne\S3Migration\File $file
     */
    public function __construct(File $file)
    {
        $this->file = $file;
    }

    /**
     * @return mixed
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function run()
    {
        return Storage::putFileAs('/', $this->getFile(), $this->file->name);
    }

    /**
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function getFile()
    {
        return Storage::disk($this->file->disk)->get($this->file->name);
    }
}
