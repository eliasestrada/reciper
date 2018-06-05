<?php

use App\Models\Recipe;
use Faker\Generator as Faker;
use App\Models\Category;

$factory->define(Recipe::class, function (Faker $faker) {
    return [
		'user_id' => rand(1, 2),
		'category_id' => rand(1, Category::count()),
		'meal_id' => rand(1, 3),
		'time' => rand(10, 160),
		'image' => 'default.jpg',

		// Russian language
        'title_ru' => $faker->catchPhrase,
		'intro_ru' => $faker->text(200),
		'ingredients_ru' => $faker->text(40),
		'text_ru' => $faker->text(1000),
		'ready_ru' => 1,
		'approved_ru' => 1,

		// Russian language
        'title_en' => $faker->catchPhrase,
		'intro_en' => $faker->text(200),
		'ingredients_en' => $faker->text(40),
		'text_en' => $faker->text(1000),
		'ready_en' => 1,
		'approved_en' => 1
    ];
});
