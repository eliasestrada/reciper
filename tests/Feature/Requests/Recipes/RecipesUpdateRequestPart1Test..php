<?php

namespace Tests\Feature\Requests\Recipes;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RecipesUpdateRequestPart1Test extends TestCase
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
