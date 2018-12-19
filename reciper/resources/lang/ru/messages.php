<?php

return [

    // Views
    'yes' => 'Да',
    'no' => 'Нет',
    'on' => 'вкл.',
    'off' => 'откл.',
    'go' => 'Перейти',
    'back' => 'Назад',
    'app_name' => 'Ресипёр',
    'no_messages' => 'Нет сообщений',
    'dark_mode' => 'Ночной режим',
    'download' => 'Скачать',
    'print' => 'Печать',
    'open' => 'Открыть',
    'edit' => 'Изменить',
    'published' => 'Опубликованные',
    'drafts' => 'Черновики',
    'sent' => 'Отправлено',
    'message' => 'Сообщение',
    'sender' => 'Отправитель',
    'in_english' => 'На английском',
    'u_need_to_login' => 'Вам нужно авторизоваться',
    'email_confirmation' => 'Подтверждение эл. адреса',
    'confirm_email_message' => 'Для того чтобы подтвердить адрес эл. почты на ' . config('app.name') . ' нажмите на кнопку ниже',
    'in_russian' => 'На русском',
    'mail_footer' => 'С уважением комманда ' . config('app.name'),
    'general' => 'Общая',
    'favorites' => 'Избранное',
    'login_to_add_recipe' => 'Для того чтобы добавить рецепт вы должны быть авторизованы. Пожалуйста <a href="' . url('/login') . '" class="red-text">Войдите</a> на свою страницу, либо <a href="' . url('/register') . '" class="red-text">Зарегистрируйтесь</a>.',
    'sure_to_logout' => 'Вы точно хотите выйти с вашей страницы?',
    'adminka' => 'Админка',

    // Artisan controller
    'cache_deleted' => 'Настройки кеша удалены!',
    'cache_saved' => 'Настройки кеша сохранены!',

    // Errors
    'query_error' => 'Некоторые данные невозможно отобразить',

    // Other
    'congrats_streak_days' => '<i class="fas fa-fire left" style="color:orangered"></i> + :xp опыта за ударный режим',

    // Trash
    'trash' => 'Корзина',
    'restore' => 'Восстановить',
    'deleted' => 'Удалено',
    'trash_is_empty' => 'Корзина пуста',
    'not_allowed' => 'Данный материал не может быть удален, не хватает параметра table',
    'trash_deleted' => 'Удалено с корзины',
    'trash_restored' => 'Материал восстановлен',
    'sure_to_delete_trash' => 'Вы уверены что хотите удалить этот материал? Его невозможно будет восстановить после удаления.',
    'sure_to_restore' => 'Вы уверены что хотите восстановить этот материал?',

];
