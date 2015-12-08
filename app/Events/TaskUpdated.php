<?php

namespace Todo\Events;

use Todo\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Todo\Task;

class TaskUpdated extends Event implements ShouldBroadcast
{
    use SerializesModels;

    /**
     * Task aggiornato
     *
     * @var Task
     */
    public $task;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
