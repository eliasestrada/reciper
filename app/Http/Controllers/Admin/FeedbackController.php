<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
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
        cache()->forget('all_feedback');

        User::whereId(user()->id)->update([
            'contact_check' => now(),
        ]);

        return view('admin.feedback.index', [
            'feedback_ru' => Feedback::whereLang('ru')->paginate(20)->onEachSide(1),
            'feedback_en' => Feedback::whereLang('en')->paginate(20)->onEachSide(1),
        ]);
    }

    /**
     * Store a newly created report in storage.
     *
     * @param ContactRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContactRequest $request)
    {
        cache()->forget('all_feedback');

        Feedback::create([
            'is_report' => is_null($request->recipe) ? 0 : 1,
            'lang' => lang(),
            'visitor_id' => visitor_id(),
            'recipe_id' => $request->recipe,
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
        // Check for correct user
        if (!user()->hasRole('admin')) {
            return redirect('/feedback')->withError(
                trans('admin.only_admin_can_delete')
            );
        }

        Feedback::findOrFail($id)->delete();

        cache()->forget('all_feedback');

        return redirect('/admin/feedback')->withSuccess(
            trans('admin.feedback_has_been_deleted')
        );
    }
}
