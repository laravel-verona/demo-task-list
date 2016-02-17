<?php

namespace Tests;

trait BuildTasksTrait
{
    public function buildTasks($count, $attributes = [])
    {
        return factory(\App\Models\Task::class, $count)->create($attributes);
    }
}
