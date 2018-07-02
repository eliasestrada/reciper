<?php

use App\Models\Meal;
use App\Models\User;
use App\Models\Recipe;
use Faker\Generator as Faker;

$factory->define(Recipe::class, function (Faker $faker) {
	$faker_ru = \Faker\Factory::create('ru_RU');
    return [
		'user_id' => rand(1, User::count()),
		'meal_id' => rand(1, 3),
		'time' => rand(10, 160),
		'image' => 'default.jpg',

		// Russian language
        'title_ru' => $faker_ru->realText(100),
		'intro_ru' => $faker_ru->realText(400),
		'ingredients_ru' => $faker_ru->realText(400),
		'text_ru' => $faker_ru->realText(1000),
		'ready_ru' => 1,
		'approved_ru' => 1,

		// English language
        'title_en' => $faker->title,
		'intro_en' => $faker->paragraph,
		'ingredients_en' => $faker->paragraph,
		'text_en' => $faker->text,
		'ready_en' => 1,
		'approved_en' => 1
    ];
});
