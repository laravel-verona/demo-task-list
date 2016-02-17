<?php

namespace Tests\Functional\Repositories;

use App\Models\Task;
use App\Repositories\DbTaskRepository;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use TestCase;
use Tests\BuildTasksTrait;

class DbTaskRepositoryTest extends TestCase
{
    use BuildTasksTrait;

    /**
     * @before
     */
    public function runDatabaseMigrations()
    {
        $this->artisan('migrate');
    }

    public function setUp()
    {
        parent::setUp();

        $this->dbTaskRepository = new DbTaskRepository(new Task());
    }

    /** @test */
    public function it_should_return_a_list_of_tasks_with_author_ordered_by_created_date_desc()
    {
        $date1 = Carbon::create(2001, 12, 21);
        $this->buildTasks(1, ['created_at' => $date1->toDateTimeString()]);

        $date2 = Carbon::create(2002, 12, 21);
        $this->buildTasks(1, ['created_at' => $date2->toDateTimeString()]);

        $date3 = Carbon::create(2003, 12, 21);
        $this->buildTasks(1, ['created_at' => $date3->toDateTimeString()]);


        $tasks = $this->dbTaskRepository->all();


        $this->assertCount(3, $tasks);
        $this->assertArrayHasKey('author', $tasks[0]);
        $this->assertEquals($date3, $tasks[0]->created_at);
        $this->assertEquals($date2, $tasks[1]->created_at);
        $this->assertEquals($date1, $tasks[2]->created_at);
    }

    /** @test */
    public function it_should_paginate_the_list_of_tasks_with_author_ordered_by_created_date_desc()
    {
        $date1 = Carbon::create(2001, 12, 21);
        $this->buildTasks(2, ['created_at' => $date1->toDateTimeString()]);

        $date2 = Carbon::create(2002, 12, 21);
        $this->buildTasks(2, ['created_at' => $date2->toDateTimeString()]);

        $date3 = Carbon::create(2003, 12, 21);
        $this->buildTasks(2, ['created_at' => $date3->toDateTimeString()]);


        $tasks = $this->dbTaskRepository->paginate();


        $this->assertCount(5, $tasks);
        $this->assertInstanceOf(LengthAwarePaginator::class, $tasks);

        $this->assertEquals($date3, $tasks[0]->created_at);
        $this->assertEquals($date3, $tasks[1]->created_at);
        $this->assertEquals($date2, $tasks[2]->created_at);
        $this->assertEquals($date2, $tasks[3]->created_at);
        $this->assertEquals($date1, $tasks[4]->created_at);
    }

    /** @test */
    public function it_should_find_a_task_by_its_id()
    {
        $task = $this->buildTasks(1);


        $foundTask = $this->dbTaskRepository->find($task->id);


        $this->assertEquals($task->id, $foundTask->id);
    }

    /** @test */
    public function it_should_create_a_new_task_in_the_database()
    {
        $this->dbTaskRepository->create([
            'name' => 'Task',
            'done' => false
        ]);

        $this->seeInDatabase('tasks', ['name' => 'Task', 'done' => 0]);
    }

    /** @test */
    public function it_should_update_a_task_in_the_database()
    {
        $task = $this->buildTasks(1);

        $this->dbTaskRepository->update($task->id, [
            'name' => 'Modified Task',
            'done' => false
        ]);

        $this->seeInDatabase('tasks', ['id' => $task->id, 'name' => 'Modified Task', 'done' => 0]);
    }

    /** @test */
    public function it_should_delete_a_task_from_the_database()
    {
        $task = $this->buildTasks(1);

        $this->dbTaskRepository->delete($task->id);

        $this->dontSeeInDatabase('tasks', ['id' => $task->id]);
    }
}
