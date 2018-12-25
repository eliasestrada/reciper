<?php

use App\Models\HelpCategory;
use Illuminate\Database\Seeder;

class HelpCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        HelpCategory::insert([
            [
                'id' => 1,
                'icon' => 'fa-user-circle',
                'title_ru' => 'Страница',
                'title_en' => 'Profile',
            ],
            [
                'id' => 2,
                'icon' => 'fa-comment-dots',
                'title_ru' => 'Общие вопросы',
                'title_en' => 'General Questions',
            ],
            [
                'id' => 3,
                'icon' => 'fa-book-open',
                'title_ru' => 'Рецепты',
                'title_en' => 'Recipes',
            ],
        ]);
    }
}
