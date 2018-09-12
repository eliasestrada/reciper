<?php

use App\Models\User;
use Faker\Generator as Faker;

cache()->flush();

$factory->define(User::class, function (Faker $faker) {
    return [
        'id' => User::orderBy('id', 'desc')->latest()->value('id') + 1,
        'name' => $faker->name,
        'email' => rand() . '@gmail.com',
        'password' => bcrypt('111111'),
        'remember_token' => str_random(10),
        'image' => 'default.jpg',
        'points' => 0,
        "notif_check" => date('Y-m-d H:i:s'),
        "contact_check" => date('Y-m-d H:i:s'),
        "online_at" => date('Y-m-d H:i:s'),
    ];
});

$factory->state(User::class, 'admin', function ($faker) {
    return [];
});
$factory->state(User::class, 'master', function ($faker) {
    return [];
});

$factory->afterCreatingState(User::class, 'admin', function ($user, $faker) {
    $user->addRole('admin');
});

$factory->afterCreatingState(User::class, 'master', function ($user, $faker) {
    $user->addRole('master');
});
