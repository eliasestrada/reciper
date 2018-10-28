<?php

namespace Tests\Feature\Jobs;

use App\Jobs\DeleteUnactiveUsersJob;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class Test extends TestCase
{
    use DatabaseTransactions;

    private $job;

    /**
     * @author Cho
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->job = new DeleteUnactiveUsersJob;
    }

    /**
     * @author Cho
     * @test
     */
    public function handle_method_deletes_all_unactive_users_that_have_not_been_updated_30_days_or_more(): void
    {
        $unactive_users = [
            'first' => create_user('', ['active' => 0, 'updated_at' => now()->subDays(31)]),
            'second' => create_user('', ['active' => 0, 'updated_at' => now()->subDays(30)]),
        ];

        $this->withoutJobs();
        $this->job->handle();

        $this->assertDatabaseMissing('users', ['id' => $unactive_users['first']->id]);
        $this->assertDatabaseMissing('users', ['id' => $unactive_users['second']->id]);
    }

    /**
     * @author Cho
     * @test
     */
    public function handle_method_doesnt_delete_unactive_users_that_have_not_been_updated_less_than_30_days(): void
    {
        $unactive_users = [
            'first' => create_user('', ['active' => 0, 'updated_at' => now()->subDays(29)]),
            'second' => create_user('', ['active' => 0, 'updated_at' => now()->subDays(28)]),
        ];

        $this->withoutJobs();
        $this->job->handle();

        $this->assertDatabaseHas('users', ['id' => $unactive_users['first']->id]);
        $this->assertDatabaseHas('users', ['id' => $unactive_users['second']->id]);
    }

    /**
     * @author Cho
     * @test
     */
    public function handle_method_doesnt_delete_active_users_that_have_not_been_updated(): void
    {
        $active_users = [
            'first' => create_user('', ['updated_at' => now()->subMonth()]),
            'second' => create_user('', ['updated_at' => now()->subYear()]),
        ];

        $this->withoutJobs();
        $this->job->handle();

        $this->assertDatabaseHas('users', ['id' => $active_users['first']->id]);
        $this->assertDatabaseHas('users', ['id' => $active_users['second']->id]);
    }

    /**
     * @author Cho
     * @test
     */
    public function handle_method_dispaches_DeletePhotoJob_when_deletes_user(): void
    {
        $this->expectsJobs(\App\Jobs\DeletePhotoJob::class);

        $unactive_user = create_user('', [
            'active' => 0,
            'photo' => 'some.jpg',
            'updated_at' => now()->subMonths(2),
        ]);
        $this->job->handle();
    }

    /**
     * @author Cho
     * @test
     */
    public function handle_method_deletes_unactive_users_even_if_they_have_some_roles(): void
    {
        $unactive_users = [
            'admin' => create_user('admin', ['active' => 0, 'updated_at' => now()->subMonth()]),
            'master' => create_user('master', ['active' => 0, 'updated_at' => now()->subYear()]),
        ];

        $this->withoutJobs();
        $this->job->handle();

        $this->assertDatabaseMissing('users', ['id' => $unactive_users['admin']->id]);
        $this->assertDatabaseMissing('users', ['id' => $unactive_users['master']->id]);
    }

    /**
     * @author Cho
     * @test
     */
    public function handle_method_deletes_unactive_user_even_if_he_has_favorite_recipe(): void
    {
        $user = create_user('', ['active' => 0, 'updated_at' => now()->subMonth()]);
        $recipe_id = create(Recipe::class)->id;

        $user->favs()->create(compact('recipe_id'));

        $this->withoutJobs();
        $this->job->handle();

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
