<?php

use App\Models\Document;

$factory->define(Document::class, function () {
    return [
        'title_ru' => 'Назввние ' . rand(),
        'title_en' => 'Title' . rand(),
        'text_ru' => 'Настоящее Пользовательское Соглашение (далее "Соглашение") регулирует отношения между владельцем reciper.tk (далее "Ресипёр", "Администрация" или "Сайт") с одной стороны и Вами (далее "Пользователь") с другой',
        'text_en' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eum reprehenderit impedit dolorem perspiciatis quam mollitia hic! Ipsa omnis similique, asperiores ut officia eos amet accusamus ducimus',
        'ready_ru' => 1,
        'ready_en' => 1,
    ];
});

$factory->state(Document::class, 'draft', [
    'ready_en' => 0,
    'ready_ru' => 0,
]);
