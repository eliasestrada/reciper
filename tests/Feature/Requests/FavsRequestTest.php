<?php

namespace Tests\Feature\Requests;

use Tests\TestCase;
use App\Models\User;

class FavsRequestTest extends TestCase
{
    /**
     * @test
     */
    public function user_cant_add_recipe_to_favs_if_there_are_no_recipe_with_this_id(): void
    {
        $this->actingAs(new User)
            ->post(action('Api\FavController@store', ['id' => 99999]))
            ->assertStatus(404);
    }

    /**
     * @test
     */
    public function user_cant_add_recipe_to_favs_if_recipe_id_is_incorrect(): void
    {
        $this->actingAs(new User)
            ->post(action('Api\FavController@store', ['id' => 'f']))
            ->assertStatus(404);
    }
}
