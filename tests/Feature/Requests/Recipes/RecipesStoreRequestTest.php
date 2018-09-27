<?php

namespace Tests\Feature\Requests\Recipes;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RecipesStoreRequestTest extends TestCase
{
    use DatabaseTransactions;

    private $title_min;
    private $title_max;
    private $request;

    public function setUp()
    {
        parent::setUp();
        $this->title_min = config('validation.recipes.title.min');
        $this->title_max = config('validation.recipes.title.max');
        $this->request = $this->actingAs(create_user())->followingRedirects();
    }

    /** @test */
    public function title_is_required(): void
    {
        $this->request->post(action('RecipesController@store', [
            'title' => '',
        ]))->assertSeeText(trans('recipes.title_required'));
    }

    /** @test */
    public function title_must_be_not_short(): void
    {
        $this->request->post(action('RecipesController@store', [
            'title' => str_random($this->title_min - 1),
        ]))->assertSeeText(preg_replace('/:min/', $this->title_min, trans('recipes.title_min')));
    }

    /** @test */
    public function title_must_be_not_long(): void
    {
        $this->request->post(action('RecipesController@store', [
            'title' => str_random($this->title_max + 1),
        ]))->assertSeeText(preg_replace('/:max/', $this->title_max, trans('recipes.title_max')));
    }
}
