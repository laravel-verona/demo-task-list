<?php

namespace Tests\Functional\Http\Controllers\Api;

use TestCase;
use Tests\BuildTasksTrait;

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

        $this->taskRepository = $this->mock('App\Contracts\TaskContract');
    }

    /** @test */
    public function it_should_return_unauthorized_if_api_token_is_missing()
    {
        $this->json('GET', 'api/tasks');

        $this->assertResponseStatus(401);
        $this->assertEquals('Unauthorized.', $this->response->getContent());
    }

    /** @test */
    public function it_should_return_unauthorized_if_api_token_is_invalid()
    {
        $this->json('GET', 'api/tasks', [], ['api_token' => 'invalidapitoken']);

        $this->assertResponseStatus(401);
        $this->assertEquals('Unauthorized.', $this->response->getContent());
    }

    /** @test */
    public function it_should_display_a_list_of_tasks_in_json_format()
    {
        $user = $this->buildUser();

        $tasks = $this->buildTasks(3);

        $this->taskRepository
            ->shouldReceive('all')
            ->once()
            ->andReturn($tasks);

        $this->json('GET', 'api/tasks', [], ['Authorization' => 'Bearer '.$user->api_token]);

        $response = json_decode($this->response->getContent(), true);

        $this->assertResponseOk();
        $this->isJson();
        $this->assertArrayHasKey('data', $response);
        $this->assertCount(3, $response['data']);
    }

    /** @test */
    public function it_should_create_a_new_task()
    {
        $user = $this->buildUser();

        $input = ['name' => 'Task Name'];

        $task = $this->buildTasks(1);

        $this->taskRepository
            ->shouldReceive('create')
            ->once()
            ->with($input)
            ->andReturn($task);

        $this->post('api/tasks', $input, ['Authorization' => 'Bearer '.$user->api_token]);

        $response = json_decode($this->response->getContent(), true);

        $this->assertResponseOk();
        $this->isJson();
        $this->assertArrayHasKey('data', $response);
    }

    /** @test */
    public function it_should_display_a_task_in_json_format()
    {
        $user = $this->buildUser();

        $task = $this->buildTasks(1);

        $this->taskRepository
            ->shouldReceive('find')
            ->once()
            ->with($task->id)
            ->andReturn($task);

        $this->json('GET', 'api/tasks/'.$task->id, [], ['Authorization' => 'Bearer '.$user->api_token]);

        $response = json_decode($this->response->getContent(), true);

        $this->assertResponseOk();
        $this->isJson();
        $this->assertArrayHasKey('data', $response);
        $this->assertEquals(1, $response['data']['id']);
    }

    /** @test */
    public function it_should_update_the_name_of_an_existing_task()
    {
        $user = $this->buildUser();

        $task = $this->buildTasks(1, ['name' => 'Task Modified']);

        $this->taskRepository
            ->shouldReceive('update')
            ->once()
            ->with($task->id, ['done' => 'false', 'name' => 'Task Modified'])
            ->andReturn($task);

        $input = ['done' => false, 'name' => 'Task Modified'];
        $this->put("api/tasks/{$task->id}", $input, ['Authorization' => 'Bearer '.$user->api_token]);

        $response = json_decode($this->response->getContent(), true);

        $this->assertResponseOk();
        $this->isJson();
        $this->assertArrayHasKey('data', $response);
    }

    /** @test */
    public function it_should_mark_an_existing_task_as_done()
    {
        $user = $this->buildUser();

        $task = $this->buildTasks(1, ['done' => false]);

        $input = ['done' => true];

        $this->taskRepository
            ->shouldReceive('update')
            ->once()
            ->with($task->id, $input)
            ->andReturn($task);

        $this->put("api/tasks/{$task->id}", $input, ['Authorization' => 'Bearer '.$user->api_token]);

        $response = json_decode($this->response->getContent(), true);

        $this->assertResponseOk();
        $this->isJson();
        $this->assertArrayHasKey('data', $response);
    }

    /** @test */
    public function it_should_destroy_an_existing_task()
    {
        $user = $this->buildUser();

        $task = $this->buildTasks(1);

        $this->taskRepository
            ->shouldReceive('delete')
            ->once()
            ->with($task->id)
            ->andReturn(true);

        $this->delete("api/tasks/{$task->id}", [], ['Authorization' => 'Bearer '.$user->api_token]);

        $response = json_decode($this->response->getContent(), true);

        $this->assertResponseOk();
        $this->isJson();
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('deleted', $response);
    }
}
