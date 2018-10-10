<?php

namespace Tests\Feature;

use App\Models\Like;
use App\Models\Recipe;
use App\Models\Visitor;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TopRecipersJobTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function job_must_cache_list_of_top_recipers_in_certain_amount(): void
    {
        $amount = config('cache.other.amount_of_top_recipers');
        cache()->flush();
        $recipes = collect([
            create(Recipe::class),
            create(Recipe::class),
            create(Recipe::class),
            create(Recipe::class),
        ]);

        // 3 likes for first recipe, 2 likes for second and 1 like for the third
        $indexes_of_liked_recipes = [0, 0, 0, 2, 2, 3];

        foreach ($indexes_of_liked_recipes as $value) {
            $visitor = Visitor::where('id', '!=', $recipes[$value]->user->visitor->id)->inRandomOrder()->first();
            Like::create([
                'visitor_id' => $visitor->id,
                'recipe_id' => $recipes[$value]->id,
                'created_at' => now()->subDay(),
            ]);
        }

        $this->fakeHandle();

        $cache = cache()->get('top_recipers');
        $this->assertCount(3, $cache);
        $this->assertEquals($recipes[0]->user->id, $cache[0]['id']);
        $this->assertEquals($recipes[2]->user->id, $cache[1]['id']);
        $this->assertEquals($recipes[3]->user->id, $cache[2]['id']);
    }

    /**
     * @
     */
    public function fakeHandle()
    {
        $users = Like::whereCreatedAt(now()->subDay())->get()->map(function ($like) {
            return $like->recipe->user->id . '<split>' . $like->recipe->user->name;
        })->toArray();

        $users = array_slice(array_reverse(array_sort(array_count_values($users))), 0, 7);

        $top_recipers = [];

        foreach ($users as $name => $value) {
            $explode = explode('<split>', $name);
            array_push($top_recipers, [
                'id' => $explode[0],
                'name' => $explode[1],
            ]);
        }
        cache()->put('top_recipers', $top_recipers, 1440);
    }
}
