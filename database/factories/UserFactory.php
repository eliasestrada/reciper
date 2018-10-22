<?php

use App\Models\User;
use App\Models\Visitor;

cache()->flush();

$factory->define(User::class, function () {
    return [
        'visitor_id' => factory(Visitor::class)->create()->id,
        'name' => 'Name' . rand(),
        'status' => '',
        'email' => rand() . '@mail.ru',
        'username' => str_random(5) . '_' . rand(),
        'password' => bcrypt('111111'),
        'remember_token' => str_random(10),
        'image' => 'default.jpg',
        // 'image' => $faker->file(base_path('../tools/people'), storage_path('/app/public/small/users'), false),
        'xp' => 1,
        'popularity' => 2,
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
