<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds
     * @return void
     */
    public function run()
    {
        $this->call(RolesSeeder::class);
        $this->call(CategoriesSeeder::class);
        $this->call(VisitorSeeder::class);
        $this->call(RecipeSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(DocumentsSeeder::class);
        $this->call(MealSeeder::class);
        $this->call(HelpCategoriesSeeder::class);
        $this->call(HelpSeeder::class);
    }
}
