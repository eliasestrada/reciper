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
                'title_ru' => 'Какие преимущества дает зарегистрация?',
                'text_ru' => 'После регистрации вы присойденяетесь к сообществу Ресипёров и у вас появляется удобный и быстрый доступ к своей личной странице, на которой у вас есть возможность писать свои собственные рецепты, и по желанию публиковать их для всех посетителей. Каждый ресипёр получает очки опыта за публикацию рецепта, за лайки которые рецепт получает от посетителей а также за количество гостей которые посетили страницу рецепта. Подробно о раcпределении очков опыта можно прочитать на странице: <a href="' . \URL::to('/help/6') . '">"Как распределяются очки опыта?"</a>.<br><br>Преимущества в публикации рецепта - это возможность наблюдать статистику развития популярности вашего рецепта и набирать свою популярность. У вас есть возможность заполнить секцию "Обо мне" на странице: <a href="' . \URL::to('/settings/general') . '">"Общие настройки"</a> где вы можете указать любую информацию о себе, например ссылку на ваш блог или социальные сети.<br><br>Одним немаловажным преимуществом быть опытным ресипёром это попадание в список топ-10 ресиперов который находится в правом нижнем углу на каждой странице. Список обновляется каждый час, и видим для всех без исключения посетителей.',
                'title_en' => 'What are the benefits of registering?',
                'text_en' => 'After registration, you join the Reciper community and you have convenient and quick access to your personal page, where you have the opportunity to write your own recipes, and, if desired, publish them for all visitors. Each reciper gets experience points for the publication of the recipe, for the likes that the recipe receives from visitors and also for the number of guests who visited the recipe page. Details on the distribution of experience points can be found on the page: <a href="' . \URL::to('/help/6') . '"> "How are experience points distributed?" </a>. <br> < br> Advantages in the publication of the recipe is an opportunity to observe the statistics of the development of the popularity of your recipe and gain your popularity. You have the option to fill out the section "About Me" on the page: <a href="' . \URL::to('/settings/general') . '"> "General Settings" </a> where you can specify any information about yourself, for example, a link to your blog or social media. <br> <br> One important advantage of being an experienced reciper is getting to the top 10 recipers that is in the lower right corner on each page. The list is updated every hour, and visible to all visitors without exception.',
            ],
            [
                'id' => 5,
                'help_category_id' => 2,
                'title_ru' => 'Как зарегистрироваться?',
                'text_ru' => 'Зарегистрироваться можно по этой ссылке: <a href="' . \URL::to('/register') . '">reciper.tk/register</a>, либо в меню навигации нажать на кнопку "Войти <i class="fas fa-sign-in-alt tiny"></i>" затем закладку "Регистрация".<br> Заполните форму регистрации и нажмите кнопку "Регистрация" для завершения процесса.',
                'title_en' => 'How to register?',
                'text_en' => 'You can register going by this link: <a href="' . \URL::to('/register') . '">reciper.tk/register</a>, or you can press button "Sign in <i class="fas fa-sign-in-alt tiny"></i>" on navigation bar, then "Register" tab.<br> Fill in register form and press "Register" button to finish the process.',
            ],
            [
                'id' => 6,
                'help_category_id' => 3,
                'title_ru' => 'Как распределяются очки опыта?',
                'text_ru' => 'Информацию о распределении очков опыта можно увидеть наведя курсором на иконку награды <i class="fas fa-award red-text"></i> под фотографией на вашей странице.<br>Опыт составляется с нижеперечисленных данных:<br>1 лайк = ' . config('custom.exp_for_like') . ' очков опыта<br>1 просмотр = ' . config('custom.exp_for_like') . ' очков опыта<br>1 опубликованный рецепт = ' . config('custom.exp_for_like') . ' очков опыта',
                'title_en' => 'How are experience points distributed?',
                'text_en' => 'Information about distributing experience points can be seen by hovering over the trophy icon under the profile image on your page.<br> That is how experience points are distributed:<br>1 like = ' . config('custom.exp_for_like') . ' experience points<br>1 view = ' . config('custom.exp_for_like') . ' experience points<br>1 published recipe = ' . config('custom.exp_for_like') . ' experience points',
            ],
            [
                'id' => 7,
                'help_category_id' => 2,
                'title_ru' => 'Почему любимые рецепты не отображаются на другом устройстве?',
                'text_ru' => 'Все рецепты которым вы подарили сердечко остаются отмеченными для вас, для того чтобы иметь быстрый доступ к ним в любое время. Все подаренные сердца привязаны к вашему устройству, поэтому при смене устройства вы не обнаружите их в списке <a href="' . \URL::to('/recipes#my_likes') . '">Любимые</a> рецепты. Если это вам составляет неудобство, сообщите нам, отправив нам сообщение <a href="' . \URL::to('/contact') . '"> reciper.tk/contact </a>.',
                'title_en' => 'Why favorite questions are not visible on other devices?',
                'text_en' => 'All the recipes which you have liked are always accessible for you anytime, in order to have quick access to them at any time. All given likes are attached to your device, so when you change the device, you will not find them in the list <a href="' . \URL::to('/recipes#my_likes') . '">Favorite</a> recipes. If it is inconvenient for you, let us know by sending us a message <a href="' . \URL::to('/contact') . '">reciper.tk/contact</a>.',
            ],
            // [
            //     'id' => 8,
            //     'help_category_id' => 3,
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
