<?php

namespace OneThirtyOne\S3Migration;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

/**
 * Class FilesMigrated.
 */
class FilesMigrated
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

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
