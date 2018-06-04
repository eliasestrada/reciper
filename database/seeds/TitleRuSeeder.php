<?php

use App\Models\Ru\TitleRu;
use Illuminate\Database\Seeder;

class TitleRuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		TitleRu::create([
			'name'  => 'Интро',
			'title' => 'Готовим вместе',
			'text'  => 'Хотелось бы поделиться с вами кулинарными секретами. Здесь вы найдете самые проверенные и оригинальные рецепты, от простых до необычных, и, главное, совсем не сложных в приготовлении. Больше Вам не придется долго искать действительно проверенный и вкусный рецепт!'
		]);

		TitleRu::create([
			'name'  => 'Подвал',
			'title' => '',
			'text'  => 'При копировании любых материалов с сайта активная ссылка на сайт deliciousfood.gq обязательна.'
		]);
    }
}