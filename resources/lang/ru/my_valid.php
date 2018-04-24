<?php

return [

	// Recipes validation
	'recipe_min' => 'Название рецепта не должно быть менее :min символов',
	'recipe_title_max' => 'Название рецепта не должно быть более :max символов',
	'recipe_intro_max' => 'Краткое описание не должно быть менее :max символов',
	'recipe_intro_max' => 'Краткое описание не должно быть не более :max символов',
	'recipe_ingredients_min' => 'Колличество символов в поле ингридиенты не должно быть менее :min символов',
	'recipe_ingredients_max' => 'Колличество символов в поле ингридиенты не должно быть не более :max символов',
	'recipe_advice_max' => 'Колличество символов в поле совет не должно быть не более :max символов',
	'recipe_text_min' => 'Колличество символов в поле приготовление не должно быть менее :min символов',
	'recipe_text_max' => 'Колличество символов в поле приготовление не должно быть более :max символов',
	'recipe_time_numeric' => 'Время должно быть числом',
	'recipe_digits_between' => 'Время должно быть числом между :min и :max',
	'recipe_image_image' => 'Изображение должно быть файлом изображения JPG',
	'recipe_image_max' => 'Максимальный допустимый обьем изображения :max кбайт',
	
	// Settings image validation
	'settings_image_image' => 'Файл не является изображением',
	'settings_image_max' => 'Изображение не должно превышать :max Кбайт',
	'settings_image_uploaded' => 'Загрузка не удалась, возможно это связано с большим разширением, изображение не должно превышать 1999 Кбайт',

	// Settings title validation
	'settings_title_max' => 'Заголовок должен быть не более :max символов',
	'settings_text_max'  => 'Текст должен быть не более :max символов',

	// Settings name validation
	'settings_name_required'  => 'Поле имя обязателено к заполнению',
	'settings_name_min'  => 'Имя должно быть хотябы :min символов',
	'settings_name_max'  => 'Имя не должно превышать :max символов',

	// Settings password validation
	'settings_pwd_required'  => 'Старый пароль обязателен к заполнению',
	'settings_new_pwd_required'  => 'Новый пароль обязателен к заполнению',
	'settings_pwd_min'  => 'Пароль должен иметь хотябы :min символов',
	'settings_pwd_confirmed'  => 'Пароли не совпадают',

	// Contact form validation
	'contact_name_required'  => 'Поле имя обязательно к заполнению',
	'contact_email_required'  => 'Поле эл. адрес обязательно к заполнению',
	'contact_message_required'  => 'Поле сообщение обязательно к заполнению',
	'contact_email_email'  => 'Эл. адрес должен быть правильным адресом',
	'contact_message_min'  => 'Сообщение слишком короткое. Должно быть не меньше :min символов',
	'contact_message_max'  => 'Сообщение слишком длинное. Должно быть не более :max символов',

];