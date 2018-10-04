<?php

namespace Tests\Feature\Requests\Recipes;

use App\Models\Category;
use App\Models\Meal;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RecipesUpdateRequestTest extends TestCase
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
    public function title_must_be_not_short(): void
    {
        $title_min = config('valid.recipes.title.min');
        $this->data['title'] = str_random($title_min - 1);
        $this->response()->assertSeeText($this->replace(':min', $title_min, trans('recipes.title_min')));
    }

    /** @test */
    public function title_must_be_not_long(): void
    {
        $title_max = config('valid.recipes.title.max');
        $this->data['title'] = str_random($title_max + 1);
        $this->response()->assertSeeText($this->replace(':max', $title_max, trans('recipes.title_max')));
    }

    /** @test */
    public function intro_must_be_not_short(): void
    {
        $intro_min = config('valid.recipes.intro.min');
        $this->data['intro'] = str_random($intro_min - 1);
        $this->response()->assertSeeText($this->replace(':min', $intro_min, trans('recipes.intro_min')));
    }

    /** @test */
    public function intro_must_be_not_long(): void
    {
        $intro_max = config('valid.recipes.intro.max');
        $this->data['intro'] = str_random($intro_max + 1);
        $this->response()->assertSeeText($this->replace(':max', $intro_max, trans('recipes.intro_max')));
    }

    /** @test */
    public function ingredients_must_be_not_short(): void
    {
        $ingredients_min = config('valid.recipes.ingredients.min');
        $this->data['ingredients'] = str_random($ingredients_min - 1);
        $this->response()->assertSeeText($this->replace(':min', $ingredients_min, trans('recipes.ingredients_min')));
    }

    /** @test */
    public function ingredients_must_be_not_long(): void
    {
        $ingredients_max = config('valid.recipes.ingredients.max');
        $this->data['ingredients'] = str_random($ingredients_max + 1);
        $this->response()->assertSeeText($this->replace(':max', $ingredients_max, trans('recipes.ingredients_max')));
    }

    /** @test */
    public function text_must_be_not_short(): void
    {
        $text_min = config('valid.recipes.text.min');
        $this->data['text'] = str_random($text_min - 1);
        $this->response()->assertSeeText($this->replace(':min', $text_min, trans('recipes.text_min')));
    }

    /** @test */
    public function text_must_be_not_long(): void
    {
        $text_max = config('valid.recipes.text.max');
        $this->data['text'] = str_random($text_max + 1);
        $this->response()->assertSeeText($this->replace(':max', $text_max, trans('recipes.text_max')));
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
        $user = create_user();

        $recipe = create(Recipe::class, [
            'approved_' . lang() => 0,
            'ready_' . lang() => 0,
            'user_id' => $user->id,
        ]);

        return $this->actingAs($user)
            ->followingRedirects()
            ->put(action('RecipesController@update', $recipe->id), $this->data);
    }
}
