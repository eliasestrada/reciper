<?php

use App\Models\Title;
use Illuminate\Database\Seeder;

class TitleSeeder extends Seeder
{
    /**
     * Run the database seeds
     * @return void
     */
    public function run()
    {
        Title::create([
            'name' => 'footer',
            'title_ru' => '',
            'text_ru' => 'При копировании любых материалов с сайта активная ссылка на сайт reciper.tk обязательна.',
        ]);
    }
}
