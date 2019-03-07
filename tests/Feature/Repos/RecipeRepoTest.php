<?php

namespace Tests\Feature\Repos;

use Tests\TestCase;
use App\Models\Recipe;
use App\Repos\RecipeRepo;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RecipeRepoTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var \App\Repos\RecipeRepo $repo
     */
    private $repo;

    /**
     * Setup the test environment
     * 
     * @author Cho
     * @return void
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
    public function method_getRecipeSlugThatAdminIsChecking_returns_id_of_recipe_that_user_is_checking(): void
    {
        $user = create_user('admin');

        $recipe = create(Recipe::class, [
            _('ready') => 1,
            _('approved') => 0,
            _('approver_id', true) => $user->id,
        ]);
        $result = $this->repo->getRecipeSlugThatAdminIsChecking($user->id);

        $this->assertEquals($recipe->slug, $result);
    }

    /**
     * @author Cho
     * @test
     */
    public function method_find_returns_recipe_by_given_slug(): void
    {
        $recipe = create(Recipe::class);
        $result = $this->repo->find($recipe->slug);
        $this->assertEquals($recipe->toBase(), $result->toBase());
    }

    /**
     * @author Cho
     * @test
     */
    public function method_findWithAuthor_returns_recipe_by_given_slug_with_user_db_record(): void
    {
        $recipe = create(Recipe::class);
        $result = $this->repo->findWithAuthor($recipe->slug);
        $this->assertEquals($recipe->user->username, $result->user->username);
    }

    /**
     * @author Cho
     * @test
     */
    public function method_paginateUserRecipesWithCountColumns_returns_user_recipes(): void
    {
        $user_id = create_user()->id;
        $recipe = create(Recipe::class, compact('user_id'));
        $result = $this->repo->paginateUserRecipesWithCountColumns($user_id);

        $this->assertNotNull($result->where('id', $recipe->id)->first());
    }

    /**
     * @author Cho
     * @test
     */
    public function method_paginateUserRecipesWithCountColumns_returns_user_recipes_with_given_count_columns(): void
    {
        $user_id = create_user()->id;
        $recipe = create(Recipe::class, compact('user_id'));
        $count_columns = ['favs', 'likes', 'views'];

        $result = $this->repo->paginateUserRecipesWithCountColumns(
            $user_id, $count_columns
        )->first()->toArray();

        array_walk($count_columns, function ($column) use ($result) {
            $this->assertArrayHasKey("{$column}_count", $result);
        }); 
    }
}
