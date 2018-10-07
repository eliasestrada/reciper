<?php

namespace Tests\Unit\Models;

use App\Models\Fav;
use App\Models\Recipe;
use App\Models\User;
use App\Models\Visitor;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function model_has_attributes(): void
    {
        $this->assertClassHasAttribute('guarded', User::class);
        $this->assertClassHasAttribute('hidden', User::class);
        $this->assertClassHasAttribute('dates', User::class);
        $this->assertClassHasAttribute('levels', User::class);
    }

    /** @test */
    public function model_has_relationship_with_recipe(): void
    {
        $this->assertCount(0, make(User::class)->recipes);
    }

    /** @test */
    public function model_has_relationship_with_role(): void
    {
        $this->assertNotNull(create_user('admin')->roles);
    }

    /** @test */
    public function model_has_relationship_with_favs(): void
    {
        $this->assertNotNull(create_user()->favs);
    }

    /** @test */
    public function model_has_relationship_with_notification(): void
    {
        $this->assertNotNull(make(User::class)->notifications);
    }

    /** @test */
    public function model_has_relationship_with_visitor(): void
    {
        $this->assertNotNull(make(User::class)->visitor);
    }

    /** @test */
    public function has_role_method_returns_true_if_user_has_given_role(): void
    {
        $this->assertFalse(create_user()->hasRole('admin'));
        $this->assertTrue(create_user('admin')->hasRole('admin'));
    }

    /** @test */
    public function add_role_method_adds_role_to_given_user(): void
    {
        $user = create_user();
        $user->addRole('master');
        $this->assertTrue($user->hasRole('master'));
    }

    /** @test */
    public function has_recipe_method_returns_true_if_user_is_an_author_of_the_given_recipe_id(): void
    {
        $user = make(User::class);
        $recipe = create(Recipe::class, ['user_id' => $user->id]);
        $this->assertTrue($user->hasRecipe($recipe->id));
    }

    /** @test */
    public function has_fav_method_returns_bool_if_user_has_this_recipe_in_favs(): void
    {
        $user = make(User::class);
        $recipe = create(Recipe::class);
        Fav::create(['user_id' => $user->id, 'recipe_id' => $recipe->id]);
        $this->assertTrue($user->hasFav($recipe->id));
    }

    /** @test */
    public function lvl_method_returns_correct_data(): void
    {
        $user = create_user('', ['exp' => 100.0]);
        $this->assertEquals(6, $user->getLvl());

        $user->exp = 250;
        $this->assertEquals(8, $user->getLvl());
    }

    /** @test */
    public function get_lvl_min_method_returns_correct_data(): void
    {
        $user = create_user('', ['exp' => 40.0]);
        $this->assertEquals($user->levels[5]['min'], $user->getLvlMin());
    }

    /** @test */
    public function get_lvl_max_method_returns_correct_data(): void
    {
        $user = create_user('', ['exp' => 70.0]);
        $this->assertEquals($user->levels[6]['max'], $user->getLvlMax());
    }
}
