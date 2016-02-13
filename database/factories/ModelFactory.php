<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    return [
        'name'      => $faker->name,
        'email'     => $faker->email,
        'password'  => bcrypt(123456),
        'api_token' => str_random(60),
    ];
});

$factory->define(App\Models\Task::class, function (Faker\Generator $faker) {
    return [
        'name'          => $faker->words(3, true),
        'done'          => rand(0,1),
        'created_by'    => factory(\App\Models\User::class)->create()->id
    ];
});

