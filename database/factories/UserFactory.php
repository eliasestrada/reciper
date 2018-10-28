<?php

use App\Models\User;

$factory->define(User::class, function () {
    return [
        'visitor_id' => 1,
        'name' => str_random(7),
        'status' => '',
        'email' => str_random(20) . '@mail.ru',
        'username' => str_random(7),
        'password' => bcrypt('111111'),
        'remember_token' => str_random(10),
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
    $user->id = rand();
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

$factory->state(User::class, 'with_photo', function () {
    return ['photo' => uploadFakePhoto()];
});
