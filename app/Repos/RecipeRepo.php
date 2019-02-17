<?php

namespace App\Repos;

use App\Models\Recipe;
use Illuminate\Database\QueryException;

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
     * @return mixed
     */
    public function paginateMyApproves()
    {
        try {
            return Recipe::oldest()
                ->where(_('approver_id', true), user()->id)
                ->done(1)
                ->paginate(30)
                ->onEachSide(1);
        } catch (QueryException $e) {
            no_connection_rror($e, __CLASS__);
            return collect();
        }
    }

    /**
     * @return int
     */
    public function getIdOfTheRecipeThatUserIsChecking(): ?int
    {
        try {
            return Recipe::where(_('approver_id', true), user()->id)
                ->approved(0)
                ->ready(1)
                ->value('id');
        } catch (QueryException $e) {
            no_connection_rror($e, __CLASS__);
            return null;
        }
    }
}
