<?php

use App\Models\Title;
use Illuminate\Database\Seeder;

class TitlesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		Title::create([
			'name'  => 'Интро',
			'title' => 'Готовим вместе',
			'text'  => 'Хотелось бы поделиться с вами кулинарными секретами. Здесь вы найдете самые проверенные и оригинальные рецепты, от простых до необычных, и, главное, совсем не сложных в приготовлении. Больше Вам не придется долго искать действительно проверенный и вкусный рецепт!'
		]);

		Title::create([
			'name'  => 'Подвал',
			'title' => '',
			'text'  => 'При копировании любых материалов с сайта активная ссылка на сайт deliciousfood.gq обязательна.'
		]);
    }
}