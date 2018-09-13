<?php

use App\Models\Recipe;
use App\Models\User;
use Faker\Generator as Faker;

cache()->flush();

$factory->define(Recipe::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class)->create(['points' => 1])->id,
        'meal_id' => rand(1, 3),
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
