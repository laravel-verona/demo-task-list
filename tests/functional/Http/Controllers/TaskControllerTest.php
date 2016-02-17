<?php

namespace Tests\Functional\Http\Controllers;

use TestCase;
use Tests\BuildTasksTrait;
use App\Contracts\TaskContract;

class TaskControllerTest extends TestCase
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

        $this->taskRepository = $this->mock(TaskContract::class);
    }

    /** @test */
    public function it_should_redirect_the_user_to_login_if_not_authenticated()
    {
        $this->get('tasks');

        $this->assertRedirectedTo('auth/login');
    }

    /** @test */
    public function it_should_display_a_list_of_tasks()
    {
        $user = $this->buildUser();

        $tasks = $this->buildTasks(3);

        $this->taskRepository
            ->shouldReceive('all')
            ->once()
            ->andReturn($tasks);

        $this->actingAs($user)->get('tasks');

        $this->assertViewHas('tasks');
        $this->assertCount(3, $this->response->getOriginalContent()->tasks);
        $this->assertEquals('tasks.index', $this->response->getOriginalContent()->getName());
    }

    /** @test */
    public function it_should_create_a_new_task()
    {
        $user = $this->buildUser();

        $task = $this->buildTasks(1);

        $input = ['name' => $task->name];

        $this->taskRepository
            ->shouldReceive('create')
            ->once()
            ->with($input)
            ->andReturn($task);

        $this->actingAs($user)->post('tasks', $input);

        $this->assertResponseStatus(302);
        $this->assertSessionHas('success');
    }

    /** @test */
    public function it_should_update_the_name_of_an_existing_task()
    {
        $this->withoutMiddleware();

        $user = $this->buildUser();

        $task = $this->buildTasks(1, ['name' => 'Task Modified']);

        $this->taskRepository
            ->shouldReceive('update')
            ->once()
            ->with($task->id, ['done' => 'false', 'name' => 'Task Modified'])
            ->andReturn($task);

        $input = ['done' => false, 'name' => 'Task Modified'];

        $this->actingAs($user)->put('tasks/'.$task->id, $input);

        $this->assertResponseStatus(302);
        $this->assertSessionHas('success');
    }

    /** @test */
    public function it_should_mark_an_existing_task_as_done()
    {
        $user = $this->buildUser();

        $this->withoutMiddleware();

        $task = $this->buildTasks(1, ['done' => false]);

        $input = ['done' => true];

        $this->taskRepository
            ->shouldReceive('update')
            ->once()
            ->with(1, $input)
            ->andReturn($task);

        $this->actingAs($user)->put('tasks/1', $input);

        $this->assertResponseStatus(302);
        $this->assertSessionHas('success');
    }

    /** @test */
    public function it_should_destroy_an_existing_task()
    {
        $this->withoutMiddleware();

        $user = $this->buildUser();

        $this->taskRepository
            ->shouldReceive('delete')
            ->once()
            ->with(1);

        $this->actingAs($user)->delete('tasks/1');

        $this->assertResponseStatus(302);
        $this->assertSessionHas('success');
    }
}
