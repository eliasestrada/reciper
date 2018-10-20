<?php

use App\Models\Recipe;
use Faker\Generator as Faker;

$factory->define(Recipe::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'meal_id' => rand(1, 3),
        'ru_approver_id' => 1,
        'en_approver_id' => 1,
        'time' => rand(10, 160),
        // 'image' => $faker->file(base_path('../tools/food'), storage_path('/app/public/small/recipes'), false),
        'image' => 'default.jpg',
        'simple' => rand(0, 1),

        // Russian language
        'title_ru' => $faker->sentence,
        'intro_ru' => $faker->paragraph,
        'ingredients_ru' => $faker->paragraph,
        'text_ru' => $faker->realText(config('valid.recipes.text.min') + 50),
        'ready_ru' => 1,
        'approved_ru' => 1,
        'published_ru' => 1,

        // English language
        'title_en' => $faker->sentence,
        'intro_en' => $faker->paragraph,
        'ingredients_en' => $faker->paragraph,
        'text_en' => $faker->realText(config('valid.recipes.text.min') + 50),
        'ready_en' => 1,
        'approved_en' => 1,
        'published_en' => 1,
    ];
});
