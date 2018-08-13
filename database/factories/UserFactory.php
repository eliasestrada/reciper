<?php

use App\Models\User;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    $path_slug = date('Y') . '/' . date('n');
    $path_to = storage_path("app/public/users/$path_slug");
    $path_from = base_path('../tools/people');

    if (!\File::exists($path_to)) {
        \File::makeDirectory($path_to, 0777, true);
    }

    if (app()->env === 'testing') {
        $img = 'default.jpg';
    } else {
        $img = $path_slug . '/' . $faker->file($path_from, $path_to, false);
    }

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('111111'),
        'remember_token' => str_random(10),
        'admin' => 0,
        'master' => 0,
        //'image' => 'default.jpg',
        'image' => $img,
        "notif_check" => now(),
        "contact_check" => now(),
        "last_visit_at" => now(),
    ];
});
