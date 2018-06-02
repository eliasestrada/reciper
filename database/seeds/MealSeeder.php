<?php

use App\Models\Meal;
use Illuminate\Database\Seeder;

class MealSeeder extends Seeder
{
    public function run()
    {
        Meal::create([
			'name_ru' => 'Завтрак',
			'name_en' => 'Breakfast'
			]);
        Meal::create([
			'name_ru' => 'Обед',
			'name_en' => 'Lunch'
			]);
        Meal::create([
			'name_ru' => 'Ужин',
			'name_en' => 'Dinner'
			]);
    }
}
