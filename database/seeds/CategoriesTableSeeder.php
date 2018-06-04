<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        Category::insert([
			[ 'name' => 'Вторые блюда' ],
			[ 'name' => 'Выпечка' ],
			[ 'name' => 'Гарниры' ],
			[ 'name' => 'Десерты' ],
			[ 'name' => 'Детские блюда' ],
			[ 'name' => 'Завтраки' ],
			[ 'name' => 'Крупы' ],
			[ 'name' => 'Мультиварка' ],
			[ 'name' => 'Мясо' ],
			[ 'name' => 'Овощи' ],
			[ 'name' => 'Рыба' ],
			[ 'name' => 'Салаты' ],
			[ 'name' => 'Соусы' ],
			[ 'name' => 'Суши' ],
			[ 'name' => 'Разное' ]
		]);
    }
}