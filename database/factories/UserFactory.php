<?php

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
$factory->define(App\Group::class, function (Faker $faker) {
    return [
        'name' => $faker->name
        ];
});
$factory->define(App\Bill::class, function (Faker $faker) {
   return [
     'description' => 'dinner',
       'cost' => 1000,
       'user_id' => factory(\App\User::class)->create()->id,
       'group_id' => factory(\App\Group::class)->create()->id
   ];
});
$factory->define(App\User::class, function (Faker $faker) {
//    static $password;

    return [
        'name' => $faker->name,
        'telegram_id' => 12415
//        'email' => $faker->unique()->safeEmail,
//        'password' => $password ?: $password = bcrypt('secret'),
//        'remember_token' => str_random(10),
    ];
});
