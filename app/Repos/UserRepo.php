<?php

namespace App\Repos;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepo
{
    /**
     * @throws \Illuminate\Database\QueryException
     * @param int|null $id
     * @return \App\Models\User|null
     */
    public function find(?int $id): ?User
    {
        try {
            return User::find($id);
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
