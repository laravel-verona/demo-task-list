<?php

use App\Models\User;
use App\Transformers\UserTransformer;

class UserTransformerTest extends TestCase
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
        $user = factory(User::class)->create();

        $transformer = new UserTransformer;

        $userArr = $transformer->transform($user);

        $this->assertEquals($userArr['id'], $user->id);
        $this->assertEquals($userArr['name'], $user->name);
        $this->assertEquals($userArr['email'], $user->email);
        $this->assertArrayHasKey('created_at', $userArr);
        $this->assertArrayHasKey('updated_at', $userArr);
    }
}
