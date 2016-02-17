<?php

namespace Tests\Functional\Http\Controllers;

use TestCase;

class UserControllerTest extends TestCase
{
    /** @test */
    public function it_should_return_a_view_with_a_list_of_users()
    {
        $users = factory(\App\Models\User::class, 3)->make();

        $userRepository = $this->mock('App\Contracts\UserContract');
        $userRepository->shouldReceive('all')->once()->andReturn($users);


        $this->get('users');


        $this->assertViewHas('users');
        $this->assertCount(3, $this->response->getOriginalContent()->users);
        $this->assertEquals('users.index', $this->response->getOriginalContent()->getName());
    }
}
