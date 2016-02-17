<?php

namespace Tests\Functional\Http\Controllers;

use TestCase;
use App\Models\User;
use App\Contracts\UserContract;

class UserControllerTest extends TestCase
{
    /** @test */
    public function it_should_return_a_view_with_a_list_of_users()
    {
        $users = factory(User::class, 3)->make();

        $userRepository = $this->mock(UserContract::class);
        $userRepository->shouldReceive('all')->once()->andReturn($users);

        $this->get('users');

        $this->assertViewHas('users');
        $this->assertCount(3, $this->response->getOriginalContent()->users);
        $this->assertEquals('users.index', $this->response->getOriginalContent()->getName());
    }
}
