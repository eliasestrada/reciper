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
        'title_ru' => 'Русское название № ' . rand(),
		'intro_ru' => 'Вступление на русском языке ' . rand(),
		'ingredients_ru' => 'Руские ингридиенты ' . rand(),
		'text_ru' => 'Текст тоже русский ' . rand(),
		'ready_ru' => 1,
		'approved_ru' => 1,

		// Russian language
        'title_en' => 'Enlish title # ' . rand(),
		'intro_en' => 'Intro in english ' . rand(),
		'ingredients_en' => 'English ingredients ' . rand(),
		'text_en' => 'Text in english ' . rand(),
		'ready_en' => 1,
		'approved_en' => 1
    ];
});
