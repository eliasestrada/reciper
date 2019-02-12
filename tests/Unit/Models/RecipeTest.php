<?php

namespace Tests\Unit\Models;

use App\Models\Recipe;
use Tests\TestCase;

class RecipeTest extends TestCase
{
    /**
     * @author Cho
     * @test
     */
    public function recipe_model_has_attributes(): void
    {
        $this->assertClassHasAttribute('guarded', Recipe::class);
    }

    /**
     * @author Cho
     * @test
     */
    public function recipe_model_has_relationship_with_user_model(): void
    {
        $this->assertTrue(make(Recipe::class)->user->exists());
    }

    /**
     * @author Cho
     * @test
     */
    public function recipe_model_has_relationship_with_category_model(): void
    {
        $this->assertNotNull(make(Recipe::class)->categories);
    }

    /**
     * @author Cho
     * @test
     */
    public function recipe_model_has_relationship_with_meal_model(): void
    {
        $this->assertTrue(make(Recipe::class)->meal->exists());
    }

    /**
     * @author Cho
     * @test
     */
    public function recipe_model_has_relationship_with_like_model(): void
    {
        $this->assertCount(0, make(Recipe::class)->likes);
    }

    /**
     * @author Cho
     * @test
     */
    public function recipe_model_has_relationship_with_fav_model(): void
    {
        $this->assertCount(0, make(Recipe::class)->favs);
    }

    /**
     * @author Cho
     * @test
     */
    public function recipe_model_has_relationship_with_view_model(): void
    {
        $this->assertCount(0, make(Recipe::class)->views);
    }

    /**
     * @author Cho
     * @test
     */
    public function recipe_model_has_relationship_with_user_model_called_approver(): void
    {
        $this->assertTrue(make(Recipe::class)->approver->exists());
    }

    /**
     * @author Cho
     * @test
     */
    public function getTitle_method_returns_title_row(): void
    {
        $recipe = new Recipe([_('title') => 'Sumpakuma']);
        $this->assertEquals('Sumpakuma', $recipe->getTitle());
    }

    /**
     * @author Cho
     * @test
     */
    public function getIngredients_method_returns_ingredients_row(): void
    {
        $recipe = new Recipe([_('ingredients') => 'Homatoma']);
        $this->assertEquals('Homatoma', $recipe->getIngredients());
    }

    /**
     * @author Cho
     * @test
     */
    public function getIntro_method_returns_intro_row(): void
    {
        $recipe = new Recipe([_('intro') => 'Mapacuta']);
        $this->assertEquals('Mapacuta', $recipe->getIntro());
    }

    /**
     * @author Cho
     * @test
     */
    public function getText_method_returns_text_row(): void
    {
        $recipe = new Recipe([_('text') => 'Kolobok']);
        $this->assertEquals('Kolobok', $recipe->getText());
    }

    /**
     * @author Cho
     * @test
     */
    public function isReady_method_returns_true_when_ready_column_set_to_one(): void
    {
        $recipe = new Recipe([_('ready') => 1]);
        $this->assertTrue($recipe->isReady());
    }

    /**
     * @author Cho
     * @test
     */
    public function isApproved_method_returns_true_when_approved_column_set_to_one(): void
    {
        $recipe = new Recipe([_('ready') => 1, _('approved') => 1]);
        $this->assertTrue($recipe->isApproved());
    }

    /**
     * @author Cho
     * @test
     */
    public function isDone_method_returns_true_when_ready_and_approved_columns_set_to_one(): void
    {
        $recipe = new Recipe([_('ready') => 1, _('approved') => 1]);
        $this->assertTrue($recipe->isDone());
    }

    /**
     * @author Cho
     * @test
     */
    public function isPublished_method_returns_true_when_published_column_is_set_to_one(): void
    {
        $recipe = new Recipe([_('published') => 1]);
        $this->assertTrue($recipe->isPublished());
    }

    /**
     * @author Cho
     * @test
     */
    public function getStatusText_method_returns_status_text(): void
    {
        $recipe = new Recipe([_('ready') => 1, _('approved') => 1]);
        $this->assertEquals(trans('users.checked'), $recipe->getStatusText());

        $recipe->{_('ready')} = 0;
        $this->assertEquals(trans('users.not_ready'), $recipe->getStatusText());

        $recipe->{_('ready')} = 1;
        $recipe->{_('approved')} = 0;
        $this->assertEquals(trans('users.is_checking'), $recipe->getStatusText());
    }

    /**
     * @author Cho
     * @test
     */
    public function getStatusIcon_method_returns_check_icon_when_recipe_is_ready_and_approved(): void
    {
        $recipe = new Recipe([_('ready') => 1, _('approved') => 1]);
        $this->assertEquals('fa-check', $recipe->getStatusIcon());
    }

    /**
     * @author Cho
     * @test
     */
    public function getStatusIcon_method_returns_pen_icon_when_recipe_is_not_ready(): void
    {
        $recipe = new Recipe([_('ready') => 0]);
        $this->assertEquals('fa-pen', $recipe->getStatusIcon());
    }

    /**
     * @author Cho
     * @test
     */
    public function getStatusIcon_method_returns_clock_icon_when_recipe_is_ready_but_not_approved_yet(): void
    {
        $recipe = new Recipe([_('ready') => 1, _('approved') => 0]);
        $this->assertEquals('fa-clock', $recipe->getStatusIcon());
    }

    /**
     * @author Cho
     * @test
     */
    public function getStatusColor_method_returns_green_color_when_recipe_is_ready_and_approved(): void
    {
        $recipe = new Recipe([_('ready') => 1, _('approved') => 1]);
        $this->assertEquals('#65b56e', $recipe->getStatusColor());
    }

    /**
     * @author Cho
     * @test
     */
    public function getStatusColor_method_returns_red_color_when_recipe_is_in_drafts(): void
    {
        $recipe = new Recipe([_('ready') => 0]);
        $this->assertEquals('#ce7777', $recipe->getStatusColor());
    }

    /**
     * @author Cho
     * @test
     */
    public function getStatusColor_method_returns_orange_color_when_recipe_is_ready_but_not_approved_yet(): void
    {
        $recipe = new Recipe([_('ready') => 1, _('approved') => 0]);
        $this->assertEquals('#e2bd18', $recipe->getStatusColor());
    }

    /**
     * @author Cho
     * @test
     */
    public function selectBasic_scope_returns_only_common_used_columns(): void
    {
        $recipe = Recipe::selectBasic()->first()->toArray();
        $columns = [
            'id',
            'slug',
            _('title'),
            _('intro'),
            _('ready'),
            _('approved'),
            'image',
            'time',
            'updated_at',
        ];

        array_map(function ($key) use ($recipe) {
            $this->assertArrayHasKey($key, $recipe);
        }, $columns);
    }
}
