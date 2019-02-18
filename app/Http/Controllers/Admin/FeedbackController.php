<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FeedbackRequest;
use App\Http\Responses\Controllers\Admin\Feedback\StoreResponse;
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
            'feedback' => [
                [
                    'lang' => 'ru',
                    'feeds' => Feedback::whereLang('ru')->latest()->paginate(20)->onEachSide(1),
                ],
                [
                    'lang' => 'en',
                    'feeds' => Feedback::whereLang('en')->latest()->paginate(20)->onEachSide(1),
                ],
            ],
        ]);
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
