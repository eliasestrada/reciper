<?php

namespace Tests\Feature\Requests\Recipes;

use Tests\TestCase;
use App\Models\Meal;
use App\Models\User;
use App\Models\Recipe;
use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RecipesUpdateRequestTest extends TestCase
{
    use DatabaseTransactions;

    private $data;
    private $user;
    private $recipe;

    /**
     * @author Cho
     */
    public function setUp()
    {
        parent::setUp();

        $this->data = [
            'title' => str_random(30),
            'intro' => str_random(200),
            'ingredients' => str_random(300),
            'text' => str_random(400),
            'meal' => mt_rand(1, 3),
            'time' => mt_rand(1, 200),
            'categories' => [0 => 2, 1 => 3],
            'ready' => 1,
        ];

        $this->user = make(User::class);
        $this->recipe = create(Recipe::class, [
            'user_id' => $this->user->id
        ], null, 'draft');
    }

    /**
     * Function helper
     *
     * @return void
     */
    private function makeRequest(): void
    {
        $this->actingAs($this->user)->put(
            action('RecipeController@update', $this->recipe->slug),$this->data
        );
    }

    /**
     * @author Cho
     * @test
     */
    public function title_must_be_not_short(): void
    {
        $this->data['title'] = str_random(config('valid.recipes.title.min') - 1);
        $this->makeRequest();
        $this->assertTrue(Recipe::where(_('title'), $this->data['title'])->doesntExist());
    }

    /**
     * @author Cho
     * @test
     */
    public function title_must_be_not_long(): void
    {
        $this->data['title'] = str_random(config('valid.recipes.title.max') + 1);
        $this->makeRequest();
        $this->assertTrue(Recipe::where(_('title'), $this->data['title'])->doesntExist());
    }

    /**
     * @author Cho
     * @test
     */
    public function intro_must_be_not_short(): void
    {
        $this->data['intro'] = str_random(config('valid.recipes.intro.min') - 1);
        $this->makeRequest();
        $this->assertTrue(Recipe::where(_('intro'), $this->data['intro'])->doesntExist());
    }

    /**
     * @author Cho
     * @test
     */
    public function intro_must_be_not_long(): void
    {
        $this->data['intro'] = str_random(config('valid.recipes.intro.max') + 1);
        $this->makeRequest();
        $this->assertTrue(Recipe::where(_('intro'), $this->data['intro'])->doesntExist());
    }

    /**
     * @author Cho
     * @test
     */
    public function ingredients_must_be_not_short(): void
    {
        $this->data['ingredients'] = str_random(config('valid.recipes.ingredients.min') - 1);
        $this->makeRequest();
        $this->assertTrue(Recipe::where(_('ingredients'), $this->data['ingredients'])->doesntExist());
    }

    /**
     * @author Cho
     * @test
     */
    public function ingredients_must_be_not_long(): void
    {
        $this->data['ingredients'] = str_random(config('valid.recipes.ingredients.max') + 1);
        $this->makeRequest();
        $this->assertTrue(Recipe::where(_('ingredients'), $this->data['ingredients'])->doesntExist());
    }

    /**
     * @author Cho
     * @test
     */
    public function text_must_be_not_short(): void
    {
        $this->data['text'] = str_random(config('valid.recipes.text.min') - 1);
        $this->makeRequest();
        $this->assertTrue(Recipe::where(_('text'), $this->data['text'])->doesntExist());
    }

    /**
     * @author Cho
     * @test
     */
    public function text_must_be_not_long(): void
    {
        $this->data['text'] = str_random(config('valid.recipes.text.max') + 1);
        $this->makeRequest();
        $this->assertTrue(Recipe::where(_('text'), $this->data['text'])->doesntExist());
    }

    /**
     * @author Cho
     * @test
     */
    public function meal_must_be_numeric(): void
    {
        $this->data['meal'] = 'n';
        $this->makeRequest();
        $this->assertTrue(Recipe::where('meal_id', $this->data['meal'])->doesntExist());
    }

    /**
     * @author Cho
     * @test
     */
    public function meal_must_be_between_numbers(): void
    {
        $this->data['meal'] = Meal::count() + 1;
        $this->makeRequest();
        $this->assertTrue(Recipe::where('meal_id', $this->data['meal'])->doesntExist());
    }

    /**
     * @author Cho
     * @test
     */
    public function categories_are_required(): void
    {
        $this->data['categories'] = '';
        $this->data['title'] = 'This title will not be saved because of validation';
        $this->makeRequest();
        $this->assertTrue(Recipe::where(_('title'), $this->data['title'])->doesntExist());
    }

    /**
     * @author Cho
     * @test
     */
    public function categories_must_be_distinct(): void
    {
        $this->data['categories'] = [0 => 2, 1 => 2];
        $this->data['title'] = 'This title will not be saved because of validation';
        $this->makeRequest();
        $this->assertTrue(Recipe::where(_('title'), $this->data['title'])->doesntExist());
    }

    /**
     * @author Cho
     * @test
     */
    public function categories_must_be_numeric(): void
    {
        $this->data['categories'] = [0 => 'string'];
        $this->data['title'] = 'This title will not be saved because of validation';
        $this->makeRequest();
        $this->assertTrue(Recipe::where(_('title'), $this->data['title'])->doesntExist());
    }

    /**
     * @author Cho
     * @test
     */
    public function categories_must_be_between_numbers(): void
    {
        $this->data['categories'] = [0 => 3, 1 => Category::count() + 1];
        $this->data['title'] = 'This title will not be saved coz category id is not between';
        $this->makeRequest();
        $this->assertTrue(Recipe::where(_('title'), $this->data['title'])->doesntExist());
    }

    /**
     * @author Cho
     * @test
     */
    public function categories_correct_data(): void
    {
        $this->data['categories'] = [0 => 2, 1 => Category::count()];
        $this->data['title'] = 'This title will be saved to DB';
        $this->makeRequest();
        $this->assertTrue(Recipe::where(_('title'), $this->data['title'])->exists());
    }
}
