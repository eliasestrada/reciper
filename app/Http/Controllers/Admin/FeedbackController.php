<?php

namespace App\Http\Controllers\Admin;

use App\Models\Feedback;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Responses\Controllers\Admin\Feedback\IndexResponse;

class FeedbackController extends Controller
{
    /**
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Show all reports and feedback
     * Mark user as he saw these messages
     *
     * @return \App\Http\Responses\Controllers\Admin\Feedback\IndexResponse
     */
    public function index(): IndexResponse
    {
        return new IndexResponse;
    }

    /**
     * Display single feedback message
     *
     * @param \App\Models\Feedback $feedback
     * @return \Illuminate\View\View
     */
    public function show(Feedback $feedback): View
    {
        return view('admin.feedback.show', compact('feedback'));
    }

    /**
     * Remove feedback message from database
     *
     * @param \App\Models\Feedback $feedback
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Feedback $feedback): RedirectResponse
    {
        $feedback->delete();

        cache()->forget('feedback_notif');

        return redirect('/admin/feedback')->withSuccess(
            trans('admin.feedback_has_been_deleted')
        );
    }
}
