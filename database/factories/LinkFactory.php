<?php

use App\Entity\Link;
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

$factory->define(Link::class, function (Faker $faker) {
    $user = new User();
    return [
        'link' => $faker->url,
        'user_id' => $user->id,
        'title' => $faker->title,
        'description' => $faker->text,
        'private' => $faker->boolean,
    ];
});
