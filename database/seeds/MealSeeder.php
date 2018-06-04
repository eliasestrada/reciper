<?php

use App\Models\Meal;
use Illuminate\Database\Seeder;

class MealSeeder extends Seeder
{
    public function run()
    {
        Meal::insert([
			[ 'name' => 'breakfast' ],
			[ 'name' => 'lunch' ],
			[ 'name' => 'dinner' ],
		]);
    }
}
