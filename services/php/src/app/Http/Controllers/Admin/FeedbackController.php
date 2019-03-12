<?php

namespace App\Http\Controllers\Admin;

use App\Models\Feedback;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Responses\Controllers\Admin\Feedback\IndexResponse;
use App\Repos\FeedbackRepo;

class FeedbackController extends Controller
{
    /**
     * @var \App\Repos\FeedbackRepo
     */
    private $repo;

    /**
     * @param \App\Repos\FeedbackRepo $repo
     * @return void
     */
    public function __construct(FeedbackRepo $repo)
    {
        $this->middleware('admin');
        $this->repo = $repo;
    }

    /**
     * Show all reports and feedback
     * Mark user as he saw these messages
     *
     * @return \App\Http\Responses\Controllers\Admin\Feedback\IndexResponse
     */
    public function index(): IndexResponse
    {
        return new IndexResponse($this->repo);
    }

    /**
     * Display single feedback message
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show(int $id): View
    {
        return view('admin.feedback.show', [
            'feedback' => $this->repo->find($id)
        ]);
    }

    /**
     * Remove feedback message from database
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->repo->find($id)->delete();

        cache()->forget('feedback_notif');

        return redirect('/admin/feedback')->withSuccess(
            trans('admin.feedback_has_been_deleted')
        );
    }
}
