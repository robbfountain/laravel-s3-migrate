<?php

namespace OneThirtyOne\S3Migration;

use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Support\Collection;

/**
 * Class FileCollector.
 */
class FileCollector
{
    /**
     * @var
     */
    protected $files;

    /**
     * @var \Illuminate\Filesystem\FilesystemManager
     */
    protected $fileSystem;

    /**
     * FileCollector constructor.
     *
     * @param  \Illuminate\Filesystem\FilesystemManager  $fileSystem
     */
    public function __construct(FilesystemManager $fileSystem)
    {
        $this->fileSystem = $fileSystem;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function fromLocalStorage()
    {
        foreach (config('s3migrate.local_paths') as $path) {
            if (is_dir($path)) {
                foreach (\Illuminate\Support\Facades\File::allFiles($path) as $file) {
                    $files[] = $file;
                }
            }
        }

        return Collection::make($files ?? []);
    }
}
