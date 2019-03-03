<?php

namespace Tests\Unit\Helpers;

use File;
use Mockery;
use Tests\TestCase;
use App\Models\Visitor;

class FunctionsTest extends TestCase
{
    /**
     * @author Cho
     * @test
     */
    public function toArrayOfListItems_helper_returns_array(): void
    {
        $string = "First line\nSecond line";
        $result = to_array_of_list_items($string);

        $this->assertCount(2, $result);
        $this->assertEquals('<li>First line</li>', $result[0]);
        $this->assertEquals('<li>Second line</li>', $result[1]);
    }

    /**
     * @author Cho
     * @test
     */
    public function toArrayOfListItems_helper_removes_empty_lines(): void
    {
        $this->assertCount(0, to_array_of_list_items("\n\n\n"));
        $this->assertCount(1, to_array_of_list_items("First \n"));
        $this->assertCount(2, to_array_of_list_items("First \n Second \n"));
    }

    /**
     * @author Cho
     * @test
     */
    public function get_online_icon_helper_should_return_correct_state(): void
    {
        // Icon should be on ===================
        array_map(function ($second) {
            $current = get_online_icon("30 {$second} " . trans("date.ago"));
            $this->assertEquals('<span class="online-icon-on"></span>', $current);
        }, [trans('date.second'), trans('date.seconds'), trans('date.seconds2')]);

        // Icon should be off ===================
        array_map(function ($minute) {
            $current = get_online_icon("30 {$minute} " . trans("date.ago"));
            $this->assertEquals('<span class="online-icon-off"></span>', $current);
        }, [trans('date.minute'), trans('date.minutes'), trans('date.minutes2')]);
    }

    /**
     * @author Cho
     * @dataProvider readableNumberHelperDataProvider
     * @test
     */
    public function readable_number_helper_converts_data_correctly($num_before, $num_after, $prefix): void
    {
        $prefix = $prefix ? trans($prefix) : '';
        $expect = "{$num_after}<br><small>{$prefix}</small>";
        $this->assertEquals($expect, readable_number($num_before));
    }

    /**
     * @return array
     */
    public function readableNumberHelperDataProvider()
    {
        return [
            [899, 899, ''], // 1
            [900, 1, 'users.thousand'], // 2
            [899499, 899, 'users.thousand'], // 3
            [900000, 1, 'users.million'], // 4
            [899999999, 900, 'users.million'], // 5
            [900000000, 1, 'users.billion'], // 6
            [899999999999, 900, 'users.billion'], // 7
            [900000000000, 1, 'users.trillion'], // 8
            [899999999999999, 900, 'users.trillion'], // 9
        ];
    }

    /**
     * @author Cho
     * @test
     */
    public function active_if_route_is_helper_returns_active_string(): void
    {
        $this->get('/');
        $this->assertEquals('active', active_if_route_is(['/', 'settings']));

        $this->get('/contact');
        $this->assertEquals('active', active_if_route_is(['/recipes', 'contact']));

        $this->get('/search');
        $this->assertEquals('active', active_if_route_is(['/search']));
    }

    /**
     * @author Cho
     * @test
     */
    public function visitor_id_function_returns_correct_data(): void
    {
        $expected = make(Visitor::class)->value('id');
        $this->assertEquals($expected, visitor_id());
    }

    /**
     * @author Cho
     * @test
     */
    public function report_error_function_flashes_message_and_logs_given_error(): void
    {
        $exception = Mockery::mock('Exception');
        $exception->shouldReceive('getMessage')->andReturn('Lorem');
        $date = date('Y-m-d');

        report_error($exception);

        $this->assertFileExists(storage_path("logs/laravel-{$date}.log"));
        $this->get('/')->assertSessionHas('error', trans('messages.query_error'));

        File::delete(storage_path("logs/laravel-{$date}.log"));
    }
}
