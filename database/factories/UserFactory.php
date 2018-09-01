<?php

use App\Models\User;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => rand() . '@gmail.com',
        'password' => bcrypt('111111'),
        'remember_token' => str_random(10),
        'admin' => 0,
        'master' => 0,
        'image' => 'default.jpg',
        "notif_check" => now(),
        "contact_check" => now(),
        "last_visit_at" => now(),
    ];
});
