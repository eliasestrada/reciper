<?php

namespace Tests\Feature\Jobs;

use App\Jobs\TopRecipersJob;
use App\Models\Like;
use App\Models\Recipe;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TopRecipersJobTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @author Cho
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->job = new TopRecipersJob;
    }
    /**
     * @author Cho
     * @test
     */
    public function makeCachedListOfToprecipers_method_returns_empty_array_if_there_are_no_likes_yesterday(): void
    {
        $method = $this->job->makeCachedListOfToprecipers();
        $this->assertTrue(is_array($method));
    }

    /**
     * @author Cho
     * @test
     */
    public function makeCachedListOfToprecipers_method_returns_recipers_usernames_whos_recipes_were_liked_yesterday(): void
    {
        Like::create([
            'visitor_id' => 1,
            'recipe_id' => ($first_recipe = create(Recipe::class))->id,
            'created_at' => Carbon::yesterday()->startOfDay(),
        ]);
        Like::create([
            'visitor_id' => 1,
            'recipe_id' => ($second_recipe = create(Recipe::class))->id,
            'created_at' => Carbon::yesterday()->endOfDay(),
        ]);

        $result = $this->job->makeCachedListOfToprecipers();

        $this->assertArrayHasKey($first_recipe->user->username, $result);
        $this->assertArrayHasKey($second_recipe->user->username, $result);
    }

    /**
     * @author Cho
     * @test
     */
    public function makeCachedListOfToprecipers_method_caches_reciper_username_whos_recipe_were_liked_yesterday(): void
    {
        Like::create([
            'visitor_id' => 1,
            'recipe_id' => ($recipe = create(Recipe::class))->id,
            'created_at' => Carbon::yesterday()->startOfDay(),
        ]);

        \Cache::shouldReceive('put')->once()->andReturn([
            $recipe->user->username => 1,
        ]);

        $this->job->makeCachedListOfToprecipers();
    }

    /**
     * @author Cho
     * @test
     */
    public function combineArrayValues_method_returns_combined_values_and_their_amount(): void
    {
        // 3 - bogdan and 1 - valya
        $result = $this->job->combineArrayValues([
            'bogdan', 'bogdan', 'bogdan', 'valya',
        ]);

        $this->assertEquals(3, $result['bogdan']);
        $this->assertEquals(1, $result['valya']);
    }

    /**
     * @author Cho
     * @test
     */
    public function saveWinnersToDatabase_method_saves_given_username_to_DB(): void
    {
        $result = $this->job->saveWinnersToDatabase(['user1' => 11]);
        $this->assertDatabaseHas('top_recipers', ['username' => 'user1']);
    }

    /**
     * @author Cho
     * @test
     */
    public function saveWinnersToDatabase_method_saves_usernames_with_higher_score(): void
    {
        $result = $this->job->saveWinnersToDatabase([
            'user1' => 11,
            'user2' => 11,
            'user3' => 9
        ]);
        $this->assertDatabaseHas('top_recipers', ['username' => 'user1']);
        $this->assertDatabaseHas('top_recipers', ['username' => 'user2']);
        $this->assertDatabaseMissing('top_recipers', ['username' => 'user3']);
    }
}
