<?php

use App\Models\Recipe;

$factory->define(Recipe::class, function () {
    return [
        'user_id' => 1,
        'meal_id' => mt_rand(1, 3),
        'ru_approver_id' => 1,
        'en_approver_id' => 1,
        'time' => mt_rand(10, 160),
        'image' => 'default.jpg',
        'simple' => mt_rand(0, 1),
        'slug' => string_random(10),

        // Russian language
        'title_ru' => string_random(config('valid.recipes.title.min')),
        'intro_ru' => string_random(config('valid.recipes.intro.min')),
        'ingredients_ru' => string_random(config('valid.recipes.ingredients.min')),
        'text_ru' => string_random(config('valid.recipes.text.min')),
        'ready_ru' => 1,
        'approved_ru' => 1,
        'published_ru' => 1,

        // English language
        'title_en' => string_random(config('valid.recipes.title.min')),
        'intro_en' => string_random(config('valid.recipes.intro.min')),
        'ingredients_en' => string_random(config('valid.recipes.ingredients.min')),
        'text_en' => string_random(config('valid.recipes.text.min')),
        'ready_en' => 1,
        'approved_en' => 1,
        'published_en' => 1,
    ];
});

$factory->state(Recipe::class, 'draft', [
    'ready_en' => 0,
    'ready_ru' => 0,
    'approved_en' => 0,
    'approved_ru' => 0,
    'en_approver_id' => 0,
    'ru_approver_id' => 0,
]);

$factory->state(Recipe::class, 'waiting', [
    'approved_en' => 0,
    'approved_ru' => 0,
    'en_approver_id' => 0,
    'ru_approver_id' => 0,
]);
