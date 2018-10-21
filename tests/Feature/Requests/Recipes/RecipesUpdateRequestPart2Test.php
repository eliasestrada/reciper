<?php

namespace Tests\Feature\Requests\Recipes;

use App\Models\Category;
use App\Models\Meal;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RecipesUpdateRequestPart2Test extends TestCase
{
    use DatabaseTransactions;

    private $data;

    public function setUp()
    {
        parent::setUp();

        $this->data = [
            'title' => str_random(30),
            'intro' => str_random(200),
            'ingredients' => str_random(300),
            'text' => str_random(400),
            'meal' => rand(1, 3),
            'time' => rand(1, 200),
            'categories' => [0 => 2, 1 => 3],
            'ready' => 1,
        ];
    }

    /** @test */
    public function meal_must_be_numeric(): void
    {
        $this->data['meal'] = 'n';
        $this->response()->assertSeeText(trans('recipes.meal_numeric'));
    }

    /** @test */
    public function meal_must_be_between_numbers(): void
    {
        $meal_max = Meal::count();
        $this->data['meal'] = $meal_max + 1;
        $expect = $this->replace(':min', 1, trans('recipes.meal_between'));

        $this->response()->assertSeeText($this->replace(':max', $meal_max, $expect));
    }

    /** @test */
    public function categories_are_required(): void
    {
        $this->data['categories'] = '';
        $this->response()->assertSeeText(trans('recipes.categories_required'));
    }

    /** @test */
    public function categories_must_be_distinct(): void
    {
        $this->data['categories'] = [0 => 2, 1 => 2];
        $this->response()->assertSeeText(trans('recipes.categories_distinct'));
    }

    /** @test */
    public function categories_must_be_numeric(): void
    {
        $this->data['categories'] = [0 => 'string'];
        $this->response()->assertSeeText(trans('recipes.categories_numeric'));
    }

    /** @test */
    public function categories_must_not_have_id_of_one(): void
    {
        $this->data['categories'] = [0 => 1];
        $this->response()->assertSeeText(trans('recipes.categories_between'));
    }

    /** @test */
    public function categories_must_be_between_numbers(): void
    {
        $this->data['categories'] = [0 => 1, 1 => 2];
        $this->response()->assertSeeText(trans('recipes.categories_between'));

        $this->data['categories'] = [0 => 3, 1 => Category::count() + 1];
        $this->response()->assertSeeText(trans('recipes.categories_between'));
    }

    /** @test */
    public function categories_correct_data(): void
    {
        $this->data['categories'] = [0 => 2, 1 => Category::count()];
        $this->response()->assertSeeText(trans('recipes.added_to_approving'));
    }

    /**
     * Helper
     * @param string $before
     * @param string $after
     * @param string $string
     * @return void
     */
    public function replace(string $before, string $after, string $string)
    {
        return preg_replace('/' . $before . '/', $after, $string);
    }

    /**
     * Helper
     * @return $this
     */
    public function response()
    {
        $user = make(User::class, ['id' => 1]);
        $recipe = create(Recipe::class, ['user_id' => $user->id], null, 'draft');

        return $this->actingAs($user)
            ->followingRedirects()
            ->put(action('RecipesController@update', $recipe->id), $this->data);
    }
}
