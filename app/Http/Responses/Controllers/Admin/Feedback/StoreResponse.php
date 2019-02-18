<?php

namespace App\Http\Responses\Controllers\Admin\Feedback;

use App\Models\Feedback;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;

class StoreResponse implements Responsable
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|null
     */
    public function toResponse($request): ?RedirectResponse
    {
        cache()->forget('feedback_notif');

        if (is_null($request->recipe_id)) {
            // If already send feedback today, return with error message
            $alredy_send = Feedback::where([
                ['visitor_id', visitor_id()],
                ['created_at', '>', now()->subDay()],
            ]);

            if ($alredy_send->exists()) {
                return back()->withError(trans('feedback.operation_denied'));
            }
        } else {
            $report_on_the_same_recipe = Feedback::where([
                ['visitor_id', '=', visitor_id()],
                ['recipe_id', '=', $request->recipe_id],
                ['created_at', '>', now()->subDay()],
                ['is_report', 1],
            ]);

            if ($report_on_the_same_recipe->exists()) {
                return back()->withError(trans('feedback.already_reported_today'));
            }
        }

        try {
            $this->createFeedback($request);
            return back()->withSuccess(trans('feedback.success_message'));
        } catch (QueryException $e) {
            no_connection_error($e, __CLASS__);
            return null;
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    protected function createFeedback($request): void
    {
        Feedback::create([
            'is_report' => $request->recipe_id ? 1 : 0,
            'lang' => _(),
            'visitor_id' => visitor_id(),
            'email' => $request->email ?? null,
            'recipe_id' => $request->recipe_id,
            'message' => $request->message,
            'created_at' => now(),
        ]);
    }
}
