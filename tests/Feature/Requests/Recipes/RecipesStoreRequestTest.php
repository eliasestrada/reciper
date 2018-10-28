<?php

namespace Tests\Feature\Requests\Recipes;

use App\Models\User;
use Tests\TestCase;

class RecipesStoreRequestTest extends TestCase
{
    private $title_min;
    private $title_max;
    private $request;

    /**
     * @author Cho
     */
    public function setUp()
    {
        parent::setUp();
        $this->title_min = config('valid.recipes.title.min');
        $this->title_max = config('valid.recipes.title.max');

        $this->request = $this->actingAs(make(User::class))->followingRedirects();
    }

    /**
     * @author Cho
     * @test
     */
    public function title_is_required(): void
    {
        $this->request->post(action('RecipesController@store'), [
            'title' => '',
        ])->assertSeeText(trans('recipes.title_required'));
    }

    /**
     * @author Cho
     * @test
     */
    public function title_must_be_not_short(): void
    {
        $this->request->post(action('RecipesController@store'), [
            'title' => str_random($this->title_min - 1),
        ])->assertSeeText(preg_replace('/:min/', $this->title_min, trans('recipes.title_min')));
    }

    /**
     * @author Cho
     * @test
     */
    public function title_must_be_not_long(): void
    {
        $this->request->post(action('RecipesController@store'), [
            'title' => str_random($this->title_max + 1),
        ])->assertSeeText(preg_replace('/:max/', $this->title_max, trans('recipes.title_max')));
    }
}
