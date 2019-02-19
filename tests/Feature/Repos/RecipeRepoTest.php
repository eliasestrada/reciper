<?php

namespace Tests\Feature\Repos;

use App\Models\Recipe;
use App\Repos\RecipeRepo;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RecipeRepoTest extends TestCase
{
    use DatabaseTransactions;

    public $recipe_repo;

    /**
     * @author Cho
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->repo = new RecipeRepo;
    }

    /**
     * @author Cho
     * @test
     */
    public function method_paginateUnapprovedWaiting_returns_recipes_that_are_waiting_to_be_approved(): void
    {
        create(Recipe::class, [
            _('ready') => 1,
            _('approved') => 0,
            _('approver_id', true) => 0,
        ], 2);

        $result = $this->repo->paginateUnapprovedWaiting();

        $this->assertEquals(2, $result->count());
    }

    /**
     * @author Cho
     * @test
     */
    public function method_paginateUnapprovedChecking_returns_recipes_that_are_being_checked(): void
    {
        create(Recipe::class, [
            _('ready') => 1,
            _('approved') => 0,
        ], 2);

        $result = $this->repo->paginateUnapprovedChecking();

        $this->assertEquals(2, $result->count());
    }

    /**
     * @author Cho
     * @test
     */
    public function method_paginateMyApproves_returns_recipes_approved_by_certain_admin(): void
    {
        $user = create_user('admin');

        create(Recipe::class, [
            _('ready') => 1,
            _('approved') => 1,
            _('approver_id', true) => $user->id,
        ], 2);

        $result = $this->repo->paginateMyApproves($user->id);

        $this->assertEquals(2, $result->count());
    }

    /**
     * @author Cho
     * @test
     */
    public function method_getIdOfTheRecipeThatUserIsChecking_returns_id_of_recipe_that_user_is_checking(): void
    {
        $user = create_user('admin');

        $recipe = create(Recipe::class, [
            _('ready') => 1,
            _('approved') => 0,
            _('approver_id', true) => $user->id,
        ]);

        $this->assertEquals($recipe->id, $this->repo->getIdOfTheRecipeThatUserIsChecking($user->id));
    }

    /**
     * @author Cho
     * @test
     */
    public function method_paginateUnapprovedWaiting_returns_aditional_likes_count_column(): void
    {
        $this->assertNotNull($this->repo->paginateByLikes()->first()->likes_count);
    }

    /**
     * @author Cho
     * @test
     */
    public function method_paginateAllSimple_doesnt_return_not_simple_recipes(): void
    {
        $not_simple_recipe = create(Recipe::class, ['simple' => 0]);
        $result = $this->repo->paginateAllSimple();
        $this->assertNull($result->where('id', $not_simple_recipe->id)->first());
    }

    /**
     * @author Cho
     * @test
     */
    public function method_paginateWithMealTime_returns_recipes_with_given_meal_time(): void
    {
        $not_simple_recipe = create(Recipe::class, ['simple' => 0]);
        $meal = ['breakfast', 'lunch', 'dinner'];

        for ($i = 0; $i < 3; $i++) {
            $recipe = create(Recipe::class, ['meal_id' => $i + 1]);
            $result = $this->repo->paginateWithMealTime($meal[$i]);
            $this->assertNotNull($result->where('id', $recipe->id)->first());
        }
    }
}
