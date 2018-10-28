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
    public function makeListOfTopRecipers_method_returns_empty_array_if_there_are_no_likes_yesterday(): void
    {
        $method = (new TopRecipersJob)->makeListOfTopRecipers();
        $this->assertTrue(is_array($method));
    }

    /**
     * @author Cho
     * @test
     */
    public function makeListOfTopRecipers_method_returns_recipers_usernames_whos_recipes_were_liked_yesterday(): void
    {
        $recipes = [
            'first' => create(Recipe::class),
            'second' => create(Recipe::class),
        ];

        $likes = [
            'first' => Like::create([
                'visitor_id' => 1,
                'recipe_id' => $recipes['first']->id,
                'created_at' => Carbon::yesterday()->startOfDay(),
            ]),
            'second' => Like::create([
                'visitor_id' => 1,
                'recipe_id' => $recipes['second']->id,
                'created_at' => Carbon::yesterday()->endOfDay(),
            ]),
        ];

        $result = (new TopRecipersJob)->makeListOfTopRecipers();

        $this->assertArrayHasKey($recipes['first']->user->username, $result);
        $this->assertArrayHasKey($recipes['second']->user->username, $result);
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
