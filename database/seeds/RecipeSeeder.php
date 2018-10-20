<?php

use App\Models\Recipe;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run()
    {
        factory(Recipe::class)->create();
    }
}
