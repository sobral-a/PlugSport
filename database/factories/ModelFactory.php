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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'first_name' => "John",
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret75'),
        'remember_token' => str_random(10),
        'description' => "Cool",
        'isAdmin' => 0,
        'wantsRappel' => 1
    ];
});

$factory->define(App\Sport::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'number' => rand(1,10)
    ];
});

$factory->define(App\Team::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'user_id' => factory(App\User::class)->create()->id,
        'sport_id' => factory(App\Sport::class)->create()->id,
        'banned' => 0
    ];
});
