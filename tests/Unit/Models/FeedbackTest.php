<?php

namespace Tests\Unit\Models;

use App\Models\Feedback;
use Tests\TestCase;

class FeedbackTest extends TestCase
{
    /** @test */
    public function model_has_attributes(): void
    {
        $this->assertClassHasAttribute('guarded', Feedback::class);
        $this->assertClassHasAttribute('timestamps', Feedback::class);
    }
}
