<?php

return [

    // Controller
    'no_rights_to_see' => 'У вас нет права просматривать этот рецепт, так как он еще не опубликован',
    'not_written' => 'Этот рецепт находится в процессе написания',
    'not_approved' => 'Этот рецепт еще не одобрен',
    'no_rights_to_edit' => 'Вы не можете редактировать не свои рецепты',
    'recipe_published' => 'Рецепт опубликован и доступен для посетителей',
    'added_to_approving' => 'Рецепт добавлен на рассмотрение и будет опубликован после одобрения администрацией',
    'saved' => 'Рецепт сохранен в черновики',
    'you_gave_recipe_back_on_editing' => 'Вы вернули рецепт на повторное редактирование',
    'deleted_fail' => 'Произошла ошибка во время удаления рецепта',

    // Views
    'add_recipe' => 'Добавление рецепта',
    'popular' => 'Популярные',
    'new' => 'Новые',
    'next' => 'Далее',
    'watched' => 'Просматриваемые',
    'title' => 'Название',
    'name_for_recipe' => 'Укажите название рецепта',
    'min' => 'мин',
    'go' => 'Перейти',
    'intro' => 'Описание',
    'categories_title' => 'Категории',
    'short_intro' => 'Краткое описание рецепта',
    'search_by_author' => 'Показать все рецепты этого автора',
    'ingredients' => 'Ингридиенты',
    'ingredients_desc' => 'Все ингридиенты рецепта. После каждого ингридиента нажимайте кнопку Ввод (Enter) чтобы разделить их на строки.',
    'text_of_recipe' => 'Приготовление',
    'text_description' => 'Опишите процесс приготовления по пунктам используя Ввод (Enter) для отделения пунктов друг от друга.',
    'category' => 'Категория',
    'categories' => 'Категории',
    'time' => 'Время приготовления',
    'time_description' => 'Приготовление в мин.',
    'meal_description' => 'Время приема',
    'image' => 'Изображение',
    'select_file' => 'Выбрать файл',
    'recipes' => 'Рецепты',
    'like' => 'Нравится',
    'dislike' => 'Не нравится',
    'bon_appetit' => 'Приятного аппетита',
    'added' => 'Добавленно',
    'author' => 'Автор рецепта',
    'more' => 'Еще рецепты',
    'are_you_sure_to_delete' => 'Вы точно хотите удалить этот рецепт?',
    'are_you_sure_to_publish' => 'Вы точно хотите опубликовать этот рецепт?',
    'are_you_sure_to_draft' => 'Вы точно хотите поместить этот рецепт в черновики?',
    'are_you_sure_to_cancel' => 'Вы точно хотите вернуть этот рецепт автору на доработку?',
    'approve_or_not' => 'Проверьте рецепт на наличие ошибок, нецензурных слов и ссылок на различные ресурсы. Также убедитесь что содержание этого рецепта не имеет негативного эффекта на читателей. Хотите опубликовать этот рецепт?',

    // Listener
    'new_recipe' => config('app.name') . '. Рецепт на рассмотрении! ',

    // Validation
    'title_min' => 'Название рецепта не должно быть менее :min символов',
    'title_max' => 'Название рецепта не должно быть более :max символов',

    'intro_min' => 'Краткое описание не должно быть менее :min символов',
    'intro_max' => 'Краткое описание не должно быть не более :max символов',

    'ingredients_min' => 'Колличество символов в поле ингридиенты не должно быть менее :min символов',
    'ingredients_max' => 'Колличество символов в поле ингридиенты не должно быть не более :max символов',

    'categories_required' => 'Рецепт должен иметь хотя бы одну категорию',
    'categories_distinct' => 'Категории должны быть разными, удалите повторяющиеся категории',
    'categories_numeric' => 'Поля выбора категорий должны содержать только предложенные варианты',

    'meal_numeric' => 'Поле "Время приема" должно быть числом',
    'meal_between' => 'Поле "Время приема" должно содержать один из предложенных вариантов',

    'text_min' => 'Колличество символов в поле приготовление не должно быть менее :min символов',
    'text_max' => 'Колличество символов в поле приготовление не должно быть более :max символов',

    'time_numeric' => 'Время должно быть числом',
    'time_between' => 'Время должно быть числом между :min и :max',

    'image_image' => 'Изображение должно быть файлом изображения JPG',
    'image_max' => 'Максимальный допустимый обьем изображения :max кбайт',

];
