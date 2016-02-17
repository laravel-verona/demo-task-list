<?php

namespace Tests;

use App\Models\Task;

trait BuildTasksTrait
{
    public function buildTasks($count, $attributes = [])
    {
        return factory(Task::class, $count)->create($attributes);
    }
}
