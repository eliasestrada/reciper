<?php

use App\Models\User;

$factory->define(User::class, function () {
    return [
        'name' => string_random(10),
        'status' => '',
        'email' => mt_rand(100, 10000) . '@' . string_random(4) . '.ru',
        'token' => null,
        'username' => string_random(40),
        'password' => bcrypt('11111111'),
        'remember_token' => mt_rand(1, 10000),
        'photo' => 'default.jpg',
        'xp' => 1,
        'popularity' => 0,
        'active' => 1,
        "streak_days" => 0,
        "streak_check" => date('Y-m-d H:i:s'),
        "notif_check" => date('Y-m-d H:i:s'),
        "contact_check" => date('Y-m-d H:i:s'),
    ];
});

$factory->afterMaking(User::class, function ($user) {
    $user->id = mt_rand(1000, 999999);
});

$factory->state(User::class, 'admin', function () {
    return [];
});

$factory->state(User::class, 'master', function () {
    return [];
});

$factory->afterCreatingState(User::class, 'admin', function ($user) {
    $user->roles()->attach([1]);
});

$factory->afterCreatingState(User::class, 'master', function ($user) {
    $user->roles()->attach([2]);
});
