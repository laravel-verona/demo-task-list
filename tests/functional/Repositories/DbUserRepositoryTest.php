<?php

namespace Tests\Functional\Repositories;

use App\Models\User;
use App\Repositories\DbUserRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use TestCase;

class DbUserRepositoryTest extends TestCase
{
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

        $this->dbUserRepository = new DbUserRepository(new User());
    }

    /** @test */
    public function it_should_return_a_list_of_users_ordered_by_name()
    {
        $this->buildUsers(1, ['name' => 'Zoe']);
        $this->buildUsers(1, ['name' => 'Regan']);
        $this->buildUsers(1, ['name' => 'Michael']);


        $users = $this->dbUserRepository->all();


        $this->assertCount(3, $users);
        $this->assertEquals('Michael', $users[0]->name);
        $this->assertEquals('Regan', $users[1]->name);
        $this->assertEquals('Zoe', $users[2]->name);
    }

    /** @test */
    public function it_should_paginate_the_list_of_users_ordered_by_name()
    {
        $this->buildUsers(2, ['name' => 'Zoe']);
        $this->buildUsers(2, ['name' => 'Regan']);
        $this->buildUsers(2, ['name' => 'Michael']);


        $users = $this->dbUserRepository->paginate();


        $this->assertCount(5, $users);
        $this->assertInstanceOf(LengthAwarePaginator::class, $users);

        $this->assertEquals('Michael', $users[0]->name);
        $this->assertEquals('Michael', $users[1]->name);
        $this->assertEquals('Regan', $users[2]->name);
        $this->assertEquals('Regan', $users[3]->name);
        $this->assertEquals('Zoe', $users[4]->name);
    }

    /** @test */
    public function it_should_find_a_user_by_its_id()
    {
        $user = $this->buildUsers(1);


        $foundUser = $this->dbUserRepository->find($user->id);


        $this->assertEquals($user->id, $foundUser->id);
    }

    /** @test */
    public function it_should_create_a_new_user_in_the_database()
    {
        $user = $this->dbUserRepository->create([
            'name' => 'User Name',
            'email' => 'email@domain.com',
            'password' => 'password'
        ]);

        $this->seeInDatabase('users', ['name' => 'User Name', 'email' => 'email@domain.com']);
    }

    /** @test */
    public function it_should_update_a_user_in_the_database()
    {
        $user = $this->buildUsers(1);


        $updatedUser = $this->dbUserRepository->update($user->id, [
            'name' => 'Modified Name'
        ]);

        $this->seeInDatabase('users', ['id' => $user->id, 'name' => 'Modified Name']);
    }

    /** @test */
    public function it_should_delete_a_user_from_the_database()
    {
        $user = $this->buildUsers(1);


        $this->dbUserRepository->delete($user->id);

        $this->dontSeeInDatabase('users', ['id' => $user->id]);
    }


    private function buildUsers($count, $attributes = [])
    {
        return factory(\App\Models\User::class, $count)->create($attributes);
    }
}
