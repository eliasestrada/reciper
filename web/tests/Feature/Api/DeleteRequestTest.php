<?php

namespace Tests\Feature\Api;

use App\Models\Recipe;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DeleteRequestTest extends TestCase
{
    use DatabaseTransactions;

    private $user;

    /**
     * @author Cho
     */
    public function setUp()
    {
        parent::setUp();
        $this->withoutJobs();
        $this->user = create_user();
    }

    /**
     * @author Cho
     * @test
     */
    public function user_can_delete_his_recipe_from_DB(): void
    {
        $recipe = create(Recipe::class, ['user_id' => $this->user->id], null, 'draft');

        $this->actingAs($this->user)->delete("/recipes/{$recipe->id}");
        $this->assertDatabaseMissing('recipes', ['id' => $recipe->id]);
    }

    /**
     * @author Cho
     * @test
     */
    public function user_cant_delete_other_recipe_from_DB(): void
    {
        $recipe = create(Recipe::class, [], null, 'draft');

        $this->actingAs($this->user)->delete("/recipes/{$recipe->id}");
        $this->assertDatabaseHas('recipes', ['id' => $recipe->id]);
    }
}
