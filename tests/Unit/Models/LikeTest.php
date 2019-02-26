<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Like;

class LikeTest extends TestCase
{
    /**
     * @author Cho
     * @test
     */
    public function like_model_has_attributes(): void
    {
        $this->assertClassHasAttribute('guarded', Like::class);
        $this->assertClassHasAttribute('timestamps', Like::class);
    }
}
