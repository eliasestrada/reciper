<?php

use App\Models\Recipe;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run()
    {
        $recipe = Recipe::create([
            'user_id' => 1,
            'meal_id' => 1,
            'title_ru' => 'Морковь по-корейски',
            'intro_ru' => 'Вкусная морковь по-корейски за 10 минут которая готовится довольно просто. Морковь приправленная пряностями, будет отличной закуской на вашем столе. Лучше всего выбирать свежую и сладкую морковь для приготовления. Если у вас нет шинковки можно морковь нарезать тонкими ломтиками.',
            'ingredients_ru' => "1 кг моркови\n1 маленькая луковица\n1 зубчик чеснока\n1/2 ч. л. красного перца \n1 ч. л. соли\n1 ч. л. молотого кориандра\n1/2 ч. л. сахара\n1/2 ч. л. черного перца\n3 капли уксуса",
            'text_ru' => "После того как морковь почищена, натираем ее на терке (шинковка).\nВ натертую морковь добавляем 1 чайную ложку соли, пол чайной ложки сахара и 3 капли уксуса.\nМелко нарезанный лук обжариваем на растительном масле до мягкости.\nДобавляем пол ложки красного перца в обжаренный лук.\nПеред тем как добавить лук в наш салат, мы добавляем 1 зубчик чеснока, пол чайной ложки черного перца и ложку молотого кориандра в нашу морковь.\nТеперь можно добавить лук с красным перцем и хорошо перемешать.\nОставить в холодильнике на пару часов чтобы морковь хорошо промариновалась.",
            'approved_ru' => 1,
            'published_ru' => 1,
            'time' => 10,
            'image' => '2018/10/15409270451528037408.jpg',
            'ready_ru' => 1,
            'ru_approver_id' => 1,
            'simple' => 1,
            'created_at' => '2018-04-02 12:48:26',
            'updated_at' => '2018-04-02 12:48:26',
        ]);
        $recipe->categories()->sync([4, 11, 13, 16]);
    }
}
