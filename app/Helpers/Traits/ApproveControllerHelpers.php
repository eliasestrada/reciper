<?php

namespace App\Helpers\Traits;

use App\Models\Recipe;

trait ApproveControllerHelpers
{
    /**
     * @param \App\Models\Recipe $recipe
     * @return string|null
     */
    public function returnErrorIfApprovedOrNotReady(Recipe $recipe): ?string
    {
        if ($recipe->isDone()) {
            return trans('approves.already_approved');
        }

        if (!$recipe->isReady() && !$recipe->isApproved()) {
            return trans('recipes.not_written');
        }
        return null;
    }
}
