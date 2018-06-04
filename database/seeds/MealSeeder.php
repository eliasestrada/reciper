<?php

use App\Models\Trans\Meal;
use Illuminate\Database\Seeder;

class MealSeeder extends Seeder
{
    public function run()
    {
        Meal::insert([
			[ 'name_en' => 'breakfast', 'name_ru' => 'завтрак' ],
			[ 'name_en' => 'lunch', 'name_ru' => 'обед' ],
			[ 'name_en' => 'dinner', 'name_ru' => 'ужин' ],
		]);
    }
}
