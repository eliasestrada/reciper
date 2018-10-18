<?php

namespace Tests\Feature\Models;

use App\Models\Fav;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class FavTest extends TestCase
{
    use DatabaseTransactions;

    private $user;
    private $recipe;
    private $fav;

    public function setUp(): void
    {
        parent::setUp();

        $this->recipe = create(Recipe::class);
        $this->user = create(User::class);
        $this->fav = Fav::create([
            'user_id' => $this->user->id,
            'recipe_id' => $this->recipe->id,
        ]);
    }

    /** @test */
    public function model_has_attributes(): void
    {
        $this->assertClassHasAttribute('guarded', Fav::class);
        $this->assertClassHasAttribute('timestamps', Fav::class);
    }

    /** @test */
    public function model_has_relationship_with_user(): void
    {
        $this->assertTrue($this->fav->user()->exists());
    }

    /** @test */
    public function model_has_relationship_with_recipe(): void
    {
        $this->assertTrue($this->fav->recipe()->exists());
    }
}
