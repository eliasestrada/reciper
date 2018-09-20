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
                'text_en' => 'You can change password on general settings page: <a href="' . \URL::to('/settings/general') . '">reciper.tk/settings/general</a>.',
            ],
            [
                'help_category_id' => 1,
                'title_ru' => 'Как изменить фотографию?',
                'title_en' => 'How to change profile picture?',
                'text_ru' => 'Изменить фотографию можно в настройках фотографиии: <a href="' . \URL::to('/settings/photo') . '">reciper.tk/settings/photo</a>.',
                'text_en' => 'You can change your profile picture on photo settings page: <a href="' . \URL::to('/settings/photo') . '">reciper.tk/settings/photo</a>.',
            ],
            [
                'help_category_id' => 2,
                'title_ru' => 'Как написать в службу Поддержки?',
                'title_en' => 'How to send a message to Support?',
                'text_ru' => 'Пожалуйста воспользуйтесь ссылкой в самом низу страницы с надписью "Связь с нами", либо перейдите по этой ссылке: <a href="' . \URL::to('/contact') . '">reciper.tk/contact</a>. Для того чтобы написать нам, достаточно заполнить форму которая будет доступна по данному адресу.<br> Хотим предупредить что отправлять можно только одно сообщение в день.',
                'text_en' => 'Please, use the link at the bottom of every page with the name: "Contact us", or you can also click on this link: <a href="' . \URL::to('/contact') . '">reciper.tk/contact</a>. In order to send us a message you can just fill in the given form which is available on this address.<br> We want to warn you that you can send only one message per day.',
            ],
            // [
            //     'help_category_id' => 2,
            //     'title_ru' => 'Какие преймущества дает зарегистрация?',
            //     'title_en' => '',
            //     'text_ru' => '',
            //     'text_en' => '',
            // ],
            [
                'help_category_id' => 2,
                'title_ru' => 'Как зарегистрироваться?',
                'title_en' => 'How to register?',
                'text_ru' => 'Зарегистрироваться можно по этой ссылке: <a href="' . \URL::to('/register') . '">reciper.tk/register</a>, либо в меню навигации нажать на кнопку "Войти <i class="material-icons tiny">exit_to_app</i>" затем под формой нажмите на "Регистрация".<br> Заполните форму регистрации и нажмите кнопку "Регистрация" для завершения процесса.',
                'text_en' => 'You can register going by this link: <a href="' . \URL::to('/register') . '">reciper.tk/register</a>, or you can press button "Sign in <i class="material-icons tiny">exit_to_app</i>" on navigation bar, and under the form press "Register".<br> Fill in register form and press "Register" button to finish the process.',
            ],
            // [
            //     'help_category_id' => 1,
            //     'title_ru' => '',
            //     'title_en' => '',
            //     'text_ru' => '',
            //     'text_en' => '',
            // ],
        ]);
        // <a href="' . \URL::to('/contact') . '">reciper.tk/contact</a>
    }
}
