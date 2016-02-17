<?php

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
        $task = factory(\App\Models\Task::class)->create();

        $transformer = new \App\Transformers\TaskTransformer();

        $taskArr = $transformer->transform($task);

        $this->assertEquals($taskArr['id'], $task->id);
        $this->assertEquals($taskArr['name'], $task->name);
        $this->assertEquals($taskArr['done'], $task->done);
        $this->assertArrayHasKey('created_at', $taskArr);
        $this->assertArrayHasKey('updated_at', $taskArr);
        $this->assertArrayHasKey('author', $taskArr);
    }
}
