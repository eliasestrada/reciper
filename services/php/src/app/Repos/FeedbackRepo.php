<?php

namespace App\Repos;

use App\Models\Feedback;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;

class FeedbackRepo
{
    /**
     * @throws \Illuminate\Database\QueryException
     * @param int $visitor_id
     * @param int $recipe_id
     * @return bool
     */
    public function alreadyReportedToday(int $visitor_id, int $recipe_id): ?bool
    {
        try {
            return Feedback::where([
                ['visitor_id', $visitor_id],
                ['recipe_id', $recipe_id],
                ['created_at', '>', now()->subDay()],
                ['is_report', 1],
            ])->exists();
        } catch (QueryException $e) {
            return report_error($e);
        }
    }

    /**
     * @throws \Illuminate\Database\QueryException
     * @param int $visitor_id
     * @return bool
     */
    public function alreadyContactedToday(int $visitor_id): ?bool
    {
        try {
            return Feedback::where([
                ['visitor_id', $visitor_id],
                ['created_at', '>', now()->subDay()],
            ])->exists();
        } catch (QueryException $e) {
            return report_error($e);
        }
    }

    /**
     * @throws \Illuminate\Database\QueryException
     * @param string $lang
     * @return \Illuminate\Pagination\LengthAwarePaginator|null
     */
    public function paginateWithLanguage(string $lang): ?LengthAwarePaginator
    {
        try {
            return Feedback::whereLang($lang)->latest()->paginate(20)->onEachSide(1);
        } catch (QueryException $e) {
            return report_error($e);
        }
    }

    /**
     * @throws \Illuminate\Database\QueryException
     * @param int $id
     * @return \App\Models\Feedback|null
     */
    public function find(int $id): ?Feedback
    {
        try {
            return Feedback::find($id);
        } catch (QueryException $e) {
            return report_error($e);
        }
    }
}
