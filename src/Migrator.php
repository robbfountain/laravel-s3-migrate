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
        $this->setBucket();

        Storage::disk('s3')->putFileAs('/', $meta = $this->getFile(), $this->file->name);

        return $meta;
    }

    /**
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function getFile()
    {
        return new LaravelFile(config('s3migrate.storage_path').$this->file->name);
    }

    /**
     * Sets the S3 bucket config.
     */
    public function setBucket()
    {
        config(['filesystems.disks.s3.bucket' => config('s3migrate.aws_bucket')]);
    }
}
