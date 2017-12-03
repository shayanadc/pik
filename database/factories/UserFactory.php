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
     'description' => $faker->word,
       'cost' => $faker->randomNumber(6),
       'owner' => factory(\App\User::class)->create()->id,
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
$factory->define(App\Ledger::class, function (Faker $faker) {
    return [
        'bill_no' => factory(\App\Bill::class)->create()->id,
        'creditor' => factory(\App\User::class)->create()->id,
        'owe' => factory(\App\User::class)->create()->id,
        'amount' => $faker->randomNumber(4)
    ];
});
