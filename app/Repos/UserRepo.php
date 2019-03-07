<?php

namespace App\Repos;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepo
{
    /**
     * @throws \Illuminate\Database\QueryException
     * @param string|null $username
     * @return \App\Models\User|null
     */
    public function find(?string $username): ?User
    {
        try {
            return User::whereUsername($username)->first();
        } catch (QueryException $e) {
            return report_error($e);
        }
    }

    /**
     * @throws \Illuminate\Database\QueryException
     * @param int|null $pagin
     * @return Illuminate\Pagination\LengthAwarePaginator|null
     */
    public function paginateActiveUsers(?int $pagin = 36): ?LengthAwarePaginator
    {
        try {
            return User::whereActive(1)
                ->orderBy('name')
                ->paginate($pagin)
                ->onEachSide(1);
        } catch (QueryException $e) {
            return report_error($e);
        }
    }
}
