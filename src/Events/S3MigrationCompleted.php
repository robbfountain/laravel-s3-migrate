<?php

namespace OneThirtyOne\S3Migration\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

/**
 * Class FilesMigrated.
 */
class S3MigrationCompleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var \Illuminate\Support\Collection
     */
    public $files;

    /**
     * FilesMigrated constructor.
     *
     * @param \Illuminate\Support\Collection $files
     */
    public function __construct(Collection $files)
    {
        $this->files = $files;
    }
}
