<?php

namespace Tests\Feature\Models;

use App\Models\Recipe;
use Tests\TestCase;

class RecipeTest extends TestCase
{
    /** @test */
    public function model_has_attributes(): void
    {
        $this->assertClassHasAttribute('guarded', Recipe::class);
    }

    /** @test */
    public function model_has_relationship_with_user(): void
    {
        $this->assertTrue(make(Recipe::class)->user->exists());
    }

    /** @test */
    public function model_has_relationship_with_meal(): void
    {
        $this->assertTrue(make(Recipe::class)->meal->exists());
    }

    /** @test */
    public function model_has_relationship_with_like(): void
    {
        $this->assertCount(0, make(Recipe::class)->likes);
    }

    /** @test */
    public function model_has_relationship_with_fav(): void
    {
        $this->assertCount(0, make(Recipe::class)->favs);
    }

    /** @test */
    public function model_has_relationship_with_view(): void
    {
        $this->assertCount(0, make(Recipe::class)->views);
    }

    /** @test */
    public function model_has_relationship_with_user_called_approver(): void
    {
        $this->assertTrue(make(Recipe::class)->approver->exists());
    }

    /** @test */
    public function getTitle_method_returns_title_row(): void
    {
        $recipe = new Recipe(['title_' . lang() => 'Sumpakuma']);
        $this->assertEquals('Sumpakuma', $recipe->getTitle());
    }

    /** @test */
    public function getIngredients_method_returns_ingredients_row(): void
    {
        $recipe = new Recipe(['ingredients_' . lang() => 'Homatoma']);
        $this->assertEquals('Homatoma', $recipe->getIngredients());
    }

    /** @test */
    public function getIntro_method_returns_intro_row(): void
    {
        $recipe = new Recipe(['intro_' . lang() => 'Mapacuta']);
        $this->assertEquals('Mapacuta', $recipe->getIntro());
    }

    /** @test */
    public function getText_method_returns_text_row(): void
    {
        $recipe = new Recipe(['text_' . lang() => 'Kolobok']);
        $this->assertEquals('Kolobok', $recipe->getText());
    }

    /** @test */
    public function isReady_method_returns_true_when_ready_column_set_to_one(): void
    {
        $recipe = new Recipe(['ready_' . lang() => 1]);
        $this->assertTrue($recipe->isReady());
    }

    /** @test */
    public function isApproved_method_returns_true_when_approved_column_set_to_one(): void
    {
        $recipe = new Recipe(['ready_' . lang() => 1, 'approved_' . lang() => 1]);
        $this->assertTrue($recipe->isApproved());
    }

    /** @test */
    public function isDone_method_returns_true_when_ready_and_approved_columns_set_to_one(): void
    {
        $recipe = new Recipe(['ready_' . lang() => 1, 'approved_' . lang() => 1]);
        $this->assertTrue($recipe->isDone());
    }

    /** @test */
    public function isPublished_method_returns_true_when_published_column_is_set_to_one(): void
    {
        $recipe = new Recipe(['published_' . lang() => 1]);
        $this->assertTrue($recipe->isPublished());
    }

    /** @test */
    public function getStatusText_method_returns_status_text(): void
    {
        $recipe = new Recipe(['ready_' . lang() => 1, 'approved_' . lang() => 1]);
        $this->assertEquals(trans('users.checked'), $recipe->getStatusText());

        $recipe->{'ready_' . lang()} = 0;
        $this->assertEquals(trans('users.not_ready'), $recipe->getStatusText());

        $recipe->{'ready_' . lang()} = 1;
        $recipe->{'approved_' . lang()} = 0;
        $this->assertEquals(trans('users.is_checking'), $recipe->getStatusText());
    }

    /** @test */
    public function getStatusIcon_method_returns_icon_name(): void
    {
        $recipe = new Recipe(['ready_' . lang() => 1, 'approved_' . lang() => 1]);
        $this->assertEquals('fa-check', $recipe->getStatusIcon());

        $recipe->{'ready_' . lang()} = 0;
        $this->assertEquals('fa-pen', $recipe->getStatusIcon());

        $recipe->{'ready_' . lang()} = 1;
        $recipe->{'approved_' . lang()} = 0;
        $this->assertEquals('fa-clock', $recipe->getStatusIcon());
    }

    /** @test */
    public function getStatusColor_method_returns_color_code(): void
    {
        $recipe = new Recipe(['ready_' . lang() => 1, 'approved_' . lang() => 1]);
        $this->assertEquals('#65b56e', $recipe->getStatusColor());

        $recipe->{'ready_' . lang()} = 0;
        $this->assertEquals('#ce7777', $recipe->getStatusColor());

        $recipe->{'ready_' . lang()} = 1;
        $recipe->{'approved_' . lang()} = 0;
        $this->assertEquals('#e2bd18', $recipe->getStatusColor());
    }
}
