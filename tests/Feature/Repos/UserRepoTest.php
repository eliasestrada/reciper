<?php

namespace Tests\Feature\Repos;

use Tests\TestCase;
use App\Repos\UserRepo;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserRepoTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var \App\Repos\UserRepo $repo
     */
    private $repo;

    /**
     * Setup the test environment
     * 
     * @author Cho
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->repo = new UserRepo;
    }

    /**
     * @author Cho
     * @test
     */
    public function method_find_returns_user_with_given_id(): void
    {
        $user = create_user();
        $result = $this->repo->find($user->id);
        $this->assertEquals($user->toBase(), $result->toBase());
    }

    /**
     * @author Cho
     * @test
     */
    public function method_paginateActiveUsers_returns_active_users(): void
    {
        $active_user = create_user();
        $result = $this->repo->paginateActiveUsers();
        $this->assertNotNull($result->where('id', $active_user->id)->first());
    }

    /**
     * @author Cho
     * @test
     */
    public function method_paginateActiveUsers_doesnt_return_not_active_users(): void
    {
        $not_active_user = create_user('not_active');
        $result = $this->repo->paginateActiveUsers();
        $this->assertNull($result->where('id', $not_active_user->id)->first());
    }
}
