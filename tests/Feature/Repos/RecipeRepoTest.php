<?php

namespace Tests\Feature\Repos;

use App\Models\Recipe;
use App\Repos\RecipeRepo;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Pagination\LengthAwarePaginator;
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
    public function method_paginateUnapprovedWaiting_returns_pagination(): void
    {
        $result = $this->repo->paginateUnapprovedWaiting();
        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
    }

    /**
     * @author Cho
     * @test
     */
    public function method_paginateUnapprovedChecking_returns_pagination(): void
    {
        $result = $this->repo->paginateUnapprovedChecking();
        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
    }

    /**
     * @author Cho
     * @test
     */
    public function method_paginateMyApproves_returns_pagination(): void
    {
        $result = $this->repo->paginateMyApproves(create_user('admin')->id);
        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
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
}
