<?php

namespace App\Repos;

use App\Models\Feedback;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;

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

    /**
     * @param int $visitor_id
     * @return bool
     */
    public static function alreadyContactedToday(int $visitor_id): ?bool
    {
        try {
            return Feedback::where([
                ['visitor_id', $visitor_id],
                ['created_at', '>', now()->subDay()],
            ])->exists();
        } catch (QueryException $e) {
            no_connection_error($e, __CLASS__);
            return null;
        }
    }

    /**
     * @param string $lang
     * @return \Illuminate\Pagination\LengthAwarePaginator|null
     */
    public static function paginateWithLanguage(string $lang): ?LengthAwarePaginator
    {
        try {
            return Feedback::whereLang($lang)->latest()->paginate(20)->onEachSide(1);
        } catch (QueryException $e) {
            no_connection_error($e, __CLASS__);
            return null;
        }
    }
}
