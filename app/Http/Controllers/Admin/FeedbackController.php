<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FeedbackRequest;
use App\Models\Feedback;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FeedbackController extends Controller
{
    /**
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin')->except(['store']);
    }

    /**
     * Show all reports and feedback
     * Mark user as he saw these messages
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        cache()->forget('feedback_notif');

        User::whereId(user()->id)->update([
            'contact_check' => now(),
        ]);

        return view('admin.feedback.index', [
            'feedback_ru' => Feedback::whereLang('ru')->latest()->paginate(20)->onEachSide(1),
            'feedback_en' => Feedback::whereLang('en')->latest()->paginate(20)->onEachSide(1),
        ]);
    }

    /**
     * Store a newly created report in storage.
     *
     * @param \App\Http\Requests\FeedbackRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(FeedbackRequest $request): RedirectResponse
    {
        cache()->forget('feedback_notif');

        // If already send feedback today, return with error message
        if (is_null($request->recipe_id)) {
            $alredy_send = Feedback::whereVisitorId(visitor_id())
                ->where('created_at', '>', now()->subDay());

            if ($alredy_send->exists()) {
                return back()->withError(trans('feedback.operation_denied'));
            }
        } else {
            $report_on_the_same_recipe = Feedback::where([
                ['visitor_id', '=', visitor_id()],
                ['recipe_id', '=', $request->recipe_id],
                ['created_at', '>', now()->subDay()],
            ]);

            if ($report_on_the_same_recipe->exists()) {
                return back()->withError(trans('feedback.already_reported_today'));
            }
        }

        Feedback::create([
            'is_report' => $request->recipe_id ? 1 : 0,
            'lang' => LANG(),
            'visitor_id' => visitor_id(),
            'email' => $request->email ?? null,
            'recipe_id' => $request->recipe_id,
            'message' => $request->message,
            'created_at' => now(),
        ]);

        return back()->withSuccess(trans('feedback.success_message'));
    }

    /**
     * Display single message
     *
     * @param \App\Models\Feedback $feedback
     * @return \Illuminate\View\View
     */
    public function show(Feedback $feedback): View
    {
        return view('admin.feedback.show', compact('feedback'));
    }

    /**
     * Remove message from storage
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        Feedback::findOrFail($id)->delete();

        cache()->forget('feedback_notif');

        return redirect('/admin/feedback')->withSuccess(
            trans('admin.feedback_has_been_deleted')
        );
    }
}
