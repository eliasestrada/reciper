<?php

namespace Tests\Feature\Models;

use App\Models\Recipe;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RecipeTest extends TestCase
{
    use DatabaseTransactions;

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
    public function model_has_relationship_with_category(): void
    {
        $recipe = create(Recipe::class);
        $recipe->categories()->sync([1, 2]);

        $this->assertCount(2, $recipe->categories);
    }

    /** @test */
    public function model_has_relationship_with_user_called_approver(): void
    {
        $this->assertTrue(make(Recipe::class)->approver->exists());
    }

    /** @test */
    public function get_title_method_returns_title_row(): void
    {
        $recipe = make(Recipe::class, ['title_' . lang() => 'Sumpakuma']);
        $this->assertEquals('Sumpakuma', $recipe->getTitle());
    }

    /** @test */
    public function get_ingredients_method_returns_ingredients_row(): void
    {
        $recipe = make(Recipe::class, ['ingredients_' . lang() => 'Homatoma']);
        $this->assertEquals('Homatoma', $recipe->getIngredients());
    }

    /** @test */
    public function get_intro_method_returns_intro_row(): void
    {
        $recipe = make(Recipe::class, ['intro_' . lang() => 'Mapacuta']);
        $this->assertEquals('Mapacuta', $recipe->getIntro());
    }

    /** @test */
    public function get_text_method_returns_text_row(): void
    {
        $recipe = make(Recipe::class, ['text_' . lang() => 'Kolobok']);
        $this->assertEquals('Kolobok', $recipe->getText());
    }

    /** @test */
    public function is_ready_method_returns_true_when_ready_column_set_to_one(): void
    {
        $recipe = make(Recipe::class, ['ready_' . lang() => 1]);
        $this->assertTrue($recipe->isReady());
    }

    /** @test */
    public function is_approved_method_returns_true_when_approved_column_set_to_one(): void
    {
        $recipe = make(Recipe::class, ['approved_' . lang() => 1]);
        $this->assertTrue($recipe->isApproved());
    }

    /** @test */
    public function is_done_method_returns_true_when_ready_and_approved_columns_set_to_one(): void
    {
        $recipe = make(Recipe::class, ['ready_' . lang() => 1, 'approved_' . lang() => 1]);
        $this->assertTrue($recipe->isDone());
    }

    /** @test */
    public function is_published_method_returns_true_when_published_column_is_set_to_one(): void
    {
        $recipe = make(Recipe::class, ['published_' . lang() => 1]);
        $this->assertTrue($recipe->isPublished());
    }

    /** @test */
    public function get_status_text_method_returns_status_text(): void
    {
        $done = make(Recipe::class);
        $not_ready = make(Recipe::class, ['ready_' . lang() => 0]);
        $not_approved = make(Recipe::class, ['approved_' . lang() => 0]);

        $this->assertEquals(trans('users.checked'), $done->getStatusText());
        $this->assertEquals(trans('users.not_ready'), $not_ready->getStatusText());
        $this->assertEquals(trans('users.is_checking'), $not_approved->getStatusText());
    }

    /** @test */
    public function get_status_icon_method_returns_icon_name(): void
    {
        $done = make(Recipe::class);
        $not_ready = make(Recipe::class, ['ready_' . lang() => 0]);
        $not_approved = make(Recipe::class, ['approved_' . lang() => 0]);

        $this->assertEquals('fa-check', $done->getStatusIcon());
        $this->assertEquals('fa-pen', $not_ready->getStatusIcon());
        $this->assertEquals('fa-clock', $not_approved->getStatusIcon());
    }

    /** @test */
    public function get_status_color_method_returns_color_code(): void
    {
        $done = make(Recipe::class);
        $not_ready = make(Recipe::class, ['ready_' . lang() => 0]);
        $not_approved = make(Recipe::class, ['approved_' . lang() => 0]);

        $this->assertEquals('#65b56e', $done->getStatusColor());
        $this->assertEquals('#ce7777', $not_ready->getStatusColor());
        $this->assertEquals('#e2bd18', $not_approved->getStatusColor());
    }
}
