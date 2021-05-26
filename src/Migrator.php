<?php

namespace OneThirtyOne\S3Migration;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        $this->file = $file ?? $this->file;

        $path = Storage::disk('s3')
            ->putFileAs($this->getPath(), $this->file, $this->file->getFilename());

        return $path;
    }

    /**
     * Sets the S3 bucket config.
     */
    public function setBucket()
    {
        config(['filesystems.disks.s3.bucket' => config('s3migrate.aws_bucket')]);
    }

    public function getPath()
    {
        return Str::of(config('s3migrate.aws_bucket_path'))->endsWith('/')
            ? Str::of(config('s3migrate.aws_bucket_path'))
                ->append($this->file->getRelativePath())
                ->append('/')
            : Str::of(config('s3migrate.aws_bucket_path'))
                ->append('/')
                ->append($this->file->getRelativePath())
                ->append('/');
    }
}
