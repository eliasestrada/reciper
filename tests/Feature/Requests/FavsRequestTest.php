<?php

namespace Tests\Feature\Requests;

use App\Models\User;
use Tests\TestCase;

class FavsRequestTest extends TestCase
{
    /**
     * @author Cho
     * @test
     */
    public function user_cant_add_recipe_to_favs_if_there_are_no_recipe_with_this_id(): void
    {
        $this->actingAs(new User)
            ->post(action('Api\FavController@store', ['id' => 99999]))
            ->assertStatus(404);
    }

    /**
     * @author Cho
     * @test
     */
    public function user_cant_add_recipe_to_favs_if_recipe_id_is_incorrect(): void
    {
        $this->actingAs(new User)
            ->post(action('Api\FavController@store', ['id' => 'f']))
            ->assertStatus(404);
    }
}
