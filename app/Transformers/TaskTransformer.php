<?php

namespace App\Transformers;

use App\Models\Task;
use League\Fractal\TransformerAbstract;

class TaskTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        'author'
    ];

    /**
     * Turn this item object into a generic array.
     *
     * @return array
     */
    public function transform(Task $task)
    {
        return [
            'id'         => $task->id,
            'name'       => $task->name,
            'done'       => (bool) $task->done,
            'created_at' => $task->created_at->toIso8601String(),
            'updated_at' => $task->updated_at->toIso8601String(),
        ];
    }

    /**
     * Include Author
     *
     * @param Task $task
     * @return \League\Fractal\Resource\Item
     */
    public function includeAuthor(Task $task)
    {
        return $this->item($task->author, new UserTransformer);
    }
}
