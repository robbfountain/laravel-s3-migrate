<?php

namespace OneThirtyOne\S3Migration\Commands;

use Illuminate\Console\Command;

/**
 * Class MigrateCommand
 * @package OneThirtyOne\S3Migration\Commands
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
     * Execute the console command
     */
    public function handle()
    {

    }
}
