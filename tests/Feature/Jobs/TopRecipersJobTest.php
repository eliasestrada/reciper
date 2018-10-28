<?php

namespace Tests\Unit\Jobs;

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
     * @test
     */
    public function makeCachedListOfToprecipers_method_returns_empty_array_if_there_are_no_likes_yesterday(): void
    {
        $method = (new TopRecipersJob)->makeCachedListOfToprecipers();
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

        $result = (new TopRecipersJob)->makeCachedListOfToprecipers();

        $this->assertArrayHasKey($first_recipe->user->username, $result);
        $this->assertArrayHasKey($second_recipe->user->username, $result);
    }

    /**
     * @author Cho
     * @test
     */
    public function makeCachedListOfToprecipers_method_caches_reciper_username_whos_recipe_were_liked_yesterday(): void
    {
        cache()->forget('top_recipers');

        Like::create([
            'visitor_id' => 1,
            'recipe_id' => ($recipe = create(Recipe::class))->id,
            'created_at' => Carbon::yesterday()->startOfDay(),
        ]);

        $result = (new TopRecipersJob)->makeCachedListOfToprecipers();

        $this->assertArrayHasKey($recipe->user->username, cache()->get('top_recipers'));
    }

    /**
     * @author Cho
     * @test
     */
    public function combineArrayValues_method_returns_combined_values_and_their_amount(): void
    {
        // 3 - bogdan and 1 - valya
        $result = (new TopRecipersJob)->combineArrayValues([
            'bogdan', 'bogdan', 'bogdan', 'valya',
        ]);

        $this->assertEquals(3, $result['bogdan']);
        $this->assertEquals(1, $result['valya']);
    }
}
