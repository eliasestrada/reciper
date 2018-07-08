<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$this->call(CategoriesTableSeeder::class);
        $this->call(TitleSeeder::class);
		$this->call(UsersSeeder::class);
		$this->call(RecipesSeeder::class);
		$this->call(MealSeeder::class);
		$this->call(DocumentsSeeder::class);
    }
}