<?php

namespace Tests\Unit\Models;

use App\Models\Fav;
use Tests\TestCase;

class FavTest extends TestCase
{
    /**
     * @test
     */
    public function fav_model_has_attributes(): void
    {
        $this->assertClassHasAttribute('guarded', Fav::class);
        $this->assertClassHasAttribute('timestamps', Fav::class);
    }

    /**
     * @test
     */
    public function fav_model_has_relationship_with_user_model(): void
    {
        $fav = Fav::make([
            'user_id' => 1,
            'recipe_id' => 1,
        ]);
        $this->assertTrue($fav->user->exists());
    }
}
