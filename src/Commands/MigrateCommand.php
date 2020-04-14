<?php

namespace OneThirtyOne\S3Migration\Commands;

use Illuminate\Console\Command;
use OneThirtyOne\S3Migration\Exceptions\InvalidAwsCredentials;
use OneThirtyOne\S3Migration\Facades\FileCollector;

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

        $this->getFiles()->each->migrate();
    }

    /**
     * @throws \OneThirtyOne\S3Migration\Exceptions\InvalidAwsCredentials
     */
    protected function verifyAwsCredentials()
    {
        if (! config('filesystems.s3.key') || ! config('filesystems.s3.secret')) {
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
