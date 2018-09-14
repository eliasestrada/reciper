<?php

use App\Models\Recipe;
use App\Models\User;
use Faker\Generator as Faker;

cache()->flush();

$factory->define(Recipe::class, function (Faker $faker) {
    $author = factory(User::class)->create(['points' => 1]);
    $admin = factory(User::class)->create();
    $admin->addRole('admin');

    return [
        'user_id' => $author->id,
        'meal_id' => rand(1, 3),
        'ru_approver_id' => $admin->id,
        'en_approver_id' => $admin->id,
        'time' => rand(10, 160),
        'image' => 'default.jpg',

        // Russian language
        'title_ru' => $faker->sentence(5),
        'intro_ru' => $faker->paragraph,
        'ingredients_ru' => $faker->paragraph,
        'text_ru' => $faker->realText(200),
        'ready_ru' => 1,
        'approved_ru' => 1,

        // English language
        'title_en' => $faker->sentence,
        'intro_en' => $faker->paragraph,
        'ingredients_en' => $faker->paragraph,
        'text_en' => $faker->realText(200),
        'ready_en' => 1,
        'approved_en' => 1,
    ];
});
