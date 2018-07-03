<?php

use App\Models\Recipe;
use App\Models\Category;
use Illuminate\Database\Seeder;

class RecipesSeeder extends Seeder
{
    /**
     * Run the database seeds
     * @return void
     */
    public function run()
    {
		// $categories = Category::get();

		// Recipe::get()->each(function ($recipe) use ($categories) {
		// 	$recipe->categories()->attach(
		// 		$categories->random(rand(1, 4))
		// 		->pluck('id')
		// 		->toArray()
		// 	);
		// });
	}
}
