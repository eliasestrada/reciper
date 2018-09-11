<?php

use App\Models\User;
use Faker\Generator as Faker;

cache()->flush();

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => rand() . '@gmail.com',
        'password' => bcrypt('111111'),
        'remember_token' => str_random(10),
        'admin' => 0,
        'master' => 0,
        'image' => 'default.jpg',
        'points' => 0,
        "notif_check" => date('Y-m-d H:i:s'),
        "contact_check" => date('Y-m-d H:i:s'),
        "online_at" => date('Y-m-d H:i:s'),
    ];
});
