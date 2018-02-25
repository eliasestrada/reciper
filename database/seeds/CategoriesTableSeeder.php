<?php

use Illuminate\Database\Seeder;


class CategoriesTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('categories')->insert(['category' => 'Вегетарианские']);
        DB::table('categories')->insert(['category' => 'Вторые блюда']);
        DB::table('categories')->insert(['category' => 'Выпечка']);
        DB::table('categories')->insert(['category' => 'Гарниры']);
        DB::table('categories')->insert(['category' => 'Десерты']);
        DB::table('categories')->insert(['category' => 'Детские блюда']);
        DB::table('categories')->insert(['category' => 'Завтраки']);
        DB::table('categories')->insert(['category' => 'Закуски']);
        DB::table('categories')->insert(['category' => 'Крупы']);
        DB::table('categories')->insert(['category' => 'Мультиварка']);
        DB::table('categories')->insert(['category' => 'Мясо']);
        DB::table('categories')->insert(['category' => 'Овощи']);
        DB::table('categories')->insert(['category' => 'Рыба']);
        DB::table('categories')->insert(['category' => 'Салаты']);
        DB::table('categories')->insert(['category' => 'Соусы']);
        DB::table('categories')->insert(['category' => 'Суши']);
        DB::table('categories')->insert(['category' => 'Разное']);
    }
}
