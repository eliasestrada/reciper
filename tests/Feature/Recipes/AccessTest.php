<?php

namespace Tests\Feature\Recipes;

use Tests\TestCase;
use App\Models\User;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AccessTest extends TestCase
{
	use DatabaseTransactions;
	
	/** @test */
	public function ifCanEditYourOwnRecipe()
	{
		$this->assertTrue(true);
	}
}
