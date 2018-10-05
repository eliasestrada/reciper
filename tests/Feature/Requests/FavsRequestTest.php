<?php

namespace Tests\Feature\Requests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class FavsRequestTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function user_cant_add_recipe_to_favs_if_there_are_no_recipe_with_this_id(): void
    {
        $this->actingAs(create_user())
            ->post(action('ApiFavsController@store', ['id' => 99999]))
            ->assertStatus(403)
            ->assertSeeText('fail');
    }

    /** @test */
    public function user_cant_add_recipe_to_favs_if_recipe_id_is_incorrect(): void
    {
        $this->actingAs(create_user())
            ->post(action('ApiFavsController@store', ['id' => 'f']))
            ->assertStatus(403)
            ->assertSeeText('fail');
    }
}
