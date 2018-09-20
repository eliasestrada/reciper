<?php

use App\Models\Help;
use Illuminate\Database\Seeder;

class HelpSeeder extends Seeder
{
    public function run()
    {
        Help::insert([
            [
                'help_category_id' => 1,
                'title_ru' => 'Как изменить пароль?',
                'title_en' => 'How to change password?',
                'text_ru' => 'Вы можете изменить пароль в общих настройках страницы: <a href="' . \URL::to('/settings/general') . '">reciper.tk/settings/general</a>.',
                'text_en' => '',
            ],
        ]);
    }
}
