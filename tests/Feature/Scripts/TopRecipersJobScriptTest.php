<?php

namespace Tests\Feature\Scrips;

use App\Jobs\TopRecipersJob;
use App\Models\Like;
use App\Models\Recipe;
use App\Models\Visitor;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TopRecipersJobScriptTest extends TestCase
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
        // last like in array should not be counted
        $data = [
            ['id' => 0, 'hours' => 0],
            ['id' => 0, 'hours' => 9],
            ['id' => 0, 'hours' => 13],
            ['id' => 2, 'hours' => 17],
            ['id' => 2, 'hours' => 20],
            ['id' => 3, 'hours' => 23],
            ['id' => 1, 'hours' => 24],
        ];

        foreach ($data as $value) {
            $visitor = Visitor::where('id', '!=', $recipes[$value['id']]->user->visitor->id)->inRandomOrder()->first();
            Like::create([
                'visitor_id' => $visitor->id,
                'recipe_id' => $recipes[$value['id']]->id,
                'created_at' => Carbon::yesterday()->addHours($value['hours']),
            ]);
        }

        (new TopRecipersJob)->bestReciperOfYesterdayScript();

        $cache = cache()->get('top_recipers');
        $this->assertCount(3, $cache);

        $this->assertEquals($recipes[0]->user->id, $cache[0]['id']);
        $this->assertEquals($recipes[2]->user->id, $cache[1]['id']);
        $this->assertEquals($recipes[3]->user->id, $cache[2]['id']);
    }
}
