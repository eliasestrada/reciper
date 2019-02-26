<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\View;

class ViewTest extends TestCase
{
    /**
     * @author Cho
     * @test
     */
    public function view_model_has_attributes(): void
    {
        $this->assertClassHasAttribute('guarded', View::class);
        $this->assertClassHasAttribute('timestamps', View::class);
    }
}
