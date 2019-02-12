<?php

use App\Models\Recipe;

$factory->define(Recipe::class, function () {
    return [
        'user_id' => 1,
        'meal_id' => rand(1, 3),
        'ru_approver_id' => 1,
        'en_approver_id' => 1,
        'time' => rand(10, 160),
        'image' => 'default.jpg',
        'simple' => rand(0, 1),
        'slug' => rand(),

        // Russian language
        'title_ru' => 'Название рецепта #' . rand(),
        'intro_ru' => 'Вкусная морковь по-корейски за 10 минут которая готовится довольно просто',
        'ingredients_ru' => "1 кг моркови\n1 маленькая луковица\n1 зубчик чеснока\n1/2 ч. л. красного перца",
        'text_ru' => "После того как морковь почищена, натираем ее на терке (шинковка).\nВ натертую морковь добавляем 1 чайную ложку соли, пол чайной ложки сахара и 3 капли уксуса",
        'ready_ru' => 1,
        'approved_ru' => 1,
        'published_ru' => 1,

        // English language
        'title_en' => 'Name of the recipe #' . rand(),
        'intro_en' => 'Another genius technique that this soup employs (which for some might be obvious, but for others might be soup-er revelatory',
        'ingredients_en' => "Carrot\nMore carrot\nOnion\nAnd many other stuf goes here",
        'text_en' => "Peel ginger using a spoon's edge — you'll be able to maneuver around the knobbly!\nWash and dry all produce.* Peel, then zest or grate 1 tbsp ginger (dbl for 4 ppl)",
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
