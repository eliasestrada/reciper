<?php

namespace Tests\Feature\Recipes;

use Tests\TestCase;
use App\Models\Meal;
use App\Models\User;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ControllerTest extends TestCase
{
	use DatabaseTransactions;

	/**
	 * @return void
	 * @test
	 */
	public function createMethod() : void
	{
		$array_of_meal = Meal::get(['id', 'name_en'])->toArray();

		app()->setLocale('en');

		$this->assertArrayHasKey('name_' . locale(), $array_of_meal[0]);
		$this->assertArrayHasKey('name_' . locale(), $array_of_meal[1]);
		$this->assertArrayHasKey('name_' . locale(), $array_of_meal[2]);

		$array_of_meal = Meal::get(['id', 'name_ru'])->toArray();
		
		app()->setLocale('ru');

		$this->assertArrayHasKey('name_' . locale(), $array_of_meal[0]);
		$this->assertArrayHasKey('name_' . locale(), $array_of_meal[1]);
		$this->assertArrayHasKey('name_' . locale(), $array_of_meal[2]);
	}
}
