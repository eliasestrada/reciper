<?php

namespace Tests\Unit\Models;

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
        $this->assertClassHasAttribute('fillable', User::class);
        $this->assertClassHasAttribute('hidden', User::class);
        $this->assertClassHasAttribute('dates', User::class);
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
}
