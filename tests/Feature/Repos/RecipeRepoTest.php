<?php

namespace Tests\Feature\Repos;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Repos\RecipeRepo;
use App\Models\Visitor;
use App\Models\View;
use App\Models\Recipe;
use App\Models\Category;

class RecipeRepoTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var \App\Repos\RecipeRepo $repo
     */
    private $repo;

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
        create(Recipe::class, ['simple' => 0]);
        $meal = ['breakfast', 'lunch', 'dinner'];

        for ($i = 0; $i < 3; $i++) {
            $recipe = create(Recipe::class, ['meal_id' => $i + 1]);
            $result = $this->repo->paginateWithMealTime($meal[$i]);
            $this->assertNotNull($result->where('id', $recipe->id)->first());
        }
    }

    /**
     * @author Cho
     * @test
     */
    public function method_paginateViewedByVisitor_returns_recipes_viewed_by_given_visitor(): void
    {
        $view = create(View::class);
        $result = $this->repo->paginateViewedByVisitor($view->visitor->id);
        $this->assertCount(1, $result);
        $this->assertSame($view->recipe->getTitle(), $result->first()->getTitle());
    }

    /**
     * @author Cho
     * @test
     */
    public function method_paginateViewedByVisitor_returns_recipes_ordered_by_latest(): void
    {
        $visitor_id = create(Visitor::class)->id;
        $first_view = create(View::class, [
            'visitor_id' => $visitor_id,
            'created_at' => now()->subSecond(),
        ]);
        $second_view = create(View::class, compact('visitor_id'));

        $result = $this->repo->paginateViewedByVisitor($visitor_id);
        $this->assertEquals($second_view->recipe->getTitle(), $result[0]->getTitle());
        $this->assertEquals($first_view->recipe->getTitle(), $result[1]->getTitle());
    }

    /**
     * @author Cho
     * @test
     */
    public function method_paginateLatest_returns_latest_recipes_that_are_ready_and_approved(): void
    {
        create(Recipe::class, [], null, 'waiting');
        $result = $this->repo->paginateLatest();
        $this->assertEquals(Recipe::query()->done(1)->count(), $result->count());
    }

    /**
     * @author Cho
     * @test
     */
    public function method_paginateLatest_returns_recipes_where_first_recipe_is_the_most_recent(): void
    {
        $last = create(Recipe::class);
        $result = $this->repo->paginateLatest();
        $this->assertEquals($last->id, $result->first()->id);
    }

    /**
     * @author Cho
     * @test
     */
    public function method_paginateWithCategoryId_returns_recipes_with_given_category_id(): void
    {
        Category::pluck('id')->each(function ($category_id) {
            $result = $this->repo->paginateWithCategoryId($category_id);

            // Loop through every recipe, assert that they have needed category_id
            $result->each(function ($recipe) use ($category_id) {
                $this->assertCount(1, $recipe->categories->where('id', $category_id));
            });
        });
    }
}
