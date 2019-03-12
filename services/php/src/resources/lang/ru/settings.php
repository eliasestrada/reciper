<?php

return [

    // Controller
    'saved' => 'Настройки сохранены',
    'pwd_wrong' => 'Неверный пароль',
    'footer_text_max' => 'Текст не должен быть не более :max символов',
    'photo_deleted' => 'Фото успешно удалено',
    'saved_now_verify_email' => 'Эл. адрес сохранен. Для того чтобы подтвердить этот эл. адрес, мы отправили сообщение на вашу эл. почту с кодом подтверждения',
    'email_is_empty' => 'Поле Эл. адрес очищено',
    'email_verified' => 'Эл адрес успешно подтвержден',

    // Views
    'general' => 'Общее',
    'general_desc' => 'Изменить имя, пароль или статус',
    'photo' => 'Фотография',
    'photo_desc' => 'Поменять фотографию страницы',
    'password' => 'Пароль',
    'settings' => 'Настройки',
    'status' => 'Статус',
    'settings_photo' => 'Настройки фото',
    'choose_photo' => 'Здесь вы можете выбрать фото, которое будет отображаться на вашей странице и во всех ваших рецептах. Для этого наведите на фото и нажмите кнопку ":btn1" чтобы выбрать файл, затем нажмите кнопку ":btn2" для сохранения.',
    'reciper_name' => 'Имя ресипёра',
    'there_are_no_file' => 'Для начала выберите файл',
    'delete_account' => 'Удалить страницу',
    'delete_account_desc' => 'Для подтверждения удаления страницы, введите ваш текущий пароль и нажмите удалить. Ваша страница будет деактивирована без потери данных. Вы можете восстановить доступ к странице в течении 7-ми дней после момента удаления. По истечению срока ваша страница будет удаленна безвозвратно.',
    'are_you_sure_to_deactivate' => 'Нам будет вас не хватать 😢 Вы точно хотите деактивировать страницу?',
    'email_change_once_per_week' => 'Эл. адрес можно менять только раз в неделю',
    'verified' => '<i class="fas fa-check"></i> Эл. адрес подтвержден!',
    'not_verified' => '<i class="fas fa-times"></i> Эл. адрес не подтвержден!',

    'token_required' => 'Токен верификации не обнаружен',

    // Validation Photo
    'photo_image' => 'Файл не является изображением',
    'photo_max' => 'Изображение не должно превышать :max Кбайт',
    'photo_uploaded' => 'Загрузка не удалась, возможно это связано с большим расширением, изображение не должно превышать 1999 Кбайт',
    'photo_mimes' => 'Изображение дожно быть только в форматах :values',

    // Validation General
    'name_min' => 'Имя должно быть хотя бы :min символов',
    'name_max' => 'Имя не должно превышать :max символов',
    'about_me_max' => 'Поле "Обо мне" не должно превышать :max символов',

    // Validation Password
    'old_pwd_required' => 'Старый пароль обязателен к заполнению',
    'old_pwd_string' => 'Старый пароль должен быть строкой',
    'pwd_required' => 'Пароль обязателен к заполнению',
    'pwd_string' => 'Пароль должен быть строкой',
    'pwd_min' => 'Пароль должен иметь хотя бы :min символов',
    'pwd_max' => 'Пароль должен иметь не более :max символов',
    'pwd_confirmed' => 'Пароли не совпадают',

    // Validation Email
    'email_max' => 'Эл. адрес не должен превышать :max символов',
    'email_email' => 'Эл. адрес должен иметь правельный формат',
    'email_unique' => 'Пользователь с таким эл. адресом уже существует',

];