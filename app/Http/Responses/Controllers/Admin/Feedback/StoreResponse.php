<?php

namespace App\Http\Responses\Controllers\Admin\Feedback;

use App\Models\Feedback;
use App\Repos\FeedbackRepo;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;

class StoreResponse implements Responsable
{
    /**
     * \App\Repos\FeedbackRepo
     */
    protected $repo;

    /**
     * @return void
     */
    public function __construct()
    {
        $this->repo= new FeedbackRepo;
    }

    /**
     * @throws \Illuminate\Database\QueryException
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|null
     */
    public function toResponse($request): ?RedirectResponse
    {
        cache()->forget('feedback_notif');

        if ($request->recipe_id) {
            if ($this->repo->alreadyReportedToday(visitor_id(), $request->recipe_id)) {
                return back()->withError(trans('feedback.already_reported_today'));
            }
        } else {
            if ($this->repo->alreadyContactedToday(visitor_id())) {
                return back()->withError(trans('feedback.operation_denied'));
            }
        }

        try {
            $this->createFeedback($request);
            return back()->withSuccess(trans('feedback.success_message'));
        } catch (QueryException $e) {
            return report_error($e);
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
