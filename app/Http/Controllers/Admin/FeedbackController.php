<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Http\Requests\FeedbackRequest;
use App\Models\Feedback;
use App\Models\User;

class FeedbackController extends Controller
{
    /**
     * Show all reports and feedback
     * Mark user as he saw these messages
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
     * Refactore
     * @param ContactRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(FeedbackRequest $request)
    {
        cache()->forget('feedback_notif');

        // If already send feedback today, return with error message
        if (is_null($request->recipe_id)) {
            $alredy_send = Feedback::whereVisitorId(visitor_id())->where('created_at', '>', now()->subDay());

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
            'is_report' => is_null($request->recipe) ? 0 : 1,
            'lang' => LANG(),
            'visitor_id' => visitor_id(),
            'email' => $request->email ?? null,
            'recipe_id' => $request->recipe_id,
            'message' => $request->message,
        ]);

        return back()->withSuccess(trans('feedback.success_message'));
    }

    /**
     * Display single message
     *
     * @param  Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function show(Feedback $feedback)
    {
        return view('admin.feedback.show', compact('feedback'));
    }

    /**
     * Remove message from storage
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Feedback::findOrFail($id)->delete();

        cache()->forget('feedback_notif');

        return redirect('/admin/feedback')->withSuccess(
            trans('admin.feedback_has_been_deleted')
        );
    }
}
