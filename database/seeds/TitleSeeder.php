<?php

use App\Models\Title;
use Illuminate\Database\Seeder;

class TitleSeeder extends Seeder
{
    public function run()
    {
		Title::create([
			'name'  => 'intro',
			'title_ru' => 'Готовим вместе',
			'text_ru'  => 'Хотелось бы поделиться с вами кулинарными секретами. Здесь вы найдете самые проверенные и оригинальные рецепты, от простых до необычных, и, главное, совсем не сложных в приготовлении. Больше Вам не придется долго искать действительно проверенный и вкусный рецепт!'
		]);

		Title::create([
			'name'  => 'footer',
			'title_ru' => '',
			'text_ru'  => 'При копировании любых материалов с сайта активная ссылка на сайт deliciousfood.gq обязательна.'
		]);
    }
}