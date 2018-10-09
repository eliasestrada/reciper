<?php

use App\Helpers\Xp;
use App\Models\Help;
use Illuminate\Database\Seeder;

class HelpSeeder extends Seeder
{
    public function run()
    {
        $xp = new Xp(1);
        $xp_table = '';

        foreach ($xp->levels as $i => $level) {
            $xp_table .= "
                <tr>
                    <td>$i</td>
                    <td>{$level['min']}</td>
                    <td>{$level['max']}</td>
                </tr>
            ";
        }

        Help::insert([
            [
                'id' => 1,
                'help_category_id' => 1,
                'title_ru' => 'Как изменить пароль?',
                'text_ru' => 'Вы можете изменить пароль в общих настройках страницы: ' . help_link('reciper.tk/settings/general/edit', '/settings/general/edit') . '. Либо перейдите в Меню > Настройки > Пароль.',
            ],
            [
                'id' => 2,
                'help_category_id' => 1,
                'title_ru' => 'Как изменить фотографию?',
                'text_ru' => 'Изменить фотографию можно в настройках фотографии: ' . help_link('reciper.tk/settings/photo/edit', '/settings/photo/edit') . '. Либо перейдите в Меню > Настройки > Фотография.',
            ],
            [
                'id' => 3,
                'help_category_id' => 2,
                'title_ru' => 'Как написать в службу Поддержки?',
                'text_ru' => 'Пожалуйста воспользуйтесь ссылкой в самом низу страницы с надписью <i class="fas fa-envelope grey-text"></i> Связь с нами, либо перейдите по этой ссылке: ' . help_link('reciper.tk/contact', '/contact') . '. Для того чтобы написать нам, достаточно заполнить форму которая будет доступна по данному адресу.<br> Хотим предупредить что отправлять можно только одно сообщение в день.',
            ],
            [
                'id' => 4,
                'help_category_id' => 2,
                'title_ru' => 'Какие преимущества дает регистрация?',
                'text_ru' => 'После регистрации вы присойденяетесь к сообществу Ресипёров и у вас появляется удобный и быстрый доступ к своей личной странице, на которой у вас есть возможность писать свои собственные рецепты, и по желанию публиковать их для всех посетителей. Каждый ресипёр получает ' . help_link('очки опыта', 9) . ' за публикации рецептов, и ' . help_link('очки популярности', 6) . ' за лайки, просмотры и звёзды..<br><br>Преимущества в публикации рецепта - это возможность наблюдать ' . help_link('статистику', '/statistics') . ' развития популярности вашего рецепта и набирать свою популярность. У вас есть возможность заполнить секцию ' . help_link('Обо мне', '/settings/general') . ', где вы можете указать любую информацию о себе, например ссылку на ваш блог или социальные сети.<br><br>Одним немаловажным преимуществом быть опытным ресипёром это попадание в список топ-10 ресиперов который находится в правом нижнем углу на каждой странице. Список обновляется каждый час, и видим для всех без исключения посетителей.',
            ],
            [
                'id' => 5,
                'help_category_id' => 2,
                'title_ru' => 'Как зарегистрироваться?',
                'text_ru' => 'Зарегистрироваться можно по этой ссылке: ' . help_link('reciper.tk/register', '/register') . ', либо в меню навигации нажать на кнопку Войти <i class="fas fa-sign-in-alt main-text tiny"></i> затем закладку "Регистрация".<br> Заполните форму регистрации и нажмите кнопку <b>Регистрация</b> для завершения процесса.',
            ],
            [
                'id' => 6,
                'help_category_id' => 1,
                'title_ru' => 'Очки популярности.',
                'text_ru' => 'Очки популярности приобретаются когда ваши публикации нравятся посетителям. За каждое действие в адрес вашей публикации вы получаете очки популярности. Информацию о распределении очков популярности можно увидеть наведя курсором на иконку <i class="fas fa-crown main-text"></i> на вашей странице.<br>Популярность составляется с нижеперечисленных данных:<br><br>1 сердечко = ' . config('custom.popularity_for_like') . ' очков<br>1 просмотр = ' . config('custom.popularity_for_view') . ' очков<br>1 добавление в избранные = ' . config('custom.popularity_for_favs') . ' очко',
            ],
            [
                'id' => 7,
                'help_category_id' => 2,
                'title_ru' => 'Почему любимые рецепты не отображаются на другом устройстве?',
                'text_ru' => 'Все рецепты которым вы подарили сердечко остаются отмеченными для вас, для того чтобы иметь быстрый доступ к ним в любое время. Все подаренные сердца привязаны к вашему устройству, поэтому при смене устройства вы не обнаружите их в списке ' . help_link('Любимые', '/recipes#my_likes') . ' рецепты. Для того чтобы рецепты отображались на всех устройствах вам необходимо добавлять рецепты в "Избранное" нажимая на звёздочку <i class="fas fa-star grey-text"></i>. Добавлять рецепты в "Избранное" могут только зарегистрированные пользователи. Зарегистрироваться можно по этой ссылке: ' . help_link('reciper.tk/register', '/register'),
            ],
            [
                'id' => 8,
                'help_category_id' => 3,
                'title_ru' => 'Как отбираются простые рецепты?',
                'text_ru' => '<b>Быстрый ответ:</b> Время приготовления должно быть не больше <b>60-ти</b> минут и количество ингредиентов в сумме с количеством шагов  приготовления не должно превышать <b>10</b><br><br><b>Подробный ответ:</b> Среди всех рецептов ресипёров мы отбираем самые простые в приготовлении, и добавляем их в категорию "Простые".<br>Для того чтобы рецепт попал в эту категорию, мы делаем не сложный подсчет количества ингредиентов в рецепте, количества шагов которое читателю предстоит сделать для приготовления блюда, время приготовления блюда, и получаем результат.<br>К примеру, у нас рецепт, в котором <b class="red-text">5</b> ингредиентов, процесс приготовления состоит из <b class="red-text">4</b> шагов а время приготовления <b class="red-text">50</b> минут. При сложении ингредиентов и шагов итоговое число <b class="red-text">9</b>.<br>Если итоговое число <b>меньше 10-ти</b> и время приготовления <b>не больше одного часа</b>, то рецепт отбирается в категорию простые рецепты.<br>В нашем примере у нас итоговое число <b class="red-text">9</b>, девять меньше десяти, значит рецепт простой, тем более время приготовления всего 50 минут. Вот если бы время было больше 60 минут, то рецепт бы никогда не попал в список простых в приготовлении.',
            ],
            [
                'id' => 9,
                'help_category_id' => 1,
                'title_ru' => 'Опыт и ударный режим.',
                'text_ru' => 'Каждый активный ресипёр в течении времени приобретает опыт в виде очков. Опыт начисляется каждый день в разных количествах, в зависимости частоты посещений и опубликованных вами материалов. Также немаловажным фактором на приобретение опыта является Ударный режим, на который влияет периодичность с которой вы посещаете сайт. Если вы посетили сайт на следующий день, это 1 день ударного режима, если еще на следующий, то это 2 дня в ударном режиме и т.д. Если же вы придерживались ударного режима, но по какой-то причине не смогли посетить сайт, то ударный режим обнуляется.<br><br><b>Подробная информация об опыте и его начислении:</b><br><b class="red-text">' . config('custom.xp_for_approve') . '</b> опыта за добавление материала<br><b class="red-text">X</b> опыта за X дней в ударном режиме<br><br><b>Начисление опыта за ударный режим</b><br>Всё очень просто. За 1 день в ударном режиме вы получаете 1 к опыту, за 2 дня - 2 к опыту, за 3 дня - 3 к опыту и т.д. Максимальное количество опыта которое можно получить от ударного режима <b class="red-text">30</b>, на 30-ты день ударного режима. Это значит что во все последующие дни вы будете получать 30 очков опыта каждый день в ударном режиме.<br>Количество дней в ударном режиме отображаются на Вашей странице в виде иконки с номером: <i class="fas fa-fire fa-15x" style="color:orangered"></i> <b>12</b>',
            ],
            [
                'id' => 10,
                'help_category_id' => 1,
                'title_ru' => 'Уровни.',
                'text_ru' => '<div class="row"><div class="col s12 m6 l6 pb-3">На старте после регистрации каждый ресипёр имеет первый уровень и нулевое количество опыта. Для освоения нового уровня ресипёру необходимо набрать определенное количество опыта. Как набирать опыт вы можете прочитать на странице ' . help_link('Опыт и ударный режим.', 9) . '.<br><br>Предел опыта который можно набрать - ' . $xp->levels[10]['max'] . '. Именно на этом количестве опыта ресипёр получает 10-тый уровень, который является максимальным.</div><div class="col s12 m6 l6"><b>Таблица уровней и опыта:</b><br>

                <table class="responsive highlight" style="max-width:400px">
                    <thead>
                        <tr class="main-light">
                            <td>Уровень</td>
                            <td>Мин. опыта</td>
                            <td>Макс. опыта</td>
                        </tr>
                    </thead>
                    <tbody>
                        ' . $xp_table . '
                    </tbody>
                </table></div></div>',
            ],
            // // [
            //     'id' => 11,
            //     'help_category_id' => 1,
            //     'title_ru' => '',
            //     'text_ru' => '',
            // ],
            // [
            //     'id' => 12,
            //     'help_category_id' => 1,
            //     'title_ru' => '',
            //     'text_ru' => '',
            // ],
            // [
            //     'id' => 13,
            //     'help_category_id' => 1,
            //     'title_ru' => '',
            //     'text_ru' => '',
            // ],
            // [
            //     'id' => 14,
            //     'help_category_id' => 1,
            //     'title_ru' => '',
            //     'text_ru' => '',
            // ],
        ]);
        //  ' . help_link('', '') . '
    }
}
