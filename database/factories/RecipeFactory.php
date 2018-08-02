<?php

use App\Models\Meal;
use App\Models\User;
use App\Models\Recipe;
use Faker\Generator as Faker;

$factory->define(Recipe::class, function (Faker $faker) {
    return [
		'user_id' => rand(1, User::count()),
		'meal_id' => rand(1, 3),
		'time' => rand(10, 160),
		'image' => 'default.jpg',

		// Russian language
        'title_ru' => $faker->sentence,
		'intro_ru' => $faker->paragraph,
		'ingredients_ru' => $faker->paragraph,
		'text_ru' => $faker->paragraph,
		'ready_ru' => 1,
		'approved_ru' => 1,

		// English language
        'title_en' => $faker->sentence,
		'intro_en' => $faker->paragraph,
		'ingredients_en' => $faker->paragraph,
		'text_en' => $faker->paragraph,
		'ready_en' => 1,
		'approved_en' => 1
    ];
});
