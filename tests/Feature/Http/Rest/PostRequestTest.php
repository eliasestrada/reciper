<?php

namespace Tests\Feature\Http\Rest;

use Tests\TestCase;
use App\Models\Recipe;
use App\Models\Visitor;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostRequestTest extends TestCase
{
	use DatabaseTransactions;

	/**
	 * @return void
	 * @test
	 */
	public function likeAndDislikeRecipePostRequest() : void
    {
		// Like recipe request ======
		$recipe = factory(Recipe::class)->create();
		$visitor = Visitor::create(['ip' => '777.777.7.7']);

		$this->assertEquals(0, count($recipe->likes));
		$this->post("/api/recipes/other/like/$recipe->id", ['ip' => $visitor->ip]);
		
		$recipe = Recipe::find($recipe->id);
		$this->assertEquals(1, count($recipe->likes));
		
		// Dislike recipe request ======
		$this->post("/api/recipes/other/dislike/$recipe->id", [
			'ip' => $visitor->ip
		]);

		$recipe = Recipe::find($recipe->id);
		$this->assertEquals(0, count($recipe->likes));
	}

	/**
	 * @test
	 * @return void
	 */
	public function checkIfLikedPostRequest() : void
	{
		$recipe = factory(Recipe::class)->create();
		$visitor = Visitor::create(['ip' => '777.777.7.7']);

		$response = $this->post("/api/recipes/other/check-if-liked/$recipe->id", [
			'ip' => $visitor->ip
		]);

		$response->assertOk();
		$this->assertEquals(0, $response->original);
	}
}
