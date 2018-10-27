<?php

namespace Tests\Unit\Models;

use App\Models\Like;
use Tests\TestCase;

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
