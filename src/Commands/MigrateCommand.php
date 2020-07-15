<?php

namespace OneThirtyOne\S3Migration\Commands;

use Illuminate\Console\Command;
use OneThirtyOne\S3Migration\Exceptions\InvalidAwsCredentials;
use OneThirtyOne\S3Migration\Facades\FileCollector;
use OneThirtyOne\S3Migration\FilesMigrated;

/**
 * Class MigrateCommand.
 */
class MigrateCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'onethirtyone:s3-migrate';

    /**
     * @var string
     */
    protected $description = 'Migrate your local storage to AWS S3 bucket';

    /**
     * MigrateCommand constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * @throws \OneThirtyOne\S3Migration\Exceptions\InvalidAwsCredentials
     */
    public function handle()
    {
        $this->verifyAwsCredentials();

        $migrated = $this->getFiles()->map(function ($file) {
            $meta = $file->migrate();
            $this->comment("Migrated {$meta->path()} ({$meta->getSize()} bytes)");

            return $meta;
        });

        if ($migrated->count()) {
            event(new FilesMigrated($migrated));
        }
    }

    /**
     * @throws \OneThirtyOne\S3Migration\Exceptions\InvalidAwsCredentials
     */
    protected function verifyAwsCredentials()
    {
        if (! config('filesystems.disks.s3.key') || ! config('filesystems.disks.s3.secret')) {
            throw new InvalidAwsCredentials();
        }
    }

    /**
     * @return mixed
     */
    protected function getFiles()
    {
        return FileCollector::fromLocalStorage();
    }
}
