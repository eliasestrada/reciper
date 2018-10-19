<?php

namespace Tests\Feature\Models;

use App\Models\Like;
use Tests\TestCase;

class LikeTest extends TestCase
{
    /** @test */
    public function model_has_attributes(): void
    {
        $this->assertClassHasAttribute('guarded', Like::class);
        $this->assertClassHasAttribute('timestamps', Like::class);
    }
}
