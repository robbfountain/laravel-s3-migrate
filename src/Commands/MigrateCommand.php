<?php

namespace OneThirtyOne\S3Migration\Commands;

use Illuminate\Console\Command;
use OneThirtyOne\S3Migration\Events\S3MigrationCompleted;
use OneThirtyOne\S3Migration\Exceptions\InvalidAwsCredentials;
use OneThirtyOne\S3Migration\Facades\FileCollector;
use OneThirtyOne\S3Migration\Facades\S3Migrator;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Class MigrateCommand.
 */
class MigrateCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'onethirtyone:s3-migrate 
                            {--F|force : Will not prompt for user confirmation}';

    /**
     * @var string
     */
    protected $description = 'Migrate your local storage to an AWS S3 bucket';

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

        $files = $this->getFiles();

        $confirmed = $this->option('force')
            ? true
            : $this->confirm('You are about to migrate ' . $files->count() . ' files to S3.  Continue?', 'yes');

        if ($confirmed) {
            $this->info('Running Migration');
            
            $migrated = $this->withProgressBar($files, function (SplFileInfo $file) {
                S3Migrator::run($file);

                return $file;
            });

            if ($migrated->count()) {
                event(new S3MigrationCompleted($migrated));

                $this->newLine();
                $this->info('Migration completed');
            }
        } else {
            $this->error('Migration cancelled');
        }
    }

    /**
     * @throws \OneThirtyOne\S3Migration\Exceptions\InvalidAwsCredentials
     */
    protected function verifyAwsCredentials()
    {
        if (!config('filesystems.disks.s3.key') || !config('filesystems.disks.s3.secret')) {
            throw new InvalidAwsCredentials();
        }
    }

    /**
     * @return mixed
     */
    protected function getFiles()
    {
        return FileCollector::fromLocalStorage()->filter(function (SplFileInfo $file) {
            return in_array($file->getExtension(), config('s3migrate.extensions'));
        });
    }
}
