<?php

use App\Models\Help;
use Illuminate\Database\Seeder;

class HelpSeeder extends Seeder
{
    public function run()
    {
        Help::insert([
            [
                'id' => 1,
                'help_category_id' => 1,
                'title_ru' => 'Как изменить пароль?',
                'text_ru' => 'Вы можете изменить пароль в общих настройках страницы: <a href="' . \URL::to('/settings/general/edit') . '">reciper.tk/settings/general/edit</a>.',
                'title_en' => 'How to change password?',
                'text_en' => 'You can change password on general settings page: <a href="' . \URL::to('/settings/general/edit') . '">reciper.tk/settings/general/edit</a>.',
            ],
            [
                'id' => 2,
                'help_category_id' => 1,
                'title_ru' => 'Как изменить фотографию?',
                'text_ru' => 'Изменить фотографию можно в настройках фотографиии: <a href="' . \URL::to('/settings/photo/edit') . '">reciper.tk/settings/photo/edit</a>.',
                'title_en' => 'How to change profile picture?',
                'text_en' => 'You can change your profile picture on photo settings page: <a href="' . \URL::to('/settings/photo/edit') . '">reciper.tk/settings/photo/edit</a>.',
            ],
            [
                'id' => 3,
                'help_category_id' => 2,
                'title_ru' => 'Как написать в службу Поддержки?',
                'text_ru' => 'Пожалуйста воспользуйтесь ссылкой в самом низу страницы с надписью "Связь с нами", либо перейдите по этой ссылке: <a href="' . \URL::to('/contact') . '">reciper.tk/contact</a>. Для того чтобы написать нам, достаточно заполнить форму которая будет доступна по данному адресу.<br> Хотим предупредить что отправлять можно только одно сообщение в день.',
                'title_en' => 'How to send a message to Support?',
                'text_en' => 'Please, use the link at the bottom of every page with the name: "Contact us", or you can also click on this link: <a href="' . \URL::to('/contact') . '">reciper.tk/contact</a>. In order to send us a message you can just fill in the given form which is available on this address.<br> We want to warn you that you can send only one message per day.',
            ],
            [
                'id' => 4,
                'help_category_id' => 2,
                'title_ru' => 'Какие преймущества дает зарегистрация?',
                'text_ru' => 'После регистрации вы присойденяетесь к сообществу Ресипёров и у вас появляется удобный и быстрый доступ к своей личной странице, на которой у вас есть возможность писать свои собственные рецепты, и по желанию публиковать их для всех посетителей. Каждый ресипёр получает очки опыта за публикацию рецепта, за лайки которые рецепт получает от посетителей а также за колличество гостей которые посетили страницу рецепта. Подробно о раcпределении очков опыта можно прочитать на странице: <a href="' . \URL::to('/help/6') . '">"Как распределяются очки опыта?"</a>.<br><br>Преймущества в публикации рецепта - это возможность наблюдать статистику развития популярности вашего рецепта и набирать свою популярность. У вас есть возможность заполнить секцию "Обо мне" на странице: <a href="' . \URL::to('/settings/general') . '">"Общие настройки"</a> где вы можете указать любую информацию о себе, например ссылку на ваш блог или социальные сети.<br><br>Одним немаловажным преймуществом быть опытным ресипёром это попадание в список топ-10 ресиперов который находится в правом нижнем углу на каждой странице. Список обновляется каждый час, и видим для всех без исключения посетителей.',
                'title_en' => '',
                'text_en' => '',
            ],
            [
                'id' => 5,
                'help_category_id' => 2,
                'title_ru' => 'Как зарегистрироваться?',
                'text_ru' => 'Зарегистрироваться можно по этой ссылке: <a href="' . \URL::to('/register') . '">reciper.tk/register</a>, либо в меню навигации нажать на кнопку "Войти <i class="material-icons tiny">exit_to_app</i>" затем под формой нажмите на "Регистрация".<br> Заполните форму регистрации и нажмите кнопку "Регистрация" для завершения процесса.',
                'title_en' => 'How to register?',
                'text_en' => 'You can register going by this link: <a href="' . \URL::to('/register') . '">reciper.tk/register</a>, or you can press button "Sign in <i class="material-icons tiny">exit_to_app</i>" on navigation bar, and under the form press "Register".<br> Fill in register form and press "Register" button to finish the process.',
            ],
            [
                'id' => 6,
                'help_category_id' => 3,
                'title_ru' => 'Как распределяются очки опыта?',
                'text_ru' => 'Информацию о распределении очков опыта можно увидеть наведя курсором на иконку трофея под фотографией на вашей странице. ',
                'title_en' => 'How are experience points distributed?',
                'text_en' => '',
            ],
            // [
            //     'id' => 7,
            //     'help_category_id' => 1,
            //     'title_ru' => '',
            //     'text_ru' => '',
            //     'title_en' => '',
            //     'text_en' => '',
            // ],
            // [
            //     'id' => 8,
            //     'help_category_id' => 1,
            //     'title_ru' => '',
            //     'text_ru' => '',
            //     'title_en' => '',
            //     'text_en' => '',
            // ],
            // [
            //     'id' => 9,
            //     'help_category_id' => 1,
            //     'title_ru' => '',
            //     'text_ru' => '',
            //     'title_en' => '',
            //     'text_en' => '',
            // ],
            // [
            //     'id' => 10,
            //     'help_category_id' => 1,
            //     'title_ru' => '',
            //     'text_ru' => '',
            //     'title_en' => '',
            //     'text_en' => '',
            // ],
            // [
            //     'id' => 11,
            //     'help_category_id' => 1,
            //     'title_ru' => '',
            //     'text_ru' => '',
            //     'title_en' => '',
            //     'text_en' => '',
            // ],
            // [
            //     'id' => 12,
            //     'help_category_id' => 1,
            //     'title_ru' => '',
            //     'text_ru' => '',
            //     'title_en' => '',
            //     'text_en' => '',
            // ],
            // [
            //     'id' => 13,
            //     'help_category_id' => 1,
            //     'title_ru' => '',
            //     'text_ru' => '',
            //     'title_en' => '',
            //     'text_en' => '',
            // ],
            // [
            //     'id' => 14,
            //     'help_category_id' => 1,
            //     'title_ru' => '',
            //     'text_ru' => '',
            //     'title_en' => '',
            //     'text_en' => '',
            // ],
        ]);
        // <a href="' . \URL::to('/contact') . '">reciper.tk/contact</a>
    }
}
