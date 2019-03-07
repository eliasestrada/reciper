<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Feedback;

class FeedbackTest extends TestCase
{
    /**
     * @test
     */
    public function feedback_model_has_attributes(): void
    {
        $this->assertClassHasAttribute('guarded', Feedback::class);
        $this->assertClassHasAttribute('timestamps', Feedback::class);
    }
}
