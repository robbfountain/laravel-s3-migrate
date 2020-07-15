<?php

namespace OneThirtyOne\S3Migration;

use Illuminate\Http\File as LaravelFile;
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

    protected $ignored = [];

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
        if (!$this->fileShouldBeIgnored()) {
            Storage::disk('s3')->putFileAs('/', $meta = $this->getFile(), $this->file->name);

            return $meta;
        }

    }

    public function fileShouldBeIgnored()
    {
        return in_array($this->file->name, $this->ignored);
    }

    /**
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function getFile()
    {
        return new LaravelFile(storage_path('app/' . $this->file->name));
    }
}
