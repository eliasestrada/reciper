<?php

namespace Tests\Feature\Api;

use App\Models\Like;
use App\Models\Recipe;
use App\Models\Visitor;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PostRequestTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @author Cho
     * @test
     */
    public function like_is_added_after_visitor_makes_like_post_request(): void
    {
        $visitor = make(Visitor::class);
        $this->post('/api/like/like/1', ['ip' => $visitor->ip]);
        $this->assertCount(1, Recipe::first()->likes);
    }

    /**
     * @author Cho
     * @test
     */
    public function like_is_removed_after_visitor_makes_dislike_post_request(): void
    {
        Like::create(['recipe_id' => 1, 'visitor_id' => 1]);

        $this->post('/api/like/dislike/1', ['ip' => '127.0.0.1']);
        $this->assertCount(0, Recipe::first()->likes);
    }

    /**
     * @author Cho
     * @test
     */
    public function request_returns_1_if_visitor_liked_the_recipe_before(): void
    {
        Like::create(['recipe_id' => 1, 'visitor_id' => 1]);
        $response = $this->post('/api/like/check/1', ['ip' => '127.0.0.1']);
        $response->assertOk();
        $this->assertEquals(1, $response->original);
    }

    /**
     * @author Cho
     * @test
     */
    public function request_returns_0_if_visitor_did_not_like_the_recipe_before(): void
    {
        $response = $this->post('/api/like/check/1', ['ip' => '127.0.0.1']);
        $response->assertOk();
        $this->assertEquals(0, $response->original);
    }
}
