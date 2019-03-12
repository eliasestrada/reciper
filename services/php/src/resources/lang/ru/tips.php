<?php

return [

    // Action buttons
    'view' => 'Просмотреть',
    'delete' => 'Удалить',
    'edit' => 'Редактировать',
    'publish' => 'Опубликовать',
    'save' => 'Сохранить',
    'add_to_drafts' => 'В черновики',

    // User bubbles
    'likes_tip' => 'Сердца: :value',
    'rating_tip' => 'Популярность: :value',
    'views_tip' => 'Просмотры: :value',

    // Other
    'remember_info' => 'Поставьте галочку если вы не хотите заполнять эту форму каждый раз когда хотите войти на свою страницу',
    'email_settings_tip' => 'Ваша эл. почта нужна только для случая если вы забудете пароль, то у вас будет возможность восстановить доступ к вашей странице.',

    // Recipes edit page
    'recipes_text' => 'Опишите процесс приготовления блюда по пунктам, используя кнопку Ввод (Enter) для отделения пунктов друг от друга.' . tip('Пример', '<br>После того как морковь почищена, натираем ее на терке (Enter)<br>В натертую морковь добавляем 1 чайную ложку соли, пол чайной ложки сахара и 3 капли уксуса.(Enter)<br>Мелко нарезанный лук обжариваем на растительном масле до мягкости.'),
    'recipes_ingredients' => 'Укажите все ингредиенты блюда. После каждого ингредиента нажимайте кнопку Ввод (Enter) чтобы разделить их на строки.' . tip('Пример', '<br>1 кг моркови (Нажимаем Enter)<br>1 маленькая луковица (Нажимаем Enter)<br>1 зубчик чеснока'),
    'recipes_intro' => 'В этом поле укажите краткое описание рецепта.' . tip('Пример', 'Самый простой рецепт манной каши на молоке, который вы можете только найти. Конечно после того как каша готова мы можем добавить в нее например варенья или простых ягод, тем самым украшая и обогащая ее вкус.'),
    'recipes_meal' => 'Лучшее время для приема вашего блюда. ' . tip(null, 'Завтрак - это заряд бодрости. На завтрак обычно едят зерновые и молочные продукты, яйца, фрукты, напитки', 'text') . tip(null, 'Обед должен быть сытным и нежирным. Обычно в обед едят каши, мясо или рыбу, первые блюда (супы, борщи), овощи.', 'text') . tip(null, 'Ужин - это вечерняя трапеза. Для ужина подходит мяснысные и рыбные блюда, овощи', 'text'),
    'recipes_time' => 'Время приготовления включает в себя только само приготовление. Например настаивание теста не учитывается, но время приготовления и запекания учитывается.',

];