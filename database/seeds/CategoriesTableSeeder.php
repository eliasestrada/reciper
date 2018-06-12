<?php

use App\Models\Title;
use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        Category::insert([
			[ 'name_ru' => 'Вторые блюда', 'name_en' => 'Second course' ],
			[ 'name_ru' => 'Выпечка', 'name_en' => 'Bakery' ],
			[ 'name_ru' => 'Вегетарианские', 'name_en' => 'Vegetarian' ],
			[ 'name_ru' => 'Гарниры', 'name_en' => 'Garnish' ],
			[ 'name_ru' => 'Десерты', 'name_en' => 'Dessert' ],
			[ 'name_ru' => 'Детские блюда', 'name_en' => 'Baby dishes' ],
			[ 'name_ru' => 'Крупы', 'name_en' => 'Cereals' ],
			[ 'name_ru' => 'Мультиварка', 'name_en' => 'Multicooker' ],
			[ 'name_ru' => 'Мясо', 'name_en' => 'Meat' ],
			[ 'name_ru' => 'Овощи', 'name_en' => 'Vegetables' ],
			[ 'name_ru' => 'Рыба', 'name_en' => 'Fish' ],
			[ 'name_ru' => 'Салаты', 'name_en' => 'Salads' ],
			[ 'name_ru' => 'Соусы', 'name_en' => 'Sauces' ],
			[ 'name_ru' => 'Суши', 'name_en' => 'Sushi' ],
			[ 'name_ru' => 'Разное', 'name_en' => 'Other' ]
		]);
    }
}