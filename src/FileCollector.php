<?php


namespace OneThirtyOne\S3Migration;


use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Support\Collection;

/**
 * Class FileCollector
 * @package OneThirtyOne\S3Migration
 */
class FileCollector
{

    /**
     * @var
     */
    protected $files;


    protected $fileSystem;

    /**
     * FileCollector constructor.
     *
     * @param \Illuminate\Filesystem\FilesystemManager $fileSystem
     */
    public function __construct(FilesystemManager $fileSystem)
    {
        $this->fileSystem = $fileSystem;
    }

    /**
     * @return \Illuminate\Support\Collection
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function fromLocalStorage()
    {
        foreach (config('s3-migrate.disks') as $disk) {
            $files[] = $this->fileSystem->disk($disk)->files();
        }

        return Collection::make($files)->flatten();
    }
}
