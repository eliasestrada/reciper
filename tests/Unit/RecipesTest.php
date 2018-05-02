<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Recipe;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RecipesTest extends TestCase
{
	use DatabaseTransactions;

    public function testFirst()
    {
		// $recipe = Recipe::find(2)->delete();
		// $this->assertTrue($recipe);

		// $this->assertDatabaseHas('recipes', [ 'id' => 1 ]);
		// $this->assertDatabaseMissing('recipes', [ 'id' => 1 ]);

		$response = $this->get('/');
		$response->assertSee('Delicious Food');
    }
}
