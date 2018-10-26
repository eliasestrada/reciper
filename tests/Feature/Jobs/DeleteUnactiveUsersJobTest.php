<?php

namespace Tests\Feature\Jobs;

use App\Jobs\DeleteUnactiveUsersJob;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DeleteUnactiveUsersJobTest extends TestCase
{
    use DatabaseTransactions;

    private $job;

    public function setUp()
    {
        parent::setUp();
        $this->job = new DeleteUnactiveUsersJob();
    }

    /** @test */
    public function job_deletes_users_that_deactivated_more_than_30_days(): void
    {
        $user_with_30_days = create_user('', ['updated_at' => now()->subDays(30), 'active' => 0]);
        $user_with_29_days = create_user('', ['updated_at' => now()->subDays(29), 'active' => 0]);

        $this->job->handle();
        $this->assertDatabaseHas('users', ['id' => $user_with_29_days->id]);
        $this->assertDatabaseMissing('users', ['id' => $user_with_30_days->id]);
    }
}
