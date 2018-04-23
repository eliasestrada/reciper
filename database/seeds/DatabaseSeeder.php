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
        $this->call(TitlesSeeder::class);
		$this->call(CategoriesTableSeeder::class);
		$this->call(UsersSeeder::class);
		$this->call(RecipesSeeder::class);
		$this->call(NotificationSeeder::class);
    }
}