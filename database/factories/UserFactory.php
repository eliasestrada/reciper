<?php

use App\Models\User;
use App\Models\Visitor;
use Faker\Generator as Faker;

cache()->flush();

$factory->define(User::class, function (Faker $faker) {
    return [
        'id' => User::orderBy('id', 'desc')->latest()->value('id') + 1,
        'visitor_id' => factory(Visitor::class)->create()->id,
        'name' => $faker->name,
        'about_me' => '',
        'email' => $faker->freeEmail,
        'password' => bcrypt('111111'),
        'remember_token' => str_random(10),
        'image' => 'default.jpg',
        // 'image' => $faker->file(base_path('../tools/people'), storage_path('/app/public/small/users'), false),
        'xp' => 1,
        'popularity' => 2,
        "streak_days" => 0,
        "streak_check" => date('Y-m-d H:i:s'),
        "notif_check" => date('Y-m-d H:i:s'),
        "contact_check" => date('Y-m-d H:i:s'),
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
