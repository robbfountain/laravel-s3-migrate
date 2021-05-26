<?php

namespace OneThirtyOne\S3Migration;

use Illuminate\Http\File as LaravelFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Finder\SplFileInfo;

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
    public function __construct()
    {
        $this->setBucket();
    }

    /**
     * @return mixed
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function run($file = null)
    {
        $file = $file ?? $this->file;

        $path = Storage::disk('s3')
            ->putFileAs(config('s3migrate.aws_bucket_path', '/'), $file, $file->getFilename());

        return $path;
    }

    /**
     * Sets the S3 bucket config.
     */
    public function setBucket()
    {
        config(['filesystems.disks.s3.bucket' => config('s3migrate.aws_bucket')]);
    }
}
