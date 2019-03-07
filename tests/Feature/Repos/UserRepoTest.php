<?php

namespace Tests\Feature\Repos;

use Tests\TestCase;
use App\Models\User;
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
        $user = create(User::class);
        $result = $this->repo->find($user->id);
        $this->assertEquals($user->toBase(), $result->toBase());
    }
}
