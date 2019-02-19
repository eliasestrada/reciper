<?php

namespace App\Repos;

use App\Models\Recipe;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;

class RecipeRepo
{
    /**
     * @return mixed
     */
    public function paginateUnapprovedWaiting()
    {
        try {
            return Recipe::oldest()
                ->where(_('approver_id', true), 0)
                ->approved(0)
                ->ready(1)
                ->paginate(30)
                ->onEachSide(1);
        } catch (QueryException $e) {
            no_connection_rror($e, __CLASS__);
            return collect();
        }
    }

    /**
     * @return mixed
     */
    public function paginateUnapprovedChecking()
    {
        try {
            return Recipe::oldest()
                ->where(_('approver_id', true), '!=', 0)
                ->approved(0)
                ->ready(1)
                ->paginate(30)
                ->onEachSide(1);
        } catch (QueryException $e) {
            no_connection_rror($e, __CLASS__);
            return collect();
        }
    }

    /**
     * @param int $user_id
     * @return mixed
     */
    public function paginateMyApproves(int $user_id)
    {
        try {
            return Recipe::oldest()
                ->where(_('approver_id', true), $user_id)
                ->done(1)
                ->paginate(30)
                ->onEachSide(1);
        } catch (QueryException $e) {
            no_connection_rror($e, __CLASS__);
            return collect();
        }
    }

    /**
     * @param int $user_id
     * @return int
     */
    public function getIdOfTheRecipeThatUserIsChecking(int $user_id): ?int
    {
        try {
            return Recipe::where(_('approver_id', true), $user_id)
                ->approved(0)
                ->ready(1)
                ->value('id');
        } catch (QueryException $e) {
            no_connection_rror($e, __CLASS__);
            return null;
        }
    }

    /**
     * @param int|null $pagin Pagination value
     * @return \Illuminate\Pagination\LengthAwarePaginator|null
     */
    public function paginateByLikes(?int $pagin = 8): ?LengthAwarePaginator
    {
        try {
            return Recipe::withCount('likes')
                ->orderBy('likes_count', 'desc')
                ->done(1)
                ->paginate($pagin);
        } catch (QueryException $e) {
            no_connection_rror($e, __CLASS__);
            return null;
        }
    }

    /**
     * @param int|null $pagin Pagination value
     * @return \Illuminate\Pagination\LengthAwarePaginator|null
     */
    public function paginateAllSimple(?int $pagin = 8): ?LengthAwarePaginator
    {
        try {
            return Recipe::whereSimple(1)->done(1)->paginate($pagin);
        } catch (QueryException $e) {
            no_connection_rror($e, __CLASS__);
            return null;
        }
    }
}
