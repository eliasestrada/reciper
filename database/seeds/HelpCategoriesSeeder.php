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
                'icon' => 'portrait',
                'title_ru' => 'Страница',
                'title_en' => 'Profile',
            ],
            [
                'icon' => 'star',
                'title_ru' => 'Общие вопросы',
                'title_en' => 'General Questions',
            ],
        ]);
    }
}
