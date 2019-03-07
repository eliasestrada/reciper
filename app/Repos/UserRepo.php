<?php

namespace App\Repos;

use App\Models\User;
use Illuminate\Database\QueryException;

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
}
