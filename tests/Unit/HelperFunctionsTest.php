<?php

namespace Tests\Unit;

use App\Models\Recipe;
use App\Models\User;
use Tests\TestCase;

class HelperFunctionsTest extends TestCase
{
    /**
     * @test
     * @return void
     */
    public function convert_to_array_of_list_items_helper_returns_array(): void
    {
        $string = 'First line
            Second line';

        $result = convertToArrayOfListItems($string);

        $this->assertCount(2, $result);
        $this->assertEquals('<li>First line</li>', $result[0]);
    }
    /**
     * @test
     * @return void
     */
    public function check_get_data_notif_markup_helper(): void
    {
        $this->assertEquals(getDataNotifMarkup(0), '');
        $this->assertEquals(getDataNotifMarkup(-1), '');
        $this->assertEquals(getDataNotifMarkup(1), 'data-notif=1');
    }

    /**
     * @test
     * @return void
     */
    public function get_online_icon_helper_should_return_correct_state(): void
    {
        // Icon should be on ===================
        array_map(function ($second) {
            $current = getOnlineIcon("30 $second " . trans("date.ago"));
            $this->assertEquals('<span class="online-icon-on"></span>', $current);
        }, [trans('date.second'), trans('date.seconds'), trans('date.seconds2')]);

        // Icon should be off ===================
        array_map(function ($minute) {
            $current = getOnlineIcon("30 $minute " . trans("date.ago"));
            $this->assertEquals('<span class="online-icon-off"></span>', $current);
        }, [trans('date.minute'), trans('date.minutes'), trans('date.minutes2')]);
    }

    /**
     * @test
     * @return void
     */
    public function readable_number_helper_converts_data_correctly(): void
    {
        $thousand = trans('users.thousand');
        $million = trans('users.million');

        $this->assertEquals(readableNumber(999), 999);
        $this->assertEquals(readableNumber(1000), "1<br /><small>$thousand</small>");
        $this->assertEquals(readableNumber(1000000), "1<br /><small>$million</small>");
    }

    /**
     * @test
     * @return void
     */
    public function get_rating_number_helper_returns_correct_rating(): void
    {
        $user = make(User::class);
        $recipes = [make(Recipe::class, ['user_id' => $user->id])];

        $this->assertEquals(getRatingNumber($recipes, $likes = 11), 2.1);
        $this->assertEquals(getRatingNumber($recipes, $likes = -11), 1);
    }

    /**
     * @test
     * @return void
     */
    public function active_if_route_is_helper_returns_active_string(): void
    {
        $this->get('/recipes');
        $this->assertEquals(activeIfRouteIs('/recipes'), 'active');
        $this->assertEquals(activeIfRouteIs('recipes'), 'active');
    }
}
