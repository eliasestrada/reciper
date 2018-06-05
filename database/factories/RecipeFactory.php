<?php

use App\Models\Recipe;
use Faker\Generator as Faker;
use App\Models\Category;

$factory->define(Recipe::class, function (Faker $faker) {
    return [
		'user_id' => rand(1, 2),
		'category_id' => rand(1, Category::count()),
		'meal_id' => rand(1, 3),
        'title' => $faker->catchPhrase,
		'intro' => $faker->text(200),
		'ingredients' => $faker->text(40),
		'text' => $faker->text(1000),
		'time' => rand(10, 160),
		'ready' => 1,
		'approved' => 1,
		'image' => 'default.jpg'
    ];
});
