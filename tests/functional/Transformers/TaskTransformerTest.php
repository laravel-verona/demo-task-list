<?php

use App\Models\Task;
use App\Transformers\TaskTransformer;

class TaskTransformerTest extends TestCase
{
    /**
     * @before
     */
    public function runDatabaseMigrations()
    {
        $this->artisan('migrate');
    }

    /** @test */
    public function it_should_transform_a_task_into_a_generic_array()
    {
        $task = factory(Task::class)->create();

        $transformer = new TaskTransformer;

        $taskArr = $transformer->transform($task);

        $this->assertEquals($taskArr['id'], $task->id);
        $this->assertEquals($taskArr['name'], $task->name);
        $this->assertEquals($taskArr['done'], $task->done);
        $this->assertArrayHasKey('created_at', $taskArr);
        $this->assertArrayHasKey('updated_at', $taskArr);
    }
}
