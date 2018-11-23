<?php

namespace Tests\Feature\Api;

use App\Models\Like;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PostRequestTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @author Cho
     * @test
     */
    public function like_is_added_after_user_makes_like_post_request(): void
    {
        $this->actingAs(create_user())->post('/likes/1');
        $this->assertCount(1, Recipe::first()->likes);
    }

    /**
     * @author Cho
     * @test
     */
    public function like_is_removed_after_user_makes_second_like_post_request(): void
    {
        $user = create_user();
        Like::create(['recipe_id' => 1, 'user_id' => $user->id]);

        $this->actingAs($user)->post('/likes/1');
        $this->assertCount(0, Recipe::first()->likes);
    }
}
