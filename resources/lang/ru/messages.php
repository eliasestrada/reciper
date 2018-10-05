<?php

return [

    // Views
    'yes' => 'Да',
    'no' => 'Нет',
    'go' => 'Перейти',
    'help' => 'Помощь',
    'back' => 'Назад',
    'app_name' => 'Ресипёр',
    'no_messages' => 'Нет сообщений',
    'favs' => 'Избранное',
    'agree' => 'Согласен',
    'download' => 'Скачать',
    'open' => 'Открыть',
    'edit' => 'Изменить',
    'published' => 'Опубликованные',
    'drafts' => 'Черновики',
    'sent' => 'Отправлено',
    'message' => 'Сообщение',
    'sender' => 'Отправитель',
    'in_english' => 'На английском',
    'in_russian' => 'На русском',
    'general' => 'Общая',

    // Artisan controller
    'cache_deleted' => 'Настройки кеша удалены!',
    'cache_saved' => 'Настройки кеша сохранены!',

    // Titles Validation
    'title_max' => 'Заголовок должен быть не более :max символов',
    'text_max' => 'Текст должен быть не более :max символов',

    'access_denied_only_auth' => 'Чтобы перейти на эту страницу, нужно зайти на сайт',
    'access_denied_only_admin' => 'Доступ к странице на которую вы пытались перейти разрешен только пользователям с правами администратора',
    'access_denied_only_master' => 'Доступ к странице на которую вы пытались перейти разрешен только пользователям с правами супер администратора',
    'fail_connection' => 'Доступ к странице которую вы пытаетесь перейти, невозможен из за технических неполадок ',
    'login_to_add_recipe' => 'Для того чтобы добавить рецепт вы должны быть авторизованы. Пожалуйста <a href="' . \URL::to('/login') . '">Войдите</a> на свою страницу, либо <a href="' . \URL::to('/register') . '">Зарегистрируйтесь</a>.',

];
