<?php

namespace App\Repos;

use App\Models\Feedback;
use Illuminate\Database\QueryException;

class FeedbackRepo
{
    /**
     * @param int $visitor_id
     * @param int $recipe_id
     * @return bool
     */
    public static function alreadyReportedToday(int $visitor_id, int $recipe_id): ?bool
    {
        try {
            return Feedback::where([
                ['visitor_id', $visitor_id],
                ['recipe_id', $recipe_id],
                ['created_at', '>', now()->subDay()],
                ['is_report', 1],
            ])->exists();
        } catch (QueryException $e) {
            no_connection_error($e, __CLASS__);
            return null;
        }
    }
}
