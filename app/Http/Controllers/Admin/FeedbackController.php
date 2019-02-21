<?php

namespace App\Http\Controllers\Admin;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use App\Models\Feedback;
use App\Http\Responses\Controllers\Admin\Feedback\StoreResponse;
use App\Http\Responses\Controllers\Admin\Feedback\IndexResponse;
use App\Http\Requests\FeedbackRequest;
use App\Http\Controllers\Controller;

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
     * @return \App\Http\Responses\Controllers\Admin\Feedback\IndexResponse
     */
    public function index(): IndexResponse
    {
        return new IndexResponse;
    }

    /**
     * Store a newly created report or feedback in database
     *
     * @param \App\Http\Requests\FeedbackRequest $request
     * @return \App\Http\Responses\Controllers\Admin\Feedback\StoreResponse
     */
    public function store(FeedbackRequest $request): StoreResponse
    {
        return new StoreResponse;
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
