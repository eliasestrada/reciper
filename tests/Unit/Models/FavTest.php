<?php

namespace Tests\Unit\Models;

use App\Models\Fav;
use Tests\TestCase;

class FavTest extends TestCase
{
    /**
     * @author Cho
     * @test
     */
    public function model_has_attributes(): void
    {
        $this->assertClassHasAttribute('guarded', Fav::class);
        $this->assertClassHasAttribute('timestamps', Fav::class);
    }
}
