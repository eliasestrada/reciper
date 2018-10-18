<?php

namespace Tests\Feature\Scrips;

use App\Jobs\TopRecipersJob;
use Carbon\Carbon;
use Tests\TestCase;

class TopRecipersJobScriptTest extends TestCase
{
    /** @test */
    public function where_statement_in_Like_query_must_be_correct(): void
    {
        $this->assertTrue($this->state(Carbon::yesterday()->setTime(0, 0, 0)->toDateTimeString()));
        $this->assertTrue($this->state(Carbon::yesterday()->setTime(23, 59, 59)->toDateTimeString()));
        $this->assertFalse($this->state(Carbon::yesterday()->setTime(23, 59, 59)->addSecond()->toDateTimeString()));
    }

    /** @test */
    public function convertArrayToNeededFormat_method_return_proper_array(): void
    {
        $result = (new TopRecipersJob)->convertArrayToNeededFormat([
            'bogdan', 'bogdan', 'bogdan', 'valya',
        ]);

        $this->assertCount(2, $result);
        $this->assertEquals(3, $result['bogdan']);
        $this->assertEquals(1, $result['valya']);
    }

    /**
     * @param $date
     * @return boolean
     */
    public function state($date): bool
    {
        $yesterday = Carbon::yesterday();
        return $date >= $yesterday->startOfDay() && $date <= $yesterday->endOfDay() ? true : false;
    }
}
