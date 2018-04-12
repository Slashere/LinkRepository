<?php

use App\Entity\User;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    $active = $faker->boolean;
    return [
        'login' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'role_id' => $active ? $faker->numberBetween(2, 3) : 1,
        'status' => $active ? 1 : 0,
        'remember_token' => str_random(10),
    ];
});
